<?php
$input = $_POST;

if($url == 'registration' AND $getvar[0] == 'delavatar')
{
	if(!file_exists('images/uploaduser/'.$_SESSION['userArray']['userImage']) OR @unlink('images/uploaduser/'.$userArray['userImage']))
	{
		$input['tableName'] = "user";
		$input['entityID'] = $userArray['userID'];
		$input['user_userImage'] = "";
		$systemMessage = saveData($input);
		$input = '';
		$userArray['userImage'] = "";
		$_SESSION['userArray']['userImage'] = "";
	}
	header("Location: ".urlse."/profile");
}

if ($url == 'registration' AND $input['viewMode']=='save')
{

	$inputTemp['tableName'] = 'user';
	$inputTemp['filter'] = 'AND userEmail=\''.$input['user_userEmail'].'\'';
	$inputTemp['select'] = 'permAll';
	$outputTemp = getData($inputTemp);

	if($outputTemp['rows'] > 0 AND empty($input['entityID']))
	{
		$identic = 'Зарегистрированный пользователь с e-mail <b>'.$input['user_userEmail'].'</b> уже существует. <a href="/restorepass">Напомнить пароль?</a>';
	}
	else
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

		$input['user_userDateBirth'] = formatDate($input['user_userDateBirth'],'db');

		if($input['user_userWWW'] == 'http://www.')
		{
			$input['user_userWWW'] = '';
		}

		$systemMessage = saveData($input);
		if($systemMessage == 'okSave')
		{
			$messageBegin = '<html>';
			$messageBegin .='<head>';
			$messageBegin .='<title>Регистрация от '.date("d.m.Y H:i:s").'</title>';
			$messageBegin .='<style>';
				$messageBegin .='div {font-family: Verdana, Helvetica; color:#323232; font-size:12px; text-align:left;}';
				$messageBegin .='a {font-family: Verdana, Helvetica; font-size:12; color:#e93900; text-decoration:none;}';
			$messageBegin .='</style>';
			$messageBegin .='</head>';
			$messageBegin .='<body >';

				$message .= '<div style="border-bottom:1px solid #ff4709;font-size:23px;padding-bottom:1px;">happymarket.net.ua</div>';
				$message .= '<div style="border-top:1px solid #ffffff;background-color:#ff4709;padding:3px;color:#ffffff;">Регистрация от '.date("d.m.Y H:i:s").'</div>';

				$message .= '<div style="padding:3px;">';
				$message .= '<br/>Здравствуйте, <strong>'.$_POST["user_userName"].'</strong>.<br/><br/>';
				if($getvar[0] == 'opt') $message .= 'Вы оформили в интернет-магазине happymarket.net.ua заявку на регистрацию оптового покупателя.<br>После подтверждения заявки в течении суток Вы получите доступ к оптовым ценам.<br/><br/>';
				else $message .= 'Вы успешно прошли регистрацию в интернет-магазине happymarket.net.ua.<br/><br/>';
					$message .= '<strong>Данные для авторизации</strong>:<br/>';
					$message .= 'Логин: <strong>'.$_POST['user_userNik'].'</strong><br/>';
					$message .= 'Пароль: <strong>'.$_POST['user_userPassword'].'</strong><br/><br/>';
				if($getvar[0] == 'opt') $message .= '<strong>Личные данные</strong>:<br/>Имя: <strong>'.$_POST["user_userName"].'</strong><br/>Фамилия: <strong>'.$_POST["user_userFamily"].'</strong><br/>Пол: <strong>'.getValueDropDown('ddGender', $_POST['user_userGender']).'</strong><br/>Дата рождения: <strong>'.$_POST['user_userDateBirth'].'</strong><br/>О себе (Компания, должность и т.п.): <strong>'.$_POST["user_userDescription"].'</strong><br/><br/>';
				else $message .= '<strong>Личные данные</strong>:<br/>Имя: <strong>'.$_POST["user_userName"].'</strong><br/>Фамилия: <strong>'.$_POST["user_userFamily"].'</strong><br/>Пол: <strong>'.getValueDropDown('ddGender', $_POST['user_userGender']).'</strong><br/>Дата рождения: <strong>'.$_POST['user_userDateBirth'].'</strong><br/>Подпись (для форума): <strong>'.$_POST["user_userCitation"].'</strong><br/>О себе (Интересы, занятия и т.п.): <strong>'.$_POST["user_userDescription"].'</strong><br/><br/>';
				$message .= '<strong>Контактные данные</strong>:<br/>Страна: <strong>'.$_POST["user_userCountry"].'</strong><br/>Город: <strong>'.$_POST["user_userCity"].'</strong><br/>Телефон: <strong>'.$_POST["user_userPhone"].'</strong><br/>E-mail: <strong>'.$_POST["user_userEmail"].'</strong><br/>#ICQ: <strong>'.$_POST["user_userICQ"].'</strong><br/><br/>';
				$message .= '--<br/>';
				$message .= 'С уважением,<br/>интернет-магазин<br/> happymarket.net.ua<br/><a href="'.urlse.'">'.urlse.'</a>';
				$message .= '</div>';

			$messageEnd = '</body>';
			$messageEnd .='</html>';


			//print_r($message);print_r('<br>***<br>');
			$message = $messageBegin.$message.$messageEnd;
			//print_r($message);print_r('<br>***<br>');

			$toadress = $_POST["user_userEmail"];
			if($getvar[0] == 'opt') $subject = "Zayavka na opt - happymarket.net.ua";
			else $subject = "Registration from happymarket.net.ua!";
			$fromadress = "From: message@happymarket.net.ua\n".
						"Return-path: message@happymarket.net.ua\n".
						"Content-type: text/html; charset=utf-8";
			$contenttype = "Content-type: text/html; charset=utf-8";
			mail($toadress, $subject, $message, $fromadress);

			$toadress = "webvit@ukr.net";
			mail($toadress, $subject, $message, $fromadress);
		}
		$input = '';

		if($systemMessage != 'error')
		{
			if(!empty($_POST['entityID']))
			{
				$input['filter_userID'] = $_POST['entityID'];
				$input['filter'] = getFilter($input);
			}
			else
			{
				$input['filter_userID'] = $globalInsertID;
				$input['filter'] = getFilter($input);
			}
			$input['tableName'] = 'user';
			$output = getData($input);
			$input = '';

			$loginStatus = 'yes';
			$userArray = $output[0];

			$_SESSION['loginStatus'] = $loginStatus;
			$_SESSION['userArray'] = $userArray;

			header("Location: ".urlse."/profile");
		}
	}
}

