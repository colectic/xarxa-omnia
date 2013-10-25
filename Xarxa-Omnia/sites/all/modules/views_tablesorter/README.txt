

Description
-------------

The views tablesorter module is a views style plugin that can be used to output
views in a table that uses the tablesorter jQuery plugin.

The tablesorter jQuery plugin allows tablesorting without refreshing the page
or re-querying the database.
It also includes a pager so that multiple pages of results can be accurately
sorted without refreshing the page or re-querying the database.

For more tablesorter information see - http://tablesorter.com/docs/


Requirements
--------------

The views module is required for this module to be of any use.
The libraries module is also required for the handling of the jQuery tablesorter library.


Installation
--------------

1. Install views_tablesorter module as usual.
See http://drupal.org/node/70151 for further information.

2. Download the tablesorter jQuery plugin from http://tablesorter.com/jquery.tablesorter.zip
and unpack it into your sites/all/libraries directory so that the plugin file is at
sites/all/libraries/tablesorter/jquery.tablesorter.js

Configuration
---------------
There are some main settings at
Administer > Site configuration > Views tablesorter settings

These settings are:
* Date field sort format:
Set this to the date format you use on your site.  The tablesorter will
be expecting dates of this format so if it isn't correct the sort will not
work properly.
* Use fixed width columns on tables:
When sorting different columns the contents of the tables cells changes.
When this happens the table columns will normally resize to best fit the new
content in their cells.  If this options is checked the columns will remain
the same width regardless of the contents of their cells, which is more
aesthetically pleasing.
* Pager settings - Rows per page:
When using the pager the user can select how many rows per page to display.
The options you select here will be the options the users will have to
select from. In addition to these options will be the number entered for
the "Items per page" views option.
* Pager settings - Current page divider:
When using the pager the current page will be displayed with the pager.
It will be something like "Page 2 of 3".  This option sets what divides
the two numbers.
* Pager settings - Single page pager:
When using the pager this sets the behaviour of the pager when there is
only a single page of results.  You can choose to display the full pager,
display no pager or display just the page and result counts without the
buttons to change page.
* Pager settings - Use label for page numbers:
This is for advanced use and controls display of the page numbers in the pager.
If checked, custom pager jQuery will be used, which allows more suitable HTML
elements to be used for the display of the page numbers.  Otherwise the original
jQuery code will be used for the pager, whicih means the page numbers must be
displayed in HTML input or select elements.
See theme_views_tablesorter_current_page() in views_tablesorter.theme.inc for
more in relation to this.

To create a tablesorter view:
* In the "Basic settings" of the view edit screen select "Tablesorter" for the style.
You will then be presented with settings for the table, which are similar to the
settings for the normal table style.

* The main differencences are for the default sort settings.
The default sort can be on multiple columns, so the default priority controls whether
the column is sorted first, second, third etc. and the default order controls whether
the column is sorted ascending or descending.

* Multiple column sorting can be achieved by holding the shift key while clicking
the column headers.

* Wait message: You can choose to display a message to users when the table is sorting.
This might be useful if you have large tables that take a long time to sort.
You can also set the text for the message.

NOTE: If you have checked the "Disable javascript with Views" option on the views
tools page this module's sorting and pager functions will not work as they require
javascript.


Authors/maintainers
---------------------

Author/maintainer:
- Reuben Turk (rooby) - http://drupal.org/user/350381

tablesorter jQuery plugin author:
- Christian Bach


Support / Bugs / Feature requests
-----------------------------------

Issues should be posted in the issue queue on drupal.org:
http://drupal.org/project/issues/views_tablesorter
