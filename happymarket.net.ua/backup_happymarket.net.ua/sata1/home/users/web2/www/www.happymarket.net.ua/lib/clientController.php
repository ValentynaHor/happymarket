<?php
$input = $_POST;

if($_POST['authentication'] == 'active')
{

	if(!empty($_POST['userNik']) OR !empty($_POST['userPassword']))
	{
		$inputLogin['tableName'] = 'user';
		$inputLogin['filter_userNik'] = $_POST['userNik'];
		$inputLogin['filter_userPassword'] = $_POST['userPassword'];
		$inputLogin['filter'] = getFilter($inputLogin);
		$outputLogin = getData($inputLogin);
		$inputLogin = '';
	}

	for ($i=0; $i<$outputLogin['rows']; $i++)
	{
		if($_POST['userNik'] == $outputLogin[$i]['userNik'] AND $_POST['userPassword'] == $outputLogin[$i]['userPassword'])
		{
			$loginStatus = "yes";
			$userArray = $outputLogin[$i];
			break;
		}
		else
		{
			$loginStatus = "no";
			$userArray = '';
		}
	}
	if($loginStatus == 'yes')
	{
		$_SESSION['loginStatus'] = $loginStatus;
		$_SESSION['userArray'] = $userArray;
		if($loaderName == 'forum' AND $url == 'login')
		{
			$pathFile = 'conference/homeForum.php';
			$url = 'forums';
		}
	}
	else
	{
		$pathFile = 'session/login.php';
		$nologin = 'Имя или пароль не верны.';
	}
}
elseif($getvar[2] == 'logout')
{
	$_SESSION['loginStatus'] = "no";
	$_SESSION['userArray'] = '';

	header("HTTP/1.1 301 Moved Permanently"); header("Location: ".$_SERVER['HTTP_REFERER'].""); exit();
	//header("Location: ".urlse);
}

$outputSetting = getData(array(
	'tableName' => 'setting'
));

$inputDep['tableName'] = 'department';
$inputDep['sort'] = 'ORDER BY departmentPosition asc';
$outputDep = getData($inputDep);
$inputDep = '';

for($i=0; $i < $outputDep['rows']; $i++)
{
	$DEP_ARRAY[$outputDep[$i]['departmentID']] = $outputDep[$i];
}

if ($url != 'home') {
	$inputPage['tableName'] = 'page';
	$inputPage['filter_pageURL'] = $url;
	$inputPage['filter'] = getFilter($inputPage);
	$inputPage['select'] = 'pageURL, pageAlias, pageModule, pageName, pageTitle, pageDescription, pageKeywords, pageText';
	$outputPage = getData($inputPage);
	$inputPage = "";
} else {
	$CUR_DEP_ARRAY = $DEP_ARRAY[2];
	$getvar['department'] = 'otdel-igrushek';
}

