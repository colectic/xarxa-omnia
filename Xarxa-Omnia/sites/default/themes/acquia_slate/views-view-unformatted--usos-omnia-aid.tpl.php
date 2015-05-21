<?php

drupal_add_css(drupal_get_path('module', 'omnia_usos') . '/css/omnia_usos.css');

global $user;
$dina = false;
if (in_array('dinamitzadors', array_values($user->roles))) $dina = true;

echo '<h3>'.$act['title'].'</h3>';
$st_header = array(
		array('data' => t('Data'), 'class' => 'th1'),
		array('data' => t('Grup/Edició'), 'class' => 'th2'),
		array('data' => t('Campanya'), 'class' => 'th3'),
		array('data' => t('Participants'), 'class' => 'th4'),
);
if ($dina) $st_header[] = array('data' => t('Accions'), 'class' => 'th5');
$tablerows = array();

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
	
	$campaign = taxonomy_get_term($use->usca);
	$url = url(drupal_get_path_alias( 'node/' . $node->nid));
	
	$actions = "<a href='{$url}'><img src='http://{$_SERVER['HTTP_HOST']}/".drupal_get_path('module', 'omnia_usos') . "/pics/view.png' alt='mostra' class='icon'></a>
				<a href='/node/{$node->nid}/edit'><img src='http://{$_SERVER['HTTP_HOST']}/".drupal_get_path('module', 'omnia_usos')."/pics/edit.png' alt='edita' class='icon'></a>
				<a href='/node/add/omnia-usos-type?usid={$node->nid}'><img src='http://{$_SERVER['HTTP_HOST']}/".drupal_get_path('module', 'omnia_usos')."/pics/clone.png' alt='clona' class='icon'></a>" ;
	
	$newrow = array(date('d/m/y', $use->usin), $use->usgr, $campaign->name, $participants);
	if ($dina) $newrow[] = $actions;
	
	$tablerows[] = $newrow;
}
echo theme_table($st_header, $tablerows, array('class' => 'medsize usos-omnia'));
?>



