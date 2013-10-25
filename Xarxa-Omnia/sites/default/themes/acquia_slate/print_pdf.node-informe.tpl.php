<?php
// $Id: print.tpl.php,v 1.8.2.17 2010/08/18 00:33:34 jcnventura Exp $

/**
 * @file
 * Default print module template
 *
 * @ingroup print
 */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="<?php print $print['language']; ?>" xml:lang="<?php print $print['language']; ?>">
  <head>
    <?php print $print['head']; ?>
    <?php print $print['base_href']; ?>
    <title><?php print $print['title']; ?></title>
    <?php print $print['scripts']; ?>
    <?php print $print['robots_meta']; ?>
    <?php print $print['favicon']; ?>
    
  </head>
  <body>


<?php 
$logoomnia=theme_image('http://xarxa-omnia.org/sites/xarxa-omnia.org/themes/acquia_slate/images/logotip_omnia.png',  $alt = 'Logotip Xarxa Òmnia', $title = 'Logotip Xarxa Òmnia', array('width'=>'199', 'height'=>'65', 'style'=>'float:right;'), FALSE);


$logogene=theme_image('http://xarxa-omnia.org/sites/xarxa-omnia.org/themes/omniaV3/css/benestar_h3.png',  $alt = 'Logotip Generalitat de Catalunya - Departament de Benestar Social i Família', $title = 'Logotip Generalitat de Catalunya - Departament de Benestar Social i Família', array('width'=>'186', 'height'=>'30', 'style'=>'float:left;'), FALSE);
?>








<?php
// snippet per separar la taxonomia amb ID 18 (vegueria-comarca-municipi)
$vid = 18;
$po=node_load($node->field_informe_nid_po[0]['value']);
$treeterms = taxonomy_get_tree($vid, 0, 0); // Gets list of ALL taxonomy terms in tree order
$nodeterms = taxonomy_node_get_terms_by_vocabulary($po, $vid); // Gets taxonomy terms assigned to the current node only.
$node_term_cmp = create_function('$term_1,$term_2', 'return $term_1->tid - $term_2->tid;'); // Callback function for uinstersect.
$iterms = array_uintersect($treeterms, $nodeterms, $node_term_cmp); // Matches terms between the two lists, keeping the tree order.
$node_antic=comprova_node_antic2($node->created);
// build the arrays - although this also seems not really necessary - or is it?
$territori = array();

// loading info into the arrays
foreach($iterms as $iterm) {
   $territori[] = $iterm->name; // gets the term with appropriate link

  }

$vegueria = $territori[0];
$comarca = $territori[1];
$municipi = $territori[2];

?>

<div style="font-size:small; text-align:right !important; float:right !important; background-color:#f1f1f1 !important; padding:30px !important; margin-top:0px !important; margin-bottom:0px !important;">
<small>
<?php 
print "<em>Demarcació: </em>".$vegueria."<br />";
print "<em>Comarca: </em>".$comarca."<br />";
print "<em>Municipi: </em>".$municipi."<br />";
?>
</small>
</div>

    <div class="print-logo"><?php print $logoomnia ?></div>
   <h1 class="print-title"><?php print $print['title']; ?></h1>
<div style="clear:both; margin-bottom:20px;"></div>


    <div class="print-content">
