<?php
/**
 * @package omnia_usos
 * @file omnia_usos.module
 * @author Associació per a Joves Teb, Xarxa-omnia <suport@xarxa-omnia.org>
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 * @version 1.0
 * Creació d'estadístiques en l'ús dels punt Òmnia.
 */
?>

<?php 
	//theme_add_style('sites/xarxa-omnia.org/themes/acquia_slate/css/style-omnia_usos.css');
/**
 * Variables globals
 */
	define('CAMP_USUARI', 'uid');
	define('CAMP_GENERE', 'gender');
	define('CAMP_EDAT', 'age');
	define('CAMP_ORIGEN', 'origin');
	define('CAMP_PAIS', 'country');
	define('CAMP_PO', 'oid');
	define('CAMP_ACTIVITAT', 'aid');
	define('CAMP_EIXPRINCIPAL_DINAMITZADOR', '1axdin');
	define('CAMP_EIXSECUNDARI_DINAMITZADOR', '2axdin');
	define('CAMP_EIXPRINCIPAL_COORDINACIO', '1axcoo');
	define('CAMP_EIXSECUNDARI_COORDINACIO', '2axcoo');
	define('CAMP_AREA_COORDINACIO', 'areacoo');
	define('CAMP_INICI', 'actime');
	define('CAMP_FI', 'actdur');
	define('TAULA', 'omnia_usos');


/**
 * TODO: Es totalment temporal. Quan s'integrin les funcions al nou mòdul, caldrà esborrar-ho.
 * Crida a les funcions
 */
	global $user;
	// TODO : Tant sols serà visible si estem autentificats amb l'usuari 'admin'
	if ($user->uid==1){
		print t("<h1>Estadístiques d'usos</h1>");

		// Formulari amb filtres
		print t("<h2>Filtre de consultes</h2>").drupal_get_form('omnia_usos_formulariconsultes');
	} 


/**
 * Called when user goes to xarxa-omnia.org/estadistiques
 */
function omnia_usos_formulariconsultes_page(){
	$output = t("<h1>Estadístiques d'usos</h1>");
	$output .= t("<h2>Filtre de consultes</h2>");
	$output .= drupal_get_form (omnia_usos_formulariconsultes);
	return $output;
}

/**
 * Defines a form
 *
 * @param &$form_state array El ​​seu ús principal és recuperar els valors introduïts per l'usuari en el formulari, però en te d'altres. 
 *                           Més info a http://api.drupal.org/api/views/views.module/function/drupal_build_form/6
 * @return $form Imprimeix el formulari
 */
