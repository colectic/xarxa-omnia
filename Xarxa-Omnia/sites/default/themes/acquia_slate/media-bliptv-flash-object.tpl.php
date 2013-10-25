<?php

/**
 * @file media_bliptv/themes/media-bliptv-flash-object.tpl.php
 *
 * Theme template for theme('media_bliptv_flash_object').
 */
?>
<?php 
$search = array('%2F', '&','%3A');
$replace = array('/', '&amp;',':');
$ruta = str_replace($search, $replace, $src);
?>

  <object id="media-bliptv-flash-object-<?php print $id; ?>" classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,40,0" width="<?php print $width; ?>" height="<?php print $height; ?>">
    <param name="movie" value="<?php print $ruta; ?>" />
    <param name="quality" value="<?php print $quality; ?>" />
    <param name="bgcolor" value="<?php print $bgcolor; ?>" />
    <param name="wmode" value="<?php print $wmode; ?>" />
    <param name="allowfullscreen" value="<?php print $allowfullscreen; ?>" />

    <!--[if !IE]> <-->
    <object id="media-bliptv-flash-object-inner-<?php print $id; ?>" data="<?php print $ruta; ?>" width="<?php print $width; ?>" height="<?php print $height; ?>" type="application/x-shockwave-flash">
    <param name="quality" value="<?php print $quality; ?>" />
    <param name="bgcolor" value="<?php print $bgcolor; ?>" />
    <param name="allowfullscreen" value="<?php print $allowfullscreen; ?>" />
    <param name="pluginurl" value="http://www.adobe.com/go/getflashplayer" />
    <param name="wmode" value="<?php print $wmode; ?>" />
    <?php print $noflash; ?>
    </object>
    <!--> <![endif]-->
  </object>
