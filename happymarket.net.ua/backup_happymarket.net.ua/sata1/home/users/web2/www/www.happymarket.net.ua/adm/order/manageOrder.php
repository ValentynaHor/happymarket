<?
$outputCatMain = $outputCatTree['top'];
$outputCatMain['rows'] = count($outputCatMain);
?>
<script language="JavaScript" src="js/JsHttpRequest/JsHttpRequest.js"></script>
<script language="JavaScript" src="js/order/frontend.js"></script>
<script language="JavaScript" src="js/order/functions.js"></script>
<script language="javascript">

<?
for($w=0; $w < count($searchWareNames); $w++)
{
	echo "lastWareName[".$w."] = '".$searchWareNames[$w]."'; ";
}
?>
</script>

<?php 
if(!empty($getvar['tab'])) $varstring = 'tab/'.$getvar['tab'].'/';
if(!empty($getvar['page'])) $varstring .= 'page/'.$getvar['page'].'/';
if(!empty($getvar['filter'])) $varstring .= 'filter/'.$getvar['filter'].'/';
if(!empty($getvar['user'])) $varstring .= 'user/'.$getvar['user'].'/';
?>
<br><br>
<table border="0" cellspacing="0" cellpadding="8" width="92%" align="center">
  <tr>
 	 <td align="let">
	 [ <a href="?manageOrders/<?=$varstring?>">назад</a> ]
	 </td>
  </tr>
  <tr>
 	 <td align="left">
<? 
	if($systemMessage == "okSave") 
	{
		echo '<br><p class="messageOK">Заказ успешно добавлен</p> ';
	}
	elseif($systemMessage == "okEdit")
	{
		echo '<br><p class="messageOK">Заказ успешно изменен</p>';
	}
	elseif($systemMessage == "error")
	{
		echo '<br><p class="messageERROR">Ошибка! Попробуйте еще раз.</p>';
	}

	
