<?php
	error_reporting(E_ERROR | E_WARNING | E_PARSE);

	require("time_meas.php");
	require("example.php");
	require("daesung_structure.php");
	
	// some example for debug mode
	if(IsSet($_REQUEST["XDEBUG_SESSION_START"]))
	{
  		$_REQUEST["DAESUNG_FRAME"] = "00:30:02:02:00:00:01:00:00:00:00:00:08:11:05:0b:0d:1e:00:00:00:00:0c:40:00:00:00:0b:81:00:19:10:00:62:05:1b:00:24:8a:00:04:2f:10:01:00:0a:2b:03";
	}

	$DAESUNG_FRAME = DAESUNG_NORMALIZE($_REQUEST["DAESUNG_FRAME"]);
?>

<!doctype HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
	<meta HTTP-EQUIV='Content-Type' CONTENT='text/html; charset=UTF-8'>
	<meta name='author' lang='en' content='Zdeno Sekerák, www.trsek.com'>
	<link rel='shortcut icon' href='favicon.ico'>
	<link rel='stylesheet' href='daesung.css'>
	<title>DAESUNG online</title>
</head>
<body>
<h1>DAESUNG Encrypt online</h1>

<?php echo show_example();?>
<table>
<form action='index.php' method='post' ENCTYPE='multipart/form-data' class='form-style-two'>
	Packet (hex format)<br>
	<textarea name='DAESUNG_FRAME' rows="9" cols="63"><?php echo $DAESUNG_FRAME;?></textarea><br>
	<input type='submit' name='analyze' value='analyze'><br>
	<br>Frame<br>
	<?php
	//var_dump($GLOBALS);
	echo daesung_show($DAESUNG_FRAME);
	?>
</form>
</table>

<?php
	require("paticka.php");
?>