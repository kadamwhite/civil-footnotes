=== Civil Footnotes ===
Contributors: defomicron
Tags: footnotes, post, posts, notes, reference, formatting, referencing, bibliography, citation
Requires at least: 2.0
Tested up to: 3.9.1
Stable tag: 1.3.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Create footnotes using a simple, easy-to-read syntax.

== Description ==

Civil Footnotes is a WordPress plugin for adding footnotes on your blog. Civil Footnotes parses your posts for notes wrapped in ((double parenthesis)), then extracts that parenthesized text into a footnote list at the end of the post.

There are many solutions for managing footnotes within your WordPress website, but Civil Footnotes distinguishes itself from the rest with a simple, readable plain text syntax that works whether you're using the WordPress block editor, a Markdown editor, or the classic editor plugin.

The majority of Civil Footnotes’s formatting is taken from Daring Fireball, which first debuted this style of footnotes [in 2005](http://daringfireball.net/2005/07/footnotes). The key difference is the addition of a `title` attribute to the footnote reference in the text. One need only hover their cursor over the reference number to read the note, eliminating two mouse clicks. For more information, visit [the plugin page](https://defomicron.net/projects/civil_footnotes) on the author’s website.

Civil Footnotes is based on [‘WP-Footnotes’](http://wordpress.org/extend/plugins/wp-footnotes/), a WordPress plugin by [Simon Elvery](http://elvery.net). It was originally created by [Austin Sweeney](https://defomicron.net/) and is currently maintained by [K. Adam White](https://www.kadamwhite.com).

== Installation ==

The easiest way to install Civil Footnotes is through the Admin section of your WordPress install. Otherwise:

1. Download and unzip `civil-footnotes.zip`

2. Upload the `civil-footnotes` folder to the `/wp-content/plugins/` directory of your WordPress install

3. Activate the plugin through the ‘Plugins’ menu in WordPress

== Frequently Asked Questions ==

= How do I use this plugin? =

Please read [the syntax guide](https://defomicron.net/projects/civil_footnotes/).

= Why aren’t there any settings? =

Good software is opinionated. Good software makes decisions. Civil Footnotes has made decisions. There are a few CSS hooks you can use to style your footnotes, as detailed on [the plugin site](https://defomicron.net/projects/civil_footnotes).

If you’re savvy, `civil-footnotes.php` is annotated with information on where to make edits to modify the plugin’s output.

= I found a bug, how can I report it? =

The best way to report a bug is to [open an issue on the plugin's GitHub repository](https://github.com/kadamwhite/civil-footnotes/issues/new) explaining your problem. You can also start a discussion on the [WordPress support forum](http://wordpress.org/support/plugin/civil-footnotes).

= May I suggest a new feature? =

You can, of course, but no guarantees! Civil Footnotes is deliberately lightweight and aims to remain so; if you have a suggestion, however, the best way to request a new feature is to open an issue on the project repository as described above in "I found a bug."

= License? =

This plugin is licensed under [the same license as WordPress](http://wordpress.org/about/license/) itself, the GPLv2 (or later).

= Why is your background image in the Plugin Directory the Manhattan skyline? =

Because it’s pretty.

= Where can I download archived releases of Civil Footnotes? =

From the [main plugin page](https://defomicron.net/projects/civil_footnotes) on the author’s website.

== Change Log ==

= 1.3.1 =

- Added a ‘footnote’ `rel` class to the footnote links

= 1.3 =

- Fixed two PHP errors (thanks to Greg Sullivan)
- From now on, identical footnotes will be created as two separate footnotes (as they should be)

= 1.2 =

- Added support for starting footnotes with a different number (e.g. 5)
- Add `<!--startnum=5-->` or similar anywhere in the post or page to do so
- This is handy for paginated posts

= 1.1 =

- Changed the backlink’s hover text, now more fun and more aligned with DF-style
- Added annotations to the plugin file to make it easier to modify output HTML
- Revised structure of output creation to make it easier to modify output HTML
- Fixed a bug that caused a `</p>` tag to not appear in the notes

This update is recommended for all users running Civil Footnotes 1.0 

= 1.0 =

- First release