function omnia_usos_formulariconsultes(&$form_state) {
	//usuaris
	$attributes=array('style' => $style);
	$prefix="<div style='width:200px; border:1px solid #ccc; float:left; padding:5px;'>";
	$suffix="</div>";
	$form['usuaris'] = array(
	    '#type' => 'fieldset',
	    '#title' => t('Usuaris'),
	    '#tree' => TRUE,
	    '#collapsible' =>  TRUE,
	    '#collapsed' =>  FALSE,
	);
	$genere = omnia_usos_consultavalorscamp(CAMP_GENERE);
	$form['usuaris']['genere'] = array(
	    '#type' => 'select',
	    '#title' => t('Gènere'),
	    '#options' => $genere,
	    '#multiple' => true,
	    '#attributes' => $attributes,
	    '#prefix' => $prefix,
	    '#suffix' => $suffix,
	    '#description' => t('Selecciona el o els gèneres a filtrar.'),
	);
	$edat = array('0' => t('Infant'), '1' => t('Jove'), '2' => t('Adult'),'3' => t('Gent gran'));
	$edat = omnia_usos_consultavalorscamp(CAMP_EDAT);
	$form['usuaris']['edat'] = array(
	    '#type' => 'select',
	    '#title' => t('Edat'),
	    '#options' => $edat,
	    '#multiple' => true,
	    '#attributes' => $attributes,
	    '#prefix' => $prefix,
	    '#suffix' => $suffix,
	    '#description' => t('Selecciona l\'edat a filtrar.'),
	);
	$origen = omnia_usos_consultavalorscamp(CAMP_ORIGEN);
	$form['usuaris']['origen'] = array(
	    '#type' => 'select',
	    '#title' => t('Origen.'),
	    '#options' => $origen,
	    '#multiple' => true,
	    '#attributes' => $attributes,
	    '#prefix' => $prefix,
	    '#suffix' => $suffix,
	    '#description' => t('Selecciona l\'origen.'),
	);
	$pais_origen = omnia_usos_consultavalorscamp(CAMP_PAIS);
	$form['usuaris']['pais'] = array(
	    '#type' => 'select',
	    '#title' => t('Pais d\'origen.'),
	    '#options' => $pais_origen,
	    '#multiple' => true,
	    '#attributes' => $attributes,
	    '#prefix' => $prefix,
	    '#suffix' => $suffix,
	    '#description' => t('Selecciona el pais d\'origen.'),
	);
	$po = omnia_usos_consultavalorscamp(CAMP_PO);
	$form['usuaris']['po'] = array(
	    '#type' => 'select',
	    '#title' => t('Punt Òmnia'),
	    '#options' => $po,
	    '#multiple' => true,
	    '#attributes' => $attributes,
	    '#prefix' => $prefix,
	    '#suffix' => $suffix,
	    '#description' => t('Selecciona l\'origen.'),
	);

	//usos
	$form['usos'] = array(
	    '#type' => 'fieldset',
	    '#title' => t('Usos'),
	    '#tree' => TRUE,
	    '#collapsible' =>  TRUE,
	    '#collapsed' =>  FALSE,
	);

	$activitats = omnia_usos_consultavalorscamp(CAMP_ACTIVITAT);
	$form['usos']['activitat'] = array(
	    '#type' => 'select',
	    '#title' => t('Activitats'),
	    '#options' => $activitats,
	    '#attributes' => $attributes,
	    '#prefix' => $prefix,
	    '#suffix' => $suffix,
	    '#multiple' => true,
	    '#description' => t('Selecciona una o més activitats.'),
	);

	$eixos_principals=omnia_usos_consultavalorscamp(CAMP_EIXPRINCIPAL_DINAMITZADOR);
	$form['usos']['eixprincipaldinamitzador'] = array(
	    '#type' => 'select',
	    '#title' => t('Eix principal dinamitzador'),
	    '#options' => $eixos_principals,
	    '#multiple' => true,
	    '#attributes' => $attributes,
	    '#prefix' => $prefix,
	    '#suffix' => $suffix,
	    '#description' => t('Selecciona l\'eix principal.'),
	);
	$eixos_secundaris=omnia_usos_consultavalorscamp(CAMP_EIXSECUNDARI_DINAMITZADOR);
	$form['usos']['eixsecundaridinamitzador'] = array(
	    '#type' => 'select',
	    '#title' => t('Eix secundari dinamitzador'),
	    '#options' => $eixos_secundaris,
	    '#multiple' => true,
	    '#attributes' => $attributes,
	    '#prefix' => $prefix,
	    '#suffix' => $suffix,
	    '#description' => t('Selecciona l\'eix secundari.'),
	);
	$eixos_principals=omnia_usos_consultavalorscamp(CAMP_EIXPRINCIPAL_COORDINACIO);
	$form['usos']['eixprincipalcoordinacio'] = array(
	    '#type' => 'select',
	    '#title' => t('Eix principal coordinació'),
	    '#options' => $eixos_principals,
	    '#multiple' => true,
	    '#attributes' => $attributes,
	    '#prefix' => $prefix,
	    '#suffix' => $suffix,
	    '#description' => t('Selecciona l\'eix principal.'),
	);
	$eixos_secundaris=omnia_usos_consultavalorscamp(CAMP_EIXSECUNDARI_COORDINACIO);
	$form['usos']['eixsecundaricoordinacio'] = array(
	    '#type' => 'select',
	    '#title' => t('Eix secundari coordinació'),
	    '#options' => $eixos_secundaris,
	    '#multiple' => true,
	    '#attributes' => $attributes,
	    '#prefix' => $prefix,
	    '#suffix' => $suffix,
	    '#description' => t('Selecciona l\'eix secundari.'),
	);
	$eixos_secundaris=omnia_usos_consultavalorscamp(CAMP_AREA_COORDINACIO);
	$form['usos']['areacoordinacio'] = array(
	    '#type' => 'select',
	    '#title' => t('Area coordinació'),
	    '#options' => $eixos_secundaris,
	    '#multiple' => true,
	    '#attributes' => $attributes,
	    '#prefix' => $prefix,
	    '#suffix' => $suffix,
	    '#description' => t('Selecciona l\'area.'),
	);


	//usos
	$form['temporalitat'] = array(
	    '#type' => 'fieldset',
	    '#title' => t('Temporalitat'),
	    '#tree' => TRUE,
	    '#collapsible' =>  TRUE,
	    '#collapsed' =>  FALSE,
	);

  	$date = '31-12-2008';
  	$format = 'd-m-Y';
	$form['temporalitat']['inici'] = array(
	    '#type' => 'date_select', // types 'date_text' and 'date_timezone' are also supported. See .inc file.
	    '#title' => t('Data d\'inici'),
	    '#default_value' => $date,
	    '#date_format' => $format,
	    '#date_label_position' => 'within', // See other available attributes and what they do in date_api_elements.inc
	    '#date_increment' => 15, // Optional, used by the date_select and date_popup elements to increment minutes and seconds.
	    '#date_year_range' => '-3:0', // Optional, used to set the year range (back 3 years and forward 3 years is the default).
	    '#description' => t('Data d\'inici'),
	    '#attributes' => $attributes,
	    '#prefix' => $prefix,
	    '#suffix' => $suffix,
	);
	$form['temporalitat']['fi'] = array(
	    '#type' => 'date_select', // types 'date_text' and 'date_timezone' are also supported. See .inc file.
	    '#title' => t('Data final'),
	    '#default_value' => $date,
	    '#date_format' => $format,
	    '#date_label_position' => 'within', // See other available attributes and what they do in date_api_elements.inc
	    '#date_increment' => 15, // Optional, used by the date_select and date_popup elements to increment minutes and seconds.
	    '#date_year_range' => '-3:0', // Optional, used to set the year range (back 3 years and forward 3 years is the default).
	    '#description' => t('Data final'),
	    '#attributes' => $attributes,
	    '#prefix' => $prefix,
	    '#suffix' => $suffix,
	);

	//botó d'enviament
	$form['submit'] = array('#type' => 'submit', '#value' => t('Filter'));

	return $form;
}

