-- Database creation
CREATE DATABASE IF NOT EXISTS `job_search_db` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_bin;
USE `job_search_db`;

-- 1. roles & users
CREATE TABLE roles (
    role_id INT PRIMARY KEY AUTO_INCREMENT,
    role_name VARCHAR(50) UNIQUE NOT NULL
);

CREATE TABLE users (
    user_id INT PRIMARY KEY AUTO_INCREMENT,
    role_id INT NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    password_hash VARCHAR(255) NOT NULL,
    FOREIGN KEY (role_id) REFERENCES roles(role_id)
);

-- 2. employers
CREATE TABLE employers (
    employer_id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT UNIQUE NOT NULL,
    company_name VARCHAR(255) NOT NULL,
    company_description TEXT,
    website VARCHAR(255),
    FOREIGN KEY (user_id) REFERENCES users(user_id) ON DELETE CASCADE
);

-- 3. Job Attributes (Reference Tables)
CREATE TABLE job_categories (
    category_id INT PRIMARY KEY AUTO_INCREMENT,
    category_name VARCHAR(100) UNIQUE NOT NULL
);

CREATE TABLE job_titles (
    title_id INT PRIMARY KEY AUTO_INCREMENT,
    title_name VARCHAR(100) UNIQUE NOT NULL
);

CREATE TABLE industries (
    industry_id INT PRIMARY KEY AUTO_INCREMENT,
    industry_name VARCHAR(100) UNIQUE NOT NULL
);

CREATE TABLE countries (
    country_id INT PRIMARY KEY AUTO_INCREMENT,
    country_name VARCHAR(100) UNIQUE NOT NULL
);

CREATE TABLE cities (
    city_id INT PRIMARY KEY AUTO_INCREMENT,
    country_id INT NOT NULL,
    city_name VARCHAR(100) NOT NULL,
    FOREIGN KEY (country_id) REFERENCES countries(country_id)
);

CREATE TABLE districts (
    district_id INT PRIMARY KEY AUTO_INCREMENT,
    city_id INT NOT NULL,
    district_name VARCHAR(100) NOT NULL,
    FOREIGN KEY (city_id) REFERENCES cities(city_id)
);

CREATE TABLE employment_types (
    emp_type_id INT PRIMARY KEY AUTO_INCREMENT,
    type_name VARCHAR(50) UNIQUE NOT NULL
);

CREATE TABLE job_levels (
    level_id INT PRIMARY KEY AUTO_INCREMENT,
    level_name VARCHAR(50) UNIQUE NOT NULL
);

CREATE TABLE work_arrangements (
    arrangement_id INT PRIMARY KEY AUTO_INCREMENT,
    arrangement_name VARCHAR(50) UNIQUE NOT NULL
);

CREATE TABLE salary_ranges (
    range_id INT PRIMARY KEY AUTO_INCREMENT,

    -- TODO: Add CHECK constraint (min_salary <= min_salary <= max_salary <= max_salary)
    min_salary INT NOT NULL,
    max_salary INT NOT NULL
);

CREATE TABLE salary_types (
    type_id INT PRIMARY KEY AUTO_INCREMENT,
    type_name VARCHAR(50) UNIQUE NOT NULL
);

CREATE TABLE degree_levels (
    degree_id INT PRIMARY KEY AUTO_INCREMENT,
    degree_name VARCHAR(100) UNIQUE NOT NULL
);

CREATE TABLE skills (
    skill_id INT PRIMARY KEY AUTO_INCREMENT,
    skill_name VARCHAR(100) UNIQUE NOT NULL
);

CREATE TABLE proficiency_levels (
    proficiency_id INT PRIMARY KEY AUTO_INCREMENT,
    proficiency_name VARCHAR(50) UNIQUE NOT NULL
);

