<?php 
drupal_add_css(drupal_get_path('module', 'omnia_usos') . '/css/omnia_usos.css'); 

$st_header = array(t('Camp'), t('Valor'));
$rows = array();
$rows[] = array(t('Tipus d\'entitat'), $node->field_entitat_omnia_tipus[0]['view']);
$rows[] = array(t('Persona de contacte'), $node->field_entitat_omnia_contacte[0]['view']);
$rows[] = array(t('Deriva persones'), ($node->field_entitat_omnia_deriva[0]['value']) ? 'Sí' : 'No');
$rows[] = array(t('Hi ha coordinació'), ($node->field_entitat_omnia_coord[0]['value']) ? 'Sí' : 'No');
if ($node->field_entitat_omnia_coord[0]['value']) {
	$rows[] = array(t('Protococol de coordinació signat'), ($node->field_entitat_omnia_protocol[0]['value']) ? 'Sí' : 'No');
	$rows[] = array(t('Freqüència de coordinació'), $node->field_entitat_omnia_frequencia[0]['view']);
}

echo theme_table($st_header, $rows, array('class' => 'medsize'));
?>




