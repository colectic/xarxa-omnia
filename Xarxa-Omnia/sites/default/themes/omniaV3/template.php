<?php
// $Id: template.php oficial,v 3 2009/05/21 14:23:00 drumm Exp $

/**
 * Sets the body-tag class attribute.
 *
 * Adds 'sidebar-left', 'sidebar-right' or 'sidebars' classes as needed.
 */
function phptemplate_body_class($left, $right) {
  if ($left != '' && $right != '') {
    $class = 'sidebars';
  }
  else {
    if ($left != '') {
      $class = 'sidebar-left';
    }
    if ($right != '') {
      $class = 'sidebar-right';
    }
  }

  if (isset($class)) {
    print ' class="'. $class .'"';
  }
}

/**
 * Funcio: omniaV3_regions
 * Definim les regions del tema
 */
function omniaV3_regions() {
  $regions = phptemplate_regions();
  $regions['filtres'] = t('Filtres');
  return $regions;
}

function phptemplate_comment_submitted($comment) {
  return t('!datetime — !username',
    array(
      '!username' => theme('username', $comment),
      '!datetime' => format_date($comment->timestamp)
    ));
}

function phptemplate_node_submitted($node) {
  return t('!datetime — !username',
    array(
      '!username' => theme('username', $node),
      '!datetime' => format_date($node->created),
    ));
}

/**
 * Funcio: omniaV3_menu_item
 * Per crear les llistes de menu
 */
/*
function omniaV3_menu_item($mid, $children = '', $leaf = TRUE) {
  return '<li class="'. ($leaf ? 'llista' : ($children ? 'expanded' : 'collapsed')) .'">'. *menu_item_link($mid) . $children ."</li>\n";
}
*/

/**
 * Funcio: omniaV3_i18n_link
 * Per no treure les imatges dels idiomes
 */
/*
function omniaV3_i18n_link($text, $target, $lang, $separator='&nbsp;'){
  $attributes = ($lang == i18n_get_lang()) ? array('class' => 'active') : NULL;
  $output .= l($text, $target, $attributes, NULL, NULL, FALSE, TRUE);
  return $output;
}
*/

/**
 * Funcio: omniaV3_phptemplate_variables
 * Per a maquetejar el tema diferenciant els tipos de contingut: 
 * Si es pagina: page-tipodecontingut.tpl.php (si no existeix l'arxiu agafara: page.tpl.php)
 * Si es node: node-tipodecontingut.tpl.php (si no existeix l'arxiu agafara: node.tpl.php)
 * Si es un node concret: node-nid.tpl.php (si no existeix l'arxiu agafara: node-tipodecontingut.tpl.php o node.tpl.php)
 */

function omniaV3_phptemplate_variables($hook, $vars = array()) {
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

  return $vars;
}

/*
 * customitzar els filtres de les views
 * http://drupal.org/node/320992#comment-1572426 & http://bjrtechnologies.com/completely-customize-views-exposed-filters
 *
 */

/*
function exposedviewsformalter_form_alter(&$form, $form_state, $form_id) {

if($form['#id'] == 'views-exposed-form-llistat_punts_omnia-page-1') {
//Add or Undo slashes to show or hide form variables
echo "";
print_r($form);
echo "";
}
}
*/

/* del README del mòdul Hierarchical Select. Posa els filtres en una columma, no una row */

/*function omniaV3_views_filters($form) {
  $view = $form['view']['#value'];
  $rows = array();
  $form['submit']['#value'] = t('Search');
  if (isset($view->exposed_filter)) {
    foreach ($view->exposed_filter as $count => $expose) {
      $rows[] = array(
        array('data' => $expose['label'], 'header' => TRUE),
        drupal_render($form["op$count"]) . drupal_render($form["filter$count"]),
      );
    }
  }
  $rows[] = array(
    array('data' => '', 'header' => TRUE),
    drupal_render($form['submit'])
  );
  if (count($rows) > 1) {
    $output = drupal_render($form['q']) . theme('table', array(), $rows) . drupal_render($form);
  }
  else {
    $output = drupal_render($form);
  }
  return $output;
}*/

/**
 * funcio: theme_pager
 * Maquetacio del numero de pagines
 */
/*
function omniaV3_pager($tags = array(), $limit = 10, $element = 0, $parameters = array()) {
  global $pager_total;
  $output .= '';
  // hem afegit aquesta linia per arreglar un problema amb la paginacio
  $pager_total[$element] = round($pager_total[$element]/2);
  
  if ($pager_total[$element] > 1) {
    $output .= '<div class="pager">';
    $output .= theme('pager_first', ($tags[0] ? $tags[0] : t('« primera')), $limit, $element, $parameters);
    $output .= theme('pager_previous', ($tags[1] ? $tags[1] : t('‹ anterior')), $limit, $element, 1, $parameters);
    $output .= theme('pager_list', $limit, $element, ($tags[2] ? $tags[2] : 9 ), '', $parameters);
    $output .= theme('pager_next', ($tags[3] ? $tags[3] : t('següent ›')), $limit, $element, 1, $parameters);
    $output .= theme('pager_last', ($tags[4] ? $tags[4] : t('última »')), $limit, $element, $parameters);
    $output .= '</div>';

    return $output;
  }
}
*/

/**
* Theme a gmap marker label.
*/
function phptemplate_gmap_views_marker_label($view, $fields, $entry) {
return _phptemplate_callback('gmap_views_maker_label', array('view' => $view, 'fields' =>
$fields, 'entry' => $entry));
}

/**
* Return a list of taxonomy terms with each vocab one its own line.
* http://drupal.org/node/133223#comment-2130438
*/

// split out taxonomy terms by vocabulary
function omniaV3_print_terms($node) {
     $vocabularies = taxonomy_get_vocabularies();
     $output = '<ul>';
     foreach($vocabularies as $vocabulary) {
       if ($vocabularies) {
         $terms = taxonomy_node_get_terms_by_vocabulary($node, $vocabulary->vid);
         if ($terms) {
           $links = array();
           $output .= '<li>' . $vocabulary->name . ': ';
           foreach ($terms as $term) {
             $links[] = l($term->name, taxonomy_term_path($term), array('rel' => 'tag', 'title' => strip_tags($term->description)));
           }
           $output .= implode(', ', $links);
           $output .= '</li>';
         }
       }
     }
     $output .= '</ul>';
     return $output;
}

function omniaV3_preprocess_node(&$vars) {
  if (module_exists('service_links')) {
    $vars['service_links'] = theme('links', service_links_render($vars['node'], TRUE));
  }
}
