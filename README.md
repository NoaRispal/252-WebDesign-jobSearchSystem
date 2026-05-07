# Job Vacancy Management & Job Search System

## Project Overview
This project is a comprehensive web-based platform developed for the **Web Programming (CO3050)** course at Ho Chi Minh City University of Technology. It connects employers with prospective candidates through a modern interface while providing administrators with robust tools to maintain system integrity.

The system is built on a custom **Model-View-Controller (MVC)** architecture using PHP and MySQL, ensuring a strict separation between business logic, data access, and the presentation layer.

## Core Features by User Role

### Job Seeker
**Multi-Filter Search:** Advanced search functionality with nine independent dimensions (Category, Location, Job Level, etc.) operating with "AND" logic.

**Job Detail View:** Comprehensive pages displaying full descriptions, requirements, and company information.

**Interactive Applications:** Direct contact forms to facilitate the application process.

### Employer
**Management Dashboard:** A centralized view to track posting lifecycles with real-time status indicators (Active, Pending, Inactive).

**Structured Job Creation:** A multi-section form capturing job details, location, compensation, and up to five required skills with proficiency levels.

**Lifecycle Control:** Ability to edit, toggle activation status, or delete postings with data atomicity.

### Administrator
**Content Moderation:** Authority to view and remove inappropriate listings across the entire platform.

**Reference Table CRUD:** A unified tab-based interface to manage 14 lookup tables (Skills, Industries, Job Levels, etc.) to ensure data consistency.

## Technical Architecture

### Backend & Security
**Pattern:** Strict Model-View-Controller (MVC) implementation.

**Database:** Fully normalized MySQL schema using 14 reference tables to eliminate text-based anomalies.

**Security Measures:**
- **SQL Injection Prevention:** Consistent use of **PDO prepared statements** for all database interactions.
- **RBAC:** Server-side Role-Based Access Control enforced in the front controller.
- **Data Sanitization:** Aggressive validation using `htmlspecialchars()` and explicit integer type-casting.

### Frontend Implementation
**Design System:** Developed from a Figma template using a "Design-to-Code" workflow assisted by MCP (Model Context Protocol).

**Styling:** A hybrid approach using a Bootstrap baseline "skinned" with custom CSS to match the professional Figma aesthetic.

**Responsive Design:** Implements a "Table-to-Card" transformation pattern for dashboards to ensure usability on mobile devices.

## Data Model
The database architecture emphasizes high integrity through normalization:

**Identity Management:** `Users`, `Roles`, and `Employers` tables with one-to-one relationships.

**Relational Mapping:** Many-to-many relationships between jobs and skills managed via junction tables (`Job_Vacancy_Skills`).

## Setup Instructions
1. Clone the repository: `https://github.com/NoaRispal/252-WebDesign-jobSearchSystem`
2. Import the `database.sql` file into your MySQL environment.
3. Configure your local server (XAMPP, MAMP, etc.).
4. Access the platform via your local host.

## Team (Group 6)
**Tran Duy Tuan:** Frontend & Report (Intro, Design)

**RISPAL Noa:** Backend & Testing (Admin/Employer Side)

**Le Huu Trieu:** Backend & Testing (Job Seeker Side)

**Le Minh Anh Tuan:** Database Design & Administration