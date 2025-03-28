<?php
$DEL_CAT_ALIAS = '';

$ddYesNo = array("0"=>"Нет","1"=>"Да");

$ddMonth = array("01"=>"Январь", "02"=>"Февраль", "03"=>"Март", "04"=>"Апрель", "05"=>"Май", "06"=>"Июнь", "07"=>"Июль", "08"=>"Август", "09"=>"Сентябрь", "10"=>"Октябрь", "11"=>"Ноябрь", "12"=>"Декабрь");
$ddMonthSm = array("01"=>"январь", "02"=>"февраль", "03"=>"март", "04"=>"апрель", "05"=>"май", "06"=>"июнь", "07"=>"июль", "08"=>"август", "09"=>"сентябрь", "10"=>"октябрь", "11"=>"ноябрь", "12"=>"декабрь");
$ddMonth_ = array("01"=>"января", "02"=>"февраля", "03"=>"марта", "04"=>"апреля", "05"=>"мая", "06"=>"июня", "07"=>"июля", "08"=>"августа", "09"=>"сентября", "10"=>"октября", "11"=>"ноября", "12"=>"декабря");
$ddDay = array(); for($i=1; $i<=31; $i++) { if($i<10) $ddDay[$i] = '0'.$i; else $ddDay[$i] = $i; }
$ddYear = array(); for($i=2008; $i<=2019; $i++) { $ddYear[$i] = $i; }

$rbHitsalesType = array("usual"=>"Обычный","hit"=>"Хит продаж","popular"=>"Мы рекомендуем");

$ddWayPaying = array("0"=>"Наличный расчет", "1"=>"Перечисление", "2"=>"Безналичный расчет(плательщик НДС)", "3"=>"Безналичный расчет(плательщик единого налога)", "4"=>"Portmone", "5"=>"Интернет деньги (webmoney и др.)");
$ddWayPayingOrder = array("0"=>"Наличный расчет", "2"=>"Безналичный расчет(плательщик НДС)", "3"=>"Безналичный расчет(плательщик единого налога)", "4"=>"Portmone", "5"=>"Webmoney", "6"=>"Другие интернет деньги");
$ddOrderStatus = array("0"=>"Новый", "6"=>"Принят", "1"=>"Подтвержден", "2"=>"Отклонен", "3"=>"Скоординирован", "4"=>"Выполнен", "5"=>"Нет в наличии");
$ddPriority = array("1"=>"Высокий","2"=>"Средний","3"=>"Низкий");
$ddPriorityFilter = array(""=>"- Приоритет -", "all"=>"Все", "1"=>"Высокий","2"=>"Средний","3"=>"Низкий");

$ddPresenceAdmin = array("1"=>"Есть в наличии","2"=>"Нет в наличии");
$ddPresenceClient = array("1"=>"Есть в наличии","2"=>"<span style=\"color:#FF0000;\">Нет в наличии</span>");
$ddResourceSort = array("name"=>"Название","price"=>"Цена");

$ddUserType = array("user"=>"Пользователь","admin"=>"Администратор");
$ddUserType2 = array("user"=>"Пользователь");
$ddGender = array("false"=>"-выбрать-","male"=>"Мужской","female"=>"Женский");
$ddPermAll = array("1"=>"Активный","0"=>"Скрытый");
$ddDelivery = array("1"=>"без доставки","2"=>"доставка по Киеву","3"=>"доставка по Украине");

$ddAlphabet_ru = array("А"=>"а","Б"=>"б","В"=>"в","Г"=>"г","Д"=>"д","Е"=>"е","Ё"=>"ё","Ж"=>"ж","З"=>"з","И"=>"и","К"=>"к","Л"=>"л","М"=>"м","Н"=>"н","О"=>"о","П"=>"п","Р"=>"р","С"=>"с","Т"=>"т","У"=>"у","Ф"=>"ф","Х"=>"х","Ц"=>"ц","Ч"=>"ч","Ш"=>"ш","Щ"=>"щ","Э"=>"э","Ю"=>"ю","Я"=>"я");
$ddAlphabet_en = array("A"=>"a","B"=>"b","C"=>"c","D"=>"d","E"=>"e","F"=>"f","G"=>"g","H"=>"h","I"=>"i","J"=>"j","K"=>"k","L"=>"l","M"=>"m","N"=>"n","O"=>"o","P"=>"p","Q"=>"q","R"=>"r","S"=>"s","T"=>"t","U"=>"u","V"=>"v","W"=>"w","X"=>"x","Y"=>"y","Z"=>"z");

