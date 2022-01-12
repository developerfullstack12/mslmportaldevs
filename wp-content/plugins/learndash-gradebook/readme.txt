=== LearnDash - Gradebook ===
Contributors: joelworsham, brashrebel, d4mation, eel87, joelyoder
Requires at least: 4.8.0
Tested up to: 5.3
Stable tag: 2.1.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Adds Gradebook functionality to LearnDash LMS.

== Description ==

Adds Gradebook functionality to LearnDash LMS.

== Changelog ==

= 2.1.1 =
- Fixes issue with fallback to a previously saved "Safe Mode" setting
- Improves updater code

= 2.1.0 =
- IMPORTANT: LearnDash Gradebook now requires LearnDash version 3.4 or above
- Renames "Gradebook Safe Mode" to "Disable Sorting by Grades for the Backend Gradebook" as that is what it was doing.
  - This can be forcibly enabled by adding `define( 'LD_GB_DISABLE_SORTING_BY_GRADES_BACKEND', true );` to your wp-config.php file.
  - If you already had this enabled as "Gradebook Safe Mode" before this update, it will stay enabled properly after you update.
- Adds a fix for sites with a lot of Groups with many Students where Admins were unable to access the dashboard. This is the new "Non-Group Leaders only have their own Group Users in their Gradebook" Setting under LearnDash LMS -> Gradebook -> Settings.
  - This can be forcibly enabled by adding `define( 'LD_GB_NON_GROUP_LEADERS_ONLY_OWN_GROUP_USERS', true );` to your wp-config.php file.
  - Note: This will prevent any Users (Including Admins) from viewing Students in the Gradebook that do not belong to a Group that they are a Group Leader of.
- Replaces deprecated calls to `lesson_hasassignments()` with `learndash_lesson_hasassignments()`
- Makes some adjustments to how templates are loaded in the Frontend Gradebook so that any fatal PHP errors will be shown as an error box
  - Further details about these errors will show within the JavaScript console in your browser.
- Fixes an issue where an empty color could be stored for the Grade Color Scale, which caused a PHP fatal error when viewing the Frontend Gradebook
- Fixes an issue where a Letter Grade Scale that was set to "0" would not display on the Settings Page
- Fixes an error on the welcome page

= 2.0.6 =
- Fixes syntax issue in Quick Start Tutorial

= 2.0.5 =
- Fixes issue with Quick Start Tutorial

= 2.0.4 =
- Fixes a bug where the User Email would get read incorrectly for the Gradebook
- Adds an option to show both Percentage and Letter Grade in the Gradebook at once
- Frontend Gradebook: The first column and the top row are now fixed in place as you scroll. This is helpful in scenarios where you have a lot of Components in a Gradebook

= 2.0.3 =
- Fixes a PHP syntax error when no Grade Style settings were saved

= 2.0.2 =
- Fixes an issue with the Backend Gradebook Exports if more than one page of Students exists
- Removes the empty lines from the All Grades Exports
- Fixes a PHP 7.1+ incompatibility if you were to delete all Grade Styles
- Fixes incompatibilities with WisdmLab's Instructor Role plugin
- Adds the ld_gb_get_gradebook_get_users_args_override Filter

= 2.0.1 =
- Fixes a bug with the "Export All Gradebook Grades" button in the Backend Gradebook
- Adds the ld_gb_backend_gradebook_export_per_page Filter

= 2.0.0 =
- A Frontend Gradebook has been included! 
  - You can include the Frontend Gradebook on any page of your site with the [ld_gradebook] Shortcode
  - You can find more information in our documentation: https://realbigplugins.com/docs/learndash-gradebook/#frontend-gradebook
- The ability to export Grades to CSV has been added!
  - You can export all Component Grades (the Grades as shown in the main Gradebook view) as well as export all Grades for each Student
- Adds the ability to sort by First Name, Last Name, Email Address, and User Login in addition to the previously used Display Name.
  - This option can be found under LearnDash LMS -> Gradebook -> Settings
- Fixes issue where the Letter Grade Scale and Color were not pulled in correctly in WordPress 5.5.x
  - Requires a database update!
- Fixes an issue where some Students were not showing in the Gradebook when they should have been
- Fixes an issue where Assignmetns wouldn't show properly within a User Grade when they were not approved or completed yet
- Fixes an issue where a site has Groups but a Group Leader is viewing the Gradebook without having Groups assigned to them caused the Gradebook to show them all Students
- Fixes an issue where Group Leaders and potentially other User Roles were unable to save Components and other Gradebook settings
- Fixes an issue where a Student had not taken any Quizzes yet and the Gradebook Completion Grading Mode was set to "Fail until completion" or "Mark as Incomplete until completion", it would not mark the relevant Quizzes as failed/incomplete correctly
- Fixes an issue where the Report Card Shortcode wouldn't respect the "Grade Display Mode" setting
  - This updated the following Report Card template files:
    - report-card/report-card.php
    - report-card/component/component.php
    - report-card/component/grade.php
    - report-card/overall-grade.php