?>
	<script language="JavaScript" type="text/javascript" src="js/validator.js"></script>
	<form name="order1" action="<?=$sid?>" method="post"  enctype="multipart/form-data">
	<input type="hidden" name="viewMode" value="save">
	<?
	if(count($outputOrder[0]['wareID']) > 0 AND count($outputOrder[0]['wareName']) > 0)
	{
		for($num=0; $num < count($outputOrder[0]['wareID']); $num++) echo '<input type="hidden" name="entityID['.$num.']" value="'.$outputOrder[0]['orderID'][$num].'">';
	}
	$currentTime = getNewDate();
	if(empty($getvar['order'])) echo '<input type="hidden" name="order_timeCreated" value="'.$currentTime.'">';
	?>
	<table border="0" cellpadding="1" cellspacing="1" >
	<? if(!empty($getvar['order'])){ ?>
	<tr>
		<td colspan="2" class="row2" style="font-size:14px; padding-bottom:12px;"><b><u>Заказ №<?=$getvar['order']?></u></b></td>
	</tr>
	<? }?>
	<tr> 
		<td valign="top"><b>Товары:</b></td>
		<td>
		<table id="tableWares" cellpadding="5" cellspacing="1">
			<tr bgcolor="#BAD1E1" align="center">
				<td width="20" style="border:1px solid #BAD1E1;">&nbsp;</td>
				<td width="15">#</td>
				<td width="275">Название</td>
				<td width="100">Наличие</td>
				<td width="50"><nobr>Цена <font style="font-size:11px;">грн.</font></nobr></td>
				<td width="50">Кол-во</td>
				<td width="30">&nbsp;</td>
			</tr>
			<?
			if(count($outputOrder[0]['wareID']) > 0 AND count($outputOrder[0]['wareName']) > 0)
			{
				$numWare = 0;
				for($num=0; $num < count($outputOrder[0]['wareID']); $num++)
				{
					echo '<tr id="ware'.$numWare.'" class="row1" align="center">';
					echo '<td style="border:1px solid #E1E4E7; background-color:white;"><img src="img/marker.gif"></td><td>#'.($numWare+1).'</td><td><input name="order_wareName['.$numWare.']" value="'.$outputOrder[0]['wareName'][$num].'" type="text" autocomplete="off" style="width:270px;" onkeydown=\'thisobject = this; window.setTimeout("searchWare(thisobject.value,'.$numWare.')",100)\' onblur="hiddenResult(this,'.$numWare.')">';
						echo '<input type="hidden" name="order_wareID['.$num.']" value="'.$outputOrder[0]['wareID'][$num].'">';
						echo '<input type="hidden" name="order_wareCategory['.$num.']" value="'.$outputOrder[0]['wareCategory'][$num].'">';
						echo '<input type="hidden" name="order_wareSubCategory['.$num.']" value="'.$outputOrder[0]['wareSubCategory'][$num].'">';
					echo '<div id="result'.$numWare.'"></div></td><td>'.$outputOrder[0]['warePresence'][$num].'</td><td><input name="order_warePrice['.$numWare.']" value="'.$outputOrder[0]['warePrice'][$num].'" type="text" style="width:50px;" ></td><td><input name="order_wareCount['.$numWare.']" value="'; if(!empty($outputOrder[0]['wareCount'][$num])) echo $outputOrder[0]['wareCount'][$num]; else echo '1'; echo '" type="text" style="width:30px;"></td>';
					echo '<td><a href="/adm/?manageOrder/order/'.$getvar['order'].'/'.$varstring.'delete/'.$outputOrder[0]['orderID'][$num].'" onClick="return confirm(\'Удалить товар '.$outputOrder[0]['wareName'][$num].'?\')"><img src="img/icon/delete.gif" onClick="this.src=delete_go.src;" onMouseMove="this.src=delete_on.src;" onMouseOut="this.src=delete_out.src;" width="25" height="28" alt="Удалить"></a></td>';
					echo '</tr>';
					$numWare++;
				}
			} else {
			?>
			<tr id="ware0" class="row1" align="center">
				<td style="border:1px solid #E1E4E7; background-color:white;">&#160;</td><td>#1</td><td><input name="order_wareName[0]" value="" type="text" autocomplete="off" style="width:270px;" onkeydown='thisobject = this; window.setTimeout("searchWare(thisobject.value,0)",100)' onfocus="checkCat(this)" onblur="hiddenResult(this, 0)">
				<div id="result0"></div></td><td></td><td></td><td></td><td></td>
			</tr>
			<? }?>
		</table>
		</td>
	</tr>
	<tr>
		<td>Дата создания:</td>
		<td>
			<? if(!empty($getvar['order'])) $currentTime = $outputOrder[0]['orderDate']; ?>
			<input name="orderDate" value="<?=formatDate($currentTime,'date')?>" type="text" style="width:80px;" >
			<input name="orderTime" value="<?=substr($currentTime,11,5)?>" type="text" style="width:50px;" >
		</td>
	</tr>
	<tr>
		<td colspan="2" style="padding-bottom:5px; padding-top:5px;"><b>Личные данные:</b></td>
	</tr>
	<tr>
		<td width="170px">Имя:</td>
		<td><input name="order_userName" value="<?=$outputOrder[0]['userName']?>" type="text" style="width:270px"></td>
	</tr>
	<tr>
		<td>Отчество:</td>
		<td><input name="order_userPatronymic" value="<?=$outputOrder[0]['userPatronymic']?>" type="text" style="width:270px"></td>
	</tr>
	<tr>
		<td>Фамилия:</td>
		<td><input name="order_userFamily" value="<?=$outputOrder[0]['userFamily']?>" type="text" style="width:270px"> </td>
	</tr>
	<tr>
		<td>Телефон:</td>
		<td><input name="order_userPhone" value="<?=$outputOrder[0]['userPhone']?>" type="text" style="width:270px"> </td>
	</tr>
	<tr>
		<td>E-mail:</td>
		<td><input name="order_userEmail" type="text" value="<?=$outputOrder[0]['userEmail']?>" style="width:270px"></td>
	</tr>
	<tr>
		<td valign="top">Вариант доставки:</td> 
		<td valign="top">
			<? if(!empty($outputOrder[0]['delivery'])) $checkedRadio[@$outputOrder[0]['delivery']] = 'checked="checked"'; else $checkedRadio['1'] = 'checked="checked"'; ?>
			<table width="100%" cellspacing="0" cellpadding="0">
			  <tr>
				<td width="30px" height="20px" align="left"><input id="dlvry2" name="delivery" type="radio" style="height:19px; width:19px; border:0px;" value="2" <?=@$checkedRadio['2']?> onClick="changeDropDown('Наличный расчет<?='. Курс $: '.$outputSetting[0]['courseUSD']?>',0,2);"></td>
				<td >доставка по Киеву</td>
			  </tr>
			  <tr>
				<td width="30px" height="20px" align="left"><input id="dlvry3" name="delivery" type="radio" style="height:19px; width:19px; border:0px;" value="3" <?=@$checkedRadio['3']?> onClick="changeDropDown('Наличный расчет<?='. Курс $: '.$outputSetting[0]['courseUSD']?>',1,3);"></td>
				<td >доставка по Украине</td>
			  </tr>
			</table>
		</td>
	</tr>
	<tr>
		<td valign="top">Адрес и время доставки:<a id="address_time" style="color:#FF0033;visibility:hidden;">*</a></td>
		<td valign="top"><textarea name="order_userAdress" style="width:270px" rows="4"><?=$outputOrder[0]['userAdress']?></textarea></td>
	</tr>
	<tr> 
		<td>Откуда Вы узнали о нас:</td>
		<td><textarea name="order_userSource" style="width:270px" rows="2"><?=$outputOrder[0]['userSource']?></textarea></td>
	</tr>
	<tr> 
		<td>Дополнительная информация и пожелания:</td>
		<td><textarea name="order_userComment" style="width:270px" rows="3"><?=$outputOrder[0]['userComment']?></textarea></td>
	</tr>
	<tr> 
		<td colspan="2"><hr class="adm" width="444px" align="left"></td> 
	</tr>
	<tr> 
		<td>№ накладной:</td>
		<td><input name="order_orderNumber" type="text" value="<?=$outputOrder[0]['orderNumber']?>" style="width:100px"></td>
	</tr> 
	<? if($outputOrder[0]['delivery'] == 3) { ?>
	<tr> 
		<td>№ товарной декларации:</td>
		<td><input name="order_orderDeclaration" type="text" value="<?=$outputOrder[0]['orderDeclaration']?>" style="width:100px"></td>
	</tr> 
	<? } ?>
	<tr> 
		<td>Закупка со склада:</td>
		<td><input name="order_orderPurchase" type="text" value="<?=$outputOrder[0]['orderPurchase']?>" style="width:270px"></td>
	</tr> 
	<tr> 
		<td valign="top">Заметки:</td> 
		<td valign="top"><textarea name="order_orderNote" style="width:270px" rows="4"><?=$outputOrder[0]['orderNote']?></textarea></td> 
	</tr>
	<? if(($outputOrder[0]['delivery'] == 2 OR $outputOrder[0]['delivery'] == 3) AND ($outputOrder[0]['orderStatus'] == '1' OR $outputOrder[0]['orderStatus'] == '3' OR $outputOrder[0]['orderStatus'] == '4')) {?>
	<tr> 
		<td colspan="2" align="left"><hr class="adm" width="444px" align="left"></td> 
	</tr>
	<tr>
		<td valign="top">Время доставки:</td> 
		<td valign="top">
		<?
			if(!empty($outputOrder[0]['deliveryDate']) AND $outputOrder[0]['deliveryDate'] != '0000-00-00') $cur_date = formatDate($outputOrder[0]['deliveryDate'], 'date'); else $cur_date = date('d.m.Y');
			if(!empty($outputOrder[0]['deliveryTimeStart']) AND $outputOrder[0]['deliveryTimeStart'] != '00:00:00') $cur_time_start = substr($outputOrder[0]['deliveryTimeStart'],0,5); else $cur_time_start = '00:00';
			if(!empty($outputOrder[0]['deliveryTimeEnd']) AND $outputOrder[0]['deliveryTimeEnd'] != '00:00:00') $cur_time_end = substr($outputOrder[0]['deliveryTimeEnd'],0,5); else $cur_time_end = '00:00';

			echo '<input name="order_deliveryDate" type="text" value="'.$cur_date.'" style="width:80px">';
			echo '&nbsp; &nbsp;с&nbsp;<input name="order_deliveryTimeStart" type="text" value="'.$cur_time_start.'" style="width:50px">&nbsp;до&nbsp;<input name="order_deliveryTimeEnd" type="text" value="'.$cur_time_end.'" style="width:50px">';
		?>
		</td> 
	</tr>
	<tr>
		<td valign="top">Комментарий:</td> 
		<td valign="top"><textarea name="order_deliveryComment" style="width:270px" rows="2"><?=$outputOrder[0]['deliveryComment']?></textarea></td> 
	</tr>
	<tr>
		<td valign="top">Курьер:</td> 
		<td valign="top">
			<select name="order_orderCourier" style="width:270px">
			<option value="">- выбрать -</option>
			<? echo getSelectedDropDown('ddCourier',$outputOrder[0]['orderCourier']); ?>
			</select>
		</td> 
	</tr>
	<? }?>
	<tr> 
		<td colspan="2"><hr class="adm" width="444px" align="left"></td> 
	</tr>
	<? if(!empty($outputOrder[0]['orderHistory'])) {
	echo '<tr>';
		echo '<td colspan="2">';
		echo '<table width="445px" style="border:1px solid #FFFFFF" cellpadding="5" cellspacing="1">';
		echo '<tr>';
			echo '<th width="100px">Статус</th>'; echo '<th>Изменил</th>'; echo '<th width="100px">Дата</th>';
		echo '</tr>';
		$historyArray = @ explode('&',$outputOrder[0]['orderHistory']);
		for($h=1; $h < count($historyArray)-1; $h++)
		{
			$hArray = @ explode('|',$historyArray[$h]); 
			echo '<tr>';
				echo '<td class="row1">'.getValueDropDown('ddOrderStatus',$hArray[0]).'</td>';
				echo '<td class="row1">'; if($hArray[1] != 'Клиент' AND $hArray[1] != '555') { echo getValueDropDown('ddUserType',$ddAllManager[$hArray[1]]['userType']).' <a class="green" href="/adm/?viewUser/user/'.$hArray[1].'" >'.$ddAllManager[$hArray[1]]['userNik'].'</a>&nbsp;['.$ddAllManager[$hArray[1]]['userName'].']'; } elseif($hArray[1] == 'Клиент') { echo 'Клиент'; } elseif($hArray[1] == '555') { echo 'Root'; } echo '</td>';
				echo '<td class="row1" align="center">'.formatDate($hArray[2],'datetime').'</td>';
			echo '</tr>';
		}
		echo '</table>';
		echo '</td>';
	echo '</tr>';
	} ?>
	<tr> 
		<td valign="top">Статус:</td> 
		<td valign="top">
			<select name="order_orderStatus" style="width:270px">
			<? echo getSelectedDropDown('arrayStatus',$outputOrder[0]['orderStatus']); ?>
			</select>
		</td> 
	</tr>
	<tr>
		<td valign="top">Приоритет:</td>
		<td valign="top">
			<select name="order_orderPriority" >
			<?
				if(empty($getvar['order'])) $outputOrder[0]['orderPriority'] = '3';
				echo getSelectedDropDown('ddPriority', $outputOrder[0]['orderPriority']);
			?>
			</select>
		</td>
	</tr>
	<tr> 
		<td></td>
		<td><br><br>
			<?
			if($outputOrder[0]['orderStatus'] == 0 AND $outputOrder[0]['payMethod'] == '4') echo '<div style="color:#FF0000;padding-bottom:10px;">Предложить другой способ оплаты клиенту</div>';
			echo '&nbsp;<input type="submit" name="Submit3" class="button" value="  Сохранить  ">';
			?>
		</td>
	</tr>
	</table>
	</form>
	<script language="JavaScript">
		var registrationValidator = new Validator("order1");
		registrationValidator.addValidation('order_userName','req','Поле "Имя" не заполнено');
		registrationValidator.addValidation('order_userPatronymic','req','Поле "Отчество" не заполнено');
		registrationValidator.addValidation('order_userFamily','req','Поле "Фамилия" не заполнено');
		registrationValidator.addValidation('order_userPhone','req','Поле "Телефон" не заполнено');
		if(document.order1.order_userEmail.value != '') registrationValidator.addValidation('order_userEmail','email','Формат поля "E-mail" не соответствует');
	

		registrationValidator.setAddnlValidationFunction('checkSelect');
		function checkSelect() {
			<? if($outputOrder[0]['delivery'] == 3) { ?>
			if (document.order1.order_orderStatus.options[document.order1.order_orderStatus.selectedIndex].value == '4' && (document.order1.order_orderDeclaration.value == 0 || document.order1.order_orderDeclaration.value == '')) {
				document.order1.order_orderDeclaration.focus();
				alert('Заполните поле "№ товарной декларации"');
				return false;
			}
			<? }?>
		}

	</script>
     </td>
  </tr>
</table>