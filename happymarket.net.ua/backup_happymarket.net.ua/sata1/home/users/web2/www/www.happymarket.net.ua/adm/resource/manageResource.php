<SCRIPT src="js/functions.js"></SCRIPT>
<? if(empty($outputResource['resourceID']) OR $getvar['changecat'] == '1') { ?>
<SCRIPT src="js/dynamicOptionList.js"></SCRIPT>
<script language="javascript" type="text/javascript">
	var cat = new DynamicOptionList();
	cat.addDependentFields("resource_categoryID","resource_subCategoryID");
	cat.setFormName("registration");
	cat.setFormIndex(1);
	<?php
	for ($cat=0; $cat<$outputCat['rows']; $cat++)
	{
		echo 'cat.forValue("'.$outputCat[$cat]['categoryID'].'").addOptionsTextValue(';
		$SEP = '';
		for ($sub=0; $sub<$outputSubCat[$outputCat[$cat]['categoryID']]['rows']; $sub++)
		{
			echo $SEP.'"'.$outputSubCat[$outputCat[$cat]['categoryID']][$sub]['categoryName'].'"';
			$SEP = ',';
			echo $SEP.'"'.$outputSubCat[$outputCat[$cat]['categoryID']][$sub]['categoryID'].'"';
		}
		echo ');';
	}
	if(!empty($outputResource['resourceID'])) echo 'cat.forValue("'.$outputResource['categoryID'].'").setDefaultOptions("'.$outputResource['subCategoryID'].'");';
	else echo 'cat.forValue("'.$getvar['category'].'").setDefaultOptions("'.$getvar['sub'].'");';
	?>
</script>
<? } ?>
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

	function showTableImages()
	{
		var elem = document.getElementById('addimg');
		if(elem.style.visibility == 'visible')
		{
			elem.style.visibility = 'hidden';
			elem.style.position = 'absolute';
			elem.style.display = 'none';
		}
		else
		{
			elem.style.visibility = 'visible';
			elem.style.position = 'relative';
			elem.style.display = 'block';
		}
		return false;
	}
</script>
<center>
<br>
<?
echo '<div style="margin-bottom:10px;">';
	echo '<div style="text-align:left;padding-bottom:10px">';
	if(!empty($getvar['page'])) $hrefPage = '/page/'.$getvar['page']; else $hrefPage = '';
	if(!empty($getvar['category'])) $hrefCategory = '/category/'.$getvar['category'];
	if(!empty($getvar['sub'])) $hrefSub = '/sub/'.$getvar['sub'];
	if(!empty($getvar['dept'])) $hrefDept = '/dept/'.$getvar['dept'];
	if(!empty($getvar['brand'])) $hrefBrand = '/brand/'.$getvar['brand'];

	// echo '<a href="/adm/?manageCategories/">Каталог</a>&nbsp;/&nbsp;';
	// echo '<a href="/adm/?manageSubCategories/category/'.$getvar['category'].'">'.$CAT_ARRAY[$getvar['category']]['categoryName'].'</a>&nbsp;/&nbsp;';
	// echo '<a href="/adm/?manageResources/category/'.$getvar['category'].'/sub/'.$getvar['sub'].$hrefPage.'">'.$CAT_ARRAY[$getvar['sub']]['categoryName'].'</a>&nbsp;/&nbsp;';

	echo '<a href="/adm/?manageDepartments/">Отделы</a>&nbsp;/&nbsp;';
	echo '<a href="/adm/?manageCategories/dept/'.$getvar['dept'].'">'.$outputDepartment['departmentName'].'</a>&nbsp;/&nbsp;';
	echo '<a href="/adm/?manageSubCategories/dept/'.$getvar['dept'].'/category/'.$getvar['category'].'" >'.$CAT_ARRAY[$getvar['category']]['categoryName'].'</a>&nbsp;/&nbsp;';
	echo '<a href="/adm/?manageResources/dept/'.$getvar['dept'].'/category/'.$getvar['category'].'/sub/'.$getvar['sub'].$hrefPage.'">'.$CAT_ARRAY[$getvar['sub']]['categoryName'].'</a>&nbsp;/&nbsp;';

	if(!empty($getvar['brand'])) echo '<a href="/adm/?manageResources/dept/'.$getvar['dept'].'/category/'.$getvar['category'].'/sub/'.$getvar['sub'].'/brand/'.$getvar['brand'].$hrefPage.'">'.$ddBrand[$getvar['brand']].'</a>&nbsp;/&nbsp;';
	echo '</div>';
