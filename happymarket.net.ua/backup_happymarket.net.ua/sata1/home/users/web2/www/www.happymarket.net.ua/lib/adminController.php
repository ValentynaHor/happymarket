<?php 
$input = $_POST;

if($_POST['authentication'] == 'active')
{
	$input['tableName'] = 'user';
	$input['filter'] = 'AND userNik = \''.$_POST['userNik'].'\' AND userPassword = \''.$_POST['userPassword'].'\' AND groupID = \'admin\'';
	$outputLogin = getData($input);
	$input = '';

	if($outputLogin['rows'] > 0 AND !empty($_POST['userNik']) AND !empty($_POST['userPassword']))
	{
		$loginStatus = "yes";
		$userArray = $outputLogin[0];


		$requestParts = explode("?",$request);
		$requestParts = explode("/",$requestParts[1]);
		//set path to file
		$url = $requestParts[0];

		@ reset($admpage);
		while(list($key,$value) = each($admpage))
		{
			if($key==$url)
			{
				$pathFile = $value;
				$pageTitle = $admpageTitle[$key];
				break;
			}
		}

		if(empty($url))
		{
			$url = 'manageDepartments';
			$pathFile = $admpage['manageDepartments'];
			$pageTitle = $admpageTitle['manageDepartments'];
		}

		for ($i=1; $i<count($requestParts); $i++)
		{
			$getvar[$requestParts[$i]] = $requestParts[$i+1];
			$i++;
		}
	}
	else
	{
		$loginStatus = "no";
		$nologin = 'Имя или пароль не верны.';
	}


	$_SESSION['loginStatus'] = $loginStatus;
	$_SESSION['userArray'] = $userArray;
}

if($getvar['userstatus'] == 'logout')
{
	$_SESSION['loginStatus'] = "no";
	$_SESSION['userArray'] = '';

	header("Location: ".urlse."/adm/");
}

$inputSetting['tableName'] = 'setting';
$outputSetting = getData($inputSetting);
$inputSetting = '';

//repair
if ($url == 'repair')
{
	include_once('adminModules/repairModule.php');
}
//resource
if ($url == 'manageResources' OR $url == 'manageResource' OR $url == 'manageCategory' OR $url == 'manageSubCategories' OR $url == 'manageSubCategory' OR $url == 'manageCategories' OR $url == 'manageComments' OR $url == 'manageComment' OR $url == 'manageBrands' OR $url == 'manageBrand' OR $url == 'managePresence' OR $url == 'managePrice' OR $url == 'quickEditor' OR $url == 'manageSetting' OR $url == 'manageHits' OR $url == 'managePopulars' OR $url == 'manageNovelties' OR $url == 'manageDepartments' OR $url == 'manageDepartment')
{
	include_once('adminModules/resourceModule.php');
}
// pages
if ($url == 'managePages' OR $url == 'managePage' OR $url == 'manageContentPages' OR $url == 'manageContentPage') 
{
	include_once('adminModules/pageModule.php');
}
//news
if ($url == 'manageFact' OR $url == 'manageFacts' OR $url == 'viewFact')
{
	include_once('adminModules/factModule.php');
}
//image
if ($url == 'manageImage')
{
	include_once('adminModules/imageModule.php');
}
//session
if ($url == 'manageUsers' OR $url == 'viewUser' OR $url == 'manageUser') 
{
	include_once('adminModules/sessionModule.php');
}
//order
if ($url == 'manageOrder' OR $url == 'viewOrder' OR $url == 'manageOrders' OR $url == 'manageOrderPrint')
{	
	include_once('adminModules/orderModule.php');
}
//search
if ($url == 'manageSearch')
{
	include_once('adminModules/searchModule.php');
}
?>