if(empty($outputPage[0]['pageAlias']))
{
	$redirect_FLAG = 0;
	$expF = str_replace('.html', '', $sid);
	$expF = explode('/',$expF);
	$part_Brand_Res_Page = explode('-',$expF[2]);

	$full_Cat_Sub = $expF[1];
	$part_Cat_Sub = explode('-',$expF[1]);
	unset($part_Cat_Sub[0]);
	$part_Cat_Sub = implode('-',$part_Cat_Sub);

	for($i=0; $i < $outputDep['rows']; $i++)
	{
		if($outputDep[$i]['departmentAlias'] == $full_Cat_Sub)
		{
			$getvar['department'] = $outputDep[$i]['departmentID']; $CUR_DEP_ARRAY = $outputDep[$i];
		}
	}

	if(empty($getvar['department']))
	{
		//chk if exp is subCat
		$inputCat['tableName'] = 'category';
		$inputCat['filter_categoryAlias'] = $full_Cat_Sub;
		$inputCat['filter'] = getFilter($inputCat);
		$outputURLSubCat = getData($inputCat);
		$inputCat = '';

		if(!empty($outputURLSubCat['rows']) AND $outputURLSubCat[0]['parentCategoryID'] != 'top')
		{
			//if is subCat - getting cat
			$getvar['sub'] = $full_Cat_Sub; 					//setting subCat when URL is not cat

			$inputCat['tableName'] = 'category';
			$inputCat['filter_categoryID'] = $outputURLSubCat[0]['parentCategoryID'];
			$inputCat['filter'] = getFilter($inputCat);
			$outputURLCat = getData($inputCat);
			$inputCat = '';

			if(!empty($outputURLCat['rows']))
			{
				$getvar['category'] = $outputURLCat[0]['categoryAlias'];	//setting cat when URL is not cat
				$CUR_CAT_ARRAY = $outputURLCat[0];
			}
		}
		elseif(!empty($outputURLSubCat['rows']) AND $outputURLSubCat[0]['parentCategoryID'] == 'top')
		{
			$getvar['category'] = $outputURLSubCat[0]['categoryAlias'];
			$CUR_CAT_ARRAY = $outputURLSubCat[0];
		}
		else
		{
			//string is not subcat alias
			$inputCat['tableName'] = 'category';
			$inputCat['filter_categoryAlias'] = $url;
			$inputCat['filter'] = getFilter($inputCat);
			$outputURLCat = getData($inputCat);
			$inputCat = '';

			if(!empty($outputURLCat['rows']))
			{
				$getvar['category'] = $outputURLCat[0]['categoryAlias'];	//setting cat when URL is cat
				$CUR_CAT_ARRAY = $outputURLCat[0];
			}

			if($CUR_CAT_ARRAY['categoryAlias'] != $full_Cat_Sub AND empty($part_Cat_Sub))
			{
				$FLAG_404ERROR = '1';
				//header("HTTP/1.1 404 Not Found"); include_once('content/404.html'); exit();
			}

			//if cached link --> redirect
			if(!empty($outputURLCat['rows']) AND !empty($part_Cat_Sub))
			{
				$redirect_FLAG = 1;
				$changedSid = str_replace($full_Cat_Sub,$part_Cat_Sub,$sid);
			}
		}

		if(!empty($getvar['category']))
		{
			$pbrpMAX = count($part_Brand_Res_Page)-1;
			$tmpRes = $part_Brand_Res_Page[$pbrpMAX];

			if($pbrpMAX > 0 AND is_numeric($tmpRes))
			{
				//than resource
				$getvar['resource'] = $part_Brand_Res_Page[$pbrpMAX];

			}
			else
			{
				$tmp = $part_Brand_Res_Page[0];
				if(is_numeric($tmp) OR $tmp == 'all')
				{
					$getvar['page'] = $part_Brand_Res_Page[0];
					unset($part_Brand_Res_Page[0]);
					$getvar['brand'] = implode('-', $part_Brand_Res_Page);
				}
				else $getvar['brand'] = implode('-', $part_Brand_Res_Page);
			}

			if($redirect_FLAG == 1)
			{
				header("HTTP/1.1 301 Moved Permanently"); header("Location: ".urlse.$changedSid.""); exit();
			}
		}
		if(!empty($CUR_CAT_ARRAY))
			$CUR_DEP_ARRAY = $DEP_ARRAY[$CUR_CAT_ARRAY['categoryDepartment']];
	}

	if(empty($_SESSION['current_dept']))
		$_SESSION['current_dept'] = 'tech';
	if(!empty($CUR_DEP_ARRAY['departmentID'])){
		if($CUR_DEP_ARRAY['departmentID'] == 1)			$_SESSION['current_dept'] = 'tech';
		else if($CUR_DEP_ARRAY['departmentID'] == 2)	$_SESSION['current_dept'] = 'kids';
		else if($CUR_DEP_ARRAY['departmentID'] == 3)	$_SESSION['current_dept'] = 'car';
		else if($CUR_DEP_ARRAY['departmentID'] == 4)	$_SESSION['current_dept'] = 'housetech';
		else if($CUR_DEP_ARRAY['departmentID'] == 5)	$_SESSION['current_dept'] = 'hifi';
        else if($CUR_DEP_ARRAY['departmentID'] == 6)    $_SESSION['current_dept'] = 'komfort';
	}

	if(!empty($getvar['department'])) $url = 'department';
	elseif(!empty($getvar['resource'])) $url = 'resource';
	elseif(!empty($getvar['sub'])) $url = 'resources';
	elseif(empty($getvar['sub']) AND empty($getvar['resource']) AND !empty($getvar['category'])) $url = 'categories';

	//categories for menu
	if(!empty($CUR_DEP_ARRAY))
	{
		$inputCat = '';
		$inputCat['tableName'] = "category";
		$inputCat['filter'] = " AND `parentCategoryID` = 'top'";
		if(!empty($CUR_DEP_ARRAY['departmentID'])) $inputCat['filter'] .= " AND `categoryDepartment` = '".$CUR_DEP_ARRAY['departmentID']."'";
		//$inputCat['sort'] = " ORDER BY BINARY(LOWER(LEFT(categoryName, 10))) ";
		$inputCat['sort'] = 'ORDER BY categoryPosition asc';
		$outputCategoryMenu = getData($inputCat);
		$inputCat = '';

		$inputSub = '';
		$inputSub['tableName'] = "category";
		$inputSub['filter'] = " AND `parentCategoryID` != 'top'";
		//$inputSub['sort'] = " ORDER BY BINARY(LOWER(LEFT(categoryName, 10))) ";
		$inputSub['sort'] = "ORDER BY categoryPosition asc";
		$outputTableCategoryMenu = getData($inputSub);
		$inputSub = '';

		// GET SUBCATEGORY
		for ($cat=0; $cat < $outputCategoryMenu['rows']; $cat++)
		{
			for ($i=0; $i < $outputTableCategoryMenu['rows']; $i++)
			{
				if($outputTableCategoryMenu[$i]['parentCategoryID'] == $outputCategoryMenu[$cat]['categoryID'])
				{
					$outputSubCategoryMenu[$outputCategoryMenu[$cat]['categoryID']][] = $outputTableCategoryMenu[$i];
				}
			}
			$outputSubCategoryMenu[$outputCategoryMenu[$cat]['categoryID']]['rows'] = count($outputSubCategoryMenu[$outputCategoryMenu[$cat]['categoryID']]);
		}
		for ($i=0; $i < $outputTableCategoryMenu['rows']; $i++){
			$SUB_ARRAY[$outputTableCategoryMenu[$i]['categoryID']] = $outputTableCategoryMenu[$i];
		}
		$CUR_CAT_INDEX = 'false';
		for($i=0; $i<$outputCategoryMenu['rows']; $i++)
		{
			$CAT_ARRAY[$outputCategoryMenu[$i]['categoryID']] = $outputCategoryMenu[$i];
			if($outputCategoryMenu[$i]['categoryID'] == $CUR_CAT_ARRAY['categoryID'] AND $outputCategoryMenu[$i]['parentCategoryID'] == 'top')
			{
				$CUR_CAT_INDEX = $i;
			}

		}
	}

	$inputPage['tableName'] = 'page';
	$inputPage['filter_pageURL'] = $url;
	$inputPage['filter'] = getFilter($inputPage);
	$inputPage['select'] = 'pageURL, pageAlias, pageModule, pageName, pageTitle, pageDescription, pageKeywords, pageText';
	$outputPage = getData($inputPage);
	$inputPage = "";
}