$ddSmileys = array("*IN LOVE*",
				   "*NO*",
				   "8-)",
				   ":-)",
				   ":-D",
				   "*TEARS*",
				   "*CRAZY*",
				   "*ROSE*",
				   "[:-}",
				   ":-(",
				   "*DEVIL*",
				   "*IDEA*",
				   "*ANGEL*",
				   "*SHOCK*",
				   "*TIRED*",
				   "*SICK*",
				   ":-P",
				   ":-*",
				   "*MALICIOUS*",
				   "*ASTERISK*",
				   "*DRINK*",
				   "@=",
				   "*HEART*",
				   "*POINTER*"
);
$ddImages = array(" <img src='../images/icon/smileys/1.gif'> ",
				  " <img src='../images/icon/smileys/2.gif'> ",
				  " <img src='../images/icon/smileys/3.gif'> ",
				  " <img src='../images/icon/smileys/4.gif'> ",
				  " <img src='../images/icon/smileys/5.gif'> ",
				  " <img src='../images/icon/smileys/6.gif'> ",
				  " <img src='../images/icon/smileys/7.gif'> ",
				  " <img src='../images/icon/smileys/8.gif'> ",
				  " <img src='../images/icon/smileys/9.gif'> ",
				  " <img src='../images/icon/smileys/10.gif'> ",
				  " <img src='../images/icon/smileys/11.gif'> ",
				  " <img src='../images/icon/smileys/12.gif'> ",
				  " <img src='../images/icon/smileys/13.gif'> ",
				  " <img src='../images/icon/smileys/14.gif'> ",
				  " <img src='../images/icon/smileys/15.gif'> ",
				  " <img src='../images/icon/smileys/16.gif'> ",
				  " <img src='../images/icon/smileys/17.gif'> ",
				  " <img src='../images/icon/smileys/18.gif'> ",
				  " <img src='../images/icon/smileys/19.gif'> ",
				  " <img src='../images/icon/smileys/20.gif'> ",
				  " <img src='../images/icon/smileys/21.gif'> ",
				  " <img src='../images/icon/smileys/22.gif'> ",
				  " <img src='../images/icon/smileys/23.gif'> ",
				  " <img src='../images/icon/smileys/24.gif'> "
);

