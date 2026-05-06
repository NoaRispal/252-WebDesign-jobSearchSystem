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

    public function getJobById($jobId) {
        $sql = "SELECT * FROM Job_Vacancies WHERE Vacancy_ID = :id LIMIT 1";
        
        try {
            $stmt = $this->db->prepare($sql);
            $stmt->execute([':id' => $jobId]);
            
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error getJobById : " . $e->getMessage());
            return null;
        }
    }

    public function create($data) {
        $query = "INSERT INTO JOB_VACANCIES (
            Employer_ID, 
            Title_ID, 
            Category_ID, 
            District_ID,
            City_ID, 
            Country_ID, 
            Industry_ID, 
            Emp_Type_ID, 
            Level_ID, 
            Number_Of_Openings,
            Salary_Range_ID, 
            Salary_Type_ID, 
            Arrangement_ID,
            Benefits,
            Job_Description, 
            Min_Degree_ID, 
            Min_Years_Experience,
            Is_Active, 
            Posting_Date
        ) VALUES (
            :employer_id, 
            :title_id, 
            :category_id, 
            :district_id,
            :city_id, 
            :country_id, 
            :industry_id, 
            :emp_type_id, 
            :level_id, 
            :number_of_openings,
            :salary_range_id, 
            :salary_type_id, 
            :arrangement_id,
            :benefits,
            :job_description, 
            :min_degree_id, 
            :min_years_experience,
            1,
            NOW()
        );";
        $stmt = $this->db->prepare($query);
        $stmt->execute($data);
        return $this->db->lastInsertId();
    }

    public function addJobSkills($jobId, $skills) {
        $sql = "INSERT INTO Job_Vacancy_Skills (Vacancy_ID, Skill_ID, Min_Proficiency_ID) 
                VALUES (:job_id, :skill_id, :proficiency)";
        
        $stmt = $this->db->prepare($sql);
    
        foreach ($skills as $skill) {
            $stmt->execute([
                ':job_id'      => $jobId,
                ':skill_id'    => $skill['name'], 
                ':proficiency' => $skill['proficiency']
            ]);
        }
    }

    public function toggleStatus($job_id, $status) {
        $new_status = 1-$status;
        $query = "UPDATE Job_Vacancies SET Is_Active = :is_act WHERE Vacancy_ID = :id";
        $stmt = $this->db->prepare($query);
        return $stmt->execute(['is_act' => $new_status, 'id' => $job_id]);
    }

    public function delete($jobId,$employer_id) {
        try {
            // For security reasons 
            // (if there is an issue on one one the following req, we don't want the other one to succeed)
            $this->db->beginTransaction(); 
            
    
            // FK Constraints
            $sqlSkills = "DELETE FROM Job_Vacancy_Skills WHERE Vacancy_ID = :vac_id";
            $stmtSkills = $this->db->prepare($sqlSkills);
            $stmtSkills->execute([':vac_id' => $jobId]);
    
            // Delete Jobs
            $sqlJob = "DELETE FROM Job_Vacancies WHERE Vacancy_ID = :job_id AND Employer_ID = :emp_id";
            $stmtJob = $this->db->prepare($sqlJob);
            $stmtJob->execute([
                ':job_id' => $jobId,
                ':emp_id' => $employer_id
            ]);
    
            $this->db->commit();
            return $stmtJob->rowCount() > 0; // true if deleted
    
        } catch (PDOException $e) {
            $this->db->rollBack();
            die("Error deleteJob : " . $e->getMessage());
            return false;
        }
    }

    public function update($jobId, $jobData, $skills) {
        try {
            $this->db->beginTransaction();
    
            $sql = "UPDATE Job_Vacancies SET 
                    Title_ID = :title_id, 
                    Category_ID = :category_id, 
                    District_ID = :district_id,
                    City_ID = :city_id, 
                    Country_ID = :country_id, 
                    Industry_ID = :industry_id, 
                    Emp_Type_ID = :emp_type_id, 
                    Level_ID = :level_id, 
                    Number_Of_Openings = :number_of_openings,
                    Salary_Range_ID = :salary_range_id, 
                    Salary_Type_ID = :salary_type_id, 
                    Arrangement_ID = :arrangement_id,
                    Benefits = :benefits,
                    Job_Description = :job_description, 
                    Min_Degree_ID = :min_degree_id, 
                    Min_Years_Experience = :min_years_experience
                    WHERE Vacancy_ID = :job_id AND Employer_ID = :employer_id";
    
            $stmt = $this->db->prepare($sql);
            $jobData['job_id'] = $jobId; 
            $stmt->execute($jobData);
    
            $this->db->prepare("DELETE FROM Job_Vacancy_Skills WHERE Vacancy_ID = ?")
                     ->execute([$jobId]);
            if (!empty($skills)) {
                $sqlSkill = "INSERT INTO Job_Vacancy_Skills (Vacancy_ID, Skill_ID, Min_Proficiency_ID) 
                             VALUES (?, ?, ?)";
                $stmtSkill = $this->db->prepare($sqlSkill);
                foreach ($skills as $s) {
                    $stmtSkill->execute([$jobId, $s['name'], $s['proficiency']]);
                }
            }
    
            $this->db->commit();
            return true;
        } catch (PDOException $e) {
            $this->db->rollBack();
            error_log("Update error: " . $e->getMessage());
            return false;
        }
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
                        CONCAT(sr.Min_Salary, '-', sr.Max_Salary) as Range_Description,
                        st.Type_Name,
                        GROUP_CONCAT(DISTINCT s.Skill_Name) as Required_Skills,
                        c.City_Name,
                        co.Country_Name,
                        et.Type_Name as Employment_Type_Name
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
                LEFT JOIN Employment_Types et ON jv.Emp_Type_ID = et.Emp_Type_ID
                WHERE jv.Employer_ID = :employer_id
                GROUP BY jv.Vacancy_ID
                ORDER BY jv.Posting_Date DESC";
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

    public function countUsedByJobs($tableName, $idColumn, $nameColumn){
        $query = "SELECT t.$nameColumn AS feature_name, COUNT(jv.Vacancy_ID) AS used_by_jobs
            FROM $tableName t
            LEFT JOIN JOB_VACANCIES jv ON t.$idColumn = jv.$idColumn
            GROUP BY t.$idColumn, t.$nameColumn
            ORDER BY used_by_jobs DESC";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function countSkillsUsed() {
        $sql = "SELECT 
                    s.Skill_Name, 
                    COUNT(jvs.Vacancy_ID) AS used_by_jobs
                FROM SKILLS s
                LEFT JOIN JOB_VACANCY_SKILLS jvs ON s.Skill_ID = jvs.Skill_ID
                GROUP BY s.Skill_ID, s.Skill_Name
                ORDER BY used_by_jobs DESC";
    
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function countSalariesUsed() {
        $sql = "SELECT 
                    CONCAT(Min_Salary, '-', Max_Salary) AS feature_name, 
                    COUNT(jv.Vacancy_ID) AS used_by_jobs
                FROM SALARY_RANGES t
                LEFT JOIN JOB_VACANCIES jv ON t.Range_ID = jv.Salary_Range_ID
                GROUP BY t.Range_ID, t.Min_Salary, t.Max_Salary";
    
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }
}
?>