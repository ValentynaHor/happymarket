<script language="JavaScript" type="text/javascript" src="js/validator.js"></script>

<table cellspacing="0" cellpadding="8" width="92%" align="center">
<tr>
	<td align="center">
<? 
	if($systemMessage == "okSave") 
	{
		echo '<p class="ok">'.$userTitle.' <b>'.$_POST['user_userName'].'</b> ('.$_POST['user_userNik'].'), Ваша учетная запись успешно добавлена.<br /> Для авторизации введите ниже Ваш ник и пароль</p> ';
	}
	elseif($systemMessage == "okEdit")
	{
		echo '<p class="ok">'.$userTitle.' <b>'.$_POST['user_userName'].'</b> ('.$_POST['user_userNik'].'), Ваша учетная запись успешно изменена.</p>';
	}
	elseif($systemMessage == "error")
	{
		echo '<p class="error">Ошибка! '.$textMessage.'Попробуйте еще раз.</p>';
	}

if(isset($identic))
{
	echo $identic;
}
else
{
	if($systemMessage != "okSave") 
	{
?>
	<table border=0 cellspacing=0 cellpadding=3>
	<form name="registration" action="<?=$sid?>" method="post" enctype="multipart/form-data">
	<input type="hidden" name="viewMode" value="save" />
	<input type="hidden" name="tableName" value="user" />
	<input type="hidden" name="user_permAll" value="1" />
	<input type="hidden" name="entityID" value="<?=$userArray['userID']?>" />
	<input type="hidden" name="user_groupID" value="<? if(!empty($userArray['groupID'])) echo $userArray['groupID']; else echo 'user';?>" />
	<input type="hidden" name="user_userType" value="<? if(!empty($userArray['userType'])) echo $userArray['userType']; else echo 'user';?>" />
	<input type="hidden" name="user_passwordEnabled" value="y" />
	<? if(empty($userArray['userID'])) { ?>
	<input type="hidden" name="user_userIPCreated" value="<?=$_SERVER['REMOTE_ADDR']?>" />
	<? } else { ?>
	<input type="hidden" name="user_userIPSaved" value="<?=$_SERVER['REMOTE_ADDR']?>" />
	<? } ?>
	<tr>
		<td></td>
		<td>Моя личная информация:</td>
	</tr>
	<tr> 
		<td width="100px">Ник (логин):</td>
		<td>
			<input type="text" name="user_userNik" style="width:150px;" value="<?=$userArray['userNik']?>">
			<font color=#FF0033>*</font>
		</td>
	</tr>
	<tr>
		<td>Имя:</td>
		<td>
			<input type="text" name="user_userName" style="width:150px;" value="<?=$userArray['userName']?>">
			<font color=#FF0033>*</font>
		</td>
	</tr>
	<tr> 
		<td>Фамилия:</td>
		<td>
			<input type="text" name="user_userFamily" style="width:150px;" value="<?=$userArray['userFamily']?>">
		</td>
	</tr>
	<tr>
		<td>Пол:</td>
		<td>
			<select name="user_userGender" style="width:100px;"><?=getSelectedDropDown('ddGender', $userArray['userGender'])?></select>
			<font color=#FF0033>*</font>
		</td>
	</tr>
	<tr> 
		<td>Дата рождения:<br>(dd.mm.yyyy)</td>
		<td> 
			<input type="text" name="user_userDateBirth" style="width:80px;" value="<?=formatDate($userArray['userDateBirth'],'date')?>">
			<font color=#FF0033>*</font>
		</td>
	</tr>
	<tr>
		<td valign="top">Фото:</td>
		<td> 
			<? if(!empty($userArray['userImage'])){ ?>
				<img src="../images/uploaduser/<?=$userArray['userImage']?>" ><br>
				<div style="margin-top:2px" align="right">[ <a href="registration/delavatar" style="text-decoration:none">удалить</a> ]</div>
			<? } ?>
			<input type="hidden" name="MAX_FILE_SIZE" value="90000000"><input type="file" name="user_userImage"  style="width:250px;">
		</td>
	</tr>
	<? if($userArray['userType'] == 'merchant' OR $getvar[0] == 'opt') {} else { ?>
	<tr>
		<td>Подпись:</td>
		<td>
			<textarea name="user_userCitation"  rows="3" style="width:250px;"><?=$userArray['userCitation']?></textarea>
		</td>
	</tr>
	<? } ?>
	<tr> 
		<td valign="top" >О себе:<br><? if($userArray['userType'] == 'merchant' OR $getvar[0] == 'opt') echo '(Компания,<br>должность и т.п.)'; else echo '(Интересы,<br>занятия и т.п.)'; ?></td>
		<td> 
			<textarea name="user_userDescription"  rows="3" style="width:250px;"><?=$userArray['userDescription']?></textarea>
		</td>
	</tr>
		<tr>
		<td></td>
		<td>
			<HR size="1" width="100%" color="#424242" align="left">
			Моя контактная информация:
		</td>
	</tr>
	<tr> 
		<td>Страна:</td>
		<td> 
			<input type="text" name="user_userCountry" style="width:150px;" value="<?=$userArray['userCountry']?>">
			<font color=#FF0033>*</font>
		</td>
	</tr>
	<tr> 
		<td>Город:</td>
		<td> 
			<input type="text" name="user_userCity" style="width:150px;" value="<?=$userArray['userCity']?>">
			<font color=#FF0033>*</font>
		</td>
	</tr>
	<tr> 
		<td>Телефон:</td>
		<td> 
			<input type="text" name="user_userPhone" style="width:150px;" value="<?=$userArray['userPhone']?>">
		</td>
	</tr>
	<tr> 
		<td>E-mail:</td>
		<td> 
			<input type="text" name="user_userEmail" style="width:150px;" value="<?=$userArray['userEmail']?>">
			<font color=#FF0033>*</font>
		</td>
	</tr>
	<tr> 
		<td>#ICQ:</td>
		<td> 
			<input type="text" name="user_userICQ" style="width:150px;" value="<?=$userArray['userICQ']?>">
		</td>
	</tr>
	<tr> 
		<td>Подписаться на новости:</td>
		<td>
			<input type="hidden" name="user_userSendnews" value="0">
			<input type="checkbox" name="user_userSendnews" value="1" <? if($userArray['userSendnews']) echo 'checked'; ?>">
		</td>
	</tr>

	<tr>
		<td></td>
		<td><HR size="1" width="100%" color="#424242" align="left"></td>
	</tr>
	<? if(empty($userArray['userPassword'])) { ?>
	<tr> 
		<td>Пароль:</td>
		<td> 
			<input type="password" name="user_userPassword" style="width:120px;">
			<font color=#FF0033>*</font>
		</td>
	</tr>
	<tr> 
		<td>Подтверждение:</td>
		<td> 
			<input type="password" name="userPassword2" style="width:120px;">
			<font color=#FF0033>*</font>
		</td>
	</tr>
	<? } ?>
	<tr> 
		<td></td>
		<td><font color="#FF0033">*</font> - поля обязательные для заполнения </td>
	</tr>
	<tr> 
		<td></td>
		<td>
			<input type="submit" value="Сохранить" name="Submit" class="button1">
		</td>
	</tr>
	</form>
	</table>
  	<script language="JavaScript">
		var registrationValidator = new Validator("registration");
		registrationValidator.addValidation('user_userNik','req','Поле "Ник" не заполнено');
		registrationValidator.addValidation('user_userName','req','Поле "Имя" не заполнено');
		registrationValidator.addValidation('user_userDateBirth','req','Поле "Дата рождения" не заполнено');
		registrationValidator.addValidation('user_userCountry','req','Поле "Страна" не заполнено');
		registrationValidator.addValidation('user_userCity','req','Поле "Город" не заполнено');
		registrationValidator.addValidation('user_userEmail','req','Поле "E-mail" не заполнено');
		registrationValidator.addValidation('user_userEmail','email','Введенный "E-mail" неправильный');
		<? if(empty($userArray['userPassword'])) { ?>
		registrationValidator.addValidation('user_userPassword','req','Поле "Пароль" не заполнено');
		registrationValidator.addValidation('userPassword2','req','Поле "Подтверждение" не заполнено');
		<? } ?>
		registrationValidator.setAddnlValidationFunction('checkSelectAndPassword');
		function checkSelectAndPassword()
		{
			// check Category
			if (registration.user_userGender.options.selectedIndex == 0) {
				registration.user_userGender.focus();
				alert('Поле "Пол" не выбрано');
				return false;
			}
			<? if(empty($userArray['userPassword'])) { ?>
			// check Password
			if (registration.user_userPassword.value != registration.userPassword2.value) {
				registration.user_userPassword.value = '';
				registration.userPassword2.value = '';
				registration.user_userPassword.focus();
				alert('Пароль и подтверждение имеют разные значения');
				return false;
			}
			<? } ?>
			// check Date Birth
			var regexp = /^(\d{2}\.\d{2}\.\d{4})$/;
			if(!regexp.test(registration.user_userDateBirth.value))
			{
				registration.user_userDateBirth.focus();
				alert('Формат даты рождения не соответствует dd.mm.yyyy');
				return false;
			}
		}
	</script>
	<? } else { ?>
	<form name="edit" action="<? echo $loaderName."/login"; ?>" method="post" enctype="multipart/form-data">
	<input  type="hidden" name="authentication" value="active">
	<table border="1" cellpadding="0" cellspacing="10" bordercolor="#D2D7DC" width="200" align="center">
	<tr>
		<td style="border-width:0;" align="left" width="50" class="text">Имя:</td>
		<td style="border-width:0;" align="left"><input class="login" type="text" name="userNik" style="width:120px;"></td>
	</tr>
	<tr>
		<td style="border-width:0;" align="left" class="text">Пароль:</td>
		<td style="border-width:0;" align="left"><input class="login" type="password" name="userPassword" style="width:120px;"></td>
	</tr>
	<tr>
		<td style="border-width:0;" align="center" class="text" colspan="2"><input type="submit" value="Авторизация" name="Submit" class="button1"></td>
	</tr>
	</table>
	</form>
<?
	}
}
?>
	</td>
</tr>
</table>