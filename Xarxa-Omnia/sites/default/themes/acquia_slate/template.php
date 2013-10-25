<?php
// $Id: template.php,v 1.4 2010/07/02 23:14:21 eternalistic Exp $
// Override theme_button for expanding graphic buttons
function acquia_slate_button($element) {
  // Make sure not to overwrite classes.
  if (isset($element['#attributes']['class'])) {
    $element['#attributes']['class'] = 'form-'. $element['#button_type'] .' '. $element['#attributes']['class'];
  }
  else {
    $element['#attributes']['class'] = 'form-'. $element['#button_type'];
  }
  
  // Wrap visible inputs with span tags for button graphics
  if (stristr($element['#attributes']['style'], 'display: none;') || stristr($element['#attributes']['class'], 'fivestar-submit') || (is_array($element["#upload_validators"]))) {
    return '<input type="submit" '. (empty($element['#name']) ? '' : 'name="'. $element['#name'] .'" ')  .'id="'. $element['#id'].'" value="'. check_plain($element['#value']) .'" '. drupal_attributes($element['#attributes']) ." />\n";
  }
  else {
    return '<span class="button-wrapper"><span class="button"><span><input type="submit" '. (empty($element['#name']) ? '' : 'name="'. $element['#name'] .'" ')  .'id="'. $element['#id'].'" value="'. check_plain($element['#value']) .'" '. drupal_attributes($element['#attributes']) ." /></span></span></span>\n";
  }
}

/**
 * Funcio: omniaV3_phptemplate_variables
 * Per a maquetejar el tema diferenciant els tipos de contingut: 
 * Si es pagina: page-tipodecontingut.tpl.php (si no existeix l'arxiu agafara: page.tpl.php)
 * Si es node: node-tipodecontingut.tpl.php (si no existeix l'arxiu agafara: node.tpl.php)
 * Si es un node concret: node-nid.tpl.php (si no existeix l'arxiu agafara: node-tipodecontingut.tpl.php o node.tpl.php)
 */

function acquia_slate_phptemplate_variables($hook, $vars = array()) {
  switch ($hook) {
    case 'page':  
	$vars['template_files'][] = 'page-'. $vars['node']->type;    
	break;
	
    case 'node':
	if ($vars['page']) {
		$vars['template_files'] = array('node-page', 'node-'. $vars['node']->type .'-page', 'node-'. $vars['node']->nid .'-page');
	}
	
	/*case 'panels':
	if (stripos($vars['messages'], 'Your message has been sent.') !== false) {
		  $msgs =  $vars['messages'];
		  unset($vars['messages']);
		  $vars['content']=str_replace('<div class="content">', '<div class="content">'.$msgs, $vars['content']);
	}*/
	else {
		$vars['template_files'] = array('node-'. $vars['node']->nid);
	}
	  
	break;

  }
	if($vars['node']->type=='entrada') {
           $vars['content'] = $vars['node->content']['body']['#value'];
	}
  return $vars;
}

/**
* Return a list of taxonomy terms with each vocab one its own line.
* http://drupal.org/node/133223#comment-2130438
*/

// split out taxonomy terms by vocabulary
function acquia_slate_print_terms($node) {
     $vocabularies = taxonomy_get_vocabularies();
     if ($vocabularies){$output = '<ul>';}
     foreach($vocabularies as $vocabulary) {
       if ($vocabularies) {
         $terms = taxonomy_node_get_terms_by_vocabulary($node, $vocabulary->vid);
         if ($terms) {
           $links = array();
           $output .= '<li>' . $vocabulary->name . ': ';
           foreach ($terms as $term) {
		if ($term->description){$titol=$term->description;}else{$titol=$term->name;}
             $links[] = l($term->name, taxonomy_term_path($term), array('rel' => 'tag', 'title' => $titol, 'lang' =>'ca', 'tabindex'=>'0', 'class'=>'etiqueta'));
           }
           $output .= implode(', ', $links);
           $output .= '</li>';
         }
       }
     }
     if ($vocabularies){$output .= '</ul>';}
     return $output;
}
function phptemplate_tagadelic_weighted($terms) {
  $output = '';
  foreach ($terms as $term) {
if ($term->description){$titol=$term->description;}else{$titol=$term->name;}
    $output .= l($term->name, taxonomy_term_path($term), array(
      'attributes' => array(
        'class' => "tagadelic level$term->weight",
	'rel' => 'tag',
        'title'  => $titol,
        'lang' =>'ca',
	'tabindex'=>'0',
        )
      )
    ) ." &#166; ";
  }
  return '<map title="Núvol d\'etiquetes" id="nuvol"><p>'.$output.'</p></map>';
}
function phptemplate_tagadelic_more($vid) {
  return "<div class='more-link'><a href='/tagadelic/chunk/".$vid."' title='Descobreix totes les etiquetes' lang='ca'>més</a></div>";

}
// Theming the filter tips more info link so users don't lose
// their stuff when visiting another page.

