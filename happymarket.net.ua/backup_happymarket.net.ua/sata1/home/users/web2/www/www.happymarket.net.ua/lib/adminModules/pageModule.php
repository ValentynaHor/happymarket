<?php
$input = $_POST;
if ($url == 'manageContentPages')
{
	if($input['viewMode'] == "saveArray")
	{
		$input['auto_increment'] = 'yes';
		saveArray($input);
		$input = '';
	}

	$input['tableName'] = 'page';
	$input['filter'] = "AND pageModule = 'content' OR (pageModule = 'mail' && pageURL = 'contact')";
	$input['sort_pagePosition'] = 'asc';
	$input['sort'] = sortData($input);
	$output = getData($input);
	$input = '';
}

if ($url == 'manageContentPage')
{
	if ($input['viewMode']=='save')
	{
		$upload = $input['tableName'].'_'.$input['tableName'].'Image';
		$upload_name = $input['tableName'].'_'.$input['tableName'].'Image_name';
		if (!empty($_FILES[$upload]['tmp_name']))
		{
			$input[$upload] = $_FILES[$upload]['name'];
			$uploadPath = url_upload.'page/'.$input[$upload];

			if(!copy($_FILES[$upload]['tmp_name'], $uploadPath))
			{
				echo 'Error: no image uploaded';
			}
		}
		$input['auto_increment'] = 'yes';
		saveData($input);
		$input = '';
	}

	if(!empty($getvar['page']))
	{
		$input['tableName'] = 'page';
		$input['filter_pageID'] = $getvar['page'];
		$input['filter'] = getFilter($input);
		$output = getData($input);
		$input = '';
	}
}

if ($url == 'managePages')
{
	if($input['viewMode'] == "saveArray")
	{
		$input['auto_increment'] = 'yes';
		saveArray($input);
		$input = '';
	}

	$input['sort_pagePosition'] = 'asc';
	$input['sort'] = sortData($input);
	$input['tableName'] = 'page';
	$output = getData($input);
	$input = '';
}

if ($url == 'managePage')
{
	if ($input['viewMode']=='save')
	{
		$upload = $input['tableName'].'_'.$input['tableName'].'Image';
		$upload_name = $input['tableName'].'_'.$input['tableName'].'Image_name';
		if (!empty($_FILES[$upload]['tmp_name']))
		{
			$input[$upload] = $_FILES[$upload]['name'];
			$uploadPath = url_upload.'page/'.$input[$upload];

			if(!copy($_FILES[$upload]['tmp_name'], $uploadPath))
			{
				echo 'Error: no image uploaded';
			}
		}
		$input['auto_increment'] = 'yes';
		saveData($input);
		$input = '';
	}
	// reading client modules to array
	$modarray = array();
	$modarray[] = 'content';
	$directory = opendir(pathcore.'lib/clientModules/');
	while($filename = readdir($directory))
	{
		$modfile = strstr($filename, "Module.php");
		if(!empty($modfile))
		{
			$modarray[] = str_replace("Module.php","",$filename);
		}
	}
	closedir($directory);

	if(!empty($getvar['page']))
	{
		$input['tableName'] = 'page';
		$input['filter_pageID'] = $getvar['page'];
		$input['filter'] = getFilter($input);
		$output = getData($input);
		$input = '';
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
		delData($input);
		$input = '';

		$FLAG_REFERER = true;
	}
}

if($FLAG_REFERER)
{
	header("Location: ".$_SERVER['HTTP_REFERER']);
}

?>
