<?php

date_default_timezone_set('UTC+1');
drupal_add_css(drupal_get_path('module', 'omnia_usos') . '/css/omnia_usos.css');

global $user;
$dina = false;
if (in_array('dinamitzadors', array_values($user->roles))) $dina = true;

$st_header = array();
if ($dina) $st_header[] = array('data' => t('Nom i Cognoms / Àlies'), 'class' => 'th1');
$st_header[] = array('data' => t('Sexe'), 'class' => 'th2');
$st_header[] = array('data' => t('País de naixement'), 'class' => 'th3');
$st_header[] = array('data' => t('Any de naixement'), 'class' => 'th4');
$st_header[] = array('data' => t('Arribada a Catalunya'), 'class' => 'th5');
$st_header[] = array('data' => t('Entén el Català'), 'class' => 'th6');
$st_header[] = array('data' => t('Escriu el Català'), 'class' => 'th7');
$st_header[] = array('data' => t('Entén el Castellà'), 'class' => 'th8');
$st_header[] = array('data' => t('Escriu el Castellà'), 'class' => 'th9');
$st_header[] = array('data' => t('Nivell d\'estudis'), 'class' => 'th10');
if ($dina) $st_header[] = array('data' => t('Accions'), 'class' => 'th11');

$trows = array();
foreach ($rows as $row) {
	$nid = strip_tags($row);
	$nid = str_replace(' ', '', $nid);
	
	$node = node_load($nid);
	$newrow = array();
	
	if ($dina) $newrow[] = array('data' => $node->title, 'class' => 'td1');
	$newrow[] = ($node->field_usuari_omnia_sexe[0]['value']) ? 'Home' : 'Dona';
	$term = taxonomy_get_term($node->field_usuari_omnia_pais_origen[0]['value']);
	$newrow[] = $term->name;
	$year = explode('-', $node->field_usuari_omnia_naixement[0]['value']);
	$newrow[] = $year[0];
	$year = explode('-', $node->field_usuari_omnia_arribada[0]['value']);
	$newrow[] = $year[0];
	$newrow[] = ($node->field_usuari_omnia_parla_cat[0]['value']) ? 'Sí' : 'No';
	$newrow[] = ($node->field_usuari_omnia_escriu_cat[0]['value']) ? 'Sí' : 'No';
	$newrow[] = ($node->field_usuari_omnia_parla_cas[0]['value']) ? 'Sí' : 'No';
	$newrow[] = ($node->field_usuari_omnia_escriu_cas[0]['value']) ? 'Sí' : 'No';
	$term = taxonomy_get_term($node->field_usuari_omnia_estudis[0]['value']);
	$newrow[] = $term->name;
	
	$url = url(drupal_get_path_alias( 'node/' . $node->nid));
	$actions = "<a href='{$url}'><img src='http://{$_SERVER['HTTP_HOST']}/".drupal_get_path('module', 'omnia_usos') . "/pics/view.png' alt='mostra' class='icon'></a>
				<a href='/node/{$node->nid}/edit'><img src='http://{$_SERVER['HTTP_HOST']}/".drupal_get_path('module', 'omnia_usos')."/pics/edit.png' alt='edita' class='icon'></a>";
	if ($dina) $newrow[] = $actions;
	
	$trows[] = $newrow;	
}

echo theme_table($st_header, $trows, array('class' => 'medsize usuaris-omnia'));

?>



