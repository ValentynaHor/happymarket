<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
<title>Deshevshe.net.ua</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="Content-Language" content="ru">
<meta name="Description" content="Каталог: мониторы, процессоры, материнские платы, видеокарты, винчестеры, память, CD-ROM, CD-RW, DVD, корпуса, клавиатуры, мышки, принтеры, сканеры, модемы...">
<meta name="Keywords" content="компьютерный каталог, интернет-магазин компьютеры Киев, каталог комплектующих, периферия, офисная техника, покупка, продажа, модернизация, доставка">
<meta http-equiv="Content-Script-Type" content="text/javascript">
<meta http-equiv="Content-Style-Type" content="text/css">
<meta name="Author" CONTENT="Vitaliy Yatsenko">
<meta name="Author-Email" content="webvit@ukr.net">
<link type="text/css" rel="stylesheet" href="css/style.css" />
<base href='<?php echo urlse; ?>/adm/' />
<script type="text/javascript">function printPage() {window.print();}</script>
</head>
<!--table border="0" cellspacing="0" cellpadding="8" width="92%" align="center"-->
<!--body topmargin="0px" leftmargin="0px" rightmargin="0px" bottommargin="0px" onLoad="self.resizeTo(825,768);"-->
<body topmargin="0px" leftmargin="0px" rightmargin="0px" bottommargin="0px" onLoad="printPage()">
<table cellpadding="0" cellspacing="0" style="width:19cm; height:27cm; margin-left:5px;" >
  <tr>
 	 <td align="left" valign="top">
