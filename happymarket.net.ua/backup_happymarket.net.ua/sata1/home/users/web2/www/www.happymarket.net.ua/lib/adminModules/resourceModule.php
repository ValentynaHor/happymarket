<?php
$input = $_POST;

$COUNT_ADD_IMAGE = 4;
if ($url == 'manageResource' OR $url == 'manageResources')
{
	if(empty($getvar['dept']) OR empty($getvar['category']) OR empty($getvar['sub'])) header("Location: ".urlse."/adm/?manageDepartments");
	elseif($getvar['dept'] != '3' AND $userArray['userID'] == '444' OR $getvar['dept'] == '3' AND $userArray['userID'] == '555')
	{
		 header("Location: ".urlse."/adm/?manageDepartments");
	}
}

if ($url == 'manageSubCategory' OR $url == 'manageSubCategories')
{
	if(empty($getvar['dept']) OR empty($getvar['category'])) header("Location: ".urlse."/adm/?manageDepartments");
	elseif($getvar['dept'] != '3' AND $userArray['userID'] == '444' OR $getvar['dept'] == '3' AND $userArray['userID'] == '555')
	{
		 header("Location: ".urlse."/adm/?manageDepartments");
	}
}

if ($url == 'manageCategory' OR $url == 'manageCategories')
{
	if(empty($getvar['dept'])) header("Location: ".urlse."/adm/?manageDepartments");
	elseif($getvar['dept'] != '3' AND $userArray['userID'] == '444' OR $getvar['dept'] == '3' AND $userArray['userID'] == '555')
	{
		 header("Location: ".urlse."/adm/?manageDepartments");
	}
}

if ($url == 'manageDepartment')
{
	if(empty($getvar['department']) OR ($getvar['department'] != '3' AND $userArray['userID'] == '444' OR $getvar['department'] == '3' AND $userArray['userID'] == '555'))
	{
		 header("Location: ".urlse."/adm/?manageDepartments");
	}
}

if ($url == 'manageSetting')
{
	if($input['viewMode'] == 'save')
	{
		$input['tableName']= 'setting';
		$input['entityID']= '111111';
		saveData($input);
		$input = '';
	}
	$input['tableName'] = 'setting';
	$outputSetting = getData($input);
	$input = '';
}

if ($url == 'manageCategory' OR $url == 'manageSubCategory')
{
	$FLAG_CHANGE_SID = '';
	if ($input['viewMode']=='save')
	{
		$input[$input['tableName'].'_'.$input['tableName'].'Name'] = trim($input[$input['tableName'].'_'.$input['tableName'].'Name']);
		$input[$input['tableName'].'_'.$input['tableName'].'Name'] = str_replace("'","`",$input[$input['tableName'].'_'.$input['tableName'].'Name']);
		$input[$input['tableName'].'_'.$input['tableName'].'Name'] = str_replace('"','&quot;',$input[$input['tableName'].'_'.$input['tableName'].'Name']);

		//generate alias
		if(empty($input['entityID']))
		{
			$input[$input['tableName'].'_'.$input['tableName'].'Alias'] = gen_alias($input[$input['tableName'].'_'.$input['tableName'].'Name'],60,50);
		}

		$upload = $input['tableName'].'_'.$input['tableName'].'Image';
		$upload_name = $input['tableName'].'_'.$input['tableName'].'Image_name';
		if (!empty($_FILES[$upload]['tmp_name']))
		{
			$ext = explode('.',$_FILES[$upload]['name']);
			$ext = '.'.$ext[count($ext)-1];
			$name = $input[$input['tableName'].'_'.$input['tableName'].'Alias'];

			$input[$upload] = $name.$ext;
			$uploadPath = url_upload."resource/".$input[$upload];

			if(!copy($_FILES[$upload]['tmp_name'], $uploadPath))
			{
				echo 'Error: no image uploaded';
			}
			else
			{
				@ chmod($uploadPath, 0777);
				$imgInfo = @ getimagesize($uploadPath);
				if($imgInfo[0] > 120 OR $imgInfo[1] > 120)
					$lines = file(urlse.'/cgi/magick.pl/120/120/75/resource/'.$input[$upload]);
			}
		}

		if($url == 'manageSubCategory' AND !empty($input['entityID']) AND $input['category_parentCategoryID'] != $input['compareParentCategory'])
		{
			$input['brand'] = '';

			if($input['category_parentCategoryID'] == 'top')
			{

				$FLAG_CHANGE_SID = '/adm/?manageCategory/category/'.$input['entityID'].'/dept/'.$getvar['dept'];

				$input['category_categoryDepartment'] = $getvar['dept'];

				$inputDelRes['tableName'] = 'resource';
				$inputDelRes['filter_subCategoryID'] = $input['entityID'];
				$inputDelRes['filter'] = getFilter($inputDelRes);
				delData($inputDelRes);
				$inputDelRes = '';
			}
		}

		$input[$input['tableName'].'_'.$input['tableName'].'Brand'] = '';
		if(is_array($input['brand']))
		{
			foreach($input['brand'] as $key => $val)
			{
				if($val == '1') $input[$input['tableName'].'_'.$input['tableName'].'Brand'] .= $key.'|';
			}
		}
		if(!empty($input[$input['tableName'].'_'.$input['tableName'].'Brand'])) $input[$input['tableName'].'_'.$input['tableName'].'Brand'] = '|'.$input[$input['tableName'].'_'.$input['tableName'].'Brand'];
		if(!empty($input['entityID']))
		{
			$inputCompare['tableName'] = 'category';
			$inputCompare['select'] = 'categoryID, categoryAlias, parentCategoryID';
			$inputCompare['filter_categoryID'] = $input['entityID'];
			$inputCompare['filter'] = getFilter($inputCompare);
			$outputCompare = getData($inputCompare);
			$inputCompare = '';
		}

		$input['auto_increment'] = 'yes';
		$systemMessage = saveData($input);

		if($systemMessage != 'error')
		{
			if(!empty($input['entityID']))
			{
				if($outputCompare[0]['categoryAlias'] != $input['category_categoryAlias'] OR $outputCompare[0]['parentCategoryID'] != $input['category_parentCategoryID'])
				{
					if(!empty($FLAG_CHANGE_SID))
					{
						$newDirPath = url_upload.'resource/'.$input['category_categoryAlias'].'/';

						if(!file_exists($newDirPath)) { mkdir($newDirPath, 0777); }
						chmod($newDirPath, 0777);
					}
					elseif($input['category_parentCategoryID'] == 'top')
					{
						$oldDirPath = url_upload.'resource/'.$outputCompare[0]['categoryAlias'].'/';
						$newDirPath = url_upload.'resource/'.$input['category_categoryAlias'].'/';

						if($oldDirPath != $newDirPath)
						{
							if(file_exists($oldDirPath) AND !file_exists($newDirPath)) { rename($oldDirPath, $newDirPath); }
							elseif(!file_exists($newDirPath)) { mkdir($newDirPath, 0777); }
						}
						elseif(!file_exists($newDirPath))
						{
							if(!file_exists($newDirPath)) { mkdir($newDirPath, 0777); }
						}
						chmod($newDirPath, 0777);
					}
					elseif($outputCompare[0]['parentCategoryID'] != $input['category_parentCategoryID'])
					{
						$inputParent['tableName'] = 'category';
						$inputParent['select'] = 'categoryAlias';
						$inputParent['filter_categoryID'] = $outputCompare[0]['parentCategoryID'];
						$inputParent['filter'] = getFilter($inputParent);
						$outputParentOld = getData($inputParent);
						$inputParent = '';

						$inputParent['tableName'] = 'category';
						$inputParent['select'] = 'categoryAlias';
						$inputParent['filter_categoryID'] = $input['category_parentCategoryID'];
						$inputParent['filter'] = getFilter($inputParent);
						$outputParentNew = getData($inputParent);
						$inputParent = '';

						$oldDirPath = url_upload.'resource/'.$outputParentOld[0]['categoryAlias'].'/'.$input['entityID'].'/';
						$newDirPath = url_upload.'resource/'.$outputParentNew[0]['categoryAlias'].'/'.$input['entityID'].'/';
						if(file_exists($oldDirPath) AND !file_exists($newDirPath)) { rename($oldDirPath, $newDirPath); chmod($newDirPath, 0777); }
						elseif(!file_exists($newDirPath))
						{
							mkdir($newDirPath, 0777);
							chmod($newDirPath, 0777);

							if(!file_exists($newDirPath.'1/')) { mkdir($newDirPath.'1/', 0777); }
							chmod($newDirPath.'1/', 0777);
							if(!file_exists($newDirPath.'2/')) { mkdir($newDirPath.'2/', 0777); }
							chmod($newDirPath.'2/', 0777);
							if(!file_exists($newDirPath.'3/')) { mkdir($newDirPath.'3/', 0777); }
							chmod($newDirPath.'3/', 0777);
							if(!file_exists($newDirPath.'4/')) { mkdir($newDirPath.'4/', 0777); }
							chmod($newDirPath.'4/', 0777);
						}
					}
				}
			}
			else
			{
				if($input['category_parentCategoryID'] == 'top')
				{
					$dirPath = url_upload.'resource/'.$input['category_categoryAlias'].'/';
					if(!file_exists($dirPath)) { mkdir($dirPath, 0777); }
					chmod($dirPath, 0777);
				}
				else
				{
					$inputParent['tableName'] = 'category';
					$inputParent['select'] = 'categoryAlias';
					$inputParent['filter_categoryID'] = $input['category_parentCategoryID'];
					$inputParent['filter'] = getFilter($inputParent);
					$outputParent = getData($inputParent);
					$inputParent = '';

					$dirPath = url_upload.'resource/'.$outputParent[0]['categoryAlias'].'/'.$globalInsertAutoID.'/';
					if(!file_exists($dirPath)) { mkdir($dirPath, 0777); }
					chmod($dirPath, 0777);

					if(!file_exists($dirPath.'1/')) { mkdir($dirPath.'1/', 0777); }
					chmod($dirPath.'1/', 0777);
					if(!file_exists($dirPath.'2/')) { mkdir($dirPath.'2/', 0777); }
					chmod($dirPath.'2/', 0777);
					if(!file_exists($dirPath.'3/')) { mkdir($dirPath.'3/', 0777); }
					chmod($dirPath.'3/', 0777);
					if(!file_exists($dirPath.'4/')) { mkdir($dirPath.'4/', 0777); }
					chmod($dirPath.'4/', 0777);
				}
			}

			if(!empty($FLAG_CHANGE_SID)) header("Location: ".urlse.$FLAG_CHANGE_SID);
		}
		$input = '';
	}
}

if ($url == 'manageCategory')
{
	if(!empty($getvar['remove']) AND !empty($getvar['category']))
	{
		if(@ unlink('../images/resource/'.$getvar['remove']) OR !file_exists('../images/resource/'.$getvar['remove']))
		{
			$input['entityID'] = $getvar['category'];
			$input['category_categoryImage'] = '';
			$input['tableName'] = 'category';
			saveData($input);
		}
		header("Location: ".$_SERVER['HTTP_REFERER']);
		$input ='';
	}

	$input['tableName'] = 'category';
	$input['filter_categoryID'] = $getvar['category'];
	$input['filter'] = getFilter($input);
	$output = getData($input);
	$output = $output[0];
	$input = '';

	$input['tableName'] = 'department';
	$input['select'] = 'departmentID, parentDepartmentID, departmentName';
	$input['sort'] = 'ORDER BY departmentID';
	$outputDepartment = getData($input);
	$input = '';

	$ddDepartment[''] = ' -- выбрать -- ';
	for($i=0; $i<$outputDepartment['rows']; $i++)
	{
		if($userArray['userID'] == '444' AND $outputDepartment[$i]['departmentID'] == '3' OR $userArray['userID'] == '555' AND $outputDepartment[$i]['departmentID'] != '3')
		{
			if($outputDepartment[$i]['parentDepartmentID'] == 'top')
			{
				$FLAG = '';
				for($j=0; $j<$outputDepartment['rows']; $j++)
				{
					if($outputDepartment[$j]['parentDepartmentID'] == $outputDepartment[$i]['departmentID'])
					{
						$ddDepartment[$outputDepartment[$j]['departmentID']] = $outputDepartment[$j]['departmentName'];
						$FLAG .= $outputDepartment[$j]['departmentID'].'|';
					}
				}
				if(empty($FLAG)) $ddDepartment[$outputDepartment[$i]['departmentID']] = $outputDepartment[$i]['departmentName'];
			}
		}
	}

	$input['tableName'] = 'brand';
	$input['select'] = 'brandID, brandName';
	$input['sort'] = " ORDER BY BINARY(LOWER(LEFT(brandName, 10))) ";
	$outputBrand = getData($input);
	$input = '';
}

