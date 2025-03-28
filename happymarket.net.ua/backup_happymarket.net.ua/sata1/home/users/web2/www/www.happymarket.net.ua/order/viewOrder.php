<? if(!empty($userArray['userID'])) { ?>
<?php 
if(($outputOrder[0]['userID'] == $userArray['userID'] OR $userArray['groupID'] == 'admin' OR  $userArray['groupID'] == 'manager') AND $loginStatus =='yes')
{

if(!empty($getvar['page'])) $pageInsStr = 'page/'.$getvar['page'].'/'; else $pageInsStr = "";
if(!empty($getvar['filter'])) $filterInsStr = 'filter/'.$getvar['filter'].'/'; else $filterInsStr = "";

if(empty($outputOrder[0]['delivery'])) $outputOrder[0]['delivery'] = 3;
if($outputOrder[0]['orderCourse'] == '0.00')
{
	if($outputOrder[0]["payMethod"] == '0' AND !empty($outputOrder[0]["delivery"])) $outputOrder[0]['orderCourse'] = $outputSetting[0]['courseUSD'];
	elseif($outputOrder[0]["payMethod"] == '3' OR $outputOrder[0]["payMethod"] == '1') $outputOrder[0]['orderCourse'] = $outputSetting[0]['courseNonCashNonNDSUSD'];
	else $outputOrder[0]['orderCourse'] = $outputSetting[0]['courseNonCashUSD'];
}
?>
<table cellspacing="0" cellpadding="8" width="100%" align="center">
<tr>
	<td align="left">

	<table cellspacing="0" cellpadding="2">
	<tr> 
		<td width="100px" class="rowgreen">ФИО:</td>
		<td>
		<a class="green" href="profile/" ><?=$outputOrder[0]['userFamily']?> <?=$outputOrder[0]['userName']?> <?=$outputOrder[0]['userPatronymic']?></a>
		</td>
	</tr>
	<tr> 
		<td class="rowgreen">E-mail:</td>
		<td>
		<a href="mailto:<?=$outputOrder[0]['userEmail']?>"><img style="padding:0px;margin:0px" src="../service/mail.php?adr=<?=str_rot13($outputOrder[0]['userEmail'])?>&size=2&red=140&green=140&blue=140"></a>    
		</td>
	</tr>
	<tr> 
		<td class="rowgreen">Адрес:</td>
		<td>
		<?=$outputOrder[0]['userAdress']?>  
		</td>
	</tr>
	<tr> 
		<td class="rowgreen">Телефон:</td>
		<td>
		<?=$outputOrder[0]['userPhone']?>  
		</td>
	</tr>
	<tr> 
		<td class="rowgreen" valign="top" style="padding:10px 0px 10px 0px;">Товары:</td>
		<td style="padding:10px 0px 10px 0px;">
		<?
			echo '<table cellpadding="2" cellspacing="0">';
			echo $strName;
			echo '</table>';
		?>
		</td>
	</tr>
	<? if(!empty($outputOrder[0]['userCity'])) { ?>
	<tr>
		<td class="rowgreen">Город доставки:</td>
		<td>
		<?=$outputOrder[0]['userCity']?>
		</td>
	</tr>
	<? } ?>
	<tr> 
		<td class="rowgreen">Доставка:</td>
		<td>
			<?
			echo '<nobr>';
				if($outputOrder[0]['delivery'] == 1) echo "без доставки";
				elseif($outputOrder[0]['delivery'] == 2) echo "доставка по Киеву";
				elseif($outputOrder[0]['delivery'] == 3) echo "доставка по Украине";
				else echo "без доставки";
			echo '</nobr>';
			?>
		</td>
	</tr>
	<tr> 
		<td class="rowgreen">Сумма:</td>
		<td>
		<? 
			echo '<span style="color:red">'.round($KOFF*$outputOrder[0]['wareSum'], 2).' грн.</span>';
		?>
		</td>
	</tr>
	<tr> 
		<td class="rowgreen">Дата заказа:</td>
		<td>
			<?=formatDate($outputOrder[0]['timeCreated'], 'datetime')?>
		</td>
	</tr>
	<tr>
        	<td class="2" colspan="2"><br>
		<?
		if(!empty($paymentStatus) AND $paymentStatus == 'success' AND $orderID == $outputOrder[0]['orderGroupID'] AND $outputOrder[0]['payMethod'] == 5)
		{
			echo '<div style="color:green">Ваш заказ успешно оплачен в системе WebMoney Transfer</div><br />'; 
		}
		else if(!empty($paymentStatus) AND $paymentStatus == 'success' AND $_POST['SHOPORDERNUMBER'] == $outputOrder[0]['orderGroupID'] AND $outputOrder[0]['payMethod'] == 4)
		{
			echo '<div style="color:green">Ваш заказ успешно оплачен в системе Portmone.com</div><br />'; 
		}
		else if(!empty($paymentStatus) AND $paymentStatus == 'success' AND $_POST['inv_id'] == $outputOrder[0]['orderGroupID'] AND $outputOrder[0]['payMethod'] == 6)
		{
			echo '<div style="color:green">Ваш заказ успешно оплачен в системе ROBOXchange.com</div><br />'; 
		}
		else if (!empty($paymentStatus) AND $paymentStatus == 'failure')
		{
			echo '<div style="color:red">Ваш заказ не оплачен</div><br />';
			echo '<div >Обратитесь в службу поддержки support@deshevshe.net.ua</div><br />';
		}
		else if(!empty($paymentStatus) AND ($paymentStatus == 'failure' OR $paymentStatus == 'success'))
		{
			echo '<div style="color:red">Ваш заказ не оплачен</div><br />';
			echo '<div >Обратитесь в службу поддержки support@deshevshe.net.ua</div><br />';
		}
		?>
		</td>
	</tr>
	
	<?
	if(($outputOrder[0]['payMethod'] == 4 OR $outputOrder[0]['payMethod'] == 5 OR $outputOrder[0]['payMethod'] == 6) AND (empty($codeReg)) AND empty($paymentStatus))
	{
	echo '<tr>'; 
		echo '<form name="checkcode" action="'.$sid.'" method="post" enctype="multipart/form-data">';
		echo '<td class="rowgreen">Введите код</td>';
		echo '<td>';
		echo '<input type="hidden" name="viewMode" value="save" />';
		echo '<input type="text" name="codeReg" value="" />';
		echo '<input type="submit" name="Submit" class="button" value="Подтвердить" style="margin-left:15px">';
		echo '<br>';
		echo '</td>';
		echo '</form>';
	echo '</tr>';
	}
	?>
	</table>

	<? if (!empty($codeReg) AND $codeStatus == 1 AND $outputOrder[0]['payMethod'] == 4) { ?>
	<div style="color:green">Код подтверждения введен верно</div>
	<FORM ACTION="https://www.portmone.com.ua/3dsecure/index.php" method="POST" style="padding:0px;">
	<input type="HIDDEN" name="UTF8" value="1">
	<INPUT TYPE="HIDDEN" NAME="PAYEE_ID" VALUE="2399">
	<INPUT TYPE="HIDDEN" NAME="SHOPORDERNUMBER" VALUE="<?=$outputOrder[0]['orderGroupID']?>">
	<INPUT TYPE="HIDDEN" NAME="BILL_AMOUNT" VALUE="<? echo round($outputOrder[0]['wareSum']*$outputOrder[0]['orderCourse']+$outputOrder[0]['deliveryPrice']); ?>">
	<INPUT TYPE="HIDDEN" NAME="EMAIL" VALUE="<?=$outputOrder[0]['userEmail']?>">
	<INPUT TYPE="HIDDEN" NAME="DESCRIPTION"  VALUE="Оплата заказа">
	<INPUT TYPE="HIDDEN" NAME="SUCCESS_URL" VALUE="http://deshevshe.net.ua/order/<?=$outputOrder[0]['orderGroupID']?>/success/">
	<INPUT TYPE="HIDDEN" NAME="FAILURE_URL" VALUE="http://deshevshe.net.ua/order/<?=$outputOrder[0]['orderGroupID']?>/failure/">
	<INPUT TYPE="HIDDEN" NAME="LANG" VALUE="ru">
	<INPUT TYPE="submit" NAME="submit" VALUE="Оплатить" style="cursor:hand;">
	</FORM>
	<? } else if (!empty($codeReg) AND $codeStatus == 1 AND $outputOrder[0]['payMethod'] == 5) {
	$descriptionWM = iconv("UTF-8", "CP1251",'Оплата заказа в интернет-магазине Deshevshe.net.ua');
	//<input type="hidden" name="LMI_PAYEE_PURSE" value="Z767148004388">
	?>
	<form id=pay name=pay method="POST" action="https://merchant.webmoney.ru/lmi/payment.asp"  style="padding:0px;">
	<input type="hidden" name="LMI_PAYMENT_AMOUNT" value="<?=round((($outputOrder[0]['wareSum']+$outputOrder[0]['deliveryPrice']/$outputSetting[0]['courseNonCashUSD'])*$outputSetting[0]['WMZ']),1)?>">
	<input type="hidden" name="LMI_PAYMENT_DESC" value="Oplata zakaza №<?=$outputOrder[0]['orderGroupID']?> na Deshevshe.net.ua">
	<input type="hidden" name="LMI_PAYMENT_NO" value="<?=$outputOrder[0]['orderGroupID']?>">
	<input type="hidden" name="LMI_PAYEE_PURSE" value="Z783410238158">
	<input type="hidden" name="LMI_SIM_MODE" value="1">
	<input type="hidden" name="LMI_SUCCESS_URL" value="http://deshevshe.net.ua/order/<?=$outputOrder[0]['orderGroupID']?>/success/">
	<input type="hidden" name="LMI_FAIL_URL" value="http://deshevshe.net.ua/order/<?=$outputOrder[0]['orderGroupID']?>/failure/">
	<input type="submit" name="submit" value="Оплатить" style="cursor:hand;">
	</form>
	<? } else if (!empty($codeReg) AND $codeStatus == 1 AND $outputOrder[0]['payMethod'] == 6) {
		//if($userArray['userNik'] == 'Ginostra')
		//{
		$mrh_login = "deshevshe";        //логин
		$mrh_pass1 = "3jKsd2pcS";    //пароль1
		
		//параметры магазина
		$inv_id    =  $outputOrder[0]['orderGroupID'];                //номер счета
		//описание покупки
		$inv_desc  = "ROBOXchange";
		$out_summ  = round((($outputOrder[0]['wareSum']+$outputOrder[0]['deliveryPrice']/$outputSetting[0]['courseNonCashUSD'])*$outputSetting[0]['WMZ']),1);          //сумма покупки
		$shp_item = 1;                // тип товара

		//формирование подписи
		$crc  = md5("$mrh_login:$out_summ:$inv_id:$mrh_pass1:shp_item=$shp_item");
		
		//вывод HTML страницы с кассой
		print "<html><script language=JavaScript ".
			  "src='http://www.roboxchange.com/mrh_summpreview.asp?".
			  "mrh=$mrh_login&out_summ=$out_summ&inv_id=$inv_id&inv_desc=$inv_desc".
			  "&crc=$crc&shp_item=$shp_item&charset=utf-8'></script></html>";
		//}
	} else if (!empty($codeReg) AND $codeStatus == 0) {
	echo '<div style="color:red">Код подтверждения введен не верно</div><br />';
	echo '<div >Обратитесь в службу поддержки support@deshevshe.net.ua</div><br />';
	}
	?>

	</td>
</tr>
</table>
<?
}
?>
<a class="level2" href="<?=$urlve?>orders/">Все заказы</a>
<?
}
else
{
	include_once('session/login.php');
}
?>