<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="<?php print $language->language ?>" xml:lang="<?php print $language->language ?>" dir="<?php print $language->dir ?>">
<head>
<title><?php print $head_title ?></title>
<?php print $head ?><?php print $styles ?><?php print $scripts ?>
<link rel="shortcut icon" href="<?php print path_to_theme() .'/favicon.ico' ?>" type="image/x-icon" />
<script type="text/javascript"><?php /* Needed to avoid Flash of Unstyle Content in IE */ ?> </script>

<!--  Accessibilitat -->
<script src="sites/xarxa-omnia.org/themes/omniaV3/js/accessibilitat.js" type="text/javascript"></script>

<!-- Fulla d'estil per a tots els Internet Explorer -->
	<!--[if IE]>
		<link rel="stylesheet" type="text/css" href="<?php print path_to_theme() .'/style_ie.css' ?>" />
	<![endif]--> 

<!-- Fulla d'estil per a els Internet Explorer v.6 o inferiors -->
	<!--[if lte IE 6]> 
		<link rel="stylesheet" type="text/css" href="<?php print path_to_theme() .'/style_ie6.css' ?>" />
	<![endif]--> 

</head>
<body<?php print phptemplate_body_class($left, $right); ?>>
<!--
contenidor
	|-> pagina
        |-> capcalera
        	|-> primary
            |-> secondary
            |-> site-slogan
            |-> mission
            |-> cercador
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
        <div class="accessibilitat"><span class="descripcio">Mida del text: </span>
			<a href="#" onmouseout="MM_swapImgRestore()" onclick="zoomText('disminuir','contenidor')" class="petit" title="Disminuir" lang="ca">A</a>
			<a href="#" onmouseout="MM_swapImgRestore()" onclick="zoomText('aumentar','contenidor')" class="gran" title="Aumentar" lang="ca">A</a>
		</div>
		
      <?php if (isset($primary_links)) { ?>
        <div id="primary"><?php print theme('links', $primary_links, array('class' =>'links', 'id' =>'navlist')) ?></div>
      <?php } ?>
      
	  <?php if (isset($secondary_links)) { ?>
        <div id="secondary"><?php print theme('links', $secondary_links, array('class' =>'links', 'id' =>'navlist')) ?></div>
      <?php } ?>
      
	  <?php if ($site_slogan) { ?>
      	<div class='site-slogan'><?php print $site_slogan ?></div> <!-- Slogan: "Accés a les noves tecnologies per tothom." -->
      <?php } ?>
      
      <?php if ($mission) { ?>
      	<div id="descripcio"><?php print $mission ?></div> <!-- Descripcio del web: Òmnia significa... -->
      <?php } ?>

	  <?php if ($search_box) { ?>
      	<div id="cercador"><?php print $search_box ?></div> <!-- cercador -->
      <?php } ?>
    </div>
<!-- FI HEADER ################################################################################################### -->

	<!-- INICI FILTRES ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ -->
    <div id="filtres">
        <?php if ($filtres){ ?><?php print $filtres ?><?php } ?>
    </div>
    <!-- FI FILTRES ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ -->
	
   <!-- INICI CONTINGUT ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ -->
    <div id="contingut">
		<?php /*print $breadcrumb*/ ?>
       	<?php if ($title!=""){ ?><div class="titol"><?php print $title; ?></div><?php } ?>
        <div class="tabs"><?php print $tabs ?></div>
        <?php if ($show_messages){ ?><?php print $messages; ?><?php } ?>
 		<?php if ($help){ ?><?php print $help; ?><?php } ?>
        <?php if ($content){ ?><?php print $content; ?><?php } ?>
        <?php print $feed_icons ?>
    </div>
    <!-- FI CONTINGUT ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ -->
    
    <!-- PEU PAGINA ************************************************************************************************* -->
    <div id="peu"><?php print $footer_message . $footer ?></div>
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
      <?php if ($left): ?>
        <div id="sidebar-left" class="sidebar">
    	<div id="utilitats"> <?php print $sidebar_left . $left ?> </div>
   	  <?php endif; ?>
	<!-- fi Menu -->

</div>
<!-- FI PANELL MENU ESQUERRA //////////////////////////////////////////////////////////////////////////////////// -->


</div> <!-- fi contenidor -->

<?php print $closure ?>
</body>
</html>
