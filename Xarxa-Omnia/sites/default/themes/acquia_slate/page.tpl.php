<?php
// $Id: page.tpl.php,v 1.4 2010/07/02 23:14:21 eternalistic Exp $
?>
<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="<?php print $language->language; ?>" xml:lang="<?php print $language->language; ?>">

<head>
<meta http-equiv="content-language" content="CA" />
<meta name="language" content="Catalan" /> 
<meta name="author" content="Oficina Técnica Xarxa Òmnia" />
<meta name="Description" content="Web de la Xarxa Òmnia" />
<meta name="keywords" content="xarxa, Òmnia, xarxa, telecentres"  />
<meta name="Copyright" content="Generalitat de Catalunya, 2011" /> 
<meta name="ROBOTS" content="NOARCHIVE" />
<meta name="robots" content="noindex" />
<meta name="google-site-verification" content="GDBSwZ4LONOe4o3At07yAS4bHbkDqTd6i6Fe-MgjPdI" />


  	<title><?php print $head_title; ?></title>

  <?php print $head; ?>
  <?php print $styles; ?>
  <link type="text/css" rel="stylesheet" media="print" href="/sites/xarxa-omnia.org/themes/acquia_slate/css/print.css" />
  <?php print $setting_styles; ?>
  <!--[if IE 8]>
  <?php print $ie8_styles; ?>
  <![endif]-->
  <!--[if IE 7]>
  <?php print $ie7_styles; ?>
  <![endif]-->
  <!--[if lte IE 6]>
  <?php print $ie6_styles; ?>
  <![endif]-->
  <?php if ($local_styles): ?>
  <?php print $local_styles; ?>
  <?php endif; ?>

  <?php print $scripts; ?>

</head>

<body id="<?php print $body_id; ?>" class="<?php print $body_classes; ?> <?php print $skinr; ?>">
<!--[if lte IE 6]><script src="/sites/xarxa-omnia.org/themes/acquia_slate/js/ie6/warning.js"></script><script>window.onload=function(){e("/sites/xarxa-omnia.org/themes/acquia_slate/js/ie6/")}</script><![endif]-->

  <div id="page" class="page">
    <div id="page-inner" class="page-inner">

      <div id="skip">
        <a href="#main-content-area" lang="ca" title="Salta al contingut principal" tabindex="1" accesskey="s">Salta al contingut principal</a>
      </div>

      <!-- header-top row: width = grid_width -->
      <?php print theme('grid_row', $header_top, 'header-top', 'full-width', $grid_width); ?>
      
              <!--inici barra eines-->
		<div id="header-links-frame">
				<p id="logo-gencat"><a href="http://www.gencat.cat/" class='new-window' lang="ca" title="Generalitat de Catalunya" tabindex="-1"><img src="http://www.gencat.cat/img/logo.gif" alt="Generalitat de Catalunya" /></a></p>
				
				<div id="header-links">
					<ul>
						<li class="<?php if ($is_front) {print 'leaf active-trail';} else{print 'leaf';} ?> first"><a href="/" title="Ves a la pàgina d'inici" lang="ca" tabindex="2" accesskey="1" rel="start" <?php if ($is_front) {print "class='link active'";} else{print "class='link'";} ?>>Inici</a></li>
						<li class="<?php acquia_actiu('contact', 'li'); ?>"><a href="/contact" title="Contacta amb la Xarxa Òmnia" lang="ca" tabindex="3" accesskey="2" class="<?php acquia_actiu('contact', 'a'); ?>">Contacta</a></li>
						<li class="<?php acquia_actiu('mapa_web', 'li'); ?>"><a href="/mapa_web" title="Mapa del Web" lang="ca" tabindex="4" accesskey="3" class="<?php acquia_actiu('mapa_web', 'a'); ?>">Mapa Web</a></li>
						<?php global $user;
						if ($user->uid) { 						
						$usuari='user/'.$user->uid;
						?>
						<li class="<?php acquia_actiu($usuari, 'li'); ?>"><a href="/user" title="El meu compte" lang="ca" tabindex="5" accesskey="4" class="<?php acquia_actiu($usuari, 'a'); ?>">El meu compte</a></li>
						<?php } else { ?>
						<li class="<?php acquia_actiu('user/login', 'li'); ?>"><a href="/user/login" title="Intranet" lang="ca" tabindex="6" accesskey="5" class="<?php acquia_actiu('user/login', 'a'); ?>">Intranet</a></li>
						<?php } ?>
					</ul>		
					<?php print $search_box ?>				
				</div>
			</div>
			<!--fi barra eines-->

      <!-- header-group row: width = grid_width -->


      <div id="header-group-wrapper" class="header-group-wrapper <?php if ($preface_top) { echo "with-preface-top"; } else { echo "without-preface-top"; }?> full-width">
        <div id="header-group" class="header-group row <?php print $grid_width; ?>">
          <div id="header-group-inner" class="header-group-inner inner clearfix">
            <?php print theme('grid_block', $primary_links_tree, 'primary-menu'); ?>
            <?php if ($logo || $site_name || $site_slogan || $header): ?>
            <div id="header-site-info" class="header-site-info <?php if ($preface_top) { echo "with-preface-top"; } else { echo "without-preface-top"; }?> block">
              <div id="header-site-info-inner" class="header-site-info-inner inner clearfix">
               
                <?php if ($logo): ?>
                <div id="logo">
			<?php if ($is_front) echo "<h1>"; ?>
			<a href="<?php print check_url($front_page); ?>" title="<?php print t('Home'); ?>" lang="ca" tabindex="-1">
			<img src="<?php print $logo; ?>" alt="<?php print t('Home'); ?>" />
			</a>
			<?php if ($is_front) echo "</h1>"; ?>
                </div>
                <?php endif; ?>
                <?php if ($site_name || $site_slogan): ?>
                <div id="site-name-wrapper" class="clearfix">
                  <?php if ($site_name): ?>
                  <span id="site-name"<?php if ($site_slogan): ?> class="with-slogan"<?php endif; ?>><a href="<?php print check_url($front_page); ?>" title="<?php print t('Home'); ?>"><?php print $site_name; ?></a></span>
                  <?php endif; ?>
                  <?php if ($site_slogan): ?>
                  <span id="slogan"><?php print $site_slogan; ?></span>
                  <?php endif; ?>



                </div><!-- /site-name-wrapper -->
                <?php endif; ?>
                <?php if ($header): ?>
                <div id="header-wrapper" class="header-wrapper">
                  <?php print $header; ?>
                </div>
                <?php endif; ?>
              </div><!-- /header-site-info-inner -->
            </div><!-- /header-site-info -->
            <?php endif; ?>

    <!-- preface-top row: width = grid_block -->

			<div id="destacats-header">
				<div class="enllac_destacat_1">
					<a href="/llistat_punts_omnia" lang="ca" title="Troba el teu Punt Òmnia més proper!" tabindex="9" accesskey="6" class="<?php acquia_actiu('llistat_punts_omnia', 'a'); ?>">
					Troba el teu Punt &Ograve;mnia m&eacute;s proper!
					</a>
				</div>
			
			</div>

          <?php print theme('grid_block', $preface_top, 'preface-top'); ?>
          <?php print theme('grid_block', theme('links', $secondary_links), 'secondary-menu'); ?>

          </div><!-- /header-group-inner -->



        </div><!-- /header-group -->
      </div><!-- /header-group-wrapper -->


      <!-- main row: width = grid_width -->
      <div id="main-wrapper" class="main-wrapper full-width cos-pagina">

	    <!-- sidebar esquerra -->
            <?php print theme('grid_row', $sidebar_first, 'sidebar-first', 'nested', $sidebar_first_width); ?>

            
                    <div id="content-group" class="content-group row nested contingut-central<?php print $content_group_width; ?>">
                    <div id="contingut-central-inner">
                        <?php print theme('grid_block', $breadcrumb, 'breadcrumbs'); ?>
                        <?php print theme('grid_block', $help, 'content-help'); ?>
                        <?php print theme('grid_block', $messages, 'content-messages'); ?>
                        <?php if ($content_top): ?>                      
                              <div id="content-top" class="inner clearfix">
                                <?php print $content_top; ?>
	                      </div><!-- /content-top -->
                        <?php endif; ?>        
