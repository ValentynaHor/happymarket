<?php
$input = $_POST;

if($pageAlias == 'viewCategories' OR $pageAlias == 'viewResources' OR $pageAlias == 'cart')
{
	$inputSubCat['tableName'] = 'category';
	$inputSubCat['filter'] = " AND parentCategoryID != 'top'";
	//$inputSubCat['sort'] = " ORDER BY BINARY(LOWER(LEFT(categoryName, 10))) ";
	$inputSubCat['sort'] = "ORDER BY categoryPosition asc";
	$outputSubTemp = getData($inputSubCat);
	$inputSubCat = '';

	for ($cat=0; $cat < $outputCat['rows']; $cat++)
	{
		$catID_Alias[$outputCat[$cat]['categoryID']] = $outputCat[$cat]['categoryAlias'];
		for ($sub=0; $sub < $outputSubTemp['rows']; $sub++)
		{
			$subCatAlias_ID[$outputSubTemp[$sub]['categoryAlias']] = $outputSubTemp[$sub]['categoryID'];
			if($outputSubTemp[$sub]['parentCategoryID'] == $outputCat[$cat]['categoryID']) $outputSub[$outputCat[$cat]['categoryID']][] = $outputSubTemp[$sub];
		}
		$outputSub[$outputCat[$cat]['categoryID']]['rows'] = count($outputSub[$outputCat[$cat]['categoryID']]);
	}

	if(!empty($getvar['sub']))
	{
		$inputSubCat['tableName'] = 'category';
		$inputSubCat['filter_parentCategoryID'] = $CUR_CAT_ARRAY['categoryID'];
		$inputSubCat['filter_categoryAlias'] = $getvar['sub'];
		$inputSubCat['filter'] = getFilter($inputSubCat);
		$CUR_SUB_ARRAY = getData($inputSubCat);
		$CUR_SUB_ARRAY = $CUR_SUB_ARRAY[0];
		$inputSubCat = '';
	}

	$expF = str_replace('.html', '', $sid);
	$expF = explode('/',$expF);
	if($url == 'brands') $getvar['brand'] = $expF[2];
	if(!empty($getvar['brand']))
	{
		$inputBrand['tableName'] = 'brand';
		$inputBrand['filter_brandAlias'] = $getvar['brand'];
		$inputBrand['filter'] = getFilter($inputBrand);
		$CUR_BRAND_ARRAY = getData($inputBrand);
		$CUR_BRAND_ARRAY = $CUR_BRAND_ARRAY[0];
		$inputBrand = '';

		if($url != 'brands' AND !empty($CUR_BRAND_ARRAY['brandID']) AND strpos($CUR_CAT_ARRAY['categoryBrand'], '|'.$CUR_BRAND_ARRAY['brandID'].'|') === false OR strlen($getvar['brand']) > 1 AND $getvar['brand'] != 'ru' AND !is_array($CUR_BRAND_ARRAY))
		{
			header("HTTP/1.1 404 Not Found"); include_once('content/404.html'); exit();
		}
	}
	$titleBrand = explode('.',$CUR_BRAND_ARRAY['brandDescription']);
	$titleBrand = str_replace($CUR_BRAND_ARRAY['brandName'], '', $titleBrand[0]);
	$titleBrand = str_replace(' - ', ' ', $titleBrand); $titleBrand = str_replace(' – ', ' ', $titleBrand);$titleBrand = str_replace(' — ', ' ', $titleBrand);$titleBrand = str_replace('  ', ' ', $titleBrand);

	if(!empty($CUR_BRAND_ARRAY['brandName']))
	{
		$pageTitle = $CUR_BRAND_ARRAY['brandName'];
		if(!empty($titleBrand)) $pageTitle .= ' - '.$titleBrand;
	}

	$filerBrand = ''; $OR = ''; $FLAG = false;
	if(!empty($getvar['sub'])) $explodeBrand = explode('|',$CUR_SUB_ARRAY['categoryBrand']); else if(!empty($getvar['category'])) $explodeBrand = explode('|',$CUR_CAT_ARRAY['categoryBrand']);
	for($i=1; $i < count($explodeBrand)-1; $i++)
	{
		$filerBrand .= $OR."`brandID` = ".$explodeBrand[$i];
		$OR = " OR ";
		$FLAG = true;
	}

	if($url == 'brands')
	{
		if(empty($CUR_BRAND_ARRAY['brandID']))
		{
			$getvar['letter'] = $getvar['brand'];
			if(empty($getvar['letter'])) $getvar['letter'] = 'a';

			$input['tableName'] = 'brand';
			if($getvar['letter'] == 'ru')
			{
				$input['filter'] = " AND (brandName regexp '^[а-яА-Я].*')";
			}
			else
			{
				$input['filter'] = " AND (brandName regexp '^".$getvar['letter'].".*')";
			}
			$input['sort'] = 'ORDER BY BINARY(LOWER(LEFT(brandName, 10)))';
			$outputBrand = getData($input);
			$input = '';
		}
	}
	else
	{
		$input['tableName'] = 'brand';
		if($FLAG) $input['filter'] = " AND (".$filerBrand.")"; else $input['filter'] = ' AND 2=1';
		$input['sort'] = " ORDER BY BINARY(LOWER(LEFT(brandName, 10))) ";
		$outputBrand = getData($input);
		$input = '';
	}

	if($url == 'brands' OR $url == 'shop')
	{
		// GET ACTIVE LETTERS
		$input['tableName'] = 'brand';
		$input['select'] = 'brandName';
		$input['sort'] = 'ORDER BY BINARY(LOWER(LEFT(brandName, 10)))';
		$outputBrandLetter = getData($input);
		$input = '';

		$COD = 'WINDOWS-1251';
		$ACTIVE_LETTERS = '|';
		for ($i=0; $i<$outputBrandLetter['rows']; $i++)
		{
			$ACTIVE_LETTERS = iconv('UTF-8', $COD, $ACTIVE_LETTERS);
			$outputBrandLetter[$i]['brandName'] = iconv('UTF-8', $COD, $outputBrandLetter[$i]['brandName']);

			if(strpos($ACTIVE_LETTERS,'|'.$outputBrandLetter[$i]['brandName']{0}.'|') === false) $ACTIVE_LETTERS .= $outputBrandLetter[$i]['brandName']{0}.'|';

			$ACTIVE_LETTERS = iconv($COD, 'UTF-8', $ACTIVE_LETTERS);
			$outputBrandLetter[$i]['brandName'] = iconv($COD, 'UTF-8', $outputBrandLetter[$i]['brandName']);

		}
	}

}
elseif($pageAlias == 'viewResource')
{
	$inputSubCat['tableName'] = 'category';
	$inputSubCat['filter'] = " AND parentCategoryID != 'top'";
	//$inputSubCat['sort'] = " ORDER BY BINARY(LOWER(LEFT(categoryName, 10))) ";
	$inputSubCat['sort'] = "ORDER BY categoryPosition asc";
	$outputSubTemp = getData($inputSubCat);
	$inputSubCat = '';

	for ($cat=0; $cat < $outputCat['rows']; $cat++)
	{
		for ($sub=0; $sub < $outputSubTemp['rows']; $sub++)
		{
			if($outputSubTemp[$sub]['parentCategoryID'] == $outputCat[$cat]['categoryID']) $outputSub[$outputCat[$cat]['categoryID']][] = $outputSubTemp[$sub];
		}
		$outputSub[$outputCat[$cat]['categoryID']]['rows'] = count($outputSub[$outputCat[$cat]['categoryID']]);
	}

	$redirect_FLAG = 0;
	if(!empty($getvar['resource']))
	{
		$inputRes['tableName'] = 'resource';
		$inputRes['filter_resourceID'] = $getvar['resource'];
		$inputRes['filter'] = getFilter($inputRes);
		$outputResource = getData($inputRes);
		$outputResource = $outputResource[0];
		$inputRes = "";

		if(!empty($outputResource['categoryID']) AND !empty($outputResource['subCategoryID']))
		{
			$inputSub['tableName'] = 'category';
			$inputSub['filter'] = ' AND (categoryID = \''.$outputResource['categoryID'].'\' OR categoryID = \''.$outputResource['subCategoryID'].'\')';
			$outputURLSub = getData($inputSub);
			$inputSub = '';

			for($i=0; $i < $outputURLSub['rows']; $i++)
			{
				if($outputURLSub[$i]['categoryID'] == $outputResource['categoryID']) { $CUR_CAT_ARRAY = $outputURLSub[$i]; $getvar['category'] = $outputURLSub[$i]['categoryAlias']; }
				elseif($outputURLSub[$i]['categoryID'] == $outputResource['subCategoryID']) { $CUR_SUB_ARRAY = $outputURLSub[$i]; $getvar['sub'] = $outputURLSub[$i]['categoryAlias']; }
			}
		}


		if(!empty($outputResource['resourceBrand']))
		{
			$inputBrand['tableName'] = 'brand';
			$inputBrand['filter'] = ' AND brandID = \''.$outputResource['resourceBrand'].'\'';
			$outputURLBrand = getData($inputBrand);
			$inputBrand = '';

			if($outputURLBrand['rows'] > 0) $CUR_BRAND_ARRAY = $outputURLBrand[0];
		}

		$getvar['brand'] = substr($expF[2],strlen($outputResource['resourceAlias'])+1);
		$getvar['brand'] = substr($getvar['brand'],0,-(strlen($outputResource['resourceID'])+1));

		if(empty($outputResource['resourceID']))
		{
			header("HTTP/1.1 404 Not Found"); include_once('content/404.html'); exit();
		}
		elseif((!empty($outputResource['resourceAlias']) AND !strstr($sid, $outputResource['resourceAlias'].'-')) OR (!empty($outputResource['resourceBrand']) AND (empty($getvar['brand']) OR $getvar['brand'] != $CUR_BRAND_ARRAY['brandAlias'])) OR (!empty($outputResource['subCategoryID']) AND (empty($getvar['sub']) OR $full_Cat_Sub != $CUR_SUB_ARRAY['categoryAlias'])))
		{
			$redirect_FLAG = 1;
			if(!empty($CUR_BRAND_ARRAY['brandAlias'])) $linkBrand = $CUR_BRAND_ARRAY['brandAlias'].'-'; else $linkBrand = '';
			$changedSid = '/'.$CUR_SUB_ARRAY['categoryAlias'].'/'.$outputResource['resourceAlias'].'-'.$linkBrand.$outputResource['resourceID'];
		}
	}

	if($redirect_FLAG == 1)
	{
		header("HTTP/1.1 301 Moved Permanently"); header("Location: ".urlse.$changedSid.""); exit();
	}

	$naviStr = '';
	//echo '<a href="'.$DEP_ARRAY[$CUR_CAT_ARRAY['categoryDepartment']]['departmentAlias'].'/" class="black">Каталог товаров:</a>';
	$naviStr .= '<a href="'.$CUR_CAT_ARRAY['categoryAlias'].'/" class="black">'.$CUR_CAT_ARRAY['categoryName'].'</a>:';
	$naviStr .=' &nbsp;<a href="'.$CUR_SUB_ARRAY['categoryAlias'].'/" class="black">'.$CUR_SUB_ARRAY['categoryName'].'</a>:';
	if(!empty($CUR_BRAND_ARRAY['brandName']))
	$naviStr .= ' &nbsp;<a href="'.$CUR_SUB_ARRAY['categoryAlias'].'/'.$CUR_BRAND_ARRAY['brandAlias'].'" class="black">'.$CUR_BRAND_ARRAY['brandName'].'</a>:';

}


