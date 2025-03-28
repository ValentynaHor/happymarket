<?php
$input = $_POST;
$input_bkp = $_POST;

$inputCat['tableName'] = "category";
$inputCat['select'] = 'categoryID, categoryDepartment';
$inputCat['filter'] = 'AND parentCategoryID = \'top\'';
$outputCat = getData($inputCat);
$inputCat = '';

for ($i=0; $i < $outputCat['rows']; $i++)
{
	$CAT_ARRAY[$outputCat[$i]['categoryID']] = $outputCat[$i];
	if(!empty($outputCat[$i]['categoryDepartment'])) $depCat[$outputCat[$i]['categoryDepartment']][] = $outputCat[$i]['categoryID'];
}

if ($url == 'viewOrder' OR $url == 'manageOrder') 
{
	if(!empty($getvar['delete']))
	{
		$input['tableName'] = "order";
		$input['filter_orderID'] = $getvar['delete'];
		$input['filter'] = getFilter($input);
		delData($input);
		$input = "";
		header("Location: ".urlse."/adm/?".$url."/order/".$getvar['order']."/tab/".$getvar['tab']);
	}
	if(!empty($getvar['order']))
	{
		$inputOldOrder['tableName'] = "order";
		//$inputOldOrder['select'] = "orderGroupID, orderStatus, oldStatus, orderHistory";
		$inputOldOrder['group'] = " group by orderGroupID DESC ";
		$inputOldOrder['filter_orderGroupID'] = $getvar['order'];
		$inputOldOrder['filter'] = getFilter($inputOldOrder);
		$inputOldOrder['lang'] = 'no';	
		$outputOldOrder = getData($inputOldOrder);
		$inputOldOrder = '';
	}
	//save/approve
	if(!isset($input['viewMode'])) $input['viewMode'] = '';
	//print_r($input);
	if($input['viewMode'] == 'save')
	{
		$approved = '';
		$input['tableName'] = "order";
		if($input['order_orderStatus'] == '1' AND $outputOldOrder[0]['orderStatus'] != '1')
		{
			if($input['order_orderStatus'] == '1' AND $outputOldOrder[0]['orderStatus'] == '3') {} else $approved = '1';

			$input['order_confirmedID'] = $userArray['userID'];
		}
		elseif($input['order_orderStatus'] == '3' AND $outputOldOrder[0]['orderStatus'] != '3')
		{
			$approved = '3';

			$courier = $input['order_orderCourier'];
			$date = $input['order_deliveryDate'].'&nbsp; &nbsp;с&nbsp;'.$input['order_deliveryTimeStart'].'&nbsp;до&nbsp;'.$input['order_deliveryTimeEnd'];
			$comment = $input['order_deliveryComment'];
			$input['order_coordinatedID'] = $userArray['userID'];
		}
		elseif($input['order_orderStatus'] == '5' AND $outputOldOrder[0]['orderStatus'] != '5')
		{
			$approved = '5';
		}

		if(!empty($input['orderDate'])) $input['order_orderDate'] = formatDate($input['orderDate'],'db').' '.$input['orderTime'].':00';
		
		if(!empty($input['delivery'])) $input['order_delivery'] = $input['delivery'];
		if(!empty($input['order_deliveryDate'])) $input['order_deliveryDate'] = formatDate($input['order_deliveryDate'], 'db');
		if(!empty($input['order_deliveryTimeStart'])) $input['order_deliveryTimeStart'] = $input['order_deliveryTimeStart'].':00';
		if(!empty($input['order_deliveryTimeEnd'])) $input['order_deliveryTimeEnd'] = $input['order_deliveryTimeEnd'].':00';
		
		if(($input['order_orderStatus'] == '4' AND $outputOldOrder[0]['orderStatus'] != '4') OR ($input['order_orderStatus'] == '2' AND $outputOldOrder[0]['orderStatus'] == '4')) $input['order_orderToDate'] = getNewDate(); //else $input['task_taskToDate'] = '0000-00-00 00:00:00';
		if(($input['order_orderStatus'] == '2' AND $outputOldOrder[0]['orderStatus'] != '2') OR ($input['order_orderStatus'] == '5' AND $outputOldOrder[0]['orderStatus'] != '5')) $input['order_oldStatus'] = $outputOldOrder[0]['orderStatus'];

		if($input['order_orderStatus'] != $outputOldOrder[0]['orderStatus'] OR empty($outputOldOrder[0]['orderHistory']))
		{
			if(!empty($outputOldOrder[0]['orderHistory']))
			{
				$historyArray = @ explode('&',$outputOldOrder[0]['orderHistory']);
				$input['order_orderHistory'] = '';
				$hResult = array();
				for($h=1; $h < count($historyArray)-1; $h++)
				{
					$hArray = @ explode('|',$historyArray[$h]);
					$hResult[$hArray[0]] = $hArray[0].'|'.$hArray[1].'|'.$hArray[2];
				}
				$hResult[$input['order_orderStatus']] = $input['order_orderStatus'].'|'.$userArray['userID'].'|'.getNewDate();
				if(count($hResult) > 0)
				{
					//ksort($hResult);
					foreach($hResult as $key => $val) $input['order_orderHistory'] .= $val.'&';
				}
				if(!empty($input['order_orderHistory'])) $input['order_orderHistory'] = '&'.$input['order_orderHistory'];
			}
			else
			{
				if($input['order_orderStatus'] == '0')
				{
					$input['order_orderHistory'] = '&'.$input['order_orderStatus'].'|'.$userArray['userID'].'|'.getNewDate().'&';
				}
				else
				{
					$input['order_orderHistory'] = '&0|'.$userArray['userID'].'|'.getNewDate().'&'.$input['order_orderStatus'].'|'.$userArray['userID'].'|'.getNewDate().'&';
				}
			}
		}

		if(is_array($input['entityID']))
		{
			$input['order_orderGroupID'] = $getvar['order'];
	
			foreach($input['order_wareID'] as $num => $val)//if(!empty($input['order_wareID'][$num]) AND !empty($input['order_wareCategory'][$num]))
			{
				$input['arrayID'][$num] = $input['entityID'][$num];
				if($url == 'manageOrder')
				{
					$input['order_wareName'][$num] = str_replace('"','&quot;',$input['order_wareName'][$num]);
					$input['order_wareName'][$num] = str_replace("'","`",$input['order_wareName'][$num]);
				}
			}

			saveArray($input);
		}
		else
		{
/*
			if(!empty($input["order_userEmail"]))
			{
				$tmp = explode('@',$input["order_userEmail"]);
				$UserNik_ = $tmp[0];
				$Pass_ = random_pass();
				
				$inputUsr['tableName'] = 'user';
				$inputUsr['filter_userEmail'] = $input["order_userEmail"];
				$inputUsr['filter'] = getFilter($inputUsr);
				$outputUsr = getData($inputUsr);
				if($outputUsr['rows'] == 0)
				{
					$inputUsr['tableName'] = 'user';
					$inputUsr['user_permAll'] = '1';
					$inputUsr['user_userType'] = 'user';
					$inputUsr['user_groupID'] = 'user';
					$inputUsr['user_userName'] = $input["order_userName"];
					$inputUsr['user_userPatronymic'] = $input["order_userPatronymic"];
					$inputUsr['user_userFamily'] = $input["order_userFamily"];
					$inputUsr['user_userNik'] = $UserNik_;
					$inputUsr['user_userPhone'] = $input["order_userPhone"];
					$inputUsr['user_userEmail'] = $input["order_userEmail"];
					$inputUsr['user_userPassword'] = $Pass_;
					$messageResult = saveData($inputUsr);
					$inputUsr = '';
		
					$inputUsr['tableName'] = 'user';
					$inputUsr['filter_userEmail'] = $input["order_userEmail"];
					$inputUsr['filter'] = getFilter($inputUsr);
					$outputUsr = getData($inputUsr);
					$userID = $outputUsr[0]['userID'];
					$userData = $outputUsr[0];
				}
				else
				{
					$userID = $outputUsr[0]['userID'];
					$userData = $outputUsr[0];
				}
			}

*/
			$inputGetUserOrderCount['tableName'] = "order";
			$inputGetUserOrderCount['select'] = "orderGroupID";
			$inputGetUserOrderCount['sort_orderGroupID'] = "desc";
			$inputGetUserOrderCount['sort'] = sortData($inputGetUserOrderCount);
			$outputUserOrderCount = getData($inputGetUserOrderCount);
			$inputGetUserOrderCount = "";
			$orderGroupIDCount = $outputUserOrderCount[0]['orderGroupID']+1;

			$count = 0;

			if(is_array($input['order_wareID']))//for($num=0; $num < 10; $num++)
			{
				$tempArray['order_wareID'] = $input['order_wareID'];
				$tempArray['order_wareCategory'] = $input['order_wareCategory'];
				$tempArray['order_wareSubCategory'] = $input['order_wareSubCategory'];
				$tempArray['order_wareName'] = $input['order_wareName'];
				$tempArray['order_warePrice'] = $input['order_warePrice'];
				$tempArray['order_wareCount'] = $input['order_wareCount'];

				foreach($tempArray['order_wareID'] as $num => $wareID)//if(!empty($input['order_wareID'][$num]) AND !empty($input['order_wareCategory'][$num]))
				{
					$category = $tempArray['order_wareCategory'][$num];

					$input['order_permAll'] = '1';
					if(!empty($userID)) $input['order_userID'] = $userID;
					if(empty($getvar['order'])) $input['order_userAdd'] = $userArray['userID'];

					$input['order_wareCategory'] = $category;
					$input['order_wareSubCategory'] = $tempArray['order_wareSubCategory'][$num];
					$input['order_wareID'] = $wareID;
					$input['order_wareName'] = $tempArray['order_wareName'][$num];
						$input['order_wareName'] = str_replace('"','&quot;',$input['order_wareName']);
						$input['order_wareName'] = str_replace("'","`",$input['order_wareName']);
					$input['order_warePrice'] = $tempArray['order_warePrice'][$num];
					$input['order_wareCount'] = $tempArray['order_wareCount'][$num];
					$input['order_userAdress'] = str_replace("\\","&#092;",$input['order_userAdress']);
					$input['order_delivery'] = $input['delivery'];
					$input['order_orderGroupID'] = $orderGroupIDCount;
					//print_r('<br>***<br>');print_r($input);print_r('<br>************************************<br>');
					saveData($input);
				}
				$tempArray = '';
			}
		}
		$input = "";
		if($approved == '1')
		{
			//send letter
			$body = '<br />Здравствуйте, '.$outputOldOrder[0]['userName'].'! <br /><br />Ваш заказ №'.$outputOldOrder[0]['orderGroupID'].' от '.formatDate($outputOldOrder[0]['timeCreated'], 'datetime').' подтвержден! <br /><br />';
			//if($outputOldOrder[0]['payMethod'] == '4' or $outputOldOrder[0]['payMethod'] == '5'  or $outputOldOrder[0]['payMethod'] == '6')
			//	{$body .= 'Введите, пожалуйста, код подтверждения <strong>'.$outputOldOrder[0]['code'].'</strong> на странице: <br> <a href="'.urlse.'/order/'.$outputOldOrder[0]['orderGroupID'].'/">'.urlse.'/order/'.$outputOldOrder[0]['orderGroupID'].'/</a>';}
			//else
			//	{$body .= 'Ссылка для просмотра заказа: <br> <a href="'.urlse.'/order/'.$outputOldOrder[0]['orderGroupID'].'/">'.urlse.'/order/'.$outputOldOrder[0]['orderGroupID'].'/</a>';}
			//$body .= '<br /><br />Менеджер: '.$userArray['userName'].'; E-mail: <a style="color:green" href="mailto:'.$userArray['userEmail'].'">'.$userArray['userEmail'].'</a>; ICQ: <a style="color:green" href="http://wwp.icq.com/scripts/contact.dll?msgto='.$userArray['userICQ'].'">'.$userArray['userICQ'].'</a>.';
			$body .= '<br /><br />Спасибо, за внимание к нашему сервису.<br />С уважением,<br/>интернет-магазин<br/> HAPPYMARKET<br/><a href="'.urlse.'">'.urlse.'</a>';
		}
		elseif($approved == '3')
		{
			//send letter
			$body = '<br />Здравствуйте, '.$outputOldOrder[0]['userName'].'! <br /><br />Ваш заказ №'.$outputOldOrder[0]['orderGroupID'].' от '.formatDate($outputOldOrder[0]['timeCreated'], 'datetime').' выполнен! <br /><br />';
			//if($outputOldOrder[0]['payMethod'] == '4' or $outputOldOrder[0]['payMethod'] == '5'  or $outputOldOrder[0]['payMethod'] == '6')
			//	$body .= 'Введите, пожалуйста, код подтверждения <strong>'.$outputOldOrder[0]['code'].'</strong> на странице: <br> <a href="'.urlse.'/order/'.$outputOldOrder[0]['orderGroupID'].'/">'.urlse.'/order/'.$outputOldOrder[0]['orderGroupID'].'/</a>';
			//else
			//	$body .= 'Ссылка для просмотра заказа: <br> <a href="'.urlse.'/order/'.$outputOldOrder[0]['orderGroupID'].'/">'.urlse.'/order/'.$outputOldOrder[0]['orderGroupID'].'/</a>';
			//$body .= '<br /><br />Время доставки: '.$date.'.';
			if(!empty($date)) $body .= '<br />Время доставки: '.$date.'.';
			if(!empty($comment)) $body .= '<br />'.$comment.'.';
			//$body .= '<br />Курьер: '.$ddAllManager[$courier]['userName'].'; Тел.: '.$ddAllManager[$courier]['userPhone'].'.';
			$body .= '<br /><br />Спасибо, за внимание к нашему сервису.<br />С уважением,<br/>интернет-магазин<br/> HAPPYMARKET<br/><a href="'.urlse.'">'.urlse.'</a></a>';
		}
		elseif($approved == '5')
		{
			//send letter
			$body = '<br />Здравствуйте, '.$outputOldOrder[0]['userName'].'! <br /><br />Ваш заказ №'.$outputOldOrder[0]['orderGroupID'].' от '.formatDate($outputOldOrder[0]['timeCreated'], 'datetime').' подтвержден. К сожалению на данном этапе нет возможности вам его доставить, как только товар появится у нас на складе вам автоматически будет отосланно сообщение о появлении данной позиции и вы сможете связаться с нами повторно.<br>';
			//$body .= '<br /><br />Менеджер: '.$userArray['userName'].'; E-mail: <a style="color:green" href="mailto:'.$userArray['userEmail'].'">'.$userArray['userEmail'].'</a>; ICQ: <a style="color:green" href="http://wwp.icq.com/scripts/contact.dll?msgto='.$userArray['userICQ'].'">'.$userArray['userICQ'].'</a>.';
			$body .= '<br /><br />Спасибо, за внимание к нашему сервису.<br />С уважением,<br/>интернет-магазин<br/> HAPPYMARKET<br/><a href="'.urlse.'">'.urlse.'</a></a>';
		}

		// send: appr OR notific
		if($approved == '1' OR $approved == '3' OR $approved == '5')
		{
			//print_r($body);
			$beginBody = '<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8"></head><body style="margin:0; padding:15px 15px 0px 15px;"> ';
			$endBody = ' </body></html>';
			$body = $beginBody.$body.$endBody;
			
			$toadress = $outputOldOrder[0]['userEmail'];
			$subject = "Happymarket.net.ua: подтверждение заказа!";
			$subject = '=?utf-8?b?'.base64_encode($subject).'?=';
			$fromadress = "From: order@happymarket.net.ua\n".
						"Return-path: order@happymarket.net.ua\n".
						"Content-type: text/html; charset=utf-8";
			$contenttype = "Content-type: text/html; charset=utf-8";
			mail($toadress, $subject, $body, $fromadress);
		}
	}
	if(!empty($getvar['order']))
	{
		$input['tableName'] = "order";
		$input['select'] = "GROUP_CONCAT(wareName SEPARATOR '||') as wareNames, 
							GROUP_CONCAT(orderID SEPARATOR '||') as orderID, 
							GROUP_CONCAT(wareID SEPARATOR '||') as wareID, 
							GROUP_CONCAT(warePrice SEPARATOR '||') as warePrice, 
							GROUP_CONCAT(wareCount SEPARATOR '||') as wareCount, 
							GROUP_CONCAT(warePos SEPARATOR '||') as warePos, 
							GROUP_CONCAT(warePosName SEPARATOR '||') as warePosName, 
							GROUP_CONCAT(wareCategory SEPARATOR '||') as wareCategory, 
							GROUP_CONCAT(wareSubCategory SEPARATOR '||') as wareSubCategory, 
							SUM(warePrice*wareCount) as wareSum, 
							SUM(deliveryPrice) as deliveryPrice, 
							orderGroupID, 
							timeCreated,
							orderDate,  
							orderToDate, 
							orderCourse, 
							delivery,
							deliveryDate, 
							deliveryTimeStart, 
							deliveryTimeEnd, 
							deliveryComment, 
							payMethod, 
							approved, 
							approvedby, 
							code, 
							prepaid, 
							orderNumber, 
							orderDeclaration, 
							orderPurchase, 
							orderNote, 
							orderStatus, 
							orderPriority, 
							oldStatus, 
							orderCourier, 
							orderHistory, 
							userID, 
							userAdd, 
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
		$input['filter_orderGroupID'] = $getvar['order'];
		$input['filter'] = getFilter($input);
		$input['lang'] = 'no';	
		$outputOrder = getData($input);
		$input = '';

		if($url == 'manageOrder' AND !empty($getvar['order']))
		{
			if(($userArray['groupID'] == 'admin' OR $userArray['userID'] == $outputOrder[0]['userAdd'] OR empty($outputOrder[0]['userAdd'])) AND $outputOrder[0]['orderStatus'] != '2' AND $outputOrder[0]['orderStatus'] != '4')
			{}
			else
			{
				if(!empty($getvar['tab'])) header("Location: ".urlse."/adm/?viewOrder/order/".$getvar['order']."/tab/".$getvar['tab']);
				else header("Location: ".urlse."/adm/?viewOrder/order/".$getvar['order']."/tab/client");
			}
		}

		if($outputOrder['rows']> 0)
		{
			$outputOrder[0]['wareNames'] = del_tags($outputOrder[0]['wareNames']);
			$outputOrder[0]['orderID'] = explode("||",$outputOrder[0]['orderID']);
			$outputOrder[0]['wareID'] = explode("||",$outputOrder[0]['wareID']);
			$outputOrder[0]['warePosName'] = explode("||",$outputOrder[0]['warePosName']);
			$outputOrder[0]['wareAlias'] = explode("||",$outputOrder[0]['wareAlias']);
			
			$outputOrder[0]['wareName'] = explode("||",$outputOrder[0]['wareNames']);
			$searchWareNames = explode("||",$outputOrder[0]['wareNames']);
			$outputOrder[0]['warePrice'] = explode("||",$outputOrder[0]['warePrice']);
			$outputOrder[0]['wareCount'] = explode("||",$outputOrder[0]['wareCount']);
			$outputOrder[0]['category'] = str_replace("||","&",$outputOrder[0]['wareCategory']);
	
			$outputOrder[0]['category'] = '&'.$outputOrder[0]['category'].'&';
			$outputOrder[0]['wareCategory'] = explode("||",$outputOrder[0]['wareCategory']);
			$array_category = array_unique($outputOrder[0]['wareCategory']);
			for($c=0; $c < count($array_category); $c++)
			{
				$selectCategoriesName .= $catAlias[$array_category[$c]].', ';
				$selectCategoriesAlias.= $array_category[$c].', ';
			}
			$outputOrder[0]['wareSubCategory'] = explode("||",$outputOrder[0]['wareSubCategory']);

			$strName = '';
			for($j=0; $j < count($outputOrder[0]['wareID']); $j++)
			{
				if(!empty($outputOrder[0]['warePosName'][$j]))
				{
					//$arrayWarePos = @explode('&&',$outputOrder[0]['warePosName'][$j]);
					//$outputOrder[0]['warePosName'][$j] = ''; $SEP_POS = '';
					//for($e=0; $e < count($arrayWarePos); $e++)
					//{
						//$outputOrder[0]['warePosName'][$j] .= $SEP_POS.$arrayWarePos[$e];
						//$SEP_POS = '; ';
					//}
					$outputOrder[0]['warePosName'][$j] = '<div style="font-size:11px;">'.str_replace('&&','; ',$outputOrder[0]['warePosName'][$j]).'</div>';
				}
				
				//*** WARE PRESENCE ***
				$inputWarePresence['tableName'] = 'resource';
				$inputWarePresence['select'] = 'presence';
				$inputWarePresence['filter_resourceID'] = $outputOrder[0]['wareID'][$j];
				$inputWarePresence['filter'] = getFilter($inputWarePresence);
				$outputWarePresence = getData($inputWarePresence);
				$inputWarePresence = '';

				if($outputWarePresence['rows'] > 0)
				{
					$outputOrder[0]['warePresence'][$j] = getValueDropDown('ddPresenceAdmin', $outputWarePresence[0]['presence']);
				}

				//*** WARE PRESENCE ***
				$strName .= '<tr class="row1" align="center"><td align="left"><a target="_blank" href="?manageResource/dept/'.$CAT_ARRAY[$outputOrder[0]['wareCategory'][$j]]['categoryDepartment'].'/resource/'.$outputOrder[0]['wareID'][$j].'/category/'.$outputOrder[0]['wareCategory'][$j].'/sub/'.$outputOrder[0]['wareSubCategory'][$j].'">'.$outputOrder[0]['wareName'][$j].'</a>'.$outputOrder[0]['warePosName'][$j].'</td><td>'.$outputOrder[0]['warePresence'][$j].'<input type="hidden" name="entityID['.$j.']" value="'.$outputOrder[0]['orderID'][$j].'"><input type="hidden" name="order_wareID['.$j.']" value="'.$outputOrder[0]['wareID'][$j].'"><input type="hidden" name="order_wareCategory['.$j.']" value="'.$outputOrder[0]['wareCategory'][$j].'"></td><td><input name="order_warePrice['.$j.']" value="'.$outputOrder[0]['warePrice'][$j].'" type="text" style="width:50px;" ></td><td><input name="order_wareCount['.$j.']" value="'.$outputOrder[0]['wareCount'][$j].'" type="text" style="width:30px;" ></td><td><a href="/adm/?viewOrder/order/'.$getvar['order'].'/tab/'.$getvar['tab'].'/delete/'.$outputOrder[0]['orderID'][$j].'" onClick="return confirm(\'Удалить товар '.$outputOrder[0]['wareName'][$j].'?\')"><img src="img/icon/delete.gif" onClick="this.src=delete_go.src;" onMouseMove="this.src=delete_on.src;" onMouseOut="this.src=delete_out.src;" width="25" height="28" alt="Удалить"></a></td></tr>';
			}
		}
	}

	//$ddOrderStatus = array("0"=>"Новый", "6"=>"Принят", "1"=>"Подтвержден", "2"=>"Отклонен", "3"=>"Скоординирован", "4"=>"Выполнен", "5"=>"Нет в наличии");
	if($outputOrder[0]['orderStatus'] == '0' OR empty($outputOrder[0]['orderStatus']))
	{
		$arrayStatus = array("0"=>"Новый", "6"=>"Принят");
	}
	if($outputOrder[0]['orderStatus'] == '6')
	{
		$arrayStatus = array("6"=>"Принят", "1"=>"Подтвержден", "2"=>"Отклонен", "5"=>"Нет в наличии");
	}
	elseif($outputOrder[0]['orderStatus'] == '1')
	{
		if($outputOrder[0]['delivery'] == '1' OR empty($outputOrder[0]['delivery']))
			$arrayStatus = array("1"=>"Подтвержден", "2"=>"Отклонен", "4"=>"Выполнен");
		else
			$arrayStatus = array("1"=>"Подтвержден", "2"=>"Отклонен", "3"=>"Скоординирован");
			
	}
	elseif($outputOrder[0]['orderStatus'] == '2' OR $outputOrder[0]['orderStatus'] == '5')
	{
		if($outputOrder[0]['oldStatus'] == '0' OR empty($outputOrder[0]['oldStatus']))
		{
			$arrayStatus = array("0"=>"Новый", "6"=>"Принят");
		}
		if($outputOrder[0]['orderStatus'] == '6')
		{
			$arrayStatus = array("6"=>"Принят", "1"=>"Подтвержден", "2"=>"Отклонен", "5"=>"Нет в наличии");
		}
		elseif($outputOrder[0]['oldStatus'] == '1')
		{
			if($outputOrder[0]['delivery'] == '1' OR empty($outputOrder[0]['delivery']))
				$arrayStatus = array("1"=>"Подтвержден", "2"=>"Отклонен", "4"=>"Выполнен");
			else
				$arrayStatus = array("1"=>"Подтвержден", "2"=>"Отклонен", "3"=>"Скоординирован");
		}
		elseif($outputOrder[0]['oldStatus'] == '3')
		{
			$arrayStatus = array("1"=>"Подтвержден", "2"=>"Отклонен", "3"=>"Скоординирован", "4"=>"Выполнен");
		}
		elseif($outputOrder[0]['oldStatus'] == '4')
		{
			$dateCurrent = time();
			$date['seconds'] = substr($outputOrder[0]['orderToDate'],17,2);
			$date['minutes'] = substr($outputOrder[0]['orderToDate'],14,2);
			$date['hours'] = substr($outputOrder[0]['orderToDate'],11,2);
			$date['day'] = substr($outputOrder[0]['orderToDate'],8,2);
			$date['month'] = substr($outputOrder[0]['orderToDate'],5,2);
			$date['year'] = substr($outputOrder[0]['orderToDate'],0,4);
			$dateSaved = mktime($date['hours'], $date['minutes'], $date['seconds'], $date['month'], $date['day'], $date['year']);
			$period = $dateCurrent - $dateSaved;
			$period_in_days = floor($period / (24*60*60));
			if($period_in_days <= 2)
			{
				if($outputOrder[0]['delivery'] == '1' OR empty($outputOrder[0]['delivery']))
					$arrayStatus = array("2"=>"Отклонен", "4"=>"Выполнен");
				else
					$arrayStatus = array("2"=>"Отклонен", "3"=>"Скоординирован", "4"=>"Выполнен");
			}
			else
			{
				$arrayStatus = array("4"=>"Выполнен");
			}
		}
	}
	elseif($outputOrder[0]['orderStatus'] == '3')
	{
		$arrayStatus = array("1"=>"Подтвержден", "2"=>"Отклонен", "3"=>"Скоординирован", "4"=>"Выполнен");
	}
	elseif($outputOrder[0]['orderStatus'] == '4')
	{
		$dateCurrent = time();
		$date['seconds'] = substr($outputOrder[0]['orderToDate'],17,2);
		$date['minutes'] = substr($outputOrder[0]['orderToDate'],14,2);
		$date['hours'] = substr($outputOrder[0]['orderToDate'],11,2);
		$date['day'] = substr($outputOrder[0]['orderToDate'],8,2);
		$date['month'] = substr($outputOrder[0]['orderToDate'],5,2);
		$date['year'] = substr($outputOrder[0]['orderToDate'],0,4);
		$dateSaved = mktime($date['hours'], $date['minutes'], $date['seconds'], $date['month'], $date['day'], $date['year']);
		$period = $dateCurrent - $dateSaved;
		$period_in_days = floor($period / (24*60*60));
		if($period_in_days <= 2)
		{
			if($outputOrder[0]['delivery'] == '1' OR empty($outputOrder[0]['delivery']))
				$arrayStatus = array("2"=>"Отклонен", "4"=>"Выполнен");
			else
				$arrayStatus = array("2"=>"Отклонен", "3"=>"Скоординирован", "4"=>"Выполнен");
		}
		else
		{
			$arrayStatus = array("4"=>"Выполнен");
		}
	}
}

