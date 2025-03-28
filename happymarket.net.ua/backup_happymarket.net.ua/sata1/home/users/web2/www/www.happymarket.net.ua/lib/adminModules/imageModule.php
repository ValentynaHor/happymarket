<?php
$input = $_POST;
if ($url == 'manageImage')
{
	if(!empty($getvar['source']))
	{
		$explode = explode('-',$getvar['source']);
		$getvar['type'] = $explode[0];
		$getvar['resource'] = $explode[1];
	}

	if(empty($getvar['resource']) OR empty($getvar['type']))
	{
		header("Location: ".urlse."/adm/");
	}

	if ($input['viewMode']=='save')
	{
		$input[$input['tableName'].'_'.$input['tableName'].'Title'] = trim($input[$input['tableName'].'_'.$input['tableName'].'Title']);
		$input[$input['tableName'].'_'.$input['tableName'].'Title'] = str_replace("'","`",$input[$input['tableName'].'_'.$input['tableName'].'Title']);
		$input[$input['tableName'].'_'.$input['tableName'].'Title'] = str_replace('"','&quot;',$input[$input['tableName'].'_'.$input['tableName'].'Title']);

		$upload = $input['tableName'].'_'.$input['tableName'].'Source';
		$upload_name = $input['tableName'].'_'.$input['tableName'].'Source_name';

		if (!empty($_FILES[$upload]['tmp_name']))
		{
			$ext = explode('.',$_FILES[$upload]['name']);
			$ext = '.'.$ext[count($ext)-1];
			$name = gen_alias($input[$input['tableName'].'_'.$input['tableName'].'Title'],35,25);

			$input[$upload] = $name.'-'.$getvar['resource'].$ext;
			$uploadPath = url_upload.$getvar['type']."/".$input[$upload];

			if(!copy($_FILES[$upload]['tmp_name'], $uploadPath))
			{
				echo 'Error: no image uploaded';
			}
			else
			{
				@ chmod($uploadPath, 0777);

				$imgInfo = @ getimagesize($uploadPath);
				if($getvar['type'] == 'interview' OR $getvar['type'] == 'recipe' OR $getvar['type'] == 'review')
				{
					if($imgInfo[0] >= 542)
					{
						$lines = file(urlse.'/cgi/magick.pl/542/265/75/'.$getvar['type'].'/'.$input[$upload]);
					}
				}
				else
				{
					if($imgInfo[0] >= 400)
					{
						$lines = file(urlse.'/cgi/magick.pl/400/400/75/'.$getvar['type'].'/'.$input[$upload]);
					}
				}
			}
		}

		$input[$input['tableName'].'_resourceType'] = $getvar['type'];
		$input[$input['tableName'].'_resourceID'] = $getvar['resource'];

		$input['auto_increment'] = 'yes';
		$systemMessage = saveData($input);
		$input = '';
	}

	if(!empty($getvar['image']))
	{
		if(!empty($getvar['remove']))
		{
			if(@ unlink('../images/'.$getvar['type'].'/'.$getvar['remove']) OR !file_exists('../images/'.$getvar['type'].'/'.$getvar['remove']))
			{
				$input['entityID'] = $getvar['image'];
				$input['image_imageSource'] = '';
				$input['tableName'] = 'image';
				saveData($input);
				$input ='';
			}
			header("Location: ".$_SERVER['HTTP_REFERER']);
		}

		$input['filter_imageID'] = $getvar['image'];
		$input['filter'] = getFilter($input);
		$input['tableName'] = 'image';
		$outputImage = getData($input);
		$outputImage = $outputImage[0];
		$input = '';
	}
}
?>