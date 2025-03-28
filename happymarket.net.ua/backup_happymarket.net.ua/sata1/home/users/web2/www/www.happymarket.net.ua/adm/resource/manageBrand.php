<center>
<?
	if($systemMessage == "okSave") 
	{
		echo '<br><p class="messageOK">Бренд <b>'.$brand_brandName.'</b> успешно добавлен.</p><br>';
	}
	elseif($systemMessage == "okEdit")
	{
		echo '<br><p class="messageOK">Бренд <b>'.$brand_brandName.'</b> успешно изменен.</p><br>';
	}
	elseif($systemMessage == "error")
	{
		echo '<br><p class="messageERROR">Ошибка! Попробуйте еще раз.</p><br>';
		if(!empty($messageText)) echo '<div style="color:#FF0000;font-size:16;">'.$messageText.'</div>';
	}
?>
<table width="90%" border="0" cellpadding="5" cellspacing="5">
<form name="registration" action="<?=$sid?>" method="post" enctype="multipart/form-data">
<input type="hidden" name="viewMode" value="save" />
<input type="hidden" name="tableName" value="brand" />
<input type="hidden" name="entityID" value="<?=$output['brandID']?>" />
<tr>
	<td align="left" valign="top">
		<p align="left">
			<?
				echo '[ <a href="/adm/?manageBrands'.$INCstatus.$INCletter.$INCpage.'" >Назад</a> ]';
			?>
		</p>
		<table border="0" cellpadding="3" cellspacing="1" align="left">
		<tr>
			<td width="170" class="rowgreen">Логотип:</td>
			<td>
			<?
			if(!empty($output['brandImage']))
			{
				echo '<div style="padding-bottom:2px"><img  src="../images/brand/'.$output['brandImage'].'">&nbsp;';
				echo '[<a href="?manageBrand/brand/'.$output['brandID'].'/remove/'.$output['brandImage'].$INCstatus.$INCletter.$INCpage.'">Удалить</a>]</div>';
			}
			?>
			<input type="hidden" name="MAX_FILE_SIZE" value="10000000"><input type="file" name="brand_brandImage" style="width:400px"/>
			</td>
		</tr>
		<tr>
			<td class="rowgreen">Название:</td>
			<td><input type="text" name="brand_brandName" style="width:400px" value="<?=$output['brandName']?>"/></td>
		</tr>
		<? if(!empty($output['brandAlias']) OR !empty($output['brandID'])) { ?>
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
							echo '<input type="hidden" name="brand_brandAlias" value="'.$output['brandAlias'].'">';
							$disabled = 'disabled';
						}
					}
				?>
				<input type="text" id="alias" name="brand_brandAlias" style="width:400px;" value="<?=$output['brandAlias']?>" <?=$disabled?>>
			</td>
		</tr>
		<? } ?>
		<tr>
			<td class="rowgreen">Описание:</td>
			<td><textarea name="brand_brandDescription" style="width:400px" rows="10"><?=$output['brandDescription']?></textarea></td>
		</tr>
<? /*		<tr>
			<td class="rowgreen">Примечание:<br><span style="font-size:11px;">(в списке товаров)</span></td>
			<td><textarea name="brand_brandNote" style="width:400px" rows="10"><?=$output['brandNote']?></textarea></td>
		</tr>
		<tr>
			<td class="rowgreen">Примечание:<br><span style="font-size:11px;">(в корзине)</span></td>
			<td><textarea name="brand_brandDelivery" style="width:400px" rows="10"><?=$output['brandDelivery']?></textarea></td>
		</tr>
		<tr>
			<td class="rowgreen">Мин. сумма заказа:</td>
			<td>
			<input type="text" name="brand_minSumOrder" <? if(!empty($output['minSumOrder'])) echo 'value="'.$output['minSumOrder'].'"'; ?> size="4" >&nbsp;<span style="font-size:14px;font-weight:bold;">y.e.</span>
			</td>
		</tr>
*/ ?>		<tr>
			<td colspan="2"><hr class="adm"></td>
		</tr>
		<tr>
			<td class="rowgreen">Статус:</td>
			<td>
				<select name="brand_permAll">
				<?
					if(empty($output['brandID'])) $output['permAll'] = '1';
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
</form>
</table>