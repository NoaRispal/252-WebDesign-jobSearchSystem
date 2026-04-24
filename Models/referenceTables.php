<?php
/*
Lookup (Reference) Model
Manage all controlled vocabularies and lookup tables (form to post)
It provides methods to fetch and manage reference data for features.
*/
class LookupModel {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getAllFromTable($table) {
        $allowed = ['job_categories', 'job_titles', 'skills', 'industries', 'locations', 'employment_types', 'job_levels', 'salary_ranges'];
        if (!in_array($table, $allowed)) return []; // Security against SQL Injection

        $query = "SELECT * FROM " . $table . " ORDER BY name ASC";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function addEntry($table, $name, $is_active) {
        $query = "INSERT INTO " . $table . " (name,is_active) VALUES (:name,:is_active)";
        $stmt = $this->db->prepare($query);
        $stmt->execute(['name' => $name,'is_active'=> $is_active]);
        return $stmt;
    }

    public function deleteEntry($table, $id) {
        // Check if Foreign Key is referenced
        $map = [
            'job_categories'   => 'category_id',
            'job_titles'       => 'job_title_id', 
            'locations'        => 'location_id',
            'industries'       => 'industry_id',
            'employment_types' => 'employment_type_id',
            'job_levels'       => 'job_level_id',
            'salary_ranges'    => 'salary_range_id'
        ];
    
        if (isset($map[$table])) {
            $column = $map[$table];
            $sql = "SELECT COUNT(*) FROM job_vacancies WHERE $column = :id";
            $stmt = $this->db->prepare($sql); 
            $stmt->execute(['id' => $id]);
            
            if ($stmt->fetchColumn() > 0) {
                return false; 
            }
        }

        if ($table === 'skills') {
            $sql = "SELECT COUNT(*) FROM job_vacancy_skills WHERE skill_id = :id";
            $stmt = $this->conn->prepare($sql);
            $stmt->execute(['id' => $id]);
            if ($stmt->fetchColumn() > 0) return false;
        }
        //
        
        $query = "DELETE FROM " . $table . " WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->execute(['id' => $id]);
        return $stmt;
    }

    public function updateEntry($table,$id,$is_active) {
        $allowed = ['job_categories', 'job_titles', 'skills', 'industries', 'locations', 'employment_types', 'job_levels', 'salary_ranges'];
        if (!in_array($table, $allowed)) return []; // Security against SQL Injection
        $query = "UPDATE " . $table . " SET name = :name, is_active=:is_active WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->execute(['name' => $name, 'is_active'=>$is_active,'id' => $id]);
        return $stmt;
    }
}

?>