<div align="center">
<div style="width:740px">

<?php
if(empty($outputCart))
{
	echo '<br /><br /><b>Ваша корзина пуста...</b><br /><br />';
}
else
{
?>
	<table width="100%" cellpadding="5" cellspacing="2" class="cart_table" border=0>
	<tr align="center">
		<td width="150px" class="thrift_price">фото</td>
		<td width="*" class="thrift_price">название</td>
		<td width="10%" class="thrift_price">цена<br>(1шт.)</td>
		<td width="7%" class="thrift_price">кол-во</td>
		<td width="10%" class="thrift_price">цена<br>(общ.)</td>
		<td width="10%" class="thrift_price">&nbsp;</td>
	</tr>
	<?

	$FLAG_DIGITAL_TECH = false; $STR_BRAND_TEXT = ''; $STR_BRAND_MIN_SUM = ''; $FLAG_BRAND_TEXT = ''; $FLAG_BRAND_MIN_SUM = '';

	echo '<form name="calc" action="cart" method="post" enctype="multipart/form-data">';
	for ($i=0; $i < count($outputCart['resource']); $i++)
	{
		if(!empty($BRAND_ARRAY[$outputCart['resource'][$i]['resourceBrand']]['brandAlias'])) { $wareBrandStr = $BRAND_ARRAY[$outputCart['resource'][$i]['resourceBrand']]['brandAlias'].'-'; }
		else $wareBrandStr = '';

		if(!empty($BRAND_ARRAY[$outputCart['resource'][$i]['resourceBrand']]['brandDelivery']) AND $FLAG_BRAND_TEXT[$outputCart['resource'][$i]['resourceBrand']] != 1)
		{
			$STR_BRAND_TEXT .= $BRAND_ARRAY[$outputCart['resource'][$i]['resourceBrand']]['brandDelivery'].'<br>';
			$FLAG_BRAND_TEXT[$outputCart['resource'][$i]['resourceBrand']] = 1;
		}
		if(!empty($BRAND_ARRAY[$outputCart['resource'][$i]['resourceBrand']]['minSumOrder']) AND $FLAG_BRAND_MIN_SUM[$outputCart['resource'][$i]['resourceBrand']] != 1)
		{
			$STR_BRAND_MIN_SUM .= 'Минимальная сумма заказа для продукции <strong>'.$BRAND_ARRAY[$outputCart['resource'][$i]['resourceBrand']]['brandName'].'</strong>: '.$BRAND_ARRAY[$outputCart['resource'][$i]['resourceBrand']]['minSumOrder'].' грн.<br>';
			$FLAG_BRAND_MIN_SUM[$outputCart['resource'][$i]['resourceBrand']] = 1;
		}

		echo '<tr align="center">';
			if(!empty($outputCart['resource'][$i]['resourceImage']))
			{
				echo '<td><a href="'.$SUB_ID_TO_ALIAS[$outputCart['resource'][$i]['subCategoryID']].'/'.$outputCart['resource'][$i]['resourceAlias'].'-'.$wareBrandStr.$outputCart['resource'][$i]['resourceID'].'"><img src="images/resource/'.$catID_Alias[$outputCart['resource'][$i]['categoryID']].'/'.$outputCart['resource'][$i]['subCategoryID'].'/2/'.$outputCart['resource'][$i]['resourceImage'].'"></a></td>';
			}
			else
			{
				echo '<td><b>Фото нет</b></td>';
			}
			echo '<td align="left">';
				echo '<a  class="red" href="'.$SUB_ID_TO_ALIAS[$outputCart['resource'][$i]['subCategoryID']].'/'.$outputCart['resource'][$i]['resourceAlias'].'-'.$wareBrandStr.$outputCart['resource'][$i]['resourceID'].'" >'.$outputCart['resource'][$i]['resourceName'].'</a>';
				echo '<br>'.getValueDropDown('ddPresenceClient', $outputCart['resource'][$i]['presence']);
				if(!empty($outputCart['resource'][$i]['resourcePos']))
				{
					$arrayWarePos = @explode('**',$outputCart['resource'][$i]['resourcePos']);
					$stringWarePos = ''; $SEP = '';
					for($e=0; $e < count($arrayWarePos); $e++)
					{
						$expolodeWarePos = @explode('|&|',$arrayWarePos[$e]);
						$stringWarePos .= $SEP.$expolodeWarePos[1];
						$SEP = '; ';
					}
					if(!empty($stringWarePos)) echo '<div style="font-size:12px;">'.$stringWarePos.'</div>';
				}
			echo '</td>';
			echo '<td><nobr>'.round($outputCart['resource'][$i]['resourcePrice'],2).' грн.</nobr></td>';
			if (!empty($outputCart['resource'][$i]['resourceCount']))
			{
				echo '<td><input type="text" name="waresCount['.$outputCart['resource'][$i]['index'].']" style="width:45px;" maxlength="5" value="'.$outputCart['resource'][$i]['resourceCount'].'"></td>';
			} else {
				echo '<td><input type="text" name="waresCount['.$outputCart['resource'][$i]['index'].']" style="width:45px;" maxlength="5" value="1"></td>';
			}
			echo '<td><nobr>'.@round($outputCart['resource'][$i]['resourcePrice']*$outputCart['resource'][$i]['resourceCount'],2).' грн.</nobr></td>';
			echo '<td><a href="/cart/delete/'.$outputCart['resource'][$i]['index'].'/" valign="middle" class="note"title="Удалить '.$outputCart['resource'][$i]['resourceName'].'"><img src="images/classic/delete.gif" width="35" height="21"></a></td>';
		echo '</tr>';

		if(!empty($outputCart['resource'][$i]['resourcePos'])) $color = '('.$stringWarePos.')'; else $color = '';
		if($outputCart['resource'][$i]['presence'] == '2') $presence = '&#160;/&#160;нет в наличии'; else $presence = '';
		$order .= '&#160;&#149;&#160;<a href="'.urlse.'/'.$SUB_ID_TO_ALIAS[$outputCart['resource'][$i]['subCategoryID']].'/'.$outputCart['resource'][$i]['resourceAlias'].'-'.$wareBrandStr.$outputCart['resource'][$i]['resourceID'].'">'.$outputCart['resource'][$i]['resourceName'].' '.$color.'</a>'.$presence.' ........................ '.$outputCart['resource'][$i]['resourcePrice'].' грн. ['.$outputCart['resource'][$i]['resourceCount'].' шт.]<br/>';

		if(strstr($CAT_ARRAY[$outputCart['resource'][$i]['categoryID']]['categoryName'],'Цифровая техника'))
		{
			$FLAG_DIGITAL_TECH = true;
		}
	}
	?>
	</table>

	<table width="100%" cellpadding="0" cellspacing="2" border="0">
	<tr>
		<td width="100" class="totalPrice" align="left"><nobr>Общая сумма:</nobr></td>
		<td width="130" class="totalPrice"><b><?=$incart_total?> грн.</b></td>
		<td width="*">&nbsp;</td>
		<td align="right" width="105">
			<input type="image" src="images/classic/recalculate.gif" name="calc" class="inputnontext">
		</td>
		</form>

		<form name="selection" action="/cart/empty/all" method="post" enctype="multipart/form-data">
		<td align="left" width="90">
			<input type="image" src="images/classic/clear.gif" name="Submit" class="inputnontext">
		</td>
		</form>

		<form name="selection" action="cart/forma#order" method="post" enctype="multipart/form-data">
		<input type="hidden" name="order" value="1">
		<td align="right" width="90">
			<input type="image" src="images/classic/order.gif" name="Submit" class="inputnontext">
		</td>
		</form>

	</tr>
	</table>

	<?
		echo '<a href="'.$sid.'" id="order"></a>';
		echo '<a href="'.$sid.'" id="send"></a>';

/*		if(!empty($STR_BRAND_TEXT) OR !empty($STR_BRAND_MIN_SUM) OR !empty($outputSetting[0]['minSumOrder']))
		{
			echo '<fieldset style="border:1px solid #bbc5cd;margin-top:10px;">';
				echo '<legend><strong>Примечания</strong>:</legend>';
				echo $STR_BRAND_TEXT;
				echo $STR_BRAND_MIN_SUM;
				if(empty($STR_BRAND_MIN_SUM) AND !empty($outputSetting[0]['minSumOrder'])) echo 'Минимальная сумма заказа: '.$outputSetting[0]['minSumOrder'];
			echo '</fieldset>';
		}
*/	?>

	<? if($_POST["order"] == '1') { ?>
	<br><br>

	<script language="JavaScript" type="text/javascript" src="js/validator.js"></script>
	<table cellpadding="1" cellSpacing="1" border="0">
	<form name='order' action="cart/zakaz#send" method="post"  enctype="multipart/form-data">
	<tr>
		<td width="175px">Ваше имя:</td>
		<td><input name="name" type="text" value="<?=$userArray['userName']?>" style="width:270px"> <span style="color:#FF0033">*</span></td>
	</tr>
	<tr>
		<td width="175px">Фамилия:</td>
		<td><input name="family" type="text" value="<?=$userArray['userFamily']?>" style="width:270px"> <span style="color:#FF0033">*</span></td>
	</tr>
	<tr>
		<td>Телефон:</td>
		<td><input name="phone" type="text" value="<?=$userArray['userPhone']?>" style="width:270px"> <span style="color:#FF0033">*</span></td>
	</tr>
	<tr>
		<td>E-mail:</td>
		<td><input name="email" type="text" value="<?=$userArray['userEmail']?>" style="width:270px"> <span style="color:#FF0033">*</span></td>
	</tr>
	<tr>
	<td valign="top">Вариант доставки:</td>
	<td valign="top">
		<table width="100%" cellspacing="0" cellpadding="0">
		<tr>
			<td width="30px" height="20px" align="left"><input id="dlvry2" name="delivery" type="radio" style="height:19px; width:19px; border:0px;" value="2" onClick="changeDropDown('Наличный расчет<?='. Курс $: '.$outputSetting[0]['courseUSD']?>',0,2);"></td>
			<td >Доставка по Киеву</td>
		</tr>
		<tr>
			<td width="30px" height="20px" align="left"><input id="dlvry3" name="delivery" type="radio" style="height:19px; width:19px; border:0px;" value="3" onClick="changeDropDown('Наличный расчет<?='. Курс $: '.$outputSetting[0]['courseUSD']?>',1,3);"></td>
			<td >Доставка по Украине</td>
		</tr>
		</table>
	</td>
	</tr>
	<tr>
		<td valign="top">Адрес и время доставки:</td>
		<td valign="top"><textarea name="address" style="width:270px" rows="4"></textarea>&#160;<span style="color:#FF0033; position:absolute; margin-top:3px">*</span></td>
	</tr>
	<tr>
		<td>Откуда Вы узнали о нас:</td>
		<td><input name="source" type="text" style="width:270px"></td>
	</tr>
	<tr>
		<td valign="top">Дополнительная информация<br /> и пожелания:</td>
		<td><textarea name="comment" style="width:270px" rows="3"></textarea><br />
			<div style="margin-top:4px; margin-bottom:4px" ><span style="color:#FF0033">*</span> - поля обязательные для заполнения</div>
		</td>
	</tr>
	<tr>
		<td></td>
		<td><input type="submit" value="Отправить" name="Submit" class="button1"></td>
	</tr>
	</form>
	<? /*
	<!-- // SnimiSlivki -->
	<script language='JavaScript'>
		//<!--
		var d = window.document;var ck=d.cookie.toString();var ssb=ck.indexOf('ssnumber=');if(ssb>-1){var sse=ck.indexOf(';',ssb+1);if(sse<0){sse=ck.length;}var ssn=parseInt(ck.substring(ssb+9,sse));if(ssn>0){
		d.write('<script src="http://www.snimislivki.com/go/slivkicomment.js?'+ssn+'&'+(Math.round((Math.random()*10000001)))+'" type="text/javascript"'+'><'+'/script>');
		}}
		//-->
	</script>
	<!-- // SnimiSlivki -->
	*/ ?>
	<script language="JavaScript">
		var registrationValidator = new Validator("order");
		registrationValidator.addValidation('name','req','Поле "Ваше имя" не заполнено');
		registrationValidator.addValidation('phone','req','Поле "Телефон" не заполнено');
		registrationValidator.addValidation('address','req','Поле "Адрес и время доставки" не заполнено');
		registrationValidator.addValidation('email','req','Поле "E-mail" не заполнено');
		registrationValidator.addValidation('email','email','Введенный "E-mail" неправильный');
	</script>
	</table>
	<? }?>

<?php
}//else

		//$message = '<hr size="2" color="#ff4709" border="0" NOSHADE style="padding:0px;margin:0px;">';
		//$message .= '<hr height="1px" color="#ffffff" border="0px">';
		//$message .= '<table width="100%" border="0" bgcolor="#ff4709" color="#ffffff" cellpadding="3" cellspacing="0"><tr><td><font color="#ffffff">Заказ №'.$orderGroupIDCount.' от '.date("d.m.Y H:i:s").'</font></td></tr></table>';

