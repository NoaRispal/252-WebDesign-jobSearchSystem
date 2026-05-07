<?php
/*
Employer Controller -> between the Employer UI and the JobVacancy model
Handle CRUD 
And toggling the status of their own job postings
*/
include_once '../config/database.php';
include_once '../models/jobVacancy.php';
include_once '../models/referenceTables.php';
include_once '../models/user.php';

class EmployerController {
    private $jobModel;
    private $lookup_model;
    private $db;
    private $base_url;
    private $userModel;

    public function __construct($db,$base_url) {
        $this->db = $db;
        $this->jobModel = new JobVacancy($db);
        $this->userModel = new User($db);
        $this->lookup_model = new LookupModel($db); 
        $this->base_url = $base_url;
        
        // Security : check if employer
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'employer') { 
            header("Location:".$this->base_url."/login.php");
            exit;
        }
    }

    public function handleRequest($action) {
        $user_id = $_SESSION['user_id'];

        switch($action) {
            case 'dashboard':
                $user = $this->userModel->getUserDataById($user_id);
                $employer = $this->userModel->getEmployerDataById($user_id);
                $all_jobs = $this->jobModel->listByEmployer($employer["employer_id"]);
                $baseUrl = $this->base_url;
                include '../view/employer/dashboard.php';
                break;
            case 'job-form':
                $job_id = $_GET['job_id_edit'] ?? null;
                $job = null;
                if ($job_id) {
                    $job = $this->jobModel->getJobById($job_id); 
                }

                $data = [
                    'categories' => $this->lookup_model->getAllFromTable('job_categories'),
                    'titles'     => $this->lookup_model->getAllFromTable('job_titles'),
                    'skills'     => $this->lookup_model->getAllFromTable('skills'),
                    'industries' => $this->lookup_model->getAllFromTable('industries'),
                    'cities'  => $this->lookup_model->getAllFromTable('cities'),
                    'countries'  => $this->lookup_model->getAllFromTable('countries'),
                    'employment' => $this->lookup_model->getAllFromTable('employment_types'),
                    'levels'     => $this->lookup_model->getAllFromTable('job_levels'),
                    'salary'     => $this->lookup_model->getAllFromTable('salary_ranges'),
                    'salary_types'     => $this->lookup_model->getAllFromTable('Salary_Types'),
                    'districts'     => $this->lookup_model->getAllFromTable('districts'),
                    'arrangement'     => $this->lookup_model->getAllFromTable('Work_Arrangements'),
                    'proficiency'     => $this->lookup_model->getAllFromTable('proficiency_levels'),
                    'degrees'     => $this->lookup_model->getAllFromTable('degree_levels'),

                ];
                $user = $this->userModel->getUserDataByID($user_id);
                $baseUrl = $this->base_url;
                include '../view/employer/job_form.php';
                break;
            case 'create':
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $jobId = $_POST['job_id'] ?? null;

                    $jobData = [
                        'employer_id'            => $this->userModel->getEmployerDataById($_SESSION['user_id'])['employer_id'],
                        'title_id'               => $_POST['job_title'],
                        'category_id'            => $_POST['job_category'],
                        'district_id'            => $_POST['district'],
                        'city_id'                => $_POST['city'],
                        'country_id'             => $_POST['country'],
                        'industry_id'            => $_POST['industry'],
                        'emp_type_id'            => $_POST['employment_type'],
                        'level_id'               => $_POST['job_level'],
                        'number_of_openings'     => $_POST['num_openings'] ?? 1,
                        'salary_range_id'        => $_POST['salary_range'],
                        'salary_type_id'         => $_POST['salary_type'],
                        'arrangement_id'         => $_POST['work_arrangement'],
                        'benefits'               => $_POST['benefits'],
                        'job_description'        => $_POST['job_description'],
                        'min_degree_id'          => $_POST['min_degree'],
                        'min_years_experience'  => $_POST['min_experience'],
                    ];
                    if ($jobId) {
                        $success = $this->jobModel->update($jobId, $jobData, $_POST['skills'] ?? []);
                        if ($success) $_SESSION['flash'] = "Job edited successfully!";
                        header("Location: " . $this->base_url . "/employer/dashboard");
                        exit();
                    }
                    else {
                        $vacancy_id = $this->jobModel->create($jobData); // return the id from the new jobs
                        // Now we link skills to this job
                        if ($vacancy_id) {
                            if (!empty($_POST['skills']) && is_array($_POST['skills'])) {
                                $this->jobModel->addJobSkills($vacancy_id, $_POST['skills']);
                            }
                            $_SESSION['flash'] = "Job posted successfully!";
                            header("Location: " . $this->base_url . "/employer/dashboard");
                            exit();
                        } else {
                            $error = "Failed to create job.";
                            $_SESSION['flash'] = $error;
                            header("Location: " . $this->base_url . "/employer/dashboard");
                            exit();
                        }
                    }
                }
                break;

            case 'delete':
                $employer_id = $this->userModel->getEmployerDataById($_SESSION['user_id'])['employer_id'];
                $success = $this->jobModel->delete($_POST['job_id'],$employer_id);
                $_SESSION['flash'] = $success ? "Job deleted successfully!" : "Error : The job has not been deleted.";
                header("Location: " . $this->base_url . "/employer/dashboard");
                exit();
                break;

            case 'toggle':
                $this->jobModel->toggleStatus($_POST['job_id'],$_POST['status']);
                $_SESSION['flash'] = "Job status changed successfully!";
                header("Location: " . $this->base_url . "/employer/dashboard");
                exit();
                break;
        }
    }
}
?>