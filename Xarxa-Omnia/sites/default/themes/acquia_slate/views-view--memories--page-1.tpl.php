<?php
/**
 * @file views-view.tpl.php
 * Main view template
 *
 * Variables available:
 * - $classes_array: An array of classes determined in
 *   template_preprocess_views_view(). Default classes are:
 *     .view
 *     .view-[css_name]
 *     .view-id-[view_name]
 *     .view-display-id-[display_name]
 *     .view-dom-id-[dom_id]
 * - $classes: A string version of $classes_array for use in the class attribute
 * - $css_name: A css-safe version of the view name.
 * - $css_class: The user-specified classes names, if any
 * - $header: The view header
 * - $footer: The view footer
 * - $rows: The results of the view query, if any
 * - $empty: The empty text to display if the view is empty
 * - $pager: The pager next/prev links to display, if any
 * - $exposed: Exposed widget form/info to display
 * - $feed_icon: Feed icon to display, if any
 * - $more: A link to view more, if any
 * - $admin_links: A rendered list of administrative links
 * - $admin_links_raw: A list of administrative links suitable for theme('links')
 *
 * @ingroup views_templates
 */
?>
<div class="<?php print $classes; ?>">
  <?php if ($admin_links): ?>
    <div class="views-admin-links views-hide">
      <?php print $admin_links; ?>
    </div>
  <?php endif; ?>
  <?php if ($header): ?>
    <div class="view-header">
      <?php print $header; ?>
    </div>
  <?php endif; ?>

  <?php if ($exposed): ?>
    <div class="view-filters">
      <?php print $exposed; ?>
    </div>
  <?php endif; ?>

  <?php if ($attachment_before): ?>
    <div class="attachment attachment-before">
      <?php print $attachment_before; ?>
    </div>
  <?php endif; ?>

  <?php if ($rows): ?>
    <div class="view-content">
      <?php print $rows; ?>
    </div>
  <?php elseif ($empty): ?>
    <div class="view-empty">
      <?php print $empty; ?>
    </div>
  <?php endif; ?>

  <?php if ($pager): ?>
    <?php print $pager; ?>
  <?php endif; ?>

  <?php if ($attachment_after): ?>
    <div class="attachment attachment-after">
      <?php print $attachment_after; ?>
    </div>
  <?php endif; ?>

  <?php if ($more): ?>
    <?php print $more; ?>
  <?php endif; ?>

  <?php if ($footer): ?>
    <div class="view-footer">
      <?php print $footer; ?>
    </div>
  <?php endif; ?>

  <?php if ($feed_icon): ?>
    <div class="feed-icon">
      <?php print $feed_icon; ?>
    </div>
  <?php endif; ?>

</div> <?php /* class view */ ?>


