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
    // The actual DB schema uses table-specific column names (Category_ID, Title_Name, etc.)
    private $columnMap = [
        'job_categories'   => ['Category_ID',  'Category_Name'],
        'job_titles'       => ['Title_ID',     'Title_Name'],
        'skills'           => ['Skill_ID',     'Skill_Name'],
        'industries'       => ['Industry_ID',  'Industry_Name'],
        'employment_types' => ['Emp_Type_ID',  'Type_Name'],
        'job_levels'       => ['Level_ID',     'Level_Name'],
        'salary_ranges'    => ['Range_ID',     'Range_Description'],
    ];

    private $allowed = ['job_categories', 'job_titles', 'skills', 'industries', 'employment_types', 'job_levels', 'salary_ranges'];

    public function __construct($db) {
        $this->db = $db;
    }

    /**
     * Get the [id_column, name_column] pair for a given table.
     */
    private function getColumns($table) {
        return $this->columnMap[$table] ?? ['id', 'name'];
    }

    public function getAllFromTable($table) {
        if (!in_array($table, $this->allowed)) return [];

        list($idCol, $nameCol) = $this->getColumns($table);
        $query = "SELECT $idCol AS id, $nameCol AS name FROM $table ORDER BY $nameCol ASC";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function addEntry($table, $name, $is_active = 1) {
        if (!in_array($table, $this->allowed)) return false;

        list($idCol, $nameCol) = $this->getColumns($table);
        $query = "INSERT INTO $table ($nameCol) VALUES (:name)";
        $stmt = $this->db->prepare($query);
        $stmt->execute(['name' => $name]);
        return $stmt;
    }

    public function deleteEntry($table, $id) {
        if (!in_array($table, $this->allowed)) return false;

        list($idCol, $nameCol) = $this->getColumns($table);

        // BEFORE COLUMN FIX:
        // $map = [ 'job_categories' => 'category_id', 'job_titles' => 'job_title_id', ... ];
        // if (isset($map[$table])) {
        //     $column = $map[$table];
        //     $sql = "SELECT COUNT(*) FROM job_vacancies WHERE $column = :id";

        // Check if Foreign Key is referenced in job_vacancies
        $fkMap = [
            'job_categories'   => 'Category_ID',
            'job_titles'       => 'Title_ID',
            'industries'       => 'Industry_ID',
            'employment_types' => 'Employment_Type_ID',
            'job_levels'       => 'Level_ID',
            'salary_ranges'    => 'Salary_Range_ID'
        ];
    
        if (isset($fkMap[$table])) {
            $column = $fkMap[$table];
            $sql = "SELECT COUNT(*) FROM Job_Vacancies WHERE $column = :id";
            $stmt = $this->db->prepare($sql); 
            $stmt->execute(['id' => $id]);
            
            if ($stmt->fetchColumn() > 0) {
                return false; 
            }
        }

        if ($table === 'skills') {
            // BEFORE PROPERTY FIX: used $this->conn instead of $this->db
            // $sql = "SELECT COUNT(*) FROM job_vacancy_skills WHERE skill_id = :id";
            // $stmt = $this->conn->prepare($sql);
            $sql = "SELECT COUNT(*) FROM Job_Vacancy_Skills WHERE Skill_ID = :id";
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
    public function updateEntry($table, $id, $name, $is_active = 1) {
        if (!in_array($table, $this->allowed)) return false;

        list($idCol, $nameCol) = $this->getColumns($table);
        $query = "UPDATE $table SET $nameCol = :name WHERE $idCol = :id";
        $stmt = $this->db->prepare($query);
        $stmt->execute(['name' => $name, 'id' => $id]);
        return $stmt;
    }
}

?>