function acquia_filter_tips_more_info() {
  return '<p>'. l(t('More information about these filters'), 'filter/tips', array('attributes' => array('class' => 'target_blank'))) .'</p>';
}

function acquia_slate_preprocess_node(&$vars) {
  if (module_exists('service_links')) {
    $vars['service_links'] = theme('links', service_links_render($vars['node'], TRUE));
  }
}

function acquia_separate_terms($node_taxonomy) {
	if ($node_taxonomy) {
		//separating terms by vocabularies
		foreach ($node_taxonomy AS $term) {
if ($term->description){$titol=$term->description;}else{$titol=$term->name;}
		$links[$term->vid]['taxonomy_term_'. $term->tid] = array(
			'title' => $term->name,
			'href' => taxonomy_term_path($term),
			'attributes' => array(
			'lang' => 'ca',
			'rel' => 'tag',
			'title' => $titol
			),
		);
		}
		//theming terms out
		foreach ($links AS $key => $vid) {
			$terms[$key] = theme_links($vid);
		}
	}
	return $terms;
}

/* Retoquem una funcio del modul service link, per tal de fer desapareixer l'atribut target="_blank" dels enllaços que genera. Aquest atribut no es acceptat pels estandards. */
function phptemplate_service_links_build_link($text, $url, $title, $image, $nodelink) {
  global $base_path;

  if ($nodelink) {
    switch (variable_get('service_links_style', 1)) {
      case 1:
        $link = array(
          'title' => $text,
          'href' => $url,
          'attributes' => array('title' => $title, 'rel' => 'nofollow')
        );
        break;
      case 2:
        $link = array(
          'title' => '<img src="'. $base_path . drupal_get_path('module', 'service_links') .'/images/'. $image .'" alt="'. $text .'" />',
          'href' => $url,
          'attributes' => array('title' => $title, 'rel' => 'nofollow'),
          'html' => TRUE
        );
        break;
      case 3:
        $link = array(
          'title' => '<img src="'. $base_path . drupal_get_path('module', 'service_links') .'/images/'. $image .'" alt="'. $text .'" /> '. $text,
          'href' => $url,
          'attributes' => array('title' => $title, 'rel' => 'nofollow'),
          'html' => TRUE
        );
        break;
    }
  }
  else {
    switch (variable_get('service_links_style', 1)) {
      case 1:
        $link = '<a href="'. check_url($url) .'" title="'. $title .'" rel="nofollow">'. $text .'</a>';
        break;
      case 2:
        $link = '<a href="'. check_url($url) .'" title="'. $title .'" rel="nofollow"><img src="'. $base_path . drupal_get_path('module', 'service_links') .'/images/'. $image .'" alt="'. $text .'" /></a>';
        break;
      case 3:
        $link = '<a href="'. check_url($url) .'" title="'. $title .'" rel="nofollow"><img src="'. $base_path . drupal_get_path('module', 'service_links') .'/images/'. $image .'" alt="'. $text .'" /> '. $text .'</a>';
        break;
    }
  }

  return $link;
}

/**
 * Imprimeix 'active'(en el cas dels enllaços <a>) o 'active-trail'(en el cas de les llistes <li>) si la url actual coincideix amb la url de l'enllaç
 *
 */
function acquia_actiu($url, $tipo="a"){
	$path1=$_GET['q'];
	$path2=drupal_get_path_alias($path1);
	if ($tipo=="a"){
		if ($url==$path1 or $url==$path2) {$class="link active";} else {$class="link";}
	}
	if ($tipo=="li"){
		if ($url==$path1 or $url==$path2) {$class="leaf active-trail";} else {$class="leaf";}
	}
	print $class;
}

/**
 * Displays file attachments in table
 * Quan apareixia més d'un node amb arxius adjunts apareixia la mateixa id. 
 * Documentació: http://drupal.org/node/366610
 * 
 * @ingroup themeable
 */
function phptemplate_upload_attachments($files) {
  $header = array(t('Attachment'), t('Size'));
  $rows = array();
  foreach ($files as $file) {
    $file = (object)$file;
    if ($file->list && empty($file->remove)) {
      $href = file_create_url($file->filepath);
      $text = $file->description ? $file->description : $file->filename;
      $rows[] = array(l($text, $href), format_size($file->filesize));
    }
  }
  if (count($rows)) {
    // return theme('table', $header, $rows, array('id' => 'attachments'));
    return theme('table', $header, $rows, array('class' => 'attachments'));
  }
}
function _acquia_slate_form_alter(&$form, &$form_state, $form_id) {
drupal_set_message("Form Id: $form_id");
	$form['path']['#collapsed'] = false;
	$form['attachments']['#collapsed'] = FALSE;
	if ($form_id == 'arxiu_node_form') {		
	    unset($form['author']);
	    unset($form['options']);
	  }
	return drupal_render($form);
}
drupal_add_js('sites/xarxa-omnia.org/themes/acquia_slate/js/target-blank.js', 'theme');
drupal_add_js('sites/xarxa-omnia.org/themes/acquia_slate/js/video.js', 'theme');
?>
