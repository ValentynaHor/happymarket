<?php
$input = $_POST;
$input_bkp = $_POST;
if(!empty($userArray['userID']))
{
	function del_tags($str)
	{
		global $langDefault;
		if(substr_count($str,"<".$langDefault.">") > 0)
			$str = preg_replace("|<".$langDefault.">(.*)<\/".$langDefault.">|U", "$1", $str);
			
		global $outputLang;
		for($lg=0; $lg < $outputLang['rows']; $lg++)
		{
			if(substr_count($str,"<".$outputLang[$lg]['langAlias'].">") > 0)
				$str = preg_replace("|<".$outputLang[$lg]['langAlias'].">(.*)<\/".$outputLang[$lg]['langAlias'].">|U", "", $str);
		}
	
		return $str;
	}

	if ($url == 'order') 
	{
		$paymentStatus = $getvar[1];
		//save/submit
		if($input['viewMode'] == 'save')
		{
			$inputGet['tableName'] = "order";
			$inputGet['filter_orderGroupID'] = $getvar[0];
			$inputGet['filter'] = getFilter($inputGet);
			$outputOrder2 = getData($inputGet);
			$inputGet = "";
			if($input['codeReg'] == $outputOrder2[0]['code']){
				$codeStatus = 1;
			}
			else{
				$codeStatus = 0;
			}
		}
		//query
		$orderID = $getvar[0];
		if($getvar[0] =='id' AND !empty($_POST['inv_id'])) $getvar[0] = $_POST['inv_id'];
	
		$input['tableName'] = "order";
		$input['select'] = "GROUP_CONCAT(wareName SEPARATOR '||') as wareNames, 
							GROUP_CONCAT(wareID SEPARATOR '||') as wareID,
							GROUP_CONCAT(warePosName SEPARATOR '||') as warePosName,
							GROUP_CONCAT(wareCount SEPARATOR '||') as wareCount,
							GROUP_CONCAT(warePrice SEPARATOR '||') as warePrice,
							SUM(warePrice*wareCount) as wareSum, 
							SUM(deliveryPrice) as deliveryPrice, 
							permAll, 
							orderGroupID, 
							timeCreated, 
							orderCourse, 
							delivery, 
							payMethod, 
							approved, 
							approvedby, 
							code, 
							prepaid, 
							userID, 
							userName, 
							userPatronymic, 
							userFamily, 
							userEmail, 
							userCity, 
							userAdress, 
							userSource, 
							userComment, 
							userPhone";
		$input['group'] = " group by orderGroupID DESC ";
		$input['filter_orderGroupID'] = $getvar[0];
		$input['filter'] = getFilter($input);
		$input['lang'] = 'no';	
		$outputOrder = getData($input);
		$input = '';

		if($outputOrder['rows']> 0 AND $outputOrder[0]['userID'] == $userArray['userID'])
		{
			$strName = '';

			$outputOrder[0]['wareNames'] = del_tags($outputOrder[0]['wareNames']);
			$outputOrder[0]['wareID'] = explode("||",$outputOrder[0]['wareID']);
			$outputOrder[0]['wareNames'] = explode("||",$outputOrder[0]['wareNames']);
			$outputOrder[0]['wareCount'] = explode("||",$outputOrder[0]['wareCount']);
			$outputOrder[0]['warePrice'] = explode("||",$outputOrder[0]['warePrice']);

			for($j=0; $j < count($outputOrder[0]['wareID']); $j++)
			{
				$strName .= '<tr><td>'.$outputOrder[0]['wareNames'][$j].' ['.$outputOrder[0]['wareCount'][$j].' шт.]</td><td> .. </td><td>'.round($outputOrder[0]['warePrice'][$j]*$outputOrder[0]['wareCount'][$j], 2).' грн. (1 шт. - '.round($outputOrder[0]['warePrice'][$j], 2).' грн.)</td></tr>';
			}
		}

		$pageTitle = 'Заказ №'.$outputOrder[0]['orderGroupID'];
	}
	
	if ($url == 'orders') 
	{
		$input = $_POST;
		$input['tableName'] = "order";
		$input['select'] = "GROUP_CONCAT(wareName SEPARATOR '||') as wareNames, 
							GROUP_CONCAT(wareID SEPARATOR '||') as wareID, 
							GROUP_CONCAT(warePosName SEPARATOR '||') as warePosName,
							GROUP_CONCAT(wareCount SEPARATOR '||') as wareCount, 
							GROUP_CONCAT(warePrice SEPARATOR '||') as warePrice, 
							SUM(warePrice*wareCount) as wareSum, 
							SUM(deliveryPrice) as deliveryPrice, 
							permAll, 
							orderGroupID, 
							timeCreated, 
							orderCourse, 
							delivery, 
							payMethod,
							userCity,  
							userID";
		$input['group'] = " group by orderGroupID DESC ";
		$input['filter_userID'] = $userArray['userID'];
		$input['filter'] = getFilter($input);
		$input['lang'] = 'no';	
		$outputOrder = getData($input);
		$input = '';

		$pageTitle = 'Заказы';
	}

	$pageTitle .= ' — Интернет-Супермаркет HappyMarket.net.ua';
}
?>
