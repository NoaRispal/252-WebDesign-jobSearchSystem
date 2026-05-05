<?php
/*
JobVacancy Model
Manages the data logic for job postings, including CRUD
It ensures that job data is correctly preprocessed (normalized,..)
*/
class JobVacancy {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function employerJobs($employer_id) {
        $query = "SELECT * FROM Job_Vacancies WHERE employer_id = ? ORDER BY created_at DESC";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$employer_id]);
        return $stmt;
    }

    public function create($data) {
        $query = "INSERT INTO Job_Vacancies 
                  SET job_title_id=:title_id, category_id=:cat_id, location_id=:loc_id, 
                      salary_range_id=:sal_id, status='active', employer_id=:emp_id";
        $stmt = $this->db->prepare($query);
        return $stmt->execute();
    }

    public function toggleStatus($job_id, $status) {
        $query = "UPDATE Job_Vacancies SET status = :status WHERE id = :id";
        $stmt = $this->db->prepare($query);
        return $stmt->execute(['status' => $status, 'id' => $job_id]);
    }

    public function delete($id) {
        $query = "DELETE FROM Job_Vacancies WHERE id = ?";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([$id]);
    }

    public function listAll(){
        $query = "SELECT jv.*, 
                         jt.Title_Name,
                         jc.Category_Name,
                         e.Company_Name,
                         it.Industry_Name,
                         jl.Level_Name,
                         wa.Arrangement_Name,
                         CONCAT(sr.Min_Salary, '-', sr.Max_Salary) as Range_Description,
                         st.Type_Name,
                         GROUP_CONCAT(DISTINCT s.Skill_Name) as Required_Skills,
                         c.City_Name,
                         co.Country_Name
                  FROM Job_Vacancies jv
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
                  WHERE jv.Is_Active = 1
                  GROUP BY jv.Vacancy_ID
                  ORDER BY jv.Posting_Date DESC";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function listByEmployer($id){
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
              FROM job_vacancies jv
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
              WHERE jv.Employer_ID = :employer_id
              GROUP BY jv.Vacancy_ID
              ORDER BY jv.Created_At DESC";
        $stmt = $this->db->prepare($query);
        $stmt->execute(['employer_id' => $id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function countAll() {
        $query = "SELECT COUNT(*) as total FROM Job_Vacancies";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['total'];
    }
}
?>