<?php
if ($node->type=='acta' or $node->type=='informe')
{
	$adminRoles= array('administradors','DGAC','ODC','OT');
	$adminAble= FALSE;
	foreach($adminRoles as $role) {
	  if( in_array($role, array_values($user->roles)) ) $adminAble= TRUE;
	}
	if($adminAble) { ?>
	 			<a name="main-content-area" id="main-content-area"></a>
                            	<?php print theme('grid_block', $tabs, 'content-tabs'); ?>
                            	<div id="content-inner" class="content-inner block">
	    			<?php if ($title): ?>
                                <h1 class="title"><?php print $title; ?></h1>
                                <?php endif; ?>
                                <?php if ($content): ?>
                                <div id="content-content" class="content-content">
                                  <?php print $content; ?>
                                  <?php print $feed_icons; ?>
                                </div><!-- /content-content -->
                                <?php endif; 
	}
	else{
		print "<h1>S'ha denegat l'accés</h1><p>No esteu autoritzat per a accedir a aquesta pàgina.</p>";
	}

}
else
{
?>
	 			<a name="main-content-area" id="main-content-area"></a>
                            	<?php print theme('grid_block', $tabs, 'content-tabs'); ?>
                            	<div id="content-inner" class="content-inner block">
                                <?php if ($title): ?>
                                <h1 class="title"><?php print $title; ?></h1>
                                <?php endif; ?>
                                <?php if ($content): ?>
                                <div id="content-content" class="content-content">
                                  <?php print $content; ?>
                                  <?php print $feed_icons; ?>
                                </div><!-- /content-content -->
                                <?php endif; ?>
<?php
} ?>


                            </div><!-- /content-inner -->
                        <?php print theme('grid_row', $content_bottom, 'content-bottom', 'nested'); ?>
                    </div>
                    </div><!-- /content-group -->


		<!-- sidebar dreta -->
		<?php $url = request_uri();
		// si NO és la pàgina del cercador, mostrar barra lateral dreta
		if (!strpos($url, "llistat_punts_omnia")) {
                print theme('grid_row', $sidebar_last, 'sidebar-last', 'nested', $sidebar_last_width);
                } ?>


      </div><!-- /main-wrapper -->






      <!-- postscript-bottom row: width = grid_width -->
      <?php print theme('grid_row', $postscript_bottom, 'postscript-bottom', 'full-width', $grid_width); ?>

      <!-- footer row: width = grid_width -->
      <?php print theme('grid_row', $footer, 'footer', 'full-width', $grid_width); ?>

      <!-- footer -->
          <div id="footer-page" class="footer-message-inner inner clearfix">
            <?php print theme('grid_block', $footer_message, 'footer-message-text'); ?>
          </div><!-- /footer -->


    </div><!-- /page-inner -->
  </div><!-- /page -->
  <?php print $closure ?>
</body>
</html>
