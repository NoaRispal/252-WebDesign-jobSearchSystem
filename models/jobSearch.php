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
        $cond = "WHERE jv.Is_Active = TRUE";

        if (!empty($params['keywords'])) {
            $keywordConditions = [];
            foreach ($params['keywords'] as $keyword) {
                $keywordConditions[] = "(jt.Title_Name LIKE ? OR jv.Job_Description LIKE ?)";
                $values[] = "%$keyword%";
                $values[] = "%$keyword%";
            }
            $cond .= " AND (" . implode(" OR ", $keywordConditions) . ")";
        }

        foreach (['country' => 'Country_ID', 'city' => 'City_ID', 'district' => 'District_ID'] as $field => $col) {
            if ($params[$field]) {
                $cond .= " AND jv.$col = ?";
                $values[] = $params[$field];
            }
        }

        if ($params['salary_min'] !== null) {
            $cond .= " AND sr.Max_Salary >= ?";
            $values[] = $params['salary_min'];
        }
        if ($params['salary_max'] !== null) {
            $cond .= " AND sr.Min_Salary <= ?";
            $values[] = $params['salary_max'];
        }

        foreach (['category' => 'Category_ID', 'job_type' => 'Emp_Type_ID', 'job_level' => 'Level_ID', 'work_arrangement' => 'Arrangement_ID'] as $field => $col) {
            if (!empty($params[$field])) {
                $placeholders = implode(',', array_fill(0, count($params[$field]), '?'));
                $cond .= " AND jv.$col IN ($placeholders)";
                $values = array_merge($values, $params[$field]);
            }
        }
        
        if (!empty($params['skills'])) {
            $placeholders = implode(',', array_fill(0, count($params['skills']), '?'));
            $cond .= " AND jv.Vacancy_ID IN (
                        SELECT Vacancy_ID FROM Job_Vacancy_Skills WHERE Skill_ID IN ($placeholders)
                    )";
            $values = array_merge($values, $params['skills']);
        }

        $countsql = "SELECT COUNT(*) FROM Job_Vacancies jv
                    JOIN Job_Titles jt ON jv.Title_ID = jt.Title_ID
                    JOIN Salary_Ranges sr ON jv.Salary_Range_ID = sr.Range_ID
                    $cond";
        $stmt = $db->prepare($countsql);
        $stmt->execute($values);
        $count = $stmt->fetchColumn();

        $sql = "SELECT jv.Vacancy_ID,
                       e.Company_Name,
                       jt.Title_Name,
                       jc.Category_Name,
                       et.Type_Name,
                       c.Country_Name,
                       ci.City_Name,
                       d.District_Name,
                       sr.Min_Salary,
                       sr.Max_Salary,
                       jv.Posting_Date
                FROM Job_Vacancies jv
                JOIN Job_Titles jt ON jv.Title_ID = jt.Title_ID
                JOIN Employers e ON jv.Employer_ID = e.Employer_ID
                JOIN Job_Categories jc ON jv.Category_ID = jc.Category_ID
                JOIN Employment_Types et ON jv.Emp_Type_ID = et.Emp_Type_ID
                JOIN Salary_Ranges sr ON jv.Salary_Range_ID = sr.Range_ID
                JOIN Countries c ON jv.Country_ID = c.Country_ID
                JOIN Cities ci  ON jv.City_ID = ci.City_ID
                LEFT JOIN Districts d ON jv.District_ID = d.District_ID
                $cond";

        $sortMap = [
            'latest'      => 'jv.Posting_Date DESC',
            'salary-asc'  => 'sr.Min_Salary ASC',
            'salary-desc' => 'sr.Max_Salary DESC',
            'title-asc'   => 'jt.Title_Name ASC',
            'title-desc'  => 'jt.Title_Name DESC'
        ];
        $sort = $sortMap[$params['sort-select']] ?? 'jv.Posting_Date DESC';
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
        $sql = "SELECT jv.Posting_Date,
                       jt.Title_Name,
                       e.Company_Name,
                       jc.Category_Name,
                       et.Type_Name,
                       sr.Min_Salary,
                       sr.Max_Salary,
                       c.Country_Name,
                       ci.City_Name,
                       d.District_Name,
                       jv.Job_Description,
                       jv.Benefits,
                       jv.Min_Years_Experience,
                       dl.Degree_Name
                FROM Job_Vacancies jv
                JOIN Job_Titles jt ON jv.Title_ID = jt.Title_ID
                JOIN Employers e ON jv.Employer_ID = e.Employer_ID
                JOIN Job_Categories jc ON jv.Category_ID = jc.Category_ID
                JOIN Employment_Types et ON jv.Emp_Type_ID = et.Emp_Type_ID
                JOIN Salary_Ranges sr ON jv.Salary_Range_ID = sr.Range_ID
                JOIN Countries c ON jv.Country_ID = c.Country_ID
                JOIN Cities ci  ON jv.City_ID = ci.City_ID
                JOIN Degree_Levels dl ON jv.Min_Degree_ID = dl.Degree_ID
                LEFT JOIN Districts d ON jv.District_ID = d.District_ID
                WHERE jv.Vacancy_ID = ? AND jv.Is_Active = TRUE";
        $stmt = $db->prepare($sql);
        $stmt->execute([$vacancyId]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$result) return;

        $skillsSql = "SELECT s.Skill_Name, pl.Proficiency_Name
                      FROM Job_Vacancy_Skills jvs
                      JOIN Skills s ON jvs.Skill_ID = s.Skill_ID
                      JOIN Proficiency_Levels pl ON jvs.Min_Proficiency_ID = pl.Proficiency_ID
                      WHERE jvs.Vacancy_ID = ?
                      ORDER BY s.Skill_Name";
        $stmt = $db->prepare($skillsSql);
        $stmt->execute([$vacancyId]);
        $result['skills'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }
}