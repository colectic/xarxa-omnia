
/**
 * This is where we add the tablesorter functionality to the views table.
 */

$(document).ready(function() {
  // Add columnHighlight widget.
  // Sorted Column Highlight Widget by Bill Beckelman http://beckelman.net
  // with a couple of modifications to better integrate with drupal.
  // Requires sortedeven and sortedodd classes in your CSS
  $.tablesorter.addWidget({
    id: 'columnHighlight',
    format: function(table) {
      $('td', table.tBodies[0]).removeClass('active');
      var ascSort = 'th.' + table.config.cssAsc;
      var descSort = 'th.' + table.config.cssDesc;

      $(table.tHead[0]).find(ascSort).add($(table.tHead[0]).find(descSort)).each(function() {
        $('tr:visible', table.tBodies[0]).find('td:nth-child(' + ($('thead th', table).index(this) + 1) + ')').addClass('active');
      });
    }
  });

  // Call the tablesorter plugin.
  $('table.views-tablesorter').tablesorter({
    sortList: Drupal.settings.views_tablesorter.tablesorter_settings.default_sort,
    headers: Drupal.settings.views_tablesorter.tablesorter_settings.unsortable_cols,
    dateFormat: Drupal.settings.views_tablesorter.tablesorter_settings.date_format,
    textExtraction: 'complex',
    cssHeader: 'header-sortable',
    cssAsc: 'header-sort-asc',
    cssDesc: 'header-sort-desc',
    widthFixed: Drupal.settings.views_tablesorter.tablesorter_settings.width_fixed,
    widgets: ['zebra', 'columnHighlight']
  });
  if (Drupal.settings.views_tablesorter.use_pager) {
    // Add the tablesorter pager plugin.
    $('table.views-tablesorter').tablesorterPager({
      container: $('#tablesorter-pager'),
      positionFixed: false,
      size: Drupal.settings.views_tablesorter.pager_settings.pager_size,
      seperator: Drupal.settings.views_tablesorter.pager_settings.current_page_separator
    });
  }

  // Display message while sorting.
  if (Drupal.settings.views_tablesorter.tablesorter_settings.wait_msg) {
    $('table.views-tablesorter').bind('sortStart', function() {
      $('#views-tablesorter-sort-msg').show();
    }).bind('sortEnd', function() {
      $('#views-tablesorter-sort-msg').hide();
    });
  }
});
