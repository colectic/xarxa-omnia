<?php 
drupal_add_css(drupal_get_path('module', 'omnia_usos') . '/css/omnia_usos.css'); ?>

<div id="dades_us">
	<h2>Dades generals</h2>
	<ul>
		<li><b>Inici: </b><?php echo $start?></li>
		<li><b>Final: </b><?php echo $end?></li>
		<?php if (!is_null($group)) {?> <li><b>Grup/Edició: </b><?php echo $group?></li> <?php }?>
		<?php if (!is_null($campaign)) {?> <li><b>Campanya: </b><?php echo $campaign?></li> <?php }?>		
	</ul>

	<h2>Dades del/les participants</h2>
	<?php echo $users_table?>
	
	<h2>Dades de l'activitat</h2>
	<?php print_r($act_table); ?>
	
	<?php if ($ent_name != '') {?>
		<h2>Dades de l'entitat: <?php echo $ent_name?></h2>
		<?php print_r($ent_table)?>
	<?php }?>

	<h2>Dades del punt Omnia</h2>
	<?php print_r($omnia_table); ?>
</div>