function getNewID(){
	$newID = (mktime()+rand(1,1000000000)).rand(1,9).rand(1,9);
	return $newID;
}
function getNewDate(){
	$newDate = date("Y-m-d H:i:s");
	return $newDate;
}
//drop down
function setDropDown($ddName)
{
	global $$ddName;
	$ddArray = $$ddName;
	$stringOption = "";
	while(list($optionKey, $optionValue) = each($ddArray))
	{
		$stringOption .= '<option value="'.$optionKey.'">'.$optionValue.'</option>';
	}
	return $stringOption;
}
function getSelectedDropDown($ddName, $optionSelected)
{
	global $$ddName;
	$ddArray = $$ddName;
	$stringOption = "";
	while(list($optionKey, $optionValue) = each($ddArray))
	{
		if($optionKey == $optionSelected)
		{
			$stringOption .= '<option selected="selected" value="'.$optionKey.'">'.$optionValue.'</option>';
		}
		else
		{
			$stringOption .= '<option value="'.$optionKey.'">'.$optionValue.'</option>';
		}
	}
	return $stringOption;
}
function getValueDropDown($ddName, $key)
{
	global $$ddName;
	$ddArray = $$ddName;
	if(!empty($key)) $res = $ddArray[$key]; elseif($key == "0") $res = $ddArray[0]; else $res = '';
	return $res;
}
function getSelectedMultyDropDown($ddName, $optionSelected, $separator)
{
	$optionSelected = explode($separator, $optionSelected);
	global $$ddName;
	$ddArray = $$ddName;
	$stringOption = "";
		while(list($optionKey, $optionValue) = each($ddArray))
		{
			for($i=0; $i < count($optionSelected); $i++)
			{
				if($optionKey == $optionSelected[$i])
				{
					$stringOptionTmp = '<option selected="selected" value="'.$optionKey.'">'.$optionValue.'</option>';
					break;
				}
				else
				{
					$stringOptionTmp = '<option value="'.$optionKey.'">'.$optionValue.'</option>';
					continue;
				}
			}
			$stringOption .= $stringOptionTmp;
		}
	return $stringOption;
}
//radio button
function setRadioButton($rbName, $fieldName)
{
	global $$rbName;
	$stringRadio = "";
	while(list($radioKey, $radioValue) = each($$rbName))
	{
		$stringRadio .= '<input name="'.$fieldName.'" type="radio" value="'.$radioKey.'"> '.$radioValue.' ';
	}
	return $stringRadio;
}
function getCheckedRadioButton($rbName, $fieldName, $radioCheked)
{
	global $$rbName;
	$stringRadio = "";
	while(list($radioKey, $radioValue) = each($$rbName))
	{
		if(empty($radioCheked))
		{
			$radioCheked = $radioKey;
		}
		if($radioKey == $radioCheked)
		{
			$stringRadio .= '<input name="'.$fieldName.'" type="radio" value="'.$radioKey.'" checked> '.$radioValue.' ';
		}
		else
		{
			$stringRadio .= '<input name="'.$fieldName.'" type="radio" value="'.$radioKey.'"> '.$radioValue.' ';
		}
	}
	return $stringRadio;
}
function getValueRadioButton($rbName, $key)
{
	global $$rbName;
	$rbtemp = $$rbName;
	return $rbtemp[$key];
}

function getCheckedCheckBox($ddName, $optionCheked, $nameField, $printFormat)
{
	global $$ddName;
	$ddArray = $$ddName;
	$stringOption = "";
	if($printFormat == 'vertical') $sep = '<br>';
	if($printFormat == 'horizontal') $sep = ' ';
	if($printFormat == 'table')
	{
	}
	else
	{
		while(list($optionKey, $optionValue) = each($ddArray))
		{
			$stringOption .= '<input name="check_'.$nameField.'['.$optionKey.']" type="hidden" value="0">';
			if(sitetype == 'client')
			{
				if(strstr($optionCheked, '&'.$optionKey.'&'))
				{
					$stringOption .= '<nobr><input id="check_'.$nameField.'_'.$optionKey.'" name="check_'.$nameField.'['.$optionKey.']" type="checkbox" value="1" checked>&nbsp;<a href="" onClick="checkelem(\'check_'.$nameField.'_'.$optionKey.'\'); return false;"><span style="color:#000000;">'.$optionValue.'</span></a></nobr>'.$sep;
				}
				else
				{
					$stringOption .= '<nobr><input id="check_'.$nameField.'_'.$optionKey.'" name="check_'.$nameField.'['.$optionKey.']" type="checkbox" value="1">&nbsp;<a href="" onClick="checkelem(\'check_'.$nameField.'_'.$optionKey.'\'); return false;"><span style="color:#646464;">'.$optionValue.'</span></a></nobr>'.$sep;
				}
			}
			else
			{
				if(strstr($optionCheked, '&'.$optionKey.'&'))
				{
					$stringOption .= '<nobr><input id="check_'.$nameField.'_'.$optionKey.'" name="check_'.$nameField.'['.$optionKey.']" type="checkbox" value="1" checked>&nbsp;'.$optionValue.'</nobr>'.$sep;
				}
				else
				{
					$stringOption .= '<nobr><input id="check_'.$nameField.'_'.$optionKey.'" name="check_'.$nameField.'['.$optionKey.']" type="checkbox" value="1">&nbsp;'.$optionValue.'</nobr>'.$sep;
				}
			}
		}
	}
	return $stringOption;
}
/*
function getCheckedCheckBoxFilter($ddName, $optionCheked, $nameField, $printFormat)
{
	global $$ddName;
	$ddArray = $$ddName;
	$stringOption = "";
	if($printFormat == 'vertical') $sep = '<br>';
	if($printFormat == 'horizontal') $sep = ' ';
	if($printFormat == 'table')
	{
	}
	else
	{
		while(list($optionKey, $optionValue) = each($ddArray))
		{
			if(strstr($optionCheked, '&'.$optionKey.'&'))
			{
				$stringOption .= '<nobr><input id="check_'.$nameField.'_'.$optionKey.'" name="check_'.$nameField.'['.$optionKey.']" type="checkbox" value="1" checked>&nbsp;<a href="" onClick="checkelem(\'check_'.$nameField.'_'.$optionKey.'\'); return false;"><span style="color:#000000;">'.$optionValue.'</span></a></nobr>'.$sep;
			}
			else
			{
				$stringOption .= '<nobr><input id="check_'.$nameField.'_'.$optionKey.'" name="check_'.$nameField.'['.$optionKey.']" type="checkbox" value="1">&nbsp;<a href="" onClick="checkelem(\'check_'.$nameField.'_'.$optionKey.'\'); return false;"><span style="color:#646464;">'.$optionValue.'</span></a></nobr>'.$sep;
			}
		}
	}
	return $stringOption;
}
*/
/*
function getCheckedCheckBox($ddName, $optionCheked, $nameField, $printFormat)
{
	global $$ddName;
	$ddArray = $$ddName;
	$stringOption = "";
	if($printFormat == 'vertical') $sep = '<br>';
	if($printFormat == 'horizontal') $sep = ' ';
	if($printFormat == 'table')
	{
	}
	else
	{
		while(list($optionKey, $optionValue) = each($ddArray))
		{
			if(strstr($optionCheked, '&'.$optionKey.'&')) $checked = 'checked'; else $checked = '';
			$stringOption .= '<nobr><input name="check_'.$nameField.'['.$optionKey.']" type="checkbox" value="1" '.$checked.'>&nbsp;'.$optionValue.'</nobr>'.$sep;
		}
	}
	return $stringOption;
}
*/

