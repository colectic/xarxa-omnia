<?php 
drupal_add_css(drupal_get_path('module', 'omnia_usos') . '/css/omnia_usos.css'); 

$coord = false;
if (in_array('OT', array_values($user->roles)) || in_array('ODC', array_values($user->roles)) || in_array('DGAC', array_values($user->roles))) $coord = true;

$st_header = array(t('Camp'), t('Valor'));
$rows = array();
$rows[] = array(t('Descripció breu'), strip_tags($node->field_activitat_omnia_descripcio[0]['value']));
$rows[] = array(t('Durada en minuts'), strip_tags($node->field_activitat_omnia_durada[0]['value']));
$rows[] = array(t('Número en sessions'), strip_tags($node->field_activitat_omnia_sessions[0]['value']));
$rows[] = array(t('Objectiu social'), strip_tags($node->field_activitat_omnia_objectius[0]['view']));
$rows[] = array(t('Competència digital'), strip_tags($node->field_activitat_omnia_competenci[0]['view']));
$rows[] = array(t('Estratègia DGAC'), strip_tags($node->field_activitat_omnia_estrat[0]['view']));
$rows[] = array(t('Col·lectiu destinatari'), strip_tags($node->field_activitat_omnia_collectiu[0]['view']));
$rows[] = array(t('Format de l\'activitat'), strip_tags($node->field_activitat_omnia_format[0]['view']));
$rows[] = array(t('Places ofertes'), strip_tags($node->field_activitat_omnia_places[0]['value']));
$rows[] = array(t('Organització'), strip_tags($node->field_activitat_omnia_organit[0]['view']));
if (!empty($node->field_activitat_omnia_entitat[0])) {
	$rows[] = array(t('Entitat'), $node->field_activitat_omnia_entitat[0]['view']);
}
if ($coord) {
	$rows[] = array(t('Eix principal'), strip_tags($node->field_activitat_omnia_eix[0]['value']));
	$rows[] = array(t('Eix secundari'), strip_tags($node->field_activitat_omnia_eix_sec[0]['value']));
	$rows[] = array(t('Estratègia DGAC - Coord.'), strip_tags($node->field_activitat_omnia_estrat_coo[0]['value']));
}
$rows[] = array(t('Observacions'), strip_tags($node->field_activitat_omnia_obs[0]['value']));

echo theme_table($st_header, $rows, array('class' => 'medsize'));
?>




