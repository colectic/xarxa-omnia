 

<div class='form-entitat'>
	<div class='form-entitat-nom'>
<?php print_r(drupal_render($form['title'])); ?>
	</div>

    <div class='form-entitat-web'>
<?php print_r(drupal_render($form['field_entitat_web'])); ?>
	</div>

    <div class='form-entitat-tipologia'>
<?php
//drupal_render($form['taxonomy']['#fieldset']['#disabled']) = TRUE;
print_r(drupal_render($form['taxonomy']['19']['#description'] = '<div class="tipologia-suffix">Per seleccionar m&eacute;s d\'un element, premi la tecla CTRL</div>'));
print_r(drupal_render($form['taxonomy']));
//print_r(drupal_render($form['taxonomy']['19']['#weight'] = -5));
?>
	</div>

    <div class='form-entitat-relaciopuntomnia'>
<?php print_r(drupal_render($form['field_puntomnia_entitat'])); ?>
	</div>

    <div class='form-entitat-municipi'>
<?php
print_r(drupal_render($form['taxonomy']['18']));
//print_r(drupal_render($form['taxonomy']['18']['#weight'] = -4));
?>
	</div>

    <div class='form-entitat-mapa'>
<?php
print_r(drupal_render($form['locations']['#prefix'] = '<div class="location-prefix">En la secci&oacute; anomenada &quot;Ubicaci&oacute;&quot;, fes clic en el mapa per a situar l\'adre&ccedil;a de l\'entitat. Els camps &quot;Latitud&quot; i &quot;Longitud&quot;, s\'ompliran autom&agrave;ticament quan facis clic dins el mapa.</div>'));
print drupal_render($form['locations']);	
?>
	</div>
</div>

<?php print drupal_render($form); ?>