/**
 * Consulta els registres d'un camp i en retorna els resultats diferents
 *
 * @param string $camp Nom del camp a consultar
 * @return array resultat de la consulta
 */
function omnia_usos_consultavalorscamp($camp){
	$sql="SELECT DISTINCT (".$camp.") valor FROM {".TAULA."}";
	$result = db_query($sql);
	if (!db_affected_rows($result) == 0) while($registre = db_fetch_object($result)) {
		switch ($camp){
			case CAMP_ORIGEN:
			case CAMP_PAIS:
			case CAMP_AREA_COORDINACIO:
			case CAMP_EIXPRINCIPAL_DINAMITZADOR:
			case CAMP_EIXSECUNDARI_DINAMITZADOR:
			case CAMP_EIXPRINCIPAL_COORDINACIO:
			case CAMP_EIXSECUNDARI_COORDINACIO: $term = omnia_usos_getTermsName($registre->valor); $valors[$registre->valor] = $term; break;
			case CAMP_PO: $po = omnia_usos_nompuntomnia($registre->valor); $valors[$registre->valor] = $po; break; 
			case CAMP_ACTIVITAT: $activitat = omnia_usos_nomactivitat($registre->valor); $valors[$registre->valor] = $activitat; break; 
			case CAMP_GENERE:
			case CAMP_EDAT:
				$valors[$registre->valor]=$registre->valor; break;
			default: $valors[$registre->valor]=$registre->valor; break;
		}
	}
	return $valors;
}


/**
 * Exemples de sortida de gràfics utilitzant la API de Google Chart
 *
 * @return html amb imatges generades des de la API
 */
