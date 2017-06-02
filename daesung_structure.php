<?php
require_once("objects.php");

/********************************************************************
* @brief Remove 0A/0D if have it. Remove SMS prefix if have it
*/
function DAESUNG_NORMALIZE($SMS)
{
	$SMS = strtoupper($SMS);
	
	// strip all spaces
	$SMS = str_replace(' ', '', $SMS);
	$SMS = str_replace(':', '', $SMS);
	$SMS = str_replace("\r", '', $SMS);
	$SMS = str_replace("\n", '', $SMS);
	$SMS = str_replace("0x", '', $SMS);
	return $SMS;
}

/********************************************************************
 * @brief Added space every $len
 */
function add_soft_space($DATI, $len)
{
	$asnwer = "";
	while( strlen($DATI))
	{	
		$answer .= substr($DATI, 0, $len) ." ";
		$DATI = substr($DATI, $len, strlen($DATI));
	}   

	return $answer;
}

/********************************************************************
* @brief Make HTML format from array
* @retval HTML format divide by <br>
*/
function daesung_array_show($value)
{
	if( is_array($value) && count($value)==1)
		$value = $value[0];
	
	if( !is_array($value))
	{
		$space = "";
		while($value[0] == ' ')
		{
			$space .= "&nbsp;";
			$value = substr($value, 1, strlen($value));
		}
		return $space. $value;
	}

	$out = "";
	foreach ($value as $value_line)
	{
		$out .= daesung_array_show($value_line) . "<br>";
	}
	return $out;
}

/********************************************************************
* @brief Show analyze PACKET
* @retval HTML table format
*/
function daesung_show($SMS)
{
	$length = hexdec(substr_cut($SMS, 2));
	$out = "";
	while( strlen($SMS) > 0 )
	{
		$DAESUNG_FRAME = daesung_analyze_frame($SMS);
		$out .= "<table class='table-style-two'>";
		if( $length > 0 )
		{
			$out .= "<tr><td>LENGTH</td><td>$length Bytes</td></tr>";
			$length = 0;
		}
		foreach ($DAESUNG_FRAME as $name => $value)
		{
			$out .= "<tr>";
			$out .= "<td>". $name ."</td>";
			$out .= "<td>";
			$out .= daesung_array_show($value);
			$out .= "</td>";
			$out .= "</tr>";
		}
		$out .= "</table>";
		$out .= "<br><br>";
	}
	
	return $out;
}

/********************************************************************
* @brief Check CRC
*/
function daesung_CRCCheck($crc, $crc_data)
{
	// compute
	$crc_compute = 0;
	while( strlen($crc_data))
	{
		$crc_compute ^= hexdec(substr_cut($crc_data,1));
	}
	
	$crc_compute += 1;
	$crc_compute = sprintf("%02X", $crc_compute);
	
	if( $crc_compute == $crc )
		$answ = "$crc - OK";
	else
		$answ = "$crc - bad, correctly $crc_compute";
				
	return $answ;
}

/********************************************************************
* @brief Decomp alarm byte
*/
function decomp_alarm($alarm)
{
	$alarm_text = array(
		0 => "0: Normal",
		1 => "1: Alarm",
	);
	$answer[] = $alarm ." hex";
	$answer[] = $alarm_text[($alarm & 0x01)>0] ." - Temperature Low limit";
	$answer[] = $alarm_text[($alarm & 0x02)>0] ." - Temperature High limit";
	$answer[] = $alarm_text[($alarm & 0x04)>0] ." - Pressure Low limit";
	$answer[] = $alarm_text[($alarm & 0x08)>0] ." - Pressure High limit";
	$answer[] = $alarm_text[($alarm & 0x10)>0] ." - Low voltage";
	$answer[] = $alarm_text[($alarm & 0x20)>0] ." - Exceeds the range Input Signal";
	$answer[] = $alarm_text[($alarm & 0x40)>0] ." - EVC communication error";
		
	return $answer;
}

/********************************************************************
* @brief Convert HEX to float
*/
function daesung_float($SMS, $len, $decimal)
{
	$cislo = (double)hexdec(substr_cut($SMS, $len - $decimal));
	$part  = (double)hexdec(substr_cut($SMS, $decimal));
	$part /= pow(10, 2*$decimal);
	
	return $cislo + $part; 
}

/********************************************************************
* @brief MetaAnalyze frame name
*/
function daesung_analyze_frame(&$SMS)
{
	$crc_data = substr($SMS, 2, 86);
	$SMS_DATI['STX']        = substr_cut($SMS, 1);
	$SMS_DATI['ARM ID1']    = substr_cut($SMS, 1);
	$SMS_DATI['ARM ID2']    = substr_cut($SMS, 3);	
	$SMS_DATI['USER PART']  = substr_cut($SMS, 5);
	$SMS_DATI['EVC MODEL']  = substr_cut($SMS, 1);
	$SMS_DATI['DATE/TIME']  = daesung_date(substr_cut($SMS, 6));
	$SMS_DATI['VM']         = hexdec(substr_cut($SMS, 5)) . " ". daesung_get_mj(UNIT_m3);
	$SMS_DATI['VB']         = hexdec(substr_cut($SMS, 5)) . " ". daesung_get_mj(UNIT_m3);
	$temp_sing              = substr_cut($SMS, 1);
	$SMS_DATI['TEMP']       = (daesung_float(substr_cut($SMS, 2), 2, 1) * (($temp_sing=='01')? -1: 1)) . " ". daesung_get_mj(UNIT_stC);
	$SMS_DATI['PRESS']      = daesung_float(substr_cut($SMS, 4), 4, 2) . " ". daesung_get_mj(UNIT_kPa);
	$SMS_DATI['C']          = daesung_float(substr_cut($SMS, 3), 3, 2);
	$SMS_DATI['QB']         = hexdec(substr_cut($SMS, 3)) . " ". daesung_get_mj(UNIT_m3h);
	$SMS_DATI['ALARM']      = decomp_alarm(substr_cut($SMS, 1));
	$SMS_DATI['FW VERSION'] = daesung_float(substr_cut($SMS, 2), 2, 1);
	$SMS_DATI['DATA INTERVAL'] = hexdec(substr_cut($SMS, 1)). " min";
	$SMS_DATI['CRC']        = daesung_CRCCheck(substr_cut($SMS, 1), $crc_data);
	$SMS_DATI['ETX']        = substr_cut($SMS, 1);
	
	return $SMS_DATI;
}
/*----------------------------------------------------------------------------*/
/* END OF FILE */
