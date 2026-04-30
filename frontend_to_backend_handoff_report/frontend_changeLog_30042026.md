# Backend Handoff Report (changeLog 30/4/2026_Tran Duy Tuan) — Project Stabilization

This report summarizes all architectural and frontend modifications made to the system. Each change is documented in the source code with `<!-- BEFORE ... FIX -->` blocks for easy rollback or comparison.

### Disclaimer

- **Personal Note 1:** Forgive me if there is any changes comparing to the lastest version on github that i missed and didn't update here. Also, i did some of the login and authentication part so that I can further work on the tables->cards layout of the dashboard page in mobile screen view. (I previously can not access to the dashboards from the login page due to the lack of the basic backend authentication that mismatched the frontend session requirement).

- **Personal Note 2:** I have added more comments in the code to make it easier to understand, but... lately I forgot to commit the partial changes, so I commit them all at once here, there will be some changes that are not clearly documented (Another apology for the lack of version controlling skill... skill issue, I admit it T_T).

---

## 1. Authentication & Session Management
**Where:** `controllers/authController.php`, `View/layouts/header.php`, `index.php`

### Changes Made:
- **[FIXED] Login Redirects**: Original logic used relative paths (e.g., `employer/dashboard`), which caused routing loops. Now uses `$baseUrl` prefixing.
- **[ADDED] Logout Functionality**: Previously, "Logout" links just navigated to the login page without clearing the session. Added a proper `logout()` method in `AuthController` and a `logout` route in `index.php`.
- **[FIXED] Session Guards**: Fixed `AdminController` and `AuthController` to correctly handle `Role_ID` and session variables to prevent unauthorized access.

### Backend Evaluation:
- **Appropriate**: The `logout` mechanism is now production-ready.
- **Further Work**: The `AuthController` currently uses a hardcoded "demo account" switch. This needs to be replaced with a real database query against the `Users` table.

---

## 2. Database & Model Alignment
**Where:** `Models/referenceTables.php`, `controllers/adminController.php`

### Changes Made:
- **[FIXED] Schema Mismatch**: The `referenceTables.php` model previously assumed all tables used `id` and `name`. It has been updated to use the correct columns from `database.sql` (e.g., `Category_ID`, `Category_Name`).
- **[REMOVED] Non-existent Tables**: The "Locations" reference table was removed from the Admin Dashboard because it does not exist in the database (replaced by Cities/Countries).
- **[FIXED] Property Inconsistency**: Fixed instances where the model used `$this->conn` instead of the initialized `$this->db` property.

### Backend Evaluation:
- **Need to Discuss**: The `Job_Vacancies` table currently uses `Salary_Range_ID` (Lookup), but the frontend has been moved to a `Min/Max` salary model (see Section 3). The backend team should decide whether to update the DB schema to `Salary_Min/Max` or map the frontend values to the lookup table.

---

## 3. Frontend UX Refactoring
**Where:** `View/jobs/list.php`, `View/employer/job_form.php`, `View/layouts/header.php`

### Changes Made:
- **[REFACTORED] Salary Input**: 
  - **Where**: Job Listing Sidebar & Employer Job Form.
  - **Why**: Standardized dropdowns/sliders are too restrictive for precise salary reporting.
  - **What**: Replaced with numeric Min/Max inputs.
- **[REFACTORED] Job Description**: 
  - **Where**: `job_form.php`.
  - **Why**: Database schema has one `Job_Description` column, but form had 4 separate textareas.
  - **What**: Consolidated into one large textarea.
- **[REFACTORED] Location Selection**: 
  - **Where**: `list.php`.
  - **What**: Split the single "City" select into "Country - City - District" cascading selects.
- **[ADDED] Required Skills**:
  - **Where**: `list.php` sidebar.
  - **What**: Added searchable multiple-choice skill filter to match the new `Job_Vacancy_Skills` junction table.

---

## 4. Dashboard & Navigation (UX Improvements)
**Where:** `View/employer/dashboard.php`, `View/admin/dashboard.php`, `View/layouts/header.php`, `Public/style.css`