<? 
for($i=0; $i < $outputOrder['rows']; $i++)
{
	if(empty($outputOrder[$i]['delivery'])) $outputOrder[$i]['delivery'] = 3;
	if($outputOrder[$i]['orderCourse'] == '0.00')
	{
		if($outputOrder[$i]["payMethod"] == '0' AND !empty($outputOrder[$i]["delivery"])) $outputOrder[$i]['orderCourse'] = $outputSetting[0]['courseUSD'];
		elseif($outputOrder[$i]["payMethod"] == '3' OR $outputOrder[$i]["payMethod"] == '1') $outputOrder[$i]['orderCourse'] = $outputSetting[0]['courseNonCashNonNDSUSD'];
		else $outputOrder[$i]['orderCourse'] = $outputSetting[0]['courseNonCashUSD'];
	}
?>
	<div style="text-align:center; margin-bottom:5px;"><b>Заказ №<?=$outputOrder[$i]['orderGroupID']?></b></div>
	<table border=0 cellspacing=0 cellpadding=1>
	<tr> 
		<td width="200px">ФИО:</td>
		<td>
			<a class="green" href="/adm/?viewUser/user/<?=$outputOrder[$i]['userID']?>" ><?=$outputOrder[$i]['userFamily']?> <?=$outputOrder[$i]['userName']?> <?=$outputOrder[$i]['userPatronymic']?></a>
		</td>
	</tr>
	<tr> 
		<td width="200px">Email:</td>
		<td>
			<a href="mailto:<?=$outputOrder[$i]['userEmail']?>"><?=$outputOrder[$i]['userEmail']?></a>    
		</td>
	</tr>
	<tr> 
		<td>Адрес:</td>
		<td>
			<?=$outputOrder[$i]['userAdress']?>  
		</td>
	</tr>
	<tr> 
		<td width="200px">Телефон:</td>
		<td>
			<?=$outputOrder[$i]['userPhone']?>  
		</td>
	</tr>
	<? 
	if(!empty($outputOrder[$i]['userComment'])) {
	?>
	<tr> 
		<td width="200px">Дополнительная информация и пожелания:</td>
		<td>
			<?=$outputOrder[$i]['userComment']?>  
		</td>
	</tr>
	<? }?>
	<tr>
	<td width="200px">Товары:</td>
	<td>
		<? 
		$outputOrder[$i]['wareNames'] = del_tags($outputOrder[$i]['wareNames']);
		$arrayID = explode("||",$outputOrder[$i]['orderID']);
		$arrayName = explode("||",$outputOrder[$i]['wareNames']);
		$arrayPrice = explode("||",$outputOrder[$i]['warePrice']);
		$strName = '';
		for($j=0; $j < count($arrayID); $j++)
		{
			$strName .= '<div>'.$arrayName[$j].'&nbsp;-&nbsp;$'.$arrayPrice[$j].'</div>';
		}
	
			echo '<nobr>'.$strName.'</nobr>';
		?>
		</td>
	</tr>
	<tr> 
		<td>Тип оплаты:</td>
		<td>
			<?=getValueDropDown('ddWayPaying', $outputOrder[$i]['payMethod'])?>
		</td>
	</tr>
	<? 
	if(!empty($outputOrder[$i]['userCity'])) {
	?>
	<tr> 
		<td>Город доставки:</td>
		<td>
			<?=$outputOrder[$i]['userCity']?>  
		</td>
	</tr>
	<? }?>
	<tr> 
		<td>Доставка:</td>
		<td>
			<?
			echo '<nobr>';
			if($outputOrder[$i]['delivery'] == 3 AND !empty($outputOrder[$i]['deliveryPrice']))
			{
				$dlvry_price_usd = round($outputOrder[$i]['deliveryPrice']/$outputOrder[$i]['orderCourse'],2);
				$dlvry_price_grn = $outputOrder[$i]['deliveryPrice'];
				echo '<b>$'.(round($outputOrder[$i]['deliveryPrice']/$outputOrder[$i]['orderCourse'],2)).'</b>&nbsp;('.$outputOrder[$i]['deliveryPrice'].' грн.) / ';
			}
			elseif($outputOrder[$i]['delivery'] == 2 AND !empty($outputOrder[$i]['deliveryPrice']))
			{
				$dlvry_price_usd = round(@($outputOrder[$i]['deliveryPrice']/count($arrayID))/$outputOrder[$i]['orderCourse'],2);
				$dlvry_price_grn = @ $outputOrder[$i]['deliveryPrice']/count($arrayID);
				echo '<b>$'.(round(@($outputOrder[$i]['deliveryPrice']/count($arrayID))/$outputOrder[$i]['orderCourse'],2)).'</b>&nbsp;('.(@$outputOrder[$i]['deliveryPrice']/count($arrayID)).' грн.) / ';
			}
	
			if($outputOrder[$i]['delivery'] == 1 or $outputOrder[$i]['delivery'] == 0) echo 'без доставки';
			elseif($outputOrder[$i]['delivery'] == 2) echo 'доставка по Киеву';
			elseif($outputOrder[$i]['delivery'] == 3) echo 'доставка по Украине';
			echo '</nobr>';
			?>
		</td>
	</tr>
	<? if($outputOrder[$i]['payMethod'] != 5) {?>
	<tr> 
		<td>Курс $:<br><small>(на момент заказа)</small></td>
		<td><?=$outputOrder[$i]['orderCourse']?> грн.</td>
	</tr>
		<? }?>
	<tr> 
		<td>Сумма:</td>
		<td>
		<? 
			echo '<span style="color:red">'.round($outputOrder[$i]['wareSum']*$outputOrder[$i]['orderCourse']).' грн.</span> ($'.$outputOrder[$i]['wareSum'].')';
			if(isset($dlvry_price_grn) AND !empty($dlvry_price_grn)) echo ' + '.$dlvry_price_grn.' грн. ($'.$dlvry_price_usd.') (доставка)';
		?>
		</td>
	</tr>
	<tr> 
		<td>Итого:</td>
		<td>
		<? 
			if($outputOrder[$i]['payMethod'] == 5)
			{
				echo '<nobr><span style="color:red">'.round((($outputOrder[$i]['wareSum'] + $outputOrder[$i]['deliveryPrice']/$outputSetting[0]['courseNonCashUSD'])*$outputSetting[0]['WMZ']),1).' WMZ</span> ($'.($outputOrder[$i]['wareSum'] + round($outputOrder[$i]['deliveryPrice']/$outputOrder[$i]['orderCourse'],1)).')';
				echo ' Курс WebMoney: '.$outputSetting[0]['WMZ'].'</nobr>';
			}
			else if($outputOrder[$i]['payMethod'] == 6)
			{
				echo '<span style="color:red">$'.($outputOrder[$i]['wareSum'] + round($outputOrder[$i]['deliveryPrice']/$outputOrder[$i]['orderCourse'],1)).'</span>';
			}
			else if(($outputOrder[$i]['delivery'] == 2 OR $outputOrder[$i]['delivery'] == 3) AND !empty($dlvry_price_grn))
				echo '<span style="color:red">'.(round($outputOrder[$i]['wareSum']*$outputOrder[$i]['orderCourse'])+$dlvry_price_grn).' грн.</span> ($'.($outputOrder[$i]['wareSum'] + $dlvry_price_usd).')';
			else
				echo '<span style="color:red">'.(round($outputOrder[$i]['wareSum']*$outputOrder[$i]['orderCourse'])).' грн.</span> ($'.$outputOrder[$i]['wareSum'].')';
		?>
		</td>
	</tr>
	<tr> 
		<td>Дата заказа:</td>
		<td>
			<?=formatDate($outputOrder[$i]['timeCreated'], 'datetime')?>
		</td>
	</tr>
	<? if($outputOrder[$i]['payMethod'] == 4 OR $outputOrder[$i]['payMethod'] == 5 OR $outputOrder[$i]['payMethod'] == 6) { ?>
	<tr> 
		<td>Код подтверждения:</td>
		<td>
			<? echo ''.$outputOrder[$i]['code'].'';?>
		</td>
	</tr>
	<? } ?>
	<? if(!empty($outputOrder[$i]['orderNumber'])) { ?>
	<tr> 
		<td valign="top">№ накладной:</td>
		<td valign="top"><?=$outputOrder[$i]['orderNumber']?></td>
	</tr>
	<? } ?>
	<? if($outputOrder[$i]['delivery'] == 3 AND !empty($outputOrder[$i]['orderDeclaration'])) { ?>
	<tr> 
		<td valign="top">№ товарной декларации:</td>
		<td valign="top"><?=$outputOrder[$i]['orderDeclaration']?></td>
	</tr> 
	<? } ?>
	<? if(!empty($outputOrder[$i]['orderPurchase'])) { ?>
	<tr> 
		<td valign="top">Закупка со склада:</td>
		<td valign="top"><?=$outputOrder[$i]['orderPurchase']?></td>
	</tr> 
	<? } ?>
	<? if(!empty($outputOrder[$i]['orderNote'])) { ?>
	<tr> 
		<td valign="top">Заметки:</td> 
		<td valign="top"><?=$outputOrder[$i]['orderNote']?></td> 
	</tr>
	<? } ?>
	<? if(($outputOrder[$i]['delivery'] == 2 OR $outputOrder[$i]['delivery'] == 3) AND ($outputOrder[$i]['orderStatus'] == '1' OR $outputOrder[$i]['orderStatus'] == '3' OR $outputOrder[$i]['orderStatus'] == '4')) { ?>
	<tr>
		<td valign="top">Время доставки:</td> 
		<td valign="top"><?=formatDate($outputOrder[$i]['deliveryDate'], 'date').'&nbsp; &nbsp;с&nbsp;'.substr($outputOrder[$i]['deliveryTimeStart'],0,5).'&nbsp;до&nbsp;'.substr($outputOrder[$i]['deliveryTimeEnd'],0,5)?></td> 
	</tr>
		<? if(!empty($outputOrder[$i]['deliveryComment'])) { ?>
		<tr>
			<td valign="top">Комментарий:</td> 
			<td valign="top"><?=$outputOrder[$i]['deliveryComment']?></td> 
		</tr>
		<? } ?>
	<? } ?>
	<?
	if(!empty($outputOrder[$i]['orderHistory']))
	{
		$historyArray = @ explode('&',$outputOrder[$i]['orderHistory']);
		for($h=1; $h < count($historyArray)-1; $h++)
		{
			$hArray = @ explode('|',$historyArray[$h]); 
			if($hArray[0] == '1')
			{
				echo '<tr>';
					echo '<td valign="top">'.getValueDropDown('ddOrderStatus',$hArray[0]).':</td>';
					echo '<td valign="top">'; if($hArray[1] != 'Клиент' AND $hArray[1] != '555') { echo getValueDropDown('ddUserType',$ddAllManager[$hArray[1]]['userType']).' <a class="green" href="/adm/?viewUser/user/'.$hArray[1].'" >'.$ddAllManager[$hArray[1]]['userNik'].'</a>&nbsp;['.$ddAllManager[$hArray[1]]['userName'].']'; } elseif($hArray[1] == 'Клиент') { echo 'Клиент'; } elseif($hArray[1] == '555') { echo 'Root'; } echo '&nbsp;('.formatDate($hArray[2],'datetime').')</td>';
				echo '</tr>';
				break;
			}
		}
	}
	?>
	</table>
<?
if($outputOrder['rows'] > 1) echo '<hr class="adm"><br>';
}
?>
     </td>
  </tr>
</table>

</body>
</html>