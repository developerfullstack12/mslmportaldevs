=== H5P for LearnDash ===
Requires at least: 5.0
Requires PHP: 5.6.20
Tested up to: 5.5
License: GPLv2 or later

H5P Interactions Control Progress in LearnDash Without an LRS.

== Description ==
The 'H5P for LearnDash' plugin does support all H5P content types which DO IMPLEMENT xAPI.

In order to take advantage of this plugin you should have good understanding of LearnDash and H5P functionality.
Refer to LearnDash and H5P documentation.
On how to test xAPI see: http://h5p.org/documentation/x-api.

The plugin does not alter the H5P content behaviours, scores etc.
Depending on H5P result success/failure plugin does control the LearnDash UI e.g. enable/disable the Lesson/Topic 'Mark Complete' button.
The H5P behaviour is configured when creating/editing the H5P content. The success/failure (pass/fail) conditions, user feedback etc. may varry depending on H5P content type.
The LearnDash Course Progression is configured when creating/editing the Course/Lesson/Topic.
The 'H5P for LearnDash' by any means does not alter configuration of H5P or LearnDash content.
In other words the plugin interprets H5P result in order to control LearnDash Course Progression.
Within this space (interpretation) the plugin allows to make some customizations, by means of use of using filter defined in the plugin.
Above requires programming knowledge and good understanding of xAPI event statement structure as well as LearnDash functionality.

In addition to above the 'H5P for LearnDash' provides shortcode which displays message based on H5P success/failure.
The text for the messages is configured in the 'H5P for LearnDash Settings' page.
The shortcode also allows to suppress 'ignore' the plugin controlling the LearnDash UI, on per H5P content bases.

== Integration of H5P into LearnDash Quiz Questions ==
The plugin will pass the H5P score (points) into LearnDash Quiz results.
The score and percentage depend on the H5P content which is used in the question(s). The LearnDash Question answer points depend on H5P content used.
The interpretation of the H5P scored points is done in LearnDash.
In other words the 'H5P for LearnDash' only passes the score returned from H5P interaction.

= Create Quiz question with H5P content =
- Add H5P shortcode into Question body. The H5P content type must support xAPI.
- For 'Answer type' select 'Assessment'. This will trigger the plugin's ability to pass the H5P score points into LearnDash quiz.
If you select any other type the 'H5P for LearnDash' plugin will not pass the H5P score.
- In 'Answers' field insert: { [1] } or any aphanumeric text.
The Answers are required (cannot be empty).
Do not worry about other settings since they will be propagated by the plugin the first time you run the Quiz.

== Installation ==
Download 'H5P for LearnDash' plugin zip file from http://elearningcomplete.com.
Refer to:
https://wordpress.org/support/article/managing-plugins/#manual-upload-via-wordpress-admin
