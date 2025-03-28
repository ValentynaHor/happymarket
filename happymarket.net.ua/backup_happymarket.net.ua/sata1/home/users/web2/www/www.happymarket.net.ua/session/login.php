<center>
<br /><br />
<?
if($url == 'login')
{
	echo $code['login_message_1'];
}
else
{
	echo $code['login_message_2'];
	echo $code['login_message_3'].' <a target="_blank" href="go/registration" class="greensmall">'.$code['login_message_4'].'</a>';
}
?>

<br />
<? if($_POST['authentication'] == 'active' AND !empty($nologin)) echo '<div style="color:#FF0000;"><strong>'.$nologin.'</strong></div>'; ?>
<form name="edit" action="<?=$lang.$sid?>" method="post" enctype="multipart/form-data">
<input  type="hidden" name="authentication" value="active">
<table cellpadding="0" cellspacing="1" align="center">
<tr>
	<td width="50" class="text">Логин:</td>
	<td align="right"><input type="text" name="userNik"  style="width:150px; height:19px;font-size:11px;"></td>
</tr>
<tr>
	<td>Пароль:</td>
	<td align="right"><input type="password" name="userPassword" style="width:150px; height:19px; font-size:11px;"></td>
</tr>
<tr>
	<td align="right" colspan="2">
		<input type="image" src="images/classic/login.gif" width="132" height="21" class="inputnontext">
		<div style="text-align:right;margin-top:2px;">
			<a class="orange" href="<?=$urlve?>registration/">Зарегистрироваться</a><br>
			<a class="orange" href="<?=$urlve?>restorepass">Забыли пароль?</a>
		</div>
	</td>
</tr>
</table>
</form>
<br /><br /><br />
</center>