<?

if($getvar[0] == 'advanced')
{
	header("HTTP/1.1 301 Moved Permanently"); header("Location: ".urlse."/search?m=adv"); exit();
}

$input['tableName'] = 'brand';
$input['select'] = 'brandID, brandAlias, brandName';
$searchBrand = getData($input);
$input = '';

$ddBrand[''] = '- выбрать -';
for($i=0; $i<$searchBrand['rows']; $i++)
{
	$BRAND_ARRAY[$searchBrand[$i]['brandID']] = $searchBrand[$i];
	$ddBrand[$searchBrand[$i]['brandID']] = $searchBrand[$i]['brandName'];
}

$input['tableName'] = 'category';
$input['filter'] = 'AND parentCategoryID = \'top\'';
$input['select'] = 'categoryID, categoryAlias, categoryName, categoryDepartment';
$searchCat = getData($input);
$input = '';

$ddCat[''] = '- выбрать -';
for($i=0; $i<$searchCat['rows']; $i++)
{
	$CAT_ARRAY[$searchCat[$i]['categoryID']] = $searchCat[$i];
	$ddCat[$searchCat[$i]['categoryID']] = $searchCat[$i]['categoryName'];
}

$SEP = '';
if(!empty($_GET['s'])) { $INCsearch = $SEP.'s='.$_GET['s']; $SEP = '&'; }
if(!empty($_GET['c'])) { $INCcat = $SEP.'c='.$_GET['c']; $SEP = '&'; }
if(!empty($_GET['b'])) { $INCbrand = $SEP.'b='.$_GET['b']; $SEP = '&'; }
if(!empty($_GET['m'])) { $INCmod = $SEP.'m='.$_GET['m']; $SEP = '&'; }

$input = $_GET;

if(!empty($input['s']) OR !empty($input['c']) OR !empty($input['b']))
{
	$searchFilter = '';

	$search = trim($input['s']);
	$search = eregi_replace("[  ]+"," ",$search);
	$searchArray = explode(' ',$search);
	for($i=0; $i < count($searchArray); $i++)
	{
		$searchFilter .=  " AND (resourceName like '%".$searchArray[$i]."%')";
	}

	if(!empty($input['c'])) $searchFilter .= 'AND categoryID = \''.$input['c'].'\' ';

	if(!empty($input['b'])) $searchFilter .= 'AND resourceBrand = \''.$input['b'].'\' ';

	$inputWare['tableName'] = 'resource';
	$inputWare['select'] = 'count(permAll)';
	$inputWare['filter'] = $searchFilter;
	$outputCount = getData($inputWare);
	$inputWare = '';

		$numPage = $input['page'];
		if($numPage == 'all') {$numPage = 1; $viewModePage = 'all';}
		if(empty($numPage)) {$numPage = 1;}
		$countEntity = 12;
		$limit = $countEntity;
		if($viewModePage == 'all'){$limit = $outputCount[0]['count(permAll)'];}

		$countPages = ceil($outputCount[0]['count(permAll)']/$countEntity);
		if($numPage == 1)
		{ $startPos = 0; } else { $startPos = $numPage*$countEntity - $countEntity; }
		if($startPos + $countEntity > $outputCount[0]['count(permAll)'])
		{ $maxPos = $outputCount[0]['count(permAll)']; } else { $maxPos = $startPos + $countEntity; }

	$inputWare['tableName'] = 'resource';
	$inputWare['select'] = 'resourceID, resourceAlias, categoryID, subCategoryID, resourceBrand, resourceName, resourceArtikul, resourceDescription, resourceImage, enterPrice, presence, resourcePrice, wholesalePrice';
	$inputWare['filter'] = $searchFilter;
	$inputWare['sort_resourcePosition'] = 'asc';
	$inputWare['sort'] = sortData($inputWare);
	$inputWare['limit'] = ' limit '.$startPos.', '.$limit;
	$outputResource = getData($inputWare);
	$inputWare = '';

	if($outputResource['rows'] > 0)
	{
		$filterSub = ''; $SEP = '';
		for ($i=0; $i < $outputResource['rows']; $i++)
		{
			$filterSub .= $SEP.'categoryID = \''.$outputResource[$i]['subCategoryID'].'\'';
			$SEP = ' OR ';
		}

		$inputSubCat['tableName'] = 'category';
		$inputSubCat['filter'] = 'AND ('.$filterSub.')';
		$inputSubCat['select'] = 'categoryID, categoryAlias, categoryName';
		$searchSubCat = getData($inputSubCat);
		$inputSubCat = '';

		for($i=0; $i < $searchSubCat['rows']; $i++)
		{
			$CAT_ARRAY[$searchSubCat[$i]['categoryID']] = $searchSubCat[$i];
		}
	}
	else
	{
		$resultMessage = '<div style="text-align:center;color:#FF0000;font-size:14px;">Поиск не дал результатов.</div>';
	}
}

$pageTitle = 'Поиск — Интернет-Супермаркет HappyMarket.net.ua';

?>
