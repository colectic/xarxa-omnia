<?php

/**
 * @file
 * Admin forms for the views tablesorter module.
 */

/**
 * Admin settings form.
 *
 * @ingroup form
 */
function views_tablesorter_settings_form() {
  $form = array();

  $form['views_tablesorter_compression_type'] = array(
    '#type' => 'radios',
    '#title' => t('Choose jQuery tablesorter compression level'),
    '#options' => array(
      'min' => t('Production (Minified)'),
      'none' => t('Development (Uncompressed Code)'),
    ),
    '#default_value' => variable_get('views_tablesorter_compression_type', 'min'),
  );

  $form['views_tablesorter_date_format'] = array(
    '#type' => 'select',
    '#title' => t('Date field sort format'),
    '#options' => array(
      'us' => 'mm/dd/yyyy or mm-dd-yyyy',
      'uk' => 'dd/mm/yyyy or dd-mm-yyyy',
    ),
    '#default_value' => variable_get('views_tablesorter_date_format', 'us'),
  );

  $form['views_tablesorter_width_fixed_cols'] = array(
    '#type' => 'checkbox',
    '#title' => t('Use fixed width columns on tables'),
    '#default_value' => variable_get('views_tablesorter_width_fixed_cols', TRUE),
    '#description' => t("If this is unchecked, when sorting, the width of table columns will change depending on the contents of their cells."),
  );

  $form['pager_settings'] = array(
    '#type' => 'fieldset',
    '#title' => t('Pager settings'),
  );
  $form['pager_settings']['views_tablesorter_page_size'] = array(
    '#type' => 'select',
    '#title' => t('Rows per page'),
    '#multiple' => TRUE,
    '#options' => array(
      5 => 5,
      10 => 10,
      12 => 12,
      15 => 15,
      18 => 18,
      20 => 20,
      25 => 25,
      30 => 30,
      35 => 35,
      40 => 40,
      45 => 45,
      50 => 50,
      60 => 60,
      70 => 70,
      75 => 75,
      80 => 80,
      90 => 90,
      100 => 100,
      125 => 125,
      150 => 150,
    ),
    '#default_value' => variable_get('views_tablesorter_page_size', array(10, 15, 20, 25)),
    '#description' => t('The pager allows users to select how many rows to display per page.  This setting allows you to select the possible options the user has to choose from. In addition to what is selected here will be the "Items per page" setting you choose in your view settings.'),
  );
  $form['pager_settings']['views_tablesorter_current_page_divider'] = array(
    '#type' => 'textfield',
    '#title' => t('Current page divider'),
    '#default_value' => variable_get('views_tablesorter_current_page_divider', ' of '),
    '#description' => t('This is the text that separates the current page number from the total number of pages in the pager.'),
  );
  $form['pager_settings']['views_tablesorter_single_page_pager'] = array(
    '#type' => 'select',
    '#title' => t('Single page pager'),
    '#options' => array(
      'none' => t('No pager'),
      'count' => t('Page & result counts only'),
      'full' => t('Full pager'),
    ),
    '#default_value' => variable_get('views_tablesorter_single_page_pager', 'none'),
    '#description' => t('This sets the behaviour of the pager when there is only a single page of results.'),
  );
  $form['pager_settings']['views_tablesorter_use_custom_pager'] = array(
    '#type' => 'checkbox',
    '#title' => t('Use label for page numbers'),
    '#default_value' => variable_get('views_tablesorter_use_custom_pager', TRUE),
    '#description' => t("The tablesorter pager only allows the use of a text field to display the page numbers.  By checking this box you are using a customised version of the tablesorter's pager plugin that allows the use of other elements that are more suitable for this task. This will affect the display of your pager."),
  );

  return system_settings_form($form);
}
