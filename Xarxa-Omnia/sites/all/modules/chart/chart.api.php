<?php
/**
 * @file
 * Hooks provided by the Chart module.
 */

/**
 * Perform alterations on a chart before it's rendered.
 *
 * @param $chart
 *   An associative array defining a chart.
 */
function hook_chart_alter(&$chart) {
  if ($chart['#chart_id'] == 'foo') {
    // Change the data color to blue.
    $chart['#data_colors'] = array('027AC6');
  }
}
