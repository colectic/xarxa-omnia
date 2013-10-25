<?php
//include 'omnia_usos_formulari.inc';

/**
 * This function contains boilerplate code for an AHAH handler.
 */
function omnia_usos_callback($item_name) {
  include_once 'modules/node/node.pages.inc';
  $form_state = array('storage' => NULL, 'submitted' => FALSE);
  $form_build_id = $_POST['form_build_id'];
  $form = form_get_cache($form_build_id, $form_state);
  $args = $form['#parameters'];
  $form_id = array_shift($args);
  $form['#post'] = $_POST;
  $form['#redirect'] = FALSE;
  $form['#programmed'] = FALSE;
  $form_state['post'] = $_POST;
  drupal_process_form($form_id, $form, $form_state);
  $form = drupal_rebuild_form($form_id, $form_state, $args, $form_build_id);
  $form_portion = $form[$item_name . '_wrapper'][$item_name];
  unset($form_portion['#prefix'], $form_portion['#suffix']); // Prevent duplicate wrappers.
  $output = theme('status_messages') . drupal_render($form_portion);
  drupal_json(array('status' => TRUE, 'data' => $output));
}

/**
 * This submit handler is invoked whenever the "Add more" submit button is clicked.
 * It increments the item counter stored in the form state.
 */
function omnia_usos_more_submit($form, &$form_state) {
  $button_id = $form_state['clicked_button']['#id'];
  if (preg_match('/^edit-(.*?)-more$/', $button_id, $match)) {
    $item_name = strtr($match[1], '-', '_');
  
    unset($form_state['submit_handlers']);
    form_execute_handlers('submit', $form, $form_state);
    $form_state['rebuild'] = TRUE;

    // Add new item
    $form_state[$item_name . '_count'] = count($form_state['values'][$item_name]) + 1;
  }
  else {
    watchdog('omnia_usos', 'omnia_usos_more_submit invoked by wrong submit button %button.', 
        array('%button' => $button_id), WATCHDOG_ALERT);
  }
}

/**
 * This function appends the wrapper element which will hold dynamically added items to the form.
 * It also appends the "Add more" button linked to the omnia_usos_callback and omnia_usos_more_submit
 * handler.
 */
function omnia_usos_wrapper(&$form, $form_state, $item_name) {
  $wrapper_name = $item_name . '_wrapper';

  $wrapper = array(
    '#tree' => FALSE,
    '#weight' => 1,
    '#prefix' => '<div class="clear-block" id="' . strtr($wrapper_name, '_', '-') . '">',
    '#suffix' => '</div>',
  ); 

  $js_wrapper = strtr($item_name . 's', '_', '-');
  $wrapper[$item_name] = array(
    '#prefix' => '<div id="' . $js_wrapper . '">',
    '#suffix' => '</div>',
    '#theme' => $item_name,
  );

  if (isset($form_state[$item_name . '_count'])) {
    $item_count = $form_state[$item_name . '_count'];
  }
  elseif (isset($_POST[$item_name])) {
    // 'Refresh' button on the page following 'Add more' submission was clicked
    $item_count = count($_POST[$item_name]);
  }
  else {
    $item_count = 8;
  }

  for ($i = 0; $i < $item_count; $i++) {
    $item = $form_state['values'][$item_name][$i];
    $item_form = array('#tree' => TRUE);

    call_user_func($item_name . '_form', &$item_form, $i, $item);

    $wrapper[$item_name][$i] = $item_form;
  }

  $form[$wrapper_name] = $wrapper;

  $form[$item_name . '_more'] = array(
    '#type' => 'submit',
    '#value' => t('Afegeix'),
    '#weight' => 1,
    '#submit' => array('omnia_usos_more_submit'),
    '#ahah' => array(
      'path' => 'omnia_usos/' . $item_name,
      'wrapper' => $js_wrapper,
      'method' => 'replace',
      ),
    );  

  return $wrapper;
}

