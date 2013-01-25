=== simplecatch ===
* by the Catch Themes team, http://catchthemes.com/

== ABOUT Simple Catch==
Simple Catch is a Simple and Clean WordPress Theme by Catch Themes. Easy Customize through Theme Options and Custom Widgets. Features: Custom Menu, Custom Widgets, Three Custom Layouts, Featured Slider, Theme Options (Header Logo, Footer Logo, Fav Icon, Social Icons, Custom CSS Styles, Webmaster Tools)  and Support for popular plugins (Breadcrumb NavXT, Contact Form 7, WP-PageNavi, WP Page Numbers). It is based on popular 978 Grid System CSS Framework. Multilingual Ready (WPML) and also currently translated in Polish and Russian.

== UPGRADE to Simple Catch Pro ==
Simple Catch Pro is an advance version of our popular theme Simple Catch. It is based on HTML5, CSS3 and Responsive Web Design to view in various devices. Some of the additional features includes: Featured Image Slider, Responsive Design, Additional Layout Options, Custom Footer Editor, and Adspace Widget for Advertisement.

== Translation ==
Simple Catch theme is translation ready. 
Added Translation for Polish by Piotrek Jas (fansitejustgames@gmail.com)
Added Translation for Russian by  Alexey Kurpachev (kurpachev@gmail.com)

== Features ==  
Featured Image Slider, Custom Drop-down Menu, Theme Options, Custom Widgets, flexible position of sidebar and Support for popular plugins.

== Tags ==

Tags Used: black, gray, silver, white, light, one-column, two-columns, left-sidebar, right-sidebar, fixed-width, custom-menu, featured-images, full-width-template, theme-options, threaded-comments, translation-ready

== Installation ==

1. Primary: 
 = Login to your wp-admin area and go to Appearance -> Themes. 
 = Select Install tab and click on Upload link. 
 = Select theme .zip and click on Install now button. 
 = If you have any errors, use alternate method.

2. Alternate: 
 = Unzip the template file (simplecatch.zip) that you have downloaded. 
 = Via FTP, upload the whole folder (simplecatch) to your server and place it in the /wp-content/themes/ folder. 
 = Do not change directory name. 
 = The template files should thus be here now: /wp-content/themes/simplecatch/index.php (for example).

3. Log into your WP admin panel and click on the Design tab. 
4. Now click on the simplecatch theme to activate it.
5. Complete all of the required inputs on the simplecatch Options page (in the WP admin panel) and click "Save Changes".

== Changelog ==
Version 1.2.1
* Fixed the Slider Image Link
* Modified the Continue Reading Link
* Added Social Icons for Pinterest and Google+
* Added CSS to Support WP-PageNavi and Contact Form 7 Plugins

Version 1.2.2
* Fixed css for Pinterest

Version 1.2.3
* Fixed css for alignment and footer clear
* Fixed the layout and css for error404 page
* Change the Heading from H1 to h2 class entry title 
* Remove title modification from header.php and added function simplecatch_filter_wp_title() to filter the wp_title
* Added Enqueue Comment Reply Script in function simplecatch_enqueue_comment_reply_script and removed it from header
* Added Social Icons for Linkedin, Slideshare, Foursquare, Vimeo, Flickr, Tumblr, DeviantArt,  Dribbble, MySpace and WordPress
* Added Custom CSS Styles option in Theme Options
* Added Webmaster Tools and verification of Google, Yahoo and Bing
Version 1.2.4
* Fixed the action hook for simplecatch_haedercode to simplecatch_footercode
Version 1.2.5
* Cleaned and Fixed the theme_options.php
* Cleaned and Fixed the Simplecatch_functins.php
* Added Social Icons for Delicious and Last.fm
Version 1.2.6
* Fixed CSS for Dropdown menu height to accept longer titles
* Added Layout Options under Theme Options 
* Added more slider options under Slider Options

Version 1.2.7
* Cleaned and arranging simpecatch_functions.php
* Cleaned and fixing searchform.php
* Cleaned Header.php file
* Fixed slider to make compatible with ie7 and ie8
* Fixed css to make compatible with ie8
* Fixed image.php file
* ul,next and previous bullet changed from jpg image format to png image format