if ($url == 'manageOrders' OR $url == 'orderExtSearch') 
{
	//delete
	if(!empty($getvar['delete']) AND $userArray['groupID'] == 'admin'){
        saveData(array(
            'query' => "INSERT INTO `table_orderremove`
                SELECT *
                FROM `table_order`
                WHERE orderGroupID = {$getvar['delete']}"
        ));

        $input['tableName'] = "order";
        $input['filter_orderGroupID'] = $getvar['delete'];
        $input['filter'] = getFilter($input);
		delData($input);
		$input = "";

        header("Location: ".$_SERVER['HTTP_REFERER']);
	}
	//query
	$input = $input;
	if(!empty($getvar['user']))
	{
		//CONSTANT
		$ARRAY_YEAR = array("2007","2008","2009","2010","2011","2012","2013","2014","2015","2016","2017");
		$ARRAY_MOUNTH = array("01","02","03","04","05","06","07","08","09","10","11","12");
		$ARRAY_DAY = array("01","02","03","04","05","06","07","08","09","10","11","12","13","14","15","16","17","18","19","20","21","22","23","24","25","26","27","28","29","30","31");
		$ARRAY_HOUR = array("00","01","02","03","04","05","06","07","08","09","10","11","12","13","14","15","16","17","18","19","20","21","22","23");
		$ARRAY_MINUTE = array("00","01","02","03","04","05","06","07","08","09","10","11","12","13","14","15","16","17","18","19","20","21","22","23","24","25","26","27","28","29","30","31","32","33","34","35","36","37","38","39","40","41","42","43","44","45","46","47","48","49","50","51","52","53","54","55","56","57","58","59");
		
		$CUR_DATE_DAY = date ('d',time());
		$CUR_DATE_MOUNTH = date ('m',time());
		$CUR_DATE_YEAR = date ('Y',time());
		//************************************
		if($getvar['filter'] == 'yes')
		{
			if($getvar['filter'] == 'yes') {$input = $session_date;}
			$session_date['hour_from'] = $input['hour_from']; $session_date['minute_from'] = $input['minute_from']; $session_date['month_from'] = $input['month_from']; $session_date['day_from'] = $input['day_from']; $session_date['year_from'] = $input['year_from'];
			$date_from = $session_date['year_from'].'-'.$session_date['month_from'].'-'.$session_date['day_from'].' '.$session_date['hour_from'].':'.$session_date['minute_from'].':00';
	
			$session_date['hour_to'] = $input['hour_to']; $session_date['minute_to'] = $input['minute_to']; $session_date['month_to'] = $input['month_to']; $session_date['day_to'] = $input['day_to']; $session_date['year_to'] = $input['year_to'];
			$date_to = $session_date['year_to'].'-'.$session_date['month_to'].'-'.$session_date['day_to'].' '.$session_date['hour_to'].':'.$session_date['minute_to'].':59';
			
			$inputUserDate = "AND `timeSaved` >= '".$date_from."'  AND `timeSaved` <= '".$date_to."' ";
		}
		else
		{
			$date_from = $CUR_DATE_YEAR.'-'.$CUR_DATE_MOUNTH.'-'.$CUR_DATE_DAY.' 00:00:00';
			$date_to = $CUR_DATE_YEAR.'-'.$CUR_DATE_MOUNTH.'-'.$CUR_DATE_DAY.' 23:59:59';
	
			$inputUserDate = "AND `timeSaved` >= '".$date_from."'  AND `timeSaved` <= '".$date_to."' ";
		}	

		$inputUserID = " AND `orderHistory` LIKE '%&1|".$getvar['user']."|%' ";
	}
	else
	{
		$getvar['tab'] = 'all';
			if(empty($input['filterNumber']) AND $input['viewMode'] != 'filter') $input['filterNumber'] = $_SESSION['SESSION_ORDER']['filterNumber'][$getvar['tab']];
			if(empty($input['filterPhone']) AND $input['viewMode'] != 'filter') $input['filterPhone'] = $_SESSION['SESSION_ORDER']['filterPhone'][$getvar['tab']];
			if(empty($input['filterEmail']) AND $input['viewMode'] != 'filter') $input['filterEmail'] = $_SESSION['SESSION_ORDER']['filterEmail'][$getvar['tab']];
			if(empty($input['filterName']) AND $input['viewMode'] != 'filter') $input['filterName'] = $_SESSION['SESSION_ORDER']['filterName'][$getvar['tab']];
			if(empty($input['filterPayMethod']) AND $input['filterPayMethod'] != '0' AND $input['viewMode'] != 'filter') $input['filterPayMethod'] = $_SESSION['SESSION_ORDER']['filterPayMethod'][$getvar['tab']];
			if($getvar['tab'] == 'all' AND $userArray['userStatus'] == '1')
			{
				if(empty($input['filterCourier']) AND $input['viewMode'] != 'filter') $input['filterCourier'] = $_SESSION['SESSION_ORDER']['filterCourier'][$getvar['tab']];
			}
			if(!is_array($input['filterStatus']) AND $input['viewMode'] != 'filter' AND $_SESSION['SESSION_ORDER']['filterStatus'][$getvar['tab']] != 'all')
			{
				if(!empty($_SESSION['SESSION_ORDER']['filterStatus'][$getvar['tab']]))
				{
					$_SESSION['SESSION_ORDER']['filterStatus'][$getvar['tab']] = explode('&',$_SESSION['SESSION_ORDER']['filterStatus'][$getvar['tab']]);
					for($i=1; $i <count($_SESSION['SESSION_ORDER']['filterStatus'][$getvar['tab']])-1; $i++) {$input['filterStatus'][$_SESSION['SESSION_ORDER']['filterStatus'][$getvar['tab']][$i]] = '1';}
				}
				elseif(empty($_SESSION['SESSION_ORDER']['filterStatus'][$getvar['tab']]))
				{
					if($getvar['tab'] == 'all')
					{
						$input['filterStatus']['1'] = '1';
					}
				}
			}
			if(!is_array($input['filterDelivery']) AND $input['viewMode'] != 'filter' AND $_SESSION['SESSION_ORDER']['filterDelivery'][$getvar['tab']] != 'all')
			{
				if(!empty($_SESSION['SESSION_ORDER']['filterDelivery'][$getvar['tab']]))
				{
					$_SESSION['SESSION_ORDER']['filterDelivery'][$getvar['tab']] = explode('&',$_SESSION['SESSION_ORDER']['filterDelivery'][$getvar['tab']]);
					for($i=1; $i < count($_SESSION['SESSION_ORDER']['filterDelivery'][$getvar['tab']])-1; $i++) {$input['filterDelivery'][$_SESSION['SESSION_ORDER']['filterDelivery'][$getvar['tab']][$i]] = '1';}
				}
				elseif(empty($_SESSION['SESSION_ORDER']['filterDelivery'][$getvar['tab']]))
				{
					if($getvar['tab'] == 'all' AND $userArray['userStatus'] == 1)
					{
						$input['filterDelivery']['2'] = '1';$input['filterDelivery']['3'] = '1';
					}
				}
			}
			if(empty($input['fromDate']) AND $input['viewMode'] != 'filter') $input['fromDate'] = $_SESSION['SESSION_ORDER']['filterFromDate'][$getvar['tab']];
			if(empty($input['toDate']) AND $input['viewMode'] != 'filter') $input['toDate'] = $_SESSION['SESSION_ORDER']['filterToDate'][$getvar['tab']];


			if(is_array($input['filterStatus']))
			{
				$inputStatus = ''; $OR = ''; $_SESSION['SESSION_ORDER']['filterStatus'][$getvar['tab']] = ''; $FLAG_EMPTY = true;
				foreach($input['filterStatus'] as $keyStatus => $valStatus)
				{
					if($valStatus == '1') {$_SESSION['SESSION_ORDER']['filterStatus'][$getvar['tab']] .= $keyStatus.'&'; $inputStatus .= $OR."orderStatus = ".$keyStatus; $OR = " OR "; $FLAG_EMPTY = false;}
				}
				if(!empty($inputStatus)) $inputStatus = " AND (".$inputStatus.")";
				if($FLAG_EMPTY) $_SESSION['SESSION_ORDER']['filterStatus'][$getvar['tab']] = 'all'; elseif(!empty($_SESSION['SESSION_ORDER']['filterStatus'][$getvar['tab']])) $_SESSION['SESSION_ORDER']['filterStatus'][$getvar['tab']] = "&".$_SESSION['SESSION_ORDER']['filterStatus'][$getvar['tab']];
			}
			if(is_array($input['filterDelivery']))
			{
				$inputDelivery = ''; $OR = ''; $_SESSION['SESSION_ORDER']['filterDelivery'][$getvar['tab']] = ''; $FLAG_EMPTY = true;
				foreach($input['filterDelivery'] as $keyDelivery => $valDelivery)
				{
					if($valDelivery == '1') {$_SESSION['SESSION_ORDER']['filterDelivery'][$getvar['tab']] .= $keyDelivery.'&'; $inputDelivery .= $OR."delivery = ".$keyDelivery; $OR = " OR "; $FLAG_EMPTY = false;}
				}
				if(!empty($inputDelivery)) $inputDelivery = " AND (".$inputDelivery.")";
				if($FLAG_EMPTY) $_SESSION['SESSION_ORDER']['filterDelivery'][$getvar['tab']] = 'all'; elseif(!empty($_SESSION['SESSION_ORDER']['filterDelivery'][$getvar['tab']])) $_SESSION['SESSION_ORDER']['filterDelivery'][$getvar['tab']] = "&".$_SESSION['SESSION_ORDER']['filterDelivery'][$getvar['tab']];
			}
			if((!empty($input['filterPayMethod']) OR $input['filterPayMethod'] == '0') AND $input['filterPayMethod'] != 'all')
			{
				$inputPayMethod = " AND payMethod = ".$input['filterPayMethod'];
			}
			else
			{
				$input['filterPayMethod'] = 'all';
			}
			$_SESSION['SESSION_ORDER']['filterPayMethod'][$getvar['tab']] = $input['filterPayMethod'];

			if($getvar['tab'] == 'all' AND $userArray['userStatus'] == '1')
			{
				if(!empty($input['filterCourier']) AND $input['filterCourier'] != 'all')
				{
					$inputCourier = " AND orderCourier = '".$input['filterCourier']."'";
				}
				else
				{
					$input['filterCourier'] = 'all';
				}
				$_SESSION['SESSION_ORDER']['filterCourier'][$getvar['tab']] = $input['filterCourier'];
			}

			if(!empty($input['filterNumber']))
			{
				$inputNumber = " AND orderGroupID = ".$input['filterNumber'];
				$input['filterStatus'] = 'all';
				$input['filterDelivery'] = 'all';
				$input['fromDate'] = 'all';
			}
			$_SESSION['SESSION_ORDER']['filterNumber'][$getvar['tab']] = $input['filterNumber'];
			if(!empty($input['filterPhone']))
			{
				$inputPhone = " AND (userPhone like '%".$input['filterPhone']."%')";
				$input['filterStatus'] = 'all';
				$input['filterDelivery'] = 'all';
				$input['fromDate'] = 'all';
			}
			$_SESSION['SESSION_ORDER']['filterPhone'][$getvar['tab']] = $input['filterPhone'];
			if(!empty($input['filterEmail']))
			{
				$inputEmail = " AND (userEmail like '%".$input['filterEmail']."%')";
				$input['filterStatus'] = 'all';
				$input['filterDelivery'] = 'all';
				$input['fromDate'] = 'all';
			}
			$_SESSION['SESSION_ORDER']['filterEmail'][$getvar['tab']] = $input['filterEmail'];
			if(!empty($input['filterName']))
			{
				$inputName = " AND (userName like '%".$input['filterName']."%' OR userPatronymic like '%".$input['filterName']."%' OR userFamily like '%".$input['filterName']."%')";
				$input['filterStatus'] = 'all';
				$input['filterDelivery'] = 'all';
				$input['fromDate'] = 'all';
			}
			$_SESSION['SESSION_ORDER']['filterName'][$getvar['tab']] = $input['filterName'];
			if(!empty($input['fromDate']) AND $input['fromDate'] != 'all')
			{
				$_SESSION['SESSION_ORDER']['filterFromDate'][$getvar['tab']] = $input['fromDate'];
				$input['fromDate'] = formatDate($input['fromDate'],'db').' 00:00:00';
				$inputTime = " AND `orderDate` >= '".$input['fromDate']."'";
			}
			elseif($input['fromDate'] != 'all')
			{
				$input['fromDate'] = date("d.m.Y",mktime(0, 0, 0, date("m")-1, date("d"), date("Y")));
				$input['fromDate'] = formatDate($input['fromDate'],'db').' 00:00:00';
				$inputTime = " AND `orderDate` >= '".$input['fromDate']."'";
			}
			if(!empty($input['toDate']))
			{
				$_SESSION['SESSION_ORDER']['filterToDate'][$getvar['tab']] = $input['toDate'];
				$input['toDate'] = formatDate($input['toDate'],'db').' 23:59:59';
				$inputTime .= " AND `orderDate` <= '".$input['toDate']."'";
			}
			else
			{
				$input['toDate'] = date("d.m.Y");
				$input['toDate'] = formatDate($input['toDate'],'db').' 23:59:59';
				$inputTime .= " AND `orderDate` <= '".$input['toDate']."'";
			}
	}
	
	$input['filter'] .= $inputTab.$inputNumber.$inputPhone.$inputEmail.$inputName.$inputPayMethod.$inputCourier.$inputStatus.$inputDelivery.$inputTime.$inputUserID;//.$inputUserDate;
	$filterHolder = $input['filter'];
//print_r($_SESSION['SESSION_ORDER']);
//print_r('<br><br><br><br><br><br><br><br><br><br><br>'.$filterHolder.'<br>***<br>');

//filter auto/happy
	$depFilter = '';
	if($userArray['userID'] == 555) {
		$dep = 0;
		$OR = '';
		while($dep < 6) {
			$dep++;
			if($dep == 3) $dep = 4;
			for($i=0; $i<count($depCat[$dep]); $i++) {
				$depFilter .= $OR.'wareCategory = \''.$depCat[$dep][$i].'\'';
				$OR = ' OR ';
			}
		}
	}
	elseif($userArray['userID'] == 444) {
		$OR = '';
		for($i=0; $i<count($depCat[3]); $i++) {
			$depFilter .= $OR.'wareCategory = \''.$depCat[3][$i].'\'';
			$OR = ' OR ';
		}
	}

    if (!empty($depFilter)) {
	    $depFilter = ' AND ('.$depFilter.')';
    }
	
	$input['tableName'] = "order";
	$input['select'] = 'DISTINCT(orderGroupID)';
	$input['filter'] = $filterHolder.$depFilter;
	$outputGroupID = getData($input);
	$input = "";

	$OR = '';
	$depFilter = '';
	for($i=0; $i<$outputGroupID['rows']; $i++) {
		$depFilter .= $OR.'orderGroupID = \''.$outputGroupID[$i]['orderGroupID'].'\'';
		$OR = ' OR ';
	}
    if (!empty($depFilter)) {
	    $depFilter = ' AND ('.$depFilter.')';
    }
	$filterHolder .= $depFilter;
//  }
	$input['tableName'] = "order";
	$input['select'] = 'COUNT(DISTINCT orderGroupID) AS countOrders';
	$input['filter'] = $filterHolder;
	$outputCount = getData($input);
	$input = "";

		$countEntity = 20;
		//$countEntity = 2;
		if(!isset($viewModePage)) $viewModePage = '';
		$limit = $countEntity;
		$numPage = $getvar['page'];
		if($numPage == 'all') {$numPage = 1; $viewModePage = 'all';}
		if(empty($numPage)) {$numPage = 1;}
		if($numPage == 1) { $startPos = 0; } else { $startPos = $numPage*$countEntity - $countEntity; }
		if(empty($startPos)) {$startPos = 0;}
		if($viewModePage == 'all'){$startPos = 0; $limit = $outputCount[0]['countOrders'];}
			
	$input['tableName'] = "order";
	$input['select'] = "GROUP_CONCAT(CONCAT(wareName, ' [', wareCount, ' shtyk.]') SEPARATOR '||') as wareNames, 
						GROUP_CONCAT(wareID SEPARATOR '||') as wareID, 
						GROUP_CONCAT(warePos SEPARATOR '||') as warePos, 
						GROUP_CONCAT(warePosName SEPARATOR '||') as warePosName, 
						GROUP_CONCAT(wareCategory SEPARATOR '||') as wareCategory, 
						GROUP_CONCAT(wareSubCategory SEPARATOR '||') as wareSubCategory, 
						SUM(enterPrice*wareCount) as enterSum, 
						SUM(warePrice*wareCount) as wareSum, 
						SUM(deliveryPrice) as deliveryPrice, 
						orderGroupID, 
						orderNumber, 
						orderDeclaration, 
						orderStatus,
						orderPriority,
						orderHistory,
						timeCreated, 
						orderDate, 
						orderCourse,
						orderPurchase, 
						orderCourier, 
						delivery,
						deliveryDate, 
						deliveryTimeStart, 
						deliveryTimeEnd, 
						payMethod,
						approved,
						approvedby,
						code,
						userID,
						userAdd,
						userName,
						userPatronymic,
						userFamily,
						userCity,
						userAdress, 
						userPhone,
						userEmail";
	$input['group'] = " group by orderGroupID DESC ";
	$input['filter'] = $filterHolder;
	$input['limit'] = ' limit '.$startPos.', '.$limit;
	$input['lang'] = 'no';
	if(empty($filter) AND $url == 'orderExtSearch')
	{
		$outputOrder['rows'] = 0;
	}
	else
	{
		$outputOrder = getData($input);
	}
	$input = "";

}

