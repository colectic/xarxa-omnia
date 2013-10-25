<?php
// $Id: node.tpl.php,v 1.3 2010/07/02 23:14:21 eternalistic Exp $
?>

<div id="node-<?php print $node->nid; ?>" class="node <?php print $node_classes; ?>">
  <div class="inner">
    <?php print $picture ?>


    <?php if ($node_top && !$teaser): ?>
    <div id="node-top" class="node-top row nested">
      <div id="node-top-inner" class="node-top-inner inner">
        <?php print $node_top; ?>
      </div><!-- /node-top-inner -->
    </div><!-- /node-top -->
    <?php endif; ?>

    <div class="content clearfix">


<?php $valida=valida_rol(); 

$po=node_load($node->field_punt[0]['nid']);
?>

<?php if ($valida){ ?>

	<div class="llista-arxius">
	    <?php foreach((array)$node->files as $fileobj){ ?>
	      <div class="item-arxiu">
		<?php

		$ruta="system/".$fileobj->filepath;
		$carpetes = explode("/",$ruta);
		
		?>
    <h2><?php print l($title, $ruta); ?></h2>


<?php 
if ($node->uid!=0) {$usuari = user_load(array('uid' => $node->uid)); $nom_usuari=$usuari->name;}

?>

    <div><strong>Nom de l'arxiu:</strong> <?php print l($fileobj->filename, $ruta); ?></div>
    <div><strong>Origen:</strong> <?php print $po->title; ?></div>
    <div><strong>Data:</strong> <?php print $node->field_dataarxiu[0]['view']; ?></div>
    <div><strong>Ruta:</strong> <?php print $ruta; ?></div>
    <div><strong>Tamany:</strong> <?php print $fileobj->filesize; ?> bytes</div>
    <div><strong>Tipu:</strong> <?php print $fileobj->filemime; ?></div>
<?php
	if (in_array('OT', array_values($usuari->roles))) $oficina = "oficina de seguiment"; 
	if (in_array('DGAC', array_values($usuari->roles))) $oficina = "DGAC";
	if (in_array('ODC', array_values($usuari->roles))) $oficina = "oficina d'inserció social"; 
?>

<?php if ($nom_usuari){?> <div><strong>Autor:</strong> <?php print $usuari->name. " (".$oficina.")"; ?></div> <?php } ?>

	<?php $rut=rawurlencode("http://xarxa-omnia.org/".$ruta); ?>


	<?php
	$document = array("application/pdf", "application/msword", "application/vnd.oasis.opendocument.text", "application/vnd.ms-excel", "application/vnd.ms-powerpoint");
	$imatge = array("image/jpeg", "image/png", "image/gif"); 

	if (in_array($fileobj->filemime, $document)){ ?> 
	<div style='text-align:center;' class='view-arxiu'>
	<iframe src="http://docs.google.com/viewer?url=<?php print $rut; ?>&embedded=true" width="600" height="780" style="border: none;"></iframe>
	</div>
	<?php } ?>
		<?php if (in_array($fileobj->filemime, $imatge)){ ?>
			<div class="item-imatge">
			<div class="field field-type-filefield imatge-node">
				    <div class="field-items">
					    <div class="field-item odd">

			<?php 
			$x++;
			$rel='gallery-'.$nid;
			print '<a href="/'.$ruta.'" class="thickbox" rel="'.$rel.'">';
			print '<img src="/'.$ruta.'" alt="'.$fileobj->filename.'" title="'.$fileobj->filename.'" class="imagecache imagecache-node_sencer" />';
			print "</a>"; ?>
					    </div>
				    </div>
				</div>
			</div>
	<?php } ?>
		<?php } ?>
	      	</div>
	    	
	</div>

<?php } ?>
    </div>

  </div><!-- /inner -->

  <?php if ($node_bottom && !$teaser): ?>
  <div id="node-bottom" class="node-bottom row nested">
    <div id="node-bottom-inner" class="node-bottom-inner inner">
      <?php print $node_bottom; ?>
      <?php //print drupal_get_form('subscriptions_ui_node_form', $node, $user); ?>
    </div><!-- /node-bottom-inner -->
  </div><!-- /node-bottom -->
  <?php endif; ?>
</div><!-- /node-<?php print $node->nid; ?> -->

<?php 
function valida_rol(){
	global $user;
	if (in_array('administradors',$user->roles) or in_array('DGAC',$user->roles) or in_array('ODC',$user->roles) or in_array('OT',$user->roles)){
		return true; 
	}
	else{
		return false;	
	}
} ?>