- Fixes an issue with displaying the Groups dropdown in the Dashboard Widget
- Prevents a possible issue when pulling saved options
- Removes PHP deprecation warning for ternary else-if format

= 1.6.6 =
- Add option to mark Assignments/Quizzes as incomplete until completion
- Fix for removing Component Grade overrides
- If a Course is chosen for a Gradebook, ensure that Quiz Grades that are grabbed are only for that Course. This is important if a Quiz is shared across multiple Courses.
- If a User Role can see the Gradebook but cannot create their own Gradebooks, ensure that they do not see the "Create Gradebook" button if no Gradebooks are found.

= 1.6.5 =
- Adds a Completion timestamp to the Quiz Grades within Components. This is a developer-centric change for those who may be using the ld_gb_get_user_grade Filter

= 1.6.4 =
- Adds the Overall Grade Shortcode. This can be a useful utility in LearnDash Certificates. 
  - Usage: `[ld_overall_grade gradebook=123]`
- Fixes a potential issue when using the `ld_gb_adminpage_gradebook_select_query_args` filter to ensure that the default Gradebook will always be the first one in the Select dropdown
- If a Quiz was manually marked as "Complete" from the User Edit screen, LearnDash Gradebook will now show a 0% for that Quiz instead of hitting an error

= 1.6.3 =
- Fixes bug when using [ld_report_card] with no Gradebook set

= 1.6.2 =
- Adds Gradebook ID to ld_gb_gradebook_data Filter
- Adds ld_gb_gradebook_list_table_grade_display Filter
- Adds ld_gb_get_user_grade Filter which allows overriding the returned value of ld_gb_get_user_grade() before anything is processed

= 1.6.1 =
- The ld_gb_adminpage_gradebook_select_query_args filter was placed on the incorrect query. This will now do what is expected of it.

= 1.6.0 =
- Now respects the Custom Labels given to LearnDash Content Types in its Settings
- Assignment Lesson/Topic fields now will only show results for Assignments that have Assignment Uploads enabled
- If Lessons or Topics are chosen to pull Assignment Grades for and the Gradebook has “Fail until completion” enabled, then a failing score of 0% will be shown for every Assignment that a Student has not submitted
    - Note: These will show below other Assignments in their User Grades and in the Report Card regardless of your Component Ordering settings.
- If an Assignment has been submitted but not approved, then it will show “Pending Approval” in their User Grades and within the Report Card and not count toward or against the Student.
- If [ld_report_card] is used without a gradebook defined, it will attempt to output all relevant Gradebooks for that Student.
    - To help facilitate this, the Gradebook ID needed to be passed into each Report Card template. This means that if you are overriding any Report Card template files in your Theme, they will require updating.
    - These changes only impact if you’re showing multiple Report Cards on the same page.
- Added the ld_gb_adminpage_gradebook_select_query_args filter to allow adjusting the Query Args for the Gradebooks shown in the Gradebooks dropdown on the primary Gradebook admin page.
- Added the learndash_gradebook_delete_manual_grade() and learndash_gradebook_update_manual_grade() functions to make interacting with Manual Grades programmatically easier.
- Added the learndash_gradebook_manual_grade_default_score filter so that a default score for Manual Grades on the User Grades screen can be defined. This does not impact using the functions listed above.

= 1.5.1 =
* Fixes an issue where when choosing a Group, it was possible for the Gradebook to show all Users if no Users within the Group had started the Course yet.
* Add ability to disable Manual Grades
* Add ability to disable Component grade Overrides
* Fixes issue where using a non-existing Gradebook with the Report Card Shortcode would cause a Fatal Error
* Fixes an issue where sometimes elements could be missing from the Gradebook/Report Card
* Adds the ability to show the containing Lesson/Topic title for Assignment entries in the Gradebook/Report Card rather than the uploaded file name.
* The Report Card template file at templates/report-card/report-card-error.php has been updated. If any Themes are overriding this file, they will need to update it.

= 1.5.0 =
* Fixes issue where when a User was granted the ability to view or create/edit Gradebooks, they were unable to within LearnDash v3.x
* Fixes an issue where if a User did not dismiss the Quickstart Guide they were unable to utilize any aspects of the Gradebook
* If a website had a lot of Course Content, it was possible that when creating a new Gradebook the page would fail to load. The default Course is no longer set to "All Courses" to avoid this. For sites where this is an issue, they will be unable to use "All Courses" at this time.
* Fixes some styling with the Gradebook and Report Card shortcode
* The Report Card template file at templates/report-card/report-card.php has been updated. If any Themes are overriding this file, they will need to update it.

= 1.4.7 =
* Fixes incompatibility with Gravity Forms Advanced Post Creation when attempting to create a Post Creation Feed

= 1.4.6 =
* Fixes an issue where Gradebooks of Courses where no User had started the Course yet would show all Users even when the "Show All Users" option was disabled

= 1.4.5 =
* Fixes issues with loading resources on Windows Servers

= 1.4.4 =
* Prevents a possible PHP error when using the [ld_report_card] shortcode
* Corrects a PHP warning when using the [ld_report_card] shortcode

