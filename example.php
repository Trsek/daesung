<?php
define('DAESUNG_DATA',   "Data");
define('DAESUNG_ANSWER', "Answer");

$example_packet = array(
	DAESUNG_DATA   => "00:30:02:02:00:00:01:00:00:00:00:00:08:11:05:0b:0d:1e:00:00:00:00:0c:40:00:00:00:0b:81:00:19:10:00:62:05:1b:00:24:8a:00:04:2f:10:01:00:0a:2b:03",
	DAESUNG_ANSWER => "2a:41:30:30:30:30:30:30:30:30:0d",
);


/********************************************************************
* @brief Example is need
*/
function is_example_time()
{
	if( empty($_POST) && empty($_GET))
		return true;
	
	return false;
}

/********************************************************************
* @brief Show links to example
*/
function show_example()
{
	if( !is_example_time())
		return;
	
	global $example_packet;
	$out = "Examples<br>";
	
	foreach ($example_packet as $example_name => $example_packet_list)
	{
		$link = "index.php?DAESUNG_FRAME=". $example_packet_list ."";
		$out .= "<a href='$link'>[". $example_name."]</a>&nbsp;";	
	}
	$out .= "<br><br>";
	return $out; 
}

/*----------------------------------------------------------------------------*/
/* END OF FILE */