<?
$input = $_POST;
$inputFilter = $_POST;
if ($url == 'manageSearch' AND $inputFilter['viewMode'] == 'search') 
{
	$inputFilter['search_name'] = trim($inputFilter['search_name']);
	$inputFilter['search_name'] = eregi_replace("[  ]+"," ",$inputFilter['search_name']);

	$inputFilter['search_description'] = trim($inputFilter['search_description']);
	$inputFilter['search_description'] = eregi_replace("[  ]+"," ",$inputFilter['search_description']);
	
	if(!is_array($inputFilter['search_presence'])) $inputFilter['search_presence'] = explode('&',$inputFilter['search_presence']);
	if (!empty($inputFilter['search_presence'][0]) AND $inputFilter['search_presence'][0] != 'all')
	{
		$searchPresenceFilter = ''; $OR = '';
		for($i=0; $i < count($inputFilter['search_presence']); $i++)
		{
			$searchPresenceFilter .= $OR."presence = '".$inputFilter['search_presence'][$i]."'";
			$OR = ' OR ';
		}
		if(!empty($searchPresenceFilter)) $searchPresenceFilter = " AND (".$searchPresenceFilter.")";
		$search_presence = implode('&',$inputFilter['search_presence']);
	}
	else
	{
		$search_presence = 'all';
	}

	if(!is_array($inputFilter['search_category'])) $inputFilter['search_category'] = explode('&',$inputFilter['search_category']);
	if (!empty($inputFilter['search_category'][0]) AND $inputFilter['search_category'][0] != 'all')
	{
		$searchCategoryFilter = ''; $SEP = '';
		for($i=0; $i < count($inputFilter['search_category']); $i++)
		{
			$searchCategoryFilter .= $SEP.'categoryID = \''.$inputFilter['search_category'][$i].'\'';
			$SEP = ' OR ';
		}
		$search_category = implode('&',$inputFilter['search_category']);
		if(!empty($search_category)) $search_category = '&'.$search_category.'&';
		if(!empty($searchCategoryFilter)) $searchCategoryFilter = ' AND ('.$searchCategoryFilter.')';
	}
	if ($inputFilter['search_status'] == 'active' OR $inputFilter['search_status'] == 'hidden')
	{
		$search_status = $inputFilter['search_status'];
		if($inputFilter['search_status'] == 'active') $searchStatusFilter = " AND `permAll` = '1'";
		if($inputFilter['search_status'] == 'hidden') $searchStatusFilter = " AND `permAll` = '0'";
	}
	elseif($inputFilter['search_status'] == 'all')
	{
		$search_status = 'all';
	}
	
	$count_search = 0;
	if(!empty($inputFilter['search_name']))
	{
		$searchNameArray = explode(' ',$inputFilter['search_name']);
		$searchNameFilter = '';
		for($i=0; $i < count($searchNameArray); $i++)
		{
			$searchNameFilter .=  " AND (resourceName like '%".$searchNameArray[$i]."%' OR resourceArtikul like '%".$searchNameArray[$i]."%')";
		}
		$search_name = $inputFilter['search_name'];
	}

	if(!empty($inputFilter['search_description']))
	{
		$searchDescriptionArray = explode(' ',$inputFilter['search_description']);
		$searchDescriptionFilter = '';
		for($i=0; $i < count($searchDescriptionArray); $i++)
		{
			$searchDescriptionFilter .=  " AND resourceDescription like '%".$searchDescriptionArray[$i]."%'";
		}
		$search_description = $inputFilter['search_description'];
	}
	
	if (!empty($inputFilter['search_minprice']) OR !empty($inputFilter['search_maxprice']))
	{
		if (!empty($inputFilter['search_minprice'])){$search_minprice = $inputFilter['search_minprice']; $searchMinPriceFilter = " AND resourcePrice >= ".$search_minprice;}
		if (!empty($inputFilter['search_maxprice'])){$search_maxprice = $inputFilter['search_maxprice']; $searchMaxPriceFilter = " AND resourcePrice <= ".$search_maxprice;}
		$searchPriceFilter = $searchMinPriceFilter.$searchMaxPriceFilter;
	}
	
	$input['tableName'] = 'resource';
	$input['filter'] = $searchCategoryFilter.$searchNameFilter.$searchDescriptionFilter.$searchStatusFilter.$searchPresenceFilter.$searchPriceFilter;
	$input['sort'] = 'ORDER BY resourcePosition asc';
	$output = getData($input);
	$input = '';

	if($output['rows'] > 0)
	{
		$filterCategory = ''; $SEP = '';
		for($i=0; $i < $output['rows']; $i++)
		{
			$filterCategory .= $SEP.'categoryID = \''.$output[$i]['categoryID'].'\'';
			$SEP = ' OR ';
		}
	
		if(!empty($filterCategory))
		{
			$input['tableName'] = 'category';
			$input['select'] = 'categoryID, categoryAlias, categoryName, categoryBrand, categoryDepartment';
			$input['filter'] = ' AND ('.$filterCategory.')';
			$input['sort'] = 'ORDER BY categoryPosition asc';
			$outputCategory = getData($input);
			$input = '';

			$filerBrand = ''; $OR = '';
			for ($cat=0; $cat < $outputCategory['rows']; $cat++)
			{
				$CAT_ARRAY[$outputCategory[$cat]['categoryID']] = $outputCategory[$cat];
				for($i=0; $i < $output['rows']; $i++)
				{
					if($outputCategory[$cat]['categoryID'] == $output[$i]['categoryID'])
					{
						$outputResource[$outputCategory[$cat]['categoryID']][] = $output[$i];
					}
				}
				$outputResource[$outputCategory[$cat]['categoryID']]['rows'] = count($outputResource[$outputCategory[$cat]['categoryID']]);

				// get filter brand
				$explodeBrand = explode('|',$outputCategory[$cat]['categoryBrand']);
				for($i=1; $i < count($explodeBrand)-1; $i++)
				{
					$filerBrand .= $OR."`brandID` = ".$explodeBrand[$i];
					$OR = " OR ";
				}
				//
			}
		
			$input['tableName'] = 'brand';
			$input['select'] = 'brandID, brandName, brandCurrency';
			if(!empty($filerBrand)) $input['filter'] = " AND (".$filerBrand.")";
			$input['sort'] = " ORDER BY BINARY(LOWER(LEFT(brandName, 10))) ";
			$outputBrand = getData($input);
			$input = '';

			$CUR_CURRENCY[''] = 'грн.'; $KOEF_CURRENCY[''] = 1;
			for($b=0; $b < $outputBrand['rows']; $b++)
			{
				$BRAND_ARRAY[$outputBrand[$b]['brandID']] = $outputBrand[$b];
			}
		}
	}
}
if($url == 'manageSearch')
{
	$inputCat['tableName'] = 'category';
	$inputCat['select'] = 'categoryID, categoryName';
	$inputCat['filter_parentCategoryID'] = 'top';
	$inputCat['filter'] = getFilter($inputCat);
	$inputCat['sort_categoryPosition'] = 'asc';
	$inputCat['sort'] = sortData($inputCat);
	$outputCat = getData($inputCat);
	$inputCat = '';

	$ddPermAll1 = array("active"=>"Активный","hidden"=>"Скрытый");
}
?>