<?php
	drupal_add_css(drupal_get_path('module', 'omnia_usos') . '/css/omnia_usos.css');
	global $user;
	
	$st_header = array(
			array('data' => t('Punt Omnia'), 'class' => 'th1'),
			array('data' => t('Entitat'), 'class' => 'th2'),
			array('data' => t('Tipus'), 'class' => 'th3'),
			array('data' => t('Deriva persones'), 'class' => 'th4'),
			array('data' => t('Hi ha coordinació'), 'class' => 'th5'),
			array('data' => t('Freq. de coordinació'), 'class' => 'th6'),
	);

	$punts = array();
	
	foreach ($rows as $row) {	
		$content = explode('</div>', $row);
		$punt = trim(strip_tags($content[0]));
		$entitat = trim(strip_tags($content[1]));
		$oid = trim(strip_tags($content[6]));
		$h = sha1($user->uid.$oid.'H35rD83X7z');
		
		if (!isset($punts[$punt])) {
			$punts[$punt] = array();
			$punts[$punt]['entitats'] = array();
			$punts[$punt]['count'] = 0;
			$punts[$punt]['nom'] = "<a href='entitats?oid={$oid}::{$h}'>{$punt}</a>";
		}
		$punts[$punt]['entitats'][$entitat] = array();
		$punts[$punt]['entitats'][$entitat]['nom'] = trim(strip_tags($content[1], '<a>'));
		
		$tipus = trim(strip_tags($content[2]));
		$tipus = str_replace('Serveis públics: ', '', $tipus);
		$tipus = str_replace('Entitats privades: ', '', $tipus);
		$punts[$punt]['entitats'][$entitat]['tipus'] = $tipus;
		
		$deriva = trim(strip_tags($content[3]));
		$deriva = ($deriva == 'Deriva persones') ? 'Sí' : 'No';
		$punts[$punt]['entitats'][$entitat]['deriva'] = $deriva;
		
		$coord = trim(strip_tags($content[4]));
		$coord = ($coord == 'Hi ha coordinació') ? 'Sí' : 'No';
		$punts[$punt]['entitats'][$entitat]['coord'] = $coord;
		
		$punts[$punt]['entitats'][$entitat]['freq'] = trim(strip_tags($content[5]));
		$punts[$punt]['count']++;
	}
	
	$rows = array();
	
	foreach ($punts as $punt) {
		$first = true;
		foreach ($punt['entitats'] as $entitat) {
			$newrow = array();
			if ($first) {
				$newrow[] = array('data' => $punt['nom'], 'rowspan' => $punt['count'], 'class' => 'td1');
				$first = false;
			}
			$newrow[] = array('data' => $entitat['nom'], 'class' => 'td2');
			$newrow[] = array('data' => $entitat['tipus'], 'class' => 'td3');
			$newrow[] = array('data' => $entitat['deriva'], 'class' => 'td4');
			$newrow[] = array('data' => $entitat['coord'], 'class' => 'td5');
			$newrow[] = array('data' => $entitat['freq'], 'class' => 'td6');
			$rows[] = $newrow;
		}
	}	
	
	echo theme_table($st_header, $rows, array('class' => 'entitats_sense_protocol'));