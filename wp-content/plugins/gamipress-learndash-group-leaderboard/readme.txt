=== GamiPress - LearnDash Group Leaderboard ===
Contributors: gamipress, tsunoa, rubengc, eneribs
Tags: gamipress, gamification, point, achievement, badge, award, reward, credit, engagement, ajax, learndash, leaderboard, group, LMS, eLearning, e-Learning, Learning, Learning Management System
Requires at least: 4.4
Tested up to: 5.8
Stable tag: 1.1.2
License: GNU AGPLv3
License URI:  http://www.gnu.org/licenses/agpl-3.0.html

Automatically create a GamiPress leaderboard of LearnDash group members

== Description ==

GamiPress - LearnDash Group Leaderboard will automatically create a [GamiPress](https://wordpress.org/plugins/gamipress/ "GamiPress") leaderboard assigned to a [LearnDash](https://www.learndash.com/ "LearnDash") group to make the leaderboard be filtered by the group members!

Through the GamiPress settings you will be able to configure the metrics by which group members should be ranked and the columns to show.

In addition, this plugin includes the "LearnDash User Groups Leaderboards" block (shortcode and widget version included too) to let you render all groups leaderboards of a specific user or of the current logged in user anywhere.

Important: This plugin requires [GamiPress - Leaderboards](https://gamipress.com/add-ons/gamipress-leaderboards/ "GamiPress - Leaderboards") add-on.

== Installation ==

= From WordPress backend =

1. Navigate to Plugins -> Add new.
2. Click the button "Upload Plugin" next to "Add plugins" title.
3. Upload the downloaded zip file and activate it.

= Direct upload =

1. Upload the downloaded zip file into your `wp-content/plugins/` folder.
2. Unzip the uploaded zip file.
3. Navigate to Plugins menu on your WordPress admin area.
4. Activate this plugin.

== Frequently Asked Questions ==

= Which attributes support [gamipress_learndash_user_groups_leaderboards] shortcode? =

[gamipress_learndash_user_groups_leaderboards] shortcode supports:

* current_user: Show groups leaderboards of the current logged in user. Accepts yes or no, by default yes.
* user_id: Show groups leaderboards of a specific user.
* exclude_groups: Comma-separated list of groups ids you want to exclude to being rendered.
* exclude_leaderboards: Comma-separated list of leaderboards ids you want to exclude to being rendered.
* excerpt: Display the leaderboard short description.
* search: Display a search input (per leaderboard).
* sort: Enable live column sorting (per leaderboard).
* hide_admins: Hide website administrators.

Example: ``[gamipress_learndash_user_groups_leaderboards current_user="yes" exclude_groups="1,2,3" exclude_leaderboards="4,5,6" excerpt="yes" search="yes" sort="yes" hide_admins="yes"]``

= How can I configure the Leaderboard display? =

After installing GamiPress - LearnDash Group Leaderboard, you will find the plugin settings on your WordPress admin area navigating to the GamiPress menu -> Settings -> Add-ons tab at box named "LearnDash Group Leaderboard".

Just choose the settings you want and click the "Save Settings" button.

= Can I regenerate all group's leaderboards? =

Of course, on your WordPress admin area, navigate to the GamiPress menu -> Settings -> Add-ons tab at box named "LearnDash Group Leaderboard" where you will find at bottom of this box a button named "Regenerate Group's Leaderboards".

Simply, click this button to run a safe process that will regenerate the leaderboards to groups that hasn't one.

Note: This is a safe process, so clicking multiples times won't make any data lost. Process will run just on groups that haven't assigned a leaderboard yet.

== Screenshots ==

== Changelog ==

= 1.1.2 =

* **Bug Fixes**
* Fixed incorrect application for the number of users and users per page settings.

= 1.1.1 =

* **Bug Fixes**
* Fixed incorrect application for the number of users setting (requires Leaderboards 1.3.0).

= 1.1.0 =

* **Improvements**
* Added extra checks to only run plugin code if Leaderboards add-on is installed.

= 1.0.9 =

* **New Features**
* Added support to Leaderboards add-on pagination.

= 1.0.8 =

* **Improvements**
* Updated deprecated jQuery functions.

= 1.0.7 =

* **New Features**
* Added a new option to limit the number of group members to display.
* **Improvements**
* Make period fields as text to allow more flexible period options.

= 1.0.6 =

* **Improvements**
* Added some extra checks to prevent incorrect group members conditionals on leaderboards query.

= 1.0.5 =

* **New Features**
* Added support to Leaderboards time period features (released on 1.1.5).
* **Developer Notes**
* Better organization of plugin functions reducing plugin code.

= 1.0.4 =

* **Bug Fixes**
* Prevent to let LearnDash use a cached result of group's users.

= 1.0.3 =

* **New Features**
* Added block, shortcode and widget to render specific or current user's groups leaderboards.
* **Improvements**
* Keep leaderboard title updated with group title in order to avoid "auto draft" titles.

= 1.0.2 =

* **New Features**
* Added the "Regenerate Group's Leaderboards" process on add-on settings box (located at GamiPress -> Settings -> Add-ons).

= 1.0.1 =

* **Bug Fixes**
* Fixed wrong method call on plugin activation by checking if method exists.

= 1.0.0 =

* Initial release.
