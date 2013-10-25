<?php

drupal_add_css(drupal_get_path('module', 'omnia_usos') . '/css/omnia_usos.css');

global $user;
$dina = false;
if (in_array('dinamitzadors', array_values($user->roles))) $dina = true;

$st_header = array();
$st_header[] = array('data' => t('Nom de l\'entitat'), 'class' => 'th1');
$st_header[] = array('data' => t('Tipus'), 'class' => 'th2');
$st_header[] = array('data' => t('Persona de contacte'), 'class' => 'th3');
$st_header[] = array('data' => t('Deriva persones'), 'class' => 'th4');
$st_header[] = array('data' => t('Hi ha coordinació'), 'class' => 'th5');
$st_header[] = array('data' => t('Protocòl signat'), 'class' => 'th6');
$st_header[] = array('data' => t('Freqüència de coord.'), 'class' => 'th7');
if ($dina) $st_header[] = array('data' => t('Accions'), 'class' => 'th8');

$trows = array();
foreach ($rows as $row) {
	$nid = strip_tags($row);
	$nid = str_replace(' ', '', $nid);
	
	$node = node_load($nid);
	$newrow = array();
	
	$newrow[] = array('data' => $node->title, 'class' => 'td1');
	$term = taxonomy_get_term($node->field_entitat_omnia_tipus[0]['value']);
	$newrow[] = $term->name;
	$newrow[] = $node->field_entitat_omnia_contacte[0]['value'];
	$newrow[] = ($node->field_entitat_omnia_deriva[0]['value']) ? 'Sí' : 'No';
	$newrow[] = ($node->field_entitat_omnia_coord[0]['value']) ? 'Sí' : 'No';
	$newrow[] = ($node->field_entitat_omnia_protocol[0]['value']) ? 'Sí' : 'No';
	$term = taxonomy_get_term($node->field_entitat_omnia_frequencia[0]['value']);
	$newrow[] = $term->name;
	
	$url = url(drupal_get_path_alias( 'node/' . $node->nid));
	$actions = "<a href='{$url}'><img src='http://{$_SERVER['HTTP_HOST']}/".drupal_get_path('module', 'omnia_usos') . "/pics/view.png' alt='mostra' class='icon'></a>
				<a href='/node/{$node->nid}/edit'><img src='http://{$_SERVER['HTTP_HOST']}/".drupal_get_path('module', 'omnia_usos')."/pics/edit.png' alt='edita' class='icon'></a>";
	if ($dina) $newrow[] = $actions;
	
	$trows[] = $newrow;	
}

echo theme_table($st_header, $trows, array('class' => 'medsize entitats-omnia'));

?>