function getValueCheckBox($ddName, $optionCheked, $printFormat)
{
	global $$ddName;
	$ddArray = $$ddName;
	$stringOption = "";
	if($printFormat == 'vertical') $sep = '<br>';
	if($printFormat == 'horizontal') $sep = ', ';

	while(list($optionKey, $optionValue) = each($ddArray))
	{
		if(strstr($optionCheked, '&'.$optionKey.'&')) $stringOption .= $optionValue.$sep;
	}
	return $stringOption;
}

function formatDate($date,$typedate)
{
	$stringDate = '';
	if(!empty($date))
	{
		if($typedate == 'datetime')
		{
			$stringDate = substr($date,8,2).".".substr($date,5,2).".".substr($date,2,2)."&#160;".substr($date,11,2).":".substr($date,14,2);
		}
		if($typedate == 'date')
		{
			$stringDate = substr($date,8,2).".".substr($date,5,2).".".substr($date,0,4);
		}
		if($typedate == 'date_sm')
		{
			$stringDate = substr($date,8,2).".".substr($date,5,2);
		}
		if($typedate == 'time')
		{
			$stringDate = substr($date,0,2).":".substr($date,3,2);
		}
		if($typedate == 'db')
		{
			$stringDate = substr($date,6,4)."-".substr($date,3,2)."-".substr($date,0,2);
		}
		if($typedate == 'db_time')
		{
			$stringDate = substr($date,0,2).":".substr($date,3,2).":00";
		}
	}
	return $stringDate;
}

function mail_coding($text)
{
	$str = 'qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM1234567890';
	$res = '';
	srand((double) microtime() * 100000);
	$i = 0;
	while(strlen($text) > $i)
	{
		$str_loc = rand(0, strlen($str)-1);
		$res .= $text[$i].$str[$str_loc];
		$i++;
	}
	return $res;
}