if ($url == 'manageCategories')
{
	if($input['viewMode'] == "saveArray")
	{
		$input['auto_increment'] = 'yes';
		saveArray($input);
		$input = '';
	}

	$input['tableName'] = 'department';
	$input['select'] = 'departmentID, departmentName';
	if(!empty($getvar['dept'])) $input['filter'] .= " AND departmentID = '".$getvar['dept']."' ";
	$outputDepartment = getData($input);
	$outputDepartment = $outputDepartment[0];
	$input = '';


	// $input['tableName'] = "category";
	// $input['filter_parentCategoryID'] = 'top';
	// $input['filter'] = getFilter($input);
	// $input['select'] = 'count(permAll)';
	// $outputCount = getData($input);
	// $input = '';

	// $numPage = $getvar['page'];
	// if(empty($numPage)) {$numPage = 1;}
	// $countEntity = 30;
	// if($numPage == 1) { $startPos = 0; } else { $startPos = $numPage*$countEntity - $countEntity; }

	$inputCat['tableName'] = 'category';
	$inputCat['filter_parentCategoryID'] = 'top';
	$inputCat['filter'] = getFilter($inputCat);
	if(!empty($getvar['dept'])) $inputCat['filter'] .= " AND categoryDepartment = '".$getvar['dept']."' ";
	//$inputCat['sort'] = ' ORDER BY BINARY(LOWER(LEFT(categoryName, 10))) ';
	$inputCat['sort'] = ' ORDER BY categoryPosition asc';
	// $inputCat['limit'] = ' limit '.$startPos.', '.$countEntity;
	$outputCat = getData($inputCat);
	$inputCat = '';

	$filterParentCat=''; $OR='';
	for($i=0; $i<$outputCat['rows']; $i++){
		$filterParentCat .= $OR."parentCategoryID = '".$outputCat[$i]['categoryID']."'";
		$OR = " OR ";
	}
	$filterParentCat = ' AND ('.$filterParentCat.') ';

	$inputSubCat['tableName'] = 'category';
	$inputSubCat['filter'] = " AND parentCategoryID != 'top' ";
	if(!empty($filterParentCat)) $inputSubCat['filter'] .= $filterParentCat;
	$inputSubCat['sort'] = 'ORDER BY categoryPosition ASC';//' ORDER BY BINARY(LOWER(LEFT(categoryName, 10))) ';
	$outputSubCat = getData($inputSubCat);
	$inputSubCat = '';


/*	$input['tableName'] = 'department';
	$input['select'] = 'departmentID, departmentName';
	if(!empty($getvar['dept'])) $input['filter'] .= " AND departmentID = '".$getvar['dept']."' ";
	$outputDepartment = getData($input);
	$outputDepartment = $outputDepartment[0];
	$input = '';
*/
	// for($i=0; $i<$outputDepartment['rows']; $i++)
	// {
		// $ddDepartment[$outputDepartment[$i]['departmentID']] = $outputDepartment[$i]['departmentName'];
	// }

}

if ($url == 'manageSubCategory')
{
	$input['tableName'] = 'category';
	$input['filter_categoryID'] = $getvar['sub'];
	$input['filter'] = getFilter($input);
	$output = getData($input);
	$output = $output[0];
	$input = '';

	$inputCat['tableName'] = 'category';
	$inputCat['select'] = 'categoryID, categoryName, categoryBrand';
	$inputCat['filter_categoryDepartment'] = $getvar['dept'];
	$inputCat['filter_parentCategoryID'] = 'top';
	$inputCat['filter'] = getFilter($inputCat);
	$inputCat['sort'] = ' ORDER BY BINARY(LOWER(LEFT(categoryName, 10))) ';
	$outputCat = getData($inputCat);
	$inputCat = '';

	for ($i=0; $i<$outputCat['rows']; $i++)
	{
		if($output['parentCategoryID'] == $outputCat[$i]['categoryID']) { $PARRENT_CAT = $outputCat[$i]; break; }
		elseif($getvar['category'] == $outputCat[$i]['categoryID']) { $PARRENT_CAT = $outputCat[$i]; }
	}

	$inputParent['tableName'] = 'category';
	$inputParent['select'] = 'categoryBrand';
	$inputParent['filter_categoryID'] = $getvar['category'];
	$inputParent['filter'] = getFilter($inputParent);
	$outputParent = getData($inputParent);
	$inputParent = '';

	$filerBrand = ''; $OR = '';$FLAG = false;
	$explodeBrand = explode('|',$PARRENT_CAT['categoryBrand']);
	for($i=1; $i < count($explodeBrand)-1; $i++)
	{
		$filerBrand .= $OR."`brandID` = ".$explodeBrand[$i];
		$OR = " OR ";
		$FLAG = true;
	}

	$input['tableName'] = 'brand';
	$input['select'] = 'brandID, brandName';
	if($FLAG) $input['filter'] = " AND (".$filerBrand.")"; else $input['filter'] = " AND 2=1 ";
	$input['sort'] = " ORDER BY BINARY(LOWER(LEFT(brandName, 10))) ";
	$outputBrand = getData($input);
	$input = '';
}

if ($url == 'manageSubCategories')
{
	if($input['viewMode'] == "saveArray")
	{
		$input['auto_increment'] = 'yes';
		saveArray($input);
		$input = '';
	}

	$input['tableName'] = "category";
	$input['filter_parentCategoryID'] = $getvar['category'];
	$input['filter'] = getFilter($input);
	$input['select'] = 'count(permAll)';
	$outputCount = getData($input);
	$input = '';

	$numPage = $getvar['page'];
	if(empty($numPage)) {$numPage = 1;}
	$countEntity = 20;
	if($numPage == 1) { $startPos = 0; } else { $startPos = $numPage*$countEntity - $countEntity; }

	$inputSub['tableName'] = 'category';
	$inputSub['filter_parentCategoryID'] = $getvar['category'];
	$inputSub['filter'] = getFilter($inputSub);
	//$inputSub['sort'] = ' ORDER BY BINARY(LOWER(LEFT(categoryName, 10))) ';
	$inputSub['sort'] = 'ORDER BY categoryPosition asc';
	$inputSub['limit'] = ' limit '.$startPos.', '.$countEntity;
	$outputSub = getData($inputSub);
	$inputSub = '';

	$input['tableName'] = "category";
	$input['select'] = 'categoryID, categoryName';
	$input['filter_categoryID'] = $getvar['category'];
	$input['filter'] = getFilter($input);
	$currentCat = getData($input);
	$input = '';

	$input['tableName'] = 'department';
	$input['select'] = 'departmentID, departmentName';
	if(!empty($getvar['dept'])) $input['filter'] .= " AND departmentID = '".$getvar['dept']."' ";
	$outputDepartment = getData($input);
	$outputDepartment = $outputDepartment[0];
	$input = '';

}

if ($url == 'manageDepartment')
{
	if ($input['viewMode']=='save')
	{
		$input[$input['tableName'].'_'.$input['tableName'].'Name'] = trim($input[$input['tableName'].'_'.$input['tableName'].'Name']);
		$input[$input['tableName'].'_'.$input['tableName'].'Name'] = str_replace("'","`",$input[$input['tableName'].'_'.$input['tableName'].'Name']);
		$input[$input['tableName'].'_'.$input['tableName'].'Name'] = str_replace('"','&quot;',$input[$input['tableName'].'_'.$input['tableName'].'Name']);

		//generate alias
		if(empty($input['entityID']))
		{
			$input[$input['tableName'].'_'.$input['tableName'].'Alias'] = gen_alias($input[$input['tableName'].'_'.$input['tableName'].'Name'],60,50);
		}

		$upload = $input['tableName'].'_'.$input['tableName'].'Image';
		$upload_name = $input['tableName'].'_'.$input['tableName'].'Image_name';
		if (!empty($_FILES[$upload]['tmp_name']))
		{
			$input[$upload] = $_FILES[$upload]['name'];
			$uploadPath = url_upload."resource/".$input[$upload];

			if(!copy($_FILES[$upload]['tmp_name'], $uploadPath))
			{
				echo 'Error: no image uploaded';
			}
			else
			{
				//$lines = file(urlse.'/cgi/magickCategory.pl/'.$input[$upload]);
			}
		}

		$input['auto_increment'] = 'yes';
		$systemMessage = saveData($input);
	}

	if(!empty($getvar['remove']))
	{
		if(@ unlink('../images/resource/preview/'.$getvar['remove']) OR !file_exists('../images/resource/preview/'.$getvar['remove']))
		{
			@ unlink('../images/resource/'.$getvar['remove']);
			$input['entityID'] = $getvar['department'];
			$input['department_departmentImage'] = '';
			$input['tableName'] = 'department';
			saveData($input);
		}
		header("Location: ".$_SERVER['HTTP_REFERER']);
		//echo '<META http-equiv="refresh" content="0; url='.$_SERVER['HTTP_REFERER'].'">';
		$input ='';
	}

	$input['tableName'] = 'department';
	$input['filter_departmentID'] = $getvar['department'];
	$input['filter'] = getFilter($input);
	$output = getData($input);
	$output = $output[0];
	$input = '';
}

if ($url == 'manageDepartments')
{
	if($input['viewMode'] == "saveArray")
	{
		$input['auto_increment'] = 'yes';
		saveArray($input);
		$input = '';
	}

	$input['tableName'] = "department";
	$input['select'] = 'count(permAll)';
	$outputCount = getData($input);
	$input = '';

	$numPage = $getvar['page'];
	if(empty($numPage)) {$numPage = 1;}
	$countEntity = 20;
	if($numPage == 1) { $startPos = 0; } else { $startPos = $numPage*$countEntity - $countEntity; }

	$inputDepartment['tableName'] = 'department';
	$inputDepartment['sort'] = 'ORDER BY departmentID';
	$inputDepartment['limit'] = ' limit '.$startPos.', '.$countEntity;
	$outputDepartment = getData($inputDepartment);
	$inputDepartment = '';
}