-- 4. Job Vacancies
CREATE TABLE job_vacancies (
    vacancy_id INT PRIMARY KEY AUTO_INCREMENT,
    employer_id INT NOT NULL,
    title_id INT NOT NULL,
    category_id INT NOT NULL,
    emp_type_id INT NOT NULL,
    industry_id INT NOT NULL,
    level_id INT NOT NULL,
    number_of_openings INT NOT NULL,
    country_id INT NOT NULL,
    city_id INT NOT NULL,
    district_id INT,
    arrangement_id INT NOT NULL,
    salary_range_id INT NOT NULL,
    salary_type_id INT NOT NULL,
    benefits TEXT,
    job_description TEXT NOT NULL,
    min_degree_id INT NOT NULL,
    min_years_experience INT NOT NULL,
    posting_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    is_active BOOLEAN DEFAULT TRUE,
    FOREIGN KEY (employer_id) REFERENCES employers(employer_id),
    FOREIGN KEY (title_id) REFERENCES job_titles(title_id),
    FOREIGN KEY (category_id) REFERENCES job_categories(category_id),
    FOREIGN KEY (emp_type_id) REFERENCES employment_types(emp_type_id),
    FOREIGN KEY (industry_id) REFERENCES industries(industry_id),
    FOREIGN KEY (level_id) REFERENCES job_levels(level_id),
    FOREIGN KEY (country_id) REFERENCES countries(country_id),
    FOREIGN KEY (city_id) REFERENCES cities(city_id),
    FOREIGN KEY (district_id) REFERENCES districts(district_id),
    FOREIGN KEY (arrangement_id) REFERENCES work_arrangements(arrangement_id),
    FOREIGN KEY (salary_range_id) REFERENCES salary_ranges(range_id),
    FOREIGN KEY (salary_type_id) REFERENCES salary_types(type_id),
    FOREIGN KEY (min_degree_id) REFERENCES degree_levels(degree_id)
);

CREATE TABLE job_vacancy_skills (
    vacancy_id INT NOT NULL,
    skill_id INT NOT NULL,
    min_proficiency_id INT NOT NULL,
    PRIMARY KEY (vacancy_id, skill_id),
    FOREIGN KEY (vacancy_id) REFERENCES job_vacancies(vacancy_id) ON DELETE CASCADE,
    FOREIGN KEY (skill_id) REFERENCES skills(skill_id),
    FOREIGN KEY (min_proficiency_id) REFERENCES proficiency_levels(proficiency_id)
);

-- ==========================================
-- TEST DATA (5 entries per table)
-- ==========================================

-- 1. roles
INSERT INTO roles (role_name) VALUES 
('admin'), ('employer'), ('job_seeker'), ('moderator'), ('guest');

-- 2. users
-- Passwords are all 'password123'
INSERT INTO users (role_id, email, password_hash) VALUES 
(1, 'admin@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'),
(2, 'employer1@tech.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'),
(2, 'employer2@creative.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'),
(3, 'seeker1@gmail.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'),
(3, 'seeker2@yahoo.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi');

-- 3. employers
INSERT INTO employers (user_id, company_name, company_description, website) VALUES 
(2, 'Global Tech Solutions', 'Leading provider of software services.', 'https://globaltech.com'),
(3, 'Creative Minds Agency', 'A boutique marketing and design firm.', 'https://creativeminds.io'),
(1, 'System Admin Group', 'Managing the internal infrastructure.', 'https://admin.internal'),
(4, 'Data Analytics Co', 'Specializing in big data and AI.', 'https://dataco.com'),
(5, 'Future Builders', 'Construction and urban development.', 'https://futurebuilders.com');

-- 4. Job Categories
INSERT INTO job_categories (category_name) VALUES 
('IT & Software'), ('Marketing'), ('Engineering'), ('Finance'), ('Healthcare'),
('Education'), ('Sales'), ('Customer Service'), ('Design'), ('Human Resources');

-- 5. Job Titles
INSERT INTO job_titles (title_name) VALUES 
('Senior PHP Developer'), ('Marketing Manager'), ('Project Engineer'), ('Financial Analyst'), ('Nurse Practitioner');