if ($pageAlias == 'viewCategories')
{
	if($CUR_DEP_ARRAY['parentDepartmentID'] == 'top')
	{
		for($i=0; $i < $outputDep['rows']; $i++)
		{
			if($outputDep[$i]['parentDepartmentID'] == $CUR_DEP_ARRAY['departmentID'])
			{
				$SUB_CUR_DEP_ARRAY[$outputDep[$i]['departmentID']] = $outputDep[$i];
			}
		}
	}

	$inputCat = '';
	$inputCat['tableName'] = "category";
	$inputCat['filter'] = " AND `parentCategoryID` = 'top'";
	if(!empty($CUR_DEP_ARRAY['departmentID'])) $inputCat['filter'] .= " AND `categoryDepartment` = '".$CUR_DEP_ARRAY['departmentID']."'";
	if(!empty($CUR_CAT_ARRAY['categoryID'])) $inputCat['filter'] .= " AND `categoryID` = '".$CUR_CAT_ARRAY['categoryID']."'";
	if(!empty($CUR_BRAND_ARRAY['brandID'])) $inputCat['filter'] .= " AND `categoryBrand` LIKE '%|".$CUR_BRAND_ARRAY['brandID']."|%'";
	//$inputCat['sort'] = " ORDER BY BINARY(LOWER(LEFT(categoryName, 10))) ";
	$inputCat['sort'] = "ORDER BY categoryPosition asc";
	$outputCategory = getData($inputCat);
	$inputCat = '';

	$inputSub = '';
	$inputSub['tableName'] = "category";
	$inputSub['filter'] = " AND `parentCategoryID` != 'top'";
	if(!empty($CUR_CAT_ARRAY['categoryID'])) $inputSub['filter'] .= " AND `parentCategoryID` = '".$CUR_CAT_ARRAY['categoryID']."'";
	if(!empty($CUR_BRAND_ARRAY['brandID'])) $inputSub['filter'] .= " AND `categoryBrand` LIKE '%|".$CUR_BRAND_ARRAY['brandID']."|%'";
	//$inputSub['sort'] = " ORDER BY BINARY(LOWER(LEFT(categoryName, 10))) ";
	$inputSub['sort'] = "ORDER BY categoryPosition asc";
	$outputTableCategory = getData($inputSub);
	$inputSub = '';

	// GET SUBCATEGORY
	for ($cat=0; $cat < $outputCategory['rows']; $cat++)
	{
		for ($i=0; $i < $outputTableCategory['rows']; $i++)
		{
			if($outputTableCategory[$i]['parentCategoryID'] == $outputCategory[$cat]['categoryID'])
			{
				$outputSubCategory[$outputCategory[$cat]['categoryID']][] = $outputTableCategory[$i];
			}
		}
		$outputSubCategory[$outputCategory[$cat]['categoryID']]['rows'] = count($outputSubCategory[$outputCategory[$cat]['categoryID']]);
	}
	if(!is_array($SUB_CUR_DEP_ARRAY)){
		$catFilter=''; $OR='';
		for($i=0; $i<$outputCategory['rows']; $i++){
			$catFilter .= $OR."categoryID = '".$outputCategory[$i]['categoryID']."'";
			$OR = ' OR ';
		}
		$inputResSel['tableName'] = 'resource';
		$inputResSel['filter'] = "AND (".$catFilter.") AND resourceSelected = '1' AND resourceImage != ''";
		$inputResSel['select'] = 'resourceID, resourceAlias, resourceName, resourceImage, categoryID, subCategoryID';
		$outputSelected = getData($inputResSel);
		$inputResSel = '';
	}
}