= 1.4.3 =
* Fixes incompatibility with Download Manager Pro

= 1.4.2 =
* Fixes incompatibility with WisdmLabs' Instructor Role Plugin causing data to not populate in the Gradebook or User Grade views.

= 1.4.1 =
* Gradebooks can now have their Author changed via the Edit screen or the Quick Edit dialog. This is useful if you've granted other Roles the ability to Edit Gradebooks, but you want to create one for them and "assign" it to them afterward.

= 1.4.0 =
* You can now grant any User Role the ability to Create their own Gradebooks. This can be found under LearnDash LMS -> Gradebook -> Settings -> Roles.
* Fix: Minimum LearnDash version now set to v2.3.0.
* Fix: Minimum WordPress version now set to v4.8.0.

= 1.3.8 =
* Fix: Fixes stying bug when Grade Display Mode is set to "Percentage"
* Fix: Quiz grades were not showing as failed if the "Fail until completion" setting was checked in the Gradebook Settings.

= 1.3.7 =
* Fix: Bug in upgrade routine that caused Gradebook to think the last upgrade preformed was one for v2.0.0
* Fix: Adiminstrators are now able to edit Gradebooks made by other Users (Database Upgrade Required)
* Added a hierarchy context for each item when Editing a Gradebook
  * Example: Lesson 2 -> Topic 3 -> Quiz 4
  * This is helpful if you have multiple different Topics or Quizzes with the same name so that they can be visually differentiated from each other when configuring a Gradebook

= 1.3.6 =
* Fix: Components sometimes lost their ID's, not allowing weights to be set properly.

= 1.3.5 =
* Fix: Unable to edit others gradebooks on multisite if not super-admin.

= 1.3.4 =
* Fix: Gradebook safemode not loading users.
* Fix: Edge case narrow dropdown for group selector on Gradebook page.
* Fix: Unable to edit user component grade overrides.
* Add ability to manually setup roles.

= 1.3.3 =
* Fix: Upgrade RBM FH to prevent Select2 conflict.
* Fix: Broken capability

= 1.3.2 =
* Fix: Gradebook not showing pagination.

= 1.3.1 =
* Fix: Gradebook only showing 10 users.

= 1.3.0 =
* Feature: Grade display mode. Allows displaying grades as percentages.
* Feature: Report Card resource ordering. Allows customization of ordering of resources on Report Card.
* Feature: Assignments from Topics. Allows adding assignments from topics on Gradebook, similar to assignments form lessons.
* Improvement: Better select box for group selector on Gradebook page.

= 1.2.101 =
* Fix assignments not populating dropdown on Gradebook edit page.
* (Version 101 due to error)

= 1.2.10 =
* Report Card shortcode user logged out message.

= 1.2.9 =
* Fix broken setting for Grade Color Scale.

= 1.2.8 =
* Fix "All Quizzes" in Gradebook with new LearnDash Course Builder.

= 1.2.7 =
* Fix "disappearing" options in components within Gradebook manaagement.

= 1.2.6 =
* Allow Group Leaders (or anyone with the "view_gradebook" capability) to view and edit user grades.
* Fix incompatibility with the new Shared Course Steps feature.

= 1.2.5 =
* Fix some PHP notices

= 1.2.4 =
* Fix pre PHP 7 conflict

= 1.2.3 =
* Gradebook safemode fix
* Gradebook page hide users verbiage update
* Pre PHP 7 conflict fix

= 1.2.2 =
* Filter users in Gradebooks based on Course enrollment
* Modify upgrade process

= 1.2.1 =
* Potential bug with upgrade process

= 1.2.0 =
* Multiple Gradebooks
* Premium support
* Assignment points integration

= 1.1.7 =
* Allow Group Leaders to assign Gradebook Types to Assignments and Quizzes.

= 1.1.6 =
* Fix new "Gradebook Safe Mode" loading bug.

= 1.1.5 =
* Improve user searching in Gradebook.
* Add "Gradebook Safe Mode" for faster loading on sites with large databases.

= 1.1.4 =
* Fix Group Leader edit assignment grade bug.

= 1.1.3 =
* Fix translatable string in Report Card

= 1.1.2 =
* Require min LearnDash version of 2.1.0

= 1.1.1 =
* Fix infinite quickstart loop

= 1.1.0 =
* LearnDash groups support
* New settings page structure and improved settings API
* New report card templating system
* Gradebook role access customization
* Gradebook Type grade override capability
* Gradebook searching and sorting
* Improved Gradebook styles
* Gradebook Type grade information tool tip
* Gradebook dashboard widget
* Customizeable grade rounding
* Fix radio select bug

= 1.0.4 =
* Fix obtrusive settings page styling.

= 1.0.3 =
* Fix broken admin Gradebook pagination.

= 1.0.2 =
* Quickstart can be cutoff on tall admin menus.

= 1.0.1 =
* Revise user edit screen Gradebook interface.
* Grade Statuses.
* Add indicators to the Types page to see what each Type is currently being used by.
* Move licensing to the Gradebook Settings page.
* Bug fixes.

= 1.0.0 =
* Initial release.