$input = $_POST;
if ($url == 'manageResource')
{
	// GET CATEGORY
	$inputCat['tableName'] = "category";
	$inputCat['select'] = "categoryID, categoryAlias, categoryName, categoryBrand, parentCategoryID, categoryDepartment";
	$inputCat['sort'] = ' ORDER BY BINARY(LOWER(LEFT(categoryName, 10))) ';
	$outputTableCategory = getData($inputCat);
	for ($i=0; $i < $outputTableCategory['rows']; $i++)
	{
		$CAT_ARRAY[$outputTableCategory[$i]['categoryID']] = $outputTableCategory[$i];
		if($outputTableCategory[$i]['parentCategoryID'] == 'top')
		{
			$outputCat[] = $outputTableCategory[$i];
		}
		if(!is_numeric($getvar['sub']) AND $getvar['sub'] == $outputTableCategory[$i]['categoryAlias'] AND $getvar['category'] == $outputTableCategory[$i]['parentCategoryID'])
		{
			$getvar['sub'] = $outputTableCategory[$i]['categoryID'];
		}
	}
	$outputCat['rows'] = count($outputCat);
	$inputCat = '';

	// GET SUBCATEGORY
	for ($cat=0; $cat < $outputCat['rows']; $cat++)
	{
		for ($i=0; $i < $outputTableCategory['rows']; $i++)
		{
			if($outputTableCategory[$i]['parentCategoryID'] == $outputCat[$cat]['categoryID'])
			{
				$outputSubCat[$outputCat[$cat]['categoryID']][] = $outputTableCategory[$i];
			}
		}
		$outputSubCat[$outputCat[$cat]['categoryID']]['rows'] = count($outputSubCat[$outputCat[$cat]['categoryID']]);
	}

	$filerBrand = ''; $OR = '';$FLAG = false;
	if($input['viewMode'] == 'save' AND !empty($input['resource_subCategoryID'])) $explodeBrand = explode('|',$CAT_ARRAY[$input['resource_subCategoryID']]['categoryBrand']); elseif($input['viewMode'] == 'save' AND !empty($input['resource_categoryID'])) $explodeBrand = explode('|',$CAT_ARRAY[$input['resource_categoryID']]['categoryBrand']); else $explodeBrand = explode('|',$CAT_ARRAY[$getvar['sub']]['categoryBrand']);
	for($i=1; $i < count($explodeBrand)-1; $i++)
	{
		$filerBrand .= $OR."`brandID` = ".$explodeBrand[$i];
		$OR = " OR ";
		$FLAG = true;
	}

	$inputBrand['tableName'] = 'brand';
	$inputBrand['select'] = 'brandID, brandAlias, brandName, brandCurrency';
	if($FLAG) $inputBrand['filter'] = " AND (".$filerBrand.")"; else $inputBrand['filter'] = " AND 2=1 ";
	$inputBrand['sort'] = " ORDER BY BINARY(LOWER(LEFT(brandName, 10))) ";
	$outputBrand = getData($inputBrand);
	$inputBrand = '';

	for($b=0; $b < $outputBrand['rows']; $b++)
	{
		$brandsArray[$outputBrand[$b]['brandID']] = $outputBrand[$b];
		$ddBrand[$outputBrand[$b]['brandID']] = $outputBrand[$b]['brandName'];
		if($outputBrand[$b]['brandID'] == $input[$input['tableName'].'_'.$input['tableName'].'Brand'] AND !empty($input[$input['tableName'].'_'.$input['tableName'].'Brand'])) $currentBrand = $outputBrand[$b];
	}

	if($input['viewMode']=='save_add' AND !empty($input[$input['tableName'].'_'.$input['tableName'].'Name']))
	{
		$input[$input['tableName'].'_'.$input['tableName'].'Name'] = str_replace('"','&quot;',$input[$input['tableName'].'_'.$input['tableName'].'Name']);
		$input[$input['tableName'].'_'.$input['tableName'].'Name'] = str_replace("'","`",$input[$input['tableName'].'_'.$input['tableName'].'Name']);

		$upload = $input['tableName'].'_'.$input['tableName'].'Image';
		$upload_name = $input['tableName'].'_'.$input['tableName'].'Image_name';
		if(!empty($_FILES[$upload]['tmp_name']))
		{
			$ext = explode('.',$_FILES[$upload]['name']);
			$ext = '.'.$ext[count($ext)-1];
			$name = gen_alias($input[$input['tableName'].'_'.$input['tableName'].'Name'],60,50).'-'.$input[$input['tableName'].'_resourceID'];

			$input[$upload] = $name.$ext;
			$uploadPath = url_upload."resource/".$CAT_ARRAY[$input['categoryID']]['categoryAlias']."/".$CAT_ARRAY[$input['subCategoryID']]['categoryID']."/3/".$input[$upload];

			if(!copy($_FILES[$upload]['tmp_name'], $uploadPath))
			{
				echo 'Error: no image uploaded';
			}
			else
			{
				copy($uploadPath, url_upload."resource/".$CAT_ARRAY[$input['categoryID']]['categoryAlias']."/".$CAT_ARRAY[$input['subCategoryID']]['categoryID']."/4/".$input[$upload]);
				@ chmod(url_upload."resource/".$CAT_ARRAY[$input['categoryID']]['categoryAlias']."/".$CAT_ARRAY[$input['subCategoryID']]['categoryID']."/4/".$input[$upload], 0777);
				@ chmod(url_upload."resource/".$CAT_ARRAY[$input['categoryID']]['categoryAlias']."/".$CAT_ARRAY[$input['subCategoryID']]['categoryID']."/3/".$input[$upload], 0777);
				$imgInfo = @ getimagesize($uploadPath);
				if($imgInfo[0] >= 150)
				{
					$lines = file(urlse.'/cgi/magick.pl/150/200/75/resource|'.$CAT_ARRAY[$input['categoryID']]['categoryAlias'].'|'.$CAT_ARRAY[$input['subCategoryID']]['categoryID'].'|4/'.$input[$upload]);
				}
				if($imgInfo[0] >= 400)
				{
					$lines = file(urlse.'/cgi/magick.pl/400/400/75/resource|'.$CAT_ARRAY[$input['categoryID']]['categoryAlias'].'|'.$CAT_ARRAY[$input['subCategoryID']]['categoryID'].'|3/'.$input[$upload]);
				}
				//@ chmod(url_upload."resource/".$CAT_ARRAY[$input['categoryID']]['categoryAlias']."/".$CAT_ARRAY[$input['subCategoryID']]['categoryID']."/3/".$input[$upload], 0777);
				//@ chmod(url_upload."resource/".$CAT_ARRAY[$input['categoryID']]['categoryAlias']."/".$CAT_ARRAY[$input['subCategoryID']]['categoryID']."/4/".$input[$upload], 0777);
			}
		}

		$input['auto_increment'] = 'yes';
		saveData($input);
		$input = '';
	}

	if ($input['viewMode']=='save')
	{
		if(empty($input['entityID']))
		{
			$q  = mysql_query("SHOW TABLE STATUS FROM `".db_name."` LIKE 'table_".$input['tableName']."'");
			$resourceID = mysql_result($q, 0, 'Auto_increment');
		}
		else
		{
			$resourceID = $input['entityID'];
		}

		foreach($input as $key=>$array)
		{
			if(strstr($key, 'check_'))
			{
				$strVal = ''; $strField = str_replace('check_','resource_',$key);
				if(is_array($array))
				{
					foreach($array as $id=>$val)
					{
						if($val == '1')
						{
							$strVal .= $id.'&';
						}
					}
					if(!empty($strVal)) $strVal  = '&'.$strVal;
				}
				$input[$strField] = $strVal;
			}
		}

		$input[$input['tableName'].'_'.$input['tableName'].'Name'] = trim($input[$input['tableName'].'_'.$input['tableName'].'Name']);
		$input[$input['tableName'].'_'.$input['tableName'].'Name'] = str_replace("'","`",$input[$input['tableName'].'_'.$input['tableName'].'Name']);
		$input[$input['tableName'].'_'.$input['tableName'].'Name'] = str_replace('"','&quot;',$input[$input['tableName'].'_'.$input['tableName'].'Name']);

		if(empty($currentBrand['brandAlias'])) $input[$input['tableName'].'_'.$input['tableName'].'Brand'] = '';

		//generate alias
		if(empty($input['entityID']))
		{
			$alias_tmp = $input[$input['tableName'].'_'.$input['tableName'].'Name'];
			$latin = validate_latin($alias_tmp);
			if(empty($latin))
			{
				$tmp_full = gen_alias2($alias_tmp,30,20,'',1);
				$tmp_cut = gen_alias2($tmp_full,30,20,1,'');
				if($tmp_full != $tmp_cut)
				{
					$quot = validate_quot($alias_tmp);
					if(!empty($quot)) $alias = $quot;
					else $alias = $tmp_cut;
				}
				else $alias = $tmp_cut;

				if(strstr($alias,'dlya') AND empty($quot))
				{
					$array_alias_cut = explode('-',$alias);
					if($array_alias_cut[count($array_alias_cut)-1] == 'dlya')
					{
						if($array_alias_cut[2] == 'dlya') $alias = str_replace('-dlya', '', $alias);
						elseif($array_alias_cut[1] == 'dlya')
						{
							$array_alias_full = explode('-',$tmp_full);
							$alias = $alias.'-'.$array_alias_full[2];
						}
					}
				}
			}
			else
			{
				$alias = $latin;
			}

			if(!empty($currentBrand['brandAlias']))
			{
				$brand_alias = gen_alias($currentBrand['brandName'], 60, 50);
				$brand_pos = strpos($alias, $brand_alias);
				if($brand_pos === false)
				{}
				else
				{
					$brand_len = strlen($brand_alias);
					$alias_len = strlen($alias);

					if($brand_pos == 0) $alias = str_replace($brand_alias.'-', '', $alias);
					elseif($brand_pos+$brand_len == $alias_len) $alias = str_replace('-'.$brand_alias, '', $alias);
					else $alias = str_replace('-'.$brand_alias.'-', '', $alias);
				}
			}

			$input[$input['tableName'].'_'.$input['tableName'].'Alias'] = $alias;
		}

		for($i=1; $i <= $COUNT_ADD_IMAGE; $i++)
		{
			$upload = $input['tableName'].'_'.$input['tableName'].'Image'.$i;
			$upload_name = $input['tableName'].'_'.$input['tableName'].'Image'.$i.'_name';
			if (!empty($_FILES[$upload]['tmp_name']))
			{
				$ext = explode('.',$_FILES[$upload]['name']);
				$ext = '.'.$ext[count($ext)-1];
				$name = $input['resource_resourceAlias'].'-'.$resourceID.'-foto-'.$i;

				$input[$upload] = $name.$ext;
				$uploadPath = url_upload."resource/".$CAT_ARRAY[$input['resource_categoryID']]['categoryAlias']."/".$input['resource_subCategoryID']."/1/".$input[$upload];

				if(!copy($_FILES[$upload]['tmp_name'], $uploadPath))
				{
					echo 'Error: no image uploaded';
				}
				else
				{
					copy($uploadPath, url_upload."resource/".$CAT_ARRAY[$input['resource_categoryID']]['categoryAlias']."/".$input['resource_subCategoryID']."/2/".$input[$upload]);
					@ chmod(url_upload."resource/".$CAT_ARRAY[$input['resource_categoryID']]['categoryAlias']."/".$input['resource_subCategoryID']."/1/".$input[$upload], 0777);
					@ chmod(url_upload."resource/".$CAT_ARRAY[$input['resource_categoryID']]['categoryAlias']."/".$input['resource_subCategoryID']."/2/".$input[$upload], 0777);
					$imgInfo = @ getimagesize($uploadPath);
					if($imgInfo[0] >= 65)
					{
						$lines = file(urlse.'/cgi/magick.pl/65/65/75/resource|'.$CAT_ARRAY[$input['resource_categoryID']]['categoryAlias'].'|'.$input['resource_subCategoryID'].'|2/'.$input[$upload]);
					}
					if($imgInfo[0] >= 375)
					{
						$lines = file(urlse.'/cgi/magick.pl/375/375/75/resource|'.$CAT_ARRAY[$input['resource_categoryID']]['categoryAlias'].'|'.$input['resource_subCategoryID'].'|1/'.$input[$upload]);
					}
				}
			}
			if(!empty($input['Alt'.$i]))
			{
				if(!empty($input['resource_resourceImage'.$i])) $input['resource_resourceImage'.$i] = $input['resource_resourceImage'.$i].'|';
				else $input['resource_resourceImage'.$i] = $input['resourceImageOld'.$i].'|';
				$explode = explode('|', $input['resource_resourceImage'.$i]);
				if(!empty($explode[1])) { $input[$upload] = $explode.'|'.$input['Alt'.$i]; }
				else { $input[$upload] .= $input['Alt'.$i]; }
			}
			$upload = '';
		}


		$upload = $input['tableName'].'_hitsalesImage';
		$upload_name = $input['tableName'].'_hitsalesImage_name';
		if(!empty($_FILES[$upload]['tmp_name']))
		{
			if($input[$input['tableName'].'_hitsalesType'] == 'hit')
			{
				$ext = explode('.',$_FILES[$upload]['name']);
				$ext = '.'.$ext[count($ext)-1];
				$name = $input['resource_resourceAlias'].'-'.$resourceID;

				$input[$upload] = 'hitsales-'.$name.$ext;
				$uploadPath = url_upload."resource/".$CAT_ARRAY[$input['resource_categoryID']]['categoryAlias']."/".$input['resource_subCategoryID']."/2/".$input[$upload];

				if(!copy($_FILES[$upload]['tmp_name'], $uploadPath))
				{
					echo 'Error: no image uploaded';
				}
				else
				{
					@ chmod($uploadPath, 0777);
					$lines = file(urlse.'/cgi/magick.pl/100/100/75/resource|'.$CAT_ARRAY[$input['resource_categoryID']]['categoryAlias'].'|'.$input['resource_subCategoryID'].'|2/'.$input[$upload]);
				}
			}
		}

		$upload = $input['tableName'].'_'.$input['tableName'].'Image';
		$upload_name = $input['tableName'].'_'.$input['tableName'].'Image_name';
		if (!empty($_FILES[$upload]['tmp_name']))
		{
			$ext = explode('.',$_FILES[$upload]['name']);
			$ext = '.'.$ext[count($ext)-1];
			$name = gen_alias($input['resource_resourceName'], 60, 50);
			$name .= '-'.date("is");
			$name .= '-'.$resourceID;

			$input[$upload] = $name.$ext;
			$uploadPath = url_upload."resource/".$CAT_ARRAY[$input['resource_categoryID']]['categoryAlias']."/".$input['resource_subCategoryID']."/1/".$input[$upload];

			if(!copy($_FILES[$upload]['tmp_name'], $uploadPath))
			{
				echo 'Error: no image uploaded';
			}
			else
			{
				copy($uploadPath, url_upload."resource/".$CAT_ARRAY[$input['resource_categoryID']]['categoryAlias']."/".$input['resource_subCategoryID']."/2/".$input[$upload]);
				@ chmod(url_upload."resource/".$CAT_ARRAY[$input['resource_categoryID']]['categoryAlias']."/".$input['resource_subCategoryID']."/1/".$input[$upload], 0777);
				@ chmod(url_upload."resource/".$CAT_ARRAY[$input['resource_categoryID']]['categoryAlias']."/".$input['resource_subCategoryID']."/2/".$input[$upload], 0777);
				$imgInfo = @ getimagesize($uploadPath);
				if($imgInfo[0] >= 150)
				{
					$lines = file(urlse.'/cgi/magick.pl/150/150/75/resource|'.$CAT_ARRAY[$input['resource_categoryID']]['categoryAlias'].'|'.$input['resource_subCategoryID'].'|2/'.$input[$upload]);
				}
				if($imgInfo[0] >= 800)
				{
					$lines = file(urlse.'/cgi/magick.pl/800/600/75/resource|'.$CAT_ARRAY[$input['resource_categoryID']]['categoryAlias'].'|'.$input['resource_subCategoryID'].'|1/'.$input[$upload]);
				}

				if($input[$input['tableName'].'_hitsalesType'] == 'hit' AND empty($input[$input['tableName'].'_hitsalesImage']) AND empty($input['entityImage']))
				{
					$input[$input['tableName'].'_hitsalesImage'] = 'hitsales-'.$input[$upload];
					$uploadHitsalesPath = url_upload."resource/".$CAT_ARRAY[$input['resource_categoryID']]['categoryAlias']."/".$input['resource_subCategoryID']."/2/hitsales-".$input[$upload];

					if(copy($_FILES[$upload]['tmp_name'], $uploadHitsalesPath))
					{
						@ chmod($uploadHitsalesPath, 0777);
						$lines = file(urlse.'/cgi/magick.pl/100/100/75/resource|'.$CAT_ARRAY[$input['resource_categoryID']]['categoryAlias'].'|'.$input['resource_subCategoryID'].'|1/'.$input[$input['tableName'].'_hitsalesImage']);
					}
				}
				elseif($input[$input['tableName'].'_hitsalesType'] == 'popular')
				{
					$input[$input['tableName'].'_hitsalesImage'] = $input[$upload];
				}
			}
		}

		if($input[$input['tableName'].'_hitsalesType'] != 'hit' AND empty($input[$input['tableName'].'_hitsalesImage']) AND !empty($input['copyImage'])) $input[$input['tableName'].'_hitsalesImage'] = $input['copyImage'];

		$input['auto_increment'] = 'yes';
		$systemMessage = saveData($input);
		if(!empty($input['entityID'])) $wareEntityID = $input['entityID']; else $wareEntityID = $globalInsertAutoID;

		if ($systemMessage != 'error')
		{
			if(!empty($input['entityID']) AND ($input['resource_categoryID'] != $input['compareCategoryID'] OR $input['resource_subCategoryID'] != $input['compareSubCategoryID']))
			{
				$inputResource['tableName'] = 'resource';
				$inputResource['select'] = 'resourceID, categoryID, subCategoryID, resourceImage, hitsalesImage'; for($img=1; $img <= $COUNT_ADD_IMAGE; $img++) { $inputResource['select'] .= ', resourceImage'.$img; }
				$inputResource['filter_resourceID'] = $input['entityID'];
				$inputResource['filter'] = getFilter($inputResource);
				$outputResource = getData($inputResource);
				$inputResource = '';

				// main img
				$oldImgPath = url_upload."resource/".$CAT_ARRAY[$input['compareCategoryID']]['categoryAlias']."/".$input['compareSubCategoryID']."/1/".$outputResource[0]['resourceImage'];
				$newImgPath = url_upload."resource/".$CAT_ARRAY[$outputResource[0]['categoryID']]['categoryAlias']."/".$outputResource[0]['subCategoryID']."/1/".$outputResource[0]['resourceImage'];
				if(!empty($outputResource[0]['resourceImage']) AND file_exists($oldImgPath) AND !file_exists($newImgPath))
				{
					if( copy($oldImgPath, $newImgPath)) { @ chmod($newImgPath, 0777); @ unlink($oldImgPath); }
				}

				$oldImgPath = url_upload."resource/".$CAT_ARRAY[$input['compareCategoryID']]['categoryAlias']."/".$input['compareSubCategoryID']."/2/".$outputResource[0]['resourceImage'];
				$newImgPath = url_upload."resource/".$CAT_ARRAY[$outputResource[0]['categoryID']]['categoryAlias']."/".$outputResource[0]['subCategoryID']."/2/".$outputResource[0]['resourceImage'];
				if(!empty($outputResource[0]['resourceImage']) AND file_exists($oldImgPath) AND !file_exists($newImgPath))
				{
					if(@ copy($oldImgPath, $newImgPath)) { @ chmod($newImgPath, 0777); @ unlink($oldImgPath); }
				}

				// hit img
				$oldImgPath = url_upload."resource/".$CAT_ARRAY[$input['compareCategoryID']]['categoryAlias']."/".$input['compareSubCategoryID']."/2/".$outputResource[0]['hitsalesImage'];
				$newImgPath = url_upload."resource/".$CAT_ARRAY[$outputResource[0]['categoryID']]['categoryAlias']."/".$outputResource[0]['subCategoryID']."/2/".$outputResource[0]['hitsalesImage'];
				if(!empty($outputResource[0]['hitsalesImage']) AND file_exists($oldImgPath) AND !file_exists($newImgPath))
				{
					if(@ copy($oldImgPath, $newImgPath)) { @ chmod($newImgPath, 0777); @ unlink($oldImgPath); }
				}

				$oldImgPath = url_upload."resource/".$CAT_ARRAY[$input['compareCategoryID']]['categoryAlias']."/".$input['compareSubCategoryID']."/2/hitsales-".$outputResource[0]['resourceImage'];
				$newImgPath = url_upload."resource/".$CAT_ARRAY[$outputResource[0]['categoryID']]['categoryAlias']."/".$outputResource[0]['subCategoryID']."/2/hitsales-".$outputResource[0]['resourceImage'];
				if(!empty($outputResource[0]['resourceImage']) AND file_exists($oldImgPath) AND !file_exists($newImgPath))
				{
					if(@ copy($oldImgPath, $newImgPath)) { @ chmod($newImgPath, 0777); @ unlink($oldImgPath); }
				}

				// add img
				for($img=1; $img <= $COUNT_ADD_IMAGE; $img++)
				{
					$explode = explode('|', $outputResource[0]['resourceImage'.$img]);
					if(!empty($explode[0]))
					{
						$oldImgPath = url_upload."resource/".$CAT_ARRAY[$input['compareCategoryID']]['categoryAlias']."/".$input['compareSubCategoryID']."/1/".$explode[0];
						$newImgPath = url_upload."resource/".$CAT_ARRAY[$outputResource[0]['categoryID']]['categoryAlias']."/".$outputResource[0]['subCategoryID']."/1/".$explode[0];

						if(file_exists($oldImgPath) AND !file_exists($newImgPath))
						{

							if(@ copy($oldImgPath, $newImgPath)) { @ chmod($newImgPath, 0777); @ unlink($oldImgPath); }
						}

						$oldImgPath = url_upload."resource/".$CAT_ARRAY[$input['compareCategoryID']]['categoryAlias']."/".$input['compareSubCategoryID']."/2/".$explode[0];
						$newImgPath = url_upload."resource/".$CAT_ARRAY[$outputResource[0]['categoryID']]['categoryAlias']."/".$outputResource[0]['subCategoryID']."/2/".$explode[0];
						if(file_exists($oldImgPath) AND !file_exists($newImgPath))
						{
							if(@ copy($oldImgPath, $newImgPath)) { @ chmod($newImgPath, 0777); @ unlink($oldImgPath); }
						}
					}
				}
			}


			for($i=0; $i<$outputTableCategory['rows']; $i++){
				$cat2dept[$outputTableCategory[$i]['categoryID']] = $outputTableCategory[$i];
			}

			$get['tableName'] = 'resource';
			$get['filter'] = "AND resourceSelected = 1";
			$get['sort'] = "order by timeSaved DESC";
			$outputRes = getData($get);
			$get = '';

			if(!empty($outputRes['rows'])){
				$xml_arr = array();
				for($i=0; $i<$outputRes['rows']; $i++){
					if(!empty($outputRes[$i]['resourceImage'])){
						if(!empty($outputRes[$i]['resourceBrand']))	$insBrand = $brandsArray[$outputRes[$i]['resourceBrand']]['brandAlias'].'-';
						else $insBrand = '';
						$xml_arr[$cat2dept[$outputRes[$i]['categoryID']]['categoryDepartment']] .= '<photo image="../../images/resource/'.$cat2dept[$outputRes[$i]['categoryID']]['categoryAlias'].'/'.$outputRes[$i]['subCategoryID'].'/2/'.$outputRes[$i]['resourceImage'].'" target="_self" url="/'.$cat2dept[$outputRes[$i]['subCategoryID']]['categoryAlias'].'/'.$outputRes[$i]['resourceAlias'].'-'.$insBrand.$outputRes[$i]['resourceID'].'"><![CDATA['.$outputRes[$i]['resourceName'].']]></photo>'.chr(10);
					}
				}
			}
			foreach($xml_arr as $dept=>$string){
				$xml_str = '';
				$xml_str = "<slideshow>\n".$string."</slideshow>\n";
				$fileName = 'images_'.$dept.'.xml';
				$file = fopen(pathcore.'js/scroller/'.$fileName, w);
				fwrite($file, $xml_str);
				fclose($file);
				@ chmod(pathcore.'js/scroller/'.$fileName, 0777);
			}

		}
		/*
		if ($systemMessage != 'error' AND $input[$input['tableName'].'_hitsalesType'] != 'usual' AND !empty($wareEntityID))
		{

			$inputResource['tableName'] = 'hitsales';
			$inputResource['filter_wareID'] = $wareEntityID;
			$inputResource['filter'] = getFilter($inputResource);
			$outputWare = getData($inputResource);
			$inputResource = '';

			$input['hitsales_hitsalesCategoryID'] = $input['resource_categoryID'];
			$input['hitsales_hitsalesCategoryAlias'] = $CAT_ARRAY[$input['resource_categoryID']]['categoryAlias'];
			$input['hitsales_hitsalesSubCategoryID'] = $input['resource_subCategoryID'];
			$input['hitsales_hitsalesSubCategoryAlias'] = $CAT_ARRAY[$input['resource_subCategoryID']]['categoryAlias'];
			$input['hitsales_hitsalesBrand'] = $currentBrand['brandAlias'];
			$input['hitsales_hitsalesCurrency'] = $currentBrand['brandCurrency'];
			$input['hitsales_wareID'] = $wareEntityID;
			$input['hitsales_hitsalesAlias'] = $input[$input['tableName'].'_'.$input['tableName'].'Alias'];
			$input['hitsales_permAll'] = $input[$input['tableName'].'_permAll'];
			$input['hitsales_hitsalesType'] = $input[$input['tableName'].'_hitsalesType'];
			$input['hitsales_hitsalesName'] = $input[$input['tableName'].'_'.$input['tableName'].'Name'];
			$input['hitsales_hitsalesTitle'] = $input[$input['tableName'].'_hitsalesTitle'];
			$input['hitsales_hitsalesPrice'] = $input[$input['tableName'].'_'.$input['tableName'].'Price'];

			if(!empty($input[$input['tableName'].'_hitsalesNote'])) $input['hitsales_hitsalesNote'] = $input[$input['tableName'].'_hitsalesNote'];
			else $input['hitsales_hitsalesNote'] = $input['resource_resourceDescription'];

			if(!empty($input[$input['tableName'].'_hitsalesImage'])) { $input['hitsales_hitsalesImage'] = $input[$input['tableName'].'_hitsalesImage']; }
			elseif(!empty($input['entityImage'])) { $input['hitsales_hitsalesImage'] = $input['entityImage']; }
			elseif(!empty($input['copyImage']))
			{
				if($input[$input['tableName'].'_hitsalesType'] == 'hit')
				{
					$sourcePath = url_upload."resource/".$CAT_ARRAY[$input['resource_categoryID']]['categoryAlias']."/".$input['resource_subCategoryID']."/1/".$input['copyImage'];
					$resultPath = url_upload."resource/".$CAT_ARRAY[$input['resource_categoryID']]['categoryAlias']."/".$input['resource_subCategoryID']."/2/hitsales-".$input['copyImage'];
					@ chmod($resultPath, 0777);

					if(copy($sourcePath, $resultPath))
					{
						@ chmod($resultPath, 0777);
						$input['hitsales_hitsalesImage'] = "hitsales-".$input['copyImage'];
						$lines = file(urlse.'/cgi/magick.pl/100/100/75/resource|'.$CAT_ARRAY[$input['resource_categoryID']]['categoryAlias'].'|'.$input['resource_subCategoryID'].'|2/'.$input['hitsales_hitsalesImage']);
					}
				}
			}

			if(!empty($outputWare[0]['hitsalesID'])) { $input['entityID'] = $outputWare[0]['hitsalesID']; }
			else { $input['entityID'] = ''; }

			if(!empty($input['hitsales_hitsalesNote']) AND !empty($input['hitsales_hitsalesImage']))
			{
				$input['tableName'] = 'hitsales';
				$systemMessageHit = saveData($input);
				//print_r($input);print_r('<br>***<br>');

				if($systemMessageHit != 'error')
				{
					$inputSave['tableName'] = 'resource';
					$inputSave['entityID'] = $wareEntityID;
					$inputSave['resource_hitsalesImage'] = $input['hitsales_hitsalesImage'];
					saveData($inputSave);
					$inputSave = '';
				}
			}
			else
			{
				//if(empty($input['hitsales_hitsalesBrand'])) $hitsalesSaveNote .= " Не выбран бренд.";
				if(empty($input['hitsales_hitsalesNote'])) $hitsalesSaveNote .= " Не заполнено описание.";
				if(empty($input['hitsales_hitsalesImage']) AND empty($input['entityImage'])) $hitsalesSaveNote .= " Не выбрано фото.";
				$hitsalesSaveResult = "<div style='text-align:center;color:#FF0000;'>Ошибка! ".$hitsalesSaveNote." Тип товара не сохранён.</div>";
			}
		}
		elseif ($systemMessage != 'error' AND !empty($wareEntityID))
		{
			$inputSave['tableName'] = 'resource';
			$inputSave['entityID'] = $wareEntityID;
			$inputSave['resource_hitsalesImage'] = '';
			saveData($inputSave);
			$inputSave = '';

			$inputDelHit['tableName'] = 'hitsales';
			$inputDelHit['filter_wareID'] = $wareEntityID;
			$inputDelHit['filter'] = getFilter($inputDelHit);
			$outputDelHit = getData($inputDelHit);
			delData($inputDelHit);
			$inputDelHit = '';

			if($outputDelHit[0]['hitsalesType'] == 'hit' AND !empty($outputDelHit[0]['hitsalesImage']))
			{
				if(strpos($outputDelHit[0]['hitsalesImage'],'hitsales-') !== false)
				{
					@ unlink(url_upload."resource/".$outputDelHit[0]['hitsalesCategoryAlias']."/".$outputDelHit[0]['hitsalesSubCategoryID']."/2/".$outputDelHit[0]['hitsalesImage']);
				}
			}
		}
		*/
		$input = '';
	}

	if(!empty($getvar['resource']))
	{
		if(!empty($getvar['remove']))
		{
			$input['tableName'] = 'resource';
			$input['select'] = 'resourceID, categoryID, subCategoryID';
			$input['filter_resourceID'] = $getvar['resource'];
			$input['filter'] = getFilter($input);
			$outputRes = getData($input);
			$input = '';

			$imgNameRemove = url_upload."resource/".$CAT_ARRAY[$outputRes[0]['categoryID']]['categoryAlias']."/".$CAT_ARRAY[$outputRes[0]['subCategoryID']]['categoryID']."/1/".$getvar['remove'];
			$imgPrevRemove = url_upload."resource/".$CAT_ARRAY[$outputRes[0]['categoryID']]['categoryAlias']."/".$CAT_ARRAY[$outputRes[0]['subCategoryID']]['categoryID']."/2/".$getvar['remove'];

			@ chmod($imgNameRemove, 0777);
			@ chmod($imgPrevRemove, 0777);

			if(@ unlink($imgPrevRemove) OR !file_exists($imgPrevRemove))
			{
				@ unlink($imgNameRemove);
				$input['entityID'] = $getvar['resource'];
				$input['resource_resourceImage'.$getvar['image']] = '';
				$input['tableName'] = 'resource';
				saveData($input);
			}
			header("Location: ".$_SERVER['HTTP_REFERER']);
			$input ='';
		}

		$input['tableName'] = 'resource';
		$input['filter_resourceID'] = $getvar['resource'];
		$input['filter'] = getFilter($input);
		$outputResource = getData($input);
		$outputResource = $outputResource[0];
		$input = '';

		/* ================================== */

		if($outputResource['categoryID'] != $getvar['category'] OR $outputResource['subCategoryID'] != $getvar['sub'])
		{
			$filerBrand = ''; $OR = '';$FLAG = false;
			if(!empty($outputResource['subCategoryID'])) $explodeBrand = explode('|',$CAT_ARRAY[$outputResource['subCategoryID']]['categoryBrand']); elseif(!empty($outputResource['categoryID'])) $explodeBrand = explode('|',$CAT_ARRAY[$outputResource['categoryID']]['categoryBrand']); else $explodeBrand = explode('|',$CAT_ARRAY[$getvar['sub']]['categoryBrand']);
			for($i=1; $i < count($explodeBrand)-1; $i++)
			{
				$filerBrand .= $OR."`brandID` = ".$explodeBrand[$i];
				$OR = " OR ";
				$FLAG = true;
			}

			$inputBrand['tableName'] = 'brand';
			$inputBrand['select'] = 'brandID, brandAlias, brandName, brandCurrency';
			if($FLAG) $inputBrand['filter'] = " AND (".$filerBrand.")"; else $inputBrand['filter'] = " AND 2=1 ";
			$inputBrand['sort'] = " ORDER BY BINARY(LOWER(LEFT(brandName, 10))) ";
			$outputBrand = getData($inputBrand);
			$inputBrand = '';

			for($b=0; $b < $outputBrand['rows']; $b++)
			{
				$ddBrand[$outputBrand[$b]['brandID']] = $outputBrand[$b]['brandName'];
				if($outputBrand[$b]['brandID'] == $input[$input['tableName'].'_'.$input['tableName'].'Brand'] AND !empty($input[$input['tableName'].'_'.$input['tableName'].'Brand'])) $currentBrand = $outputBrand[$b];
			}
		}

		/* ================================== */
	}

	$input['tableName'] = 'department';
	$input['select'] = 'departmentID, departmentName';
	if(!empty($getvar['dept'])) $input['filter'] .= " AND departmentID = '".$getvar['dept']."' ";
	$outputDepartment = getData($input);
	$outputDepartment = $outputDepartment[0];
	$input = '';
}