<?php
llistat_estat_entrega_memories();
function llistat_estat_entrega_memories(){
	$sql="
	SELECT 
	node.nid AS nid,
	node_data_field_active.field_po_vegueria_comp_value AS vegueria,
	node_data_field_active.field_po_comarca_comp_value AS comarca,
	location.city AS ciutat,
	node_data_field_active.field_barri_value AS barri,
	node.title AS po_nom,
	node_data_field_phone_number.field_phone_number_value AS po_telf,
	node_data_field_e_mail.field_e_mail_email AS po_email,
	users_node_data_field_1r_dinamitzador_a.uid AS dinamitzador_uid,
	node_users_node_data_field_1r_dinamitzador_a_node_data_field_nom.field_nom_value AS dinamitzador_nom,
	node_users_node_data_field_1r_dinamitzador_a_node_data_field_nom.field_surname1_value AS dinamitzador_cognom1,
	node_users_node_data_field_1r_dinamitzador_a_node_data_field_nom.field_surname2_value AS dinamitzador_cognom2,
	node_users_node_data_field_1r_dinamitzador_a_node_data_field_e_mail.field_e_mail_email AS dinamitzador_email,
	node_data_field_active.field_active_value AS po_actiu
	 FROM node node 
	 LEFT JOIN content_type_content_punt node_data_field_1r_dinamitzador_a ON node.vid = node_data_field_1r_dinamitzador_a.vid
	 LEFT JOIN users users_node_data_field_1r_dinamitzador_a ON node_data_field_1r_dinamitzador_a.field_1r_dinamitzador_a_uid = users_node_data_field_1r_dinamitzador_a.uid
	 LEFT JOIN node node_users_node_data_field_1r_dinamitzador_a ON users_node_data_field_1r_dinamitzador_a.uid = node_users_node_data_field_1r_dinamitzador_a.uid AND node_users_node_data_field_1r_dinamitzador_a.type = 'profile'
	 LEFT JOIN content_type_content_punt node_data_field_active ON node.vid = node_data_field_active.vid
	 LEFT JOIN location_instance location_instance ON node.vid = location_instance.vid
	 LEFT JOIN location location ON location_instance.lid = location.lid
	 LEFT JOIN content_field_adrea node_data_field_adrea ON node.vid = node_data_field_adrea.vid
	 LEFT JOIN content_field_zip_code node_data_field_zip_code ON node.vid = node_data_field_zip_code.vid
	 LEFT JOIN content_field_phone_number node_data_field_phone_number ON node.vid = node_data_field_phone_number.vid
	 LEFT JOIN content_field_e_mail node_data_field_e_mail ON node.vid = node_data_field_e_mail.vid
	 LEFT JOIN content_type_profile node_users_node_data_field_1r_dinamitzador_a_node_data_field_nom ON node_users_node_data_field_1r_dinamitzador_a.vid = node_users_node_data_field_1r_dinamitzador_a_node_data_field_nom.vid
	 LEFT JOIN content_field_e_mail node_users_node_data_field_1r_dinamitzador_a_node_data_field_e_mail ON node_users_node_data_field_1r_dinamitzador_a.vid = node_users_node_data_field_1r_dinamitzador_a_node_data_field_e_mail.vid
	 WHERE (node.status = 1) AND (node.type in ('content_punt')) AND (node_data_field_active.field_active_value = 0)
	 ORDER BY po_nom
	";
	$result = db_query($sql);
	$header = array(t('Id'), t('Punt Òmnia'), t('Memòria entregada'), t('Nom dinamitzador/a'), t('Telèfon'), t('Email'));
$timestamp_inici=strtotime("-3 months");
$timestamp_fi=strtotime("now");
$data_inici=date('Y-m-d', $timestamp_inici);
$data_fi=date('Y-m-d', $timestamp_fi);

$inici=date('d-m-Y', $timestamp_inici);
$fi=date('d-m-Y', $timestamp_fi);
$data_info= "des del ".$inici." fins ".$fi;

	//$data_inici=date("Y")."-01-01";
	//$data_fi=date("Y")."-12-31";
	$files=array();
	if (!db_affected_rows($result) == 0) {
	while($po = db_fetch_object($result)){

		$nid_arxiu=comprova_existencia_de_memoria($po->nid);
		if ($nid_arxiu) $existeix="SI";
		else $existeix="NO";


		$sql_arxiu="
		SELECT node.nid nid, FROM_UNIXTIME(node.created,'%d-%m-%Y') created
		 FROM node node 
		 INNER JOIN term_node term_node ON node.vid = term_node.vid
		 INNER JOIN content_field_punt node_data_field_punt ON node.vid = node_data_field_punt.vid
		 WHERE node.type='arxiu' 
		 AND term_node.tid = 2733 AND 
		 node_data_field_punt.field_punt_nid = '".$po->nid."'
		AND FROM_UNIXTIME(created)>='".$data_inici."'
	   	AND FROM_UNIXTIME(created)< '".$data_fi."'
		";

		$resultat = db_query($sql_arxiu);
		if (!db_affected_rows($resultat) == 0) $existeix="SI";
		else $existeix="NO";
		$data_entrega="";
		while($arxiu = db_fetch_object($resultat)){
/*
			$data_entrega=$arxiu->created;
			$nid=$arxiu->nid;
			$files = node_load($nid);
			$files=$files->files;
*/
			//$arxius= theme_upload_attachments($files);
/*
			  $rows = array();
			  foreach ($files as $file) {
			    if ($file->list) {
			      $href = $file->fid ? file_create_url($file->filepath) : url(file_create_filename($file->filename, file_create_path()));
			      $text = $file->description ? $file->description : $file->filename;
			      $mime = strtoupper(substr($file->filemime, strrpos($file->filemime, '/')+1));
			      $rows[] = array(l($text, $href), format_size($file->filesize), $mime);
			    }
			  }

			  foreach($rows as $row){
			   $listBullets .= '<li>'.$row[0].' <small>['.$row[2].', '. $row[1].']</small>'.'</li>';
			  }

			   $arxius= '<ul>'.$listBullets.'</ul>';
*/
			//$arxius="";

		}

		$files[] = array(
			$po->nid,
			l($po->po_nom, "node/".$po->nid), 
			$existeix,
			l($po->dinamitzador_nom." ".$po->dinamitzador_cognom1." ".$po->dinamitzador_cognom1, "user/".$po->dinamitzador_uid),
			$po->po_telf,
			$po->po_email,
			//$data_entrega,
			//$arxius
		);
	  	
	}
}
	$output .= "<div id='estat-memories' style='margin-top:50px; clear:both;'>";
	$output .= "<h2>Estat d'enviament de les memòries ".$data_info."</h2>";
	$output .= theme('table', $header, $files);
	$output .= "</div>";
	print $output;
}

function comprova_existencia_de_memoria($nid){
	$data_inici=date("Y")."-01-01";
	$data_fi=date("Y")."-12-31";
	$sql="
	SELECT node.nid
	 FROM node node 
	 INNER JOIN term_node term_node ON node.vid = term_node.vid
	 INNER JOIN content_field_punt node_data_field_punt ON node.vid = node_data_field_punt.vid
	 WHERE node.type='arxiu' 
	 AND term_node.tid = 2733 AND 
	 node_data_field_punt.field_punt_nid = '".$nid."'
	AND FROM_UNIXTIME(created)>='".$data_inici."'
   	AND FROM_UNIXTIME(created)< '".$data_fi."'
	";



	$result=db_result(db_query($sql));
	if (!db_affected_rows($result) == 0) return true;
	else return false;
}


?>



