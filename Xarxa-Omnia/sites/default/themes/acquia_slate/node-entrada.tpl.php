<?php
// $Id: node.tpl.php,v 1.3 2010/07/02 23:14:21 eternalistic Exp $
?>

<div id="node-<?php print $node->nid; ?>" class="node <?php print $node_classes; ?>">


  <div class="inner">


    <?php if ($page == 0): ?>
    <h2 class="title"><a href="<?php print $node_url ?>" title="<?php print str_replace('"', '\'', $title); ?>" lang="ca"><?php print $title ?></a></h2>
    <?php endif; ?>



<!-- dreta -->
<div class="node-dreta">
	<div class="field field-type-filefield imatge-node">
	    <div class="field-items">
		    <div class="field-item odd">
		        	<a href="<?php print '/'.$node->field_imatge[0][filepath]; ?>" title="<?php print str_replace('"', '\'', $node->field_imatge[0][data][title]); ?>" class="thickbox" rel="gallery-<?php print $node->field_imatge[0][fid]; ?>" lang="ca">
					<img src="/<?php print $node->field_imatge[0][filepath]; ?>" alt="<?php print str_replace('"', '\'', $node->field_imatge[0][data][alt]); ?>" title="<?php print str_replace('"', '\'', $node->field_imatge[0][data][title]); ?>" class="imagecache imagecache-node_sencer" />
				</a>       
		    </div>
	    </div>
	</div>

<div class="dades-node">
    <?php print $picture ?>
    <?php if ($submitted): ?>
    <div class="meta">
      <span class="submitted"><?php //print $submitted ?>
      <?php print theme('username', $node) ?></span>&nbsp;— <?php print format_date($node->created, 'custom', 'D, d M Y'); ?>

<?php
$sql="SELECT po.title,
node_data_field_punt.field_punt_nid AS nid
 FROM node node 
 LEFT JOIN content_type_relacio node_data_field_user ON node.vid = node_data_field_user.vid
 LEFT JOIN content_field_punt node_data_field_punt ON node.vid = node_data_field_punt.vid
LEFT JOIN node AS po ON po.type ='content_punt' AND po.nid=node_data_field_punt.field_punt_nid
 WHERE node.type='relacio' AND node_data_field_user.field_user_uid = ".$node->uid." 
AND node_data_field_user.field_status_value='Active'";


	$po=db_result(db_query($sql));
$result = db_query($sql);
while($po = db_fetch_object($result)){

	$nom_po=$po->title;
	$output .= '<div class="node-submitted-po"><a href="/node/' . $po->nid . '" title="' . $po->title . '">' . $po->title . '</a></div>';
}

print $output;

?>

      	<?php $types = array('entrada', 'news', 'story', 'event', 'blog', 'forum', 'job');  // put your allowed types in here, one or more.
	if (arg(0) == 'node' && ctype_digit(arg(1)) && is_null(arg(2))) {
		$node = node_load(arg(1));
		if ($node && in_array($node->type, $types)) { ?>
		  <div class="service_links"><?php print $service_links ?></div>
		<?php }
	} ?>
	
    </div>
    <?php endif; ?>


    <?php if ($terms): ?>
    <div class="terms">
      <div class="terms-inner">
<?php $terms = acquia_separate_terms($node->taxonomy); ?>
        <?php print $terms[21]; ?>

      </div>
    </div>
    <?php endif; ?>


  <?php if ($node_bottom && !$teaser): ?>
  <div id="node-bottom" class="node-bottom row nested">
    <div id="node-bottom-inner" class="node-bottom-inner inner">
      <?php print $node_bottom; ?>
    </div><!-- /node-bottom-inner -->
  </div><!-- /node-bottom -->
  <?php endif; ?>

</div>
</div>
<!-- fi dreta -->


<div class="node-esquerra">
    <?php if ($node_top && !$teaser): ?>
    <div id="node-top" class="node-top row nested">
      <div id="node-top-inner" class="node-top-inner inner">
        <?php print $node_top; ?>
      </div><!-- /node-top-inner -->
    </div><!-- /node-top -->
    <?php endif; ?>

    <div class="content clearfix">


      <?php print $content; ?>

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

if ( ($location['latitude'] != 0) && ($location['longitude'] != 0) && ($teaser != 1) ) { ?>
	<br class="clear" />
	<div class="node_entrada_mapa">
	<h2>Mapa de l'esdeveniment</h2>
	
	<?php 
	$points = array(
     'id' => 'map'.$node->nid,
     'width' => '100%',
     'height' => '255px',
     'latitude' => $location['latitude'],
     'longitude'=> $location['longitude'],
     'zoom' => 15,
     'controls' => 'Small',
     'mtc' => 'Off',
     'maptype' => 'Map',
     'markers' => array(array(
       'markername' => 'green',
       'markermode'=> 1,
       'text'=> '<div class="node-mapa-titol";>' . $node->title . '</div><div class="node-mapa-nom">' . $location['name'] . '</div><div class="node-mapa-carrer">' . $location['street'] . '</div><div class="node-mapa-codipostal">' . $location['postal_code'] . ' ' . $location['city'] . '</div>',
       'opts'=> array('title'=> $node->title),
       'latitude' => $location['latitude'], 
       'longitude' => $location['longitude'], 
        )),
      );
    print theme('gmap', array('#settings' => $points));
    
    ?>
    
    </div>
	<br class="clear" />

<?php } ?>

    <?php if ($links && !$teaser): ?>
    <br class="clear" />
    <div class="links">
      <div class="links-inner">
        <?php print $links; ?>
      </div>
    </div>
    <?php endif; ?>

    </div>



</div>





<div class="clear"></div>
  </div><!-- /inner -->

</div><!-- /node-<?php print $node->nid; ?> -->