if ($url == 'manageResources')
{
	if($input['viewMode'] == "saveArray")
	{
		$input['auto_increment'] = 'yes';
		saveArray($input);
	}

	$input['tableName'] = "resource";
	$input['filter_categoryID'] = $getvar['category'];
	$input['filter_subCategoryID'] = $getvar['sub'];
	if(!empty($getvar['brand'])) $input['filter_resourceBrand'] = $getvar['brand'];
	$input['filter'] = getFilter($input);
	$input['select'] = 'count(permAll)';
	$outputCount = getData($input);
	$input = '';

			$numPage = $getvar['page'];
			if($numPage == 'all') {$numPage = 1; $viewModePage = 'all';}
			if(empty($numPage)) {$numPage = 1;}
			$countEntity = 12;
			$limit = $countEntity;
			if($viewModePage == 'all'){$startPos = 0; $limit = $outputCount[0]['count(permAll)'];}

			$countPages = ceil($outputCount[0]['count(permAll)']/$countEntity);
			if($numPage == 1)
			{ $startPos = 0; } else { $startPos = $numPage*$countEntity - $countEntity; }
			if($startPos + $countEntity > $outputCount[0]['count(permAll)'])
			{ $maxPos = $outputCount[0]['count(permAll)']; } else { $maxPos = $startPos + $countEntity; }

	$input['tableName'] = "resource";
	$input['filter_categoryID'] = $getvar['category'];
	$input['filter_subCategoryID'] = $getvar['sub'];
	if(!empty($getvar['brand'])) $input['filter_resourceBrand'] = $getvar['brand'];
	$input['filter'] = getFilter($input);
	$input['sort_resourcePosition'] = 'asc';
	$input['sort'] = sortData($input);
	$input['limit'] = ' limit '.$startPos.', '.$limit;
	$outputResource = getData($input);
	$input = "";

	$input['tableName'] = "category";
	$input['select'] = 'categoryID, categoryAlias, categoryName';
	$input['filter_categoryID'] = $getvar['category'];
	$input['filter'] = getFilter($input);
	$currentCat = getData($input);
	$input = '';

	$input['tableName'] = "category";
	$input['select'] = 'categoryID, categoryName, categoryBrand';
	$input['filter_categoryID'] = $getvar['sub'];
	$input['filter'] = getFilter($input);
	$currentSub = getData($input);
	$input = '';

	$filerBrand = ''; $OR = '';$FLAG = false;
	$explodeBrand = explode('|',$currentSub[0]['categoryBrand']);
	for($i=1; $i < count($explodeBrand)-1; $i++)
	{
		$filerBrand .= $OR."`brandID` = ".$explodeBrand[$i];
		$OR = " OR ";
		$FLAG = true;
	}

	$inputBrand['tableName'] = 'brand';
	$inputBrand['select'] = 'brandID, brandAlias, brandName, brandCurrency';
	if($FLAG) $inputBrand['filter'] = " AND (".$filerBrand.")"; else $inputBrand['filter'] = " AND 2=1 ";
	$inputBrand['sort'] = " ORDER BY BINARY(LOWER(LEFT(brandName, 10))) ";
	$outputBrand = getData($inputBrand);
	$inputBrand = '';

	for($b=0; $b < $outputBrand['rows']; $b++)
	{
		$ddBrand[$outputBrand[$b]['brandID']] = $outputBrand[$b]['brandName'];
	}

	$input['tableName'] = 'department';
	$input['select'] = 'departmentID, departmentName';
	if(!empty($getvar['dept'])) $input['filter'] .= " AND departmentID = '".$getvar['dept']."' ";
	$outputDepartment = getData($input);
	$outputDepartment = $outputDepartment[0];
	$input = '';
}
/*
$input = $_POST;
if ($url == 'manageHits' OR $url == 'manageNovelties' OR $url == 'managePopulars')
{
	if(!empty($input['filter']) OR !empty($filter))
	{
		if(!empty($input['Submit'])) {$filter = $input['filter']; }
		if(!empty($filter)) $input['filter'] = $filter;
		if(!empty($input['filter']) AND $input['filter'] != 'all')
		{
			$input['filter_hitsalesCategoryID'] = $input['filter'];
			$input['filter'] = getFilter($input);
			$currrentFilter = $input['filter'];
		}
	}

	if ($input['viewMode']=='saveArray') { saveArray($input); }

	if($url == 'manageHits') $type = 'hit';
	if($url == 'manageNovelties') $type = 'new';
	if($url == 'managePopulars') $type = 'popular';

	$input['tableName'] = 'hitsales';
	$input['select'] = 'count(permAll)';
	$input['filter'] = '';
	$input['filter_hitsalesType'] = $type;
	$input['filter'] = getFilter($input);
	$input['filter'] .= $currrentFilter;
	$outputCount = getData($input);
	$input = '';

			$numPage = $getvar['page'];
			if($numPage == 'all') {$numPage = 1; $viewModePage = 'all';}
			if(empty($numPage)) {$numPage = 1;}
			$countEntity = 10;
			$limit = $countEntity;
			if($viewModePage == 'all'){$startPos = 0; $limit = $outputCount[0]['count(permAll)'];}

			$countPages = ceil($outputCount[0]['count(permAll)']/$countEntity);
			if($numPage == 1)
				{ $startPos = 0; } else { $startPos = $numPage*$countEntity - $countEntity; }
			if($startPos + $countEntity > $outputCount[0]['count(permAll)'])
				{ $maxPos = $outputCount[0]['count(permAll)']; } else { $maxPos = $startPos + $countEntity; }

	$input['tableName'] = 'hitsales';
	$input['filter_hitsalesType'] = $type;
	$input['filter'] = getFilter($input);
	$input['filter'] .= $currrentFilter;
	$input['sort_hitsalesPosition'] = 'asc';
	$input['sort'] = sortData($input);
	$input['limit'] = ' limit '.$startPos.', '.$limit;
	$output = getData($input);
	$input = '';

	$inputCat['tableName'] = "category";
	$inputCat['select'] = "categoryID, categoryAlias, categoryName, parentCategoryID";
	$inputCat['sort'] = ' ORDER BY BINARY(LOWER(LEFT(categoryName, 10))) ';
	$outputTableCategory = getData($inputCat);
	for ($i=0; $i < $outputTableCategory['rows']; $i++)
	{
		$CAT_ARRAY[$outputTableCategory[$i]['categoryID']] = $outputTableCategory[$i];
		if($outputTableCategory[$i]['parentCategoryID'] == 'top')
		{
			$outputCat[] = $outputTableCategory[$i];
		}
	}
	$outputCat['rows'] = count($outputCat);
	$inputCat = '';

	// GET SUBCATEGORY
	$ddData['all'] = '-- выбрать --';
	for ($cat=0; $cat < $outputCat['rows']; $cat++)
	{
		$ddData[$outputCat[$cat]['categoryID']] = $outputCat[$cat]['categoryName'];
		for ($i=0; $i < $outputTableCategory['rows']; $i++)
		{
			if($outputTableCategory[$i]['parentCategoryID'] == $outputCat[$cat]['categoryID'])
			{
				$outputSubCat[$outputCat[$cat]['categoryID']][] = $outputTableCategory[$i];
			}
		}
		$outputSubCat[$outputCat[$cat]['categoryID']]['rows'] = count($outputSubCat[$outputCat[$cat]['categoryID']]);
	}
}
*/

