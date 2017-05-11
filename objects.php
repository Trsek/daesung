<?php
/********************************************************************
* @brief Strip 'len' chars from start of string 
*/
function substr_cut(&$SMS, $len)
{
	$cut_str = substr($SMS, 0, 2*$len);
	$SMS = substr($SMS, 2*$len, strlen($SMS) - 2*$len);
	return $cut_str;
}

/********************************************************************
* @brief hex2bin in PHP < 5.4.0
*/
if (PHP_VERSION_ID < 50400) {
function hex2bin($hex_string)
{
	return pack("H*" , $hex_string);
}
}

/********************************************************************
* @brief Convert hex to string
*/
function hexToStr($hex)
{
	$string='';
	for ($i=0; $i < strlen($hex)-1; $i+=2){
		$string .= chr(hexdec($hex[$i].$hex[$i+1]));
	}
	return $string;
}

/********************************************************************
* @brief Return text presentation unit of measure
*/
function deasung_get_mj($unit)
{
	$unit_str = array(
		 UNIT_DEFAULT =>"",			
		 UNIT_stC =>    "°C",
		 UNIT_stF =>    "°F",
		 UNIT_Kelvin => "K",
		 UNIT_stR =>    "°R",
		 UNIT_kPa =>    "kPa",
		 UNIT_Pa =>     "Pa",
		 UNIT_MPa =>    "MPa",
		 UNIT_bar =>    "bar",
		 UNIT_torr =>   "torr",
		 UNIT_PSI =>    "PSI",
		 UNIT_at =>     "at",
		 UNIT_kgfcm2 => "kgf/cm²",
		 UNIT_atm =>    "atm",
		 UNIT_MJm3 =>   "MJ/m³",
		 UNIT_kWhm3 =>  "kWh/m³",
		 UNIT_Btuft3 => "Btu/ft³",
		 UNIT_MJ =>     "MJ",
		 UNIT_kWh =>    "kWh",
		 UNIT_Btu =>    "Btu",
		 UNIT_m3 =>     "m³",
		 UNIT_ft3 =>    "ft³",
		 UNIT_nm3 =>    "nm³",
		 UNIT_nft3 =>   "nft³",
		 UNIT_m3h =>    "m³/h",
		 UNIT_ft3h =>   "ft³/h",
		 UNIT_nm3h =>   "nm³/h",
		 UNIT_nft3h =>  "nft³/h",
		 UNIT_yard3h => "yard³/h",
		 UNIT_galh =>   "gal³/h",
		 UNIT_yard3 =>  "yard³",
		 UNIT_gal =>    "galon",
		 UNIT_V =>      "V",
		 UNIT_mV =>     "mV",
		 UNIT_A =>      "A",
		 UNIT_mA =>     "mA",
		 UNIT_m =>      "m",
		 UNIT_ft =>     "ft",
		 UNIT_kgm3 =>   "kg/m³",
		 UNIT_h =>      "hrs",
		 UNIT_dB =>     "dB",
		 UNIT_HEX =>    "h",
		 UNIT_percent =>"%",
	);
		
	return $unit_str[$unit];
}

/********************************************************************
* @brief Deasung date presentation
*/
function deasung_date($DATI)
{
	$data_year   = hexdec(substr_cut($DATI, 1))+2000;	
	$data_month  = hexdec(substr_cut($DATI, 1));	
	$data_day    = hexdec(substr_cut($DATI, 1));	
	$data_hour   = hexdec(substr_cut($DATI, 1));	
	$data_minute = hexdec(substr_cut($DATI, 1));	
	$data_second = hexdec(substr_cut($DATI, 1));
	
	return sprintf("%04d-%02d-%02d %02d:%02d:%02d", $data_year, $data_month, $data_day, $data_hour, $data_minute, $data_second);	break;
}

/********************************************************************
* @brief When need value to one line
*/
function array_val_line($value)
{
	if(!is_array($value))
		return $value[0];

	$answer = "";
	foreach ($value[0] as $value_line)
	{
		$answer .= (empty($answer)? "": ", "). $value_line;
	}
	return $answer;
}

/*----------------------------------------------------------------------------*/
/* END OF FILE */
