<script language="JavaScript" type="text/javascript" src="js/validator.js"></script>
<center>
<br><br>
<table width="80%" cellpadding="3" cellspacing="1">
<tr>
	<td  align="center">

	<p align="left">
	<?
		if(!empty($getvar['page'])) $INCpage = '/page/'.$getvar['page'];
		echo '[ <a href="/adm/?manageUsers'.$INCpage.'" >Назад</a> ]';
	?>
	</p>

	<table cellpadding="3" cellspacing="1" width="80%">
	<tr>
		<td align="center">
		<?
			if($systemMessage == "okSave")
			{
				echo '<br><p class="messageOK">'.$userTitle.'Учетная запись <b>'.$_POST['user_userNik'].'</b> успешно добавлена.</p> ';
			}
			elseif($systemMessage == "okEdit")
			{
				echo '<br><p class="messageOK">'.$userTitle.'Учетная запись <b>'.$_POST['user_userNik'].'</b> успешно изменена.</p> ';
			}
			elseif($systemMessage == "error")
			{
				echo '<br><p class="messageERROR">Ошибка! Попробуйте еще раз.</p>';
			}


		?>
		</td>
	</tr>
	</table>

	<table cellpadding="3" cellspacing="1" align="left">
	<form name="registration" action="<?=$sid?>" method="post" enctype="multipart/form-data">
	<input type="hidden" name="viewMode" value="save" />
	<input type="hidden" name="tableName" value="user" />
	<input type="hidden" name="entityID" value="<?=$outputUser['userID']?>" />
	<input type="hidden" name="user_userType" value="<? if(!empty($outputUser['userType'])) echo $outputUser['userType']; else echo 'user'; ?>" />
	<input type="hidden" name="oldType" value="<?=$outputUser['userType']?>" />
	<input type="hidden" name="user_passwordEnabled" value="y" />
	<? if(empty($outputUser['userID'])) { ?>
	<input type="hidden" name="user_userIPCreated" value="<?=$_SERVER['REMOTE_ADDR']?>" />
	<? } else { ?>
	<input type="hidden" name="user_userIPSaved" value="<?=$_SERVER['REMOTE_ADDR']?>" />
	<? } ?>
	<tr>
		<td width="200px" class="rowgreen">Имя:</td>
		<td>
			<input type="text" name="user_userName" style="width:150px;" value="<?=$outputUser['userName']?>">
			<font color=#FF0033>*</font>
		</td>
	</tr>
	<tr>
		<td class="rowgreen">Фамилия:</td>
		<td>
			<input type="text" name="user_userFamily" style="width:150px;" value="<?=$outputUser['userFamily']?>">
		</td>
	</tr>
	<tr>
		<td class="rowgreen">Пол:</td>
		<td>
			<select name="user_userGender" style="width:80px;">
				<?=getSelectedDropDown('ddGender', $outputUser['userGender'])?>
			</select>
			<font color=#FF0033>*</font>
		</td>
	</tr>
	<tr>
		<td class="rowgreen">Дата рождения:<br>(dd.mm.yyyy)</td>
		<td>
			<input type="text" name="user_userDateBirth" style="width:80px;" value="<?=formatDate($outputUser['userDateBirth'],'date')?>">
			<font color=#FF0033>*</font>
		</td>
	</tr>
	<tr>
		<td valign="top" class="rowgreen">Фото:</td>
		<td>
			<?
			if(!empty($outputUser['userImage']))
			{
				echo '<img '.$width.' src="../images/uploaduser/'.$outputUser['userImage'].'">';
				echo ' &#160; [<a href="?manageUser/user/'.$outputUser['userID'].$INCpage.'/remove/'.$outputUser['userImage'].'/" >Удалить</a>]<br />';
			}
			?>
			<input type="hidden" name="MAX_FILE_SIZE" value="100000">
			<input type="file" name="user_userImage"  style="width:250px;">
		</td>
	</tr>
	<tr>
		<td class="rowgreen">Подпись:</td>
		<td>
			<textarea name="user_userCitation"  rows="3" style="width:250px;"><?=$outputUser['userCitation']?></textarea>
		</td>
	</tr>
	<tr>
		<td valign="top" class="rowgreen">О себе:<br>(Интересы,<br>занятия и т. п.)</td>
		<td>
			<textarea name="user_userDescription"  rows="3" style="width:250px;"><?=$outputUser['userDescription']?></textarea>
		</td>
	</tr>
	<tr>
		<td colspan="2"><hr></td>
	</tr>
	<tr>
		<td class="rowgreen">Страна:</td>
		<td>
			<input type="text" name="user_userCountry" style="width:150px;" value="<?=$outputUser['userCountry']?>">
			<font color=#FF0033>*</font>
		</td>
	</tr>
	<tr>
		<td class="rowgreen">Город:</td>
		<td>
			<input type="text" name="user_userCity" style="width:150px;" value="<?=$outputUser['userCity']?>">
			<font color=#FF0033>*</font>
		</td>
	</tr>
	<tr>
		<td class="rowgreen">Телефон:</td>
		<td>
			<input type="text" name="user_userPhone" style="width:150px;" value="<?=$outputUser['userPhone']?>">
		</td>
	</tr>
	<tr>
		<td class="rowgreen">E-mail:</td>
		<td>
			<input type="text" name="user_userEmail" style="width:150px;" value="<?=$outputUser['userEmail']?>">
			<font color=#FF0033>*</font>
		</td>
	</tr>
	<tr>
		<td class="rowgreen">#ICQ:</td>
		<td>
			<input type="text" name="user_userICQ" style="width:150px;" value="<?=$outputUser['userICQ']?>">
		</td>
	</tr>
	<tr>
		<td class="rowgreen">www:</td>
		<td>
			<? if(!empty($outputUser['userWWW'])) { ?>
			<input type="text" name="user_userWWW" style="width:190px;" value="<?=$outputUser['userWWW']?>">
			<? } else { ?>
			<input type="text" name="user_userWWW" style="width:190px;" value="http://www.">
			<? } ?>
		</td>
	</tr>
	<tr>
		<td colspan="2"><hr></td>
	</tr>
	<tr>
		<td class="rowgreen">Тип:</td>
		<td>
			<select name="user_userType">
			<?
				echo getSelectedDropDown('ddUserType', $outputUser['userType']);
			?>
			</select>
		</td>
	</tr>
	<? if($changeUserType == 'merchant') { ?>
	<tr>
		<td class="rowgreen">Отправить сообщение клиенту:</td>
		<td>
			<input type="submit" name="sendYes" class="button" value=" Да ">&nbsp;
			<input type="submit" name="sendNo" class="button" value=" Нет ">
		</td>
	</tr>
	<? } ?>
	<tr>
		<td width="100" class="rowgreen">Ник (логин):</td>
		<td>
			<input type="text" name="user_userNik" style="width:150px;" value="<?=$outputUser['userNik']?>"/>
			<font color=#FF0033>*</font>
		</td>
	</tr>
	<tr>
		<td class="rowgreen">Пароль:</td>
		<td>
			<input type="text" name="user_userPassword" style="width:150px;" value="<?=$outputUser['userPassword']?>"/>
			<font color=#FF0033>*</font>
		</td>
	</tr>
	<? if(!empty($outputUser['userID'])) { ?>
	<tr>
		<td class="rowgreen">Дата регистрации:</td>
		<td>
			<input type="text" name="user_timeCreated" style="width:150px;" value="<?=formatDate($outputUser['timeCreated'],'date')?>"/>
			<input type="hidden" name="time" value="<?=formatDate($outputUser['timeCreated'],'time')?>"/>
			<font color=#FF0033>*</font>
		</td>
	</tr>
	<? } ?>
	<tr>
		<td class="rowgreen">Компания:</td>
		<td>
			<?
				if($outputUser['userFirm'] == 1) $checked = 'checked'; else $checked = '';
			?>
			<input type="checkbox" name="user_userFirm" value="1" <?=$checked?>>
		</td>
	</tr>
	<tr>
		<td class="rowgreen">Оптовый покупатель:</td>
		<td>
			<?
				if($outputUser['wholesale'] == 1) $checked = 'checked'; else $checked = '';
			?>
			<input type="hidden" name="user_wholesale" value="0">
			<input type="checkbox" name="user_wholesale" value="1" <?=$checked?>>
		</td>
	</tr>
	<tr>
		<td class="rowgreen">Статус:</td>
		<td>
			<select name="user_permAll">
			<?
				if(empty($outputUser['userID'])) $outputUser['permAll'] = '1';
				echo getSelectedDropDown('ddPermAll', $outputUser['permAll']);
			?>
			</select>
		</td>
	</tr>
	<tr>
		<td></td>
		<td><font color="#FF0033">*</font> - поля обязательные для заполнения </td>
	</tr>
	<tr>
		<td></td>
		<td>
			<input type="submit" name="Submit" class="button" value="  Сохранить  ">
		</td>
	</tr>
	</form>
	</table>

	<script language="JavaScript">
		var registrationValidator = new Validator("registration");
		registrationValidator.addValidation('user_userName','req','Поле "Имя" не заполнено');
		registrationValidator.addValidation('user_userDateBirth','req','Поле "Дата рождения" не заполнено');
		registrationValidator.addValidation('user_userCountry','req','Поле "Страна" не заполнено');
		registrationValidator.addValidation('user_userCity','req','Поле "Город" не заполнено');
		registrationValidator.addValidation('user_userEmail','req','Поле "E-mail" не заполнено');
		registrationValidator.addValidation('user_userEmail','email','Введенный "E-mail" неправильный');
		registrationValidator.addValidation('user_userNik','req','Поле "Ник" не заполнено');
		<? if(empty($userArray['userPassword'])) { ?>
		registrationValidator.addValidation('user_userPassword','req','Поле "Пароль" не заполнено');
		registrationValidator.addValidation('userPassword2','req','Поле "Подтверждение" не заполнено');
		<? } ?>
		registrationValidator.setAddnlValidationFunction('checkSelectAndPassword');
		function checkSelectAndPassword() {
			// check Category
			if (registration.user_userGender.options.selectedIndex == 0) {
				registration.user_userGender.focus();
				alert('Поле "Пол" не выбрано');
				return false;
			}

			// check Date Birth
			var regexp = /^(\d{2}\.\d{2}\.\d{4})$/;
			if(!regexp.test(registration.user_userDateBirth.value))
			{
				registration.user_userDateBirth.focus();
				alert('Формат даты не соответствует dd.mm.yyyy');
				return false;
			}
			<? if(!empty($outputUser['userID'])) {?>
			// check Date
			var regexp = /^(\d{2}\.\d{2}\.\d{4})$/;
			if(!regexp.test(registration.user_timeCreated.value))
			{
				registration.user_timeCreated.focus();
				alert('Формат даты не соответствует dd.mm.yyyy');
				return false;
			}
			<? }?>
		}
	</script>

	</td>
</tr>
</table>
