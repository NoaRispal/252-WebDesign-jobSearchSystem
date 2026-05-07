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
        $query = "SELECT * FROM job_vacancies WHERE employer_id = ? ORDER BY created_at DESC";
        $stmt = $this->db->prepare($query);
        $stmt->execute([$employer_id]);
        return $stmt;
    }

    public function getJobById($jobId) {
        $sql = "SELECT * FROM job_vacancies WHERE vacancy_id = :id LIMIT 1";
        
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
        $query = "INSERT INTO job_vacancies (
            employer_id, 
            title_id, 
            category_id, 
            district_id,
            city_id, 
            country_id, 
            industry_id, 
            emp_type_id, 
            Level_id, 
            number_of_openings,
            salary_range_id, 
            salary_type_id, 
            arrangement_id,
            benefits,
            job_description, 
            min_degree_id, 
            min_years_experience,
            is_active, 
            posting_date
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
        $sql = "INSERT INTO job_vacancy_skills (vacancy_id, skill_id, min_proficiency_id) 
                VALUES (:job_id, :skill_id, :proficiency)";
        
        $stmt = $this->db->prepare($sql);
    
        foreach ($skills as $skill) {
            $stmt->execute([
                ':job_id'      => $jobId,
                ':skill_id'    => $skill['id'], 
                ':proficiency' => $skill['proficiency_id']
            ]);
        }
    }

    public function toggleStatus($job_id, $status) {
        $new_status = 1-$status;
        $query = "UPDATE job_vacancies SET is_active = :is_act WHERE vacancy_id = :id";
        $stmt = $this->db->prepare($query);
        return $stmt->execute(['is_act' => $new_status, 'id' => $job_id]);
    }

    public function delete($jobId,$employer_id,$admin=false) {
        try {
            // For security reasons 
            // (if there is an issue on one one the following req, we don't want the other one to succeed)
            $this->db->beginTransaction(); 
            
    
            // FK Constraints
            $sqlSkills = "DELETE FROM job_vacancy_skills WHERE vacancy_id = :vac_id";
            $stmtSkills = $this->db->prepare($sqlSkills);
            $stmtSkills->execute([':vac_id' => $jobId]);
    
            // Delete Jobs
            if ($admin) {
                $sqlJob = "DELETE FROM job_vacancies WHERE vacancy_id = :job_id";
                $stmtJob = $this->db->prepare($sqlJob);
                $stmtJob->execute([
                    ':job_id' => $jobId
                ]);
            } else {
                $sqlJob = "DELETE FROM job_vacancies WHERE vacancy_id = :job_id AND employer_id = :emp_id";
                $stmtJob = $this->db->prepare($sqlJob);
                $stmtJob->execute([
                    ':job_id' => $jobId,
                    ':emp_id' => $employer_id
                ]);
            }
    
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
    
            $sql = "UPDATE job_vacancies SET 
                    title_id = :title_id, 
                    category_id = :category_id, 
                    district_id = :district_id,
                    city_id = :city_id, 
                    country_id = :country_id, 
                    industry_id = :industry_id, 
                    emp_type_id = :emp_type_id, 
                    Level_id = :level_id, 
                    number_of_openings = :number_of_openings,
                    salary_range_id = :salary_range_id, 
                    salary_type_id = :salary_type_id, 
                    arrangement_id = :arrangement_id,
                    benefits = :benefits,
                    job_description = :job_description, 
                    min_degree_id = :min_degree_id, 
                    min_years_experience = :min_years_experience
                    WHERE vacancy_id = :job_id AND employer_id = :employer_id";
    
            $stmt = $this->db->prepare($sql);
            $jobData['job_id'] = $jobId; 
            $stmt->execute($jobData);
    
            $this->db->prepare("DELETE FROM job_vacancy_skills WHERE vacancy_id = ?")
                     ->execute([$jobId]);
            if (!empty($skills)) {
                $sqlSkill = "INSERT INTO job_vacancy_skills (vacancy_id, skill_id, min_proficiency_id) 
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
                         jt.title_name,
                         jc.category_name,
                         e.company_name,
                         it.industry_name,
                         jl.Level_name,
                         wa.arrangement_name,
                         CONCAT(sr.min_salary, '-', sr.max_salary) as range_description,
                         st.type_name,
                         GROUP_CONCAT(DISTINCT s.skill_name) as required_skills,
                         c.city_name,
                         co.country_name
                  FROM job_vacancies jv
                  LEFT JOIN job_titles jt ON jv.title_id = jt.title_id
                  LEFT JOIN job_categories jc ON jv.category_id = jc.category_id
                  LEFT JOIN employers e ON jv.employer_id = e.employer_id
                  LEFT JOIN industries it ON jv.industry_id = it.industry_id
                  LEFT JOIN job_Levels jl ON jv.Level_id = jl.Level_id
                  LEFT JOIN work_arrangements wa ON jv.arrangement_id = wa.arrangement_id
                  LEFT JOIN salary_ranges sr ON jv.salary_range_id = sr.range_id
                  LEFT JOIN salary_types st ON jv.salary_type_id = st.type_id
                  LEFT JOIN cities c ON jv.city_id = c.city_id
                  LEFT JOIN countries co ON jv.country_id = co.country_id
                  LEFT JOIN job_vacancy_skills jvs ON jv.vacancy_id = jvs.vacancy_id
                  LEFT JOIN skills s ON jvs.skill_id = s.skill_id
                  GROUP BY jv.vacancy_id
                  ORDER BY jv.posting_date DESC";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function listByEmployer($id){
        $query = "SELECT jv.*, 
                        jt.title_name,
                        jc.category_name,
                        e.company_name,
                        it.industry_name,
                        jl.Level_name,
                        wa.arrangement_name,
                        CONCAT(sr.min_salary, '-', sr.max_salary) as range_description,
                        st.type_name,
                        GROUP_CONCAT(DISTINCT s.skill_name) as required_skills,
                        c.city_name,
                        co.country_name,
                        et.type_name as employment_type_name
                FROM job_vacancies jv
                LEFT JOIN job_titles jt ON jv.title_id = jt.title_id
                LEFT JOIN job_categories jc ON jv.category_id = jc.category_id
                LEFT JOIN employers e ON jv.employer_id = e.employer_id
                LEFT JOIN industries it ON jv.industry_id = it.industry_id
                LEFT JOIN job_Levels jl ON jv.Level_id = jl.Level_id
                LEFT JOIN work_arrangements wa ON jv.arrangement_id = wa.arrangement_id
                LEFT JOIN salary_ranges sr ON jv.salary_range_id = sr.range_id
                LEFT JOIN salary_types st ON jv.salary_type_id = st.type_id
                LEFT JOIN cities c ON jv.city_id = c.city_id
                LEFT JOIN countries co ON jv.country_id = co.country_id
                LEFT JOIN job_vacancy_skills jvs ON jv.vacancy_id = jvs.vacancy_id
                LEFT JOIN skills s ON jvs.skill_id = s.skill_id
                LEFT JOIN employment_types et ON jv.emp_type_id = et.emp_type_id
                WHERE jv.employer_id = :employer_id
                GROUP BY jv.vacancy_id
                ORDER BY jv.posting_date DESC";
        $stmt = $this->db->prepare($query);
        $stmt->execute(['employer_id' => $id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function countAll() {
        $query = "SELECT COUNT(*) as total FROM job_vacancies";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['total'];
    }

    public function countUsedByJobs($tableName, $idColumn, $nameColumn){
        $query = "SELECT t.$nameColumn AS feature_name, COUNT(jv.vacancy_id) AS used_by_jobs
            FROM $tableName t
            LEFT JOIN job_vacancies jv ON t.$idColumn = jv.$idColumn
            GROUP BY t.$idColumn, t.$nameColumn
            ORDER BY used_by_jobs DESC";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function countSkillsUsed() {
        $sql = "SELECT 
                    s.skill_name, 
                    COUNT(jvs.vacancy_id) AS used_by_jobs
                FROM SKILLS s
                LEFT JOIN job_vacancy_skills jvs ON s.skill_id = jvs.skill_id
                GROUP BY s.skill_id, s.skill_name
                ORDER BY used_by_jobs DESC";
    
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function countSalariesUsed() {
        $sql = "SELECT 
                    CONCAT(min_salary, '-', max_salary) AS feature_name, 
                    COUNT(jv.vacancy_id) AS used_by_jobs
                FROM salary_ranges t
                LEFT JOIN job_vacancies jv ON t.range_id = jv.salary_range_id
                GROUP BY t.range_id, t.min_salary, t.max_salary";
    
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function getRecentJobs($limit = 6) {
        $query = "SELECT jv.*, 
                         jt.title_name,
                         jc.category_name,
                         e.company_name,
                         it.industry_name,
                         jl.Level_name,
                         wa.arrangement_name,
                         CONCAT(sr.min_salary, '-', sr.max_salary) as range_description,
                         st.type_name,
                         GROUP_CONCAT(DISTINCT s.skill_name) as required_skills,
                         c.city_name,
                         co.country_name
                  FROM job_vacancies jv
                  LEFT JOIN job_titles jt ON jv.title_id = jt.title_id
                  LEFT JOIN job_categories jc ON jv.category_id = jc.category_id
                  LEFT JOIN employers e ON jv.employer_id = e.employer_id
                  LEFT JOIN industries it ON jv.industry_id = it.industry_id
                  LEFT JOIN job_Levels jl ON jv.Level_id = jl.Level_id
                  LEFT JOIN work_arrangements wa ON jv.arrangement_id = wa.arrangement_id
                  LEFT JOIN salary_ranges sr ON jv.salary_range_id = sr.range_id
                  LEFT JOIN salary_types st ON jv.salary_type_id = st.type_id
                  LEFT JOIN cities c ON jv.city_id = c.city_id
                  LEFT JOIN countries co ON jv.country_id = co.country_id
                  LEFT JOIN job_vacancy_skills jvs ON jv.vacancy_id = jvs.vacancy_id
                  LEFT JOIN skills s ON jvs.skill_id = s.skill_id
                  GROUP BY jv.vacancy_id
                  ORDER BY jv.posting_date DESC LIMIT :limit";
                
        $stmt = $this->db->prepare($query);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTotalUniqueCompanies() {
        $sql = "SELECT COUNT(DISTINCT employer_id) AS total_companies FROM job_vacancies;";
                
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return (int) $stmt->fetchColumn();
    }
}
?>