<div align="center">
<div style="width:500px; margin-top:40px;" >
<b>Для восстановления пароля введите Ваш e-mail адрес,<br> который Вы указали при регистрации:</b>
<script language="JavaScript" type="text/javascript" src="js/validator.js"></script>
<table border="0" cellspacing="0" cellpadding="8" align="center">
<tr>
	<td align="center">
	<? 
	if($systemMessage == "send") 
	{
		echo '<p class="ok">На <b>'.$outputUser[0]['userEmail'].'</b> отправленны данные для авторизации.</p> ';
	}
	else if($systemMessage == "errorsend")
	{
		echo '<p class="error">Ошибка! Возможно проблемы со связью. Попробуйте ещё раз.</p>';
	}
	else if($systemMessage == "error")
	{
		echo '<p class="error">Введенный e-mail не зарегистрирован в нашей системе.</p>';
	}
	?>
	<table border=0 cellspacing=0 cellpadding=3 class="wares_left">
	<form name="registration" action="<?=$lang.'/restorepass.html'?>" method="post" enctype="multipart/form-data">
	<input type="hidden" name="viewMode" value="save" />
	<tr>
		<td>E-mail:</td>
		<td><input type="text" name="email" style="width:150px;"></td>
		<td><input type="submit" value="Отправить" name="Submit" class="button1"></td>
	</tr>
	</form>
	</table>

  	<script language="JavaScript">
		var registrationValidator = new Validator("registration");
		registrationValidator.addValidation('email','req','Поле "Email" не заполнено.');
	</script>

	</td>
</tr>
</table>
</div>
</div>
