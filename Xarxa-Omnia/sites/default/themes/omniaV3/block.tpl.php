<?php 
if ($is_front){
	if ($block->module=='block' || $block->region=='destacats')
    {
        if ($block->delta%2==0) 
        { ?>
		<div class="destacat block-parell" id="block-<?php print $block->module; ?>-<?php print $block->delta; ?>"> 
        <?php } //estil parell
		else
		{ ?>
        <div class="destacat block-imparell" id="block-<?php print $block->module; ?>-<?php print $block->delta; ?>"> 
        <?php
        } //estil imparell
  	?>			
    	<!-- <div class="titol"><?php //print $block->subject; ?></div> -->
    	<div class="contingut"><?php print $block->content; ?><div class="destacat-peu"></div></div>
        
	</div>
    <?php 
	}
    else { /* codi de block.tpl.php del tema Bluemarine */ ?>
	  <div class="block block-<?php print $block->module; ?>" id="block-<?php print $block->module; ?>-<?php print $block->delta; ?>">
		<h2 class="title"><?php print $block->subject; ?></h2>
		<div class="content"><?php print $block->content; ?></div>
	 </div>
    <?php 
	} 
}
else { /* aqui també el codi de block.tpl.php del tema Bluemarine */
?>
  <div class="block block-<?php print $block->module; ?>" id="block-<?php print $block->module; ?>-<?php print $block->delta; ?>">
	<h2 class="title"><?php print $block->subject; ?></h2>
	<div class="content"><?php print $block->content; ?></div>
 </div>

<?php
} ?>
