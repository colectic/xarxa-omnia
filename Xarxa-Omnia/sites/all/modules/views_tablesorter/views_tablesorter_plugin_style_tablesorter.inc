<?php
/**
 * @file
 * Contains the tablesorter style plugin.
 */

/**
 * Style plugin to render each item as a row in a table
 * sortable using the tablesorter jQuery plugin.
 *
 * @ingroup views_style_plugins
 */
class views_tablesorter_plugin_style_tablesorter extends views_plugin_style_table {
  function option_definition() {
    $options = parent::option_definition();
    $options['unsortable'] = array('default' => array());
    $options['wait_msg_enabled'] = array('default' => FALSE);
    $options['wait_msg'] = array('default' => t('Sorting, please wait...'));
    // We don't need this from the table style.
    unset($options['order']);
    return $options;
  }

  /**
   * Render the given style.
   */
  function options_form(&$form, &$form_state) {
    parent::options_form($form, $form_state);
    unset($form['order']);

    if (variable_get('views_no_javascript', FALSE)) {
      $form['error_markup'] = array(
        '#value' => t('The sorting and pager functionalities of this style will not currently work because the "Disable javascript with Views" option has been selected on the <a href="@tools-page">views tools page</a>.', array('@tools-page' => url('admin/build/views/tools'))),
        '#prefix' => '<div class="error form-item description">',
        '#suffix' => '</div>',
      );
    }

    // This theme function is registered by views_tablesorter.module.
    $form['#theme'] = 'views_tablesorter_style_plugin_tablesorter';

    $columns = $this->sanitize_columns($this->options['columns']);
    $priority_options = range(1, count($columns));
    array_unshift($priority_options, '<none>');

    // $form['info'] has already been set up by the table style plugin so we just add to that.
    foreach ($form['info'] as $field => $info) {
      // We want to make all fields sortable.
      if (!isset($info['sortable'])) {
        $form['info'][$field]['sortable'] = array(
          '#type' => 'checkbox',
          '#default_value' => !empty($this->options['info'][$field]['sortable']),
          '#process' => array('views_process_dependency'),
          '#dependency' => $info['sortable']['#dependency'],
        );
      }
      $form['info'][$field]['default_priority'] = array(
        '#type' => 'select',
        '#options' => $priority_options,
        '#default_value' => isset($this->options['info'][$field]['default_priority']) ? $this->options['info'][$field]['default_priority'] : 0,
        '#process' => array('views_process_dependency'),
        '#dependency' => $info['sortable']['#dependency'],
      );
      $form['info'][$field]['default_order'] = array(
        '#type' => 'select',
        '#options' => array(0 => t('Ascending'), 1 => t('Descending')),
        '#default_value' => isset($this->options['info'][$field]['default_order']) ? $this->options['info'][$field]['default_order'] : 0,
        '#process' => array('views_process_dependency'),
        '#dependency' => $info['sortable']['#dependency'],
      );
    }

    // This will be the default sort value.
    // It will be set in the form submit based on the individual field default values.
    $form['default'] = array(
      '#type' => 'value',
      '#value' => isset($this->options['default']) ? $this->options['default'] : '',
    );
    $form['unsortable'] = array(
      '#type' => 'value',
      '#value' => isset($this->options['unsortable']) ? $this->options['unsortable'] : '',
    );

    $form['wait_msg_enabled'] = array(
      '#type' => 'checkbox',
      '#title' => t('Wait message enabled'),
      '#default_value' => isset($this->options['wait_msg_enabled']) ? $this->options['wait_msg_enabled'] : FALSE,
      '#description' => t("If checked, a message will be displayed while sorting.  This is useful to inform the user what is going on when sorting large tables."),
    );
    $form['wait_msg'] = array(
      '#type' => 'textfield',
      '#title' => t('Message'),
      '#default_value' => isset($this->options['wait_msg']) ? $this->options['wait_msg'] : t('Sorting, please wait...'),
      '#description' => t("The message to display."),
      '#process' => array('views_process_dependency'),
      '#dependency' => array('edit-style-options-wait-msg-enabled' => array(TRUE)),
    );

    $form['description_markup']['#value'] = t('Place fields into columns; you may combine multiple fields into the same column. If you do, the separator in the column specified will be used to separate the fields. Check the sortable boxes of the columns you want to make sortable, then you can set the default sort by selecting the priority of the sort fields and their sort order. You may control column order and field labels in the fields section.');
  }

  /**
   * Perform any necessary validation for the form.
   */
  function options_validate($form, &$form_state) {
    parent::options_validate($form, $form_state);
    // Make sure we have unique default priorities.
    $selected_priorities = array();
    $unique_error_set = FALSE;
    $unsortable_error_set = FALSE;
    foreach ($form_state['values']['style_options']['info'] as $field => $info) {
      if ($info['default_priority']) {
        // Make sure we don't have default sorts on unsortable columns.
        if (!isset($info['sortable']) || !$info['sortable']) {
          form_set_error("style_options][info][$field][default_priority", t("Unsortable columns cannot be used in the default sort."));
          if ($unsortable_error_set) {
            // So we don't get duplicate errors, unset any after the first.
            // It's a bit of a hack but hard to avoid with form_set_error().
            array_pop($_SESSION['messages']['error']);
          }
          $unsortable_error_set = TRUE;
        }
        // Make sure we have unique default priorities.
        else if (in_array($info['default_priority'], $selected_priorities)) {
          form_set_error("style_options][info][$field][default_priority", t("The same default priority cannot be used more than once."));
          if ($unique_error_set) {
            // So we don't get duplicate errors, unset any after the first.
            // It's a bit of a hack but hard to avoid with form_set_error().
            array_pop($_SESSION['messages']['error']);
          }
          $unique_error_set = TRUE;
        }
        $selected_priorities[] = $info['default_priority'];
      }
    }
  }
}
