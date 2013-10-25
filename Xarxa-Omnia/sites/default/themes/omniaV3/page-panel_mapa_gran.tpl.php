<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="<?php print $language->language ?>" xml:lang="<?php print $language->language ?>" dir="<?php print $language->dir ?>">
<head>
<title><?php print $head_title ?></title>
<?php print $head ?><?php print $styles ?><?php print $scripts ?>
<link rel="shortcut icon" href="<?php print 'http://xarxa-omnia.org/' . path_to_theme() .'/favicon.ico' ?>" type="image/x-icon" />
<script type="text/javascript"><?php /* Needed to avoid Flash of Unstyle Content in IE */ ?> </script>

<!--  Accessibilitat
<script src=" print 'http://xarxa-omnia.org/' . path_to_theme() .'/js/accessibilitat.js' " type="text/javascript"></script> -->

<!-- Fulla d'estil per a tots els Internet Explorer -->
	<!--[if IE]>
		<link rel="stylesheet" type="text/css" href="<?php print 'http://xarxa-omnia.org/' . path_to_theme() .'/style_ie.css' ?>" />
	<![endif]--> 

<!-- Fulla d'estil per a els Internet Explorer v.6 o inferiors -->
	<!--[if lte IE 6]> 
		<link rel="stylesheet" type="text/css" href="<?php print 'http://xarxa-omnia.org/' . path_to_theme() .'/style_ie6.css' ?>" />
	<![endif]--> 

</head>
<body>
<!--
contenidor
	|-> pagina
        |-> capcalera
        	|-> primary
            |-> secondary
        |-> contingut
    |-> panell
    	|-> logotip
        |-> menu
    |-> peu
-->

<div id="contenidor">

  <div id="pagina"> 
  		<?php print $header ?>
    
<!-- HEADER ##################################################################################################### -->  
	<div id="capcalera">
      <?php if (isset($primary_links)) { // no mostrem ni els primary ni els secondary links ?>
        <div class="titol" style="padding: 20px 15px 5px 0px; font-size: 24px; font-family: Verdana,Arial,Helvetica,sans-serif;">Mapa del Punts Òmnia i entitats</div>
		<div class="enllac-mapa-petit" style="padding-left: 0px"><a href="mapa_punts_i_entitats">Tornar al mapa normal</a></div>
      <?php } ?>
      
	  <?php if (isset($secondary_links)) { ?>
      <?php } ?>
    </div>
<!-- FI HEADER ################################################################################################### -->      

	<!-- INICI FILTRES ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ -->
    <div id="filtres">        
        <?php if ($filtres){ ?><?php print $filtres; ?><?php } ?>        	          
    </div> 
    <!-- FI FILTRES ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ -->
	
   <!-- INICI CONTINGUT ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ -->
    <div id="contingut">   
       	<?php if ($title!=""){ ?><div class="titol"><?php print $title; ?></div><?php } ?>
        <?php if ($tabs){ // no imprimem les pestanyes del panell ?><?php } ?>
 		<?php if ($help){ ?><?php print $help; ?><?php } ?>
        <?php if ($messages){ ?><?php print $messages; ?><?php } ?>
        <?php if ($content){ ?><?php print $content; ?><?php } ?>         
    </div> 
    <!-- FI CONTINGUT ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ -->
    
    <!-- PEU PAGINA ************************************************************************************************* -->
    <div id="peu"><?php print $footer_message ?></div>
    <?php print $closure ?>
	<!-- FI PEU PAGINA ********************************************************************************************** -->
    
    </div> <!-- Fi id=pagina -->
    
<!-- INICI PANELL MENU ESQUERRA ////////////////////////////////////////////////////////////////////////////////// -->
<div id="panell">
	<!-- logotip omnia -->     
  	<?php if ($site_name) { ?>
 	   <div class="site-name"><a href="<?php print $base_path ?>" title="<?php print t('Home') ?>"><img src="<?php print base_path() . path_to_theme() .'/css/titol.png' ?>" alt="Logotip Xarxa Òmnia" /></a></div>
  	<?php } ?>
	<!-- fi logotip omnia -->
    
	<!-- Inici menu -->    
   	 <?php if ($sidebar_left) { // no mostrem la barra de navegació esquerra ?>
   	 <?php } ?>
	<!-- fi Menu -->

</div>
<!-- FI PANELL MENU ESQUERRA //////////////////////////////////////////////////////////////////////////////////// -->


</div> <!-- fi contenidor -->
</body>
</html>
