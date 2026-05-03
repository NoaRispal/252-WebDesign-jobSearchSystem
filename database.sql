-- Database creation
CREATE DATABASE IF NOT EXISTS `job_search_db` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
USE `job_search_db`;

-- 1. Roles & Users
CREATE TABLE Roles (
    Role_ID INT PRIMARY KEY AUTO_INCREMENT,
    Role_Name VARCHAR(50) UNIQUE NOT NULL
);

CREATE TABLE Users (
    User_ID INT PRIMARY KEY AUTO_INCREMENT,
    Role_ID INT NOT NULL,
    Email VARCHAR(255) UNIQUE NOT NULL,
    Password_Hash VARCHAR(255) NOT NULL,
    FOREIGN KEY (Role_ID) REFERENCES Roles(Role_ID)
);

-- 2. Employers
CREATE TABLE Employers (
    Employer_ID INT PRIMARY KEY AUTO_INCREMENT,
    User_ID INT UNIQUE NOT NULL,
    Company_Name VARCHAR(255) NOT NULL,
    Company_Description TEXT,
    Website VARCHAR(255),
    FOREIGN KEY (User_ID) REFERENCES Users(User_ID) ON DELETE CASCADE
);

-- 3. Job Attributes (Reference Tables)
CREATE TABLE Job_Categories (
    Category_ID INT PRIMARY KEY AUTO_INCREMENT,
    Category_Name VARCHAR(100) UNIQUE NOT NULL
);

CREATE TABLE Job_Titles (
    Title_ID INT PRIMARY KEY AUTO_INCREMENT,
    Title_Name VARCHAR(100) UNIQUE NOT NULL
);

CREATE TABLE Industries (
    Industry_ID INT PRIMARY KEY AUTO_INCREMENT,
    Industry_Name VARCHAR(100) UNIQUE NOT NULL
);

CREATE TABLE Countries (
    Country_ID INT PRIMARY KEY AUTO_INCREMENT,
    Country_Name VARCHAR(100) UNIQUE NOT NULL
);

CREATE TABLE Cities (
    City_ID INT PRIMARY KEY AUTO_INCREMENT,
    Country_ID INT NOT NULL,
    City_Name VARCHAR(100) NOT NULL,
    FOREIGN KEY (Country_ID) REFERENCES Countries(Country_ID)
);

CREATE TABLE Districts (
    District_ID INT PRIMARY KEY AUTO_INCREMENT,
    City_ID INT NOT NULL,
    District_Name VARCHAR(100) NOT NULL,
    FOREIGN KEY (City_ID) REFERENCES Cities(City_ID)
);

CREATE TABLE Employment_Types (
    Emp_Type_ID INT PRIMARY KEY AUTO_INCREMENT,
    Type_Name VARCHAR(50) UNIQUE NOT NULL
);

CREATE TABLE Job_Levels (
    Level_ID INT PRIMARY KEY AUTO_INCREMENT,
    Level_Name VARCHAR(50) UNIQUE NOT NULL
);

CREATE TABLE Work_Arrangements (
    Arrangement_ID INT PRIMARY KEY AUTO_INCREMENT,
    Arrangement_Name VARCHAR(50) UNIQUE NOT NULL
);

CREATE TABLE Salary_Ranges (
    Range_ID INT PRIMARY KEY AUTO_INCREMENT,

    -- TODO: Add CHECK constraint (MIN_SALARY <= Min_Salary <= Max_Salary <= MAX_SALARY)
    Min_Salary INT NOT NULL,
    Max_Salary INT NOT NULL
);

CREATE TABLE Salary_Types (
    Type_ID INT PRIMARY KEY AUTO_INCREMENT,
    Type_Name VARCHAR(50) UNIQUE NOT NULL
);

CREATE TABLE Degree_Levels (
    Degree_ID INT PRIMARY KEY AUTO_INCREMENT,
    Degree_Name VARCHAR(100) UNIQUE NOT NULL
);

CREATE TABLE Skills (
    Skill_ID INT PRIMARY KEY AUTO_INCREMENT,
    Skill_Name VARCHAR(100) UNIQUE NOT NULL
);

CREATE TABLE Proficiency_Levels (
    Proficiency_ID INT PRIMARY KEY AUTO_INCREMENT,
    Proficiency_Name VARCHAR(50) UNIQUE NOT NULL
);

