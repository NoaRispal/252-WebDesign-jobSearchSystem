<?php
/*
Job Search Model
Handles job searching, filtering, and retrieval for job seekers
*/
class JobSearch {
    private $conn;
    private $table = 'job_vacancies';

    public function __construct($db) {
        $this->conn = $db;
    }

    public function searchJobs($filters = [], $page = null, $limit = null) {
        $query = "SELECT jv.*, 
                         jt.Title_Name,
                         jc.Category_Name,
                         e.Company_Name,
                         it.Industry_Name,
                         jl.Level_Name,
                         wa.Arrangement_Name,
                         sr.Range_Description,
                         st.Type_Name,
                         GROUP_CONCAT(DISTINCT s.Skill_Name) as Required_Skills,
                         c.City_Name,
                         co.Country_Name
                  FROM " . $this->table . " jv
                  LEFT JOIN Job_Titles jt ON jv.Title_ID = jt.Title_ID
                  LEFT JOIN Job_Categories jc ON jv.Category_ID = jc.Category_ID
                  LEFT JOIN Employers e ON jv.Employer_ID = e.Employer_ID
                  LEFT JOIN Industries it ON jv.Industry_ID = it.Industry_ID
                  LEFT JOIN Job_Levels jl ON jv.Level_ID = jl.Level_ID
                  LEFT JOIN Work_Arrangements wa ON jv.Arrangement_ID = wa.Arrangement_ID
                  LEFT JOIN Salary_Ranges sr ON jv.Salary_Range_ID = sr.Range_ID
                  LEFT JOIN Salary_Types st ON jv.Salary_Type_ID = st.Type_ID
                  LEFT JOIN Cities c ON jv.City_ID = c.City_ID
                  LEFT JOIN Countries co ON jv.Country_ID = co.Country_ID
                  LEFT JOIN Job_Vacancy_Skills jvs ON jv.Vacancy_ID = jvs.Vacancy_ID
                  LEFT JOIN Skills s ON jvs.Skill_ID = s.Skill_ID
                  WHERE jv.Is_Active = 1";

        if (!empty($filters['keyword'])) {
            $keyword = '%' . $filters['keyword'] . '%';
            $query .= " AND (jt.Title_Name LIKE ? OR jv.Job_Description LIKE ? OR e.Company_Name LIKE ?)";
        }

        if (!empty($filters['category_id'])) {
            if (is_array($filters['category_id'])) {
                $placeholders = implode(',', array_fill(0, count($filters['category_id']), '?'));
                $query .= " AND jv.Category_ID IN ($placeholders)";
            } else {
                $query .= " AND jv.Category_ID = ?";
            }
        }

        if (!empty($filters['country_id'])) {
            $query .= " AND jv.Country_ID = ?";
        }

        if (!empty($filters['city_id'])) {
            $query .= " AND jv.City_ID = ?";
        }

        if (!empty($filters['employment_type'])) {
            if (is_array($filters['employment_type'])) {
                $placeholders = implode(',', array_fill(0, count($filters['employment_type']), '?'));
                $query .= " AND jv.Emp_Type_ID IN ($placeholders)";
            } else {
                $query .= " AND jv.Emp_Type_ID = ?";
            }
        }

        if (!empty($filters['job_level'])) {
            if (is_array($filters['job_level'])) {
                $placeholders = implode(',', array_fill(0, count($filters['job_level']), '?'));
                $query .= " AND jv.Level_ID IN ($placeholders)";
            } else {
                $query .= " AND jv.Level_ID = ?";
            }
        }

        if (!empty($filters['salary_range'])) {
            $query .= " AND jv.Salary_Range_ID = ?";
        }

        if (!empty($filters['work_arrangement'])) {
            if (is_array($filters['work_arrangement'])) {
                $placeholders = implode(',', array_fill(0, count($filters['work_arrangement']), '?'));
                $query .= " AND jv.Arrangement_ID IN ($placeholders)";
            } else {
                $query .= " AND jv.Arrangement_ID = ?";
            }
        }

        if (!empty($filters['skill_ids']) && is_array($filters['skill_ids'])) {
            $placeholders = implode(',', array_fill(0, count($filters['skill_ids']), '?'));
            $query .= " AND s.Skill_ID IN ($placeholders)";
        }

        $query .= " GROUP BY jv.Vacancy_ID";

        $sort = $filters['sort'] ?? 'latest';
        switch ($sort) {
            case 'salary-asc':
                $query .= " ORDER BY sr.Range_ID ASC";
                break;
            case 'salary-desc':
                $query .= " ORDER BY sr.Range_ID DESC";
                break;
            case 'title-asc':
                $query .= " ORDER BY jt.Title_Name ASC";
                break;
            default: // latest
                $query .= " ORDER BY jv.Posting_Date DESC";
                break;
        }

        try {
            $stmt = $this->conn->prepare($query);

            $param_index = 1;

            if (!empty($filters['keyword'])) {
                $stmt->bindValue($param_index++, $keyword);
                $stmt->bindValue($param_index++, $keyword);
                $stmt->bindValue($param_index++, $keyword);
            }

            if (!empty($filters['category_id'])) {
                if (is_array($filters['category_id'])) {
                    foreach ($filters['category_id'] as $cat_id) {
                        $stmt->bindValue($param_index++, (int)$cat_id, PDO::PARAM_INT);
                    }
                } else {
                    $stmt->bindValue($param_index++, (int)$filters['category_id'], PDO::PARAM_INT);
                }
            }

            if (!empty($filters['country_id'])) {
                $stmt->bindValue($param_index++, (int)$filters['country_id'], PDO::PARAM_INT);
            }

            if (!empty($filters['city_id'])) {
                $stmt->bindValue($param_index++, (int)$filters['city_id'], PDO::PARAM_INT);
            }

            if (!empty($filters['employment_type'])) {
                if (is_array($filters['employment_type'])) {
                    foreach ($filters['employment_type'] as $emp_type) {
                        $stmt->bindValue($param_index++, (int)$emp_type, PDO::PARAM_INT);
                    }
                } else {
                    $stmt->bindValue($param_index++, (int)$filters['employment_type'], PDO::PARAM_INT);
                }
            }

            if (!empty($filters['job_level'])) {
                if (is_array($filters['job_level'])) {
                    foreach ($filters['job_level'] as $level) {
                        $stmt->bindValue($param_index++, (int)$level, PDO::PARAM_INT);
                    }
                } else {
                    $stmt->bindValue($param_index++, (int)$filters['job_level'], PDO::PARAM_INT);
                }
            }

            if (!empty($filters['salary_range'])) {
                $stmt->bindValue($param_index++, (int)$filters['salary_range'], PDO::PARAM_INT);
            }

            if (!empty($filters['work_arrangement'])) {
                if (is_array($filters['work_arrangement'])) {
                    foreach ($filters['work_arrangement'] as $arr) {
                        $stmt->bindValue($param_index++, (int)$arr, PDO::PARAM_INT);
                    }
                } else {
                    $stmt->bindValue($param_index++, (int)$filters['work_arrangement'], PDO::PARAM_INT);
                }
            }

            if (!empty($filters['skill_ids']) && is_array($filters['skill_ids'])) {
                foreach ($filters['skill_ids'] as $skill_id) {
                    $stmt->bindValue($param_index++, (int)$skill_id, PDO::PARAM_INT);
                }
            }

            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Search query error: " . $e->getMessage());
            return [];
        }
    }

