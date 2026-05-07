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
    private $userModel;

    public function __construct($db,$base_url) {
        $this->db = $db;
        $this->base_url = $base_url;
        $this->job_model = new JobVacancy($db);
        $this->lookup_model = new LookupModel($db); 
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
                // BEFORE LOGOUT FIX: $baseUrl was not exposed to the view scope, causing undefined variable errors in sidebar links
                $baseUrl = $this->base_url;
                include '../view/admin/dashboard.php';
                break;

            case 'users':
                $data = $this->userModel->getAllUser(); 
                $baseUrl = $this->base_url;
                include '../view/admin/users.php';
                break;

            case 'addUser':
                $data = [
                    'email' => $_POST["email"],
                    'password_hash' => password_hash($_POST["password"],PASSWORD_DEFAULT),
                    'role_id' => $_POST["role_id"]
                ];
                $this->userModel->create($data);
                $_SESSION['flash'] = "Created successfully!";
                header("Location: " . $this->base_url . "/admin/users");
                break;

            case 'removeUser':
                $id = $_POST['user_id'];
                $this->userModel->delete($id);
                $_SESSION['flash'] = "Deleted successfully!";
                header("Location: " . $this->base_url . "/admin/users");
                break;

            case 'manageJob':
                $allJobs = $this->job_model->listAll(); 
                include '../views/admin/all_jobs.php';
                break;

            case 'removeJob':
                $id = $_POST['job_id'];
                $this->job_model->delete($id,1,true);
                $_SESSION['flash'] = "Deleted successfully!";
                header("Location: " . $this->base_url . "/admin/dashboard");
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
                        $_SESSION['flash'] = "Added successfully!";
                    }
                    
                    header("Location: " . $this->base_url . "/admin/references");
                    exit();
                }
                $data = [
                    'categories' => $this->lookup_model->getAllFromTable('job_categories'),
                    'titles'     => $this->lookup_model->getAllFromTable('job_titles'),
                    'skills'     => $this->lookup_model->getAllFromTable('skills'),
                    'industries' => $this->lookup_model->getAllFromTable('industries'),
                    'employment' => $this->lookup_model->getAllFromTable('employment_yypes'),
                    'levels'     => $this->lookup_model->getAllFromTable('job_levels'),
                    'salary'     => $this->lookup_model->getAllFromTable('salary_ranges')
                ];

                $counts = $this->getCount();

                $baseUrl = $this->base_url;
                include '../view/admin/references.php';
                break;
        }
    }

    public function updateLookup($action) {
        $tableName = $_POST['table'] ?? '';
        $value = $_POST['entry_name'] ?? '';
        $id = $_POST['id'] ?? null;

        switch ($action) {
            case 'create':
                $this->lookup_model->addEntry($tableName,$value);
                $_SESSION['flash'] = "Created successfully!";
                break;
    
            case 'update':
                $this->lookup_model->updateEntry($tableName, $id, $value);
                $_SESSION['flash'] = "Updated successfully!";
                break;
    
            case 'delete':
                $this->lookup_model->deleteEntry($tableName, $id);
                $_SESSION['flash'] = "Deleted successfully!";
                break;
        }
        header("Location: " . $this->base_url . "/admin/references");
        exit();
    }

    public function getCount(){
        $features = [
            'categories' => ['job_categories', 'category_id', 'category_name'],
            'titles'     => ['job_titles', 'title_id', 'title_name'],
            'industries' => ['industries', 'industry_id', 'industry_name'],
            'types'      => ['employment_types', 'emp_type_id', 'type_name'],
            'levels'     => ['job_levels', 'level_id', 'level_name'],
        ];
    
        $counts = [];
    
        foreach ($features as $key => $config) {
            $data = $this->job_model->countUsedByJobs($config[0], $config[1], $config[2]);
            
            /* 
               We change res so $counts['categories'] is like :
               [ "Finance" => 4, "Marketing" => 2, ... ]
            */
            foreach ($data as $row) {
                $counts[$key][$row['feature_name']] = $row['used_by_jobs'];
            }
        }
    
        // For Skills
        $skillData = $this->job_model->countSkillsUsed();
        foreach ($skillData as $row) {
            $counts['skills'][$row['skill_name']] = $row['used_by_jobs'];
        }
        // For salaries range
        $salaryData = $this->job_model->countSalariesUsed();
        foreach ($salaryData as $row) {
            $counts['salaries'][$row['feature_name']] = $row['used_by_jobs'];
        }

        return $counts;
    }
}

?>