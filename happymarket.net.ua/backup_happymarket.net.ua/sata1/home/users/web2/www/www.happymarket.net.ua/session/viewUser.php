<script language="JavaScript" type="text/javascript" src="js/validator.js"></script>

<div style="float:right;"><a href="<?=$urlve?>registration">Редактировать</a></div>

<table cellspacing="0" cellpadding="8" width="90%" align="center">
<tr>
	<td align="center">

	<table border=0 cellspacing=0 cellpadding=3 >
	<tr>
		<td></td>
		<td><b>Личная информация:</b></td>
	</tr>
	<tr>
		<td valign="top" class="rowgreen">Фото:</td>
		<td> 
		<? if(!empty($outputUser['userImage'])){ ?>
			<img src="../images/uploaduser/<?=$outputUser['userImage']?>" >
		<? } else { ?>
			-
		<? } ?>
		</td>
	</tr>
	<tr>
		<td width="110px" class="rowgreen">Ник (логин):</td>
		<td>
			<?=$outputUser['userNik']?>
		</td>
	</tr>
	<tr> 
		<td class="rowgreen">Имя:</td>
		<td>
			<?=$outputUser['userName']?>
		</td>
	</tr>
	<tr> 
		<td class="rowgreen">Фамилия:</td>
		<td>
			<?=$outputUser['userFamily']?>
		</td>
	</tr>
	<tr> 
		<td class="rowgreen">Пол:</td>
		<td> 
			<?=getValueDropDown('ddGender',$outputUser['userGender'])?>
		</td>
	</tr>
	<tr> 
		<td class="rowgreen">Дата рождения:
		</td>
		<td> 
			<?=formatDate($outputUser['userDateBirth'],'date')?>
		</td>
	</tr>
	<? if($outputUser['userType'] != 'merchant') { ?>
	<tr> 
		<td valign="top" class="rowgreen">Подпись:</td>
		<td> 
			<div style="padding:5px; text-align:justify;"><?=nl2br($outputUser['userDescription'])?></div>
		</td>
	</tr>
	<? } ?>
	<tr> 
		<td valign="top" class="rowgreen">О себе:<br><? if($outputUser['userType'] != 'merchant') echo '(Интересы,<br>занятия и т.п.)'; else echo '(Компания,<br>должность и т.п.)'; ?></td>
		<td> 
			<div style="padding:5px; text-align:justify;"><?=nl2br($outputUser['userDescription'])?></div>
		</td>
	</tr>
	<tr>
		<td colspan="2"><HR size="1" width="100%" color="#424242" align="left"></td>
	</tr>
		<td></td>
		<td><b>Kонтактная информация:</b></td>
	</tr>
	<tr> 
		<td class="rowgreen">Страна:</td>
		<td> 
			<?=$outputUser['userCountry']?>
		</td>
	</tr>
	<tr> 
		<td class="rowgreen">Город:</td>
		<td> 
			<?=$outputUser['userCity']?>
		</td>
	</tr>
	<tr> 
		<td class="rowgreen">Телефон:</td>
		<td> 
			<?=$outputUser['userPhone']?>
		</td>
	</tr>
	<? if(!empty($outputUser['userEmail'])) { ?>
	<tr> 
		<td class="rowgreen">E-mail:</td>
		<td> 
			<img style="padding:0px;margin:0px" src="../service/mail.php?adr=<?=str_rot13($outputUser['userEmail'])?>&size=2&red=75&green=75&blue=75">
		</td>
	</tr>
	<? } ?>
	<tr> 
		<td class="rowgreen">#ICQ:</td>
		<td> 
			<?=$outputUser['userICQ']?>
		</td>
	</tr>
	</table>

	</td>
</tr>
</table>