echo '</div>';
?>
<table width="95%" border="0" cellpadding="3" cellspacing="1">
<tr>
	<td align="center">

	<table cellpadding="3" cellspacing="1" width="100%">
	<tr>
		<td valign="top" align="center" width="50%">
		<?
			if($systemMessage == "okSave")
			{
				echo '<br><p class="messageOK">Товар успешно добавлен.</p> ';
			}
			elseif($systemMessage == "okEdit")
			{
				echo '<br><p class="messageOK">Товар успешно изменен.</p> ';
			}
			elseif($systemMessage == "error")
			{
				echo '<br><p class="messageERROR">Ошибка! Попробуйте еще раз.</p>';
			}
		?>
		</td>
	</tr>
	</table>
	<table width="100%" border="0" cellpadding="0" cellspacing="0">
	<form name="registration" action="<?=str_replace('/changecat/1','',$sid)?>" method="post" enctype="multipart/form-data">
	<input type="hidden" name="viewMode" value="save" />
	<input type="hidden" name="tableName" value="resource" />
	<input type="hidden" name="entityImage" value="<?=$outputResource['hitsalesImage']?>" />
	<input type="hidden" name="copyImage" value="<?=$outputResource['resourceImage']?>" />
	<input type="hidden" name="compareCategoryID" value="<?=$outputResource['categoryID']?>" />
	<input type="hidden" name="compareSubCategoryID" value="<?=$outputResource['subCategoryID']?>" />
	<input type="hidden" name="entityID" value="<?=$outputResource['resourceID']?>" />
	<tr>
		<td valign="top">

		<table width="100%" border="0" cellpadding="3" cellspacing="1" align="left">
		<tr>
			<td width="200" class="rowgreen">Фото:</td>
			<td>
			<?
			if(!empty($outputResource['resourceImage']))
			{
				echo '<div style="padding-bottom:2px"><img  src="../images/resource/'.$CAT_ARRAY[$outputResource['categoryID']]['categoryAlias'].'/'.$CAT_ARRAY[$outputResource['subCategoryID']]['categoryID'].'/2/'.$outputResource['resourceImage'].'">&nbsp;';
				echo '[<a href="?manageResource/resource/'.$outputResource['resourceID'].$hrefCategory.$hrefSub.$hrefDept.$hrefBrand.$hrefPage.'/remove/'.$outputResource['resourceImage'].$hrefPage.'">Удалить</a>]</div>';
			}
			?>
			<input type="hidden" name="MAX_FILE_SIZE" value="10000000"><input type="file" name="resource_resourceImage" style="width:400px"/>
			</td>
		</tr>
		<tr>
			<td valign="top" class="rowgreen">Название:</td>
			<td><input type="text" name="resource_resourceName" style="width:400px;" value="<?=$outputResource['resourceName']?>"></td>
		</tr>
		<? if(!empty($outputResource['resourceAlias']) OR !empty($outputResource['resourceID'])) { ?>
		<tr>
			<td class="rowgreen">Псевдоним:</td>
			<td>
				<?
					if(!empty($outputResource['timeCreated']))
					{
						$curDate = $outputResource['timeCreated'];

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
							echo '<input type="hidden" name="resource_resourceAlias" value="'.$outputResource['resourceAlias'].'">';
							$disabled = 'disabled';
						}
					}
				?>
				<input type="text" name="resource_resourceAlias" value="<?=$outputResource['resourceAlias']?>" style="width:400px" <?=$disabled?>/>
				<font color=#FF0033>*</font>
			</td>
		</tr>
		<? } ?>
		<tr>
			<td valign="top" class="rowgreen">Артикул:</td>
			<td><input type="text" name="resource_resourceArtikul" style="width:200px;" value="<?=$outputResource['resourceArtikul']?>"></td>
		</tr>