-- 4. Job Vacancies
CREATE TABLE Job_Vacancies (
    Vacancy_ID INT PRIMARY KEY AUTO_INCREMENT,
    Employer_ID INT NOT NULL,
    Title_ID INT NOT NULL,
    Category_ID INT NOT NULL,
    Emp_Type_ID INT NOT NULL,
    Industry_ID INT NOT NULL,
    Level_ID INT NOT NULL,
    Number_Of_Openings INT NOT NULL,
    Country_ID INT NOT NULL,
    City_ID INT NOT NULL,
    District_ID INT,
    Arrangement_ID INT NOT NULL,
    Salary_Range_ID INT NOT NULL,
    Salary_Type_ID INT NOT NULL,
    Benefits TEXT,
    Job_Description TEXT NOT NULL,
    Min_Degree_ID INT NOT NULL,
    Min_Years_Experience INT NOT NULL,
    Posting_Date DATETIME DEFAULT CURRENT_TIMESTAMP,
    Is_Active BOOLEAN DEFAULT TRUE,
    FOREIGN KEY (Employer_ID) REFERENCES Employers(Employer_ID),
    FOREIGN KEY (Title_ID) REFERENCES Job_Titles(Title_ID),
    FOREIGN KEY (Category_ID) REFERENCES Job_Categories(Category_ID),
    FOREIGN KEY (Emp_Type_ID) REFERENCES Employment_Types(Emp_Type_ID),
    FOREIGN KEY (Industry_ID) REFERENCES Industries(Industry_ID),
    FOREIGN KEY (Level_ID) REFERENCES Job_Levels(Level_ID),
    FOREIGN KEY (Country_ID) REFERENCES Countries(Country_ID),
    FOREIGN KEY (City_ID) REFERENCES Cities(City_ID),
    FOREIGN KEY (District_ID) REFERENCES Districts(District_ID),
    FOREIGN KEY (Arrangement_ID) REFERENCES Work_Arrangements(Arrangement_ID),
    FOREIGN KEY (Salary_Range_ID) REFERENCES Salary_Ranges(Range_ID),
    FOREIGN KEY (Salary_Type_ID) REFERENCES Salary_Types(Type_ID),
    FOREIGN KEY (Min_Degree_ID) REFERENCES Degree_Levels(Degree_ID)
);

CREATE TABLE Job_Vacancy_Skills (
    Vacancy_ID INT NOT NULL,
    Skill_ID INT NOT NULL,
    Min_Proficiency_ID INT NOT NULL,
    PRIMARY KEY (Vacancy_ID, Skill_ID),
    FOREIGN KEY (Vacancy_ID) REFERENCES Job_Vacancies(Vacancy_ID) ON DELETE CASCADE,
    FOREIGN KEY (Skill_ID) REFERENCES Skills(Skill_ID),
    FOREIGN KEY (Min_Proficiency_ID) REFERENCES Proficiency_Levels(Proficiency_ID)
);

-- ==========================================
-- TEST DATA (5 entries per table)
-- ==========================================

-- 1. Roles
INSERT INTO Roles (Role_Name) VALUES 
('admin'), ('employer'), ('job_seeker'), ('moderator'), ('guest');

-- 2. Users
-- Passwords are all 'password123'
INSERT INTO Users (Role_ID, Email, Password_Hash) VALUES 
(1, 'admin@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'),
(2, 'employer1@tech.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'),
(2, 'employer2@creative.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'),
(3, 'seeker1@gmail.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'),
(3, 'seeker2@yahoo.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi');

-- 3. Employers
INSERT INTO Employers (User_ID, Company_Name, Company_Description, Website) VALUES 
(2, 'Global Tech Solutions', 'Leading provider of software services.', 'https://globaltech.com'),
(3, 'Creative Minds Agency', 'A boutique marketing and design firm.', 'https://creativeminds.io'),
(1, 'System Admin Group', 'Managing the internal infrastructure.', 'https://admin.internal'),
(4, 'Data Analytics Co', 'Specializing in big data and AI.', 'https://dataco.com'),
(5, 'Future Builders', 'Construction and urban development.', 'https://futurebuilders.com');

-- 4. Job Categories
INSERT INTO Job_Categories (Category_Name) VALUES 
('IT & Software'), ('Marketing'), ('Engineering'), ('Finance'), ('Healthcare'),
('Education'), ('Sales'), ('Customer Service'), ('Design'), ('Human Resources');

-- 5. Job Titles
INSERT INTO Job_Titles (Title_Name) VALUES 
('Senior PHP Developer'), ('Marketing Manager'), ('Project Engineer'), ('Financial Analyst'), ('Nurse Practitioner');

-- 6. Industries
INSERT INTO Industries (Industry_Name) VALUES 
('Information Technology'), ('Advertising'), ('Construction'), ('Banking'), ('Medical');

