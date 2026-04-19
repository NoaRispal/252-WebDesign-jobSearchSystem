<?php
public function searchJobs() {
    $filters = [];

    // Build filters from GET parameters
    if (isset($_GET['q']) && !empty($_GET['q'])) {
        $filters['keyword'] = trim($_GET['q']);
    }

    if (isset($_GET['category']) && is_array($_GET['category'])) {
        $filters['category_id'] = array_map('intval', $_GET['category']);
    } elseif (isset($_GET['category']) && !empty($_GET['category'])) {
        $filters['category_id'] = (int)$_GET['category'];
    }

    if (isset($_GET['country']) && !empty($_GET['country'])) {
        $filters['country_id'] = (int)$_GET['country'];
    }

    if (isset($_GET['city']) && !empty($_GET['city'])) {
        $filters['city_id'] = (int)$_GET['city'];
    }

    if (isset($_GET['job_type']) && is_array($_GET['job_type'])) {
        $filters['employment_type'] = array_map('intval', $_GET['job_type']);
    } elseif (isset($_GET['job_type']) && !empty($_GET['job_type'])) {
        $filters['employment_type'] = (int)$_GET['job_type'];
    }

    if (isset($_GET['job_level']) && is_array($_GET['job_level'])) {
        $filters['job_level'] = array_map('intval', $_GET['job_level']);
    } elseif (isset($_GET['job_level']) && !empty($_GET['job_level'])) {
        $filters['job_level'] = (int)$_GET['job_level'];
    }

    if (isset($_GET['salary_range']) && !empty($_GET['salary_range'])) {
        $filters['salary_range'] = (int)$_GET['salary_range'];
    }

    if (isset($_GET['work_arrangement']) && is_array($_GET['work_arrangement'])) {
        $filters['work_arrangement'] = array_map('intval', $_GET['work_arrangement']);
    } elseif (isset($_GET['work_arrangement']) && !empty($_GET['work_arrangement'])) {
        $filters['work_arrangement'] = (int)$_GET['work_arrangement'];
    }

    if (isset($_GET['skills']) && is_array($_GET['skills'])) {
        $filters['skill_ids'] = array_map('intval', $_GET['skills']);
    }

    $filters['sort'] = isset($_GET['sort']) && !empty($_GET['sort'])
        ? trim($_GET['sort'])
        : 'latest';

    $jobs = $this->jobSearch->searchJobs($filters);

    return [
        'success' => true,
        'jobs' => $jobs,
        'totalJobs' => count($jobs),
        'filters' => $filters
    ];
}