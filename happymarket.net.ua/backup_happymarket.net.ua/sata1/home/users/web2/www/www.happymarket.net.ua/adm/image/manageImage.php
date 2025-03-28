<script language="JavaScript" type="text/javascript" src="js/validator.js"></script>
<br><br>
<center>
<table width="80%" cellpadding="3" cellspacing="1">
<tr>
	<td  align="center">

		<p align="left">
		<?
			echo '[ <a href="/adm/?manage'.ucfirst($getvar['type']).'/'.$getvar['type'].'/'.$getvar['resource'];
			if(!empty($getvar['page'])) echo '/page/'.$getvar['page'];
			echo '" >Назад</a> ]';
		?>
		</p>
		<table cellpadding="3" cellspacing="1" width="80%">
		<tr>
			<td align="center">
			<?
				if($systemMessage == "okSave") 
				{
					echo '<br><p class="messageOK">Фото успешно добавлено.</p> ';
				}
				elseif($systemMessage == "okEdit")
				{
					echo '<br><p class="messageOK">Фото успешно изменено.</p> ';
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
		<input type="hidden" name="tableName" value="image" />
		<input type="hidden" name="entityID" value="<?=$outputImage['imageID']?>" />
		<tr>
			<td width="150" class="rowgreen">Фото:</td>
			<td>
				<?
				if(!empty($outputImage['imageSource']))
				{
					echo '<img src="../images/'.$outputImage['resourceType'].'/'.$outputImage['imageSource'].'">';
					echo ' &#160; [<a href="?manageImage/image/'.$outputImage['imageID'].'/type/'.$outputImage['resourceType'].'/remove/'.$outputImage['imageSource'].'/" >Удалить</a>]<br />';
				}
				?>
				<div style="padding-top:5px;"><input type="hidden" name="MAX_FILE_SIZE" value="10000000"><input type="file" name="image_imageSource" style="width:250px"/></div>
			</td>
		</tr>
		<tr>
			<td class="rowgreen">Подпись:</td>
			<td>
				<input type="text" name="image_imageTitle" style="width:400px;" value="<?=$outputImage['imageTitle']?>">
				<font color=#FF0033>*</font>
			</td>
		</tr>
		<tr>
			<td></td>
			<td><font color="#FF0033">*</font> - поля обязательные для заполнения </td>
		</tr>
		<tr>
			<td colspan="2"><hr class="adm"></td>
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
			registrationValidator.addValidation('image_imageTitle','req','Поле "Подпись" не заполнено');
		</script>

	</td>
</tr>
</table>