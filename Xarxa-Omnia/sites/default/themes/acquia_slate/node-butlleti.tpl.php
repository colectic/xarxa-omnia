<?php
// $Id: node.tpl.php,v 1.3 2010/07/02 23:14:21 eternalistic Exp $
?>

<div id="node-<?php print $node->nid; ?>" class="node <?php print $node_classes; ?> node-butlleti">
  <div class="inner">
  
    <?php if ($node_top && !$teaser): ?>
    <div id="node-top" class="node-top row nested">
      <div id="node-top-inner" class="node-top-inner inner">
        <?php print $node_top; ?>
      </div><!-- /node-top-inner -->
    </div><!-- /node-top -->
    <?php endif; ?>

    <div class="content clearfix">
      <?php print $content ?>
    </div>
  </div><!-- /inner -->


</div><!-- /node-<?php print $node->nid; ?> -->