<?php if ($node->field_fitxatecnica[0]['value']){ ?>
	<h2>Fitxa tècnica</h2>
<hr />
	<?php print $node->field_fitxatecnica[0]['value'] ?>
	<br /><br />
<?php } ?>
<?php if ($node_antic) { ?>
	<?php if ($node->field_caracteristiquesentorn[0]['value'] and !$node_antic){ ?>
		<h2>Característiques de l'entorn</h2>
		<hr />
		<?php print $node->field_caracteristiquesentorn[0]['value'] ?>
		<br /><br />
	<?php } ?>
	<?php if ($node->field_entitat_gestora[0]['value'] and !$node_antic){ ?>
		<h2>Entitat Gestora</h2>
		<hr />
		<?php print $node->field_entitat_gestora[0]['value'] ?>
		<br /><br />
	<?php } ?>
<?php } ?>
<?php if ($node_antic) { ?>
	<h2>Punt Òmnia</h2>
	<hr />
	<?php if ($node->field_informe_punt_omnia[0]['value']){ ?>
		<?php print $node->field_informe_punt_omnia[0]['value'] ?>
	<?php } ?>

	<?php 
	$valor=false;
	foreach ((array)$node->field_informe_ubicacio as $item) { 
	if ($item['filepath']) $valor=true;
	} ?>
	<?php if ($valor){ ?>
		<div style='text-align:center;'>
		    <?php foreach ((array)$node->field_informe_ubicacio as $item) { ?>
		      <div><?php print theme_image($item['filepath'], $alt = '', $title = '', array('width'=>'500px', 'height'=>'auto', 'style'=>'width:500px; height:auto; text-align:center;'), FALSE); ?></div>
		    <?php } ?>
		</div>
	<?php } ?>
<?php } ?>

<?php if ($node->field_informe_activitats[0]['value']){ ?>
	<h2>Activitats</h2>
<hr />
	<?php print $node->field_informe_activitats[0]['value'] ?>
<?php } ?>

<?php if ($node->field_informe_coord_entitat_gest[0]['value']){ ?>
	<h3>Coordinació amb l'entitat gestora</h3>
	<?php print $node->field_informe_coord_entitat_gest[0]['value'] ?>
<?php } ?>

<?php if ($node_antic) { ?>
	<?php if ($node->field_informe_transversalitat[0]['value']){ ?>
		<h3>Transversalitat amb altres projectes</h3>
		<?php print $node->field_informe_transversalitat[0]['value'] ?>
	<?php } ?>
<?php } ?>

<?php if ($node->field_informe_participacio[0]['value']){ ?>
	<h3>Participació a formació, trobades territorials i jornada anual</h3>
	<?php print $node->field_informe_participacio[0]['value'] ?>
<?php } ?>

<?php if ($node_antic) { ?>
	<?php if ($node->field_inventari_de_maquinari[0]['value'] or $node->field_informe_historicincidencie[0]['value'] or $node->field_valoracio_manteniment[0]['value']){ ?>
		<h3>Valoració tècnica</h3>
		<?php if ($node->field_inventari_de_maquinari[0]['value']){ ?>
			  <h4>Inventari de maquinari</h4>
			<?php print $node->field_inventari_de_maquinari[0]['value'] ?>
		<?php } ?>
		<?php if ($node->field_informe_historicincidencie[0]['value']){ ?>
			  <h4>Històric d'incidències</h4>
			<?php print $node->field_informe_historicincidencie[0]['value'] ?>
		<?php } ?>
		<?php if ($node->field_valoracio_manteniment[0]['value']){ ?>
			  <h4>Valoració del manteniment</h4>
			<?php print $node->field_valoracio_manteniment[0]['value'] ?>
		<?php } ?>
	<?php } ?>
<?php } ?>
<?php if (!$node_antic) { ?>
  <h2>Visualització del Punt</h2>
<hr />
<?php } else { ?>
  <h2>Espais Virtuals</h2>
<hr />
<?php } ?>

