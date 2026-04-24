<?php
/*
Employer Controller -> between the Employer UI and the JobVacancy model
Handle CRUD 
And toggling the status of their own job postings
*/
include_once '../config/database.php';
include_once '../models/jobVacancy.php';
include_once '../models/user.php';

class EmployerController {
    private $jobModel;
    private $db;
    private $base_url;
    private $userModel;

    public function __construct($db,$base_url) {
        $this->db = $db;
        $this->jobModel = new JobVacancy($db);
        $this->userModel = new User($db);
        $this->$base_url = $base_url;
        
        // Security : check if employer
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'employer') { 
            header("Location:".$this->base_url."/login.php");
            exit;
        }
    }

    public function handleRequest() {
        $action = $_GET['action'] ?? 'dashboard';
        $employer_id = $_SESSION['user_id'];

        switch($action) {
            case 'dashboard':
                $all_jobs = $this->jobModel->readByEmployer($employer_id);
                $user_data = $this->userModel->getUserData($employer_id,'employer');
                include '../views/employer/dashboard.php';
            case 'create':
                // Case 1: form is completed and we need to verify the input and then tu update db
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $this->publish();
                }
                // Case 2: we show the empty form
                $job = null;
                $jobSkills = [];

                if (isset($_GET['id'])) {
                    $jobId = intval($_GET['id']);
                    $job = $this->jobModel->findByIdAndEmployer($jobId, $_SESSION['user_id']);
                    
                    if (!$job) {
                        header("Location: " . $this->baseUrl . "/employer/dashboard");
                        exit();
                    }
                    $jobSkills = $this->jobModel->getSkillsByJobId($jobId);
                }

                // Préparation des listes pour les menus déroulants (LookupModel)
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
                $user_data = $this->userModel->getUserData($employer_id,'employer');
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

    public function publishJob(){
        $data = $_POST;
        $data['employer_id'] = $_SESSION['user_id'];

        // Add:  Some security verification 
        
        $success = $this->jobModel->create($data);
        
        if ($success) {
            $_SESSION['flash'] = "Job published!";
            header("Location: " . $this->baseUrl . "/employer/dashboard");
            exit();
        }
    }
}
?>