    public function getJobById($vacancy_id) {
        $query = "SELECT jv.*, 
                         jt.Title_Name,
                         jc.Category_Name,
                         e.Employer_ID,
                         e.Company_Name,
                         e.Company_Description,
                         e.Website,
                         it.Industry_Name,
                         jl.Level_Name,
                         wa.Arrangement_Name,
                         sr.Range_Description,
                         st.Type_Name,
                         dl.Degree_Name,
                         c.City_Name,
                         co.Country_Name,
                         d.District_Name
                  FROM " . $this->table . " jv
                  LEFT JOIN Job_Titles jt ON jv.Title_ID = jt.Title_ID
                  LEFT JOIN Job_Categories jc ON jv.Category_ID = jc.Category_ID
                  LEFT JOIN Employers e ON jv.Employer_ID = e.Employer_ID
                  LEFT JOIN Industries it ON jv.Industry_ID = it.Industry_ID
                  LEFT JOIN Job_Levels jl ON jv.Level_ID = jl.Level_ID
                  LEFT JOIN Work_Arrangements wa ON jv.Arrangement_ID = wa.Arrangement_ID
                  LEFT JOIN Salary_Ranges sr ON jv.Salary_Range_ID = sr.Range_ID
                  LEFT JOIN Salary_Types st ON jv.Salary_Type_ID = st.Type_ID
                  LEFT JOIN Degree_Levels dl ON jv.Min_Degree_ID = dl.Degree_ID
                  LEFT JOIN Cities c ON jv.City_ID = c.City_ID
                  LEFT JOIN Countries co ON jv.Country_ID = co.Country_ID
                  LEFT JOIN Districts d ON jv.District_ID = d.District_ID
                  WHERE jv.Vacancy_ID = ? AND jv.Is_Active = 1";

        try {
            $stmt = $this->conn->prepare($query);
            $stmt->bindValue(1, $vacancy_id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Get job error: " . $e->getMessage());
            return null;
        }
    }

    public function getJobSkills($vacancy_id) {
        $query = "SELECT s.Skill_ID, s.Skill_Name, pl.Proficiency_Name
                  FROM Job_Vacancy_Skills jvs
                  LEFT JOIN Skills s ON jvs.Skill_ID = s.Skill_ID
                  LEFT JOIN Proficiency_Levels pl ON jvs.Min_Proficiency_ID = pl.Proficiency_ID
                  WHERE jvs.Vacancy_ID = ?";

        try {
            $stmt = $this->conn->prepare($query);
            $stmt->bindValue(1, $vacancy_id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Get job skills error: " . $e->getMessage());
            return [];
        }
    }

    public function getJobCategories() {
        $query = "SELECT jc.Category_ID, jc.Category_Name, COUNT(jv.Vacancy_ID) as job_count
                  FROM Job_Categories jc
                  LEFT JOIN Job_Vacancies jv ON jc.Category_ID = jv.Category_ID AND jv.Is_Active = 1
                  GROUP BY jc.Category_ID, jc.Category_Name
                  ORDER BY jc.Category_Name ASC";

        try {
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Get categories error: " . $e->getMessage());
            return [];
        }
    }

    public function getLocations() {
        $query = "SELECT DISTINCT c.Country_ID, c.Country_Name, ci.City_ID, ci.City_Name
                  FROM Countries c
                  LEFT JOIN Cities ci ON c.Country_ID = ci.Country_ID
                  LEFT JOIN Job_Vacancies jv ON ci.City_ID = jv.City_ID AND jv.Is_Active = 1
                  WHERE ci.City_ID IS NOT NULL
                  ORDER BY c.Country_Name, ci.City_Name";

        try {
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Get locations error: " . $e->getMessage());
            return [];
        }
    }

    public function getEmploymentTypes() {
        $query = "SELECT * FROM Employment_Types ORDER BY Type_Name ASC";
        try {
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Get employment types error: " . $e->getMessage());
            return [];
        }
    }

    public function getJobLevels() {
        $query = "SELECT * FROM Job_Levels ORDER BY Level_Name ASC";
        try {
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Get job levels error: " . $e->getMessage());
            return [];
        }
    }

    public function getSalaryRanges() {
        $query = "SELECT * FROM Salary_Ranges ORDER BY Range_ID ASC";
        try {
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Get salary ranges error: " . $e->getMessage());
            return [];
        }
    }

    public function getWorkArrangements() {
        $query = "SELECT * FROM Work_Arrangements ORDER BY Arrangement_Name ASC";
        try {
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Get work arrangements error: " . $e->getMessage());
            return [];
        }
    }

    public function getSkills() {
        $query = "SELECT * FROM Skills ORDER BY Skill_Name ASC";
        try {
            $stmt = $this->conn->prepare($query);
            $stmt->execute();
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Get skills error: " . $e->getMessage());
            return [];
        }
    }
}
?>