if ($url == 'manageBrands')
{
	// GET ACTIVE LETTERS
	$input['tableName'] = 'brand';
	$input['select'] = 'brandName';
	$input['sort'] = 'ORDER BY BINARY(LOWER(LEFT(brandName, 10)))';
	$outputBrandLetter = getData($input);
	$input = '';

	$countBrands = $outputBrandLetter['rows'];

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

	// GET FILTER
	if(empty($getvar['letter'])) $getvar['letter'] = $ACTIVE_LETTERS{1};

	if($getvar['letter'] == 'ru')
	{
		$filter = " AND (brandName regexp '^[а-яА-Я].*')";
	}
	else
	{
		$filter = " AND (brandName regexp '^".$getvar['letter'].".*')";
	}

	if($getvar['status'] == 'active') $filter .= 'AND permAll=\'1\'';
	elseif($getvar['status'] == 'hidden') $filter .= 'AND permAll=\'0\'';

	$input['tableName'] = 'brand';
	$input['filter'] = $filter;
	$input['select'] = 'count(permAll)';
	$outputCount = getData($input);
	$input = '';

	$numPage = $getvar['page'];
	if(empty($numPage)) {$numPage = 1;}
	$countEntity = 1000;
	if($numPage == 1)
	{ $startPos = 0; } else { $startPos = $numPage*$countEntity - $countEntity; }

	$input['tableName'] = 'brand';
	$input['filter'] = $filter;
	$input['sort'] = " ORDER BY BINARY(LOWER(LEFT(brandName, 10))) ";
	$input['limit'] = ' limit '.$startPos.', '.$countEntity;
	$output = getData($input);
	$input = '';
}