function omnia_usos_exemplegrafics(){
	/* Exemple 1 */
	  $output.="<h2>Exemple 1</h2>";
	  $chart = array(
	      '#chart_id' => 'exemple_1',
	      '#title' => t('Titol del gràfic'),
	      '#type' => CHART_TYPE_PIE_3D,
	    );   
	  $chart['#data']['dones'] = 3;
	  $chart['#data']['homes']  = 2;
	  $chart['#data']['nens']  = 5;
	  $output.=chart_render($chart);

	/* Exemple 2 */ 
	  $output.="<h2>Exemple 2</h2>";
	  $chart = array(
	      '#chart_id' => 'exemple_2',
	      '#title' => chart_title(t('Titol del gràfic'), 'cc0000', 15),
	      '#type' => CHART_TYPE_PIE,
	      '#size' => chart_size(400, 200),
	    ); 
	  $chart['#data']['dones'] = 3;
	  $chart['#data']['homes']  = 2;
	  $chart['#data']['nens']  = 5;
	  $chart['#labels'][] = t('Dones');
	  $chart['#labels'][] = t('Homes');
	  $chart['#labels'][] = t('Nens');
	  $output.=chart_render($chart);

	/* Exemple 3 */ 
	  $output.="<h2>Exemple 3</h2>";
	  $chart = array(
	      '#chart_id' => 'exemple_3',
	      '#title' => chart_title(t('Titol del gràfic'), 'cc0000', 15),
	      '#type' => CHART_TYPE_PIE,
	      '#size' => chart_size(400, 200),
	    ); 
	  $chart['#data']['dones'] = 3;
	  $chart['#data']['homes']  = 2;
	  $chart['#data']['nens']  = 5;
	  $chart['#labels'][] = t('Dones');
	  $chart['#labels'][] = t('Homes');
	  $chart['#labels'][] = t('Nens');
	  $chart['#data_colors'][] = '00ff00';
	  $chart['#data_colors'][] = 'ff0000';
	  $chart['#data_colors'][] = '0000ff';
	  $output.=chart_render($chart);

	/* Exemple 4 */ 
	  $output.="<h2>Exemple 4</h2>";
	  $chart = array(
	      '#chart_id' => 'exemple_4',
	      '#title' => chart_title(t('Titol del gràfic'), 'cc0000', 15),
	      '#type' => CHART_TYPE_LINE,
	      '#size' => chart_size(400, 200),
	      '#adjust_resolution' => TRUE,
	    );
	  $chart['#data']['dones'] = array(1, 3, 5, 4, 2);
	  $chart['#data']['homes']  = array(2, 2, 4, 3, 1);
	  $chart['#data']['nens']  = array(5, 2, 3, 1, 2);
	  $chart['#legends'][] = t('Dones');
	  $chart['#legends'][] = t('Homes');
	  $chart['#legends'][] = t('Nens');
	  $chart['#data_colors'][] = '00ff00';
	  $chart['#data_colors'][] = 'ff0000';
	  $chart['#data_colors'][] = '0000ff';
	  $chart['#mixed_axis_labels'][CHART_AXIS_Y_LEFT][0][] = chart_mixed_axis_range_label(0, 5);
	  $chart['#mixed_axis_labels'][CHART_AXIS_Y_LEFT][1][] = chart_mixed_axis_label(t('Count'), 95);
	  $chart['#mixed_axis_labels'][CHART_AXIS_X_BOTTOM][1][] = chart_mixed_axis_label(t('Di'));
	  $chart['#mixed_axis_labels'][CHART_AXIS_X_BOTTOM][1][] = chart_mixed_axis_label(t('Dm'));
	  $chart['#mixed_axis_labels'][CHART_AXIS_X_BOTTOM][1][] = chart_mixed_axis_label(t('Dmc'));
	  $chart['#mixed_axis_labels'][CHART_AXIS_X_BOTTOM][1][] = chart_mixed_axis_label(t('Dj'));  
	  $chart['#mixed_axis_labels'][CHART_AXIS_X_BOTTOM][1][] = chart_mixed_axis_label(t('Dv'));
	  $chart['#mixed_axis_labels'][CHART_AXIS_X_BOTTOM][2][] = chart_mixed_axis_label(t('Dies de la setmana'), 50);
	  $output.=chart_render($chart);

	/* Exemple 5 */ 
	  $output.="<h2>Exemple 5</h2>";
	  $chart = array(
	      '#chart_id' => 'exemple_5',
	      '#title' => chart_title(t('Titol del gràfic'), 'cc0000', 15),
	      '#type' => CHART_TYPE_LINE,
	      '#size' => chart_size(400, 200),
	      '#chart_fill' => chart_fill('c', 'eeeeee'),          
	      '#grid_lines' => chart_grid_lines(20, 20, 1, 5),          
	    );
	    
	  for ($i = 0; $i < 80; $i++){
	    $chart['#data'][] = $i + rand(0, $i);
	  }
	  $output.=chart_render($chart);

	/* Exemple 6 */ 
	  $output.="<h2>Exemple 6</h2>";
	  $chart = array(
	      '#chart_id' => 'exemple_6',
	      '#title' => chart_title(t('Titol del gràfic'), '0000ee', 15),
	      '#type' => CHART_TYPE_BAR_V_GROUPED,
	      '#size' => chart_size(400, 200),
	      '#grid_lines' => chart_grid_lines(30, 15),
	      '#bar_size' => chart_bar_size(15, 5), 
	    ); 
	  $chart['#data'][] = array(40, 50, 70);
	  $chart['#data'][] = array(60, 50, 30);
	  $chart['#data'][] = array(40, 60, 20);
	  $chart['#data_colors'][] = chart_unique_color('test_a');
	  $chart['#data_colors'][] = chart_unique_color('test_b');
	  $chart['#data_colors'][] = chart_unique_color('test_c');
	  $output.=chart_render($chart);

	  $body = $body . '<fieldset class="collapsible collapsed">' . 
	  '<legend>Gràfics d\'exemple</legend>' . 
	  '<description class="description">Gràfics d\'exemple utilitzant la API de Google Chart</description><br /><br />' .  $output;
	  return $body;  
}

