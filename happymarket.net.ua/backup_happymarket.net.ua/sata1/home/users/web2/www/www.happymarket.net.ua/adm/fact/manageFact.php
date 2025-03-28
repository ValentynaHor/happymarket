<SCRIPT src="js/dynamicOptionList.js"></SCRIPT>
<SCRIPT src="js/functions.js"></SCRIPT>
<? /*
<script language="javascript" type="text/javascript">
	var cat = new DynamicOptionList();
	cat.addDependentFields("fact_factCategory","fact_factSubCategory");
	cat.setFormName("registration");
	cat.setFormIndex(1);
	<?php
	for ($cat=0; $cat<$outputCat['rows']; $cat++)
	{
		//$sub_length = $outputSubCat[$outputCat[$cat]['categoryID']]['rows'];
		echo 'cat.forValue("'.$outputCat[$cat]['categoryID'].'").addOptionsTextValue(';
		echo '" - выбрать - ", ""';
		for ($sub=0; $sub<$outputSubCat[$outputCat[$cat]['categoryID']]['rows']; $sub++)
		{
			if(empty($outputSubCat[$outputCat[$cat]['categoryID']][$sub]['treeCategoryID']))
			{
			
				echo ',"'.$outputSubCat[$outputCat[$cat]['categoryID']][$sub]['categoryName'].'"';
				echo ',"'.$outputSubCat[$outputCat[$cat]['categoryID']][$sub]['categoryID'].'"';
			}
		}
		echo ');';
	}echo 'cat.forValue("'.$outputFact['factCategory'].'").setDefaultOptions("'.$outputFact['factSubCategory'].'");';
	?>
</script>
*/ ?>
<table width="80%" border="0" cellpadding="3" cellspacing="1">
<tr>
	<td align="left">

		<p align="left">
		<?
			if(!empty($getvar['page'])) {$INCpage = '/page/'.$getvar['page'];}

			echo '[ <a href="/adm/?manageFacts'.$INCpage.'" >Назад</a> ]';	
		?>
		</p>
		<table cellpadding="3" cellspacing="1" width="80%">
		<tr>
			<td align="center">
		<? 
			if($systemMessage == "okSave") 
			{
				echo '<br><p class="messageOK">Новость <b>"'.$_POST['fact_factTitle'].'"</b> успешно добавлена</p> ';
			}
			elseif($systemMessage == "okEdit")
			{
				echo '<br><p class="messageOK">Новость <b>"'.$_POST['fact_factTitle'].'"</b> успешно сохранена</p> ';
			}
			elseif($systemMessage == "error")
			{
				echo '<br><p class="messageERROR">Ошибка! Пожалуйста, попробуйте еще раз</p>';
			}
			if(!empty($errorMessageAlias)) echo $errorMessageAlias;
		?>
				</td>
			</tr>	
		</table>	

		<table border="0" cellpadding="3" cellspacing="1" align="left">
		<form name="registration" action="<?=$sid?>" method="post" enctype="multipart/form-data">
		<input type="hidden" name="viewMode" value="save" />
		<input type="hidden" name="tableName" value="fact" />
		<input type="hidden" name="fact_permAll" value="1" />
		<input type="hidden" name="entityID" value="<?=$outputFact['factID']?>" />
		<tr>
			<td width="150" class="rowgreen">Фото:</td>
			<td>
			<?
				if(!empty($outputFact['factImage']))
				{
					if(!empty($outputFact['factImage']))
					{
						$infoImage = @GetImageSize(pathcore.'/images/fact/preview/'.$outputFact['factImage']);
						if($infoImage[0] > 450) $width = 'width="450px;"'; else $width = '';
					}
					echo '<img '.$width.' src="../images/fact/preview/'.$outputFact['factImage'].'">';
					echo ' &#160; [<a href="?manageFact/fact/'.$outputFact['factID'].$INCpage.'/remove/'.$outputFact['factImage'].'/" >Удалить</a>]<br />';
				}
				?>
				<div style="padding-top:5px;color:#999999;">
					<input type="hidden" name="MAX_FILE_SIZE" value="10000000"><input type="file" name="fact_factImage" size="18" style="width:250px"/>
					Подпись: <input type="text" name="fact_factImageAlt" style="width:250px;" value="<?=$outputFact['factImageAlt']?>"/>
				</div>
			</td>
		</tr>
		<tr>
			<td class="rowgreen">Название:</td>
			<td>
				<input type="text" name="fact_factTitle" style="width:700px;" value="<?=$outputFact['factTitle']?>"/>
			</td>
		</tr>
		<? if(!empty($outputFact['factAlias']) OR !empty($outputFact['factID'])) { ?>
		<tr> 
			<td class="rowgreen">Псевдоним:</td>
			<td>
				<?
					if(!empty($outputFact['timeCreated']))
					{
						$curDate = $outputFact['timeCreated'];
					
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
							echo '<input type="hidden" name="fact_factAlias" value="'.$outputFact['factAlias'].'">';
							$disabled = 'disabled';
						}
					}
				?>
				<input type="text" id="alias" name="fact_factAlias" style="width:400px;" value="<?=$outputFact['factAlias']?>" <?=$disabled?>>
			</td>
		</tr>
		<? } ?>
		<tr> 
			<td valign="top" class="rowgreen">Краткое описание: </td>
			<td> 
				<textarea name="fact_factDescription" rows="10" style="width:700px;"><?=$outputFact['factDescription']?></textarea>
			</td>
		</tr>
		<tr> 
			<td valign="top" class="rowgreen">Текст:</td>
			<td>
				<textarea name="fact_factText"  rows="20" style="width:700px;"><?=$outputFact['factText']?></textarea>
			</td>
		</tr>
		<tr> 
			<td valign="top" class="rowgreen">Ключевые слова:</td>
			<td>
				<input type="hidden" name="compareKeywords" value="<?=$outputFact['factKeywords']?>"/>
				<textarea name="fact_factKeywords"  rows="2" style="width:300px;"><?=$outputFact['factKeywords']?></textarea>
			</td>
		</tr>
		<tr> 
			<td class="rowgreen">Источник:</td>
			<td> 
				<input type="text" name="fact_factSource" style="width:200px;" value="<?=$outputFact['factSource']?>">
			</td>
		</tr>
		<tr>
			<td colspan="2"><hr class="adm"></td>
		</tr>
