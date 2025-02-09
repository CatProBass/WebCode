=== WP JV Post Reading Groups ===
Contributors: janosver
Tags: access, login, permission, permissions, post, posts, privacy, private, restrict, simple, user, users, member, members, membership, page, pages
Requires at least: 3.9.2
Tested up to: 5.5.3
Stable tag: 2.4
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Easily create posts and pages visible only for selected users of your blog

== Description ==

This plugin will enable you to

* Create Reading Groups and associate them with users and private posts and private pages

* Once these users logged in they will see those private posts and private pages which you granted access to

* Publish your posts and pages to general public as usual

Your users will not be aware (unless you tell them) of what Reading Groups they are part of (if any).

Translations

* Hungarian - Janos Ver (last updated for plugin v1.9)

* Czech - TomKom (last updated for plugin v1.9)


== Installation ==

1. Download wp-jv-post-reading-groups.zip
2. Extract to `/wp-content/plugins/wp-jv-post-reading-groups` directory
3. Activate the plugin through the 'Plugins' menu in WordPress

== Frequently Asked Questions ==

= How to create Reading Groups? =

Go to Settings -> Reading to create your Reading Groups.

= How to assign Reading Groups to Users? =

Go to Users -> All Users and select a non-admin user (admins have access to all RGs anyway) and grant permissions to Reading Groups of your choice.

When you add a New User you will be able to select Reading Groups as well.

= How to assign Reading Groups to Posts? =

Go to Posts -> Edit Post and select who will be able to read that post. **Don't forget to publish that post privately.**

= I added a page/post to the menu as custom link. Why is it visible for everyone? =

The plugin does not remove any links added to the menu this way as it is unable to distinguish between URLs pointing to the site or elsewhere.