if ($pageAlias == 'viewResources')
{
	$inputFilter = $_POST;

	//**************************FILTER BEGIN***************************
		if(!isset($inputFilter['viewMode'])) $inputFilter['viewMode'] = '';

		if(empty($inputFilter['viewMode']) AND (!empty($_SESSION['SESSION_RESOURCE'][$getvar['category']][$getvar['sub']]['list']) OR !empty($_SESSION['SESSION_RESOURCE'][$getvar['category']][$getvar['sub']][$getvar['brand']]['sel']) OR !empty($_SESSION['SESSION_RESOURCE'][$getvar['category']][$getvar['sub']][$getvar['brand']]['presence']) OR !empty($_SESSION['SESSION_RESOURCE'][$getvar['category']][$getvar['sub']][$getvar['brand']]['minprice']) OR !empty($_SESSION['SESSION_RESOURCE'][$getvar['category']][$getvar['sub']][$getvar['brand']]['maxprice'])))
		{
			$inputFilter['presence'] = $_SESSION['SESSION_RESOURCE'][$getvar['category']][$getvar['sub']][$getvar['brand']]['presence'];

			$inputFilter['sort'] = $_SESSION['SESSION_RESOURCE'][$getvar['category']][$getvar['sub']][$getvar['brand']]['sort'];
		}

		if(!empty($inputFilter['presence']) AND $inputFilter['presence'] != 'all')
		{
			$input['filter_presence'] = $inputFilter['presence'];
			$FLAG_USE_FILTER = true;
		}

		$_SESSION['SESSION_RESOURCE'][$getvar['category']][$getvar['sub']][$getvar['brand']]['presence'] = $inputFilter['presence'];

		$_SESSION['SESSION_RESOURCE'][$getvar['category']][$getvar['sub']][$getvar['brand']]['sort'] = $inputFilter['sort'];

	//**************************FILTER END***************************

	$FILTER_HOLDER = '';
	$input['tableName'] = "resource";
	$input['filter_categoryID'] = $CUR_CAT_ARRAY['categoryID'];
	$input['filter_subCategoryID'] = $CUR_SUB_ARRAY['categoryID'];
	if(!empty($CUR_BRAND_ARRAY['brandID'])) $input['filter_resourceBrand'] = $CUR_BRAND_ARRAY['brandID'];
	$input['filter'] = getFilter($input);
	$FILTER_HOLDER = $input['filter'];

	$input['select'] = "count(permAll)";
	$outputCount = getData($input);
	$input = '';

			$numPage = $getvar['page'];
			if($numPage == 'all') {$numPage = 1; $viewModePage = 'all';}
			if(empty($numPage)) {$numPage = 1;}
			$countEntity = 12;
			//$countEntity = 2;
			$limit = $countEntity;
			if($viewModePage == 'all'){$limit = $outputCount[0]['count(permAll)'];}

			$countPages = ceil($outputCount[0]['count(permAll)']/$countEntity);
			if($numPage == 1)
				{ $startPos = 0; } else { $startPos = $numPage*$countEntity - $countEntity; }
			if($startPos + $countEntity > $outputCount[0]['count(permAll)'])
				{ $maxPos = $outputCount[0]['count(permAll)']; } else { $maxPos = $startPos + $countEntity; }

	$input['tableName'] = "resource";
	$input['select'] = 'resourceID, resourceAlias, categoryID, subCategoryID, resourceBrand, resourceName, resourceArtikul, resourceDescription, resourceImage, enterPrice, presence, resourceOffer, resourcePrice, wholesalePrice, note';
	$input['filter'] = $FILTER_HOLDER;
	$input['sort'] = "ORDER BY presence ASC, ";
	if(!empty($_SESSION['SESSION_RESOURCE'][$getvar['category']][$getvar['sub']][$getvar['brand']]['sort']))
	{
		$input['sort'] .= "resource".ucfirst($_SESSION['SESSION_RESOURCE'][$getvar['category']][$getvar['sub']][$getvar['brand']]['sort'])." asc";
	}
	else
	{
		$input['sort'] .= " resourcePosition ASC ";
	}
	$input['limit'] = " limit ".$startPos.", ".$limit;
	$outputResource = getData($input);
	$input = "";

	for ($i=0; $i<$outputBrand['rows']; $i++)
	{
		$BRAND_ARRAY[$outputBrand[$i]['brandID']] = $outputBrand[$i];
	}

	$naviStr = '';
	//echo '<a href="shop" class="black">Каталог товаров:</a>';
	if(!empty($CUR_BRAND_ARRAY['brandID'])) $naviStr .= ' <a href="'.$CUR_CAT_ARRAY['categoryAlias'].'/'.$CUR_BRAND_ARRAY['brandAlias'].'" class="black">'.$CUR_CAT_ARRAY['categoryName'].'</a>:';
	else $naviStr .= ' <a href="'.$CUR_CAT_ARRAY['categoryAlias'].'/" class="black">'.$CUR_CAT_ARRAY['categoryName'].'</a>:';
	$naviStr .= ' &nbsp;<h1>'.$CUR_SUB_ARRAY['categoryName'].'</h1>';
	if(!empty($CUR_BRAND_ARRAY['brandID'])) $naviStr .= ' <span class="black">'.$CUR_BRAND_ARRAY['brandName'].'</span>';
}