<? /*		<tr>
			<td class="rowgreen">Категория:</td>
			<td> 
				<select name="fact_factCategory">
				<?php
				echo '<option value=""> - выбрать - </option>';
				for ($i=0; $i<$outputCat['rows']; $i++)
				{
					if($outputFact['factCategory'] == $outputCat[$i]['categoryID']) $selected = ' selected="selected"'; else $selected = '';
					echo '<option value="'.$outputCat[$i]['categoryID'].'" '.$selected.'>'.$outputCat[$i]['categoryName'].'</option>';
				}
				?>
				</select>
			</td>
		</tr>
		<tr> 
			<td class="rowgreen">Подкатегория:</td>
			<td> 
				<SELECT name="fact_factSubCategory">
				<script>cat.printOptions("fact_factSubCategory")</script>
				</SELECT> 
			</td>
		</tr>
		<tr> 
		<td class="rowgreen">Товар:</td>
			<td> 
				<input type="text" name="fact_factResource" style="width:50px;" value="<?=$outputFact['factResource']?>">
			</td>
		</tr>
*/ ?>		<?
		if(!empty($outputFact['factID']))
		{
			echo '<tr>';
				echo '<td colspan="2"><hr class="adm"></td>';
			echo '</tr>';
			echo '<tr>';
				echo '<td colspan="2" align="center">';

				echo '<div style="padding:10px;">';
					echo '[ <a href="/adm/?manageImage/source/fact-'.$outputFact['factID']; if(!empty($getvar['page'])) {echo '/page/'.$getvar['page'];} echo '" >Добавить фото</a> ]';
				echo '</div>';

				echo '<table width="100%" border="0"  bordercolor="#FFFFFF" cellpadding="5" cellspacing="1">';
				echo '<tr>';
					echo '<th width="100px">Фото</th><th>Тэг</th><th width="10%"></th>';
				echo '</tr>';
				for($i=0; $i < $outputImage['rows']; $i++)
				{
					if(!empty($outputImage[$i]['imageSource']))
					{
						$infoImage = @GetImageSize('../images/'.$outputImage[$i]['resourceType'].'/'.$outputImage[$i]['imageSource']);
						if($infoImage[0] > 100) $width = 'width="100px;"'; else $width = '';
					}
				
					echo '<tr>';
					echo '<td style="border:1px solid #E1E4E7;text-align:center">';
						if(!empty($outputImage[$i]['imageSource'])) echo '<img '.$width.' src="../images/'.$outputImage[$i]['resourceType'].'/'.$outputImage[$i]['imageSource'].'">'; else echo '&nbsp;';
					echo '</td>';
					echo '<td class="row1" style="text-align:center;font-size:14px;color:#000000"><div style="border:1px solid #7C8DA3;background-color:#FFFFFF;padding:3px;">&lt;img src="images/'.$outputImage[$i]['resourceType'].'/'.$outputImage[$i]['imageSource'].'" alt="'.$outputImage[$i]['imageTitle'].'"&gt;</div></td>';
					?>
					<td class="row1" style="text-align:center">
						<a href="/adm/?manageImage/source/fact-<?=$outputFact['factID']?>/image/<? echo $outputImage[$i]['imageID']; if(!empty($getvar['page'])) {echo '/page/'.$getvar['page'];} ?>" ><img src="img/icon/edit.gif" onClick="this.src=edit_go.src;"  onMouseMove="this.src=edit_on.src;" onMouseOut="this.src=edit_out.src;" width="25" height="28" alt="Редактировать"></a>
						<a href="/adm/?manageFact/del-image/<?=$outputImage[$i]['imageID']?>/fact/<?=$outputFact['factID']?>" onClick="return confirm('Удалить фото ?')" ><img src="img/icon/delete.gif" onClick="this.src=delete_go.src;" onMouseMove="this.src=delete_on.src;" onMouseOut="this.src=delete_out.src;" width="25" height="28" alt="Удалить"></a>
					</td>
					<?
					echo '</tr>';
				}
				echo '</table>';
				echo '</td>';
			echo '</tr>';
		}
		?>
		<tr>
			<td colspan="2"><hr class="adm"></td>
		</tr>
		<tr>
			<td>Статус:</td>
			<td>
				<select name="fact_permAll" style="width:100px;">
				<?
					if(empty($outputFact['factID'])) $outputFact['permAll'] = '1';
					echo getSelectedDropDown('ddPermAll', $outputFact['permAll']);
				?>
				</select>
			</td>
		</tr>
		<tr> 
			<td></td>
			<td> 
				<input type="submit" name="Submit" class="button" value="  Сохранить  ">
				<?
					if(!empty($getvar['fact']) AND $outputFact['factMailed'] == 0){
						echo '<input type="submit" name="mailSend" class="button" style="margin-left:30px" value="  Разослать  ">';
					}
					elseif(!empty($getvar['fact']) AND $outputFact['factMailed'] == 1){
						echo '<span style="margin-left:30px; color:#555">Новость была разосланна подписчикам.</span>';
					}
				?>
			</td>
		</tr>
		</form>
		</table>

	</td>
</tr>
</table>