<?php
/*
Employer Controller -> between the Employer UI and the JobVacancy model
Handle CRUD 
And toggling the status of their own job postings
*/
include_once '../config/database.php';
include_once '../models/jobVacancy.php';

class EmployerController {
    private $jobModel;
    private $db;
    private $base_url;

    public function __construct($db,$base_url) {
        $this->db = $db;
        $this->jobModel = new JobVacancy($db);
        $this->$base_url = $base_url;
        
        // Security : check if employer
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'employer') { 
            header("Location:".$this->base_url."/login.php");
            exit;
        }
    }

    public function listJobs() {
        $employer_id = $_SESSION['user_id'];
        return $this->jobModel->readByEmployer($employer_id);
    }

    public function handleRequest() {
        $action = $_GET['action'] ?? 'dashboard';

        switch($action) {
            case 'dashboard':
                $all_jobs = $this->listJobs();
                include '../views/employer/dashboard.php';
            case 'create':
                if ($_POST) $this->jobModel->create($_POST);
                include '../views/employer/create.php';
                break;
            case 'delete':
                $this->jobModel->delete($_GET['id']);
                header("Location: dashboard.php");
                break;
            case 'toggle':
                $this->jobModel->toggleStatus($_GET['id'], $_GET['status']);
                header("Location: dashboard.php");
                break;
        }
    }
}
?>