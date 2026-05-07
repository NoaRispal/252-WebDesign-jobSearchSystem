<?php
/*
Lookup (Reference) Model
Manage all controlled vocabularies and lookup tables (form to post)
It provides methods to fetch and manage reference data for features.
*/
class LookupModel {
    private $db;

    /* BEFORE COLUMN FIX (original model assumed all tables had 'id' and 'name' columns):
       $query = "SELECT * FROM " . $table . " ORDER BY name ASC";
       $query = "INSERT INTO " . $table . " (name,is_active) VALUES (:name,:is_active)";
       $query = "UPDATE " . $table . " SET name = :name, is_active=:is_active WHERE id = :id";
       $query = "DELETE FROM " . $table . " WHERE id = :id";
    END BEFORE COLUMN FIX */

    // Column mapping: table => [id_column, name_column]
    // The actual DB schema uses table-specific column names (Category_ID, Title_name, etc.)
    private $columnMap = [
        'job_categories'   => ['category_id',  'category_name'],
        'job_titles'       => ['title_id',     'title_name'],
        'skills'           => ['skill_id',     'skill_name'],
        'industries'       => ['industry_id',  'industry_name'],
        'employment_types' => ['emp_type_id',  'type_name'],
        'job_levels'       => ['level_id',     'level_name'],
        'salary_ranges'    => ['range_id',     'CONCAT(min_salary, "-", max_salary)'],
        'salary_types'    => ['type_id',     'type_name'],
        'cities'    => ['city_id',     'city_name'],
        'countries'    => ['country_id',     'country_name'],
        'districts'    => ['district_id','district_name'],
        'work_arrangements'    => ['arrangement_id',     'arrangement_name'],
        'proficiency_levels'    => ['proficiency_id',     'proficiency_name'],
        'degree_levels'    => ['degree_id',     'degree_name'],
    ];

    public function __construct($db) {
        $this->db = $db;
    }

    public function getAllFromTable($table) {
        $table = strtolower($table);
        if (!isset($this->columnMap[$table])) return [];

        list($idCol, $nameCol) = $this->columnMap[$table];
        $query = "SELECT $idCol AS id, $nameCol AS name FROM $table ORDER BY name ASC";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addEntry($table,$value) {
        $table = strtolower($table);
        if (!isset($this->columnMap[$table])) return false;

        list($idCol, $nameCol) = $this->columnMap[$table];
        $query = "INSERT INTO $table ($nameCol) VALUES (:name)";
        $stmt = $this->db->prepare($query);
        $stmt->execute(['name' => $value]);
        return $stmt;
    }

    public function deleteEntry($table, $id) {
        $table = strtolower($table);
        if (!isset($this->columnMap[$table])) return false;

        list($idCol, $nameCol) = $this->columnMap[$table];

        // Check if Foreign Key is referenced in job_vacancies
        $fkMap = [
            'job_categories'   => 'category_id',
            'job_titles'       => 'title_id',
            'industries'       => 'industry_id',
            'employment_types' => 'employment_type_id',
            'job_levels'       => 'level_id',
            'salary_ranges'    => 'salary_range_id'
        ];
    
        if (isset($fkMap[$table])) {
            $column = $fkMap[$table];
            $sql = "SELECT COUNT(*) FROM job_vacancies WHERE $column = :id";
            $stmt = $this->db->prepare($sql); 
            $stmt->execute(['id' => $id]);
            
            if ($stmt->fetchColumn() > 0) {
                return false; 
            }
        }

        if ($table === 'skills') {
            $sql = "SELECT COUNT(*) FROM job_vacancy_skills WHERE skill_id = :id";
            $stmt = $this->db->prepare($sql);
            $stmt->execute(['id' => $id]);
            if ($stmt->fetchColumn() > 0) return false;
        }
        
        $query = "DELETE FROM $table WHERE $idCol = :id";
        $stmt = $this->db->prepare($query);
        $stmt->execute(['id' => $id]);
        return $stmt;
    }

    // BEFORE COLUMN FIX: public function updateEntry($table,$id,$is_active) {
    // BEFORE PROPERTY FIX: used $this->conn instead of $this->db
    public function updateEntry($table, $id, $name) {
        $table = strtolower($table);
        if (!isset($this->columnMap[$table])) return false;

        list($idCol, $nameCol) = $this->columnMap[$table];
        $query = "UPDATE $table SET $nameCol = :name WHERE $idCol = :id";
        $stmt = $this->db->prepare($query);
        $stmt->execute(['name' => $name, 'id' => $id]);
        return $stmt;
    }
}

?>