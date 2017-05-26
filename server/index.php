<?
	require_once("config.php");
	require_once("../daesung_structure.php");
	require_once("../../xml/db/mte/mte.php");
	
	if(IsSet($_REQUEST["XDEBUG_SESSION_START"]))
	{
		$HTTP_RAW_POST_DATA = '0030020000000000000000000011051a0c2c0a00000000000000000000001809006317810025390000001004050ac803';
	}

	# data branch
	$por = 0;
	do {
	  $daes_file = 'data/daesung' .Date("_Ymd_His_"). $por++ .'.dat';
	} while( file_exists($daes_file));

	@file_put_contents($daes_file, $HTTP_RAW_POST_DATA);

	# database open
	$tabledit = new MySQLtabledit();
	$tabledit->database_connect_quick(DB_NAME, 'daesung');
	$tabledit->primary_key = "id";
	
	# parsing
	$data_hex = strtoupper($HTTP_RAW_POST_DATA);
	$length = hexdec(substr_cut($data_hex, 2));
	
	# packets
	while( strlen($data_hex) > 0 )
	{
		# add to post
		$_POST = null;

		# parsing
		$daesung_frame = daesung_analyze_frame($data_hex);
		foreach ($daesung_frame as $name => $value)
		{
			$name = $map_fields[$name];
			if( $name != "fe")
			{
				if( is_array($value)) {
					$value = $value[0];
				}
				list($value, $mj) = explode(" ", $value);
			}

			if( $name != "" ) {
				$_POST[$name] = $value;
			}
		}
		
		# store it
		$_POST['mte_new_rec'] = "new";
		$tabledit->save_rec_directly();
	}

	# close
	$tabledit->database_disconnect();
?>
