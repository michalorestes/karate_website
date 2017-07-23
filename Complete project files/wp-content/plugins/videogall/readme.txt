=== VideoGall ===
Contributors: Nischal Maniar
Tags: video, gallery, widget, youtube, metacafe, flv, vimeo, quicktime, ShadowBox
Requires at least: 2.1
Tested up to: 3.1
Stable tag: 2.1

An automatic video gallery of videos from any site with ShadowBox effect. Includes option to display images with ShadowBox effect.

== Description ==

Display a video gallery on your site. Add videos from different sites through the admin panel and get a beautiful video gallery with ShadowBox effect. Also available are options to edit or delete already added videos. Videos can be categorized and displayed according to their categories aswell. You can also add a videogall widget on sidebar. - Now supports pagination -
For more details, visit http://nischalmaniar.info/2010/05/videogall-plugin/

== Screenshots ==

1. Video Gallery
2. Video with shadowbox effect

== Installation ==

* Unzip the VideoGall plugin in the plugins folder in wp-content directory i.e `wp-content/plugins`.
* Go to your wordpress site admin and plugins section and activate the VideoGall plugin
* Go to settings --> VideoGall to set your options and add videos
* Add a new page or in an existing page, type following: [myvideogall:category-name]. E.g. [myvideogall:movies]. To display all videos, type [myvideogall:all]. Note: Category name is not case-sensitive.

== Other Notes ==

* You may want to deactivate any lightbox plugin you already have installed for your site incase the shadowbox doesn't work. Videogall can be used for images as well.
* VideoGall creates a table in your wordpress database and stores all information there
* If you want to customize the look of the gallery, make changes to the file (videogallstyle.css) inside the videoGall plugin folder
* You can now add categories to the videos and display videos based on categories.
* To add pagination, use the settings page and set the number of videos per page.
* If description is enabled and not all videos have description, then layout would be broken.

== Frequently Asked Questions ==

* Do I need to deactivate Lightbox plugin if I have installed one ? - MAYBE, Videos will work but images will be opened twice, one with lightbox and other with shadowbox if it is enabled for images as well. VideoGall can be used for images aswell.
* How do I change the look of the gallery ? - By making changes to the videogallstyle.css stylesheet
* Layout of videos is broker ? - Try playing around with the videos per row option

== ChangeLog ==

** Version 2.1 **

* Support for Blip.tv

** Version 2.0 **

* Added description field again, on popular demand
* Added option to set number of videos per row to avoid breaking of horizontal layout
* Fixed issue of unrecognizable URL, in which case, page will be redirected to that URL instead of shadowbox

** Version 1.9 **

* Fixed bug for creating tables for new users
* Added a fixed height for caption in order to preserve horizontal layout

** Version 1.8 **

* Changed the function names to avoid conflicts with other plugins

** Version 1.7 **

* Fixed issue with pagination

** Version 1.6 **

* Pagination feature added
* Limit number of videos in the sidebar widget
* Shadowbox effect available for images
* Removed description section
* Translation ready
* Bug fixes

** Version 1.5.5 **

* Sort videos by in order of ascending or descending
* Put videos on sidebar widget
* Fixed the issue with horizontal layout

** Version 1.5.3 **

* Sort videos by Caption, Date and Categories
* Option to display border around the video thumbnails

** Version 1.5.1 **

* Added code to ignore PHP warnings if argument is not passed to function

** Version 1.5 **

* Switched to ShadowBox instead of VidBox
* Now you can categorize your videos by adding categories and display your videos based on categories
* Removed the vertical style display. Only horizontal style display available
* Added a name field to the video entries. After the upgrade, existing videos will get the name "default"
* Each video can have a different size
* Shadowbox can be used for images as well

** Version 1.4 **

* Switched back to VideoBox instead of LightWindow
* Added option to enable videobox effect for images as well

** Version 1.3 **

* Fixed the issue of incorrect path of stylesheets and javascripts
* Added option to specify height and width of the video

** Version 1.2 **

* Modified the plugin to use LightWindow instead of VideoBox
* Updated to work with Wordpress 2.9.1

** Version 1.1 **

* Added option to show/hide date below videos. Updated to work with Wordpress 2.86

** Version 1.0 **

* Initial release of VideoGall plugin