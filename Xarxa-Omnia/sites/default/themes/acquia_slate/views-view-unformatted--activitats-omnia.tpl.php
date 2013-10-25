<?php

drupal_add_css(drupal_get_path('module', 'omnia_usos') . '/css/omnia_usos.css');
$oid = '?oid='.$_REQUEST['oid'];

global $user;
$coord = false;
if (in_array('OT', array_values($user->roles)) || in_array('ODC', array_values($user->roles)) || in_array('DGAC', array_values($user->roles))) $coord = true;
$dina = false;
if (in_array('dinamitzadors', array_values($user->roles))) $dina = true;

$st_header = array();
$st_header[] = array('data' => t('Nom de l\'activitat'), 'class' => 'th1');
$st_header[] = array('data' => t('Durada'), 'class' => 'th2');
$st_header[] = array('data' => t('Sessions'), 'class' => 'th3');
$st_header[] = array('data' => t('Objectiu social'), 'class' => 'th4');
$st_header[] = array('data' => t('Competència digital'), 'class' => 'th5');
$st_header[] = array('data' => t('Estratègia DGAC'), 'class' => 'th6');
$st_header[] = array('data' => t('Col·lectiu destinatari'), 'class' => 'th7');
$st_header[] = array('data' => t('Format'), 'class' => 'th8');
$st_header[] = array('data' => t('Places'), 'class' => 'th9');
$st_header[] = array('data' => t('Organització'), 'class' => 'th10');
$st_header[] = array('data' => t('Entitat'), 'class' => 'th11');
if ($coord) $st_header[] = array('data' => t('Eix principal'), 'class' => 'th12');
if ($coord) $st_header[] = array('data' => t('Eix secundari'), 'class' => 'th13');
if ($coord) $st_header[] = array('data' => t('Estratègia DGAC - Coord.'), 'class' => 'th14');
if ($coord || $dina)$st_header[] = array('data' => t('Accions'), 'class' => 'th15');

$trows = array();
foreach ($rows as $row) {
	$nid = strip_tags($row);
	$nid = str_replace(' ', '', $nid);
	
	$node = node_load($nid);
	$newrow = array();
	
	$newrow[] = array('data' => $node->title, 'class' => 'td1');
	$newrow[] = $node->field_activitat_omnia_durada[0]['value'];
	$newrow[] = $node->field_activitat_omnia_sessions[0]['value'];
	$term = taxonomy_get_term($node->field_activitat_omnia_objectius[0]['value']);
	$newrow[] = $term->name;
	$term = taxonomy_get_term($node->field_activitat_omnia_competenci[0]['value']);
	$newrow[] = $term->name;
	$term = taxonomy_get_term($node->field_activitat_omnia_estrat[0]['value']);
	$newrow[] = $term->name;
	$term = taxonomy_get_term($node->field_activitat_omnia_collectiu[0]['value']);
	$newrow[] = $term->name;
	$term = taxonomy_get_term($node->field_activitat_omnia_format[0]['value']);
	$newrow[] = $term->name;
	$newrow[] = $node->field_activitat_omnia_places[0]['value'];
	$term = taxonomy_get_term($node->field_activitat_omnia_organit[0]['value']);
	$newrow[] = $term->name;
	$eid = $node->field_activitat_omnia_entitat[0]['nid'];
	$neid =  node_load($eid);
	$newrow[] = $neid->title;
	
	$url = url(drupal_get_path_alias( 'node/' . $node->nid));
	if ($coord) {
		$term = taxonomy_get_term($node->field_activitat_omnia_eix[0]['value']);
		$newrow[] = $term->name;
		$term = taxonomy_get_term($node->field_activitat_omnia_eix_sec[0]['value']);
		$newrow[] = $term->name;
		$term = taxonomy_get_term($node->field_activitat_omnia_estrat_coo[0]['value']);
		$newrow[] = $term->name;
	} 
	$actions = "<a href='{$url}{$oid}'><img src='http://{$_SERVER['HTTP_HOST']}/".drupal_get_path('module', 'omnia_usos') . "/pics/view.png' alt='mostra' class='icon'></a>
				<a href='/node/{$node->nid}/edit{$oid}'><img src='http://{$_SERVER['HTTP_HOST']}/".drupal_get_path('module', 'omnia_usos')."/pics/edit.png' alt='edita' class='icon'></a>";
	
	if ($coord || $dina) $newrow[] = $actions;
	
	$trows[] = $newrow;	
}

echo theme_table($st_header, $trows, array('class' => 'medsize activitats-omnia'));

?>