The plugin is able to dynamically remove the ones a user has no permission, but to do that
1. add then create a page/post and publish it with visibility=public,
2. add it to the menu,
3. then set the page/post visibility=private (if you first set the post/page to private you won't find it in the list of pages/posts when trying to add it to the menu).

== Screenshots ==

1. Settings -> Reading
2. Users -> All Users
3. Users -> Add New
4. Posts -> All Posts
5. Posts -> Add New

== Changelog ==

= 2.4 =
Release date: November 21, 2020

* Bugfix: a number of odd behaviours and console errors fixed by updating the deprecated .live() jQuery method to use the .on() method instead

= 2.3 =
Release date: February 16, 2020

* Added support for custom post types - thanks to [@scottdeluzio](https://profiles.wordpress.org/scottdeluzio/)
* Added count of posts, pages per reading groups to Settings -> Reading and Users -> All Users screens
* Removed donation link
* Bugfix: non-logged in users couldn't see navigation menu items created using categories, even if there were public posts within those categories

= 2.2 =
Release date: December 28, 2018

* Bugfix: posts were not visible within categories for permitted users

= 2.1 =
Release date: March 18, 2017

* Bugfix: when a post/page had no Reading Group selected when posted privately it was visible for any logged in user - these posts will be visible for admins only.

= 2.0 =
Release date: October 16, 2016

* The default categories widget will now display categories with private posts only as well
* If a category is part of the menu, but the current user has no access to any posts within it then it gets removed from the menu for the current user only

= 1.9 =
Release date: June 1, 2016

* Added Czech translation by TomKom
* Permament fix for an issue when a subscriber is not able to comment on private posts to which he/she has read access
* Fix an issue when used in conjunction with [WP JV Custom Email Settings](https://wordpress.org/plugins/wp-jv-custom-email-settings/) which sent out notification to every user about new private posts/pages instead of only the users who authorized to see the new private post/page

= 1.8 =
Release date: April 14, 2016

* Fixed spinner icon while adding new Reading Group on Settings -> Reading screen - thanks to [@dbasilioesp](https://profiles.wordpress.org/dbasilioesp/) for the fix
* Fix an issue when a subscriber is not able to comment on private posts which he/she has otherwise read access to

= 1.7 =
Release date: December 14, 2015

* Fix a compatibility issue with WP 4.4 when it was not possible to add / rename or delete a Reading Group

= 1.6 =
Release date: December 13, 2015

* Performance improvement by loading javascript only on admin pages

New features added:

 * Private pages can be associated with Reading Groups
 * Users who have access to Reading Group are able to see the associated private pages as well

= 1.5 =
Release date: August 1, 2015
* Comments for private posts are now visible in Recent Comments widget (or any other similar) if the user is eligible
* Performance improvement by using minified js code
* Hungarian translation added

= 1.4 =
Release date: February 2, 2015
* Fix issue: post preview resulted in HTTP 404
* Fix issue: list of post reading groups was missing on add new user screen
* Other small fixes to improve compatibility with other plugins

= 1.3 =
Release date: January 29, 2015
* Fix issue: when user clicked on a URL of a private post multiple posts were shown
* Fix issue: private posts can't be distinguished on all posts admin screens
* Fix issue: private posts for which a user has got access does not appear in recent posts list
* Small fixes to improve compatibility with other plugins
* Tested with WordPress 4.1

= 1.2 =
Release date: September 8, 2014
* Fix issue: WP DB prefix to run on any instance

= 1.1 =
Release date: September 7, 2014
* Fix issue: click on a private post resulted in HTTP 404
* Fix issue: private posts where not included in recent posts widget
* Fix issue: "Private:" text from title was not excluded properly for languages other than English

= 1.0 =
Release date: August 16, 2014
* Initial release.

== Upgrade Notice ==

= 1.0 =
Release date: August 16, 2014

* Initial release

= 1.1 =
Release date: September 7, 2014

* Fix issue: click on a private post resulted in HTTP 404
* Fix issue: private posts where not included in recent posts widget
* Fix issue: "Private:" text from title was not excluded properly for languages other than English

= 1.2 =
Release date: September 8, 2014

* Fix issue: WP DB prefix to run on any instance

= 1.3 =
Release date: January 29, 2015

* Fix issue: when user clicked on a URL of a private post multiple posts were shown
* Fix issue: private posts can't be distinguished on all posts admin screens
* Fix issue: private posts for which a user has got access does not appear in recent posts list
* Small fixes to improve compatibility with other plugins
* Tested with WordPress 4.1

= 1.4 =
Release date: February 2, 2015

* Fix issue: post preview resulted in HTTP 404
* Fix issue: list of post reading groups was missing on add new user screen
* Other small fixes to improve compatibility with other plugins

= 1.5 =
Release date: August 1, 2015
* Comments for private posts are now visible in Recent Comments widget (or any other similar) if the user is eligible
* Performance improvement by using minified js code
* Hungarian translation added

= 1.6 =
Release date: December 13, 2015

* Performance improvement by loading javascript only on admin pages

New features added:

 * Private pages can be associated with Reading Groups
 * Users who have access to Reading Group are able to see the associated private pages as well

= 1.7 =
Release date: December 14, 2015

* Fix a compatibility issue with WP 4.4 when it was not possible to add / rename or delete a Reading Group

= 1.8 =
Release date: April 14, 2016

* Fixed spinner icon while adding new Reading Group on Settings -> Reading screen - thanks to dbasilioesp for the fix
* Fix an issue when a subscriber is not able to comment on private posts which he/she has otherwise read access to

= 1.9 =
Release date: June 1, 2016

* Added Czech translation by TomKom
* Permament fix for an issue when a subscriber is not able to comment on private posts to which he/she has read access
* Fix an issue when used in conjunction with [WP JV Custom Email Settings](https://wordpress.org/plugins/wp-jv-custom-email-settings/) which sent out notification to every user about new private posts/pages instead of only the users who authorized to see the new private post/page

= 2.0 =
Release date: October 16, 2016

* The default categories widget will now display categories with private posts only as well
* If a category is part of the menu, but the current user has no access to any posts within it then it gets removed from the menu for the current user only

= 2.1 =
Release date: March 18, 2017

* Bugfix: when a post/page had no Reading Group selected when posted privately it was visible for any logged in user - these posts will be visible for admins only.
