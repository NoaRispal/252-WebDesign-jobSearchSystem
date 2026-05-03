# Project Handoff: Job Portal Frontend

Hello Backend and Database Teams! 👋

This repository contains the finalized (maybe) frontend templates (HTML/CSS/Vanilla JS) for the Job Vacancy Management & Job Search System (Powered by Antigravity IDE and Figma). The frontend has been designed, normalized, and heavily documented to ensure a seamless transition into a dynamic PHP MVC backend.

The preview of the pages are in the Figma export folder. Please take a look at the preview to understand the design and functionality of the website.

Figma template (customized) link: https://www.figma.com/design/lj1aREtxlHBrGzgY2e7Yev/Job-Portal-Figma-Template--Custum-?node-id=0-1&t=E5yIvaGQJloEezh2-1

Please review the following navigation guide to find exactly what you need for your respective tasks.

Note: The "SUS" mobile layouts for employer dasboard, admin dashboard and admin reference tables page are not yet fixed, will be done soon later with extra works using Figma and Antigravity IDE agents.

Note 2: The Figma MCP Server is included in the `figma-mcp-server` directory. Please refer to `figma-mcp-server_setup.md` for instructions on how to set it up. (I need the plugin to make it easier to edit the frontend and export the Figma design to codes using Antigravity IDE, reference: https://youtu.be/MHmJl4B-dL4?si=4-4vUrEVrjme2_ji)

Note 3: If there is any conflict between the frontend setup and the current backend and database, please note it down and let me know.

---

## 📁 File Structure Overview

*   `*.html` - The static frontend templates ready to be renamed to `.php`.
*   `style.css` - Custom CSS. Uses CSS variables for all theme tokens (dark mode compatible). Avoid rewriting these tokens!
*   `script.js` - Contains mobile navigation menus, dynamic form generation, and UI modal logic. Do not remove this!
*   `Figma export/` - Contains the visual PNG snapshots of every rendered page.
*   `git_github_guide.md` - Nothing special, just a note/guide for using git and github that i prompted for explaining it to a monkey like me.

---

## 🧭 Navigation for the Backend Engineering Team

The main goal will be migrating these static `.html` files into dynamic `.php` views, and building out the `Auth`, `Job`, and `Admin` controllers. 

Here is what you need to know:
1. **Developer Comments:** Open any major `.html` file (`index.html`, `login.html`, `employer-job-form.html`, etc.). You will see detailed `<!-- BACKEND: ... -->` comments that explicitly indicate:
   * Recommended form `action` endpoints.
   * Specific variable names your controllers should pass to the views.
   * Flash session handling patterns.
   * Security constraints (Requires Employer vs. Admin role, CSRF token insertion points).
2. **Dynamic Components:** We have fully structured the forms to capture arrays properly. For example, in `employer-job-form.html`, the dynamic skills module generates hidden `<input name="skills[0][name]">` elements that your POST requests will natively capture.
3. **Core Integration Reference:** You **must** read **`backend_integration_report_v2.md`**. It contains the exact form-to-database column mapping, the recommended file structure (Views/Controllers/Models layout), and server-side validation checklists.

---

## 🗄️ Navigation for the Database Team

The main goal will be establishing the normalized relational schemas and seeding the reference data.

Here is what you need to know:
1. **Schema Design:** Your primary resource is **`backend_integration_report_v2.md`**. It provides a comprehensive breakdown of the 12 primary tables required, including all Foreign Keys, constraints, and data types mapped perfectly to the frontend inputs.
2. **Reference Tables:** The system relies heavily on reference data (Categories, Job Levels, etc.). We built a specific page for this: `admin-references.html`. Please ensure the database schema fully supports the 8 core reference tables outlined there.
3. **Dynamic Dropdowns:** Whenever you see a `<select>` input in `jobs.html` or `employer-job-form.html`, we expect the backend to loop over the reference tables you create to populate them dynamically. 

---


