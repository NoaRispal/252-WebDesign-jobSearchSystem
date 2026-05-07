<?php
class JobseekerController {
    static public function get_countries($db) {
        return (new JobSearchQuery($db, "countries", "country_id", "country_name"))();
    }

    static public function get_categories($db) {
        return (new JobSearchQuery($db, "job_categories", "category_id", "category_name"))();
    }

    static public function get_required_skills($db) {
        return (new JobSearchQuery($db, "skills", "skill_id", "skill_name"))();
    }

    static public function get_job_types($db) {
        return (new JobSearchQuery($db, "employment_types", "emp_type_id", "type_name"))();
    }

    static public function get_job_levels($db) {
        return (new JobSearchQuery($db, "job_levels", "level_id", "level_name"))();
    }

    static public function get_work_arrangements($db) {
        return (new JobSearchQuery($db, "work_arrangements", "arrangement_id", "arrangement_name"))();
    }

    static public function get_cities($db) {
        if (!isset($_GET['country_id'])) return;
        $query = new JobSearchQuery($db, "cities", "city_id", "city_name");
        $query->where_col_has_val("country_id", $_GET['country_id']);
        return $query();
    }

    static public function get_districts($db) {
        if (!isset($_GET['city_id'])) return;
        $query = new JobSearchQuery($db, "districts", "district_id", "district_name");
        $query->where_col_has_val("city_id", $_GET['city_id']);
        return $query();
    }

    static public function get_jobs($db) {
        $params = [];

        $params['keywords'] = [];
        if (isset($_POST['keywords']) && is_array($_POST['keywords'])) {
            foreach ($_POST['keywords'] as $k) {
                $k = htmlspecialchars(trim($k));
                if ($k !== '' && !in_array($k, $params['keywords'])) $params['keywords'][] = $k;
            }
        }

        foreach(['country', 'city', 'district', 'salary_min', 'salary_max'] as $field) {
            $params[$field] = null;
            if (!isset($_POST[$field]) || $_POST[$field] === '') continue;
            $params[$field] = (int)$_POST[$field];
        }

        foreach(['category', 'skills', 'job_type', 'job_level', 'work_arrangement'] as $field) {
            $params[$field] = [];
            if (!isset($_POST[$field]) || !is_array($_POST[$field])) continue;

            foreach ($_POST[$field] as $val) {
                $val = (int)$val;
                if (!in_array($val, $params[$field])) $params[$field][] = $val;
            }
        }

        $params["sort-select"] = "latest";
        if (isset($_POST['sort-select']) && in_array($_POST['sort-select'], ["latest", "salary-asc", "salary-desc", "title-asc", "title-desc"])) {
            $params["sort-select"] = $_POST['sort-select'];
        }

        $params["page"] = 1;
        if (isset($_POST['page'])) $params["page"] = max($params["page"], (int)$_POST['page']);

        return JobSearchResults::handle($db, $params);
    }

    static public function handle_request($db, $urlParts) {
        if (!isset($urlParts[2])) return;
        if ($urlParts[2] === 'get-cities') return JobseekerController::get_cities($db);
        if ($urlParts[2] === 'get-districts') return JobseekerController::get_districts($db);
        if ($urlParts[2] === 'job-filter-form') return JobseekerController::get_jobs($db);
    }

    static public function getJobDetail($db) {
        if (!isset($_GET['id'])) return;
        return JobDetails::handle($db, $_GET['id']);
    }
}