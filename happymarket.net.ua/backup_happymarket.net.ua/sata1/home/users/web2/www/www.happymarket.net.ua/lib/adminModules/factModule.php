<?php
$input = $_POST;
if ($url == 'manageFact')
{
/*
	$inputCat['tableName'] = "category";
	$inputCat['sort_categoryPosition'] = 'asc';
	$inputCat['sort'] = sortData($inputCat);
	$outputTableCategory = getData($inputCat);
	for ($i=0; $i < $outputTableCategory['rows']; $i++)
	{
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
*/
}

if ($url == 'manageFact' AND $input['viewMode']=='save')
{
	$input[$input['tableName'].'_'.$input['tableName'].'Title'] = trim($input[$input['tableName'].'_'.$input['tableName'].'Title']);
	$input[$input['tableName'].'_'.$input['tableName'].'Title'] = str_replace("'","`",$input[$input['tableName'].'_'.$input['tableName'].'Title']);
	$input[$input['tableName'].'_'.$input['tableName'].'Title'] = str_replace('"','&quot;',$input[$input['tableName'].'_'.$input['tableName'].'Title']);

	//generate alias
	if(empty($input['entityID']))
	{
		$input[$input['tableName'].'_'.$input['tableName'].'Alias'] = gen_alias($input[$input['tableName'].'_'.$input['tableName'].'Title'],60,50);
	}

	if(empty($input['entityID']))
	{
		$inputCompare['tableName'] = "fact";
		$inputCompare['filter_factAlias'] = $input[$input['tableName'].'_'.$input['tableName'].'Alias'];
		$inputCompare['filter'] = getFilter($inputCompare);
		$outputCompare = getData($inputCompare);
		$inputCompare = "";

		if($outputCompare['rows'] > 0)
		{
			$input['fact_permAll'] = '9';
			$_FILES[$input['tableName'].'_'.$input['tableName'].'Image']['tmp_name'] = '';
		}
		$FLAG_CHANGE = true;
	}

	$upload = $input['tableName'].'_'.$input['tableName'].'Image';
	$upload_name = $input['tableName'].'_'.$input['tableName'].'Image_name';
	if (!empty($_FILES[$upload]['tmp_name']))
	{
		$ext = explode('.',$_FILES[$upload]['name']);
		$ext = '.'.$ext[count($ext)-1];
		$name = $input[$input['tableName'].'_'.$input['tableName'].'Alias'];

		$input[$upload] = $name.$ext;
		$uploadPath = url_upload."fact/".$input[$upload];

		if(!copy($_FILES[$upload]['tmp_name'], $uploadPath))
		{
			echo 'Error: no image uploaded';
		}
		else
		{
			copy($uploadPath,url_upload.'fact/preview/'.$input[$upload]);
			@ chmod(url_upload."fact/".$input[$upload], 0777);
			@ chmod(url_upload."fact/preview/".$input[$upload], 0777);

			$imgInfo = @ getimagesize(url_upload."fact/".$input[$upload]);
			if($imgInfo[0] >= 100)
			{
				$lines = file(urlse.'/cgi/magick.pl/100/100/75/fact|preview/'.$input[$upload]);
			}
			if($imgInfo[0] >= 400)
			{
				$lines = file(urlse.'/cgi/magick.pl/400/400/75/fact/'.$input[$upload]);
			}
		}
	}
	if(isset($input['mailSend'])){
		$inputMailingList['tableName'] = 'user';
		$inputMailingList['filter_ userSendnews'] = '1';
		$inputMailingList['filter'] = sortData($inputMailingList);
		$outputMailingList = getData($inputMailingList);
		$inputMailingList = '';

		for($i=0; $i<$outputMailingList['rows']; $i++){
			$body  = '<div style="font-size:12px; font-family:Arial;">';
			$body .= '<br /><br /><b>'.$outputMailingList[$i]['userFamily'].' '.$outputMailingList[$i]['userName'].'</b>, Вы получили это письмо, т.к. подписались на рассылку новостей сайта <a href="http://'.$_SERVER['HTTP_HOST'].'">'.$_SERVER['HTTP_HOST'].'</a>';
			$body .= '<br />Новость Вы можете прочесть, перейдя по этой <a href="http://'.$_SERVER['HTTP_HOST'].'/facts/'.$input[$input['tableName'].'_'.$input['tableName'].'Alias'].'">ссылке</a>.';
			$body .= '<br /><br />Отказаться от подписки Вы можете на <a href="http://'.$_SERVER['HTTP_HOST'].'/registration">страничке редактирования профиля</a>';
			$body .= '</div>';
			$toadress = $outputMailingList[$i]['userEmail'];
			$subject = 'Свежие новости на сайте '.$_SERVER['HTTP_HOST'];
			$subject = '=?utf-8?b?'.base64_encode($subject).'?=';
			$fromadress = "From: message@happymarket.net.ua\n".
						"Return-path: message@happymarket.net.ua\n".
						"Content-type: text/html; charset=utf-8";
			$contenttype = "Content-type: text/html; charset=utf-8";
			if (mail($toadress, $subject, $body, $fromadress)) { $systemMessage = 'ok';}
			else { $systemMessage = 'error'; }
			//print_r($body);
			//$toadress = "webtesting@ukr.net";
			mail($toadress, $subject, $body, $fromadress);
		}

		$input['fact_factMailed'] = 1;
	}
	$input['auto_increment'] = 'yes';
	$systemMessage = saveData($input);
	$input = '';

	if($outputCompare['rows'] > 0 OR $systemMessage == 'okSave')
	{
		header("Location: ".urlse."/adm/?manageFact/fact/".$globalInsertAutoID);
	}
}

