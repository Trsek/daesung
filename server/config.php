<?php
	# db filename
//	define('DB_NAME', "data/daesung.sqlite");
	define('DB_NAME', "../../xml/SLRCAppTerm/data/xmldata.sqlite");

	date_default_timezone_set('Europe/Prague');
	
	# map values name
	$map_fields = array(
		'STX'        => '',
		'ARM ID1'    => 'arm_id1',
		'ARM ID2'    => 'arm_id2',
		'USER PART'  => 'user_part',
		'EVC MODEL'  => 'evc',
		'DATE/TIME'  => 'fe',
		'VM'         => 'vm',
		'VB'         => 'vb',
		'TEMP'       => 'temp',
		'PRESS'      => 'press',
		'C'          => 'c',
		'QB'         => 'qb',
		'ALARM'      => 'alarm',
		'FW VERSION' => 'fw',
		'DATA INTERVAL' => 'period',
		'CRC'        => 'crc',
		'ETX'        => ''
	);
