<?php
class JobSearchQuery {
    private $db;
    private string $table;
    private string $idCol;
    private string $valCol;
    private array $conditions = [];
    private array $params = [];

    public function __construct($db, $table, $idCol, $valCol) {
        $this->db = $db;
        $this->table = $table;
        $this->idCol = $idCol;
        $this->valCol = $valCol;
    }

    public function where_col_has_val($whereCol, $whereVal): self {
        $this->conditions[] = "$whereCol = ?";
        $this->params[] = $whereVal;
        return $this;
    }

    public function __invoke() {
        $sql = "SELECT {$this->idCol} AS id, {$this->valCol} AS value FROM {$this->table}";
        if ($this->conditions) $sql .= " WHERE ".implode(" AND ", $this->conditions);
        $sql .= " ORDER BY value";

        $stmt = $this->db->prepare($sql);
        $stmt->execute($this->params);
        return $stmt->fetchAll(PDO::FETCH_NUM);
    }
}

class JobSearchResults {
    public static function handle($db, $params) {
        $values = [];
        $cond = "WHERE jv.is_active = TRUE";

        if (!empty($params['keywords'])) {
            $keywordConditions = [];
            foreach ($params['keywords'] as $keyword) {
                $keywordConditions[] = "(LOWER(jt.title_name) LIKE ? OR LOWER(jv.job_description) LIKE ?)";
                $values[] = "%$keyword%";
                $values[] = "%$keyword%";
            }
            $cond .= " AND (" . implode(" OR ", $keywordConditions) . ")";
        }

        foreach (['country' => 'country_id', 'city' => 'city_id', 'district' => 'district_id'] as $field => $col) {
            if ($params[$field]) {
                $cond .= " AND jv.$col = ?";
                $values[] = $params[$field];
            }
        }

        if ($params['salary_min'] !== null) {
            $cond .= " AND sr.max_salary >= ?";
            $values[] = $params['salary_min'];
        }
        if ($params['salary_max'] !== null) {
            $cond .= " AND sr.min_salary <= ?";
            $values[] = $params['salary_max'];
        }

        foreach (['category' => 'category_id', 'job_type' => 'emp_type_id', 'job_level' => 'level_id', 'work_arrangement' => 'Arrangement_id'] as $field => $col) {
            if (!empty($params[$field])) {
                $placeholders = implode(',', array_fill(0, count($params[$field]), '?'));
                $cond .= " AND jv.$col IN ($placeholders)";
                $values = array_merge($values, $params[$field]);
            }
        }
        
        if (!empty($params['skills'])) {
            $placeholders = implode(',', array_fill(0, count($params['skills']), '?'));
            $cond .= " AND jv.vacancy_id IN (
                        SELECT vacancy_id FROM job_vacancy_skills WHERE skill_id IN ($placeholders)
                    )";
            $values = array_merge($values, $params['skills']);
        }

        $countsql = "SELECT COUNT(*) FROM job_vacancies jv
                    JOIN job_titles jt ON jv.title_id = jt.title_id
                    JOIN salary_ranges sr ON jv.salary_range_id = sr.range_id
                    $cond";
        $stmt = $db->prepare($countsql);
        $stmt->execute($values);
        $count = $stmt->fetchColumn();

        $sql = "SELECT jv.vacancy_id,
                       e.company_name,
                       jt.title_name,
                       jc.category_name,
                       et.type_name,
                       c.country_name,
                       ci.city_name,
                       d.district_name,
                       sr.min_salary,
                       sr.max_salary,
                       jv.posting_date
                FROM job_vacancies jv
                JOIN job_titles jt ON jv.title_id = jt.title_id
                JOIN employers e ON jv.employer_id = e.employer_id
                JOIN job_categories jc ON jv.category_id = jc.category_id
                JOIN employment_types et ON jv.emp_type_id = et.emp_type_id
                JOIN salary_ranges sr ON jv.salary_range_id = sr.range_id
                JOIN countries c ON jv.country_id = c.country_id
                JOIN cities ci  ON jv.city_id = ci.city_id
                LEFT JOIN districts d ON jv.district_id = d.district_id
                $cond";

        $sortMap = [
            'latest'      => 'jv.posting_date DESC',
            'salary-asc'  => 'sr.min_salary ASC',
            'salary-desc' => 'sr.max_salary DESC',
            'title-asc'   => 'jt.title_name ASC',
            'title-desc'  => 'jt.title_name DESC'
        ];
        $sort = $sortMap[$params['sort-select']] ?? 'jv.posting_date DESC';
        $sql .= " ORDER BY $sort";

        $page = max(1, $params['page']);
        $perPage = 6;
        $offset = ($page - 1) * $perPage;
        $sql .= " LIMIT ? OFFSET ?";
        $values[] = $perPage;
        $values[] = $offset;

        $stmt = $db->prepare($sql);
        $stmt->execute($values);
        $jobs = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return [
            'jobs' => $jobs,
            'total' => $count,
            'page' => $page,
            'numPage' => ceil($count / $perPage)
        ];
    }
}

class JobDetails {
    public static function handle($db, $vacancyId) {
        $sql = "SELECT jv.posting_date,
                       jv.vacancy_id,
                       jt.title_name,
                       e.company_name,
                       jc.category_name,
                       et.type_name,
                       sr.min_salary,
                       sr.max_salary,
                       c.country_name,
                       ci.city_name,
                       d.district_name,
                       jv.job_description,
                       jv.benefits,
                       jv.min_years_experience,
                       dl.degree_name
                FROM job_vacancies jv
                JOIN job_titles jt ON jv.title_id = jt.title_id
                JOIN employers e ON jv.employer_id = e.employer_id
                JOIN job_categories jc ON jv.category_id = jc.category_id
                JOIN employment_types et ON jv.emp_type_id = et.emp_type_id
                JOIN salary_ranges sr ON jv.salary_range_id = sr.range_id
                JOIN countries c ON jv.country_id = c.country_id
                JOIN cities ci  ON jv.city_id = ci.city_id
                JOIN degree_levels dl ON jv.min_degree_id = dl.degree_id
                LEFT JOIN districts d ON jv.district_id = d.district_id
                WHERE jv.vacancy_id = ? AND jv.is_active = TRUE";
        $stmt = $db->prepare($sql);
        $stmt->execute([$vacancyId]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$result) return;

        $skillsSql = "SELECT s.skill_name, pl.proficiency_name
                      FROM job_vacancy_skills jvs
                      JOIN skills s ON jvs.skill_id = s.skill_id
                      JOIN proficiency_levels pl ON jvs.min_proficiency_id = pl.proficiency_id
                      WHERE jvs.vacancy_id = ?
                      ORDER BY s.skill_name";
        $stmt = $db->prepare($skillsSql);
        $stmt->execute([$vacancyId]);
        $result['skills'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
}