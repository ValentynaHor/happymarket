<script> 
function treatment_keys() 
{
		var AgntUsr=navigator.userAgent.toLowerCase();
		var Opr=AgntUsr.indexOf('opera')!=-1?1:0;

		if( (Opr == 1&&(window.event.ctrlKey&&window.event.shiftKey)&&window.event.keyCode==66) || (Opr != 1&&(window.event.ctrlKey&&window.event.shiftKey)&&window.event.keyCode==2))
		{
			var text = document.selection.createRange().text;
			document.selection.createRange().text = "<strong>" + text + "</strong>";
			window.event.keyCode = 0;
			return false;

		}
		if( (Opr == 1&&(window.event.ctrlKey&&window.event.shiftKey)&&window.event.keyCode==85) || (Opr != 1&&(window.event.ctrlKey&&window.event.shiftKey)&&window.event.keyCode==21))
		{
			var i=prompt('Введите адрес:','http://www.');
			var j=prompt('Введите название:','');
			var text = document.selection.createRange().text;
			document.selection.createRange().text = "<a href=\"" + i + "\" class=\"langselactive\" title=\""+j+"\">" + text + "</a>";
			window.event.keyCode = 0;
			return false;
		}
}
</script>
<center>
<?
	if($systemMessage == "okSave") 
	{
		echo '<br><p class="messageOK">Отдел <b>'.$_POST['department_departmentName'].'</b> успешно добавлен.</p><br>';
	}
	elseif($systemMessage == "okEdit")
	{
		echo '<br><p class="messageOK">Отдел <b>'.$_POST['department_departmentName'].'</b> успешно изменен.</p><br>';
	}
	elseif($systemMessage == "error")
	{
		echo '<br><p class="messageERROR">Ошибка! Попробуйте еще раз.</p><br>';
	}
?>
<form name="registration" action="<?=$sid?>" method="post" enctype="multipart/form-data">
<input type="hidden" name="viewMode" value="save" />
<input type="hidden" name="tableName" value="department" />
<input type="hidden" name="entityID" value="<?=$output['departmentID']?>" />
<table width="90%" border="0" cellpadding="5" cellspacing="5">
<tr>
	<td width="50%" align="left" valign="top" style="border:1px solid #CCCCCC;">
		<p align="left">
			<?
				echo '[ <a href="/adm/?manageDepartments';
				if(!empty($getvar['page'])) {echo '/page/'.$getvar['page'];}
				echo '" >Назад</a> ]';	
			?>
		</p>
		<table border="0" cellpadding="3" cellspacing="1" align="left">
		<tr>
				<td width="150" class="rowgreen">Название:</td>
				<td><input type="text" name="department_departmentName" style="width:400px" value="<?=$output['departmentName']?>"/>&nbsp;&nbsp; </td>
		</tr>
		<tr>
				<td class="rowgreen">Название в шапке:</td>
				<td><input type="text" name="department_departmentHeadTitle" style="width:400px" value="<?=$output['departmentHeadTitle']?>"/>&nbsp;&nbsp; </td>
		</tr>
		<? if(!empty($output['departmentAlias']) OR !empty($output['departmentID'])) { ?>
		<tr> 
				<td class="rowgreen">Псевдоним:</td>
				<td>
					<?
						if(!empty($output['timeCreated']))
						{
							$curDate = $output['timeCreated'];
						
							$d = substr($curDate,8,2);
							$m = substr($curDate,5,2);
							$Y = substr($curDate,0,4);
						
							$H = substr($curDate,11,2);
							$i = substr($curDate,14,2);
							$s = substr($curDate,17,2);
						
							$DATE_CREATED = date('Y-m-d H:i:s',mktime($H, $i, $s, $m, $d, $Y));
							$DATE_2_DAY = date("Y-m-d H:i:s",mktime(date("G"), date("i"), date("s"), date("m"), date("d")-2, date("Y")));
							
							if($DATE_2_DAY > $DATE_CREATED AND $getvar['alias'] != '1')
							{
								echo '<input type="hidden" name="department_departmentAlias" value="'.$output['departmentAlias'].'">';
								$disabled = 'disabled';
							}
						}
					?>
					<input type="text" name="department_departmentAlias" value="<?=$output['departmentAlias']?>" style="width:400px" <?=$disabled?>/>
					<font color=#FF0033>*</font>
					
				</td>
		</tr>
		<? } ?>
		<tr>
			<td class="rowgreen">Описание:</td>
			<td>
				<textarea class="ckeditor" id="editor1" name="department_departmentText"><?=$output['departmentText']?></textarea>
			</td>
		</tr>
		<tr>
			<td class="rowgreen">Статус:</td>
			<td>
				<select name="department_permAll">
				<?
					if(empty($output['departmentID'])) $output['permAll'] = '1';
					echo getSelectedDropDown('ddPermAll', $output['permAll']);
				?>
				</select>
			</td>
		</tr>
		<tr> 
			<td></td>
			<td> 
				<input type="submit" name="Submit" class="button" value="  Сохранить  ">
			</td>
		</tr>
		</table>
	</td>
</tr>
</table>
</form>