/**
 * Càlcula el valor mínim d'un conjunt de valors
 *
 * @param $valors Array Valors que li passem a la funció
 * @return Valor resultant
 */
function omnia_usos_calc_min($valors){
	return min($valors);
}

/**
 * Càlcula el valor màxim d'un conjunt de valors
 *
 * @param $valors Array Valors que li passem a la funció
 * @return Valor resultant
 */
function omnia_usos_calc_max($valors){
	return max($valors);
}

/**
 * Càlcula la mitjana d'un conjunt de valors
 *
 * @param $valors Array Valors que li passem a la funció
 * @return Valor resultant
 */
function omnia_usos_calc_mitjana($valors){
        $sum = array_sum($valors); // Sumem els valors del array
        $count = count($valors); // comptem els valors del array
        return ($sum/$count); 
}

/**
 * Càlcula la moda, el valor més repetit, d'un conjunt de valors
 *
 * @param $valors Array Valors que li passem a la funció
 * @return Valor resultant
 */
function omnia_usos_calc_moda($valors){
	return $valors;
}


/**
 * Acció del formulari
 *
 * @param $form
 * @param &$form_state
 */

function omnia_usos_formulariconsultes_submit($form, &$form_state) {

	$where="";
	if ($form_state['values']['usuaris']['genere']) {
		if ($where) $where.=" AND "; 
		$where.=omnia_usos_formulariconsultes_where($form_state['values']['usuaris']['genere'], CAMP_GENERE);
	}
	if ($form_state['values']['usuaris']['edat']) {
		if ($where) $where.=" AND "; 
		$where.=omnia_usos_formulariconsultes_where($form_state['values']['usuaris']['edat'], CAMP_EDAT);
	}
	if ($form_state['values']['usuaris']['origen']) {
		if ($where) $where.=" AND "; 
		$where.=omnia_usos_formulariconsultes_where($form_state['values']['usuaris']['origen'], CAMP_ORIGEN);
	}
	if ($form_state['values']['usuaris']['pais']) {
		if ($where) $where.=" AND "; 
		$where.=omnia_usos_formulariconsultes_where($form_state['values']['usuaris']['pais'], CAMP_PAIS);
	}
	if ($form_state['values']['usuaris']['po']) {
		if ($where) $where.=" AND "; 
		$where.=omnia_usos_formulariconsultes_where($form_state['values']['usuaris']['po'], CAMP_PO);
	}

	if ($form_state['values']['usos']['activitat']) {
		if ($where) $where.=" AND "; 
		$where.=omnia_usos_formulariconsultes_where($form_state['values']['usuaris']['activitat'], CAMP_ACTIVITAT);
	}

	if ($form_state['values']['usos']['eixprincipaldinamitzador']) {
		if ($where) $where.=" AND "; 
		$where.=omnia_usos_formulariconsultes_where($form_state['values']['usuaris']['eixprincipaldinamitzador'], CAMP_EIXPRINCIPAL_DINAMITZADOR);
	}
	if ($form_state['values']['usos']['eixsecundaridinamitzador']) {
		if ($where) $where.=" AND "; 
		$where.=omnia_usos_formulariconsultes_where($form_state['values']['usuaris']['eixprincipaldinamitzador'], CAMP_EIXSECUNDARI_DINAMITZADOR);
	}
	if ($form_state['values']['usos']['eixprincipalcoordinacio']) {
		if ($where) $where.=" AND "; 
		$where.=omnia_usos_formulariconsultes_where($form_state['values']['usuaris']['eixprincipalcoordinacio'], CAMP_EIXPRINCIPAL_COORDINACIO);
	}
	if ($form_state['values']['usos']['eixsecundaricoordinacio']) {
		if ($where) $where.=" AND "; 
		$where.=omnia_usos_formulariconsultes_where($form_state['values']['usuaris']['eixprincipalcoordinacio'], CAMP_EIXSECUNDARI_COORDINACIO);
	}
	if ($form_state['values']['usos']['areacoordinacio']) {
		if ($where) $where.=" AND "; 
		$where.=omnia_usos_formulariconsultes_where($form_state['values']['usuaris']['areacoordinacio'], CAMP_AREA_COORDINACIO);
	}
	if ($form_state['values']['temporalitat']['inici'] and $form_state['values']['temporalitat']['fi']) {
		$data_inici = date_convert($form_state['values']['temporalitat']['inici'], DATE_ISO, DATE_UNIX);
		$data_fi = date_convert($form_state['values']['temporalitat']['fi'], DATE_ISO, DATE_UNIX);
		if ($where) $where.=" AND ";   
		$where.="(actime >='".$data_inici."' AND actime <= '".$data_fi."')";
	}

	if ($where){ 
		$SQL1="SELECT COUNT(*) conta FROM {".TAULA."} WHERE ".$where;
		$SQL2="SELECT * FROM {".TAULA."} WHERE ".$where;
	} else {
		$SQL1="SELECT COUNT(*) conta FROM {".TAULA."}";
		$SQL2="SELECT * FROM {".TAULA."}";
	}
	$count = db_result(db_query($SQL1));

	
	$missatge .="<br /><br /><strong>SQL: </strong>".$SQL2;
	$missatge .="<h1>".$count." resultats</h1>".$impressio.omnia_usos_imprimirtaula($SQL2);
  	drupal_set_message($missatge);
}