**Note 01 _ Navbar behaviors change base on the user role**: The `header.php` is now a global component. It is displayed on the frontend for public pages, and when the user logs in, it automatically switches to the dashboard navigation. You can check it in `View/layouts/header.php` and `index.php`. There 3 different behaviors for header.php:
1. **Public pages (guest and jobseeker)**: Display the "Login" and "Register" buttons and the navbar of the job seeking site. the job seekers can search for jobs, view job details, and apply for jobs.
2. **Employer dashboard**: Display the "Profile", "Dashboard", "Create Job", "Manage Jobs", and "Logout" buttons on the sidebar. The employer can create, edit, and delete jobs. The top navbar will be change to hide the job seeker's navbar and search bar (note that the usecases of the employer is only create and manage jobs, not to navigate to other pages).
3. **Admin dashboard**: Display the "Profile", "Dashboard", "Manage Categories", "Manage Locations", "Manage Job Types", "Manage Salary Ranges", "Manage Job Vacancies", and "Logout" buttons. The top navbar in admin dashboard will be hide the job seeker's navbar and search bar but a button to browse the site is displayed on the top right corner to switch back to public site for reviewing and testing.

**Note 02 _ Dashboard layout changes**: The dashboard layout has been changed to a two-column layout with a sidebar and a main content area. The main content area is a grid of cards that can be expanded to show more details. You can check it in `View/employer/dashboard.php` and `View/admin/dashboard.php`. The previously implemented table layout of the dashboard is removed and replaced with the card layout to fit the mobile screen when accessing the site via phone browser, while preserving the desktop layout as it is. (The change is made to fit the mobile screen, not to change the whole layout)

### Changes Made:
- **[ADDED] Responsive Dashboard Cards**: 
  - **Problem**: Admin/Employer tables suffered from heavy horizontal scrolling on mobile.
  - **Solution**: Implemented a "Card Mode" media query in `style.css` that converts table rows into expandable cards on screens < 768px.
  - **Interaction**: Added `initCardExpand()` in `script.js` to allow users to toggle card details on mobile tap.
- **[REMOVED] "Flagged" Status**: 
  - **Reason**: Per backend team request, removed the "Flagged" status from the Admin dashboard and reference modals as there is currently no suspicion detector logic.
- **[FIXED] Dashboard Action Icons**:
  - **Where**: Dashboard table rows/cards.
  - **Problem**: View/Edit/Delete buttons were missing icons or had inconsistent interactions.
  - **Solution**: Standardized all actions with SVG icons and ensured `a` links and `button` forms have identical hover/click behaviors.
- **[ADDED] Role-Based Navigation Guards**:
  - **Job Seeker**: When logged in, the "Login/Register" buttons are automatically replaced by a Profile Badge and a Logout button.
  - **Employer**: Public job seeker navigation links are hidden within the dashboard to prevent cross-contamination of flows. Logout is moved exclusively to the sidebar.
  - **Admin**: Added a "Browse Site" button in the dashboard and a "Back to Dashboard" button when browsing public pages to allow for easier moderation/review.

### Backend Evaluation:
- **Appropriate**: The navigation logic in `header.php` is now context-aware based on the user's role and the current page type (`$isDashboard`).
- **Appropriate**: The removal of "Flagged" status ensures the UI does not offer options that the backend cannot currently process.

---

## 5. Router & Navigation (Stability)
**Where:** `Public/index.php`, `View/errors/404.php`

### Changes Made:
- **[FIXED] Router Typo**: Fixed a 404 error where the router looked for `job-form.php` instead of the actual `job_form.php`.
- **[ADDED] 404 UX**: Added a "Go Back" button to the 404 page using `window.history.back()` to prevent dead-ends for users.

---

## 6. Suggestions & Conflicts
- **Conflict — Job Titles**: The current system uses a `Job_Titles` lookup table. This is highly restrictive for employers. **Suggestion**: Change `Title_ID` to a free-form VARCHAR or implement an "Add New Title" logic in the `JobVacancy` model.
- **Conflict — Required Skills**: The database junction table `Job_Vacancy_Skills` requires a `Min_Proficiency_ID`. The UI has been updated to include a Proficiency dropdown for each skill added. The backend team must ensure the `createJob` logic handles this array submission correctly.
- **Suggestion**: Integrate a **Rich Text Editor** (Quill/TinyMCE) for the `Job_Description` field in the employer form to allow for professional formatting (bullets, bolding), as the current single textarea is plain text.

---
*End of Report*