-- 6. industries
INSERT INTO industries (industry_name) VALUES 
('Information Technology'), ('Advertising'), ('Construction'), ('Banking'), ('Medical');

-- 7. countries
INSERT INTO countries (country_name) VALUES 
('Thailand'), ('USA'), ('United Kingdom'), ('Singapore'), ('Japan');

-- 8. cities
INSERT INTO cities (country_id, city_name) VALUES 
(1, 'Bangkok'), (2, 'New York'), (3, 'London'), (4, 'Singapore City'), (5, 'Tokyo'),
(1, 'Chiang Mai'), (2, 'Los Angeles'), (3, 'Manchester'), (4, 'Jurong'), (5, 'Osaka'),
(1, 'Phuket'), (2, 'Chicago'), (3, 'Bristol'), (4, 'Tampines'), (5, 'Kyoto');

-- 9. districts
INSERT INTO districts (city_id, district_name) VALUES 
(1, 'Sukhumvit'), (2, 'Manhattan'), (3, 'Westminster'), (4, 'Jurong East'), (5, 'Shibuya'),
(6, 'Silom'), (7, 'Brooklyn'), (8, 'Camden'), (9, 'Tampines'), (10, 'Shinjuku'),
(11, 'Chatuchak'), (12, 'Queens'), (13, 'Islington'), (14, 'Yishun'), (15, 'Ginza');

-- 10. Employment Types
INSERT INTO employment_types (type_name) VALUES 
('Full-time'), ('Part-time'), ('Contract'), ('Internship'), ('Freelance');

-- 11. Job Levels
INSERT INTO job_levels (level_name) VALUES 
('Entry Level'), ('Junior'), ('Mid-Level'), ('Senior'), ('Executive');

-- 12. Work Arrangements
INSERT INTO work_arrangements (arrangement_name) VALUES 
('On-site'), ('Remote'), ('Hybrid'), ('Flexible'), ('Traveling');

-- 13. Salary Ranges
INSERT INTO salary_ranges (min_salary, max_salary) VALUES 
(20000, 30000), (40000, 60000), (70000, 100000), (120000, 150000);

-- 14. salary_types
INSERT INTO salary_types (type_name) VALUES 
('Monthly'), ('Hourly'), ('Yearly'), ('Per Project'), ('Commission');

-- 15. Degree Levels
INSERT INTO degree_levels (degree_name) VALUES 
('Bachelor Degree'), ('Master Degree'), ('Doctorate'), ('High School'), ('None');

-- 16. skills
INSERT INTO skills (skill_name) VALUES 
('PHP'), ('SQL'), ('JavaScript'), ('Project Management'), ('Data Analysis'),
('Embedded Systems'), ('Digital Marketing'), ('Civil Engineering'), ('Financial Modeling'), ('Patient Care');

-- 17. Proficiency Levels
INSERT INTO proficiency_levels (proficiency_name) VALUES 
('Beginner'), ('Intermediate'), ('Advanced'), ('Expert'), ('Native');

-- 18. Job Vacancies
INSERT INTO job_vacancies (
    employer_id, title_id, category_id, emp_type_id, industry_id, level_id, 
    number_of_openings, country_id, city_id, district_id, arrangement_id, 
    salary_range_id, salary_type_id, benefits, job_description, min_degree_id, 
    min_years_experience
) VALUES 
(1, 1, 1, 1, 1, 4, 2, 1, 1, 1, 3, 3, 1, 'Medical insurance, Free lunch', 'We are looking for a Senior PHP Developer...', 1, 5),
(2, 2, 2, 1, 2, 3, 1, 2, 2, 2, 2, 2, 1, 'Remote work, Annual bonus', 'Seeking a Marketing Manager for our NYC office.', 1, 3),
(3, 3, 3, 1, 3, 3, 3, 3, 3, 3, 1, 3, 1, 'On-site housing', 'Project Engineer needed for London bridge project.', 1, 4),
(4, 4, 4, 1, 4, 2, 1, 4, 4, 4, 3, 2, 1, 'Stock options', 'Junior Financial Analyst for Singapore HQ.', 1, 2),
(5, 5, 5, 1, 5, 4, 5, 5, 5, 5, 1, 4, 1, 'Pension scheme', 'Experienced Nurse for Tokyo International Hospital.', 1, 6);

