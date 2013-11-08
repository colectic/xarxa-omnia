<?php
/* *********************************** */
 if ($page == 0) { /* teaser view      */
/* *********************************** */
?>

<?php
// snippet per separar la taxonomia amb ID 18 (vegueria-comarca-municipi)
$vid = 18;
$treeterms = taxonomy_get_tree($vid, 0, 0); // Gets list of ALL taxonomy terms in tree order
$nodeterms = taxonomy_node_get_terms_by_vocabulary($node, $vid); // Gets taxonomy terms assigned to the current node only.
$node_term_cmp = create_function('$term_1,$term_2', 'return $term_1->tid - $term_2->tid;'); // Callback function for uinstersect.
$iterms = array_uintersect($treeterms, $nodeterms, $node_term_cmp); // Matches terms between the two lists, keeping the tree order.

// build the arrays - although this also seems not really necessary - or is it?
$links = array();
$termid = array();

// loading info into the arrays
foreach($iterms as $iterm) {
   $links[] = l($iterm->name, taxonomy_term_path($iterm)); // gets the term with appropriate link
   $termid[] = check_plain($iterm->tid, taxonomy_term_path($iterm)); // gets the TID (without link)
  }

$vegueria = $links[0];
$comarca = $links[1];
$municipi = $links[2];

$vegueria_tid = $termid[0];
$comarca_tid = $termid[1];
$municipi_tid = $termid[2];
?>

<h2><?php print $node->title ?></h2>

<div class="field field-type-text field-field-adrea">
<div class="field-items"><?php foreach ((array)$field_adrea as $item) { ?>
<div class="field-item"><?php print $item['view'] ?></div>
<?php } ?></div>
</div>
<div class="field field-type-es-zipcode field-field-zip-code">
<div class="field-items"><?php foreach ((array)$field_zip_code as $item) { ?>
<div class="field-item"><?php print $item['view'] ?><?php print " " . $municipi; ?></div>
<?php } ?></div>
</div>
<div class="field field-type-text field-field-web-address">
<div class="field-items"><?php foreach ((array)$field_web_address as $item) { ?>
<div class="field-item"><?php print $item['view'] ?></div>
<?php } ?></div>
</div>
<div class="field field-type-email field-field-e-mail">
<div class="field-items"><?php foreach ((array)$field_e_mail as $item) { ?>
<div class="field-item"><?php print $item['view'] ?></div>
</div>
<?php } ?></div>

<?php 
} /* END IF TEASER VIEW */

