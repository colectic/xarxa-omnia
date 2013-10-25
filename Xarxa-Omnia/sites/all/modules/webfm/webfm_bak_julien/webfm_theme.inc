<?php
// $Id: webfm_theme.inc,v 1.7 2011/01/16 01:45:08 nielshackius Exp $

/**
 * @file
 * This file holds the themeing functions of webfm
 *
 * Currently there is only one function creating a table for the attachments.
 */

/**
 * Displays file attachments in table
 *
 * @return
 *        string HtMl of attachments-table themed via the theme('table'... function.
 */
function theme_webfm_attachments($files) {
  global $base_url;

  $header = array(t('Attachment'));
  if ($enable_date = variable_get('webfm_attach_date', '')) {
    array_push($header, t('Date'));
  }
  if ($enable_size = variable_get('webfm_attach_size', '')) {
    array_push($header, t('Size'));
  }
  // jul: afegim autor fitxer + categoria
  array_push($header, t('Autor'));
  array_push($header, t('Categoria'));

  $rows = array();
  foreach ($files as $file) {
    // 0 =inline : 1 = attach
    $icon_path = $base_url .'/'. variable_get('webfm_icon_dir', drupal_get_path('module', 'webfm') .'/image/icon')  .'/'. _webfm_get_icon($file->e);
    $description = '';
    if (variable_get('webfm_attach_desc', '') && !empty($file->fdesc)) {
      $description = '<div class="att-fdesc">'. $file->fdesc .'</div>';
    }
    $filename = $file->ftitle ? $file->ftitle : $file->n;
    if (variable_get('webfm_attach_new_window', '')) {
      $href = array(
      'data' => l('<img src="'. $icon_path .'" alt="[file]" title="Download '. $filename .'"/> ', 'webfm_send/'. $file->id .'/1', array('attributes' => array('title' => 'Download '. $filename, 'target' => '_blank'), 'html' => TRUE)) . l($filename, 'webfm_send/'. $file->id, array('attributes' => array('title' => t('Open @filename', array('@filename' => $filename)), 'target' => '_blank'))) . $description,
      'class' => 'att-title'
      );
    }
    else {
      $href = array(
      'data' => l('<img src="'. $icon_path .'" alt="[file]" title="Download '. $filename .'"/> ', 'webfm_send/'. $file->id .'/1', array('attributes' => array('title' => 'Download '. $filename), 'html' => TRUE)) . l($filename, 'webfm_send/'. $file->id, array('attributes' => array('title' => t('Open @filename', array('@filename' => $filename))))) . $description,
      'class' => 'att-title'
      );
    }

    $row = array();
    array_push($row, $href);
    if ($enable_date) {
      $time = $file->fcreatedate ? date(webfm_get_date_format(), $file->fcreatedate) : date(webfm_get_date_format(),  @filemtime($file->p .'/'. $file->n));
      array_push($row, array('data' => $time, 'class' => 'att-time'));
    }
    if ($enable_size) {
      array_push($row, array('data' => format_size($file->s), 'class' => 'att-size'));
    }
    // jul: afegeixem el autor del fitxer
    
    $user_uid = $file->uid;
	$array_of_user_data = user_load(array('uid' => $user_uid));
	$user_name = '<a title="Anar a la pàgina del perfil d\'usuari" href="/user/'.$file->uid.'">'.$array_of_user_data->name.'</a>';

/* una altre manera: webfm.odule, linia 1311
 * $query = 'SELECT name FROM {users} WHERE uid = %d';
 * $meta['un'] = db_result(db_query($query, $file->uid));
 */

    array_push($row, array('data' => $user_name, 'class' => 'att-size'));
    
    // jul: afegeixem la categoria, que es simplement el nom de la carpeta
    $url = request_uri($file->p);
    
	/*if (strpos($file->p, "gestio")) {
	  array_push($row, array('data' => 'Gesti&oacute;', 'class' => 'webfm-pane-header'));
	}*/
	if (strpos($file->p, "oficina_tecnica")) {
	  array_push($row, array('data' => 'Oficina T&egrave;cnica', 'class' => 'att-size'));
	}
	if (strpos($file->p, "dg")) {
	  array_push($row, array('data' => 'DG', 'class' => 'att-size'));
	}
	if (strpos($file->p, "seguiment")) {
	  array_push($row, array('data' => 'Seguiment', 'class' => 'att-size'));
	}
	//$categoria = $file->p;
    array_push($rows, $row);
  }
  if (count($rows)) {
    return theme('table', $header, $rows, array('class' => 'webfm-attach-list'));
  }
}
