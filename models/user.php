<?php
/*
User Model
Handles authentication, role management, and user-related data retrieval.
This model supports Role-Based Access Control (RBAC) as required by the system.
 */
class User {
    private $db;
    private $table_name = "users";

    // Table columns
    public $id;
    public $full_name;
    public $email;
    public $password_hash;
    public $role;

    public function __construct($db) {
        $this->db = $db;
    }

    public function findByEmail($email) {
        $query = "SELECT id, full_name, email, password_hash, role 
                  FROM " . $this->table_name . " 
                  WHERE email = :email 
                  LIMIT 1";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getUserDataById($id) {
        $query = "SELECT * 
                  FROM users
                  WHERE user_id = :id 
                  LIMIT 1";

        $stmt = $this->db->prepare($query);
        $stmt->execute([':id'=>$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getEmployerDataById($id) {
        $query = "SELECT * 
                  FROM employers
                  WHERE user_id = :id 
                  LIMIT 1";

        $stmt = $this->db->prepare($query);
        $stmt->execute([':id'=>$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Count users by their specific role
     * Used for Admin Dashboard statistics (Employers / Job Seekers)
     */
    // public function countByRole($role) {
    //     // Valid roles according to system specifications: employer, job_seeker, admin 
    //     $query = "SELECT COUNT(*) as total 
    //               FROM " . $this->table_name . " 
    //               WHERE role = :role";

    //     $stmt = $this->db->prepare($query);
    //     $stmt->bindParam(':role', $role);
    //     $stmt->execute();

    //     $row = $stmt->fetch(PDO::FETCH_ASSOC);
    //     return $row['total'] ?? 0;
    // }

    public function countByRole($role) {
        // Valid roles according to system specifications: employer, job_seeker, admin 
        $query = "SELECT COUNT(*) as total 
                  FROM " . $this->table_name . " u
                  JOIN roles r ON u.role_id = r.role_id
                  WHERE r.role_name = :role";

        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':role', $role);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['total'] ?? 0;
    }


    public function create($data) {
        $query = "INSERT INTO users
                  SET email = :email, 
                      password_hash = :password_hash, 
                      role_id = :role_id";

        $stmt = $this->db->prepare($query);

        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':password_hash', $data['password_hash']);
        $stmt->bindParam(':role_id', $data['role_id']);

        if($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function delete($id) {
        $query = "DELETE FROM users WHERE user_id = ?";
        $stmt = $this->db->prepare($query);
        return $stmt->execute([$id]);
    }

    public function getAllUser() {
        $query = "SELECT user_id, role_id, email
                FROM users";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}