Version 1.2.8
* Added option in Featured Slider to Exclude Slider Posts from Homepage.
* Cleaned simplecatch_functions.php file.
* Cleaned searchform.php file.
* Fixed Layout settings of theme option.

Version 1.2.9
* Cleaned simplecatch_functions.php file.
* Removed the inline script from searchform.php
* Theme options are saved in single option array from multiple options array
* Unwanted wp_query removed and instead used pre_get_posts hook to alter main loop in homepage

Version 1.3.0
* Added Theme Option array Backward Compatibility for SimpleCatch version 1.2.7 and below

Version 1.3.1
* Added option to show posts from only selected category in homepage.
* Added option to disable site title and site description

Version 1.3.1.1
* Fixed logo condition in simplecatch_headerdetails() function

Version 1.3.1.2
* Fixed Link for logo and site title in simplecatch_headerdetails() function 

Version 1.3.2
* Added sidebar layout option metabox in post and page
* Added default sidebar layout option in Theme options.
* Fixed the issue of Dual title in feed
* Fixed the site verification, site title, Description caching issue
* Fixed the css issue for search title

Version 1.3.3
* Added Excerpt Length option to alter the excerpt length in Layout Settings.
* Fixed content.php file.
* Used get_option( 'date_format' ) rather than hardcoding format.
* Made Post author link prefix translation ready.
* Changing the key name for post custom metadata i.e. 'Sidebar-layout' keyname changed to 'simplecatch-sidebarlayout'.

Version 1.3.4
* Initialized all theme options variables and created simplecatch_themeoptions_defaults.php file.
* Fixed add_image_scripts.js
* Stored all theme options variables in a global variable and used it instead of get_option.
* Change stylesheet URL to get_stylesheet_uri()
* Added simplecatch.pot file to make theme translation ready

Version 1.3.5
* Changed theme options user interface design.
* Added Toggle effect on Theme Options. Added admin_js file for the toggle effect.
* Larger size js file(jquery.cycle.all.min.js) are minified.

Version 1.3.5.1
* Adding back missing tanslation ready file in function

Version 1.3.5.2
* Updated FAQ in Theme Options
* Fixed Theme Option Data Validation for html special character &rarr; in continue reading. This fixed the problem in the server where Theme Option was not being saved.
* Fixed Slider loading issue and display overlap 
* Added un-minified version of JS as per GPL
* Updated simplecatch.pot file

Version 1.3.5.3
* Fixed css for Title
* Fixed css for input fields in sidebar
* Fixing textdomain in theme option
* Replace wp_print_styles to wp_enqueue_scripts

Version 1.3.5.4
* Fixed pagination float issue
* Added pagination in page
* Added Support for Captcha Plugin
* Replaced get_stylesheet_directory_uri to get_template_directory_uri

Version 1.3.6
* Added Content Color Option
* Added Custom Background

Version 1.4
* Added Feed Redirect Option in Theme Options
* Added more FAQ
* Change the Settings in Theme Options

Version 1.4.1
* Fixing Color Options

Version 1.4.2
* Changed Theme URI to match with the new theme site
* Change the license to GPL 2
* Added Info bar in Theme Option Panel
* Fixed Slider Initialization 

Version 1.4.3
* Fixed textdomain in Info Bar
* Fixed float issue of Static home page.
* Fixed footer code
* Fixed site title though changes in wp_title and catchbox_filter_wp_title function

Version 1.4.4
* Update the Add Image Script
* Fixed layout issue with the attachments

Version 1.4.5
* Fixed Theme Option issue with Facebook and Twitter Like

Version 1.4.6
* Fixed the typo for All Rights Reserved

Version 1.4.7
* Fixed menu highlight for current menu
* Added Polish translation pl_PL.po and pl_PL.mo

Version 1.4.8
* Fixed simplecatch.pot file for comment form labels

Version 1.4.9
* Improving Theme Options data validation

Version 1.4.9.1
* Fixed CSS Pagination with WP-PageNavi and WP Page Numbers Plugins
* Fixed CSS for default textarea

Version 1.5
* Added Russian translation ru_RU.po and ru_RU.mo
* Added Word Wrap for commentlist in style.css