<?php if ($node_antic) { ?>
	<ul>
	<?php if ($node->field_informe_webpo_xarxaomnia[0]['value']){ ?>
	  <li>Web del punt dins la xarxa-omnia: <?php print $node->field_informe_webpo_xarxaomnia[0]['value'] ?></li>
	<?php } ?>
	<?php if ($node->field_informe_web_po_altredomini[0]['value']){ ?>
	  <li>Web del punt en un altre domini?: <?php print $node->field_informe_web_po_altredomini[0]['value'] ?></li>
	<?php } ?>
	<?php 
		$valor=false; $x=0;

		foreach ((array)$node->field_informe_link_web as $item) {
			if ($item['url']) {$valor=true; $x++;} 
		}
		if ($valor and $x>1){ ?>
		  <li>Enllaços: <ul>
		    <?php foreach ((array)$node->field_informe_link_web as $item) { ?>
		      <li><?php print $item['url']; ?></li>
		    <?php } ?>
		  </ul></li>
		<?php } 

		if ($valor and $x==1){ ?>
		  <li>Enllaç: <?php foreach ((array)$node->field_informe_link_web as $item) { 
		      print $item['url']; 
		      } ?>
		  </li>
		<?php } ?>
	<?php if ($node->field_informe_blog_en_xarxaomnia[0]['value']){ ?>
	  <li>Bloc del punt dins la xarxa-omnia?: <?php print $node->field_informe_blog_en_xarxaomnia[0]['value'] ?></li>
	<?php } ?>
	<?php if ($node->field_informe_blogpo_altre[0]['value']){ ?>
	  <li>Blog del punt en un altre domini?: <?php print $node->field_informe_blogpo_altre[0]['value'] ?></li>
	<?php } ?>
		<?php 
		$valor=false; $x=0;
		foreach ((array)$node->field_informe_link_blog as $item) {
			if ($item['url']) {$valor=true; $x++;} 
		}
		if ($valor and $x>1){ ?>
		  <li>Enllaços: <ul>
		    <?php foreach ((array)$node->field_informe_link_blog as $item) { ?>
		      <li><?php print $item['url']; ?></li>
		    <?php } ?>
		  </ul></li>
		<?php } 

		if ($valor and $x==1){ ?>
		  <li>Enllaç: <?php foreach ((array)$node->field_informe_link_blog as $item) { 
		      print $item['url']; 
		      } ?>
		  </li>
		<?php } ?>
	</ul>
<?php } else { ?>
	<?php if ($node->field_informe_observacions_webs[0]['value']){ ?>
	  <div><?php print $node->field_informe_observacions_webs[0]['value'] ?></div>
	<?php } ?>
<?php } ?>
<?php if ($node_antic) { ?>
	<?php if ($node->field_informe_observacions_webs[0]['value']){ ?>
	  <h4>Observacions</h4>
	  <div><?php print $node->field_informe_observacions_webs[0]['value'] ?></div>
	<?php } ?>
<?php } ?>


<?php if ($node_antic) { ?>
	<?php if ($node->field_informe_inclou_logos[0]['value']){ ?>
	<ul>
	  <li>Inclou els logotips del Departament de Benestar i Família i el de la Xarxa Òmnia?: <?php print $node->field_informe_inclou_logos[0]['value'] ?></li>
	</ul>
		<?php if ($node->field_informe_observacions_logos[0]['value']){ ?>
		  <h4>Observacions</h4>
		<?php print $node->field_informe_observacions_logos[0]['value'] ?>
		<?php } ?>
	<?php } ?>
<?php } ?>
<?php if ($node_antic) { 
      $valor=false; $x=0;
      foreach ((array)$node->field_informe_altres_xarxes as $item) {
      		if ($item['url']) $valor=true; $x++;
      } 
      if($valor or $node->field_informe_facebook[0]['value'] or $node->field_informe_twitter[0]['value'] or $node->field_informe_ning[0]['value']){ ?>
	  <h3>Presència a les xarxes socials</h3>
	<ul>
		<?php if ($node->field_informe_facebook[0]['value']){ ?>
		  <li>Facebook: <?php print $node->field_informe_facebook[0]['value'] ?></li>
		<?php } ?>
		<?php if ($node->field_informe_twitter[0]['value']){ ?>
		  <li>Twitter: <?php print $node->field_informe_twitter[0]['value'] ?></li>
		<?php } ?>

		<?php 
		if ($valor and $x>1){ ?>
		  <li>Altres: <ul>
		    <?php foreach ((array)$node->field_informe_altres_xarxes as $item) { ?>
		      <li><?php print $item['title']; ?>: <?php print $item['url']; ?></li>
		    <?php } ?>
		  </ul></li>
		<?php } 

		if ($valor and $x==1){ ?>
		  <li><?php print $item['title']; ?>: <?php foreach ((array)$node->field_informe_altres_xarxes as $item) { 
		      print $item['url']; 
		      } ?>
		  </li>
		<?php } ?>




		<?php if ($node->field_informe_ning[0]['value']) { ?>
		  <li>Utilitza el Ning: <?php print $node->field_informe_ning[0]['value'] ?>
			<?php if ($node->field_informe_ning_perque[0]['value']) { ?>
			  <h4>Per què?</h4>
			  <?php print $node->field_informe_ning_perque[0]['value'] ?>
			<?php } ?>
		  </li>
		<?php } ?>
	</ul>
	<br /><br />
      <?php } 
 } ?>

