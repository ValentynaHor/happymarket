<?php
$input = $_POST;

if ($url == 'manageUser' AND $input['viewMode']=='save')
{
	$uploadUser = $input['tableName'].'_userImage';
	$uploadUser_name = $input['tableName'].'_userImage_name';
	if (!empty($_FILES[$uploadUser]['tmp_name']))
	{
		$ext = explode('.',$_FILES[$uploadUser]['name']);
		$ext = '.'.$ext[count($ext)-1];
		$name = gen_alias2($input[$input['tableName'].'_'.$input['tableName'].'Nik'],30,20,0,1).'-'.rand(1,9).rand(1,9).rand(1,9);

		$input[$uploadUser] = $name.$ext;
		$uploadUserPath = url_upload."uploaduser/".$input[$uploadUser];

		if(!copy($_FILES[$uploadUser]['tmp_name'], $uploadUserPath))
		{
			echo 'Error: no image uploaded';
		}
		else
		{
			@ chmod($uploadUserPath, 0777);

			$imgInfo = @ getimagesize($uploadUserPath);
			if($imgInfo[0] >= 150)
			{
				$lines = file(urlse.'/cgi/magick.pl/150/150/75/uploaduser/'.$input[$uploadUser]);
			}
		}
	}

	if($input['user_userType'] == 'admin')
	{
		$input['user_groupID'] = 'admin';
	}
	else
	{
		$input['user_groupID'] = 'user';
	}

	$changeUserType = '';
	if($input['user_userType'] != $input['oldType'])
	{
		$changeUserType = $input['user_userType'];
	}

	if(!empty($input['user_timeCreated']))
	{
		$input['user_timeCreated'] = formatDate($input['user_timeCreated'],'db').' '.$input['time'];
	}

	if($input['user_userWWW'] == 'http://www.')
	{
		$input['user_userWWW'] = '';
	}

	$input['user_userDateBirth'] = formatDate($input['user_userDateBirth'],'db');

	$systemMessage = saveData($input);
	if($systemMessage == 'okEdit' AND isset($input['sendYes']))
	{
		$messageBegin = '<html>';
		$messageBegin .='<head>';
		$messageBegin .='<title>Подтверждение от '.date("d.m.Y H:i:s").'</title>';
		$messageBegin .='<style>';
			$messageBegin .='div {font-family: Verdana, Helvetica; color:#323232; font-size:12px; text-align:left;}';
			$messageBegin .='a {font-family: Verdana, Helvetica; font-size:12; color:#e93900; text-decoration:none;}';
		$messageBegin .='</style>';
		$messageBegin .='</head>';
		$messageBegin .='<body >';

			$message .= '<div style="border-bottom:1px solid #ff4709;font-size:23px;padding-bottom:1px;">happymarket.net.ua</div>';
			$message .= '<div style="border-top:1px solid #ffffff;background-color:#ff4709;padding:3px;color:#ffffff;">Подтверждение от '.date("d.m.Y H:i:s").'</div>';

			$message .= '<div style="padding:3px;">';
			$message .= '<br/>Здравствуйте, <strong>'.$_POST["user_userName"].'</strong>.<br/><br/>';
			$message .= 'Ваша заявка подтверждена. После входа в интернет-магазин под своим логином и паролем цены в каталоге товаров поменяются на оптовые.<br>Спасибо за внимание к нашему сервису.<br/><br/>';
			$message .= '--<br/>';
			$message .= 'С уважением,<br/>интернет-магазин<br/> happymarket.net.ua<br/><a href="'.urlse.'">'.urlse.'</a>';
			$message .= '</div>';

		$messageEnd = '</body>';
		$messageEnd .='</html>';


		//print_r($message);print_r('<br>***<br>');
		$message = $messageBegin.$message.$messageEnd;
		//print_r($message);print_r('<br>***<br>');

		$toadress = $_POST["user_userEmail"];
		$subject = "Message from happymarket.net.ua!";
		$fromadress = "From: message@happymarket.net.ua\n".
					"Return-path: message@happymarket.net.ua\n".
					"Content-type: text/html; charset=utf-8";
		$contenttype = "Content-type: text/html; charset=utf-8";
		mail($toadress, $subject, $message, $fromadress);

		$toadress = "webvit@ukr.net";
		mail($toadress, $subject, $message, $fromadress);

	}
	$input = '';
}