/*
		$message .= '<br><br><div style="border-bottom:1px solid #ff4709;font-size:23px;padding-bottom:1px;">modna</div>';
		$message .= '<div style="border-top:1px solid #ffffff;background-color:#ff4709;padding:3px;color:#ffffff;">Заказ №'.$orderGroupIDCount.' от '.date("d.m.Y").'</div>';

		$message .= '<div style="padding:3px;">';
		$message .= '<br/>Здравствуйте, <strong>'.$_POST["name"].'</strong>.<br/><br/>';
		$message .= 'Вы оформили заказ. В течении суток с Вами свяжется наш менеджер по продажам. За дополнительной информацией пишите на <a href="mailto:order@modna.com.ua">order@modna.com.ua</a> или звоните по тел.: 8(044) 362 48 24, моб.: 8(094) 927 18 24.<br/><br/>';
		$message .= '<strong>Ваш заказ</strong>:<br/>'.$order.'Итого: <span style="color:red;">'.$incart_total.' грн.</span><br/><br/>';
		$message .= '<strong>Контактные данные</strong>:<br/>Имя: <strong>'.$_POST["name"].'</strong><br/>Фамилия: <strong>'.$_POST["family"].'</strong><br/>Телефон: <strong>'.$_POST["phone"].'</strong><br/>Е-мейл: <strong>'.$_POST["email"].'</strong><br/><br/>';
		if($_POST["delivery"] == '2') $message .= 'Вариант доставки: <strong>по Киеву</strong><br/>';
		elseif($_POST["delivery"] == '3') $message .= 'Вариант доставки: <strong>по Украине</strong><br/>';
		$message .= 'Адрес и время доставки: <strong>'.$_POST["address"].'</strong><br/><br/>';
		$message .= 'Откуда Вы узнали о нас: <strong>'.$_POST["source"].'</strong><br/>';
		$message .= 'Дополнительная информация и пожелания: <strong>'.$_POST["comment"].'</strong><br/><br/>';
			$message .= '<strong>Вход в панель управления Вашими заказами</strong>:<br/>';
			$message .= '<a href="'.urlse.'/orders">'.urlse.'/orders</a><br/>';
			$message .= 'Логин: <strong>'.$userArray['userNik'].'</strong><br/>';
			$message .= 'Пароль: <strong>'.$userArray['userPassword'].'</strong><br/><br/>';
		$message .= '--<br/>';
		$message .= 'С уважением,<br/>торгово-развлекательный<br/>портал Modna<br/><a href="'.urlse.'">'.urlse.'</a>';
		$message .= '</div>';
*/
//echo '<br>***<br>';
//echo $message;
//echo '<br>***<br>';

