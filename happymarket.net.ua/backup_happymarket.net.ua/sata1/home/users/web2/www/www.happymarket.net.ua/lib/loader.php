<?php
$loginStatus = $_SESSION['loginStatus'];
if(isset($_SESSION['userArray'])) $userArray = $_SESSION['userArray'];
$request = $_SERVER["REQUEST_URI"];
$sid = $request;
if(strpos($sid, '/hypher/1') !== FALSE){
	$_SESSION['hypher'] = 'yes';
	$sid = str_replace('/hypher/1', '/', $sid);
}
elseif(strpos($sid, '/hypher/0') !== FALSE){
	$_SESSION['hypher'] = 'no';
	$sid = str_replace('/hypher/0', '/', $sid); //header str:648 - hypher();
}

// get languagеs
	$inputLang['tableName'] = 'lang';
	$inputLang['sort_langPosition'] = 'asc';
	$inputLang['sort'] = sortData($inputLang);
	$outputLang = getData($inputLang);
	$inputLang = '';
	for ($i=0; $i < $outputLang['rows']; $i++)
	{
		if($outputLang[$i]['langDefault'] == 1)
		{
			$langDefault = $outputLang[$i]['langAlias'];
		}
	}

if(sitetype == 'client')
{
	$request = str_replace(urlse."/$loaderName/","",$request);
	$request = str_replace(urlse."/$loaderName","",$request);
	$request = str_replace("/$loaderName/","",$request);
	$articleSid = strstr($sid, "/articles/");
	if(empty($articleSid)) $request = str_replace(".html","",$request);
	$request = str_replace(".php","",$request);
	$request = str_replace("-","/",$request);
	$request = str_replace("?","/",$request);
	
	for ($i=0; $i < $outputLang['rows']; $i++)
	{
		$checkLang = strstr($request, '/'.$outputLang[$i]['langAlias'].'/');
		//print_r($checkLang);
		if(!empty($checkLang) AND $outputLang[$i]['langDefault'] != 1)
		{
			$lang = $outputLang[$i]['langAlias'];
			$langAlias = $outputLang[$i]['langAlias'];
			$request = str_replace("/".$outputLang[$i]['langAlias']."/","/",$request);
			$sid = str_replace("/".$outputLang[$i]['langAlias']."/","/",$sid);
		}
	}
	if(empty($langAlias)) $langAlias = $langDefault;
	if(!empty($lang))
	$urlve = $lang.'/';
	else $urlve = '';
	
	$request = ereg_replace("^/","",$request);
	$requestParts = explode("/",$request);	
	//set path to file
	$url = $requestParts[0];
	if(empty($url) OR $url == 'index')
	{
			$url = 'home';
	}
}
else{
	if($loginStatus == 'yes' AND $userArray['groupID'] == 'admin')
	{
		$requestParts = explode("?",$request);
		$requestParts = explode("/",$requestParts[1]);
		//set path to file
		$url = $requestParts[0];
		while(list($key,$value) = each($admpage))
		{
			if($key==$url)
			{
				$pathFile = $value;
				$pageTitle = $admpageTitle[$key];
			}
		}
		if(empty($pathFile))
		{
			$url = 'manageDepartments';
			$pathFile = $admpage['manageDepartments'];
			$pageTitle = $admpageTitle['manageDepartments'];
		}
	}
	else
	{
		$pathFile = 'session/login.php';
		$pageTitle = $admpageTitle['login'];
	}
}

$loaderInSid = strstr($sid, "/".$loaderName."/");
if(sitetype == 'client' and empty($loaderInSid))
{
	// get variables without loader
	for ($i=1; $i<count($requestParts); $i++)
	{
		$getvar[] = $requestParts[$i];
	}
}
else
{
	// get variables for loader
	for ($i=1; $i<count($requestParts); $i++)
	{
		$getvar[$requestParts[$i]] = $requestParts[$i+1];
		$i++;
	}
}
// get first variables 
while ( list($varName, $varValue) = @each($getvar) )
	{
	$getvarFirst =  $varName;
	break;
	}
	$getvarLast = $getvar[count($getvar)-1];
?>