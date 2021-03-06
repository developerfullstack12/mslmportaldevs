=== RPB Chessboard ===
Contributors: yo35
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=YHNERW43QN49E
Tags: chess, chessboard, fen, pgn, games
Requires at least: 5.5
Tested up to: 5.8
Stable tag: trunk
License: GPLv3
License URI: http://www.gnu.org/licenses/gpl-3.0.html

This plugin allows you to typeset and display chess diagrams and PGN-encoded chess games.



== Description ==

RPB Chessboard allows you to typeset and display chess games and diagrams in the posts and pages of your WordPress blog, using the standard [FEN](https://en.wikipedia.org/wiki/Forsyth-Edwards_Notation) and [PGN](https://en.wikipedia.org/wiki/Portable_Game_Notation) notations.

= Links =

* [Ask for help or report a problem](https://github.com/yo35/rpb-chessboard/issues)
* [Live demo](https://rpb-chessboard.yo35.org/)
* [Source code (GitHub repository)](https://github.com/yo35/rpb-chessboard)

= Features =

 * Customizable aspect for the chessboards (orientation, size, etc...).
 * Support comments and sub-variations in PGN-encoded games.
 * Support HTML formatting in PGN comments.
 * Support several chess variants:
   - [Chess960](https://en.wikipedia.org/wiki/Chess960) (also known as Fischer Random Chess).
   - [Antichess](https://en.wikipedia.org/wiki/Losing_chess).
   - [Horde chess](https://en.wikipedia.org/wiki/Dunsany%27s_chess#Horde_chess).
 * Colored square and arrow markers.
 * Compatibility mode to avoid conflicts with the other plugins that use the `[fen][/fen]` and `[pgn][/pgn]` shortcodes too.
 * Upload PGN files and load PGN data from a URL.
 * Diagram block with its editor embedded in the WordPress post/page editor.
 * Multi-language support.

If you encounter some bugs with this plugin, or if you wish to get new features in the future versions, you can report/propose them in the [GitHub bug tracker](https://github.com/yo35/rpb-chessboard/issues).

If you are interested in translating this plugin into your language, please [contact the author](mailto:yo35@melix.net).

Custom developments in relation with RPB Chessboard (e.g. specific feature, advanced customization...) can be realized by the author as a paid service. If you need to have such custom developments for your website, please feel free to [contact the author](mailto:yo35@melix.net).



== Installation ==

1. Download [rpb-chessboard.zip](http://downloads.wordpress.org/plugin/rpb-chessboard.zip) and upload its content to the `/wp-content/plugins/` directory of your website.
2. Activate the plugin through the *Plugins* menu in WordPress.
3. You are now able to put `[fen][/fen]` and `[pgn][/pgn]` tags in your posts and pages to insert chess diagrams and full chess games. Please look at the *Chess* > *Memo* menu (created by the plugin) for examples of how to use these tags.

For extensive details about plugin installation and management, please have a look to the general [plugin management page](http://codex.wordpress.org/Managing_Plugins).



== Frequently Asked Questions ==

= How to find help? =

First, **look at the plugin help page**. This help page is available in the administration section of your WordPress website: in the main navigation menu > *Chess* > *Help*. If no answer can be found there, ask your question on [this forum](https://github.com/yo35/rpb-chessboard/issues).

= I encounter a bug, or I think the plugin misses a key feature... =

Please expose your case on [the forum](https://github.com/yo35/rpb-chessboard/issues)! Usually, bugs get fixed very quickly after being reported. Feature requests are discussed, and then implemented if relevant.

= The plugin is not available in my language, I want to translate it. =

Please [contact the author](mailto:yo35@melix.net) for this.



== Screenshots ==

1. Typesetting and rendering a chess diagram.
2. Typesetting and rendering a chess game with comments and sub-variations.
3. Chess diagram in a post with the Twenty Ten theme.
4. Chess game in a post with the Twenty Ten theme.
5. When clicking on a move, a popup frame is displayed, showing the corresponding position.
6. A navigation board can be added near the move list.
7. Chess game with comments and sub-variations. HTML formatting in text comments is supported.
8. Diagram block with its editor embedded in the WordPress post/page editor.



== Changelog ==

= 6.4.0 (October 22, 2021) =
* Add square annotations plus/times/dot/circle (see #218).

= 6.3.0 (September 27, 2021) =
* Add support for [Horde chess](https://en.wikipedia.org/wiki/Dunsany%27s_chess#Horde_chess) (see #167).

= 6.2.2 (September 19, 2021) =
* Cleanup and upgrade dependencies.

= 6.2.1 (August 15, 2021) =
* Support castling moves encoded with zeros (see #142).

= 6.2.0 (July 25, 2021) =
* Add support for [Antichess](https://en.wikipedia.org/wiki/Losing_chess) (see #187).

= 6.1.0 (June 26, 2021) =
* Add text field to allow copy/paste FEN in the diagram editor (see #211).

= 6.0.2 (June 6, 2021) =
* Fix navigation board size issue in popup frame on small-screen devices (see #208).

= 6.0.1 (May 30, 2021) =
* Fix plugin crash encountered with old PHP versions (before PHP 7.3).

= 6.0.0 (May 30, 2021) =
* Add chess diagram block with its editor to the Gutenberg-based WordPress page/post editor.
* Drop support for the old TinyMCE-based WordPress page/post editor.
* Significant code refactoring of the chess diagram widget, which is now released as a standalone NPM library (kokopu-react).

= 5.9.3 (May 17, 2021) =
* Tested up to WordPress 5.7.
* Italian translation (thanks to Andrea Cuccarini).

= 5.9.2 (February 6, 2021) =
* Rollback square marker rendering to plain square (as it used to be until version 5.9.0).

= 5.9.1 (January 10, 2021) =
* Render square markers with a plain circle.

= 5.9.0 (January 3, 2021) =
* Tested up to WordPress 5.6.
* Enable arrow/square marker color customization (see #190).
* Implement square annotation with letter/digit (see #192).
* Fix alignment issue with float-right navigation board (see #191).

= 5.8.1 (November 18, 2020) =
* Fix arrow tip issue (see #185).

= 5.8.0 (August 22, 2020) =
* Tested up to WordPress 5.5.
* Handle games with no king (see #171).

= 5.7.1 (July 30, 2020) =
* Brazilian Portuguese translation (thanks to Rewbenio Frota).

= 5.7.0 (June 20, 2020) =
* Tested up to WordPress 5.4.
* Implement lazy-loading for CSS assets (see #135) and introduce a compatibility option to disable this feature.

= 5.6.9 (February 9, 2020) =
* Fix some typos in the Spanish translation.

= 5.6.8 (February 1, 2020) =
* Fix some typos in the Spanish translation.

= 5.6.7 (February 1, 2020) =
* Spanish translation (thanks to Martin Frith).

= 5.6.6 (December 22, 2019) =
* Fix annotation arrows (regression from 5.6.5).

= 5.6.5 (December 20, 2019) =
* Improve PGN parsing robustness to linebreak issues (see #155).

= 5.6.4 (November 24, 2019) =
* Tested up to WordPress 5.3.
* Czech translation for frontend (thanks to Jan Jilek).

= 5.6.3 (June 8, 2019) =
* Fix corner case issues occurring in PGN parsing.

= 5.6.2 (May 13, 2019) =
* Tested up to WordPress 5.2.
* Fix diagrams/games not rendered with themes that do no include jQuery by default (see #154).

= 5.6.1 (April 21, 2019) =
* Fix disambiguation issue on rook move (see #153).

= 5.6 (April 20, 2019) =
* Fix PGN parsing error encountered with lichess syntax for %csl/%cal (see #151).
* Add support for advanced NAGs (see #152).

= 5.5.3 (March 23, 2019) =
* Fix PGN parsing error encountered with games downloaded from lichess.org (see #149).

= 5.5.2 (March 10, 2019) =
* Fix PGN parsing issue (see #146).

= 5.5.1 (February 23, 2019) =
* Tested up to WordPress 5.1.
* Lazy-loading of CSS assets does not work with some themes (see #145): revert this feature.

= 5.5 (February 9, 2019) =
* Load CSS/JS assets only when necessary in the frontend (see #135).

= 5.4.4 (January 1, 2019) =
* Tested up to WordPress 5.0.
* Code cleanup.

= 5.4.3 (October 27, 2018) =
* Fix (again) page/post rendering for Gutenberg (see #137).

= 5.4.2 (August 25, 2018) =
* Fix scroll area sizing in hidden chessgames (see #141).

= 5.4.1 (August 12, 2018) =
* Fix animation issue occurring on small-screen devices (see #136).
* Fix page/post rendering for Gutenberg (see #137).
* Fix diagrams not working in Chess960 games (see #138).

= 5.4 (July 22, 2018) =
* Add support for [Chess960](https://en.wikipedia.org/wiki/Chess960), aka. Fischer Random Chess (see #15).

= 5.3.3 (July 9, 2018) =
* Fix invalid move notation issue (see #134).

= 5.3.2 (July 8, 2018) =
* Fix security issue (see #133).

= 5.3.1 (July 7, 2018) =
* Fix security issue (see #132).

= 5.3 (May 26, 2018) =
* Fix diagram issues (see #130 and #131): `[pgndiagram]` is no-longer available. From now on, the standard `[#]` should be used instead.
* Fix security issue (see #122): refactor DOM building process and set-up proper HTML sanitization where needed.
* Refactor move generation/validation + PGN parsing code as a standalone NPM library (Kokopu).

= 5.2.2 (May 1, 2018) =
* Fix page jump issue (see #129).

= 5.2.1 (April 8, 2018) =
* Fix scrolling issue (see #128).

= 5.2 (April 2, 2018) =
* Fix several code security issues (see #116, #117, #118, #119, #120 and #121).
* Image size optimization.
* IE 8 not supported anymore.

= 5.1.6 (January 7, 2018) =
* Fix scrolling issue (see #111).
* Enforce WP coding conventions and code cleanup.
* Chess font size optimization.

= 5.1.5 (January 1, 2018) =
* Fix several issues affecting mobile devices (see #101, #104 and #105).

= 5.1.4 (December 3, 2017) =
* Add the "Fix jQuery's buttons" option as a workaround for conflicts with Bootstrap-based plugins and themes.

= 5.1.3 (November 26, 2017) =
* Tested up to WordPress 4.9.
* Fix scrollLeft/scrollRight rendering on small-screen devices (see #101).

= 5.1.2 (October 26, 2017) =
* Fix missing jQuery dependencies (possible cause of #99).

= 5.1.1 (October 15, 2017) =
* Fix browser-related issue with the keyboard shortcut feature.

= 5.1 (October 15, 2017) =
* Add keyboard shortcuts on the navigation board (see #48).
* Add a "Donate" button.

= 5.0.1 (October 14, 2017) =
* Change the text domain to comply with WP.org recommendations.

= 5.0 (July 9, 2017) =
* Tested up to WordPress 4.8.
* Allow navigation board flipping (see #70).
* Add a button to let readers download PGN data (see #78).
* Refactor file and CSS class naming.
* Improve memo/help pages to take into account theming and default settings.

= 4.8.1 (April 23, 2017) =
* Workaround so that FEN works within bbPress content.

= 4.8 (April 23, 2017) =
* Allow left/right alignment for diagrams (see #81).
* Minor fixes.

= 4.7 (January 16, 2017) =
* Enable .pgn file uploading.
* Loading PGN data from a URL (see #50).

= 4.6.2 (January 2, 2017) =
* Tested up to WordPress 4.7.
* Fix arrow refresh issue (see #76).

= 4.6.1 (November 12, 2016) =
* Russian translation (thanks to Sergey Baravicov).

= 4.6 (November 6, 2016) =
* Add scrollLeft/scrollRight positions for the navigation board.

= 4.5 (October 15, 2016) =
* Add theming feature.

= 4.4 (August 31, 2016) =
* Tested up to WordPress 4.6.
* Add keyboard shortcuts to the FEN editor (see #67).

= 4.3.3 (August 7, 2016) =
* Fix animation not working when clicking on text moves (see #68).

= 4.3.2 (July 3, 2016) =
* Fix wrong colorset/pieceset parameters in navigation frame (see #66).

= 4.3.1 (June 16, 2016) =
* Tested up to WordPress 4.5.
* Minor fixes.

= 4.3 (March 10, 2016) =
* Add colorset and pieceset customization parameters (see #13 and #29).

= 4.2.3 (January 21, 2016) =
* Fix PGN parsing issue (see #53).

= 4.2.2 (December 20, 2015) =
* Tested up to WordPress 4.4.
* Add cache for dynamic CSS.

= 4.2.1 (November 22, 2015) =
* Fix rendering of NAG $11 (see #51).

= 4.2 (November 15, 2015) =
* Add move animation and highlighting (see #39).
* Refactor organization of PHP classes.

= 4.1.4 (September 2, 2015) =
* Tested up to WordPress 4.3.
* Turkish translation (thanks to Ali Nihat Yaz??c??).

= 4.1.3 (August 15, 2015) =
* Fix click-on-image-not-working issue in IE (see #43).

= 4.1.2 (August 1, 2015) =
* Fix arrow-head issue in Chrome (see #40).

= 4.1.1 (July 27, 2015) =
* Fix small-screen related issue (see #41).
* Fix navigation frame sizing issue occurring with some themes.

= 4.1 (July 7, 2015) =
* Add: option to get navigation board above/below the move list.

= 4.0.2 (June 17, 2015) =
* Fix syntax issue.

= 4.0.1 (June 17, 2015) =
* Fix compatibility issue with PHP <= 5.3 (see issue #37).
* Force JS/CSS file reloading each time the version of the plugin changes.

= 4.0 (June 6, 2015) =
* Add support for square highlights and arrow (see issue #27).
* Refactor the help pages.

= 3.6.2 (April 26, 2015) =
* Tested up to WordPress 4.2.
* Add help on null moves.

= 3.6.1 (April 18, 2015) =
* Null-move support (see issue #35).

= 3.6 (March 29, 2015) =
* Significant code refactoring of the JavaScript chess library: do not use chess.js anymore.
* Improve FEN/PGN parsing error messages (see issue #11).

= 3.5.1 (March 15, 2015) =
* Fix: make `flip` attribute work on tag `[pgndiagram]` (see issue #32).

= 3.5 (February 22, 2015) =
* Add options to customize chessboard appearance on small-screen devices (see issue #26).

= 3.4.3 (January 26, 2015) =
* Tested up to WordPress 4.1.
* Add: scroll the document to the selected move if it is not visible (see issue #28).

= 3.4.2 (November 23, 2014) =
* Sprite system refactoring to allow responsive web design (see issue #26).
* Fix file-collapse issue (see #25).

= 3.4.1 (November 17, 2014) =
* Fix localization not working on frontend.

= 3.4 (October 26, 2014) =
* Refactor edit-FEN dialog and make it available in TinyMCE editor.

= 3.3 (September 6, 2014) =
* Tested up to WordPress 4.0.
* Dutch translation (thanks to Ivan Deceuninck).
* Minor fixes.

= 3.2.3 (August 30, 2014) =
* Fix issue with occurring with `[pgn][/pgn]` tags in non-post/page contexts.

= 3.2.2 (August 30, 2014) =
* Fix issue with occurring with `[fen][/fen]` tags in non-post/page contexts.

= 3.2.1 (August 26, 2014) =
* Fix plugin set-up for non-standard WordPress install configurations.

= 3.2 (August 13, 2014) =
* Improve date rendering and localization.
* Minor fixes.

= 3.1 (July 27, 2014) =
* Polish translation (thanks to Dawid Zi????kowski).
* Minor fixes.

= 3.0 (July 14, 2014) =
* Add: cancel/reset buttons in the setting pages.
* Minor fixes.

= 2.99.1 (June 27, 2014) =
* Fix compatibility issue with PHP <= 5.2.
* CSS classes for light- and dark-squares (see issue #13).

= 2.99 (June 16, 2014) =
* Add: piece symbol customization.
* Add: navigation board next to the move list (not only in a popup frame).
* Fix several bugs related to PGN game parsing and rendering.
* Code refactoring (use the jQuery widget framework for PGN rendering in particular).
* Provide minified versions of the JS scripts.

= 2.4.3 (May 12, 2014) =
* Plugin icon & banner.

= 2.4.2 (May 10, 2014) =
* Update the documentation and add links toward Yo35.org.

= 2.4.1 (April 30, 2014) =
* Improve code robustness with respect to dynamically loaded content (e.g. through AJAX requests).

= 2.4 (April 26, 2014) =
* German translation (thanks to mliebelt).
* Fix browser compatibility issue (bug with the FEN dialog, reported as issue #5).
* PHP code refactoring (backend).

= 2.3.2 (April 19, 2014) =
* Tested up to WordPress 3.9.
* Minor code cleaning.

= 2.3.1 (April 4, 2014) =
* Fix warnings issued by WP in debug mode.

= 2.3 (March 16, 2014) =
* Dialog to create/edit FEN chess diagrams in the text editor.

= 2.2.2 (March 13, 2014) =
* Improve compatibility with IE <= 10.

= 2.2.1 (February 16, 2014) =
* Fix parsing bug (castle moves with check, reported as issue #3).

= 2.2 (February 16, 2014) =
* Faster rendering of the chess diagrams.

= 2.1 (January 3, 2014) =
* Compatibility mode to avoid conflicts with other plugins that might use the `[fen][/fen]` and `[pgn][/pgn]` shortcodes.

= 2.0.1 (December 13, 2013) =
* Tested up to WordPress 3.8.

= 2.0 (November 10, 2013) =
* Add: flip attribute (to change the orientation of the chessboards).
* Auto-size the chessboard in the navigation frame generated with `[pgn][/pgn]`.

= 1.99.6 (November 4, 2013) =
* Documentation for the PGN tag.

= 1.99.5 (November 2, 2013) =
* Fix issue #1.
* Documentation for the FEN tag.

= 1.99.4 (November 2, 2013) =
* Clean the credits page in the backend.
* Fix: missing theming for the jQuery widgets in the backend.

= 1.99.3 (November 1, 2013) =
* Fix: use the WP theming for jQuery dialogs to avoid conflicts between CSS.

= 1.99.2 (October 31, 2013) =
* Fix: rpbchessboard.php is renamed as rpb-chessboard.php (allocated slug name on the WP repository).

= 1.99.1 (October 31, 2013) =
* First public version.



== Credits ==

= Author =

Yoann Le Montagner

= Contributors =

Marek ??migielski, [Paul Schreiber](https://paulschreiber.com/), [Adam Silverstein](http://www.10up.com/)

= Translators =

Jan J??lek (Czech), Markus Liebelt (German), Yoann Le Montagner (English and French), Martin Frith (Spanish), Andrea Cuccarini (Italian), Ivan Deceuninck (Dutch), [Dawid Zi????kowski](http://dawidziolkowski.com/) (Polish), [Rewbenio Frota](http://www.lancesqi.com.br/) (Brazilian Portuguese), [Sergey Baravicov](http://safoyeth.com/) (Russian), Ali Nihat Yaz??c?? (Turkish).

= Graphic resources =

Pieceset *CBurnett* has been created by [Colin M.L. Burnett](https://en.wikipedia.org/wiki/User:Cburnett), who shares it under the [CC-BY-SA] license on [Wikimedia Commons](https://commons.wikimedia.org/wiki/Category:SVG_chess_pieces); user [Antonsusi](https://commons.wikimedia.org/wiki/User:Antonsusi) has also contributed to this work. Piecesets *Celtic*, *Eyes*, *Fantasy*, *Skulls* and *Spatial* have been created by [Maurizio Monge](http://poisson.phc.dm.unipi.it/~monge/), who makes them freely available for chess programs. Colorsets *Coral*, *Dusk*, *Emerald*, *Marine*, *Sandcastle* and *Wheat* have been proposed in this [blog post](http://omgchess.blogspot.fr/2015/09/chess-board-color-schemes.html) by [Gorgonian](http://omgchess.blogspot.fr/). Icon *Tick* has been created by [Momentum Design Lab](http://momentumdesignlab.com/), who shares it under the [CC-BY] license on [Find Icons](http://findicons.com/pack/2226/matte_basic). Icon *Not-Found* has been created by [gakuseiSean](http://gakuseisean.deviantart.com/), who makes it freely available for non-commercial use on [Find Icons](http://findicons.com/icon/89623/error). Icon *Help* has been created by [Ruby Software](http://www.rubysoftware.nl/), who shares it as a freeware on [Find Icons](http://findicons.com/icon/26233/help).

The author would like to thank all these people for their highly valuable work.