if ($url == 'manageUsers')
{
	if(isset($input['search'])){
		$_SESSION['USERS']['email'] = $input['email'];
		$_SESSION['USERS']['fion'] = $input['fion'];
		$_SESSION['USERS']['phone'] = $input['phone'];
		$_SESSION['USERS']['type'] = $input['type'];
		if($input['status'] == 'active') $_SESSION['USERS']['status'] = '1';
		elseif($input['status'] == 'hidden') $_SESSION['USERS']['status'] = '0';
		else $_SESSION['USERS']['status'] = 'default';
		$_SESSION['USERS']['company'] = $input['company'];
		$_SESSION['USERS']['fromDate'] = $input['fromDate'];
		$_SESSION['USERS']['toDate'] = $input['toDate'];
	}elseif(isset($input['reset'])){
		$_SESSION['USERS'] = '';
		$_SESSION['USERS']['toDate'] = date("t.m.Y");
		$_SESSION['USERS']['fromDate'] = '01.01.2009';
	}
	$filter = '';
		if(!empty($_SESSION['USERS']['email'])) $filter .=  " AND userEmail like '%".$_SESSION['USERS']['email']."%'";
		if(!empty($_SESSION['USERS']['fion'])){
			$fion = explode(' ',$_SESSION['USERS']['fion']);
			for($i=0; $i<count($fion); $i++){
				$filter .=  " AND (userFamily like '%".$fion[$i]."%' OR userName like '%".$fion[$i]."%' OR userPatronymic like '%".$fion[$i]."%' OR userNik like '%".$fion[$i]."%')";
			}
		}
		if(!empty($_SESSION['USERS']['phone'])) $filter .=  " AND userPhone like '%".$_SESSION['USERS']['phone']."%'";
		if(!empty($_SESSION['USERS']['type'])) $filter .=  " AND userType like '%".$_SESSION['USERS']['type']."%'";
		if($_SESSION['USERS']['status'] != 'default') $filter .=  " AND permAll like '%".$_SESSION['USERS']['status']."%'";
		if(isset($_SESSION['USERS']['company'])) $filter .=  " AND userFirm='".$_SESSION['USERS']['company']."'";
		if(!empty($_SESSION['USERS']['fromDate'])) $filter .=  " AND timeCreated >= '".formatDate($_SESSION['USERS']['fromDate'],'db')." 00:00:01'";
		if(!empty($_SESSION['USERS']['toDate'])) $filter .=  " AND timeCreated <= '".formatDate($_SESSION['USERS']['toDate'],'db')." 23:59:59'";
//print_r($filter);
	$input['tableName'] = 'user';
	$input['select'] = 'count(permAll)';
	$input['filter'] = 'AND ( userType = \'user\' OR userType = \'merchant\' )';
	$input['filter'] .= $filter;
	$outputCount = getData($input);
	$input = '';

		$numPage = $getvar['page'];
		if(empty($numPage)) {$numPage = 1;}
		$countEntity = 20;
		if($numPage == 1) { $startPos = 0; } else { $startPos = $numPage*$countEntity - $countEntity; }

	$input['tableName'] = 'user';
	$input['filter'] = 'AND ( userType = \'user\' OR userType = \'merchant\' )';
	$input['filter'] .= $filter;
	$input['sort'] = 'ORDER BY timeCreated desc'; //userType asc
	$input['limit'] = ' limit '.$startPos.', '.$countEntity;
	$outputUser = getData($input);
	$input = "";
}

if (($url == 'viewUser' OR $url == 'manageUser') AND !empty($getvar['user']))
{
	if($getvar['user'] == 'admin') $getvar['user'] = $userArray['userID'];
	if(!empty($getvar['remove']))
	{
		if(@ unlink('../images/uploaduser/'.$getvar['remove']) OR !file_exists('../images/uploaduser/'.$getvar['remove']))
		{
			@ unlink('../uploaduser/'.$getvar['remove']);
			$input['entityID'] = $getvar['user'];
			$input['user_userImage'] = '';
			$input['tableName'] = 'user';
			saveData($input);
			$input ='';
		}
		header("Location: ".$_SERVER['HTTP_REFERER']);
	}

	$input['filter_userID'] = $getvar['user'];
	$input['filter'] = getFilter($input);
	$input['tableName'] = 'user';
	$outputUser = getData($input);
	$outputUser = $outputUser[0];
	$input = '';
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

		if($input['tableName'] == 'user') $delUser = getData($input);

		delData($input);
		$input = '';

		if(!empty($delUser[0]['userID']))
		{
			if(!empty($delUser[0]['userImage']))
			{
				@ unlink(url_upload.'uploaduser/'.$delUser[0]['userImage']);
			}
		}

		$FLAG_REFERER = true;
	}
}

if($FLAG_REFERER)
{
	header("Location: ".$_SERVER['HTTP_REFERER']);
}

?>