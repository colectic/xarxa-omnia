<?php if ($page == 0) { // TEASER DEL NODE + + + + ++ + + + + ++ + + + + ++ + + + ++ + ?>
 
	<div class="node node-portada <?php if ($sticky) { print " sticky"; } ?><?php if (!$status) { print " node-unpublished"; } ?>">

	<?php if (!$page) { ?>
		<h2 class="title"><a href="<?php print $node_url?>"><?php print $title?></a></h2>
	<?php }; ?>

	<span class="submitted"><?php print $submitted?></span>
		
	<?php //print $node->content['image_attach']['#value']; ?>
		
	<div class="content"><?php print $content; ?></div>

	<div class="taxonomy"><?php print $terms?></div>

	<?php if ($links) { ?>
		<div class="links"><?php print $links?></div>
	<?php } ?>
	
	</div>

<?php } else { // NODE SENCER + + + + + + + + ++   ++ + + + + + + + + + +  ?>

	<div class="node <?php if ($sticky) { print " sticky"; } ?><?php if (!$status) { print " node-unpublished"; } ?>">

	<?php if (!$page) { ?>
		<h2 class="title"><a href="<?php print $node_url?>"><?php print $title?></a></h2>
	<?php }; ?>

	<?php if ($picture) {print $picture;}?>

	<div id="node_capcalera">
	<div class="submitted"><?php print $submitted?></div>

	<?php $types = array('entrada', 'news', 'story', 'event', 'blog', 'forum', 'job');  // put your allowed types in here, one or more.
	if (arg(0) == 'node' && ctype_digit(arg(1)) && is_null(arg(2))) {
		$node = node_load(arg(1));
		if ($node && in_array($node->type, $types)) { ?>
		  <div class="service_links"><?php print $service_links ?></div>
		<?php }
	} ?>
	</div>
	
	<!--<div class="bloc_esquerra">-->
		<?php //print $node->content['image_attach']['#value'];?>
	<!--</div>-->
	
	<div class="content"><?php print $content; ?></div>

	<?php $types = array('entrada', 'news', 'story', 'intern');  // put your allowed types in here, one or more.
	if (arg(0) == 'node' && ctype_digit(arg(1)) && is_null(arg(2))) {
		$node = node_load(arg(1));
		if ($node && in_array($node->type, $types)) { ?>
			<div class="taxonomy"><?php print $terms ?></div>
		<?php }
	} ?>
	
	<?php if ($node->relatedlinks && $page) { ?>
		<div class="related-links">
			<h3>Enllaços relacionats</h3>
			<ul>
			<?php
				foreach ($node->relatedlinks as $relatedlinks){
      					foreach ($relatedlinks as $link){
						printf('<li><a href="%s">%s</a></li>', $link[url], $link[title]);
					}
				} ?>
			</ul>
    		</div>
	<?php } ?>

	<?php if ($links) { ?>
		<div class="links"><?php print $links?></div>
	<?php } ?>
	
	</div>
	
	<?php print drupal_get_form('subscriptions_ui_node_form', $node, $user); ?>
	
<?php } ?>

