<?php
/*
Employer Controller -> between the Employer UI and the JobVacancy model
Handle CRUD 
And toggling the status of their own job postings
*/
include_once '../config/database.php';
include_once '../models/jobVacancy.php';

class JobController {
    private $jobModel;

    public function __construct() {
        $database = new Database();
        $db = $database->getConnection();
        $this->jobModel = new JobVacancy($db);
        
        // Security : check if employer
        if ($_SESSION['role'] !== 'employer') {
            header("Location: /login.php");
            exit;
        }
    }

    public function listJobs() {
        $employer_id = $_SESSION['user_id'];
        return $this->jobModel->readByEmployer($employer_id);
    }

    public function handleRequest() {
        $action = $_GET['action'] ?? 'list';

        switch($action) {
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