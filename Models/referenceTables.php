<?php
/*
Lookup (Reference) Model
Manage all controlled vocabularies and lookup tables (form to post)
It provides methods to fetch and manage reference data for features.
*/
class LookupModel {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAll($table) {
        $allowed = ['job_categories', 'job_titles', 'skills', 'industries', 'locations', 'employment_types', 'job_levels', 'salary_ranges'];
        if (!in_array($table, $allowed)) return []; // Security against SQL Injection

        $query = "SELECT * FROM " . $table . " ORDER BY name ASC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function addEntry($table, $name) {
        $query = "INSERT INTO " . $table . " (name) VALUES (:name)";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute(['name' => $name]);
    }

    public function deleteEntry($table, $id) {
        $query = "DELETE FROM " . $table . " WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute(['id' => $id]);
    }
}

?>