if ($url == 'manageOrderPrint') 
{
	//save/approve
	if(!isset($input['viewMode'])) $input['viewMode'] = '';
	if($input['viewMode'] == 'print' AND is_array($input['order']))
	{
		$filterGroup = ''; $OR = '';
		foreach($input['order'] as $key => $val)
		{
			if($val == '1')
			{
				$filterGroup .= $OR."orderGroupID = '". $key."'";
				$OR = ' OR ';
			}
		}
	}
	if(!empty($filterGroup))
	{

		$input['tableName'] = "order";
		$input['select'] = "GROUP_CONCAT(wareName SEPARATOR '||') as wareNames, 
						GROUP_CONCAT(orderID SEPARATOR '||') as orderID, 
						GROUP_CONCAT(warePrice SEPARATOR '||') as warePrice, 
						SUM(warePrice*wareCount) as wareSum, 
						SUM(deliveryPrice) as deliveryPrice, 
						orderGroupID, 
						timeCreated, 
						orderDate, 
						orderToDate, 
						orderCourse, 
						delivery,
						deliveryDate, 
						deliveryTimeStart,
						deliveryTimeEnd, 
						deliveryComment, 
						payMethod, 
						approved, 
						approvedby, 
						code, 
						prepaid, 
						orderNumber, 
						orderDeclaration, 
						orderPurchase, 
						orderNote, 
						orderStatus, 
						orderPriority, 
						oldStatus, 
						orderCourier, 
						orderHistory, 
						userID, 
						userAdd, 
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
		$input['filter'] = " AND (".$filterGroup.") ";
		$input['lang'] = 'no';	
		$outputOrder = getData($input);
		$input = '';
	}
}
if(!isset($systemMessage)) $systemMessage = '';
if(!isset($sort)) $sort = '';
if(!isset($hrefUserType)) $hrefUserType = '';
if(!isset($categoryName)) $categoryName = '';
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

/********** [ DEL DATA ] **********/
$FLAG_REFERER = false;
if (!empty($getvarFirst))
{
	$explodeFirst = explode ("-",$getvarFirst);
	$getvarEntity = $explodeFirst[1];
	if ($explodeFirst[0] == 'del')
	{
		$input['tableName'] = $getvarEntity;
		$input['filter_'.$getvarEntity.'ID'] = $getvar[$getvarFirst];
		$input['filter'] = getFilter($input);
		delData($input);
		$input = '';

		$FLAG_REFERER = true;
	}
}

if($FLAG_REFERER)
{
	header("Location: ".$_SERVER['HTTP_REFERER']);
}

?>