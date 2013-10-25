<?php

/**
 * @file views_tablesorter.theme.inc
 *
 * Theme functions for the views_tablesorter module.
 */

/**
 * Theme the tablesorter pager.
 *
 *  Note that the classes on the images are required for
 *  the tablesorter to work.
 *
 * @param $view
 *   The view object.
 * @param $size_options
 *   An array of the possible options for items per page.
 *
 * @ingroup themeable
 */
function theme_views_tablesorter_pager($view, $size_options) {
  $pager_type = variable_get('views_tablesorter_single_page_pager', 'none');
  $one_page = $view->total_rows <= $view->style_plugin->options['pager']['items_per_page'];

  if ($one_page && $pager_type == 'none') {
    return '';
  }

  $path = drupal_get_path('module', 'views_tablesorter');

  $output = '<div id="tablesorter-pager">';
  if (!$one_page || $pager_type == 'full') {
    $output .= '<img class="first" src="' . $path . '/images/first.png"/>';
    $output .= '<img class="prev" src="' . $path . '/images/prev.png"/>';
  }
  $output .= theme('views_tablesorter_current_page', $view->total_rows);
  if (!$one_page || $pager_type == 'full') {
    $output .= '<img class="next" src="' . $path . '/images/next.png"/>';
    $output .= '<img class="last" src="' . $path . '/images/last.png"/>';
    $output .= '<div class="size-option">';
    $output .= '<label>' . t('Results per page: ') . '</label>';
    $output .= '<select class="pagesize">';
    foreach ($size_options as $size_option) {
      $selected = $size_option == $view->style_plugin->options['pager']['items_per_page'] ? ' selected="selected"' : '';
      $output .= '<option' . $selected . ' value="' . $size_option . '">' . $size_option . '</option>';
    }
    $output .= '</select>';
    $output .= '</div>';
  }
  $output .= '</div>';

  return $output;
}

/**
 * Theme the current page part of the tablesorter pager.
 *
 * The element with the class .pagedisplay will be modified by jQuery
 * to set the page numbers. At this stage it must be an element that
 * can be modified by the .val() jQuery method, unless you have checked
 * the "Use label for page numbers" option on the settings page, in which
 * case it must be an element that can be modified by the .text() jQuery
 * method.
 *
 * @param $total_rows
 *   The total number of rows for the view.
 *
 * @ingroup themeable
 */
function theme_views_tablesorter_current_page($total_rows) {
  $current_page = variable_get('views_tablesorter_use_custom_pager', TRUE) ? '<label class="pagedisplay"></label>' : '<input type="text" disabled="disabled" class="pagedisplay"></input>';
  $output = '<span class="current-page">';
  $output .= t('Page ') . $current_page . t(' (@total_rows records)', array('@total_rows' => $total_rows));
  $output .= '</span>';
  return $output;
}

/**
 * Theme the form for the tablesorter style plugin.
 *
 * @param $form
 *   The form array for the tablesorter style setings form.
 *
 * @ingroup themeable
 */
function theme_views_tablesorter_style_plugin_tablesorter($form) {
  $output = '';
  if ($form['error_markup']) {
    $output .= drupal_render($form['error_markup']);
  }
  $output .= drupal_render($form['description_markup']);

  $header = array(
    t('Field'),
    t('Column'),
    t('Separator'),
    array(
      'data' => t('Sortable'),
      'align' => 'center',
    ),
    t('Default priority'),
    t('Default order'),
  );
  $rows = array();
  foreach (element_children($form['columns']) as $id) {
    $row = array();
    $row[] = drupal_render($form['info'][$id]['name']);
    $row[] = drupal_render($form['columns'][$id]);
    $row[] = drupal_render($form['info'][$id]['separator']);
    if (!empty($form['info'][$id]['sortable'])) {
      $row[] = array(
        'data' => drupal_render($form['info'][$id]['sortable']),
        'align' => 'center',
      );
      $row[] = drupal_render($form['info'][$id]['default_priority']);
      $row[] = drupal_render($form['info'][$id]['default_order']);
    }
    else {
      $row[] = '';
      $row[] = '';
      $row[] = '';
    }
    $rows[] = $row;
  }

  $output .= theme('table', $header, $rows);
  $output .= drupal_render($form);
  return $output;
}
