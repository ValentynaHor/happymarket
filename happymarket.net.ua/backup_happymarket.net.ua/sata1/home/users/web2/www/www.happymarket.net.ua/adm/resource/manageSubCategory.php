<script language="JavaScript" type="text/javascript" src="js/validator.js"></script>
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
		echo '<br><p class="messageOK">Подраздел <b>'.$_POST['category_categoryName'].'</b> успешно добавлен.</p><br>';
	}
	elseif($systemMessage == "okEdit")
	{
		echo '<br><p class="messageOK">Подраздел <b>'.$_POST['category_categoryName'].'</b> успешно изменен.</p><br>';
	}
	elseif($systemMessage == "error")
	{
		echo '<br><p class="messageERROR">Ошибка! Попробуйте еще раз.</p><br>';
	}
?>
<table width="90%" border="0" cellpadding="5" cellspacing="5">
<form name="registration" action="<?=$sid?>" method="post" enctype="multipart/form-data">
<input type="hidden" name="viewMode" value="save" />
<input type="hidden" name="tableName" value="category" />
<input type="hidden" name="entityID" value="<?=$output['categoryID']?>" />
<input type="hidden" name="category_parentCategoryID" value="<?=$getvar['category']?>" />
<tr>
	<td width="50%" align="left" valign="top" style="border:1px solid #CCCCCC;">
		<p align="left">
			<?
				echo '[ <a href="/adm/?manageSubCategories/category/'.$getvar['category'].'/dept/'.$getvar['dept'];
				if(!empty($getvar['page'])) {echo '/page/'.$getvar['page'];}
				echo '" >Назад</a> ]';
			?>
		</p>
		<table border="0" cellpadding="3" cellspacing="1" align="left">
		<tr> 
				<td class="rowgreen">Название:</td>
				<td><input type="text" name="category_categoryName" style="width:600px" value="<?=$output['categoryName']?>"/>&nbsp;&nbsp; </td>
		</tr>
		<? if(!empty($output['categoryAlias']) OR !empty($output['categoryID'])) { ?>
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
								echo '<input type="hidden" name="category_categoryAlias" value="'.$output['categoryAlias'].'">';
								$disabled = 'disabled';
							}
						}
					?>
					<input type="text" name="category_categoryAlias" value="<?=$output['categoryAlias']?>" style="width:600px" <?=$disabled?>/>
					<font color=#FF0033>*</font>
					
				</td>
		</tr>
		<? } ?>
<? /*		<tr> 
			<td width="100" class="rowgreen">&nbsp;</td>
			<td style="font-size:11px; color:#999999">
				<br>Горячие клавиши:<br>
				Выделить слово или фразу и CTRL + SHIFT + B -> Выделить жирным текст<br>
				Выделить слово или фразу и CTRL + SHIFT + U -> Добавить ссылку<br><br>
			</td>	
		</tr>
*/ ?>		<tr>

			<td class="rowgreen">Текст:</td>
			<td><textarea class="ckeditor" id="editor1" name="category_categoryDescription"><?=$output['categoryDescription']?></textarea></td>
		</tr>
		<tr>
			<td class="rowgreen">Категория:</td>
			<td>
				<input type="hidden" name="compareParentCategory" value="<?=$output['parentCategoryID']?>" />
				<select name="category_parentCategoryID" onChange="checkTop(this);">
				<?php
				if(!empty($output['categoryID'])) echo '<option value="top">TOP</option>';
				for ($i=0; $i<$outputCat['rows']; $i++)
				{
					if($output['parentCategoryID'] == $outputCat[$i]['categoryID']) $selected = ' selected="selected"';
					elseif(empty($output['parentCategoryID']) AND $getvar['category'] == $outputCat[$i]['categoryID']) $selected = ' selected="selected"';
					else $selected = '';
					echo '<option value="'.$outputCat[$i]['categoryID'].'" '.$selected.'>'.$outputCat[$i]['categoryName'].'</option>';
				}
				?>
				</select>
			</td>
		</tr>
		<tr>
			<td colspan="2"><hr class="adm"></td>
		</tr>
		<tr>
			<td class="rowgreen">Статус:</td>
			<td>
				<select name="category_permAll">
				<?
					if(empty($output['categoryID'])) $output['permAll'] = '1';
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
	<td width="50%" align="center" valign="top" style="border:1px solid #CCCCCC;">
		<div style="text-align:center;padding:5px;">Бренды</div>
		<?
		echo '<table width="100%" border="0" cellpadding="2" cellspacing="1">';
		echo '<tr>';
			for($i=0; $i < $outputBrand['rows']; $i++)
			{
				if($i%3 == 0 AND $i != 0) echo '</tr><tr>';
				if(strstr($output['categoryBrand'],'|'.$outputBrand[$i]['brandID'].'|')) $checked = 'checked'; else $checked = '';
				echo '<td width="33%" align="left">';
					
					echo '<input type="hidden" name="brand['.$outputBrand[$i]['brandID'].']" value="0">';
					echo '<input type="checkbox" name="brand['.$outputBrand[$i]['brandID'].']" value="1" '.$checked.'>';
					echo '&nbsp;'.$outputBrand[$i]['brandName'].'&nbsp;';
				echo '</td>';
			}
			if($outputBrand['rows']%3 == 1) echo '<td width="33%">&nbsp;</td><td width="33%">&nbsp;</td>';
			elseif($outputBrand['rows']%3 == 2) echo '<td width="33%">&nbsp;</td>';
		echo '</tr>';
		echo '</table>';
		?>
	</td>
</tr>
</form>
<script language="JavaScript">
	function checkTop(elem)
	{
		oldVal = <?=$output['parentCategoryID']?>;
		elemVal = elem[elem.options.selectedIndex].value;

		if(elemVal == 'top' && elemVal != oldVal)
		{
			elemConf = confirm('ВНИМАНИЕ! При изменении значения все товары этой подкатегории будут удалены.\nВы согласны?');
			//alert(elemConf);
			if(elemConf == 'true') return true;
			else return false;
		}
		return false;
	}
</script>
</table>