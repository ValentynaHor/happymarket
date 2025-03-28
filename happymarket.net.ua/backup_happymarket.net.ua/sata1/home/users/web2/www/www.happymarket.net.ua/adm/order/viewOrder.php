<script language="JavaScript" type="text/javascript" src="js/validator.js"></script>
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
		echo '<br><p class="messageOK">'.$userTitle.' <b>'.$user_userName.'</b> ('.$user_userNik.'), Ваша учетная запись успешно добавлена.<br /> Для авторизации введите ниже Ваш ник и пароль</p> ';
	}
	elseif($systemMessage == "okEdit")
	{
		echo '<br><p class="messageOK">'.$userTitle.' <b>'.$user_userName.'</b> ('.$user_userNik.'), Ваша учетная запись успешно изменена.</p>';
	}
	elseif($systemMessage == "error")
	{
		echo '<br><p class="messageERROR">Ошибка! Попробуйте еще раз.</p>';
	}
	
	if(empty($outputOrder[0]['delivery'])) $outputOrder[0]['delivery'] = 3;
	if($outputOrder[0]['orderCourse'] == '0.00')
	{
		if($outputOrder[0]["payMethod"] == '0' AND !empty($outputOrder[0]["delivery"])) $outputOrder[0]['orderCourse'] = $outputSetting[0]['courseUSD'];
		elseif($outputOrder[0]["payMethod"] == '3' OR $outputOrder[0]["payMethod"] == '1') $outputOrder[0]['orderCourse'] = $outputSetting[0]['courseNonCashNonNDSUSD'];
		else $outputOrder[0]['orderCourse'] = $outputSetting[0]['courseNonCashUSD'];
	}
