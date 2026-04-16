<?php
/*
main controller between the administrator interface and the database. Process all management features from the admin. 
Allows admin to manage reference (lookup) tables
And CRUD for job posting in sudo
*/
include_once '../config/database.php';
include_once '../models/jobVacancy.php';
include_once '../models/referenceTables.php';

class AdminController {
    private $jobModel;
    private $lookupModel;

    public function __construct() {
        $database = new Database();
        $db = $database->getConnection();
        $this->jobModel = new JobVacancy($db);
        $this->lookupModel = new LookupModel($db);
        
        // Security : check if admin
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') { 
            header("Location: /login.php");
            exit;
        }
    }

    public function handleRequest() {
        $action = $_GET['action'] ?? 'dashboard';

        switch($action) {
            case 'manage_jobs':
                $jobs = $this->jobModel->readAll(); 
                include '../views/admin/all_jobs.php';
                break;

            case 'delete_job':
                $this->jobModel->delete($_GET['id']);
                header("Location: ?action=manage_jobs");
                break;

            case 'manage_lookup':
                $targetTable = $_GET['table'] ?? 'job_categories';
                if ($_POST['new_name']) {
                    $this->lookupModel->addEntry($targetTable, $_POST['new_name']);
                }
                $items = $this->lookupModel->getAll($targetTable);
                include '../views/admin/lookup_list.php';
                break;
        }
    }
}

?>