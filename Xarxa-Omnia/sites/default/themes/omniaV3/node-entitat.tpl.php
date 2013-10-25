<?php 
print '<div class="node';
if ($sticky) print " sticky"; if (!$status) print " node-unpublished";
print ' entitat">'; ?>
	<?php if (!$page) { ?>
		<h2 class="title"><a href="<?php print $node_url?>"><?php print $title?></a></h2>
	<?php }; ?>
	<?php if ($picture) {print $picture;}?>
	<span class="submitted"><?php print $submitted?></span>
	<?php if ($node->op == 'Preview' && !$vars['teaser']) { ?>
	<p style="color: red;">Aquesta previsualitzaci&oacute; no reflecteix el disseny final de la fitxa. Encara que hagis triat el municipi, seleccionat la tipologia i geolocalitzat l'entitat en el mapa, no apareixen encara. Per veure el disseny complet has de desar la pàgina, gracies.</p>
	<?php } ?>
	<div class="content"><?php // print $content; ?>
	<?php if (!$node->op == 'Preview' && !$vars['teaser']) { ?>
<?php
// snippet per separar la taxonomia amb ID 18 (vegueria-comarca-municipi)
$vid = 18;
$treeterms = taxonomy_get_tree($vid, 0, 0); // Gets list of ALL taxonomy terms in tree order
$nodeterms = taxonomy_node_get_terms_by_vocabulary($node->nid, $vid); // Gets taxonomy terms assigned to the current node only.
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
$textmapa = $node->title . "<div class='mapa-lesmeves-municipi'>" . $municipi . "</div>";


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
print "<div class='punt-fitxa field_punttic_mapa'>";
  $points = array(
     'id' => 'map'.$node->nid,
     'width' => '400px',
     'height' => '260px',
     'latitude' => $location['latitude'],
     'longitude'=> $location['longitude'],
     'zoom' => 15,
     'controls' => 'Small',
     'mtc' => 'Off',
     'maptype' => 'Map',
     'markers' => array(array(
       'markername' => 'green',
       'markermode'=> 1,
       'text'=> $textmapa,
       'opts'=> array('title'=> $node->title),
       'latitude' => $location['latitude'], 
       'longitude' => $location['longitude']
        )),
      );
    print theme('gmap', array('#settings' => $points));
print "</div>";
}
} ?>
<p class="field-punt-referencia"><strong>Punt &Ograve;mnia de referencia</strong></p>
<p><?php print $node->field_puntomnia_entitat[0]['view'] ?></p>
<?php if (!$node->op == 'Preview' && !$vars['teaser']) { ?>
<p><strong>Tipologia</strong></p>
<p><?php
print omniaV3_print_terms($node, 19);
?></p>
<?php } ?>
<?php if ($field_entitat_web[0]['view']): ?>
<p><strong>P&agrave;gina web</strong></p>
<p><?php print $node->field_entitat_web[0]['view'] ?></p>
<?php endif;?>
</div>
</div>
