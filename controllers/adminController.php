<?php
/*
main controller between the administrator interface and the database. Process all management features from the admin. 
Allows admin to manage reference (lookup) tables
And CRUD for job posting in sudo
*/
include_once '../config/database.php';
include_once '../models/jobVacancy.php';
include_once '../models/referenceTables.php';
include_once '../models/user.php';

class AdminController {
    private $job_model;
    private $lookup_model;
    private $db;
    private $base_url;

    public function __construct($db,$base_url) {
        $this->db = $db;
        $this->$base_url = $base_url;
        $this->job_model = new JobVacancy($db);
        $this->lookup_model = new lookup_model($db);
        $this->userModel = new User($db);
        
        // Security : check if admin
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') { 
            header("Location:".$this->base_url."/login.php");
            exit;
        }
    }

    public function handleRequest($action = 'dashboard') {

        switch($action) {
            case 'dashboard':
                $allJobs = $this->job_model->listAll(); 
                $totalPostings = $this->job_model->countAll();
                $employerCount = $this->userModel->countByRole('employer');
                $seekerCount = $this->userModel->countByRole('job_seeker');
                include '../view/admin/dashboard.php';
                break;

            case 'manage_jobs':
                $allJobs = $this->job_model->listAll(); 
                include '../views/admin/all_jobs.php';
                break;

            case 'delete_job':
                $this->job_model->delete($_GET['id']);
                header("Location: ?action=manage_jobs");
                break;

            case 'addRef':
                $this->updateLookup('create');
                break;
            
            case 'updateRef':
                $this->updateLookup('update');
                break;
            
            case 'deleteRef':
                $this->updateLookup('delete');
                break;

            case 'references':
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $target_table = $_POST['table'] ?? 'job_categories';
                    
                    if (!empty($_POST['new_name'])) {
                        $new_name = trim(htmlspecialchars($_POST['new_name']));
                        $this->lookup_model->addEntry($target_table, $new_name);
                        $_SESSION['flash_success'] = "Added successfully!";
                    }
                    
                    header("Location: " . $this->base_url . "/admin/references");
                    exit();
                }
                $data = [
                    'categories' => $this->lookup_model->getAllFromTable('job_categories')->fetchAll(PDO::FETCH_ASSOC),
                    'titles'     => $this->lookup_model->getAllFromTable('job_titles')->fetchAll(PDO::FETCH_ASSOC),
                    'skills'     => $this->lookup_model->getAllFromTable('skills')->fetchAll(PDO::FETCH_ASSOC),
                    'industries' => $this->lookup_model->getAllFromTable('industries')->fetchAll(PDO::FETCH_ASSOC),
                    'locations'  => $this->lookup_model->getAllFromTable('locations')->fetchAll(PDO::FETCH_ASSOC),
                    'employment' => $this->lookup_model->getAllFromTable('employment_types')->fetchAll(PDO::FETCH_ASSOC),
                    'levels'     => $this->lookup_model->getAllFromTable('job_levels')->fetchAll(PDO::FETCH_ASSOC),
                    'salary'     => $this->lookup_model->getAllFromTable('salary_ranges')->fetchAll(PDO::FETCH_ASSOC)
                ];

                include '../views/admin/references.php';
                break;
        }
    }

    public function updateLookup($action) {
        $table = $_POST['table'] ?? '';
        $name  = trim(htmlspecialchars($_POST['entry_name'] ?? ''));
        $id    = $_POST['id'] ?? null;
        $status = (isset($_POST['entry_status']) && $_POST['entry_status'] === 'active') ? 1 : 0;
    
        switch ($action) {
            case 'create':
                $this->lookup_model->addEntry($table, $name, $status);
                $_SESSION['flash'] = "Created successfully!";
                break;
    
            case 'update':
                $this->lookup_model->updateEntry($table, $id, $name, $status);
                $_SESSION['flash'] = "Updated successfully!";
                break;
    
            case 'delete':
                // Logique de vérification FK avant suppression
                $this->lookup_model->deleteEntry($table, $id);
                $_SESSION['flash'] = "Deleted successfully!";
                break;
        }
        header("Location: " . $this->base_url . "/admin/references");
        exit();
    }
}

?>