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
    <?php if (!empty($print['message'])) {
      //print '<div class="print-message">'. $print['message'] .'</div><p />';
    } ?>

<?php 
$logoomnia=theme_image('http://xarxa-omnia.org/sites/xarxa-omnia.org/themes/acquia_slate/images/logotip_omnia.png',  $alt = 'Logotip Xarxa Òmnia', $title = 'Logotip Xarxa Òmnia', array('width'=>'199', 'height'=>'65', 'style'=>'float:right;'), FALSE);


$logogene=theme_image('http://xarxa-omnia.org/sites/xarxa-omnia.org/themes/omniaV3/css/benestar_h3.png',  $alt = 'Logotip Generalitat de Catalunya - Departament de Benestar Social i Família', $title = 'Logotip Generalitat de Catalunya - Departament de Benestar Social i Família', array('width'=>'186', 'height'=>'30', 'style'=>'float:left;'), FALSE);
?>


    <div class="print-logo"><?php print $logoomnia ?></div>
   <h1 class="print-title"><?php print $print['title']; ?></h1>
<div style="clear:both; margin-bottom:20px;"></div>


    <div class="print-content">


<?php
	$my_date = strtotime($node->field_dataacta[0]['value']);
   	$tz_offset = strtotime(date("M d Y H:i:s")) - strtotime(gmdate("M d Y H:i:s"));
    	$my_date += $tz_offset;

	$my_date2 = strtotime($node->field_dataacta[0]['value2']);
    	$tz_offset2 = strtotime(date("M d Y H:i:s")) - strtotime(gmdate("M d Y H:i:s"));
    	$my_date2 += $tz_offset2;

    	$data = format_date($my_date, 'custom', 'd/m/Y', NULL);  
    	$horaini=format_date($my_date, 'custom', 'G:i', NULL); 
    	$horafi=format_date($my_date2, 'custom', 'G:i', NULL); 

 ?>



<table style="text-align: left; border:10px solid #000 !important;" border="10" cellpadding="2" cellspacing="2">
<tbody>
<tr style="text-align: left; border:1px solid #000 !important;">
<td style="vertical-align: top; font-size:1em;">
</td>

<td style="vertical-align: top; font-size:1em;">
</td>

<td style="vertical-align: top; font-size:0.8em; width:250px;">Lloc:<br>
</td>
<td style="vertical-align: top; font-size:0.8em; width:250px;"><?php print $node->field_lloc[0]['value']; ?>
</td>
</tr>
<tr style="text-align: left; border:1px solid #000 !important;">
<td style="vertical-align: top; font-size:0.8em; width:250px;">Convocats:
</td>
<td style="vertical-align: top; font-size:0.8em; width:800px;"><?php print $node->field_excusats[0]['value']; ?>
</td>
<td style="vertical-align: top; font-size:0.8em; width:250px; text-align:right;">Lloc:&nbsp;
</td>
<td style="vertical-align: top; font-size:0.8em;"> <?php print $node->field_lloc[0]['value']; ?>
</td>
</tr>
<tr style="text-align: left; border:1px solid #000 !important;">
<td style="vertical-align: top; font-size:0.8em; width:250px;">Assistents:
</td>
<td style="vertical-align: top; font-size:0.8em; width:800px; "><?php print $node->field_assistents[0]['value']; ?>
</td>
<td style="vertical-align: top; font-size:0.8em; width:250px; text-align:right;">Data:&nbsp;
</td>
<td style="vertical-align: top; font-size:0.8em; width:250px;"> <?php print $data; ?>
</td>
</tr>
<tr style="text-align: left; border:1px solid #000 !important;">
<td style="vertical-align: top; font-size:0.8em; width:250px;">
</td>
<td style="vertical-align: top; font-size:0.8em; width:800px; ">
</td>
<td style="vertical-align: top; font-size:0.8em; width:250px; text-align:right;">Hora:&nbsp;
</td>
<td style="vertical-align: top; font-size:0.8em; width:250px;"> <?php print $horaini. " - ". $horafi; ?>
</td>
</tr>
</tbody>
</table>



<p></p>
<h2>Ordre del dia</h2>
<?php print $node->field_ordredeldia[0]['value']; ?>

<h2>&nbsp;</h2>
<h2>Desenvolupament de la sessió</h2>
<?php print $node->body ?>


</div>

  </body>
</html>






