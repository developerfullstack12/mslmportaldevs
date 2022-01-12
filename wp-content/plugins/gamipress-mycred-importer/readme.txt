=== GamiPress - myCRED Importer ===
Contributors: gamipress, tsunoa, rubengc, eneribs
Tags: mycred, gamipress, gamification, points, credits, achievements, ranks, badges, awards, rewards, engagement, migration, import, importer
Requires at least: 4.4
Tested up to: 5.8
Stable tag: 1.1.0
License: GNU AGPLv3
License URI:  http://www.gnu.org/licenses/agpl-3.0.html

Tool to migrate all stored data from myCRED to GamiPress

== Description ==

GamiPress - myCRED Importer let's you migrate all data from myCRED to [GamiPress](https://wordpress.org/plugins/gamipress/ "GamiPress")!

= Features =

* Ability to move myCRED points types to GamiPress points type.
* Ability to move myCRED badges to any GamiPress achievement type.
* Ability to move myCRED ranks to any GamiPress rank type.
* Ability to reassign all myCRED user earned points/badges/ranks to GamiPress user earnings.
* Ability to move myCRED logs to GamiPress logs.

= myCRED integrations support =

* Support for myCRED BuddyPress activity to be imported to [GamiPress - BuddyPress integration](https://wordpress.org/plugins/gamipress-buddypress-integration/).
* Support for myCRED bbPress activity to be imported to [GamiPress - bbPress integration](https://wordpress.org/plugins/gamipress-bbpress-integration/).
* Support for myCRED Contact Form 7 activity to be imported to [GamiPress - Contact Form 7 integration](https://wordpress.org/plugins/gamipress-contact-form-7-integration/).
* Support for myCRED Gravity Forms activity to be imported to [GamiPress - Gravity Forms integration](https://wordpress.org/plugins/gamipress-gravity-forms-integration/).
* Support for myCRED AffiliateWP activity to be imported to [GamiPress - AffiliateWP integration](https://wordpress.org/plugins/gamipress-affiliatewp-integration/).
* Support for myCRED LearnDash activity to be imported to [GamiPress - LearnDash integration](https://wordpress.org/plugins/gamipress-learndash-integration/).
* Support for myCRED WooCommerce activity to be imported to [GamiPress - WooCommerce integration](https://wordpress.org/plugins/gamipress-woocommerce-integration/).

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

= How to import your data? =

1. Navigate to WP Admin area -> GamiPress -> Tools -> Import/Export tab.
2. At box "myCRED Importer" you will find settings to set to which achievement types, points types and rank types migrate every group of data.
3. Click the button "Start Importing Data" and wait until process gets finished.
4. That's all!

== Screenshots ==

== Changelog ==

= 1.1.0 =

* **Improvements**
* Javascript files updated to match with latest changes.

= 1.0.9 =

* **Improvements**
* Updated code to support MyCred latest changes.
* Removed old backward compatibility code.

= 1.0.8 =

* **Improvements**
* Updated code to support MyCred latest changes.

= 1.0.7 =

* **Improvements**
* Updated deprecated jQuery functions.

= 1.0.6 =

* Added support to GamiPress 1.5.1 relationships since P2P has been deprecated.

= 1.0.5 =

* Added support to GamiPress 1.5.1 logs database changes.

= 1.0.4 =

* Added extra checks to meet if MyCRED badges and ranks modules has been enabled.
* Added checks to meet if MyCRED is installed.

= 1.0.3 =

* Added support to GamiPress 1.4.3 and 1.4.7 database upgrades.

= 1.0.2 =

* Added the ability to select import achievements and ranks.
* Improvements migrating records on multisite installs.

= 1.0.1 =

* Added the ability to select import user earnings and logs.
* Added the ability to keep the imported points balance instead of sum them to the current points balance.
* Improvements migrating large amounts of records.

= 1.0.0 =

* Initial release.
