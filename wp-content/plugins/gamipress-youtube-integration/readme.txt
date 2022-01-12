=== GamiPress - Youtube integration ===
Contributors: gamipress, tsunoa, rubengc, eneribs
Tags: youtube, video, gamipress, gamification, points, achievements, badges, awards, rewards, credits, engagement, play, watch, player
Requires at least: 4.4
Tested up to: 5.8
Stable tag: 1.0.7
License: GNU AGPLv3
License URI:  http://www.gnu.org/licenses/agpl-3.0.html

Connect GamiPress with Youtube

== Description ==

GamiPress - Youtube integration let's you add activity triggers based on Youtube video interaction adding new activity events on [GamiPress](https://wordpress.org/plugins/gamipress/ "GamiPress")!

= Watch a demo =

https://youtu.be/AG-f0Uv5_WM

= New Events =

* Watch any video: When an user watches any youtube video.
* Watch a specific video: When an user watches a specific youtube video.

Important: The unique Youtube videos that trigger this activities are the videos placed through GamiPress: Youtube block, [gamipress_youtube] shortcode and GamiPress: Youtube widget.

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

== Screenshots ==

== Frequently Asked Questions ==

= Which attributes support [gamipress_youtube] shortcode? =

[gamipress_youtube] shortcode supports:

* url: The Youtube video URL or ID.
* width: The player width (in pixels). By default, 640.
* height: The player height (in pixels). By default, 360.
* autoplay: Option to automatically play the video. Accepts "yes" or "no", by default "no".
* controls: Option to enable or disable player controls. Accepts "yes" or "no", by default "yes".

Example with video URL:
``[gamipress_youtube url="https://www.youtube.com/watch?v=72xdCU__XCk" width="640" height="360" autoplay="no" controls="yes"]``
Example with video ID:
``[gamipress_youtube url="72xdCU__XCk" width="640" height="360" autoplay="no" controls="yes"]``

= Can this plugin work with Youtube videos embedded in other way? =

No, is required that videos are placed through the provided block, shortcode or widget to let the plugin detect when an user interacts with them.

== Changelog ==

= 1.0.7 =

* **Improvements**
* Ensure to only display the preview on the blocks editor area.

= 1.0.6 =

* **Improvements**
* Ensure to only display the preview when its available.

= 1.0.5 =

* **Improvements**
* Added preview on the block editor area.

= 1.0.4 =

* **Bug Fixes**
* Fixed incorrect event count for watch a specific video event.

= 1.0.3 =

* **Bug Fixes**
* Fixed an incorrect check that causes multiples video watches not trigger the watch a video event.
* **Developer Notes**
* Added a filter to modify the video allowed delay (by default of 1 second).

= 1.0.2 =

* **Improvements**
* Improved watched time detection when video gets paused.

= 1.0.1 =

* **Improvements**
* Added the ability to correctly handle events when multiple videos get played at same time.
* Improved watched time detection when video gets paused.

= 1.0.0 =

* Initial release.