if ($url == 'manageBrand')
{
	if(!empty($getvar['page'])) $INCpage = '/page/'.$getvar['page'];
	if(!empty($getvar['status'])) $INCstatus = '/status/'.$getvar['status'];
	if(!empty($getvar['letter'])) $INCletter = '/letter/'.$getvar['letter'];

	if ($input['viewMode']=='save')
	{
		$input[$input['tableName'].'_'.$input['tableName'].'Name'] = trim($input[$input['tableName'].'_'.$input['tableName'].'Name']);
		$input[$input['tableName'].'_'.$input['tableName'].'Name'] = str_replace("'","`",$input[$input['tableName'].'_'.$input['tableName'].'Name']);
		$input[$input['tableName'].'_'.$input['tableName'].'Name'] = str_replace('"','&quot;',$input[$input['tableName'].'_'.$input['tableName'].'Name']);

		//generate alias
		if(empty($input['entityID']))
		{
			$input[$input['tableName'].'_'.$input['tableName'].'Alias'] = gen_alias($input[$input['tableName'].'_'.$input['tableName'].'Name'],60,50);
		}

		if(empty($input['entityID']))
		{
			$inputCompare['tableName'] = "brand";
			$inputCompare['filter'] = " AND (brandAlias = '".$input['brand_brandAlias']."')";
			$outputCompare = getData($inputCompare);
			$inputCompare = '';

			if($outputCompare['rows'] > 0)
			{
				$_FILES[$input['tableName'].'_'.$input['tableName'].'Image']['tmp_name'] = '';
				if($outputCompare[0]['brandAlias'] == $input['brand_brandAlias']) $messageText = 'Совпадение в поле "Псевдоним".';
				$systemMessage = 'error';
			}
		}

		$upload = $input['tableName'].'_'.$input['tableName'].'Image';
		$upload_name = $input['tableName'].'_'.$input['tableName'].'Image_name';
		if(!empty($_FILES[$upload]['tmp_name']))
		{
			$ext = explode('.',$_FILES[$upload]['name']);
			$ext = '.'.$ext[count($ext)-1];
			$name = $input['brand_brandAlias'];

			$input[$upload] = $name.'-logo'.$ext;
			$uploadPath = url_upload."brand/".$input[$upload];

			if(!copy($_FILES[$upload]['tmp_name'], $uploadPath))
			{
				echo 'Error: no image uploaded';
			}
			else
			{
				@ chmod($uploadPath, 0777);
				$imgInfo = @ getimagesize($uploadPath);
				if($imgInfo[0] > 125)
				{
					$lines = file(urlse.'/cgi/magick.pl/125/125/75/brand/'.$input[$upload]);
				}
			}
		}

		$input['auto_increment'] = 'yes';
		if($systemMessage != 'error') $systemMessage = saveData($input);
		$input = '';
	}

	if(!empty($getvar['brand']))
	{

		if(!empty($getvar['remove']))
		{
			if(@ unlink('../images/brand/'.$getvar['remove']) OR !file_exists('../images/brand/'.$getvar['remove']))
			{
				$input['entityID'] = $getvar['brand'];
				$input['brand_brandImage'] = '';
				$input['tableName'] = 'brand';
				saveData($input);
				$input ='';
			}
			header("Location: ".urlse."/adm/?manageBrand/brand/".$getvar['brand'].$INCstatus.$INCletter.$INCpage);
			//header("Location: ".$_SERVER['HTTP_REFERER']);
		}

		$input['tableName'] = 'brand';
		$input['filter_brandID'] = $getvar['brand'];
		$input['filter'] = getFilter($input);
		$output = getData($input);
		$output = $output[0];
		$input = '';
	}
}

if ($url == 'managePrice' OR $url == 'quickEditor')
{
	$inputCat = '';
	$inputCat['tableName'] = "category";
	$inputCat['sort'] = ' ORDER BY BINARY(LOWER(LEFT(categoryName, 10))) ';
	//$inputCat['sort_categoryPosition'] = 'asc';
	//$inputCat['sort'] = sortData($inputCat);
	$outputTableCategory = getData($inputCat);
	for ($i=0; $i < $outputTableCategory['rows']; $i++)
	{
		$CAT_ARRAY[$outputTableCategory[$i]['categoryID']] = $outputTableCategory[$i];
		if($outputTableCategory[$i]['parentCategoryID'] == 'top')
		{
			$outputCat[] = $outputTableCategory[$i];
		}
	}
	$outputCat['rows'] = count($outputCat);
	$inputCat = '';

	// GET SUBCATEGORY
	for ($cat=0; $cat < $outputCat['rows']; $cat++)
	{
		for ($i=0; $i < $outputTableCategory['rows']; $i++)
		{
			if($outputTableCategory[$i]['parentCategoryID'] == $outputCat[$cat]['categoryID'])
			{
				$outputSubCat[$outputCat[$cat]['categoryID']][] = $outputTableCategory[$i];
			}
		}
		$outputSubCat[$outputCat[$cat]['categoryID']]['rows'] = count($outputSubCat[$outputCat[$cat]['categoryID']]);
	}
}

