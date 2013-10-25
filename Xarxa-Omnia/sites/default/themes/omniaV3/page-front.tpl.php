<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="<?php print $language->language ?>" xml:lang="<?php print $language->language ?>" dir="<?php print $language->dir ?>">
<head>
<title><?php print $head_title ?></title>
<?php print $head ?><?php print $styles ?><?php print $scripts ?>
<link rel="shortcut icon" href="<?php print path_to_theme() .'/favicon.ico' ?>" type="image/x-icon" />
<script type="text/javascript"><?php /* Needed to avoid Flash of Unstyle Content in IE */ ?> </script>

<!--  Accessibilitat -->
<script src="<?php print path_to_theme() .'/js/accessibilitat.js' ?>" type="text/javascript"></script>

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
            |-> contingut-portada
            |-> portada_columna_esquerra
                |-> destacats
                |-> fotos
    |-> panell
    	|-> logotip
        |-> menu
    |-> peu
-->

<div id="contenidor" class="portada">
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
      
   <!-- INICI CONTINGUT ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ -->
    <div id="contingut" class="port">
    
    	<!-- Inici contingut-portada columna dreta -->
      	<div id="contingut-portada">
        	<?php if ($title!=""){ ?><?php print $title; ?><?php } ?>
            <?php if ($tabs){ ?><?php print $tabs; ?><?php } ?>
    		<?php if ($help){ ?><?php print $help; ?><?php } ?>
            <?php if ($messages){ ?><?php print $messages; ?><?php } ?>
            <?php if ($content){ ?><?php print $content; ?><?php } ?>
     	</div>
     	<!-- Fi contingut-portada columna dreta -->
     
    	<!-- inici PORTADA_COLUMNA_ESQUERRA ===================================================================== -->
      	<div id="portada_columna_esquerra">
      	
    		<!-- inici DESTACATS -->
            <div id="destacats">
		      <?php print $destacats; ?>
		      <?php // relacions PO i dinamitzador (nid present a l'url)
/*	if (in_array('administradors',$GLOBALS['user']->roles)) { 
		print "<p>proves</p>";
    global $current_view;
    $view2 = views_get_view('llistat_punts_omnia');                    
    $vista2 = views_embed_view('llistat_punts_omnia',$display_id='block_2',$current_view->args);
      if ($vista2) { 
		print $vista2; }
	}*/
    ?>
            </div>
       	 	<!-- fi DESTACATS -->
      
     	 </div>
     	 <!--  fi PORTADA_COLUMNA_ESQUERRA ===================================================================== -->

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

        <div id="sidebar-left" class="sidebar">
    	<div id="utilitats"> <?php print $left ?> </div>

	<!-- fi Menu -->

</div>
<!-- FI PANELL MENU ESQUERRA //////////////////////////////////////////////////////////////////////////////////// -->


</div> <!-- fi contenidor -->

<?php print $closure ?>
</body>
</html>