function mail_encoding($text)
{
	$i = 0;
	$res = '';
	while(strlen($text) > $i)
	{
		if($i%2 == 0)
		{
			$res .= $text[$i];
		}
		$i++;
	}
	return $res;
}

function random_pass()
{
	$str = 'qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM1234567890';
	$pass = 'q';
	srand((double) microtime() * 100000);
	$i = 0;
	while(strlen($pass) < 6)
	{
		$str_loc = rand(0, strlen($str)-1);
		$pass[$i] = $str[$str_loc];
		$i++;
	}
	return $pass;
}

function toUpper($str) {
	$str = iconv('UTF-8', 'WINDOWS-1251', $str);
	$str = strtr(strtoupper($str), '[абвгдеёжзийклмнорпстуфхцчшщъьыэюя]', '[АБВГДЕЁЖЗИЙКЛМНОРПСТУФХЦЧШЩЪЬЫЭЮЯ]');
	$str = iconv('WINDOWS-1251', 'UTF-8', $str);
	return $str;
}

function toLower($str)
{
	$str = iconv('UTF-8', 'WINDOWS-1251', $str);
	$str = strtr(strtolower($str), '[АБВГДЕЁЖЗИЙКЛМНОРПСТУФХЦЧШЩЪЬЫЭЮЯ]', '[абвгдеёжзийклмнорпстуфхцчшщъьыэюя]');
	$str = iconv('WINDOWS-1251', 'UTF-8', $str);
	return $str;
}

function squash($str,$length_str,$length_space)
{
	$str = str_replace('"','',$str);
	$str = ereg_replace('[[:space:]]+',' ',$str);
	$lenstr = strlen($str);
	if($lenstr > $length_str)
	{
		$posSpase = strpos($str.' ', ' ', $length_space);
		$str = substr($str,0,$posSpase);
	}
	if($lenstr > $length_str)
	{
		$str = ereg_replace('[[:punct:]]*$','',$str);
		$str = $str.'...';
	}
	return $str;
}

function totranslit($str)
{
	$translit_arr = array(
		"а"=>"a","А"=>"a",
		"б"=>"b","Б"=>"b",
		"в"=>"v","В"=>"v",
		"г"=>"g","Г"=>"g",
		"д"=>"d","Д"=>"d",
		"е"=>"e","Е"=>"e",
		"ё"=>"yo","Ё"=>"yo",
		"ж"=>"zh","Ж"=>"zh",
		"з"=>"z","З"=>"z",
		"и"=>"i","И"=>"i",
		"й"=>"j","Й"=>"j",
		"к"=>"k","К"=>"k",
		"л"=>"l","Л"=>"l",
		"м"=>"m","М"=>"m",
		"н"=>"n","Н"=>"n",
		"о"=>"o","О"=>"o",
		"п"=>"p","П"=>"p",
		"р"=>"r","Р"=>"r",
		"с"=>"s","С"=>"s",
		"т"=>"t","Т"=>"t",
		"у"=>"u","У"=>"u",
		"ф"=>"f","Ф"=>"f",
		"х"=>"h","Х"=>"h",
		"ц"=>"c","Ц"=>"c",
		"ч"=>"ch","Ч"=>"ch",
		"ш"=>"sh","Ш"=>"sh",
		"щ"=>"ssh","Щ"=>"ssh",
		"ъ"=>"","Ъ"=>"",
		"ы"=>"y","Ы"=>"y",
		"ь"=>"","Ь"=>"",
		"э"=>"eh","Э"=>"eh",
		"ю"=>"yu","Ю"=>"yu",
		"я"=>"ya","Я"=>"ya",
		"і"=>"i","І"=>"I",
		"є"=>"e","Є"=>"e",
		"ї"=>"i","Ї"=>"i"
	);
	$str = strtr($str, $translit_arr);
	return $str;
}

