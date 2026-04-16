<?php
/*
JobVacancy Model
Manages the data logic for job postings, including CRUD
It ensures that job data is correctly preprocessed (normalized,..)
*/
class JobVacancy {
    private $conn;
    private $table_name = "job_vacancies";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function employerJobs($employer_id) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE employer_id = ? ORDER BY created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$employer_id]);
        return $stmt;
    }

    public function create($data) {
        $query = "INSERT INTO " . $this->table_name . " 
                  SET job_title_id=:title_id, category_id=:cat_id, location_id=:loc_id, 
                      salary_range_id=:sal_id, status='active', employer_id=:emp_id";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute();
    }

    public function toggleStatus($job_id, $status) {
        $query = "UPDATE " . $this->table_name . " SET status = :status WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute(['status' => $status, 'id' => $job_id]);
    }

    public function delete($id) {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$id]);
    }
}
?>