<? /*		<tr>
			<td valign="top" class="rowgreen">Part Number:</td>
			<td><input type="text" name="resource_partnumber" style="width:200px;" value="<?=$outputResource['partnumber']?>"></td>
		</tr>
*/ ?>		<tr>
			<td class="rowgreen">&nbsp;</td>
			<td style="font-size:11px; color:#999999">
			<br>Горячие клавиши:<br>
			Выделить слово или фразу и CTRL + SHIFT + B -> Выделить жирным текст<br>
			Выделить слово или фразу и CTRL + SHIFT + U -> Добавить ссылку<br><br>
			</td>
		</tr>
		<tr>
			<td class="rowgreen">Описание:</td>
			<td><textarea name="resource_resourceDescription" style="width:400px" rows="10" onkeypress="treatment_keys()"><?=$outputResource['resourceDescription']?></textarea></td>
		</tr>
		<tr>
			<td class="rowgreen">Наличие:</td>
			<td>
			<select name="resource_presence">
			<?
				if(empty($outputResource['resourceID'])) $outputResource['permAll'] = '1';
				echo getSelectedDropDown('ddPresenceAdmin', $outputResource['presence']);
			?>
			</select>
			</td>
		</tr>
        <tr>
            <td class="rowgreen">Красная строка:</td>
            <td>
                <textarea name="resource_note" rows="3" style="width:400px;"><?=$outputResource['note']?></textarea>
            </td>
        </tr>
		<tr>
			<td class="rowgreen">Акция:</td>
			<td>
				<? if($outputResource['resourceOffer'] == '1') $checked = 'checked'; else $checked = ''; ?>
				<input type="hidden" name="resource_resourceOffer" value="0"/>
				<input type="checkbox" name="resource_resourceOffer" value="1" <?=$checked?>/>
			</td>
		</tr>
		<tr>
			<td class="rowgreen">Бегущая строка:</td>
			<td>
				<? if($outputResource['resourceSelected'] == '1') $checked = 'checked'; else $checked = ''; ?>
				<input type="hidden" name="resource_resourceSelected" value="0"/>
				<input type="checkbox" name="resource_resourceSelected" value="1" <?=$checked?>/>
			</td>
		</tr>
		<tr>
			<td valign="top" class="rowgreen">Вх. цена:</td>
			<td>
				<input type="text" name="resource_enterPrice" style="width:80px;" value="<?=$outputResource['enterPrice']?>">
			</td>
		</tr>
		<tr>
			<td valign="top" class="rowgreen">Цена:</td>
			<td>
				<input type="text" name="resource_resourcePrice" style="width:80px;" value="<?=$outputResource['resourcePrice']?>">
			</td>
		</tr>
		<tr>
			<td valign="top" class="rowgreen">Оптовая цена:</td>
			<td>
				<input type="text" name="resource_wholesalePrice" style="width:80px;" value="<?=$outputResource['wholesalePrice']?>">
			</td>
		</tr>
		<tr>
			<td colspan="2"><hr class="adm"></td>
		</tr>
		<? if(!empty($outputResource['resourceID']) AND $getvar['changecat'] != '1') { ?>
		<tr>
			<td class="rowgreen">Категория, подкатегория:</td>
			<td>
				<input type="hidden" name="resource_categoryID" value="<?=$outputResource['categoryID']?>" />
				<input type="hidden" name="resource_subCategoryID" value="<?=$outputResource['subCategoryID']?>" />
				<input type="hidden" name="resource_resourceBrand" value="<?=$outputResource['resourceBrand']?>" />
				[<a href="?manageResource/resource/<?=$outputResource['resourceID'].$hrefCategory.$hrefSub.$hrefDept.$hrefBrand.$hrefPage.'/changecat/1'?>">Редактировать</a>]
			</td>
		</tr>
			<? if(empty($outputResource['resourceBrand'])) { ?>
			<tr>
				<td class="rowgreen"><span style="color:#FF0000;">Бренд:</span></td>
				<td>
					<select name="resource_resourceBrand">
					<?php
					echo '<option value=""> - выбрать - </option>';
					for ($i=0; $i<$outputBrand['rows']; $i++)
					{
						if((!empty($outputResource['resourceID']) AND $outputResource['resourceBrand'] == $outputBrand[$i]['brandID']) OR $getvar['brand'] == $outputBrand[$i]['brandID']) $selected = ' selected="selected"'; else $selected = '';
						echo '<option value="'.$outputBrand[$i]['brandID'].'" '.$selected.'>'.$outputBrand[$i]['brandName'].'</option>';
					}
					?>
					</select>
				</td>
			</tr>
			<? } ?>
		<? } else { ?>
		<tr>
			<td class="rowgreen">Категория:</td>
			<td>
				<select name="resource_categoryID">
				<?php
				echo '<option value=""> - выбрать - </option>';
				for ($i=0; $i<$outputCat['rows']; $i++)
				{
					if((!empty($outputResource['resourceID']) AND $outputResource['categoryID'] == $outputCat[$i]['categoryID']) OR $getvar['category'] == $outputCat[$i]['categoryID']) $selected = ' selected="selected"'; else $selected = '';
					echo '<option value="'.$outputCat[$i]['categoryID'].'" '.$selected.'>'.$outputCat[$i]['categoryName'].'</option>';
				}
				?>
				</select>
			</td>
		</tr>
		<tr>
			<td class="rowgreen">Подкатегория:</td>
			<td>
				<SELECT name="resource_subCategoryID">
				<script>cat.printOptions("resource_subCategoryID")</script>
				</SELECT>
			</td>
		</tr>
		<tr>
			<td class="rowgreen"><? if(!empty($outputResource['resourceID']) AND empty($outputResource['resourceBrand'])) echo '<span style="color:#FF0000;">Бренд:</span>'; else echo 'Бренд:';?></td>
			<td>
				<select name="resource_resourceBrand">
				<?php
				echo '<option value=""> - выбрать - </option>';
				for ($i=0; $i<$outputBrand['rows']; $i++)
				{
					if((!empty($outputResource['resourceID']) AND $outputResource['resourceBrand'] == $outputBrand[$i]['brandID']) OR $getvar['brand'] == $outputBrand[$i]['brandID']) $selected = ' selected="selected"'; else $selected = '';
					echo '<option value="'.$outputBrand[$i]['brandID'].'" '.$selected.'>'.$outputBrand[$i]['brandName'].'</option>';
				}
				?>
				</select>
			</td>
		</tr>
		<? } ?>
		<?
		if(!empty($outputResource['resourceID']))
		{
			echo '<tr>';
				echo '<td colspan="2"><hr class="adm"></td>';
			echo '</tr>';

			$ACTIVE_IMG_STR = ''; $HIDDEN_IMG_STR = '';
			for($i=1; $i <= $COUNT_ADD_IMAGE; $i++)
			{
				if(!empty($outputResource['resourceImage'.$i]))
				{
					$explode = explode('|',$outputResource['resourceImage'.$i]);
					$outputResource['resourceImage'.$i] = $explode[0];
					$outputResource['Alt'.$i] = $explode[1];

					$ACTIVE_IMG_STR .= '<tr>';
						$ACTIVE_IMG_STR .= '<td width="80px" style="border:1px solid #E1E4E7; text-align:center">';
						if(!empty($outputResource['resourceImage'.$i]))
						{
							$imgInfo = @ getimagesize(url_upload.'resource/'.$CAT_ARRAY[$outputResource['categoryID']]['categoryAlias'].'/'.$CAT_ARRAY[$outputResource['subCategoryID']]['categoryID'].'/2/'.$outputResource['resourceImage'.$i]);
							if($imgInfo[0] > 65) $width = 'width="65px"'; else $width = '';
							if($imgInfo[1] > 65) $height = 'height="65px"'; else $height = '';

							$ACTIVE_IMG_STR .= '<img '.$width.' '.$height.' src="../images/resource/'.$CAT_ARRAY[$outputResource['categoryID']]['categoryAlias'].'/'.$CAT_ARRAY[$outputResource['subCategoryID']]['categoryID'].'/2/'.$outputResource['resourceImage'.$i].'"><br />';
							$ACTIVE_IMG_STR .= '[<a style="font-size:11px;" href="?manageResource/resource/'.$outputResource['resourceID'].$hrefCategory.$hrefSub.$hrefDept.$hrefBrand.$hrefPage.'/image/'.$i.'/remove/'.$outputResource['resourceImage'.$i].'">Удалить</a>]';
						}
						else
						{
							$ACTIVE_IMG_STR .= '&nbsp;';
						}
						$ACTIVE_IMG_STR .= '</td>';
						$ACTIVE_IMG_STR .= '<td style="font-size:11px; color:#999999;">';
							$ACTIVE_IMG_STR .= '<font>'.$i.'</font>.&nbsp; Комментарий к картинке (alt):<br><br><input type="text" name="Alt'.$i.'" style="width:250px;" value="'.$outputResource['Alt'.$i].'"><br>';
							$ACTIVE_IMG_STR .= '<input type="hidden" name="resourceImageOld'.$i.'" value="'.$outputResource['resourceImage'.$i].'">';
							$ACTIVE_IMG_STR .= '<input type="hidden" name="MAX_FILE_SIZE" value="900000000"><input type="file" name="resource_resourceImage'.$i.'" style="width:250px;margin-top:2px;" size="18"/>';
						$ACTIVE_IMG_STR .= '</td>';
					$ACTIVE_IMG_STR .= '</tr>';
				}
				else
				{
					$explode = explode('|',$outputResource['resourceImage'.$i]);
					$outputResource['resourceImage'.$i] = $explode[0];
					$outputResource['Alt'.$i] = $explode[1];

					$HIDDEN_IMG_STR .= '<tr>';
						$HIDDEN_IMG_STR .= '<td width="80px" style="border:1px solid #E1E4E7; text-align:center">&nbsp;</td>';
						$HIDDEN_IMG_STR .= '<td style="font-size:11px; color:#999999;">';
							$HIDDEN_IMG_STR .= '<font>'.$i.'</font>.&nbsp; Комментарий к картинке (alt):<br><br><input type="text" name="Alt'.$i.'" style="width:250px;" value="'.$outputResource['Alt'.$i].'"><br>';
							$HIDDEN_IMG_STR .= '<input type="hidden" name="resourceImageOld'.$i.'" value="'.$outputResource['resourceImage'.$i].'">';
							$HIDDEN_IMG_STR .= '<input type="hidden" name="MAX_FILE_SIZE" value="900000000"><input type="file" name="resource_resourceImage'.$i.'" style="width:250px;margin-top:2px;" size="18"/>';
						$HIDDEN_IMG_STR .= '</td>';
					$HIDDEN_IMG_STR .= '</tr>';
				}
			}
			echo '<tr>';
				echo '<td class="rowgreen">Дополнительные фото:</td>';
				echo '<td>';

					if(!empty($ACTIVE_IMG_STR))
					{
						echo '<table cellpadding="2" cellspacing="2" border="0">';
						echo $ACTIVE_IMG_STR;
						echo '</table>';
					}

					if(!empty($HIDDEN_IMG_STR))
					{
						echo '<div style="text-align:left;padding:10px 0px 10px 5px;">[ <a href="'.$sid.'" onClick="showTableImages(); return false;">Добавить</a> ]</div>';

						echo '<table cellpadding="2" cellspacing="2" border="0" id="addimg" style="visibility:hidden;position:absolute;display:none;">';
						echo $HIDDEN_IMG_STR;
						echo '</table>';
					}
				echo '</td>';
			echo '</tr>';
		}
		?>
		<tr>
			<td colspan="2"><hr class="adm"></td>
		</tr>
		<tr>
			<td valign="top" class="rowgreen">Позиция:</td>
			<td><input type="text" name="resource_resourcePosition" style="width:50px;" value="<?=$outputResource['resourcePosition']?>"></td>
		</tr>
		<tr>
			<td class="rowgreen">Статус:</td>
			<td>
			<select name="resource_permAll">
			<?
				if(empty($outputResource['resourceID'])) $outputResource['permAll'] = '1';
				echo getSelectedDropDown('ddPermAll', $outputResource['permAll']);
			?>
			</select>
			</td>
		</tr>
		<tr>
		  <td></td>
		  <td>
			<input type="submit" name="Submit" class="button" value="  Сохранить  "><!--&nbsp;<input type="submit" name="Send" class="button" value="  Разослать  "-->
		  </td>
		</tr>
		</table>

		</td>
	</tr>
	</table>
	</form>

	</td>
</tr>
</table>