function gen_alias($text,$length_str,$length_space)
{
	$res = trim($text);
	//****************************************************
	$res = totranslit($res);
	$res = strtolower($res);
	//****************************************************
	$res = str_replace("&quot;","",$res);
	$res = eregi_replace("[^a-z0-9[:punct:] ]+","",$res);
	//$res = eregi_replace("[[:punct:][:punct:]]+"," ",$res);
	$res = eregi_replace("[[:punct:]]+"," ",$res);
	$res = eregi_replace("[  ]+"," ",$res);
	$res = str_replace(" ","-",trim($res));
	//****************************************************
	$lenstr = strlen($res);
	if($lenstr > $length_str)
	{
		$posSpase = strpos($res.'-', '-', $length_space);
		$res = substr($res,0,$posSpase);
	}
	//****************************************************
	return $res;
}

function gen_alias2($text,$length_str,$length_space,$lf_tr,$fl_cut)
{
	$res = trim($text);
	//****************************************************
	if($lf_tr != 1)
	{
		$res = totranslit($res);
		$res = strtolower($res);
		//****************************************************
		$res = str_replace("&quot;","",$res);
		$res = str_replace(","," ",$res);
		$res = str_replace("."," ",$res);
		$res = str_replace(":"," ",$res);
		$res = eregi_replace("[^a-z0-9[:punct:] ]+","",$res);
		//$res = eregi_replace("[[:punct:][:punct:]]+"," ",$res);
		$res = eregi_replace("[[:punct:]]+"," ",$res);
		$res = eregi_replace("[  ]+"," ",$res);
		$res = str_replace(" ","-",trim($res));
		//****************************************************
	}
	if($fl_cut != 1)
	{
		$lenstr = strlen($res);
		if($lenstr > $length_str)
		{
			$posSpase = strpos($res.'-', '-', $length_space);
			$res = substr($res,0,$posSpase);
		}
		//****************************************************
	}
	return $res;
}

function validate_latin($text)
{
	$res = trim($text);
	$res = strtolower($res);
	$res = str_replace("&quot;","",$res);
	$res = str_replace(","," ",$res);
	$res = str_replace("."," ",$res);
	$res = str_replace(":"," ",$res);
	$res = eregi_replace("[^a-z0-9[:punct:] ]+","",$res);
	//$res = eregi_replace("[[:punct:][:punct:]]+"," ",$res);
	$res = eregi_replace("[[:punct:]]+"," ",$res);
	$res = eregi_replace("[  ]+"," ",$res);
	$res = str_replace(" ","-",trim($res));
	//****************************************************
	return $res;
}

function validate_quot($text)
{
	$res = trim($text);
	if(strstr($res, '"'))
	{
		$fQuotPos = strpos($res, '"');
		$lQuotPos = strpos($res, '"',$fQuotPos+1);
		if($fQuotPos != 0 OR $lQuotPos != 0) $res = substr($res,$fQuotPos+1,($lQuotPos-$fQuotPos-1)); else $res = '';
	}
	elseif(strstr($res, '\''))
	{
		$fQuotPos = strpos($res, '\'');
		$lQuotPos = strpos($res, '\'',$fQuotPos+1);
		if($fQuotPos != 0 OR $lQuotPos != 0) $res = substr($res,$fQuotPos+1,($lQuotPos-$fQuotPos-1)); else $res = '';
	}
	elseif(strstr($res, '«') OR strstr($res, '»'))
	{
		$fQuotPos = strpos($res, '«');
		$lQuotPos = strpos($res, '»',$fQuotPos+2);
		if($fQuotPos != 0 OR $lQuotPos != 0) $res = substr($res,$fQuotPos+2,($lQuotPos-$fQuotPos-2)); else $res = '';
	}
	elseif(strstr($res, '``'))
	{
		$fQuotPos = strpos($res, '``');
		$lQuotPos = strpos($res, '``',$fQuotPos+2);
		if($fQuotPos != 0 OR $lQuotPos != 0) $res = substr($res,$fQuotPos+2,($lQuotPos-$fQuotPos-2)); else $res = '';
	}
	elseif(strstr($res, '`'))
	{
		$fQuotPos = strpos($res, '`');
		$lQuotPos = strpos($res, '`',$fQuotPos+1);
		if($fQuotPos != 0 OR $lQuotPos != 0) $res = substr($res,$fQuotPos+1,($lQuotPos-$fQuotPos-1)); else $res = '';
	}
	elseif(strstr($res, '&quot;'))
	{
		$fQuotPos = strpos($res, '&quot;');
		$lQuotPos = strpos($res, '&quot;',$fQuotPos+6);
		if($fQuotPos != 0 OR $lQuotPos != 0) $res = substr($res,$fQuotPos+6,($lQuotPos-$fQuotPos-6)); else $res = '';
	}
	else $res = '';

	$res = trim($res);
	if(!empty($res))
	{
		//****************************************************
		$res = totranslit($res);
		$res = strtolower($res);
		//****************************************************
		$res = str_replace(","," ",$res);
		$res = str_replace("."," ",$res);
		$res = str_replace(":"," ",$res);
		$res = eregi_replace("[^a-z0-9[:punct:] ]+","",$res);
		//$res = eregi_replace("[[:punct:][:punct:]]+"," ",$res);
		$res = eregi_replace("[[:punct:]]+"," ",$res);
		$res = eregi_replace("[  ]+"," ",$res);
		$res = str_replace(" ","-",trim($res));
		//****************************************************
	}
	return $res;
}

