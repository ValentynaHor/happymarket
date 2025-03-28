<div style="text-align:left; padding-left:20px; padding-top:20px; ">
	<form action="<?=$sid?>" method="post" enctype="multipart/form-data">
	<input type="hidden" name="viewMode" value="save" >
	<table cellpadding="2" cellspacing="0">
<? /*	<tr>
		<td class="rowgreen">Мин. сумма заказа:</td>
		<td>
		<input type="text" name="setting_minSumOrder" <? if(!empty($outputSetting[0]['minSumOrder'])) echo 'value="'.$outputSetting[0]['minSumOrder'].'"'; ?> size="4" >&nbsp;грн.
		</td>
	</tr>
*/ ?>
	<tr>
		<td class="rowgreen" colspan="2" align="center" style="padding-top:10px; font-weight:bold">Контактная информация:</td>
	</tr>
	<tr>
		<td class="rowgreen">Тел. #1:</td>
		<td>
		<input type="text" name="setting_phone1" value="<? echo $outputSetting[0]['phone1']; ?>" style="width:300px;" >
		</td>
	</tr>
	<tr>
		<td class="rowgreen">Тел. #2:</td>
		<td>
		<input type="text" name="setting_phone2" value="<? echo $outputSetting[0]['phone2']; ?>" style="width:300px;" >
		</td>
	</tr>
	<tr>
		<td class="rowgreen">Тел. #3:</td>
		<td>
		<input type="text" name="setting_phone3" value="<? echo $outputSetting[0]['phone3']; ?>" style="width:300px;" >
		</td>
	</tr>
<? /*	<tr>
		<td class="rowgreen">Адрес:</td>
		<td>
		<textarea name="setting_address" style="width:300px;" ><? echo $outputSetting[0]['address']; ?></textarea>
		</td>
	</tr>
*/?>	<tr>
		<td class="rowgreen" colspan="2" align="center"><input type="submit" name="submit" class="button" style="width:100px;" value="Сохранить" /></td>
	</tr>
	</table>
	</form>
</div>
