<?php

/**
 * @file
 * Defines the view style plugins for views tablesorter module.
 */

/**
 * Implementation of hook_views_plugins().
 */
function views_tablesorter_views_plugins() {
  return array(
    'style' => array(
      'tablesorter' => array(
        'title' => t('Tablesorter'),
        'help' => t('Display the results as a table using the tablesorter jQuery plugin.'),
        'handler' => 'views_tablesorter_plugin_style_tablesorter',
        'theme' => 'views_tablesorter_view_tablesorter',
        'uses options' => TRUE,
        'uses grouping' => FALSE,
        'uses row plugin' => TRUE,
        'type' => 'normal',
        'parent' => 'table',
      ),
    ),
  );
}

/**
 * Implementation of hook_views_pre_execute().
 */
function views_tablesorter_views_pre_execute(&$view) {
  if ($view->style_plugin->definition['handler'] == 'views_tablesorter_plugin_style_tablesorter') {
    // Disable the views pager before the query is executed as it interferes with our pager.
    // Keep the settings for our own pager though.
    if ($view->pager['use_pager']) {
      $view->style_plugin->options['pager'] = $view->pager;
      $view->pager['use_pager'] = 0;
      $view->pager['items_per_page'] = 0;
    }
  }
}
