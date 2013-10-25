<?php 
drupal_add_css(drupal_get_path('module', 'omnia_usos') . '/css/omnia_usos.css'); 

echo '<p><b>Identificador:</b> '.$node->nid.'</p>';

$st_header = array(t('Camp'), t('Valor'));
$rows = array();
$rows[] = array(t('Sexe'), $node->field_usuari_omnia_sexe[0]['view']);
$rows[] = array(t('País de naixement'), $node->field_usuari_omnia_pais_origen[0]['view']);
$rows[] = array(t('Any de naixement'), strip_tags($node->field_usuari_omnia_naixement[0]['view']));
$rows[] = array(t('Any de d\'arribada a Catalunya'), strip_tags($node->field_usuari_omnia_arribada[0]['view']));
$rows[] = array(t('Entén el Català'), ($node->field_usuari_omnia_parla_cat[0]['value']) ? 'Sí' : 'No');
$rows[] = array(t('Escriu el Català'), ($node->field_usuari_omnia_escriu_cat[0]['value']) ? 'Sí' : 'No');
$rows[] = array(t('Entén el Castellà'), ($node->field_usuari_omnia_parla_cas[0]['value']) ? 'Sí' : 'No');
$rows[] = array(t('Escriu el Castellà'), ($node->field_usuari_omnia_escriu_cas[0]['value']) ? 'Sí' : 'No');
$rows[] = array(t('Nivell d\'estudis'), $node->field_usuari_omnia_estudis[0]['view']);

echo theme_table($st_header, $rows, array('class' => 'medsize'));
?>