-- 7. Countries
INSERT INTO Countries (Country_Name) VALUES 
('Thailand'), ('USA'), ('United Kingdom'), ('Singapore'), ('Japan');

-- 8. Cities
INSERT INTO Cities (Country_ID, City_Name) VALUES 
(1, 'Bangkok'), (2, 'New York'), (3, 'London'), (4, 'Singapore City'), (5, 'Tokyo'),
(1, 'Chiang Mai'), (2, 'Los Angeles'), (3, 'Manchester'), (4, 'Jurong'), (5, 'Osaka'),
(1, 'Phuket'), (2, 'Chicago'), (3, 'Bristol'), (4, 'Tampines'), (5, 'Kyoto');

-- 9. Districts
INSERT INTO Districts (City_ID, District_Name) VALUES 
(1, 'Sukhumvit'), (2, 'Manhattan'), (3, 'Westminster'), (4, 'Jurong East'), (5, 'Shibuya'),
(6, 'Silom'), (7, 'Brooklyn'), (8, 'Camden'), (9, 'Tampines'), (10, 'Shinjuku'),
(11, 'Chatuchak'), (12, 'Queens'), (13, 'Islington'), (14, 'Yishun'), (15, 'Ginza');

-- 10. Employment Types
INSERT INTO Employment_Types (Type_Name) VALUES 
('Full-time'), ('Part-time'), ('Contract'), ('Internship'), ('Freelance');

-- 11. Job Levels
INSERT INTO Job_Levels (Level_Name) VALUES 
('Entry Level'), ('Junior'), ('Mid-Level'), ('Senior'), ('Executive');

-- 12. Work Arrangements
INSERT INTO Work_Arrangements (Arrangement_Name) VALUES 
('On-site'), ('Remote'), ('Hybrid'), ('Flexible'), ('Traveling');

-- 13. Salary Ranges
INSERT INTO Salary_Ranges (Min_Salary, Max_Salary) VALUES 
(20000, 30000), (40000, 60000), (70000, 100000), (120000, 150000);

-- 14. Salary_Types
INSERT INTO Salary_Types (Type_Name) VALUES 
('Monthly'), ('Hourly'), ('Yearly'), ('Per Project'), ('Commission');

-- 15. Degree Levels
INSERT INTO Degree_Levels (Degree_Name) VALUES 
('Bachelor Degree'), ('Master Degree'), ('Doctorate'), ('High School'), ('None');

-- 16. Skills
INSERT INTO Skills (Skill_Name) VALUES 
('PHP'), ('SQL'), ('JavaScript'), ('Project Management'), ('Data Analysis'),
('Embedded Systems'), ('Digital Marketing'), ('Civil Engineering'), ('Financial Modeling'), ('Patient Care');

-- 17. Proficiency Levels
INSERT INTO Proficiency_Levels (Proficiency_Name) VALUES 
('Beginner'), ('Intermediate'), ('Advanced'), ('Expert'), ('Native');

-- 18. Job Vacancies
INSERT INTO Job_Vacancies (
    Employer_ID, Title_ID, Category_ID, Emp_Type_ID, Industry_ID, Level_ID, 
    Number_Of_Openings, Country_ID, City_ID, District_ID, Arrangement_ID, 
    Salary_Range_ID, Salary_Type_ID, Benefits, Job_Description, Min_Degree_ID, 
    Min_Years_Experience
) VALUES 
(1, 1, 1, 1, 1, 4, 2, 1, 1, 1, 3, 3, 1, 'Medical insurance, Free lunch', 'We are looking for a Senior PHP Developer...', 1, 5),
(2, 2, 2, 1, 2, 3, 1, 2, 2, 2, 2, 2, 1, 'Remote work, Annual bonus', 'Seeking a Marketing Manager for our NYC office.', 1, 3),
(3, 3, 3, 1, 3, 3, 3, 3, 3, 3, 1, 3, 1, 'On-site housing', 'Project Engineer needed for London bridge project.', 1, 4),
(4, 4, 4, 1, 4, 2, 1, 4, 4, 4, 3, 2, 1, 'Stock options', 'Junior Financial Analyst for Singapore HQ.', 1, 2),
(5, 5, 5, 1, 5, 4, 5, 5, 5, 5, 1, 4, 1, 'Pension scheme', 'Experienced Nurse for Tokyo International Hospital.', 1, 6);

-- 19. Job Vacancy Skills
INSERT INTO Job_Vacancy_Skills (Vacancy_ID, Skill_ID, Min_Proficiency_ID) VALUES 
(1, 1, 4), (1, 2, 3), (2, 4, 3), (4, 5, 2), (5, 5, 4);