// call saveArray from form
if ($input['viewMode']=='saveArray')
{
	//print_r('<br>***<br>');
	//print_r($input);
	//print_r('<br>***<br>');
	// set courseUSD
	if(empty($input['arrayID']))
	{
		$systemMessages['nowares'] = 'active';
		$input = '';
	}
	else
	{
		if($url == "managePrice")
		{
			foreach($input['arrayID'] as $key=>$val)
			{
				if(!empty($input['managerPrice'][$key]) AND $input['dateCompare'][$key] != $input['resource_datePrice'][$key])
				{
					$inputCompare['tableName'] = 'resource';
					$inputCompare['filter_resourceID'] = $input['arrayID'][$key];
					$inputCompare['filter'] = getFilter($inputCompare);
					$inputCompare['select'] = 'userID, resourceID, presence, datePrice';
					$outputCompare = getData($inputCompare);
					$inputCompare = '';

					$explodeDate = @explode('|',$outputCompare[0]['datePrice']);
					if($outputCompare[0]['presence'] != $input['resource_presence'][$key]) $explodeDate[1]  = '';
					$input['resource_datePrice'][$key] = $input['resource_datePrice'][$key].'|'.$explodeDate[1];

					if(empty($outputCompare[0]['resourceID']))
					{
						if($input['resource_presence'][$key] == '2') $inputCompare['resource_userID'] = $userArray['userID'].'||||&'.$userArray['userID'];
						else $inputCompare['resource_userID'] = $userArray['userID'];
					}
					else
					{
						$arrayCreatedSaved = explode('||',$outputCompare[0]['userID']);
						if(empty($arrayCreatedSaved[0]))
						{
							if($outputCompare[0]['presence'] != '2' AND $input['resource_presence'][$key] == '2') $inputCompare['resource_userID'] = '||'.$userArray['userID'].'||&'.$userArray['userID'];
							elseif($outputCompare[0]['presence'] == '2' AND $input['resource_presence'][$key] == '2') $inputCompare['resource_userID'] = '||'.$userArray['userID'].'||'.$arrayCreatedSaved[2];
							else $inputCompare['resource_userID'] = '||'.$userArray['userID'];
						}
						else
						{
							if($outputCompare[0]['presence'] != '2' AND $input['resource_presence'][$key] == '2') $inputCompare['resource_userID'] = $arrayCreatedSaved[0].'||'.$userArray['userID'].'||&'.$userArray['userID'];
							elseif($outputCompare[0]['presence'] == '2' AND $input['resource_presence'][$key] == '2') $inputCompare['resource_userID'] = $arrayCreatedSaved[0].'||'.$userArray['userID'].'||'.$arrayCreatedSaved[2];
							else $inputCompare['resource_userID'] = $arrayCreatedSaved[0].'||'.$userArray['userID'];
						}
					}

					$inputCompare['tableName'] = 'resource';
					$inputCompare['entityID'] = $outputCompare[0]['resourceID'];
					saveData($inputCompare);
					$inputCompare = '';
				}
				else
				{
					$input['resource_datePrice'][$key] = $input['resource_datePrice'][$key].'|'.$input['datePresence'][$key];
				}
				//*************************************************
			}
		}
		elseif($url == "quickEditor" AND $input['search_imageshow'] == '1')
		{
			foreach($input['arrayID'] as $key=>$val)
			{
				$upload = $input['tableName'].'_'.$input['tableName'].'Image';
				$upload_name = $input['tableName'].'_'.$input['tableName'].'Image_name';
				if (!empty($_FILES[$upload]['tmp_name'][$key]))
				{
					$inputRes['tableName'] = 'resource';
					$inputRes['select'] = 'resourceID, resourceAlias, categoryID, subCategoryID';
					$inputRes['filter_resourceID'] = $val;
					$inputRes['filter'] = getFilter($inputRes);
					$outputRes = getData($inputRes);
					$inputRes = '';

					$ext = explode('.',$_FILES[$upload]['name'][$key]);
					$ext = '.'.$ext[count($ext)-1];
					$name = $outputRes[0]['resourceAlias'].'-'.$outputRes[0]['resourceID'];

					$input[$upload][$key] = $name.$ext;
					$uploadPath = url_upload.'resource/'.$CAT_ARRAY[$outputRes[0]['categoryID']]['categoryAlias'].'/'.$outputRes[0]['subCategoryID'].'/1/'.$input[$upload][$key];

					if(!copy($_FILES[$upload]['tmp_name'][$key], $uploadPath))
					{
						echo 'Error: no image uploaded';
					}
					else
					{

						copy($uploadPath, url_upload.'resource/'.$CAT_ARRAY[$outputRes[0]['categoryID']]['categoryAlias'].'/'.$outputRes[0]['subCategoryID'].'/2/'.$input[$upload][$key]);
						@ chmod(url_upload.'resource/'.$CAT_ARRAY[$outputRes[0]['categoryID']]['categoryAlias'].'/'.$outputRes[0]['subCategoryID'].'/1/'.$input[$upload][$key], 0777);
						@ chmod(url_upload.'resource/'.$CAT_ARRAY[$outputRes[0]['categoryID']]['categoryAlias'].'/'.$outputRes[0]['subCategoryID'].'/2/'.$input[$upload][$key], 0777);
						$imgInfo = @ getimagesize($uploadPath);
						if($imgInfo[0] >= 150)
						{
							$lines = file(urlse.'/cgi/magick.pl/150/150/75/resource|'.$CAT_ARRAY[$outputRes[0]['categoryID']]['categoryAlias'].'|'.$outputRes[0]['subCategoryID'].'|2/'.$input[$upload][$key]);
						}
						if($imgInfo[0] >= 375)
						{
							$lines = file(urlse.'/cgi/magick.pl/375/375/75/resource|'.$CAT_ARRAY[$outputRes[0]['categoryID']]['categoryAlias'].'|'.$outputRes[0]['subCategoryID'].'|1/'.$input[$upload][$key]);
						}
					}
				}
			}
		}
		$input['auto_increment'] = 'yes';
		saveArray($input);
	}
}

if ($url == 'managePrice' OR $url == 'quickEditor')
{
	//$_SESSION['SESSION_PRICE'] = '';
	if($input['viewMode'] != 'search' AND $input['viewMode2'] != 'search' AND $getvar['sort'] == 'name')
	{
		$input = $_SESSION['SESSION_PRICE']['input'];
	}
	if ($input['viewMode']=='search' OR $input['viewMode2']=='search')
	{
		//print_r('<br><br><br><br><br>');
		//print_r($_SESSION['SESSION_PRICE']['input']);print_r('<br>***<br>');
		//print_r($input);print_r('<br>***<br>');
		$_SESSION['SESSION_PRICE']['input'] = $input;

		if (!empty($input['search_category']))
		{
			$input['filter_categoryID'] = $input['search_category'];
			$input['filter'] = getFilter($input);
			$search_category = $input['search_category'];
		}

		if (!empty($input['search_sub']))
		{
			$input['filter_subCategoryID'] = $input['search_sub'];
			$input['filter'] = getFilter($input);
			$search_sub = $input['search_sub'];
		}

		$input['search_name'] = trim($input['search_name']);
		$input['search_name'] = eregi_replace("[  ]+"," ",$input['search_name']);
		if(!empty($input['search_name']))
		{
			$searchNameArray = explode(' ',$input['search_name']);
			$searchNameFilter = '';
			for($i=0; $i < count($searchNameArray); $i++)
			{
				$searchNameFilter .=  " AND (resourceName like '%".$searchNameArray[$i]."%' OR resourceDescription like '%".$searchNameArray[$i]."%')";
			}
			$input['filter'] .= $searchNameFilter;
			$search_name = $input['search_name'];
		}
		if (!isset($input['search_brand']) OR $input['search_brand'] == 'all')
		{
			$search_brand = 'all';
		}
		else
		{
			$input['filter'] .= " AND resourceBrand =".$input['search_brand'];
			$search_brand = $input['search_brand'];
		}
		if (!empty($input['search_minprice']) OR !empty($input['search_maxprice']))
		{
			if (empty($input['search_minprice'])){$input['search_minprice']=1;}
			if (empty($input['search_maxprice'])){$input['search_maxprice']=999999999;}
			settype ($input['search_minprice'] , integer);
			settype ($input['search_maxprice'] , integer);
			$input['filter'] .= " AND resourcePrice >=".$input['search_minprice']." AND resourcePrice <= ".$input['search_maxprice'];
			$search_minprice = $input['search_minprice'];
			$search_maxprice = $input['search_maxprice'];
		}
		if(!is_array($input['search_presence'])) $input['search_presence'] = explode('&',$input['search_presence']);
		if (!empty($input['search_presence'][0]) AND $input['search_presence'][0] != 'all')
		{
			$filterPresence = ''; $or = '';
			for($i=0; $i < count($input['search_presence']); $i++)
			{
				$filterPresence .= $or."presence = '".$input['search_presence'][$i]."'";
				$or = ' OR ';
			}
			if(!empty($filterPresence)) $input['filter'] .= " AND (".$filterPresence.")";
			$search_presence = implode('&',$input['search_presence']);
		}
		elseif($input['search_presence'][0] == 'all')
		{
			$search_presence = 'all';
		}

		$scat = $input['search_category'];
		$search_category = $input['search_category'];
		$search_sub = $input['search_sub'];
		$search_descriptionshow = $input['search_descriptionshow'];
		$search_imageshow = $input['search_imageshow'];

		if(empty($CAT_ARRAY[$search_category]['categoryDepartment']) OR ($CAT_ARRAY[$search_category]['categoryDepartment'] != '3' AND $userArray['userID'] == '444' OR $CAT_ARRAY[$search_category]['categoryDepartment'] == '3' AND $userArray['userID'] == '555'))
		{}
		else
		{

			$inputList['tableName'] = 'field';
			$inputList['filter_fieldCategory'] = $input['search_sub'];
			$inputList['filter_fieldQuickEditor'] = 1;
			$inputList['filter'] = getFilter($inputList);
			if(!empty($search_brand)) $inputList['filter'] .= ' AND (checkBrand = \'0\' OR fieldBrand like \'%|'.$search_brand.'|%\')';
			else $inputList['filter'] .= ' AND checkBrand = \'0\'';
			$outputList = getData($inputList);
			$inputList = '';


			//$input['select'] = ' resourceID, resourceName, resourcePrice, enterPrice, datePrice, timeSaved, resourcePosition, guarantee, presence, permAll, supplier, signedUsers, signedOrder, priceURL, userID';
			$input['select'] = 'resourceID, categoryID, subCategoryID, resourceImage, resourceName, resourceDescription, resourceBrand, resourcePrice, enterPrice, datePrice, timeSaved, resourcePosition, presence, permAll, userID';
			if($url == 'quickEditor')
			{
				for ($c=0; $c<$outputList['rows']; $c++)
				{
					$input['select'] .=', '.$outputList[$c]['fieldName'];
				}
			}
			if ($url == 'managePrice')
			{
				$input['filter'] .= " AND permAll = '1'";
			}

			$input['tableName'] = 'resource';
			if($getvar['sort'] == 'name') $input['sort'] = 'ORDER BY BINARY(LOWER(LEFT(resourceName, 20)))';
			else $input['sort'] = 'ORDER BY presence asc, resourcePosition asc';
			$output = getData($input);

			if(!empty($input['search_sub']))
			{
				$inputCatBrand['tableName'] = 'category';
				$inputCatBrand['filter_categoryID'] = $input['search_sub'];
				$inputCatBrand['filter'] = getFilter($inputCatBrand);
				$outputCatBrand = getData($inputCatBrand);
				$inputCatBrand = '';

				$filerBrand = ''; $OR = ''; $FLAG = false;
				$explodeBrand = explode('|',$outputCatBrand[0]['categoryBrand']);
				for($i=1; $i < count($explodeBrand)-1; $i++)
				{
					$filerBrand .= $OR."`brandID` = ".$explodeBrand[$i];
					$OR = " OR ";
					$FLAG = true;
				}

				$inputBrand['tableName'] = 'brand';
				if($FLAG) $inputBrand['filter'] = " AND (".$filerBrand.")";
				$inputBrand['select'] = 'brandID, brandName, brandCurrency';
				$outputddBrand = getData($inputBrand);
				$inputBrand = '';

				for($i=0; $i < $outputddBrand['rows']; $i++)
				{
					$ddBrand[$outputddBrand[$i]['brandID']] = $outputddBrand[$i]['brandName'];
				}
			}
		}

		$_SESSION["SESSION_PRICE"] = $SESSION_PRICE;
	}
}

if ($url == 'managePresence')
{
	if ($input['viewMode']=='change' AND !empty($input['change_brand']) AND !empty($input['change_presence']))
	{
		$change_brand = $input['change_brand'];
		$change_presence = $input['change_presence'];

		connectDB();
		$query = "UPDATE `table_resource` SET presence = '".$change_presence."' WHERE 1=1 AND resourceBrand = '".$change_brand."' AND presence != '".$change_presence."'";
		$result = @mysql_query($query);
		$rowsChanged = mysql_affected_rows();
	}

	$inputBrand['tableName'] = 'brand';
	$inputBrand['select'] = 'brandID, brandName';
	$inputBrand['sort'] = " ORDER BY BINARY(LOWER(LEFT(brandName, 10))) ";
	$outputBrand = getData($inputBrand);
	$inputBrand = '';

	for ($i=0; $i<$outputBrand['rows']; $i++)
	{
		$ddBrand[$outputBrand[$i]['brandID']] = $outputBrand[$i]['brandName'];
	}
}

