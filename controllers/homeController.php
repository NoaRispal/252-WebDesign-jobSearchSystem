<?php
include_once '../config/database.php';
include_once '../models/jobVacancy.php';
include_once '../models/referenceTables.php';
include_once '../models/user.php';

class HomeController{
    private $jobModel;
    private $lookup_model;
    private $db;
    private $base_url;
    private $userModel;

    public function __construct($db,$base_url) {
        $this->db = $db;
        $this->base_url = $base_url;
        $this->jobModel = new JobVacancy($db);
        $this->lookup_model = new LookupModel($db); 
        $this->userModel = new User($db);
        
    }

    public function index() {
        $jobCount = count($this->jobModel->listAll());
        $companyCount = $this->jobModel->getTotalUniqueCompanies();
        
        $categories = $this->lookup_model->getAllFromTable("job_categories");
        $locations = $this->lookup_model->getAllFromTable("cities");
        
        $recentJobs = $this->jobModel->getRecentJobs(6);

        $baseUrl = $this->base_url;
    
        include '../view/home/index.php';
    }
}