if ($url == 'profile')
{
	/*$string = $sid;
	$pattern = '/\/profile\/(([0-9A-Za-z-]{2,})-(\d+)|)((-|)p-(\d+)|)$/';
	preg_match($pattern, $string, $matches);
	print_r($matches);
	if(is_array($matches)){
		if($matches[2] == 'p')
		$getvar['page'] = $matches[3];


	}*/
	if($getvar[0] == '')
	unset ($getvar);
	if(!empty($getvar) AND $getvar[0] != 'p'){
		$input['filter_userID'] = $getvar[0];
		$input['filter'] = getFilter($input);
		$input['tableName'] = 'user';
		$outputUser = getData($input);
		$outputUser = $outputUser[0];
		$input = '';
	}
	elseif((empty($getvar) OR $getvar[0] == 'p')  AND !empty($userArray))
	{
		$outputUser = $userArray;
	}
	else
	{
		$pathFile = 'session/login.php';
	}

}

if ($pageAlias == 'passwordRestore')
{
	$input = $_POST;
	if(!empty($input['email']))
	{
		$inputUser['filter_userEmail'] = trim($input['email']);
		$inputUser['filter'] = getFilter($inputUser);
		$inputUser['tableName'] = 'user';
		$outputUser = getData($inputUser);
		$input = '';
		$inputUser = '';

		if(!empty($outputUser[0]['userID']))
		{
			$messageBegin = '<html>';
			$messageBegin .='<head>';
			$messageBegin .='<title>Восстановление пароля</title>';
			$messageBegin .='<style>';
				$messageBegin .='div {font-family: Verdana, Helvetica; color:#323232; font-size:12px; text-align:left;}';
				$messageBegin .='a {font-family: Verdana, Helvetica; font-size:12; color:#e93900; text-decoration:none;}';
			$messageBegin .='</style>';
			$messageBegin .='</head>';
			$messageBegin .='<body >';

				$message .= '<div style="border-bottom:1px solid #ff4709;font-size:23px;padding-bottom:1px;">happymarket.net.ua</div>';
				$message .= '<div style="border-top:1px solid #ffffff;background-color:#ff4709;padding:3px;color:#ffffff;">Восстановление пароля</div>';

				$message .= '<div style="padding:3px;">';
				$message .= '<br/>Здравствуйте, <strong>'.$outputUser[0]['userName'].'</strong>.<br/><br/>';
				$message .= 'Вы были зарегистрированы '.formatDate($outputUser[0]['timeCreated'], 'datetime').'.<br/><br/>';
				$message .= '<strong>Данные для авторизации</strong>:<br/>';
				$message .= 'Логин: <strong>'.$outputUser[0]['userNik'].'</strong><br/>';
				$message .= 'Пароль: <strong>'.$outputUser[0]['userPassword'].'</strong><br/><br/>';
				$message .= '--<br/>';
				$message .= 'С уважением,<br/>интернет-магазин<br/> happymarket.net.ua<br/><a href="'.urlse.'">'.urlse.'</a>';
				$message .= '</div>';

			$messageEnd = '</body>';
			$messageEnd .='</html>';

			//print_r($message);print_r('<br>***<br>');
			$message = $messageBegin.$message.$messageEnd;
			//print_r($message);print_r('<br>***<br>');

			$toadress = $outputUser[0]['userEmail'];
			$subject = "happymarket.net.ua: password recovery";
			$fromadress = "From: message@happymarket.net.ua\n".
						"Return-path: message@happymarket.net.ua\n".
						"Content-type: text/html; charset=utf-8";
			$contenttype = "Content-type: text/html; charset=utf-8";
			if (mail($toadress, $subject, $message, $fromadress)) $systemMessage = "send";
			else $systemMessage = "errorsend";
		}
		else
		{
			$systemMessage = "error";
		}
	}
}

if(($pageAlias == 'viewUser' OR $pageAlias == 'manageUser') AND !empty($userArray['userID']))
{
	$pageTitle = 'Информация о пользователе '.$userArray['userNik'].' ('.$userArray['userName'].' '.$userArray['userFamily'].')';

	$pageDescription = $userArray['userName'].' '.$userArray['userFamily'].' ('.$userArray['userNik'].'). Контактная  информация: '.$userArray['userCountry'].', '.$userArray['userCity'].'.';
	if(!empty($userArray['userDescription']))
	{
		$pageDescription .= ' О себе:'.$userArray['userDescription'];
	}
	else
	{
		$pageDescription .= ' Интересы, занятия, о себе.';
		if(!empty($userArray['userCitation'])) $pageDescription .= ' '.$userArray['userCitation'];
	}

	$pageKeywords = $userArray['userName'].' '.$userArray['userFamily'].', '.$userArray['userNik'].', пользователь, профиль, личная информация';

}
elseif($pageAlias == 'manageUser' AND $getvar[0] == 'opt')
{
	$pageTitle = 'Регистрация оптового покупателя';
}

$pageTitle .= ' — Интернет-Супермаркет HappyMarket.net.ua';
?>
