<?php

drupal_add_css(drupal_get_path('module', 'omnia_usos') . '/css/omnia_usos.css');

global $user;
$dina = false;
if (in_array('dinamitzadors', array_values($user->roles))) $dina = true;

$nodes = array();
foreach ($rows as $row) {
	$nid = strip_tags($row);
	$nid = str_replace(' ', '', $nid);
	$query = "SELECT nid, uid, aid, usgr, usin, usca FROM {omnia_usos} WHERE nid = {$nid}";
	$query = db_query($query);
	
	$users = array();
	while ($nuse = db_fetch_object($query)) {
		if (!is_null($nuse->uid)) $users[] = $nuse->uid;
		$use = $nuse;	
	}
	$participants = count($users);
	
	$node = node_load($nid);
	$activity = node_load($use->aid);
	$data = array ( 'users' => $users,
					'activity' => $activity->title." [{$use->aid}]",
					'group' => $use->usgr);
	$data = urlencode(serialize($data));
	
	$campaign = taxonomy_get_term($use->usca);
	$url = url(drupal_get_path_alias( 'node/' . $node->nid));
	
	$nodes[$use->aid]['groups'][$use->usgr][$use->usin.$node->nid] = array(
			'nid' => $node->nid,
			'starttime' => $use->usin,
			'campaign' => $campaign->name,
			'participants' => $participants,
			'data' => $data
			);
	$nodes[$use->aid]['title'] = $activity->title;
	
}


foreach ($nodes as $aid => $act) {
	echo '<h3>'.$act['title'].'</h3>';
	$st_header = array( 
					array('data' => t('Grup/Edició'), 'class' => 'th1'),
					array('data' => t('Data'), 'class' => 'th2'),
					array('data' => t('Campanya'), 'class' => 'th3'),
					array('data' => t('Participants'), 'class' => 'th4'),
					);
	if ($dina) $st_header[] = array('data' => t('Accions'), 'class' => 'th5');
	$rows = array();
	
	$groups = $act['groups'];
	ksort($groups);
	
	foreach ($groups as $group => $uses) {
		$sha = sha1($aid.'::'.$group);
		$num_uses = count($uses);
		$initial_uses = $num_uses;
		if ($num_uses>3) {
			$num_uses++;
			$initial_uses = 4;
		}
		$first = true;
		krsort($uses);
		$nodepos = 0;
		foreach ($uses as $use) {
			$url = url(drupal_get_path_alias( 'node/' . $use['nid']));
			$actions = "<a href='{$url}'><img src='http://{$_SERVER['HTTP_HOST']}/".drupal_get_path('module', 'omnia_usos') . "/pics/view.png' alt='mostra' class='icon'></a>
						<a href='/node/{$use['nid']}/edit'><img src='http://{$_SERVER['HTTP_HOST']}/".drupal_get_path('module', 'omnia_usos')."/pics/edit.png' alt='edita' class='icon'></a>
						<a href='/node/add/omnia-usos-type?data={$use['data']}'><img src='http://{$_SERVER['HTTP_HOST']}/".drupal_get_path('module', 'omnia_usos')."/pics/clone.png' alt='clona' class='icon'></a>" ;
			if ($nodepos == 3) {
				$js = "$(document).ready(function(){
					$('a#button_{$sha}').click(function(){
					$('.group_{$sha}').toggle();
					$('a#button_{$sha}').text(
						$('.group_{$sha}').is(':visible') ? 'Amaga els usos antics' : 'Mostra els usos antics'
					);
					$('.td1_{$sha}').attr('rowspan',
						$('.group_{$sha}').is(':visible') ? '{$num_uses}' : '4'
					);
				});});";
				drupal_add_js($js, 'inline');
				$colspan = 4;
				if ($dina) $colspan++;
				$button = "<a id='button_{$sha}'>Mostra els usos antics</a>";
				$newrow = array(array('data' => $button, 'colspan' => $colspan, 'class' => 'rowsbutton'));
				$rows[] = $newrow;
			}
			if ($first) {
				$newrow = array(array('data' => $group, 'rowspan' => $initial_uses, 'class' => 'td1 td1_'.$sha), 
								array('data' => date('d/m/y', $use['starttime']), 'class' => 'td2'), 
								array('data' => $use['campaign'], 'class' => 'td3'), 
								array('data' => $use['participants'], 'class' => 'td4'), 
								);
				if ($dina) $newrow[] = array('data' => $actions, 'class' => 'td5');			
				$first = false;
			} elseif ($nodepos >= 3) {
				$data = array(date('d/m/y', $use['starttime']), $use['campaign'], $use['participants']);
				if ($dina) $data[] = $actions;
				$newrow = array('data' => $data, 'class' => 'group_'.$sha.' groupoff');
			} else {
				$newrow = array(date('d/m/y', $use['starttime']), $use['campaign'], $use['participants']);
				if ($dina) $newrow[] = $actions;
			}
			$rows[] = $newrow;
			$nodepos++;
		}
	}
	echo theme_table($st_header, $rows, array('class' => 'medsize usos-omnia'));	
}


?>



