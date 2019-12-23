=== Plugin Name ===
Contributors: 15km
Donate link: http://plugins.15kmtoexit.com/donate/
Tags: breakpoint, title, layout, markers, title manipulation
Requires at least: 3.0.1
Tested up to: 5.2.1
Stable tag: 2.0.7
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Lets you set breakpoints on your title for your posts, pages and custom post type pages without having to add html tags to the title in the textfield and currently only works with the Classic Editor plugin.

== Description ==

Lets you set breakpoints on your posts, pages and custom post types titles without having to add html to the title by setting markers in the title text field.

This allow for a better layout of the title on desktop version of the site and when on a mobile device it gives you the ability to remove the breakpoints by adjusting the CSS. Some of the other uses are that you can set multiple markers in the text field to highlight colours of certain words in the title.

== Installation ==

1. Upload the plugin files to the `/wp-content/plugins/page-title-splitter` directory, or install the plugin through the WordPress plugins screen directly.
2. Activate the plugin through the 'Plugins' screen in WordPress.
3. Use the Settings->Page Title Splitter screen to configure the plugin, if you would like to update any of the default CSS, default options for title manipulation or to see how to use the plugin.
4. The functionality for setting breakpoints will appear underneath the Post, Page or Custom Post Type of the titles on the site, click on the / button under the title text field off to the side and then click on a character where you would like the breakpoint to occur.


== Frequently Asked Questions ==

= How do I implement the title with markup into my site? =

The modified title can be show on the website by adding one of the functions to your source code. `the_split_title()` will print the title on the page and `get_split_title()` will allow you to store it in a variable or print it yourself.

= How do I use one of the functions outside the loop? =

A Post ID can be added to either function to show a title outside of the loop or on a different page, ex. `<?php the_split_title(12); ?>`.

= How do I add a breakpoint to my title? =

Go to either Add/Edit a Post, Page or Custom Post Type and you will find a grey bar underneath the title text field. To the left of that bar you will see a / button, once pressed this will add a marker at the start of the title. Now by clicking on a character in the title, the marker will move to that position and that is where the page break will occur in the title. You can add as many markers as needed to the title.

= How do I move a breakpoint marker in my title? =

Click on the marker that sits below the title text field, that marker will then highlight. Now you can click on a different character in the title text field that marker will move to that position.

= How do I delete a breakpoint marker in my title? =

Click on the marker that sits below the title text field, that marker will then highlight. If you look to the left of the grey bar underneath the text field you will see a “x”, if click on that button it will delete the marker.

= How do I cancel the highlight state on a marker? =

Click on the marker that is currently highlighted in the grey bar underneath the title text field and it will remove the highlighted state from the marker. This will allow you to select a different marker and not worry about it moving if you click on a character in the title text field.

== Screenshots ==

1. Clicking on the button to add a new breakpoint to the text field.
2. Placing a new breakpoint into the text field.
3. The page title with the breaks in place.
4. Settings page and instructions on how to use.

== Changelog ==

= 1.0 =
* plugin created and made live in the directory
= 1.0.5 =
* bug fixes
= 1.0.6 =
* icon update and removal of splitter from Custom Fields plugin
= 1.0.7 =
* bug fixes and updated icon and plugin thumbnail
= 1.0.8 =
* added option for splitting titles outside of the loop and in the menu or not
= 1.0.9 =
* menu issue bug fix
= 1.1.0 =
* Character issue fix for special/non-english characters, they now show on titles that have been split
Thank you to malasaad82 for pointing this issue out and suggesting a fix
= 1.1.1 =
* Issue has been fixed with calling the function get_current_screen()
Thank you to sanerdesign for pointing this issue out and suggesting a fix
= 1.1.2 =
* Fixed additional errors with the plugin
= 1.1.3 =
* Fixed issue with the ability to split the title not showing on initial load
Thank you to Ric for letting me know about the issue
= 2.0.0 =
* Added more options as to where you would like the breakpoints to appear or not appear, like widgets or search loops. Fixed issues of breakpoints being added to the html head code, as well as to tags with attributes like an alt or title using the title in the site
= 2.0.1 =
* Fixed issue with the menu not showing adjusted menu title
= 2.0.2 =
* Fixed issue with integrating with other plugins
= 2.0.3 =
* Fixed issue with non post items ex. categories not showing up in the menu
Thank you to communimage for letting me know about the issue
= 2.0.4 =
* Fixed issue with previous/next post links when there is no other post available.
Thank you to Javier for letting me know about the issue
= 2.0.5 =
* Fixed issue with the PHP warning and showing of code in the customize section of the backend.
Thank you to giomorin for letting me know about the issues
= 2.0.6 =
* Fixed issue with the IMG tag and page titles used in alt tags throwing errors
= 2.0.7 =
* Fixed issue with the showing of code in woocommerce on stock variations
Thank you to giomorin for letting me know about the issues

== Upgrade Notice ==

No issues found at this time.