if(!empty($CUR_CAT_ARRAY['categoryID']) OR !empty($CUR_BRAND_ARRAY['brandID']))
{
	$pageTitle = '';
	if(!empty($getvar['resource']))
	{
		$resourceTitle = $outputResource['resourceName'];

		if(!empty($CUR_BRAND_ARRAY['brandName']) OR !empty($outputResource['resourceArtikul']))
		{
			$resourceAlias = gen_alias2($outputResource['resourceName'], 0, 0, '', 1);

			if(!empty($outputResource['resourceArtikul']))
			{
				$artikulAlias = gen_alias2($outputResource['resourceArtikul'], 0, 0, '', 1);
				if(strpos($resourceAlias, $artikulAlias) === false) { $resourceTitle .= ' '.$outputResource['resourceArtikul']; }
			}

			if(!empty($CUR_BRAND_ARRAY['brandName']))
			{
				$brandAlias = gen_alias2($CUR_BRAND_ARRAY['brandName'], 0, 0, '', 1);
				if(strpos($resourceAlias, $brandAlias) === false) { $resourceTitle .= ' '.$CUR_BRAND_ARRAY['brandName']; }
			}

		}

		$pageTitle = strip_tags($resourceTitle).', купить, описание цена';

		$pageDescription = strip_tags(str_replace('
', ' ', $outputResource['resourceDescription']));
		if(!empty($outputResource['resourcePrice']) AND $outputResource['resourcePrice'] != '0.00') $pageDescription .= ', '.$outputResource['resourcePrice'].' грн';
		else $pageDescription .= ', цену уточняйте';
		$pageDescription .= ', '.strip_tags(getValueDropDown('ddPresenceClient', $outputResource['presence']));

		$pageKeywords = $outputResource['resourceName'].'';
		if(!empty($outputResource['resourcePrice']) AND $outputResource['resourcePrice'] != '0.00') $pageKeywords .= ', '.$outputResource['resourcePrice'].' грн';
		else $pageKeywords .= ', цену уточняйте';
		$pageKeywords .= ', купить, продажа';
		if(!empty($CUR_BRAND_ARRAY['brandName']))
		{
			$brandAlias = gen_alias2($CUR_BRAND_ARRAY['brandName'], 0, 0, '', 1);
			if(strpos($resourceAlias, $brandAlias) === false) { $pageKeywords .= ', '.$CUR_BRAND_ARRAY['brandName']; }
		}
		$pageKeywords .= ', '.$CUR_SUB_ARRAY['categoryName'];
		//$pageTitle = $resourceTitle.' купить - '.$CUR_SUB_ARRAY['categoryName'];
	}
	elseif(!empty($getvar['sub']) AND !empty($getvar['brand']))
	{
		$pageTitle = $CUR_SUB_ARRAY['categoryName'].' '.$CUR_BRAND_ARRAY['brandName'];
	}
	elseif(!empty($getvar['sub']))
	{
		$pageTitle = $CUR_SUB_ARRAY['categoryName'];
	}

	if(!empty($CUR_BRAND_ARRAY['brandID']) AND empty($getvar['resource']) AND empty($getvar['sub']) AND empty($getvar['category']))
	{
		$pageTitle = $CUR_BRAND_ARRAY['brandName'];
		/*
		$pageTitle = $CUR_BRAND_ARRAY['brandName'].' - Интернет-магазин ';
		$count = 0; $sep = '';
		for($i=0; $i<$outputCategory['rows']; $i++)
		{
			if($count < 5) { $pageTitle .= $sep.$outputCategory[$i]['categoryName2']; $sep = ', '; $count++; } else break;
		}
		if(empty($count)) $pageTitle .= 'HAPPYMARKET';
		*/
	}
	elseif(empty($getvar['resource']) AND empty($getvar['sub']) AND !empty($getvar['category']))
	{
		$pageTitle = $CUR_CAT_ARRAY['categoryName'];
		if(!empty($getvar['brand'])) $pageTitle .= ' '.$CUR_BRAND_ARRAY['brandName'];

		$pageKeywords = ''; $pageDescription = ''; $SEP = ''; $LIM5 = 0;
		for($sub=0; $sub < $outputSub[$CUR_CAT_ARRAY['categoryID']]['rows']; $sub++)
		{
			if($LIM5 < 5) $pageDescription .= $SEP.$outputSub[$CUR_CAT_ARRAY['categoryID']][$sub]['categoryName'];
			$pageKeywords .= $SEP.$outputSub[$CUR_CAT_ARRAY['categoryID']][$sub]['categoryName'];
			$SEP = ', ';
			$LIM5++;
		}

		if(!empty($pageDescription)) $pageDescription .= ' — купить, продажа в Украине';
	}
	elseif(empty($getvar['resource']) AND !empty($getvar['sub']))
	{
		if(!empty($CUR_BRAND_ARRAY['brandName'])) $titleBrand = ' '.$CUR_BRAND_ARRAY['brandName'];
		$pageTitle = $CUR_SUB_ARRAY['categoryName'].$titleBrand.' купить, продажа в Украине';
		$pageKeywords = '';

		if(empty($CUR_BRAND_ARRAY['brandName']))
		{
			$LIM3 = 0;
			for ($i=0; $i<$outputBrand['rows']; $i++)
			{
				if(!empty($outputBrand[$i]['brandName']))
				{
					if($LIM3 < 3) $pageTitle .= ', '.$outputBrand[$i]['brandName'];
					$pageKeywords .= ', '.$outputBrand[$i]['brandName'];
					$LIM3++;
				}
			}
		}


		$pageDescription = $CUR_SUB_ARRAY['categoryName'].$titleBrand.', лучшие цены, описание, доставка по Украине. Звоните сейчас';
		$SEP = ' ';
		for($i=1; $i<=3; $i++)
		{
			if(!empty($outputSetting[0]['phone'.$i])) { $pageDescription .= $SEP.$outputSetting[0]['phone'.$i]; $SEP = ', ';}
		}

		$pageKeywords = $CUR_SUB_ARRAY['categoryName'].$titleBrand.', купить, продажа, купить в интернет магазине, цена, описание, дешево, доставка, украина'.$pageKeywords;

		//if(!empty($getvar['brand'])) $pageTitle .= ' '.$CUR_BRAND_ARRAY['brandName'];
		//$pageTitle .= ' - '.$CUR_DEP_ARRAY[$CUR_SUB_ARRAY['categoryDepartment']]['departmentName'].' "'.$CUR_DEP_ARRAY[$CUR_SUB_ARRAY['categoryDepartment']]['departmentHeadTitle'].'"';
	}

}
elseif($url == 'brands')
{
	$pageTitle = 'Бренды';
}
elseif(!empty($CUR_DEP_ARRAY['departmentName']))
{
	$pageTitle = $CUR_DEP_ARRAY['departmentName'].', продажа, купить в Украине';

	//print_r($CUR_DEP_ARRAY['departmentID']);print_R('<br>***<br>***<br>');

	$pageDescription = ''; $pageKeywords = '';

	$SUB_DEP = ''; $SEP = '';
	if($CUR_DEP_ARRAY['parentDepartmentID'] == 'top')
	{
		for($j=0; $j < $outputDep['rows']; $j++)
		{
			if($outputDep[$j]['parentDepartmentID'] == $CUR_DEP_ARRAY['departmentID'])
			{
				$pageDescription .= $SEP.$outputDep[$j]['departmentName'];
				$pageKeywords .= $SEP.$outputDep[$j]['departmentName'];
				$SUB_DEP .= $outputDep[$j]['departmentID'].'|';
				$SEP = ', ';
			}
		}
	}

	if(empty($SUB_DEP))
	{
		$SEP = ''; $LIM5 = 0;
		for($cat=0; $cat < $outputCat['rows']; $cat++)
		{
			//print_r($outputCat[$cat]['categoryDepartment']);print_R('<br>***<br>');
			if(!empty($outputCat[$cat]['categoryName']) AND $outputCat[$cat]['categoryDepartment'] == $CUR_DEP_ARRAY['departmentID'])
			{
				if($LIM5 < 5) $pageDescription .= $SEP.$outputCat[$cat]['categoryName'];
				$pageKeywords .= $SEP.$outputCat[$cat]['categoryName'];
				$SEP = ', ';
				$LIM5++;
			}
		}
	}

	if(!empty($pageDescription)) $pageDescription .= ' — и многое другое по доступным ценам, широкий ассортимент.';
	//$pageTitle .= ' - '.$CUR_DEP_ARRAY['departmentName'].' "'.$CUR_DEP_ARRAY['departmentHeadTitle'].'"';
}

if($pageAlias == 'viewPricelist')
{
	//$inputDep['tableName'] = 'department';
	//$inputDep['select'] = 'departmentID, departmentAlias, parentDepartmentID, departmentName';
	//$outputDep = getData($inputDep);

	$alias = explode('/',$sid);
	$alias = $alias[2];
	if(empty($alias)) $alias = $outputDep[0]['departmentAlias'];

	$inputSubCat['tableName'] = 'category';
	$inputSubCat['select'] = 'categoryID, categoryAlias, categoryName, parentCategoryID';
	$inputSubCat['filter'] = 'AND parentCategoryID != \'top\'';
	$inputSubCat['sort'] = "ORDER BY categoryPosition asc";
	$outputSubCat = getData($inputSubCat);
	$inputSubCat = '';

	for($i=0; $i<$outputDep['rows']; $i++)
	{
		$department[$outputDep[$i]['departmentID']] = $outputDep[$i]['departmentAlias'];
	}

	for($i=0; $i<$outputCat['rows']; $i++)
	{
		if($outputCat[$i]['categoryAlias'] == $alias)
		{
			$curNameTitle = ' '.$outputCat[$i]['categoryName'];

			$SEP = ''; $pageDescription = '';
			for($s=0; $s < $outputSubCat['rows']; $s++)
			{
				if($outputSubCat[$s]['parentCategoryID'] == $outputCat[$i]['categoryID']) { $pageDescription .= $SEP.$outputSubCat[$s]['categoryName']; $SEP = ', '; }
			}
		}

		$catsAlias[$outputCat[$i]['categoryID']] = $outputCat[$i]['categoryAlias'];
		$cat[$department[$outputCat[$i]['categoryDepartment']]][] = $outputCat[$i];
		$catAlias_depAlias[$outputCat[$i]['categoryAlias']] = $department[$outputCat[$i]['categoryDepartment']];
	}

	for($i=0; $i<$outputDep['rows']; $i++)
	{
		if($outputDep[$i]['departmentAlias'] == $alias)
		{
			$curNameTitle = ' '.$outputDep[$i]['departmentName'];

			$SEP = ''; $pageDescription = '';
			for($c=0; $c<$outputCat['rows']; $c++)
			{
				if($outputCat[$c]['categoryDepartment'] == $outputDep[$i]['departmentID']) { $pageDescription .= $SEP.$outputCat[$c]['categoryName']; $SEP = ', '; }
			}
		}
		$cat[$outputDep[$i]['departmentAlias']]['rows'] = count($cat[$outputDep[$i]['departmentAlias']]);
	}

	for($i=0; $i<$outputSubCat['rows']; $i++)
	{
		if($outputSubCat[$i]['categoryAlias'] == $alias)
		{
			$curNameTitle = ' '.$outputSubCat[$i]['categoryName'];
		}

		$subCat[$outputSubCat[$i]['categoryID']] = $outputSubCat[$i]['categoryAlias'];
		$sub[$catsAlias[$outputSubCat[$i]['parentCategoryID']]][] = $outputSubCat[$i];
		$subCatAlias_catAlias[$outputSubCat[$i]['categoryAlias']] = $catsAlias[$outputSubCat[$i]['parentCategoryID']];
	}

	for($i=0; $i<$outputCat['rows']; $i++)
	{
		$sub[$outputCat[$i]['categoryAlias']]['rows'] = count($sub[$outputCat[$i]['categoryAlias']]);
	}

	$inputResource['tableName'] = 'resource';
	$inputResource['select'] = 'resourceID, resourceAlias, categoryID, subCategoryID, resourceBrand, resourceName, resourcePrice, wholesalePrice';
	$outputResource = getData($inputResource);
	$inputResource = '';

	for($i=0; $i<$outputResource['rows']; $i++)
	{
		$resource[$subCat[$outputResource[$i]['subCategoryID']]][] = $outputResource[$i];
	}

	for($i=0; $i<$outputSubCat['rows']; $i++)
	{
		$resource[$outputSubCat[$i]['categoryAlias']]['rows'] = count($resource[$outputSubCat[$i]['categoryAlias']]);
	}

	if(isset($cat[$alias]))
	{
		$depAlias = $alias;
		$catAlias = '';
		$subCatAlias = '';
	}
	elseif(isset($sub[$alias]))
	{
		$depAlias = $catAlias_depAlias[$alias];
		$catAlias = $alias;
		$subCatAlias = '';
	}
	elseif(isset($resource[$alias]))
	{
		$catAlias = $subCatAlias_catAlias[$alias];
		$depAlias = $catAlias_depAlias[$catAlias];
		$subCatAlias = $alias;
	}

	$pageTitle = 'Прайс лист'.$curNameTitle;
}

if ($url == 'cart')
{
	$input = $_POST;
	$cart = $_SESSION['cart'];
	$countCart = $_SESSION['countCart'];
	$gamut = $_SESSION['gamut'];
	$incart_total = $_SESSION['incart_total'];
	//$incart_total_current = $_SESSION['incart_total_current'];

	if($input['viewMode'] == 'purchase')
	{
		$tmp = $input['addition'];
		if(!empty($tmp))
		{
			$gamut[$input['ware']] = '';
			foreach($tmp as $key => $val)
			{
				$gamut[$input['ware']][] = $key.'|&|'.$val;
			}
		}
	}

	if(!empty($input['waresCount']))
	{
		$countCart = $input['waresCount'];
		$_SESSION['countCart'] = $countCart;
	}

	$getvar['category'] = $input['category'];
	$getvar['sub'] = $input['sub'];
	$getvar['ware'] = $input['ware'];
	$getvar['table'] = 'resource';

	if ($getvar[0] == 'delete') {
		$getvar['delete'] = $getvar[1];
	}

	if ($getvar[0] == 'empty') {
		$getvar['empty'] = $getvar[1];
	}

	if (!empty($getvar['empty']))
	{
		$incart_total = 0;
		//$incart_total_current = 0;
		$incart_count = 0;

		$_SESSION['incart_total'] = $incart_total;
		//$_SESSION['incart_total_current'] = $incart_total_current;
		$_SESSION['incart_count'] = $incart_count;

		$cart = "";
		$countCart = "";
		$gamut = "";

		$_SESSION['cart'] = "";
		$_SESSION['countCart'] = "";
		$_SESSION['gamut'] = "";
	}

	$outputCart = array();
	if (!empty($getvar['ware']))
	{
		$cart_table = "cart_".$getvar['table'];
		if(!empty($gamut[$getvar['ware']]))
		{
			$tempGamut = ''; $SEP = '';
			for ($g=0; $g < count($gamut[$getvar['ware']]); $g++)
			{
				$tempGamut .= $SEP.$gamut[$getvar['ware']][$g]; $SEP = '**';
			}//for
			$cart[$cart_table]['id'][] = $getvar['ware'];
			$cart[$cart_table]['add'][] = $tempGamut;
		}
		else
		{
			$cart[$cart_table]['id'][] = $getvar['ware'];
			$cart[$cart_table]['add'][] = "";
		}
		$_SESSION['cart'] = $cart;
	}

	if (!empty($getvar['delete']) OR $getvar['delete'] == '0')
	{
		$cart_table = "cart_".$getvar['table'];

		if(!is_array($cart)) $cart = array();
		if (count($cart[$cart_table]['id'])<=1)
		{

			$incart_total = 0;
			//$incart_total_current = 0;
			$incart_count = 0;
			$_SESSION['incart_total'] = $incart_total;
			//$_SESSION['incart_total_current'] = $incart_total_current;
			$_SESSION['incart_count'] = $incart_count;

			$cart = "";
			$countCart = "";
			$gamut = "";
			$_SESSION['cart'] = "";
			$_SESSION['countCart'] = "";
			$_SESSION['gamut'] = "";

		}
		else
		{

			for ($g=0; $g < count($cart[$cart_table]['id']); $g++)
			{
				if ($g != $getvar['delete'])
				{
					$tempCart['id'][] = $cart[$cart_table]['id'][$g];
					$tempCart['add'][] = $cart[$cart_table]['add'][$g];
				}//if
			}//for
			$cart[$cart_table]['id'] = $tempCart['id'];
			$cart[$cart_table]['add'] = $tempCart['add'];
		}//else
		$_SESSION['cart'] = $cart;
	}

	if (!empty($cart))
	{
		$filterSubCat = ''; $filterBrand = ''; $OR = '';

		while ( list($cartName, $cartValue) = each($cart) )
		{
			if (strstr($cartName,"cart_"))
			{
				for($j=0; $j<count($cartValue['id']); $j++)
				{

					$explodeCart = explode ("_",$cartName);
					$input['filter_resourceID'] = $cartValue['id'][$j];
					$input['filter'] = getFilter($input);
					$input['tableName'] = 'resource';
					$input['select'] = 'resourceID, resourceAlias, categoryID, subCategoryID, resourceBrand, resourceName, resourceDescription, resourceImage, presence, enterPrice';
					$wholesale = empty($userArray['wholesale']) ? 0 : $userArray['wholesale'];
					$input['select'] .= ', IF('.$wholesale.' = 1, wholesalePrice, resourcePrice) as resourcePrice';
					$outputCart['temp'] = getData($input);
					$outputCart[$input['tableName']][$j] = $outputCart['temp'][0];

					$filterSubCat .= $OR."categoryID = '".$outputCart[$input['tableName']][$j]['subCategoryID']."'";
					$filterBrand .= $OR."brandID = '".$outputCart[$input['tableName']][$j]['resourceBrand']."'";
					$OR = ' OR ';

					$outputCart[$input['tableName']][$j]['index'] = $j;
					if(!empty($countCart[$outputCart[$input['tableName']][$j]['index']])) { $outputCart[$input['tableName']][$j]['resourceCount'] = $countCart[$j]; }
					else { $outputCart[$input['tableName']][$j]['resourceCount'] = 1; }

					if(!empty($cartValue['add'][$j])) $outputCart[$input['tableName']][$j]['resourcePos'] = $cartValue['add'][$j];
					$input='';
				}
			}
		}//while

		if(!empty($filterSubCat))
		{
			$input['tableName'] = "category";
			$input['filter'] = " AND (".$filterSubCat.") ";
			$arraySub = getData($input);
			$input = '';
			for($i=0; $i < $arraySub['rows']; $i++) $SUB_ID_TO_ALIAS[$arraySub[$i]['categoryID']] = $arraySub[$i]['categoryAlias'];
		}

		if(!empty($filterBrand))
		{
			$input['tableName'] = 'brand';
			$input['filter'] = " AND (".$filterBrand.") ";
			$arrayBrand = getData($input);
			$input = '';
			for($i=0; $i < $arrayBrand['rows']; $i++)
			{
				$BRAND_ARRAY[$arrayBrand[$i]['brandID']] = $arrayBrand[$i];
			}
		}

		//$incart_total_current = 0;
		$incart_total = 0;
		$incart_count = 0;
		for ($i=0; $i < count($outputCart['resource']); $i++)
		{
			if(empty($outputCart['resource'][$i]['resourceCount'])) $outputCart['resource'][$i]['resourceCount'] = 1;

			$incart_total += @round($outputCart['resource'][$i]['resourcePrice']*$outputCart['resource'][$i]['resourceCount'],2);
			$incart_count += $outputCart['resource'][$i]['resourceCount'];
		}

		//$_SESSION['incart_total_current'] = $incart_total_current;
		$_SESSION['incart_total'] = $incart_total;
		$_SESSION['incart_count'] = $incart_count;

		$_POST["name"] = trim($_POST["name"]);
		$_POST["email"] = trim($_POST["email"]);
		if (!empty($_POST["name"]))
		{

			$inputGetUserOrderCount['tableName'] = "order";
			$inputGetUserOrderCount['select'] = "orderGroupID";
			$inputGetUserOrderCount['sort_orderGroupID'] = "desc";
			$inputGetUserOrderCount['sort'] = sortData($inputGetUserOrderCount);
			$outputUserOrderCount = getData($inputGetUserOrderCount);
			$inputGetUserOrderCount = "";
			$orderGroupIDCount = $outputUserOrderCount[0]['orderGroupID']+1;

			$category = 'resource';
            $array_saved_IDs = array();
			for ($i=0; $i < count($outputCart[$category]); $i++)
			{
				$inputOrder['tableName'] = "order";
				$currentTime = getNewDate();
				$inputOrder['order_timeCreated'] = $currentTime;
				$inputOrder['order_orderDate'] = $currentTime;
				$inputOrder['order_orderHistory'] = '&0|Клиент|'.$currentTime.'&';
				$inputOrder['order_permAll'] = '1';
				$inputOrder['order_userID'] = $userID;
				$inputOrder['order_wareCategory'] = $outputCart[$category][$i]['categoryID'];
				$inputOrder['order_wareSubCategory'] = $outputCart[$category][$i]['subCategoryID'];
				//$inputOrder['order_wareBrand'] = $outputCart[$category][$i][$category.'Brand'];
				$inputOrder['order_wareID'] = $outputCart[$category][$i][$category.'ID'];
				$inputOrder['order_wareName'] = $outputCart[$category][$i][$category.'Name'];
					$inputOrder['order_wareName'] = str_replace('"','&quot;',$inputOrder['order_wareName']);
					$inputOrder['order_wareName'] = str_replace("'","`",$inputOrder['order_wareName']);
				$inputOrder['order_enterPrice'] = $outputCart['resource'][$i]['enterPrice'];
				$inputOrder['order_warePrice'] = $outputCart['resource'][$i]['resourcePrice'];
				$inputOrder['order_wareCount'] = $outputCart[$category][$i][$category.'Count'];
				$inputOrder['order_userFamily'] = $_POST['family'];
				$inputOrder['order_userName'] = $_POST['name'];
				$inputOrder['order_userPatronymic'] = $_POST['patronymic'];
				$inputOrder['order_userEmail'] = trim($_POST['email']);
				$inputOrder['order_userPhone'] = $_POST['phone'];
				$inputOrder['order_userAdress'] = $_POST['address'];
				$inputOrder['order_userAdress'] = str_replace("\\","&#092;",$inputOrder['order_userAdress']);
				$inputOrder['order_userSource'] = $_POST['source'];
				$inputOrder['order_userComment'] = $_POST['comment'];
				$inputOrder['order_delivery'] = $_POST['delivery'];
				$inputOrder['order_orderGroupID'] = $orderGroupIDCount;

				$inputCompare = '';
				foreach($inputOrder as $key => $val)
				{
					if($key != 'order_orderGroupID' AND $key != 'order_timeCreated' AND $key != 'order_orderDate' AND $key != 'order_orderHistory')
					{
						$NEWkey = str_replace('order_','filter_',$key);
						$inputCompare[$NEWkey] = $val;
					}
				}
				$inputCompare['filter'] = getFilter($inputCompare);
				$inputCompare['filter'] .= ' AND timeCreated >= \''.date("Y-m-d H:i:s",mktime(date("H"), date("i"), date("s"), date("m"), date("d")-1, date("Y"))).'\'';
                $inputCompare['select'] = 'orderID';
				$outputCompare = getData($inputCompare);
				$inputCompare = '';

                if ($outputCompare['rows'] != 0 AND in_array($outputCompare[0]['orderID'],$array_saved_IDs)) {
                    $outputCompare['rows'] = 0;
                }

				if($outputCompare['rows'] == 0)
				{
					saveData($inputOrder);
                    $array_saved_IDs[] = $globalInsertID;
					$inputOrder = "";
					$wareOrderIDs .= $separator.$globalInsertID;
					$separator = '-';
				}
			}
		}
	}//if

	$pageTitle = 'Корзина';
}

if(!empty($pageTitle)) $pageTitle .= ' — Интернет-Супермаркет HappyMarket.net.ua';

if ($_SERVER['REQUEST_URI'] == '/') {
	$pageTitle = 'Интернет-супермаркет HappyMarket.net.ua: детские товары, игрушки, чулочно-носочные изделия купить Украина';
	$pageDescription = 'On-line супермаркет полезных товаров. Мы сэкономим Ваши время и деньги. Доставка по все Украине. Покупайте по честным ценам.';
}

?>