/**
 * Concreta valors al WHERE de la consulta
 *
 * @param $sql
 * @return html del resultat de la consulta
 */
function omnia_usos_formulariconsultes_where($array, $camp){
	$where.="(";
	$x=0;
	foreach ($array as &$valor) {
		$valor = $valor;
		if($x==0) $where.=$camp." = '".$valor."' "; 
		else $where.="AND ".$camp." = '".$valor."' "; 
		$x++;
	}
	$where.=")";
	return $where;
}

/**
 * Imprimeix una taula amb els valors de la consulta
 *
 * @param $sql
 * @return html del resultat de la consulta
 */
function omnia_usos_imprimirtaula($sql){
	$query = db_query($sql);
	$rows = array();
	while ($row = db_fetch_array($query)) {
		foreach ($row  as $clave => $valor) $header[]=$clave;
		if ($row[CAMP_ORIGEN]) $row[CAMP_ORIGEN] = omnia_usos_getTermsName($row[CAMP_ORIGEN]);
		if ($row[CAMP_PAIS]) $row[CAMP_PAIS] = omnia_usos_getTermsName($row[CAMP_PAIS]);
		if ($row[CAMP_AREA_COORDINACIO]) $row[CAMP_AREA_COORDINACIO] = omnia_usos_getTermsName($row[CAMP_AREA_COORDINACIO]);
		if ($row[CAMP_EIXPRINCIPAL_DINAMITZADOR]) $row[CAMP_EIXPRINCIPAL_DINAMITZADOR] = omnia_usos_getTermsName($row[CAMP_EIXPRINCIPAL_DINAMITZADOR]);
		if ($row[CAMP_EIXSECUNDARI_DINAMITZADOR]) $row[CAMP_EIXSECUNDARI_DINAMITZADOR] = omnia_usos_getTermsName($row[CAMP_EIXSECUNDARI_DINAMITZADOR]);
		if ($row[CAMP_EIXPRINCIPAL_COORDINACIO]) $row[CAMP_EIXPRINCIPAL_COORDINACIO] = omnia_usos_getTermsName($row[CAMP_EIXPRINCIPAL_COORDINACIO]);
		if ($row[CAMP_EIXSECUNDARI_COORDINACIO]) $row[CAMP_EIXSECUNDARI_COORDINACIO] = omnia_usos_getTermsName($row[CAMP_EIXSECUNDARI_COORDINACIO]);
		if ($row[CAMP_AREA_COORDINACIO]) $row[CAMP_AREA_COORDINACIO] = omnia_usos_getTermsName($row[CAMP_AREA_COORDINACIO]);
		if ($row[CAMP_USUARI]) $row[CAMP_USUARI] = omnia_usos_nomusuari($row[CAMP_USUARI]);
		if ($row[CAMP_PO]) $row[CAMP_PO] = omnia_usos_nompuntomnia($row[CAMP_PO]);
		if ($row[CAMP_ACTIVITAT]) $row[CAMP_ACTIVITAT] = omnia_usos_nomactivitat($row[CAMP_ACTIVITAT]);
		if ($row[CAMP_INICI]) $row[CAMP_INICI] = format_date($row[CAMP_INICI], 'custom', 'd-m-Y');
		$rows[] = $row;
	}
	$output="<small style='font-size:6px; font-weight:normal; padding:0px; margin:0px;'>".theme('table', $header, $rows)."</small>";
	$output.=omnia_usos_grafic_genere($sql);
	$output.=omnia_usos_grafic($sql, CAMP_ORIGEN, "Origen");
	$output.=omnia_usos_grafic($sql, CAMP_PAIS, "Pais");
	$output.=omnia_usos_grafic($sql, CAMP_EIXPRINCIPAL_DINAMITZADOR, "Eix principal dinamitzador ");
	$output.=omnia_usos_grafic($sql, CAMP_EIXSECUNDARI_DINAMITZADOR, "Eix secundari dinamitzador ");
	$output.=omnia_usos_grafic($sql, CAMP_EIXPRINCIPAL_COORDINACIO, "Eix principal coordinació");
	$output.=omnia_usos_grafic($sql, CAMP_EIXSECUNDARI_COORDINACIO, "Eix secundari coordinació");
	$output.=omnia_usos_grafic($sql, CAMP_AREA_COORDINACIO, "Àmbit");
	return $output;
}
/**
 * Imprimeix un gràfic comptabilitzant el genere
 *
 * @param $sql
 * @return gràfic
 */