-- 19. Job Vacancy skills
INSERT INTO job_vacancy_skills (vacancy_id, skill_id, min_proficiency_id) VALUES 
(1, 1, 4), (1, 2, 3), (2, 4, 3), (4, 5, 2), (5, 5, 4);

-- Additional Job Vacancies (15 more entries)
INSERT INTO job_vacancies (
    employer_id, title_id, category_id, emp_type_id, industry_id, level_id, 
    number_of_openings, country_id, city_id, district_id, arrangement_id, 
    salary_range_id, salary_type_id, benefits, job_description, min_degree_id, 
    min_years_experience
) VALUES 
(1, 1, 1, 1, 1, 3, 3, 1, 1, 1, 1, 3, 1, 'Health insurance, Stock options', 'Mid-level PHP Developer with Laravel experience.', 1, 3),
(2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 2, 1, 'Remote work, Flexible hours', 'Junior Marketing Specialist for social media campaigns.', 1, 1),
(3, 3, 3, 1, 3, 4, 1, 3, 3, 3, 3, 3, 1, 'On-site housing, Transportation', 'Senior Project Engineer for infrastructure projects.', 1, 7),
(4, 4, 4, 3, 4, 2, 2, 4, 4, 4, 1, 2, 1, 'Performance bonus, Mentorship', 'Intermediate Financial Analyst for risk assessment.', 1, 2),
(5, 5, 5, 1, 5, 3, 3, 5, 5, 5, 2, 4, 1, 'Medical coverage, Professional development', 'Experienced Nurse Practitioner for Tokyo medical center.', 1, 5),
(1, 1, 1, 2, 1, 1, 1, 1, 6, 6, 2, 1, 1, 'Learning budget, Free tools', 'Junior PHP Developer for web applications.', 1, 0),
(2, 2, 2, 1, 2, 3, 1, 2, 7, 7, 3, 3, 1, 'Annual raise, Conference tickets', 'Senior Marketing Manager for North America region.', 1, 6),
(3, 3, 3, 3, 3, 2, 2, 3, 8, 8, 1, 2, 1, 'Relocation package, Visa support', 'Contract Project Engineer for bridge construction.', 1, 3),
(4, 4, 4, 1, 4, 1, 1, 4, 9, 9, 2, 1, 1, 'Gym membership, Meal plans', 'Entry-level Financial Analyst for banking sector.', 1, 0),
(5, 5, 5, 1, 5, 4, 2, 5, 10, 10, 3, 3, 1, 'Housing allowance, Insurance', 'Senior Nurse for Tokyo International Medical Center.', 1, 8),
(1, 1, 1, 1, 1, 2, 2, 1, 11, 11, 1, 2, 1, 'Remote flexibility, Bonuses', 'Mid-level Backend Developer for fintech startup.', 1, 2),
(2, 2, 2, 2, 2, 1, 1, 2, 12, 12, 2, 1, 1, 'Flexible schedule, Creative freedom', 'Junior Content Marketing Specialist.', 1, 1),
(3, 3, 3, 1, 3, 3, 1, 3, 13, 13, 3, 3, 1, 'On-site meals, Transportation', 'Mid-level Structural Engineer for UK projects.', 1, 4),
(4, 4, 4, 1, 4, 3, 1, 4, 14, 14, 1, 3, 1, 'Performance incentives, Training', 'Senior Financial Analyst for Singapore office.', 1, 5),
(1, 1, 1, 1, 1, 4, 1, 1, 1, 1, 2, 4, 1, 'Executive perks, Stock options', 'Principal Architect for enterprise solutions.', 1, 10);