/* *********************************** */
 else { /* full node view              */
/* *********************************** */

// snippet per separar la taxonomia amb ID 18 (vegueria-comarca-municipi)
$vid = 18;
$treeterms = taxonomy_get_tree($vid, 0, 0); // Gets list of ALL taxonomy terms in tree order
$nodeterms = taxonomy_node_get_terms_by_vocabulary($node, $vid); // Gets taxonomy terms assigned to the current node only.
$node_term_cmp = create_function('$term_1,$term_2', 'return $term_1->tid - $term_2->tid;'); // Callback function for uinstersect.
$iterms = array_uintersect($treeterms, $nodeterms, $node_term_cmp); // Matches terms between the two lists, keeping the tree order.

// build the arrays - although this also seems not really necessary - or is it?
$links = array();
$termid = array();

// loading info into the arrays
foreach($iterms as $iterm) {
   $links[] = l($iterm->name, taxonomy_term_path($iterm)); // gets the term with appropriate link
   $termid[] = check_plain($iterm->tid, taxonomy_term_path($iterm)); // gets the TID (without link)
  }

$vegueria = $links[0];
$comarca = $links[1];
$municipi = $links[2];

$vegueria_tid = $termid[0];
$comarca_tid = $termid[1];
$municipi_tid = $termid[2];

?>

<div id="punt">

<div id="punt-dades">

<h3 class="field-label"><?php print t('Description') ?></h3>
<?php foreach ((array)$field_description as $item) {
		print $item['view'];
	} ?>

<div class="punt-dades-logo">
<?php print $node->content['image_attach']['#value']; // logo del Punt Òmnia ?>
</div>

<h3 class="field-label"><?php print t('Schedule') ?></h3>
<?php foreach ((array)$field_horari as $item) {
		print $item['view'];
	} ?>
</div>
	
<div class="punt-fitxa">

<div class="puntomnia-dades-contacte">
<h3>Dades de contacte</h3>
<ul>
    <li><strong>Adre&ccedil;a</strong><br />
    <?php foreach ((array)$field_adrea as $item) {
			print $item['view'];
		} ?><br />
    <?php foreach ((array)$field_zip_code as $item) {
			print $item['value'];
        } ?>&nbsp;<?php print $municipi; ?><br />
    <?php print $comarca." (Comarca)<br />".$vegueria." (Demarcació territorial)"; ?></li>
    <li><strong>Tel&egrave;fon</strong>: <?php foreach ((array)$field_phone_number as $item) {
			print $item['view']; } ?></li>
	<?php foreach ((array)$field_fax as $item) {
		if ($item['view'] != '') {
			print "<li><strong>Fax</strong>: ";
			print $item['view'];
			print "</li>";
			}
		} ?>
    <li><strong>Correu electr&ograve;nic</strong>: <?php if (cerca_permis_dinamitzador($node->nid)) { print $node->field_e_mail[0]['safe']; }
    else { foreach ((array)$field_e_mail as $item) { print $item['view']; } } ?></li>
    <?php foreach ((array)$field_web_address as $item) { if ($item['view'] != '') { ?>
    <li class="web"><strong>Web:</strong> <?php foreach ((array)$field_web_address as $item) { ?><?php print "<a href='" . $item['view'] . "'>" . $item['view']=truncate_utf8($item['view'],'40', FALSE, TRUE) . "</a>"; ?><?php } ?></li>
	<?php } } ?>
</ul>
</div>

<?php

  /*
  *  id - the id of the map every map on a page must have a unique id
  *  width - width of the map
  *  height - height of the map
  *  center - a string of the longitude and latitude of the centre of the map
  *  zoom - the zoom factor of the google map
  *  align - the alignment of the map 'right', 'left' or 'center'
  *  control - the control shown on the map 'Large', 'Small', or 'None'
  *  type - 'Map', 'Hybrid' or 'Satellite'
  *  points/markers - a string of points to mark on the map with + between each point
  */

if ( ($location['latitude'] != 0) && ($location['longitude'] != 0) && ($teaser != 1) ) {
  $points = array(
     'id' => 'map'.$node->nid,
     'width' => '350px',
     'height' => '250px',
     'latitude' => $location['latitude'],
     'longitude'=> $location['longitude'],
     'zoom' => 15,
     'controls' => 'Small',
     'mtc' => 'Off',
     'maptype' => 'Map',
     'markers' => array(array(
       'markername' => 'green',
       'markermode'=> 1,
       'text'=> $node->title . "<div class='mapa-lesmeves-municipi'>" . $municipi . "</div>",
       'opts'=> array('title'=> $node->title),
       'latitude' => $location['latitude'], 
       'longitude' => $location['longitude']
        )),
      );
    print "<div class='puntomnia-mapa'>" . theme('gmap', array('#settings' => $points)) . "</div>";
}
?>

<?php if ($files) : ?>
<div class="po-adjunts">
<h3>Arxiu adjunt</h3>
<?php foreach ((array)$files as $file) { ?>
<div class="content">
<?php
//$file->filemime = 'application/pdf';

switch ($file->filemime)
{
	case "application/pdf":
		print '<span class="icona-mimetype"><img alt="" src="/files/icones/mimetypes/mime_pdf_34.png" /></span>';
		break;
	case "application/octet-stream":
		print '<span class="icona-mimetype"><img alt="" src="/files/icones/mimetypes/mime_doc_34.png" /></span>';
		break;
	case "application/vnd.ms-excel":
		print '<span class="icona-mimetype"><img alt="" src="/files/icones/mimetypes/mime_xls_34.png" /></span>';
		break;
	case "image/jpeg":
		print '<span class="icona-mimetype"><img alt="" src="/files/icones/mimetypes/mime_image_34.png" /></span>';
		break;
	default:
		echo '<span class="icona-mimetype"><img alt="" src="/files/icones/mimetypes/mime_misc_34.png" /></span>';
		break;
}
?>

<a title="<?php print $file->filename ?>" href="/<?php print $file->filepath ?>"><div class="file-descripcio"><?php print $file->description ?></div></a> <div class="file-size">(<?php print $file->filesize ?> bytes)</div></div>
<?php } ?>
</div>
<?php endif; ?>

<?php
/* pendent decisio OT si es mostra o no...
$viewName = 'les_meves_entitats';
$output5 .= views_embed_view('les_meves_entitats','block_2');
print $output5;
*/
?>

</div><!-- END div id punt-fitxa -->

<?php
/*$output6 .= '<h3>Not&iacute;cies publicades</h3>';
$output6 .= views_embed_view('po_noticies','block_1');
print $output6;*/
?>

<?php
if (in_array('administradors',$GLOBALS['user']->roles) || in_array('OT',$GLOBALS['user']->roles)) {
	if ($node->field_1r_dinamitzador_a[0]['uid']) {
	$outputz .= "<div class='po_news-bloc'>";
	$outputz .= "<h3>Not&iacute;cies publicades</h3>";
	$outputz .= "<ul>";
	
	// busquem si existeix un dina ppl, i en cas afirmatiu, si té contingut publicat
$sql = "SELECT DISTINCT(node.nid) AS node_nid,
node.title AS node_title,
node.uid AS node_uid,
node.created AS node_created
FROM node, content_type_content_punt
WHERE (node.status = 1)
AND (node.type IN('news','event','entrada'))
AND (content_type_content_punt.field_1r_dinamitzador_a_uid = node.uid)
AND (content_type_content_punt.field_1r_dinamitzador_a_uid =" . $node->field_1r_dinamitzador_a[0]['uid'] . ")
ORDER BY node_created DESC
LIMIT 0,10";

$cck_user_ref_uid_1 = $node->field_1r_dinamitzador_a[0]['uid'];
$array_of_user_data_1 = user_load(array('uid' => $cck_user_ref_uid_1));
$user_name = $array_of_user_data_1->name;

$result = db_query($sql);

if (!db_affected_rows($result) == 0) {
	while($po_noticies = db_fetch_object($result)){
	$outputz .= "<li><a href='/node/" . $po_noticies->node_nid . "'>" . $po_noticies->node_title . "</a>";
	$outputz .= "<div class='autoria'>";
	$outputz .= "<a href='/user/" . $po_noticies->node_uid . "'>" . $user_name . "</a> &middot; ";
	$outputz .= format_date($po_noticies->node_created, 'custom', "j M Y");
	$outputz .= "</div>";
	$outputz .= "</li>";
	}
}

// busquem si existeix primer un dina secundari, i en cas afirmatiu, si té contingut publicat
if ($node->field_puntomnia_dinas2[0]['uid']) {
	$sql = "SELECT DISTINCT(node.nid) AS node_nid, node.title AS node_title, node.uid AS node_uid, node.created AS node_created FROM node, content_field_puntomnia_dinas2 WHERE (node.status = 1) AND (node.type IN('news','event','entrada')) AND (content_field_puntomnia_dinas2.field_puntomnia_dinas2_uid = node.uid) AND (content_field_puntomnia_dinas2.field_puntomnia_dinas2_uid =" . $node->field_puntomnia_dinas2[0]['uid'] . ") ORDER BY node_created DESC LIMIT 0,5";
$cck_user2_ref_uid_1 = $node->field_puntomnia_dinas2[0]['uid'];
$array_of_user2_data1 = user_load(array('uid' => $cck_user2_ref_uid_1));
$user2_1_name = $array_of_user2_data1->name;
$result = db_query($sql);
if (!db_affected_rows($result) == 0) {
	while($po_noticies = db_fetch_object($result)){
	$outputz .= "<li><a href='/node/" . $po_noticies->node_nid . "'>" . $po_noticies->node_title . "</a>";
	$outputz .= "<div class='autoria'>";
	$outputz .= "<a href='/user/" . $po_noticies->node_uid . "'>" . $user2_1_name . "</a> &middot; ";
	$outputz .= format_date($po_noticies->node_created, 'custom', "j M Y");
	$outputz .= "</div>";
	$outputz .= "</li>";
	}
}
}

// busquem si existeix un segon dina secundari, i en cas afirmatiu, si té contingut publicat
if ($node->field_puntomnia_dinas2[1]['uid']) {
	$sql = "SELECT DISTINCT(node.nid) AS node_nid, node.title AS node_title, node.uid AS node_uid, node.created AS node_created FROM node, content_field_puntomnia_dinas2 WHERE (node.status = 1) AND (node.type IN('news','event','entrada')) AND (content_field_puntomnia_dinas2.field_puntomnia_dinas2_uid = node.uid) AND (content_field_puntomnia_dinas2.field_puntomnia_dinas2_uid =" . $node->field_puntomnia_dinas2[1]['uid'] . ") ORDER BY node_created DESC LIMIT 0,5";
$cck_user2_ref_uid_2 = $node->field_puntomnia_dinas2[1]['uid'];
$array_of_user2_data2 = user_load(array('uid' => $cck_user2_ref_uid_2));
$user2_2_name = $array_of_user2_data2->name;
$result = db_query($sql);
if (!db_affected_rows($result) == 0) {
	while($po_noticies = db_fetch_object($result)){
	$outputz .= "<li><a href='/node/" . $po_noticies->node_nid . "'>" . $po_noticies->node_title . "</a>";
	$outputz .= "<div class='autoria'>";
	$outputz .= "<a href='/user/" . $po_noticies->node_uid . "'>" . $user2_2_name . "</a> &middot; ";
	$outputz .= format_date($po_noticies->node_created, 'custom', "j M Y");
	$outputz .= "</div>";
	$outputz .= "</li>";
	}
}
}

	$outputz .= "</ul>";
	$outputz .= "<div class='mes'><a href='/user/" . $node->field_1r_dinamitzador_a[0]['uid'] . "/track'>m&eacute;s</a></div>";
	$outputz .= "</div>";

print $outputz;
	}

}

?>
</div><!-- END div id punt -->

<div class="puntomnia-gestio" style="padding-top: 15px;">
<?php

/* ************************************** START DADES GESTORS ******************************************** */


if (in_array('administradors',$GLOBALS['user']->roles) || in_array('OT',$GLOBALS['user']->roles) || in_array('ODC',$GLOBALS['user']->roles) || in_array('DGAC',$GLOBALS['user']->roles)) { 

/* START fieldset Gestió fitxa */

$title2 = 'Dades internes per gestors';
$output2 = "<div class='fieldset-po-gestio'>";

// indicar a la fitxa si esta publicada o no
$output2 .= "<div class='help'>";
if ($node->status == 0) {
   $output2 .= "<span style='text-align: left; color: red; font-weight: bold;'>FITXA DESPUBLICADA / ";
   }
else { $output2 .= "<span style='text-align: left; color: green; font-weight: bold;'>FITXA PUBLICADA / "; }

if ($node->field_active[0]['value'] == 0) {
   $output2 .= "<font color='green'>Punt &Ograve;mnia obert</font></span>";
   }
else { $output2 .= "<font color='red'>Punt &Ograve;mnia tancat</font></span>"; }

$output2 .= "<div>Fitxa creada el " . format_date($node->created) . " per <a title='veure perfil' href='/user/" . $node->uid . "'>" . $node->name . "</a>";
	if (strcmp($node->changed,$node->created) == 0) {
	$output2 .= ". Mai ha sigut actualitzada.</div>";
	}
	else {
	$output2 .= " i actualitzada per &uacute;ltima vegada el " . format_date($node->changed) . ".</div>";
	}
$output2 .= "</div>";

/* ********************************* */
$output2 .= "<div class='gestors_dades_basiques'>";
$output2 .= "<h3>Altres dades b&agrave;siques</h3>";
/* ********************************* */

 $myvars = taxonomy_node_get_terms_by_vocabulary($node, 20);
 if ($myvars) {
	$res = count ($myvars);
	$names = array();
	foreach ($myvars as $key => $myvar) {
	   $names[$myvar->tid] = $myvar->name;
	}
	asort($names);
	foreach ($names as $key => $myvar) {
	   $res--;
	   $lvar = l($myvar, 'taxonomy/term/'.$key);
	   $output2 .= "<strong>Any d'inici (taxonomia)</strong>: " . $lvar . "<br />";
	}
  }
//$output2 .= "<strong>Any d'inici</strong>: " . $node->field_start_year[0]['value'] . "<br />";

if (!$field_empty) {
$output2 .= "<strong>Tel&egrave;fon mòbil</strong>: " . $node->field_mobile_number[0]['value'] . "<br />";
}
$output2 .= "<strong>Correu electr&ograve;nic</strong>: " . $node->field_e_mail[0]['safe'];

$output2 .= "<p><strong>Dinamitzador principal del Punt TIC</strong></p>";

// Dinamitzador ppal del PO (nid present a l'url)
global $current_view;
// selecciona la vista para la view2
$view2 = views_get_view('po_dina_ppl_actiu');                    
// envia los argumentos de la vista y pinta el resultado en el contenido
$vista2 = views_embed_view('po_dina_ppl_actiu',$display_id='default',$current_view->args);
if ($vista2) { 
	$output2 .= $vista2; }
else { $output2 .= '<div style="padding: 20px 0 0 10px; font-style: italic;">No hi ha dinamitzador principal en aquest punt &Ograve;mnia.</div>'; }

$output2 .= "<p><strong>Dinamitzadors/es secundaris/ies</strong></p>";

// Dinamitzadors 2aris del PO (nid present a l'url)
global $current_view;
// selecciona la vista para la view2
$view2 = views_get_view('po_dinas_2s_actius');                    
// envia los argumentos de la vista y pinta el resultado en el contenido
$vista2 = views_embed_view('po_dinas_2s_actius',$display_id='default',$current_view->args);
if ($vista2) { 
	$output2 .= $vista2; }
else { $output2 .= '<div style="padding: 20px 0 0 10px; font-style: italic;">No hi han dinamitzadors secundaris en aquest punt &Ograve;mnia.</div>'; }




$output2 .= "<strong>Nom intern contractació</strong>: " . $node->field_po_nom_intern_contractacio[0]['value'] . "<br />";

$output2 .= "<p><strong>Maquinari del punt</strong></p>";
if (!$field_empty) {	
	$output2 .= "ADSL subvencionat: " . $node->field_po_adsl_subv[0]['view'] . "<br />";
}
if (!$field_empty) {	
	$output2 .= "N&uacute;mero d'ADSL: " . $node->field_po_adsl[0]['view'] . "<br />";
}
if (!$field_empty) {	
	$output2 .= "Any de renovació o instal·lació: " . $node->field_po_any_renov[0]['view'] . "<br />";
}
if (!$field_empty) {	
	$output2 .= "Descripció de maquinari:" . $node->field_po_maqui_descr[0]['value'];
}

$output2 .= "<p><strong>ID</strong>: " . $node->field_codi_telecentre[0]['value'] . "</p>";

if (!(array)$field_po_obs_internes) {
$output2 .= "<p><strong>Observacions internes</strong></p>";
foreach ((array)$field_po_obs_internes as $item) {
		$output2 .= $item['value'];
	}
}

if ($node->field_po_access_local[0]['value'] == 1) {
	$output2 .= "<p><strong>Acessibilitat del local</strong>: s&iacute;<br /><strong>Maquinari adaptat i accessible</strong>: " . $node->field_po_access_maqui[0]['value'] . "</p>";
}
else if ($node->field_po_access_local[0]['value'] = "0") { $output2 .= "<p><strong>Acessibilitat del local</strong>: no</p>"; }
else { $output2 .= "<p><strong>Acessibilitat del local</strong>: N/C</p>"; }
	
$output2 .= "</div>";

/* ********************************* */
$output2 .= "<div class='gestors_equipament_sac'>";
$output2 .= "<h3>Equipament DGACC</h3>";
/* ********************************* */

if (!$field_empty) {
$output2 .= "<strong>Nom de l'equipament</strong>: " . $node->field_nom_de_lequipament_sac[0]['view'] . "<br />";
}
/*
if (!$field_empty) {
$output2 .= "<strong>Tipus d'equipament_antic</strong>: " . $node->field_puntomnia_equipament_tipu[0]['view'] . "<br />";
}*/
if (!$field_empty) {
$output2 .= "<strong>Tipus d'equipament</strong>: " . $node->field_puntomnia_tipus_equipament[0]['view'] . "<br />";
}
if (!$field_empty) { 
$output2 .= "<strong>Responsable</strong>: " . $node->field_responsable_equipament_sa[0]['view'] . "<br />";
}
if (!$field_empty) { 
$output2 .= "<strong>Tel&egrave;fon</strong>: " . $node->field_po_equipament_telefon[0]['view'] . "<br />";
}
if (!$field_empty) { 
$output2 .= "<strong>Correu electr&ograve;nic</strong>: " . $node->field_po_equipament_mail[0]['view'];
}

$output2 .= "</div>";

/* ********************************* */
$output2 .= "<div class='gestors_entitat_gestora'>";
$output2 .= "<h3>Entitat gestora</h3>";
/* ********************************* */

$output2 .= "<p><em>Tots els punts &Ograve;mnia tenen entitat gestora. Si s&oacute;n punts de l&#39;any 1999 tenen contracte negociat amb la DGACC. Si s&oacute;n de l'any 2001 &eacute;s la pr&ograve;pia entitat qui assumeix les despeses de la dinamitzaci&oacute; i per tant el finan&ccedil;ament &eacute;s propi (FP). En el cas de punts &Ograve;mnia creats a partir de l'any 2001 i que no estan sotmesos a cap convocat&ograve;ria hi ha entitats que tenen negociat amb la DGACC i n'hi ha que tenen FP.</em></p>";

if (!$field_empty) {
$output2 .= "<strong>Nom de l'entitat</strong>: " . $node->field_nom_de_lentitat_gestora[0]['value'] . "<br />";
}
if (!$field_empty) {
$output2 .= "<strong>NIF</strong>: " . $node->field_nif_entitat[0]['value'] . "<br />";
}
if (!$field_empty) {
$output2 .= "<strong>Adre&ccedil;a</strong>:<br />" . $node->field_adress_entitat[0]['value'] . "<br />";
}
if (!$field_empty) { 
$output2 .= $node->field_puntomnia_entitat_zipcode[0]['view'];
	if (!$field_empty) { $output2 .= " " . $node->field_entitat_municipi[0]['view']; }
	$output2 .= "<br />";
}
if (!$field_empty) {
$output2 .= "<strong>Nom del responsable</strong>: " . $node->field_nom_responsable[0]['value'] . "<br />";
}
if (!$field_empty) {
$output2 .= "<strong>Correu electr&ograve;nic del responsable</strong>: " . $node->field_email_responsable[0]['email'] . "<br />";
}
foreach ((array)$node->field_email_responsable as $item) {
      $output2 .= "<div class='field-item'>" . $item['view'] . "</div>";
    }
if (!$field_empty) {
$output2 .= "<strong>Tel&egrave;fon del responsable</strong>: " . $node->field_telefon_responsable[0]['value'] . "<br />";
}
if (!$field_empty) {
$output2 .= "<strong>C&agrave;rrec del responsable</strong>: " . $node->field_carrec_responsable[0]['value'] . "<br />";
}
/*
if (!$field_empty) {
$output2 .= "<strong>Finan&ccedil;ament dinamitzaci&oacute_antic</strong>: " . $node->field_finanament_dinamitzaci[0]['value'] . "<br />";
}
*/
if (!$field_empty) {
$output2 .= "<strong>Finan&ccedil;ament dinamitzaci&oacute;</strong>: " . $node->field_financament[0]['view'] . "<br />";
}
if (!$field_empty) { 
$output2 .= "<strong>Altres programes DGACC</strong>: " . $node->field_altres_programes_dgac[0]['value'] . "<br />";
}
if (!$field_empty) { 
$output2 .= "<strong>Aprendre a Aprendre fins 2011</strong>: " . $node->field_altres_programes_aaa[0]['view'] . "<br />";
}
if (!$field_empty) { 
$output2 .= "<strong>PDC</strong>: " . $node->field_altres_programes_pdc[0]['view'] . "<br />";
}
if (!$field_empty) { 
$output2 .= "<strong>Inserci&oacute Social</strong>: " . $node->field_altres_programes_insercio[0]['view'];
}

$output2 .= "</div>";

/* ************************************** */
$output2 .= "<div class='gestors_entitat_col'>";
$output2 .= "<h3>Entitat col·laboradora</h3>";
/* ************************************** */

$output2 .= "<p><em>L'entitat col&middot;laboradora &eacute;s aquella entitat que va obtenir un punt &Ograve;mnia a partir de les convocat&ograve;ries dels anys 1999 i 2001 a excepci&oacute; dels punts &Ograve;mnia que actualment gestiona FUPAPSO i que nom&eacute;s tenen entitat gestora.</em></p>";

if (!$field_empty) {
$output2 .= "<strong>Nom de l'entitat</strong>: " . $node->field_entitat_colaboradora[0]['value'] . "<br />";
}
if (!$field_empty) {
$output2 .= "<strong>Adre&ccedil;a</strong>: " . $node->field_po_entitat_col_adreca[0]['value'] . "<br />";
}
if (!$field_empty) { 
$output2 .= $node->field_po_entitat_col_cp[0]['view'] . " " . $node->field_po_entitat_col_municipi[0]['view'] . "<br />";
}
if (!$field_empty) {
$output2 .= "<strong>Tel&egrave;fon</strong>: " . $node->field_po_entitat_col_tel[0]['value'] . "<br />";
}
if (!$field_empty) {
$output2 .= "<strong>Persona responsable</strong>: " . $node->field_po_entitat_col_resp[0]['value'] . "<br />";
}
if (!$field_empty) {
$output2 .= "<strong>C&agrave;rrec</strong>: " . $node->field_po_entitat_col_carrec[0]['value'] . "<br />";
}
if (!$field_empty) {
$output2 .= "<strong>Correu electr&ograve;nic</strong>: " . $node->field_po_entitat_col_mail[0]['email'];
}

$output2 .= "</div>";

/* ************************************** */
$output2 .= "<div class='gestors_po_relacions'>";
$output2 .= "<h3>Hist&ograve;ric de relacions que impliquen aquest punt &Ograve;mnia</h3>";
/* ************************************** */

if ($node->field_coordination[0]['nid']) {
$coordination1 = $node->field_coordination[0]['nid'];
$array_of_coordination1 = node_load(array('nid' => $coordination1));
$coordination1_nom = $coordination1->title;
$output2 .= "<p><strong>Coordinaci&oacute; fins 2008</strong>: <a href='/node/" . $coordination1 . "'>" . $node->field_coordination[0]['safe']['title'] . "</a></p>";
}

// relacions PO i dinamitzador (nid present a l'url)
    // cargar los 'metadata'
    global $current_view;
    // define el nid del nodo como el argumento
    //$current_view->args[0]=$node->uid;
    // selecciona la vista para la view2
    $view2 = views_get_view('Relacions_po_dina');                    
    // envia los argumentos de la vista y pinta el resultado en el contenido
    $vista2 = views_embed_view('Relacions_po_dina',$display_id='default',$current_view->args);
// El titulo de la vista incrustada
      if ($vista2) { 
		$output2 .= $vista2; }
      else { $output2 .= '<div style="padding: 20px 0 0 10px; font-style: italic;">No existeixen relacions establides entre dinamitzadors i aquest punt &Ograve;mnia.</div>'; }
$output2 .= "</div>";

$output2 .= "</div>";

/* ************************************** */
$output2 .= "<div class='gestors_po_fitxers'>";
$output2 .= "<h3>Documents de seguiment i informes</h3>";
/* ************************************** */

$output2 .= "<p><em>Acc&eacute;s compartit entre les 3 oficines als documents i informes sobre cada punt.<br />
Cada oficina penja els documents elaborats sobre el PO segon les 3 categories de documentaci&oacute; seg&uuml;ents: Seguiment, Inserci&oacute; social i DG.</em></p>";

// per veure array: $output2 .= '$node->webfm_files = '. print_r($node->webfm_files, true);
/* WEBFM */
/*
if ($node->content['webfm_attachments']['#value']) {
  $output2 .= $node->content['webfm_attachments']['#value'];

}
else { $output2 .= "<div style='background: #FFFBCF; border: 1px solid #ccc; padding: 10px 5px; font-style: italic; font-size: 0.9em;'>No hi ha documents vinculats a aquest Punt Òmnia o no tens els permisos suficients per poder veure-los.</div>"; }
*/

$myNodes = $node->nid;

$titol="<h3>Actes</h3>";
$actes = views_embed_view('acta', 'llistatactespo', $node->nid);
if ($actes) {$output2 .=$titol.$actes;}
$output2 .= "<p>".l('Crea una nova acta', 'node/add/acta', array('html' => true, 'query' => array( 'id' => $node->nid)))."</p>";

$titol="<h3>Informes del Servei de Seguiment</h3><p><em>Visibles tant sols per les 3 oficines.</em></p>";
$informe = views_embed_view('informepo', 'llistatinformes', $node->nid);
if ($informe) {$output2 .=$titol.$informe;}
$output2 .= "<p>".l('Crea un nou informe d\'aquest punt', 'node/add/informe', array('html' => true, 'query' => array( 'id' => $node->nid)))."</p>";

$titol="<h3>Altres arxius interns de les 3 oficines</h3>";
$arxiusinterns = views_embed_view('Arxiuintern', 'llistatarxiusinterns', $node->nid);


if (in_array('OT', array_values($user->roles)) or in_array('ODC', array_values($user->roles)) or in_array('DGAC', array_values($user->roles))) {
	$output2.= $titol;
	if ($arxiusinterns) {$output2 .= $arxiusinterns;}
	if (in_array('OT', array_values($user->roles))) $oficina = "oficina de seguiment"; 
	if (in_array('DGAC', array_values($user->roles))) $oficina = "DGAC";
	if (in_array('ODC', array_values($user->roles))) $oficina = "oficina d'inserció social"; 
	$output2 .= "<p>".l('Penja un arxiu de la '.$oficina.' en aquest punt', 'node/add/arxiuintern', array('html' => true, 'query' => array( 'id' => $node->nid)))."</p>";
}




$titol="<h3>Altres arxius</h3><p><em>Acc&eacute;s compartit entre Seguiment, Inserci&oacute; social, DG i també pels dinamitzador/s del ".$node->title."</em></p>";
$informe = views_embed_view('arxius', 'altresarxius', $node->nid);
if ($informe) {$output2 .=$titol.$informe;}
$output2 .= "<p>".l('Penja més arxius en aquest punt Òmnia', 'node/add/arxiu', array('html' => true, 'query' => array( 'id' => $node->nid)))."</p>";


$output2 .= "</div>";

$output2 .= "</div>";

$body2 = $output2;

//drupal_set_content('content', $body2);

$fieldset2 = array(
  '#title' => $title2,
  '#collapsible' => TRUE,
  '#collapsed' => FALSE,
  '#value' => $body2);

print theme('fieldset', $fieldset2);
                
?>

<?php 
/* STOP fieldset Gestió fitxa */
}

$permis_dinamitzador=cerca_permis_dinamitzador($node->nid);
if ($permis_dinamitzador){
	$title_dina = "Documents interns d'aquest Punt Òmnia";
	$output_dina = "<div class='fieldset-po-gestio'>";

	/* ************************************** */
	$output_dina .= "<div class='gestors_po_fitxers'>";

	/* ************************************** */

	$output_dina .= "<p><em>Llistat d'arxius d'aquest Punt Òmnia.</em></p>";

	$titol="<h3>Arxius</h3>";

	$informe = views_embed_view('arxius', 'altresarxius', $node->nid);
	if ($informe) {$output_dina .=$titol.$informe;}

if (in_array('dinamitzadors',$GLOBALS['user']->roles)){
	$output_dina .= "<p>".l('Penja més arxius', 'node/add/arxiu', array('html' => true, 'query' => array( 'id' => $node->nid)))."</p>";
}

	$output_dina .= "</div>";

	$output_dina .= "</div>";

	$body_dina = $output_dina;

	//drupal_set_content('content', $body2);

	$fieldset_dina = array(
	  '#title' => $title_dina,
	  '#collapsible' => TRUE,
	  '#collapsed' => FALSE,
	  '#value' => $body_dina);

	print theme('fieldset', $fieldset_dina);
}



?>
</div><!-- END div class puntomnia-gestio -->

<br class="clear" />

<?php 
} /* END IF FULL NODE VIEW */

