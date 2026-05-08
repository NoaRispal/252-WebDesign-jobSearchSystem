<?php
/*
 * Database Configuration & Connection
 *
 * Provides a reusable Database class that creates and returns a PDO connection.
 */

class Database {

    // ── Connection parameters ────────────────────────────────────────────────
    private string $host     = 'localhost';
    private string $db_name  = 'job_search_db';
    private string $username = 'root';
    //private string $password = 'root';
    private string $password = '';
    private string $charset  = 'utf8mb4';

   
    private ?PDO $conn = null;

    // ── Public interface ─────────────────────────────────────────────────────



     
    public function getConnection(): ?PDO {
        if ($this->conn !== null) {
            return $this->conn;         
        }

        $dsn = "mysql:host={$this->host};dbname={$this->db_name};charset={$this->charset}";

        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,   
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,         
            PDO::ATTR_EMULATE_PREPARES   => false,                   
        ];

        try {
            $this->conn = new PDO($dsn, $this->username, $this->password, $options);
        } catch (PDOException $e) {
            // In dev use this to debug
            die("Database connection failed (Make sure to have the right credentials): " . $e->getMessage());
            
            // error_log('Database connection failed: ' . $e->getMessage());
            $this->conn = null;
        }

        return $this->conn;
    }


    
    public function closeConnection(): void {
        $this->conn = null;
    }

    /**
     * Quick connectivity test — returns true if a connection can be established.
     *
     * @return bool
     */
    public function isConnected(): bool {
        return $this->getConnection() !== null;
    }
}
?>