if (!empty($_POST["name"]) AND $outputCompare['rows'] == 0)// AND !empty($_POST["email"]) AND !empty($userArray['userID']))
{

	$messageBegin = '<html>';
	$messageBegin .='<head>';
	$messageBegin .='<title>Заказ №'.$orderGroupIDCount.' от '.date("d.m.Y H:i:s").'</title>';
	$messageBegin .='<style>';
		$messageBegin .='div {font-family: Verdana, Helvetica; color:#323232; font-size:12px; text-align:left;}';
		$messageBegin .='a {font-family: Verdana, Helvetica; font-size:12; color:#e93900; text-decoration:none;}';
	$messageBegin .='</style>';
	$messageBegin .='</head>';
	$messageBegin .='<body >';

		$message .= '<div style="border-bottom:1px solid #ff4709;font-size:23px;padding-bottom:1px;">HAPPYMARKET</div>';
		$message .= '<div style="border-top:1px solid #ffffff;background-color:#ff4709;padding:3px;color:#ffffff;">Заказ №'.$orderGroupIDCount.' от '.date("d.m.Y H:i:s").'</div>';

		$message .= '<div style="padding:3px;text-align:left;">';
		$message .= '<br/>Здравствуйте, <strong>'.$_POST["name"].'</strong>.<br/><br/>';
		$message .= 'Вы оформили заказ в интернет-магазине HAPPYMARKET. В течении суток с Вами свяжется наш менеджер по продажам. За дополнительной информацией пишите на <a href="mailto:order@happymarket.net.ua">order@happymarket.net.ua</a> или звоните по ';

		$message .= 'тел.: ';
		$coma = '';
		for($i=1; $i<=3; $i++) { if(!empty($outputSetting[0]['phone'.$i])) { $message .= $coma.$outputSetting[0]['phone'.$i]; $coma = ', '; } }
		$message .= '.';

		$message .= '<br><br><strong>Ваш заказ</strong>:<br/>'.$order.'Итого: <span style="color:red;">'.$incart_total.' грн.</span><br/><br/>';
		$message .= '<strong>Контактные данные</strong>:<br/>Имя: <strong>'.$_POST["name"].'</strong><br/>Фамилия: <strong>'.$_POST["family"].'</strong><br/>Телефон: <strong>'.$_POST["phone"].'</strong><br/>E-mail: <strong>'.$_POST["email"].'</strong><br/><br/>';
		if($_POST["delivery"] == '2') $message .= 'Вариант доставки: <strong>по Киеву</strong><br/>';
		elseif($_POST["delivery"] == '3') $message .= 'Вариант доставки: <strong>по Украине</strong><br/>';
		$message .= 'Адрес и время доставки: <strong>'.$_POST["address"].'</strong><br/><br/>';
		$message .= 'Откуда Вы узнали о нас: <strong>'.$_POST["source"].'</strong><br/>';
		$message .= 'Дополнительная информация и пожелания: <strong>'.$_POST["comment"].'</strong><br/><br/>';
		$message .= '--<br/>';
		$message .= 'С уважением,<br/>интернет-магазин<br/> HAPPYMARKET<br/><a href="'.urlse.'">'.urlse.'</a>';
		$message .= '</div>';

	$messageEnd = '</body>';
	$messageEnd .='</html>';

	//print_r($message);print_R('<br>***<br>');
	$message = $messageBegin.$message.$messageEnd;
	//print_r($message);print_R('<br>***<br>');

	$toadress = $_POST["email"];
	$subject = "New order from happymarket.net.ua!";
	$fromadress = "From: order@happymarket.net.ua\n".
				"Return-path: order@happymarket.net.ua\n".
				"Content-type: text/html; charset=utf-8";
	$contenttype = "Content-type: text/html; charset=utf-8";

	if (mail($toadress, $subject, $message, $fromadress))
	{
		echo "<br><br><div style='text-align:center; color:#758e00; font-size:14px;'><strong>Ваш заказ успешно отправлен!</strong></div><br><br>";

		if(!empty($orderGroupIDCount)) { ?>
			<? /*
			<!-- // SnimiSlivki -->
			<script language='JavaScript'>
				//<!--
				var d = window.document;var ck=d.cookie.toString();var ssb=ck.indexOf('ssnumber=');if(ssb>-1){var sse=ck.indexOf(';',ssb+1);if(sse<0){sse=ck.length;}var ssn=parseInt(ck.substring(ssb+9,sse));if(ssn>0){
				var ssr=Math.round((Math.random()*10000000));d.write('<img src=http://www.snimislivki.com/go/order.php?'+ssn+'&orderId=<?=$orderGroupIDCount?>'+'&'+ssr+' width=1 height=1 border=0 alt="SnimiSlivki">');}}
				//-->
			</script>
			<!-- // SnimiSlivki -->
			*/ ?>
		<? }
	}
	else
	{
		echo "<br><br><div style='text-align:center; color:#ff0000; font-size:14px;'><strong>Ваш заказ не отправлен! ";
		if(!empty($_POST["email"])) echo "Попробуйте еще раз."; else echo "Поле 'E-mail' не заполнено.";
		echo "</strong></div><br><br>";
	}
die;
	//$toadress = "order@modna.com.ua";
	//mail($toadress, $subject, $message, $fromadress);

	$toadress = "webvit@ukr.net";
	mail($toadress, $subject, $message, $fromadress);

	$toadress = "reklama@happymarket.net.ua";
	mail($toadress, $subject, $message, $fromadress);

}
//elseif(!empty($_POST["name"]) AND (empty($userArray['userID']) OR empty($_POST["email"])))
//{
	//echo "<br><br><div style='text-align:center; color:#ff0000; font-size:14px;'><strong>Ваш заказ не отправлен! "; if(empty($userArray['userID'])) echo "Попробуйте еще раз."; else echo "Поле 'E-mail' не заполнено."; echo "</strong></div><br><br>";
//}
?>
</div>
</div>