?>
	<form name="order1" action="<?=$sid?>" method="post" enctype="multipart/form-data">
	<input type="hidden" name="viewMode" value="save" />
	<input type="hidden" name="delivery" value="<?=$outputOrder[0]['delivery']?>" />
	<table border=0 cellspacing=0 cellpadding=3>
	<tr>
		<td colspan="2" class="row2" style="font-size:14px; padding-bottom:12px;"><b><u>Заказ №<?=$getvar['order']?></u></b></td>
	</tr>
	<tr> 
		<td><strong>Товары:</strong></td>
		<td><? echo '<table cellpadding="5" cellspacing="1"><tr bgcolor="#BAD1E1" align="center"><td width="300px">Товар</td><td width="100">Наличие</td><td width="50">Цена</td><td width="50">Кол-во</td><td>&nbsp;</td></tr>'.$strName.'</table>'; ?></td>
	</td>
	<tr>
		<td>Дата создания:</td>
		<td>
			<input name="orderDate" value="<?=formatDate($outputOrder[0]['orderDate'],'date')?>" type="text" style="width:80px;" >
			<input name="orderTime" value="<?=substr($outputOrder[0]['orderDate'],11,5)?>" type="text" style="width:50px;" >
		</td>
	</tr>
	<tr>
		<td colspan="2" style="padding-bottom:5px; padding-top:5px;"><b>Личные данные:</b></td>
	</tr>
	<tr>
		<td width="170px">ФИО:</td>
		<td>
			<?
			if(!empty($outputOrder[0]['userID']))
				echo '<a target="_blank" class="green" href="/adm/?viewUser/user/'.$outputOrder[0]['userID'].'" >'.$outputOrder[0]['userFamily'].' '.$outputOrder[0]['userName'].' '.$outputOrder[0]['userPatronymic'].'</a>';
			else
				echo $outputOrder[0]['userFamily'].' '.$outputOrder[0]['userName'].' '.$outputOrder[0]['userPatronymic'];
			?>
		</td>
	</tr>
	<tr> 
		<td>Телефон:</td>
		<td><?=$outputOrder[0]['userPhone']?></td>
	</tr>
	<tr>
		<td>Email:</td>
		<td><a href="mailto:<?=$outputOrder[0]['userEmail']?>"><?=$outputOrder[0]['userEmail']?></a></td>
	</tr>
	<tr> 
		<td>Доставка:</td>
		<td>
		<?
			echo '<nobr>';
			if($outputOrder[0]['delivery'] == 1 or $outputOrder[0]['delivery'] == 0) echo 'без доставки';
			elseif($outputOrder[0]['delivery'] == 2) echo 'доставка по Киеву';
			elseif($outputOrder[0]['delivery'] == 3) echo 'доставка по Украине';
			echo '</nobr>';
		?>
		</td>
	</tr>
	<? if(!empty($outputOrder[0]['userAdress'])) { ?>
	<tr> 
		<td>Адрес и время доставки:</td>
		<td><?=$outputOrder[0]['userAdress']?></td>
	</tr>
	<? }?>
	<tr> 
		<td>Сумма:</td>
		<td>
		<? 
			echo '<span style="color:red">'.round($outputOrder[0]['wareSum'], 2).' грн.</span>';
		?>
		</td>
	</tr>
	<tr> 
		<td>Дата заказа:</td>
		<td><?=formatDate($outputOrder[0]['timeCreated'], 'datetime')?></td>
	</tr>
	<? if($outputOrder[0]['payMethod'] == 4 OR $outputOrder[0]['payMethod'] == 5 OR $outputOrder[0]['payMethod'] == 6){ ?>
	<tr> 
		<td>Код подтверждения:</td>
		<td><? echo '<a href="'.urlse.'/order/'.$getvar['order'].'/">'.$outputOrder[0]['code'].'</a>';?></td>
	</tr>
	<? }?>
	<tr> 
		<td>Оплачено:</td>
		<td><?=getValueDropDown('ddYesNo', $outputOrder[0]['prepaid'])?></td>
	</tr>
	<? if(!empty($outputOrder[0]['userAdd'])){ ?>
	<tr> 
		<td>Создал:</td>
		<td><? echo getValueDropDown('ddUserType', $ddAllManager[$outputOrder[0]['userAdd']]['userType']).' '.$ddAllManager[$outputOrder[0]['userAdd']]['userName'].', тел.: '.$ddAllManager[$outputOrder[0]['userAdd']]['userPhone']; ?></td>
	</tr>
	<? }?>
	<? if(!empty($outputOrder[0]['userSource'])) { ?>
	<tr> 
		<td>Откуда Вы узнали о нас:</td>
		<td><?=$outputOrder[0]['userSource']?></td>
	</tr>
	<? }?>
	<? if(!empty($outputOrder[0]['userComment'])) { ?>
	<tr> 
		<td>Дополнительная информация и пожелания:</td>
		<td><?=$outputOrder[0]['userComment']?></td>
	</tr>
	<? }?>
	<tr> 
		<td colspan="2"><hr class="adm" width="446px" align="left"></td> 
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
		<td colspan="2"><hr class="adm" width="446px" align="left"></td> 
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
		<td colspan="2"><hr class="adm" width="446px" align="left"></td> 
	</tr>
	<? if(!empty($outputOrder[0]['orderHistory'])) {
	echo '<tr>';
		echo '<td colspan="2">';
		echo '<table width="447px" style="border:1px solid #FFFFFF" cellpadding="5" cellspacing="1">';
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

		registrationValidator.setAddnlValidationFunction('checkSelect');
		function checkSelect() {
			var regexp = /^(\d{2}\.\d{2}\.\d{4})$/;

			if(!regexp.test(document.order1.orderDate.value))

			{

				document.order1.orderDate.focus();

				alert('Формат даты не соответствует dd.mm.yyyy');

				return false;

			}

			var regexp = /^(\d{2}\:\d{2})$/;

			if(!regexp.test(document.order1.orderTime.value))

			{

				document.order1.orderTime.focus();

				alert('Формат времени не соответствует hh:mm');

				return false;

			}

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
