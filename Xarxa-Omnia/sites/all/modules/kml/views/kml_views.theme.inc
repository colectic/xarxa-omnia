<?php

/**
 * @file
 * Theming functions for KML module views output.
 */

function template_preprocess_views_view_kml(&$vars) {
  $view = $vars['view'];
  
  $points = $view->style_plugin->map_rows($vars['rows']);

  $style = theme('kml_style', $points);

  foreach ($points as $point) {
    $rows .= theme('kml_placemark', $point, $points);
  }
     
  $vars['rows'] = $rows;
  $vars['style'] = $style;
  $vars['viewtitle'] = $view->get_title();
    
  // Checks if filename is manually specified in view style options otherwise
  // it sets it as the name of the view.
  if (!empty($view->style_options['filename'])) {
    $filename = $view->style_options['filename'] . '.kml';
  }
  else {
    $filename = $vars['viewtitle'] . '.kml';
  }

  drupal_set_header('Content-Type: application/vnd.google-earth.kml+xml');
  drupal_set_header("Content-Disposition: attachment; filename=\"$filename\"");
}

/**
 * Preprocess for theme('kml_placemark').
 */
function template_preprocess_kml_placemark(&$vars) {  
  $vars['name'] = filter_xss_admin($vars['point']['name']);
  $vars['description'] = filter_xss_admin($vars['point']['description']);
  $vars['coords'] = check_plain($vars['point']['point']);
  $vars['styleUrl'] = check_plain($vars['point']['styleUrl']);

  // Create a variable for every field that is unassigned, (is not Name, Desc,
  // Lat, or Lon.) These can be used in custom kml-placemark.tpl.php theme
  // implementations, each as $content['VARNAME'].
  foreach($vars['point']['content'] as $key => $value) {
    $vars['content'][$key] = filter_xss_admin($value);
  }
}

/**
 * Theme function for feed icon.
 */
function theme_kml_feed_icon() {
  $icon = drupal_get_path('module', 'kml').'/images/kml.png';
  return theme('image', $icon, t('KML icon'), t('Download KML Feed'));
}