$inputCat = '';
$inputCat['tableName'] = "category";
$inputCat['filter'] = " AND `parentCategoryID` = 'top'";
$inputCat['filter'] .= " AND `categoryDepartment` = '2'";
$inputCat['sort'] = 'ORDER BY categoryPosition asc';
$outputCategoryMenu = getData($inputCat);
$inputCat = '';


	if(empty($outputPage[0]['pageAlias']))
	{
		$FLAG_404ERROR = '1';
	}

	$pageAlias = $outputPage[0]['pageAlias'];
	$pageName = $outputPage[0]['pageName'];
	$pageTitle = $outputPage[0]['pageTitle'];
	$pageDescription = $outputPage[0]['pageDescription'];
	$pageKeywords = $outputPage[0]['pageKeywords'];
	$pageModule = $outputPage[0]['pageModule'];
	if($pageModule == 'content')
		$pageTitle .= ' — Интернет-Супермаркет HappyMarket.net.ua';
	$pageText = $outputPage[0]['pageText'];
	$pageFile = $pageModule.'/'.$pageAlias.'.php';

//================================================
	if($pageModule == 'resource')
	{
		$inputCat['tableName'] = 'category';
		$inputCat['filter_parentCategoryID'] = 'top';
		$inputCat['filter'] = getFilter($inputCat);
		$inputCat['sort'] = ' ORDER BY BINARY(LOWER(LEFT(categoryName, 10))) ';
		$outputCat = getData($inputCat);
		$inputCat = '';
	}
//================================================

	if($FLAG_404ERROR == '1') { header("HTTP/1.1 404 Not Found"); include_once('content/404.html'); exit(); }

	// inсlude module
	if($pageModule == "content")
		$pageFile = 'content/content.php';
	else if(!empty($pageModule))
	{
		include_once('clientModules/'.$pageModule.'Module.php');
	}
?>