function to_xml($str)
{
	return str_replace( array('<','>','&'), array('&lt;','&gt;',' '), $str);
	return $str;
}

function to_xml_char($str)
{
	return str_replace( array('<','>','&'), array('&lt;','&gt;',' '), $str);
	return $str;
}


function lower_str_kirilica($str)
{
	$res = trim($str);
	$bg_sm_arr = array( "А"=>"а", "Б"=>"б", "В"=>"в", "Г"=>"г", "Д"=>"д", "Е"=>"е", "Ё"=>"ё", "Ж"=>"ж", "З"=>"з", "И"=>"и", "Й"=>"й", "К"=>"к", "Л"=>"л", "М"=>"м", "Н"=>"н", "О"=>"о", "П"=>"п", "Р"=>"р", "С"=>"с", "Т"=>"т", "У"=>"у", "Ф"=>"ф", "Х"=>"х", "Ц"=>"ц", "Ч"=>"ч", "Ш"=>"ш", "Щ"=>"щ", "Ъ"=>"ъ", "Ы"=>"ы", "Ь"=>"ь", "Э"=>"э", "Ю"=>"ю","Я"=>"я","І"=>"і","Є"=>"є","Ї"=>"ї");
	$res = strtr($res, $bg_sm_arr);
	return $res;
}

function obrezanie_okonchaniy($str)
{
	$str = trim($str);
	$glasn_kir_arr = array(
		"а"=>"","А"=>"",
		"е"=>"","Е"=>"",
		"ё"=>"","Ё"=>"",
		"и"=>"","И"=>"",
		"й"=>"","Й"=>"",
		"о"=>"","О"=>"",
		"у"=>"","У"=>"",
		"ы"=>"","Ы"=>"",
		"ь"=>"","Ь"=>"",
		"э"=>"","Э"=>"",
		"ю"=>"","Ю"=>"",
		"я"=>"","Я"=>"",
		"і"=>"","І"=>"",
		"є"=>"","Є"=>"",
		"ї"=>"","Ї"=>""
	);

	$sub = substr($str, -2);
	$sub = strtr($sub, $glasn_kir_arr);
	$str = substr($str, 0, strlen($str)-2).$sub;

	$sub = substr($str, -2);
	$sub = strtr($sub, $glasn_kir_arr);
	$str = substr($str, 0, strlen($str)-2).$sub;

	$res = $str;
	return $res;
}

function deleteDir($dir)
{
	if(substr($dir, strlen($dir)-1, 1) != '/') $dir .= '/';
	if(!file_exists($dir)) return false;
	if($handle = opendir($dir))
	{
		while($obj = readdir($handle))
		{
			if($obj != '.' && $obj != '..')
			{
				if(is_dir($dir.$obj))
				{
					if(!deleteDir($dir.$obj)) return false;
				}
				elseif (is_file($dir.$obj))
				{
					if (!unlink($dir.$obj)) return false;
				}
			}
		}
		closedir($handle);
		if(!@ rmdir($dir)) return false;
		return true;
	}
	return false;
}
?>