/********** [ DEL DATA ] **********/
$FLAG_REFERER = false;
if (!empty($getvarFirst))
{
	$explodeFirst = explode ("-",$getvarFirst);
	$getvarEntity = $explodeFirst[1];
	if ($explodeFirst[0] == 'del')
	{
		$input['tableName'] = $getvarEntity;
		$input['filter_'.$getvarEntity.'ID'] = $getvar[$getvarFirst];
		$input['filter'] = getFilter($input);

		if($input['tableName'] == 'category') $delCategory = getData($input);
		if($input['tableName'] == 'resource') $delResource = getData($input);
		if($input['tableName'] == 'section') $delSection = getData($input);
		if($input['tableName'] == 'position') $delPosition = getData($input);
		if($input['tableName'] == 'hitsales') $delHitsales = getData($input);
		if($input['tableName'] == 'comment') $delComment = getData($input);
		if($input['tableName'] == 'brand') $delBrand = getData($input);

		delData($input);
		$input = '';

		// delete data
		if(!empty($delCategory[0]['categoryID']))
		{
			if($delCategory[0]['parentCategoryID'] == 'top')
			{
				$inputDelSub['tableName'] = 'category';
				$inputDelSub['filter_parentCategoryID'] = $delCategory[0]['categoryID'];
				$inputDelSub['filter'] = getFilter($inputDelSub);
				delData($inputDelSub);
				$inputDelSub = '';

				$inputDelHit['tableName'] = 'hitsales';
				$inputDelHit['filter_hitsalesCategoryID'] = $delCategory[0]['categoryID'];
				$inputDelHit['filter'] = getFilter($inputDelHit);
				delData($inputDelHit);
				$inputDelHit = '';

				if(!empty($delCategory[0]['categoryAlias'])) deleteDir(url_upload.'resource/'.$delCategory[0]['categoryAlias'].'/');
			}
			else
			{
				$inputCatSub['tableName'] = 'category';
				$inputCatSub['select'] = 'categoryID, categoryAlias';
				$inputCatSub['filter_categoryID'] = $delCategory[0]['parentCategoryID'];
				$inputCatSub['filter'] = getFilter($inputCatSub);
				$outputCatSub = getData($inputCatSub);
				$inputCatSub = '';

				$inputDelHit['tableName'] = 'hitsales';
				$inputDelHit['filter_hitsalesSubCategoryID'] = $delCategory[0]['categoryID'];
				$inputDelHit['filter'] = getFilter($inputDelHit);
				delData($inputDelHit);
				$inputDelHit = '';

				if(!empty($outputCatSub[0]['categoryAlias']) AND !empty($delCategory[0]['categoryID'])) deleteDir(url_upload.'resource/'.$outputCatSub[0]['categoryAlias'].'/'.$delCategory[0]['categoryID'].'/');
			}

			$inputDelRes['tableName'] = 'resource';
			if($delCategory[0]['parentCategoryID'] == 'top') $inputDelRes['filter_categoryID'] = $delCategory[0]['categoryID']; else $inputDelRes['filter_subCategoryID'] = $delCategory[0]['categoryID'];
			$inputDelRes['filter'] = getFilter($inputDelRes);
			$outputCatRes = getData($inputDelRes);
			delData($inputDelRes);
			$inputDelRes = '';

			for($d=0; $d < $outputCatRes['rows']; $d++)
			{
				$inputDelSec['tableName'] = 'section';
				$inputDelSec['filter_resourceID'] = $outputCatRes[$d]['resourceID'];
				$inputDelSec['filter'] = getFilter($inputDelSec);
				delData($inputDelSec);
				$inputDelSec = '';

				$inputDelPos['tableName'] = 'position';
				$inputDelPos['filter_resourceID'] =  $outputCatRes[$d]['resourceID'];
				$inputDelPos['filter'] = getFilter($inputDelPos);
				delData($inputDelPos);
				$inputDelPos = '';
			}

			$FLAG_REFERER = true;
		}

		if(!empty($delResource[0]['resourceID']))
		{
			$inputCatRes['tableName'] = 'category';
			$inputCatRes['select'] = 'categoryID, categoryAlias';
			$inputCatRes['filter_categoryID'] = $delResource[0]['categoryID'];
			$inputCatRes['filter'] = getFilter($inputCatRes);
			$outputCatRes = getData($inputCatRes);
			$inputCatRes = '';

			$inputDelHit['tableName'] = 'hitsales';
			$inputDelHit['filter_wareID'] = $delResource[0]['resourceID'];
			$inputDelHit['filter'] = getFilter($inputDelHit);
			delData($inputDelHit);
			$inputDelHit = '';

			$inputDelSec['tableName'] = 'section';
			$inputDelSec['filter_resourceID'] = $delResource[0]['resourceID'];
			$inputDelSec['filter'] = getFilter($inputDelSec);
			delData($inputDelSec);
			$inputDelSec = '';

			$inputDelPos['tableName'] = 'position';
			$inputDelPos['filter_resourceID'] = $delResource[0]['resourceID'];
			$inputDelPos['filter'] = getFilter($inputDelPos);
			$outputPosRes = getData($inputDelPos);
			delData($inputDelPos);
			$inputDelPos = '';

			$inputDelComment['tableName'] = 'comment';
			$inputDelComment['filter_commentType'] = 'resource';
			$inputDelComment['filter_wareID'] = $delResource[0]['resourceID'];
			$inputDelComment['filter'] = getFilter($inputDelComment);
			delData($inputDelComment);
			$inputDelComment = '';

			if(!empty($delResource[0]['resourceImage']))
			{
				@ unlink(url_upload."resource/".$outputCatRes[0]['categoryAlias']."/".$delResource[0]['subCategoryID']."/1/".$delResource[0]['resourceImage']);
				@ unlink(url_upload."resource/".$outputCatRes[0]['categoryAlias']."/".$delResource[0]['subCategoryID']."/2/".$delResource[0]['resourceImage']);
			}

			if(!empty($delResource[0]['hitsalesImage']))
			{
				@ unlink(url_upload."resource/".$outputCatRes[0]['categoryAlias']."/".$delResource[0]['subCategoryID']."/2/".$delResource[0]['hitsalesImage']);
			}

			for($img=1; $img <= $COUNT_ADD_IMAGE; $img++)
			{
				$explode = explode('|', $delResource[0]['resourceImage'.$img]);
				if(!empty($explode[0]))
				{
					@ unlink(url_upload."resource/".$outputCatRes[0]['categoryAlias']."/".$delResource[0]['subCategoryID']."/1/".$explode[0]);
					@ unlink(url_upload."resource/".$outputCatRes[0]['categoryAlias']."/".$delResource[0]['subCategoryID']."/2/".$explode[0]);
				}
			}

			for($pos=0; $pos < $outputPosRes['rows']; $pos++)
			{
				if(!empty($outputPosRes[$pos]['positionImage']))
				{
					@ unlink(url_upload."resource/".$outputCatRes[0]['categoryAlias']."/".$delResource[0]['subCategoryID']."/3/".$outputPosRes[$pos]['positionImage']);
					@ unlink(url_upload."resource/".$outputCatRes[0]['categoryAlias']."/".$delResource[0]['subCategoryID']."/4/".$outputPosRes[$pos]['positionImage']);
				}
			}

			$FLAG_REFERER = true;
		}

		if(!empty($delSection[0]['sectionID']))
		{
			$inputResSec['tableName'] = 'resource';
			$inputResSec['select'] = 'resourceID, categoryID, subCategoryID';
			$inputResSec['filter_resourceID'] = $delSection[0]['resourceID'];
			$inputResSec['filter'] = getFilter($inputResSec);
			$outputResSec = getData($inputResSec);
			$inputResSec = '';

			$inputCatRes['tableName'] = 'category';
			$inputCatRes['select'] = 'categoryID, categoryAlias';
			$inputCatRes['filter_categoryID'] = $outputResSec[0]['categoryID'];
			$inputCatRes['filter'] = getFilter($inputCatRes);
			$outputCatRes = getData($inputCatRes);
			$inputCatRes = '';

			$inputDelPos['tableName'] = 'position';
			$inputDelPos['filter_sectionID'] = $delSection[0]['sectionID'];
			$inputDelPos['filter'] = getFilter($inputDelPos);
			$outputSecPos = getData($inputDelPos);
			delData($inputDelPos);
			$inputDelPos = '';

			for($pos=0; $pos < $outputSecPos['rows']; $pos++)
			{
				if(!empty($outputSecPos[$pos]['positionImage']))
				{
					@ unlink(url_upload."resource/".$outputCatRes[0]['categoryAlias']."/".$outputResSec[0]['subCategoryID']."/3/".$outputSecPos[$pos]['positionImage']);
					@ unlink(url_upload."resource/".$outputCatRes[0]['categoryAlias']."/".$outputResSec[0]['subCategoryID']."/4/".$outputSecPos[$pos]['positionImage']);
				}
			}

			$FLAG_REFERER = true;
		}

		if(!empty($delPosition[0]['positionID']))
		{
			$inputResSec['tableName'] = 'resource';
			$inputResSec['select'] = 'resourceID, categoryID, subCategoryID';
			$inputResSec['filter_resourceID'] = $delPosition[0]['resourceID'];
			$inputResSec['filter'] = getFilter($inputResSec);
			$outputResSec = getData($inputResSec);
			$inputResSec = '';

			$inputCatRes['tableName'] = 'category';
			$inputCatRes['select'] = 'categoryID, categoryAlias';
			$inputCatRes['filter_categoryID'] = $outputResSec[0]['categoryID'];
			$inputCatRes['filter'] = getFilter($inputCatRes);
			$outputCatRes = getData($inputCatRes);
			$inputCatRes = '';

			if(!empty($delPosition[0]['positionImage']))
			{
				@ unlink(url_upload."resource/".$outputCatRes[0]['categoryAlias']."/".$outputResSec[0]['subCategoryID']."/3/".$delPosition[0]['positionImage']);
				@ unlink(url_upload."resource/".$outputCatRes[0]['categoryAlias']."/".$outputResSec[0]['subCategoryID']."/4/".$delPosition[0]['positionImage']);
			}

			$FLAG_REFERER = true;
		}

		if(!empty($delHitsales[0]['hitsalesID']))
		{
			if(!empty($delHitsales[0]['wareID']))
			{
				$inputResUsual['tableName'] = 'resource';
				$inputResUsual['entityID'] = $delHitsales[0]['wareID'];
				$inputResUsual['resource_hitsalesType'] = 'usual';
				saveData($inputResUsual);
				$inputResUsual = '';
			}

			if(!empty($delHitsales[0]['wareID']) AND $delHitsales[0]['hitsalesType'] == 'hit' AND !empty($delHitsales[0]['hitsalesImage']))
			{
				if(strpos($delHitsales[0]['hitsalesImage'], 'hitsales-') !== false)
				{
					@ unlink(url_upload."resource/".$delHitsales[0]['hitsalesCategoryAlias']."/".$delHitsales[0]['hitsalesSubCategoryID']."/2/".$delHitsales[0]['hitsalesImage']);
				}
			}

			$FLAG_REFERER = true;
		}

		if($delComment[0]['commentType'] == 'resource')
		{
			$inputCommCount['tableName'] = 'comment';
			$inputCommCount['select'] = 'count(permAll)';
			$inputCommCount['filter_commentType'] = 'resource';
			$inputCommCount['filter_wareID'] = $delComment[0]['wareID'];
			$inputCommCount['filter'] = getFilter($inputCommCount);
			$resourceCommCount = getData($inputCommCount);
			$inputCommCount = '';

			if(!empty($delComment[0]['wareID']))
			{
				$inputCommCount['tableName'] = 'resource';
				$inputCommCount['entityID'] = $delComment[0]['wareID'];
				$inputCommCount['resource_countComment'] = $resourceCommCount[0]['count(permAll)'];
				saveData($inputCommCount);
				$inputCommCount = '';
			}

			$FLAG_REFERER = true;
		}

		if(!empty($delBrand[0]['brandID']))
		{
			if(!empty($delBrand[0]['brandImage']))
			{
				@ unlink(url_upload.'brand/'.$delBrand[0]['brandImage']);
			}

			$FLAG_REFERER = true;
		}
	}
}

if($FLAG_REFERER)
{
	header("Location: ".$_SERVER['HTTP_REFERER']);
}
?>