function cerca_permis_dinamitzador($nid){
	global $user;

	if (in_array('dinamitzadors',$GLOBALS['user']->roles)){
		$sql="SELECT node.nid AS nid
		 FROM node node 
		 INNER JOIN content_type_content_punt node_data_field_active ON node.vid = node_data_field_active.vid
		 LEFT JOIN content_type_content_punt node_data_field_1r_dinamitzador_a ON node.vid = node_data_field_1r_dinamitzador_a.vid
		 LEFT JOIN content_field_puntomnia_dinas2 node_data_field_puntomnia_dinas2 ON node.vid = node_data_field_puntomnia_dinas2.vid
		 WHERE node.status = 1 AND node.type ='content_punt' AND node.nid=".$nid." 
		AND (node_data_field_1r_dinamitzador_a.field_1r_dinamitzador_a_uid=".$user->uid."
		 OR node_data_field_puntomnia_dinas2.field_puntomnia_dinas2_uid =".$user->uid." OR
		node.uid=".$user->uid.")";
		$nid_po=db_result(db_query($sql));
		if ($nid_po) return true;
		
	}
	if (in_array('entitat gestora',$GLOBALS['user']->roles)){
		$sql2="
		SELECT node.nid AS nid
		 FROM node node 
		 INNER JOIN content_type_content_punt node_data_field_active ON node.vid = node_data_field_active.vid
		 LEFT JOIN content_type_content_punt gestora ON node.vid = gestora.vid
		 WHERE node.status = 1 AND node.type ='content_punt' AND node.nid=".$nid." 
		AND gestora.field_gestora_usuari_uid=".$user->uid;
		$nid_po=db_result(db_query($sql2));
		if ($nid_po) return true; 
	}
	return false;
}
?>
