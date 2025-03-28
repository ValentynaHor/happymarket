<div>
<div style="float:left; padding-left:50px; width:300px;">
<?	echo $pageText;
?>
</div>
<div style="float:right;padding-right:300px;">
<form name="quickMail" action="<?=$sid?>" method="post" enctype="multipart/form-data">
<input type="hidden" name="viewMode" value="sendMail" />
<div align="center">
<?
	if(!empty($systemMessage)){
		if($systemMessage == 'ok') echo '<div style="color:green; text-align:center">Ваше письмо успешно отправленно. Спасибо!</div>';
		elseif($systemMessage == 'error') echo '<div style="color:red; text-align:center">Ошибка! Пожалуйста, попробуйте еще раз.</div>';
	}
?>
<b>Обратная связь</b>
<table border="0" cellspacing="0" cellpadding="3" style="margin-top:0px;">
	<tr valign="middle">
		<td>Сообщение:</td><td><textarea name="message" style="width:340px; height:150px;"></textarea></td>
	</tr>
	<tr valign="top">
		<td>Имя:</td><td><input type="text" name="name" value="" style="width:230px;"></td>
	</tr>
	<tr valign="top">
		<td>Телефон:</td><td><input type="text" name="phone" value="" style="width:230px;"></td>
	</tr>
	<tr valign="top">
		<td>E-mail:</td><td><input type="text" name="email" value="" style="width:230px;"></td>
	</tr>
	<tr valign="top">
		<td>&nbsp;</td>
		<td align="center"><input type="submit" name="Submit" class="button1" value="  Отправить  "></td>
	</tr>
</table>
</div>
</form>
</div>

</div>
