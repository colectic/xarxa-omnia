<?php

/**
 * @file media_bliptv/themes/media-bliptv-flash-embed.tpl.php
 *
 * Theme template for theme('media_bliptv_flash_embed').
 */
?>
  <embed id="media-bliptv-flash-embed-<?php print $id; ?>"
    width="<?php print $width; ?>"
    height="<?php print $height; ?>"
    src="<?php print $src; ?>"
    type="application/x-shockwave-flash"
    allowscriptaccess="<?php print $allowscriptaccess; ?>"
    allowfullscreen="<?php print $allowfullscreen; ?>"
    wmode="<?php print $wmode; ?>">
  </embed>
