=== Civil Footnotes ===
Contributors: kadamwhite, defomicron
Tags: footnotes, footnote, posts, notes, reference, formatting, referencing, bibliography, citation
Requires at least: 2.0
Tested up to: 5.2
Requires PHP: 7.0.0
Stable tag: 2.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Add footnotes to your site using a simple, easy-to-read inline syntax ((by wrapping footnote content with double-parentheses)).

== Description ==

Civil Footnotes is a WordPress plugin for adding footnotes on your blog. Civil Footnotes parses your posts for notes wrapped in ((double parenthesis)), then extracts that parenthesized text into a footnote list at the end of the post.

There are many solutions for managing footnotes within your WordPress website, but Civil Footnotes distinguishes itself from the rest with a simple, readable plain text syntax that works whether you're using the WordPress block editor, a Markdown editor, or the classic editor plugin.

The majority of Civil Footnotes’ formatting is taken from the blog [Daring Fireball](https://daringfireball.net/), which first debuted this style of footnotes [in 2005](http://daringfireball.net/2005/07/footnotes). The key difference is the addition of a `title` attribute to the footnote reference in the text which permits sighted mouse users to efficiently read the note by hovering their cursor over the reference number.

= Credits =

Civil Footnotes was originally created by [Austin Sweeney](https://defomicron.net/) and is currently maintained by [K. Adam White](https://www.kadamwhite.com).

== Installation ==

The easiest way to install Civil Footnotes is through the Admin section of your WordPress install. Otherwise:

1. Download and unzip `civil-footnotes.zip`

2. Upload the `civil-footnotes` folder to the `/wp-content/plugins/` directory of your WordPress install

3. Activate the plugin through the ‘Plugins’ menu in WordPress

== Frequently Asked Questions ==

= How do I use this plugin? =

To create a footnote in a post, wrap the note in double parenthesis. For example, if I wrapped `((this in double parenthesis))`, Civil Footnotes would interpret that as a footnote and convert it appropriately. This is a vast improvement over previous solutions which required you to manually keep a numbered reference in the text in sync with a note appended to the end.

Footnotes can be added to any post or page in WordPress. If you are using a plugin which provides Markdown support for your site, you may also include Markdown formatted text and links within your footnotes.

NOTE: You must include a space before the first parenthesis of your footnote; otherwise they will not display. This space will not be included in the final markup.

= Why aren’t there any settings? =

Civil Footnotes adheres to the WordPress project’s philosophy of ["Decisions, not Options"](https://wordpress.org/about/philosophy/#decisions). As a result there is no user-facing options configuration screen, and Civil Footnotes is designed to work as one might expect right out of the box.

If you do wish to change the behavior of the plugin, there are two ways in which a specific theme can alter how the footnotes render in code:

1. Your theme may provide custom CSS to style the footnote output. To style the reference numbers, style the `<sup>` tag in CSS. The footnotes at the bottom of a page use two css classes, `.footnotes` and `.backlink`, which may be used to apply additional CSS styling to those elements.

2. Your theme may specify the format of footnote marker. The available footnote markers are ‘decimal’, ‘lower-roman’, ‘upper-roman’, ‘lower-alpha’, ‘upper-alpha’, ‘lower-greek’, ‘upper-greek’, and ‘symbol’. To specify which marker is used on your site, you can add a filter function to the `footnotes_style` hook:

<pre><code>
// functions.php
function mytheme_use_roman_numeral_footnotes( $style, $formats ) {
  return $formats['lower-roman'];
}
apply_filter( 'footnotes_style', 'mytheme_use_roman_numeral_footnotes', 10, 2 );
</code></pre>

All available formats are specified in the keys of this filter's `$formats` array.

= I found a bug, how can I report it? =

The best way to report a bug is to [open an issue on the plugin's GitHub repository](https://github.com/kadamwhite/civil-footnotes/issues/new) explaining your problem. You can also start a discussion on the [WordPress support forum](http://wordpress.org/support/plugin/civil-footnotes).

= May I suggest a new feature? =

Absolutely! We cannot guarantee all feature proposals will be accepted; Civil Footnotes is deliberately lightweight and aims to remain so. If you have a suggestion, however, the best way to request a new feature is to open an issue on the project repository as described above in "I found a bug."

= Where can I download archived releases of Civil Footnotes? =

From the [Releases page](https://github.com/kadamwhite/civil-footnotes/releases) of the plugin’s GitHub repository.

== Upgrade Notice ==

= 2.0 =
Civil Footnotes 2.0 supports modern PHP versions and works with the block editor.

= 1.3.1 =
This is the last version of Civil Footnotes that supports PHP 5.6.

== Change Log ==

= 2.0.0 =

- Upgraded plugin for compatibility with PHP versions 7 and up
- Introduced `footnotes_style` filter to select roman numerals, symbols, or other non-numeric footnote styles
- Modernized & reorganized code for a more efficient footnote rendering experience
- Temporarily removed support for de-duplicating identical footnotes.
- Temporarily removed support for `<!--startnum=5-->` footnote number overrides.

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

== License & Attribution ==

This plugin is licensed under the terms of the [GNU General Public License](./license.txt) (or "GPL"). It is free software; you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation; either version 2 of the License, or (at your option) any later version.