function omnia_usos_grafic_genere($sql){
	$F=$M=0;
	$query = db_query($sql);
	$rows = array();
	while ($row = db_fetch_array($query)) {
		if ($row[CAMP_GENERE] == 'F') $F++;
		if ($row[CAMP_GENERE] == 'M') $M++; 
	}

	/* Generació del gràfic */ 
	  $chart = array(
	      '#chart_id' => 'genere',
	      '#title' => chart_title(t('Gènere'), 'cc0000', 15),
	      '#type' => CHART_TYPE_PIE,
	      '#size' => chart_size(400, 200),
	    ); 
	  $chart['#data']['dones'] = $F;
	  $chart['#data']['homes']  = $M;
	  $chart['#labels'][] = t('Dones').": ".$F;
	  $chart['#labels'][] = t('Homes').": ".$M;
	  $output.=chart_render($chart);
	return $output;
}

/**
 * Imprimeix un gràfic depenen del nom del camp
 *
 * @param $sql
 * @param $nom_camp String Camp de la base de dades
 * @param $titoldelgrafic String Titol del gràfic
 * @return gràfic
 */
function omnia_usos_grafic($sql, $nom_camp, $titoldelgrafic){
	$F=$M=0;
	$query = db_query($sql);
	$rows = array();
	$origen = omnia_usos_consultavalorscamp($nom_camp);
	$camp=array();
	foreach ($origen  as $clave => $valor) $camp[$valor]=0;
	while ($row = db_fetch_array($query)) {
		if ($row[$nom_camp]){
			foreach ($origen  as $clave => $valor){
				if (omnia_usos_getTermsName($row[$nom_camp])==$valor) {$camp[$valor]=$camp[$valor]+1; }
			}
		}
	}

	/* Generació del gràfic */ 
	  $chart = array(
	      '#chart_id' => $nom_camp,
	      '#title' => chart_title($titoldelgrafic, 'cc0000', 15),
	      '#type' => CHART_TYPE_PIE,
	      '#size' => chart_size(400, 200),
	    ); 
	  foreach ($origen  as $clave => $valor){
	  	$chart['#data'][$valor]=$camp[$valor];
	  	$chart['#labels'][] = $valor.": ".$camp[$valor];
	  }
	  $output.=chart_render($chart);
	return $output;
}