<?php if (!$node_antic) { ?>
  <h3>Respecte a la imatge corporativa del projecte</h3>
		<?php print $node->field_informe_imatge_coorporativ[0]['value']; ?>
<?php } ?>

<?php if ($node->field_propostes_de_millora[0]['value']) { ?>
	  <h2>Propostes de millora</h2>
	<hr />
	<?php print $node->field_propostes_de_millora[0]['value'] ?>
	<br /><br />
<?php } ?>

<?php if (!$node_antic) { ?>
	<?php if ($node->field_inventari_de_maquinari[0]['value']){ ?>
		<h2>Observacions</h2>
		<hr />
		<?php print $node->field_informe_observacions[0]['value'] ?>
	<?php } ?>
<?php } ?>


<?php if (!$node_antic) { ?>
	<?php if ($node->field_inventari_de_maquinari[0]['value'] or $node->field_informe_historicincidencie[0]['value'] or $node->field_valoracio_manteniment[0]['value']){ ?>
		<h2>Valoració tècnica</h2>
<hr />
		<?php if ($node->field_inventari_de_maquinari[0]['value']){ ?>
			  <h4>Inventari de maquinari</h4>
			<?php print $node->field_inventari_de_maquinari[0]['value'] ?>
		<?php } ?>
		<?php if ($node->field_informe_historicincidencie[0]['value']){ ?>
			  <h4>Històric d'incidències</h4>
			<?php print $node->field_informe_historicincidencie[0]['value'] ?>
		<?php } ?>
		<?php if ($node->field_valoracio_manteniment[0]['value']){ ?>
			  <h4>Valoració del manteniment</h4>
			<?php print $node->field_valoracio_manteniment[0]['value'] ?>
		<?php } ?>
	<?php } ?>
<?php } ?>
<?php if ($node_antic) { ?>
	<?php if ($node->body) { ?>
		  <h2>Observacions</h2>
		<hr />
		<?php print $node->body ?>
	<?php } ?>
<?php } ?>


</div>
<?php
$user_fields = user_load($node->uid);
$firstname = $user_fields->field_firstname['und']['0']['value'];
$lastname = $user_fields->field_lastname['und']['0']['value'];
?>

<?php 
$result = db_query("SELECT 
profile.field_nom_value,
profile.field_surname1_value,
profile.field_surname2_value
FROM node node 
LEFT JOIN content_type_profile profile ON node.vid = profile.vid
WHERE node.type = 'profile' AND node.uid=".$node->uid);
 while ($autor = db_fetch_object($result)) {
      $nom=$autor->field_nom_value;
      $cognom1=$autor->field_surname1_value;
      $cognom2=$autor->field_surname2_value;
    }
if (!$nom && !$cognom1 && !$cognom2){$usuari=user_load($node->uid); $nom=$usuari->name;}
?>
<div class="print-footer"><div><?php print $nom." ".$cognom1." ".$cognom2; ?> - <?php print format_date($node->created, "custom", "j/m/Y"); ?></div></div>

  </body>
</html>


<?php 
// util per diferencia la plantilla actual de l'antiga plantilla
function comprova_node_antic2($data){
	$data_node = strtotime(format_date($data, "custom", "Y-m-d")); 
	$data_actualitzacio_informe = strtotime("2012-09-17"); 
	if ($data_actualitzacio_informe >= $data_node) return true; 
	else return false;
}
?>