if ($url == 'manageFacts')
{
	if($input['viewMode'] == 'filter' OR is_array($_SESSION['SESSION_FACT']))
	{
		$currrentFilter = '';

		if($input['viewMode'] != 'filter')
		{
			$input['title'] = $_SESSION['SESSION_FACT']['title'];
		}

		if(!empty($input['title']))
		{
			$input['title'] = trim($input['title']);
			$input['title'] = eregi_replace("[  ]+"," ",$input['title']);

			$currrentFilter = '';
			$searchArray = explode(' ',$input['title']);
			for($i=0; $i < count($searchArray); $i++)
			{
				$currrentFilter .=  ' AND (factTitle like \'%'.$searchArray[$i].'%\' OR factText like \'%'.$searchArray[$i].'%\')';
			}
		}

		$_SESSION['SESSION_FACT']['title'] = $input['title'];
	}

	$input['tableName'] = "fact";
	$input['filter'] = $currrentFilter;
	$input['select'] = 'count(permAll)';
	$outputCount = getData($input);
	$input = '';

		$numPage = $getvar['page'];
		if(empty($numPage)) {$numPage = 1;}
		$countEntity = 10;
		if($numPage == 1) { $startPos = 0; } else { $startPos = $numPage*$countEntity - $countEntity; }

	$input['tableName'] = "fact";
	$input['filter'] = $currrentFilter;
	$input['sort_timeCreated'] = 'desc';
	$input['sort'] = sortData($input);
	$input['limit'] = ' limit '.$startPos.', '.$countEntity;
	$outputFact = getData($input);
	$input = "";
}

if ($url == 'manageFact' OR $url == 'viewFact')
{
	if(!empty($getvar['fact']))
	{
		if(!empty($getvar['remove']))
		{
			@chmod(url_upload."fact/".$getvar['remove'], 0777);
			@chmod(url_upload."fact/preview/".$getvar['remove'], 0777);

			if(@ unlink('../images/fact/preview/'.$getvar['remove']) OR !file_exists('../images/fact/preview/'.$getvar['remove']))
			{
				@ unlink('../images/fact/'.$getvar['remove']);
				$input['entityID'] = $getvar['fact'];
				$input['fact_factImage'] = '';
				$input['tableName'] = 'fact';
				saveData($input);
				$input ='';
			}
			header("Location: ".$_SERVER['HTTP_REFERER']);
		}

		$input['filter_factID'] = $getvar['fact'];
		$input['filter'] = getFilter($input);
		$input['tableName'] = 'fact';
		$outputFact = getData($input);
		$outputFact = $outputFact[0];
		$input = '';

		if($outputFact['permAll'] == '9')
		{
			$errorMessageAlias = '<br><p style="color:#FF0000;">Внимание! Псевдоним "<strong>'.$outputFact['factAlias'].'</strong>" уже существует. Статус выставлен в "Скрытый".</p>';
			$outputFact['factAlias'] = '';
			$outputFact['permAll'] = '0';
		}

		$input['tableName'] = 'image';
		$input['filter_resourceID'] = $outputFact['factID'];
		$input['filter_resourceType'] = 'fact';
		$input['filter'] = getFilter($input);
		$outputImage = getData($input);
		$input = '';
	}
}

/********** [ DEL DATA ] **********/
$FLAG_REFERER = false;
if (!empty($getvarFirst))
{
	$explodeFirst = explode ("-",$getvarFirst);
	$getvarEntity = $explodeFirst[1];
	if ($explodeFirst[0]=='del')
	{
		$input['filter_'.$getvarEntity.'ID'] = $getvar[$getvarFirst];
		$input['filter'] = getFilter($input);
		$input['tableName'] = $getvarEntity;

		if($input['tableName'] == 'fact') $delFact = getData($input);
		if($input['tableName'] == 'image') $delImage = getData($input);

		delData($input);
		$input = '';

		// delete data
		$FLAG_REFERER = true;

		if(!empty($delFact[0]['factID']))
		{
			$inputDelImg['tableName'] = 'image';
			$inputDelImg['filter_resourceType'] = 'fact';
			$inputDelImg['filter_resourceID'] = $delFact[0]['factID'];
			$inputDelImg['filter'] = getFilter($inputDelImg);
			$outputImgFac = getData($inputDelImg);
			delData($inputDelImg);
			$inputDelImg = '';

			if(!empty($delFact[0]['factImage']))
			{
				@ unlink(url_upload.'fact/preview/'.$delFact[0]['factImage']);
				@ unlink(url_upload.'fact/'.$delFact[0]['factImage']);
			}

			for($img=0; $img < $outputImgFac['rows']; $img++)
			{
				if(!empty($outputImgFac[$img]['imageSource']))
				{
					@ unlink(url_upload."fact/".$outputImgFac[$img]['imageSource']);
				}
			}
		}

		if(!empty($delImage[0]['imageID']))
		{
			if(!empty($delImage[0]['imageSource']))
			{
				@ unlink(url_upload."fact/".$delImage[0]['imageSource']);
			}
		}

		$input = '';
	}
}

if($FLAG_REFERER)
{
	header("Location: ".$_SERVER['HTTP_REFERER']);
}

?>