/**
 * Validació del formulari
 *
 * @param $form
 * @param &$form_state
 */
function omnia_usos_formulariconsultes_validate($form, &$form_state) {
	if ($form_state['values']['temporalitat']['inici'] == '') {
		form_set_error('', t('Has d\'indica una data d\'inici'));
	}
	if ($form_state['values']['temporalitat']['fi'] == '') {
		form_set_error('', t('Has d\'indica una data final'));
	}
}

/**
 * Retorna el nom de la taxonomia
 *
 * @param $taxnomyid Identificador de la taxonomia
 * @return El nom de la taxonomia
 */

function omnia_usos_getTermsName($taxnomyid){
	$terms =  taxonomy_get_term($taxnomyid);
	$termsname = $terms->name;
	return $termsname;
}

/**
 * Retorna el titol del node. Util per saber el nom de l'activitat, o el nom del Punt Òmnia.
 *
 * @param $nid Identificador del node
 * @return El titol del node.
 */

function omnia_usos_titoldelnode($nid){
	$sql = "SELECT title FROM {node} WHERE nid=".$nid;
	$result = db_query($sql);
	if (!db_affected_rows($result) == 0) while($registre = db_fetch_object($result)) {$title= $registre->title;}
	return $title;
}

function omnia_usos_nomactivitat($nid){
	return omnia_usos_titoldelnode($nid);
}

function omnia_usos_nompuntomnia($nid){
	return omnia_usos_titoldelnode($nid);
}

/**
 * Retorna el nom i cognoms de l'usuari. Si aquests camps no existeixen retorna el nom d'usuari de Drupal.
 *
 * @param $uid
 * @return El nom del l'usuari
 */

function omnia_usos_nomusuari($uid){
	$sql = "SELECT users.name, field_nom_value, field_surname1_value, field_surname2_value 
		FROM users
		LEFT JOIN node ON node.type = 'profile' AND node.uid=".$uid." 
		LEFT JOIN content_type_profile profile ON node.vid = profile.vid
		WHERE users.uid =".$uid;

	$result = db_query($sql);
	if (!db_affected_rows($result) == 0) while($registre = db_fetch_object($result)) {
		if ($registre->field_nom_value) $name = $registre->field_nom_value;
		if ($registre->field_surname1_value) $name .= " ".$registre->field_surname1_value;
		if ($registre->field_surname2_value) $name .= " ".$registre->field_surname2_value;
		if (!$name) $name= $registre->name;
	}
	return $name;
}
?>
