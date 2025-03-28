<link rel="STYLESHEET" type="text/css" href="js/calendar/dhtmlxcalendar.css">
<script type="text/javascript" src="js/calendar/dhtmlxcommon.js"></script>
<script src="js/calendar/dhtmlxcalendar.js" type="text/javascript"></script>
<?php 
if(!empty($getvar['page'])) $var_page = '/page/'.$getvar['page'];
//if(!empty($getvar['filter'])) $var_filter = '/filter/'.$getvar['filter'];
if(!empty($getvar['user'])) $var_user = '/user/'.$getvar['user'];
?>

<? if(empty($getvar['user'])){?>
<table border="0" cellpadding="5" cellspacing="1" width="98%" style="margin-top:14px;">
  <tr valign="top">
	<td align="center" valign="middle">
	[ <a href="/adm/?manageOrder<?=$var_tab.$var_page.$var_filter.$var_user?>">Добавить заказ</a> ]
	</td>
  </tr>
</table>
<? } else echo '<div style="text-align:left;padding:20px;">[ <a href="/adm/?viewManagersStats'.$var_tab.$var_page.$var_filter.$var_user.'" >Назад</a> ]</div>'; ?>
<form name="formDate" action="<?=$sid?>" method="post" enctype="multipart/form-data" style="margin:0px;">
<input type="hidden" name="viewMode" value="filter">
<!--input type="hidden" name="tab" value="<?=$getvar['tab']?>"-->
<div style="text-align:left; width:98%; margin-top:5px; margin-bottom:4px;">
<nobr>
	<div id="dhtmlxDblCalendar" style="position:absolute; margin-top:30px;"></div>
	&nbsp;Дата с <input type="text" id="fromDate" name="fromDate" style="width:80px;">  по <input type="text" id="toDate" name="toDate" style="width:80px;"> <img src="js/calendar/imgs/calendar.gif" onclick="showHide()">
	<script>
	<?
		if(!empty($_SESSION['SESSION_ORDER']['filterFromDate'][$getvar['tab']])) echo 'var mDCalDateFrom="'.$_SESSION['SESSION_ORDER']['filterFromDate'][$getvar['tab']].'";'; else echo 'var mDCalDateFrom="'.date("d.m.Y",mktime(0, 0, 0, date("m")-1, date("d"), date("Y"))).'";';
		if(!empty($_SESSION['SESSION_ORDER']['filterToDate'][$getvar['tab']])) echo 'var mDCalDateTo="'.$_SESSION['SESSION_ORDER']['filterToDate'][$getvar['tab']].'";'; else echo 'var mDCalDateTo="'.date("d.m.Y").'";';
	?>
	</script>
	<script src="js/calendar/setcalendar.js" type="text/javascript"></script>
	&nbsp; &nbsp;№:&nbsp;
	<? if(!isset($_SESSION['SESSION_ORDER']['filterNumber'][$getvar['tab']])) $_SESSION['SESSION_ORDER']['filterNumber'][$getvar['tab']] = '';?>
		 <input type="text" name="filterNumber" style="width:50;" value="<?=$_SESSION['SESSION_ORDER']['filterNumber'][$getvar['tab']]?>">

	&nbsp;Тел.:&nbsp;
	<? if(!isset($_SESSION['SESSION_ORDER']['filterPhone'][$getvar['tab']])) $_SESSION['SESSION_ORDER']['filterPhone'][$getvar['tab']] = '';?>
		 <input type="text" name="filterPhone" style="width:120;" value="<?=$_SESSION['SESSION_ORDER']['filterPhone'][$getvar['tab']]?>">

	&nbsp;E-mail:&nbsp;
	<? if(!isset($_SESSION['SESSION_ORDER']['filterEmail'][$getvar['tab']])) $_SESSION['SESSION_ORDER']['filterEmail'][$getvar['tab']] = '';?>
		 <input type="text" name="filterEmail" style="width:120;" value="<?=$_SESSION['SESSION_ORDER']['filterEmail'][$getvar['tab']]?>">

	&nbsp;ФИО:&nbsp;
	<? if(!isset($_SESSION['SESSION_ORDER']['filterName'][$getvar['tab']])) $_SESSION['SESSION_ORDER']['filterName'][$getvar['tab']] = '';?>
		 <input type="text" name="filterName" style="width:120;" value="<?=$_SESSION['SESSION_ORDER']['filterName'][$getvar['tab']]?>">


	<div style="padding-top:8px;padding-bottom:5px;">
	&nbsp;Статус:&nbsp;
	<?
		foreach($ddOrderStatus as $keyStatus => $valStatus)
		{
			if(strstr($_SESSION['SESSION_ORDER']['filterStatus'][$getvar['tab']], '&'.$keyStatus.'&'))
			{
				$checked = 'checked'; $style = 'style="color:#000000"';
				echo '<input type="hidden" name="filterStatus['.$keyStatus.']" value="0">';
			}
			else
			{
				$checked = ''; $style = 'style="color:#999999"';
			}
			echo '<input type="checkbox" name="filterStatus['.$keyStatus.']" value="1" '.$checked.'>&nbsp;<span '.$style.'>'.$valStatus.'</span>&nbsp;';
		}
	?>
	</div>
	&nbsp;Доставка:&nbsp;
	<?
		foreach($ddDelivery as $keyDelivery => $valDelivery)
		{
			if(strstr($_SESSION['SESSION_ORDER']['filterDelivery'][$getvar['tab']], '&'.$keyDelivery.'&'))
			{
				$checked = 'checked'; $style = 'style="color:#000000"';
				echo '<input type="hidden" name="filterDelivery['.$keyDelivery.']" value="0">';
			}
			else
			{
				$checked = ''; $style = 'style="color:#999999"';
			}
			echo '<input type="checkbox" name="filterDelivery['.$keyDelivery.']" value="1" '.$checked.'>&nbsp;<span '.$style.'>'.$valDelivery.'</span>&nbsp;';
		}
	?>

	&nbsp; <input type="submit" class="button" name="submit" value=" Фильтровать " style="height:19px"/>	
</nobr>
</div>
</form>
<table width="98%" cellpadding="0" cellspacing="5" border="0"> 
<tr>
	<td align="left" valign="bottom">
	Всего найдено: <?=$outputCount[0]['countOrders']?>
	</td>
	<td valign="bottom">
	<?
	if ($outputCount[0]['countOrders'] > $countEntity)
	{
		$maxPage = 30;
		$countPages = ceil($outputCount[0]['countOrders']/$countEntity);
		$levelPage = ceil($numPage/$maxPage)-1;
		//$maxPos = count($outputOrder)-1;
		if(!empty($maxPage) AND ($numPage > $maxPage))
		{
			$startPage = $maxPage*$levelPage + 1;
		}
		else if(!empty($maxPage) AND ($numPage <= $maxPage))
		{
			$startPage = 1;
		}
		if($countPages < $maxPage*($levelPage+1)) { $endPage = $countPages; }
		else{ $endPage = $maxPage*($levelPage+1);}

		echo '<div style="width:98%; margin-top:0px; margin-bottom:1px" align="right"> Страницы: ';
		if($numPage != 1)
			{
			echo '<a href="?manageOrders'.$sort.'/page/'.($numPage-1).$var_tab.$var_filter.$var_user.'" alt="Предыдущая"><strong>&#160;&laquo;&#160;</strong></a>';
			}
		if($numPage > $maxPage)
			{
				echo '<span class="small"><a href="?manageOrders'.$sort.'/page/'.($startPage-1).$var_tab.$var_filter.$var_user.'" class="small">&#160; &nbsp; ['.($startPage-$maxPage).' - '.($startPage-1).'] &nbsp; &#160;</a></span>';
			}
		for ($p = $startPage; $p < $endPage + 1; $p++)
		{	
			if($p == $numPage AND $viewModePage != 'all')
			{
				echo '<span class="note"> &#160;'.$p.'&#160; </span>';
			}
			else if($p == 1)
			{
				echo '<a href="?manageOrders/'.$sort.$var_tab.$var_filter.$var_user.'" class="small"> &#160;'.$p.'&#160; </a>';
			}
			else
			{
				echo '<a href="?manageOrders'.$sort.'/page/'.$p.$var_tab.$var_filter.$var_user.'" class="small"> &#160;'.$p.'&#160; </a>';
			}
		}
		if($countPages > $maxPage*($levelPage+1))
			{
				echo '<span class="small"><a href="?manageOrders'.$sort.'/page/'.($endPage+1).$var_tab.$var_filter.$var_user.'" class="small">&#160; &nbsp; ['.($endPage+1).' - '; if($countPages < $endPage+$maxPage){echo($countPages);}else{echo($endPage+$maxPage);} echo'] &nbsp; &#160;</a></span>';
			}
		if($numPage != $countPages)
			{
			echo '<a href="?manageOrders'.$sort.'/page/'.($numPage+1).$var_tab.$var_filter.$var_user.'" alt="Следующая"><strong>&#160;&raquo;&#160;</strong></a>';
			}
		if($viewModePage == 'all')
		{
			echo '<span class="note">&#160; все</span>';
		}
		else
		{
			echo '<a href="?manageOrders'.$sort.'/page/all'.$var_tab.$var_filter.$var_user.'" class="page" title="Показать все '.$categoryName.'">&#160; все</a>';
		}
		echo '</div>';
	}
	?>
	</td>
</tr>
</table>

<center>
<form target="_blank" name="print" action="/adm/?manageOrderPrint" method="post" enctype="multipart/form-data">
<input type="hidden" name="viewMode" value="print" />
<table width="98%" style="border:1px solid #FFFFFF" cellpadding="5" cellspacing="1">
  <tr>
	<th width="20px"></th>
	<? /*<th width="25px">Приоритет</th> */?>
	<th width="100px">Заказ</th>
	<th>Товары</th>
	<th width="120px">Вх. сумма</th>
	<th width="120px">Сумма</th>
	<th width="120px">Доход</th>
	<? /*<th width="120px">Доставка</th> */?>
	<th width="120px">ФИО\Тел.</th>
	<th width="60px">Создан</th>
	<th width="100px">Статус</th>
	<th width="65px"></th>
  </tr>
    <?php 
		for($i=0; $i<$outputOrder['rows']; $i++)
		{
			if(empty($outputOrder[$i]['delivery'])) $outputOrder[$i]['delivery'] = 3;
			if($outputOrder[$i]['orderCourse'] == '0.00')
			{
					if($outputOrder[$i]["payMethod"] == '0' AND !empty($outputOrder[$i]["delivery"])) $outputOrder[$i]['orderCourse'] = $outputSetting[0]['courseUSD'];
					elseif($outputOrder[$i]["payMethod"] == '3' OR $outputOrder[$i]["payMethod"] == '1') $outputOrder[$i]['orderCourse'] = $outputSetting[0]['courseNonCashNonNDSUSD'];
					else $outputOrder[$i]['orderCourse'] = $outputSetting[0]['courseNonCashUSD'];
			}
			if($outputOrder[$i]['wareCount'] == '0') $outputOrder[$i]['wareCount'] = 1;
			echo '<input type="hidden" name="order['.$outputOrder[$i]['orderGroupID'].']" value="0">';

			echo '<tr>';
			echo '<td class="row1" align="center"><input type="checkbox" name="order['.$outputOrder[$i]['orderGroupID'].']" value="1"></td>';
			/*
			echo '<td class="row1" align="center">';
				echo '<img src="img/icon/priority'.$outputOrder[$i]['orderPriority'].'.gif" alt="'.getValueDropDown('ddPriority',$outputOrder[$i]['orderPriority']).'" title="'.getValueDropDown('ddPriority',$outputOrder[$i]['orderPriority']).'">';
			echo '</td>';
			*/
			echo '<td style="border:1px solid #E1E4E7; cursor:pointer; background-color:#E1F7D0;" onmousemove="this.style.backgroundColor=\'white\';" onmouseout="this.style.backgroundColor=\'#E1F7D0\';" align="center" onclick="location.href=\'/adm/?viewOrder/order/'.$outputOrder[$i]['orderGroupID'].$var_tab.$var_page.$var_filter.$var_user.'\'"><a style="color:#3B69AA;"  href="/adm/?viewOrder/order/'.$outputOrder[$i]['orderGroupID'].$var_tab.$var_page.$var_filter.$var_user.'"><b>Заказ&nbsp;№'.$outputOrder[$i]['orderGroupID'].'</b>';
			if($outputOrder[$i]['orderNumber'] != 0) echo '<span style="font-size:11; color:#6C7686"><br />Накладная&#160;№'.$outputOrder[$i]['orderNumber'].'</span>';
			if($outputOrder[$i]['orderDeclaration'] != 0) echo '<span style="font-size:11; color:#6C7686"><br />Декларация&#160;№'.$outputOrder[$i]['orderDeclaration'].'</span>';
			echo '</a></td><td class="row1">';
				$outputOrder[$i]['wareNames'] = del_tags($outputOrder[$i]['wareNames']);
				$arrayID = explode("||",$outputOrder[$i]['wareID']);
				$arrayName = explode("||",str_replace('shtyk','шт',$outputOrder[$i]['wareNames']));
				$arrayCat = explode("||",$outputOrder[$i]['wareCategory']);
				$arraySub = explode("||",$outputOrder[$i]['wareSubCategory']);
				$outputOrder[$i]['warePosName'] = explode("||",$outputOrder[$i]['warePosName']);
				$SEP = '';
				for($j=0; $j < count($arrayID); $j++)
				{
					if(!empty($outputOrder[$i]['warePosName'][$j]))
					{
						$outputOrder[$i]['warePosName'][$j] = '<br><span style="font-size:11px;">'.str_replace('&&','; ',$outputOrder[$i]['warePosName'][$j]).'</span>';
					}
					echo $SEP.'<a target="_blank" class="green" href="?manageResource/dept/'.$CAT_ARRAY[$arrayCat[$j]]['categoryDepartment'].'/resource/'.$arrayID[$j].'/category/'.$arrayCat[$j].'/sub/'.$arraySub[$j].'">'.($j+1).'. '.$arrayName[$j].'</a>'.$outputOrder[$i]['warePosName'][$j];
					$SEP = '<br /> ';
				}
			echo '</td>';
			echo '<td class="row1" align="center">';
				echo '<b>'.$outputOrder[$i]['enterSum'].' грн.</b>';
			echo '</td>';
			echo '<td class="row1" align="center">';
				echo '<b>'.$outputOrder[$i]['wareSum'].' грн.</b>';
			echo '</td>';
			echo '<td class="row1" align="center">';
				echo '<b>'.($outputOrder[$i]['wareSum']-$outputOrder[$i]['enterSum']).' грн.</b>';
			echo '</td>';
			/*
			echo '<td class="row1" align="center">';
				if($outputOrder[$i]['delivery'] == 1) echo "без доставки";
				elseif($outputOrder[$i]['delivery'] == 2) echo "доставка по Киеву";
				elseif($outputOrder[$i]['delivery'] == 3) echo "доставка по Украине";
				else echo "без доставки";
			echo '</td>';
			*/
			echo '<td class="row1" align="left"><a class="green" href="/adm/?viewUser/user/'.$outputOrder[$i]['userID'].'" >'.$outputOrder[$i]['userFamily'].' '.$outputOrder[$i]['userName'].' '.$outputOrder[$i]['userPatronymic'].'</a><div style="font-size:11px;text-align:left;padding-top:5px;">Тел.:&nbsp;'.$outputOrder[$i]['userPhone'].'<br>E-mail:&nbsp;'.$outputOrder[$i]['userEmail'].'</div></td>';
			echo '<td class="row1" align="center">';
				if(!empty($outputOrder[$i]['userAdd']) AND $outputOrder[$i]['userAdd'] != '555') echo '<a class="green" href="/adm/?viewUser/user/'.$outputOrder[$i]['userAdd'].'" >'.$ddAllManager[$outputOrder[$i]['userAdd']]['userNik'].'</a>'; elseif($outputOrder[$i]['userAdd'] == '555') echo '<a class="green">Root</a>'; else echo '<a class="green">Клиент</a>';
				echo '<br><nobr>'.formatDate($outputOrder[$i]['orderDate'], 'datetime').'</nobr>';
			echo '</td>';
			echo '<td class="row1" align="center">';
				if(!empty($outputOrder[$i]['orderHistory']) AND $outputOrder[$i]['orderStatus'] != '0')
				{
					$historyArray = @ explode('&',$outputOrder[$i]['orderHistory']);
					$hArray = @ explode('|',$historyArray[count($historyArray)-2]); 
					if($hArray[1] != 'Клиент' AND $hArray[1] != '555') { echo '<a class="green" href="/adm/?viewUser/user/'.$hArray[1].'" >'.$ddAllManager[$hArray[1]]['userNik'].'</a>'; } elseif($hArray[1] == 'Клиент') { echo '<a class="green">Клиент</a>'; } elseif($hArray[1] == '555') { echo '<a class="green">Root</a>'; }
					echo '<br>';
				}
				echo getValueDropDown('ddOrderStatus', $outputOrder[$i]['orderStatus']);
			echo '</td>';

			?>
			<td class="row1" style="text-align:center;padding:0px;">
				<? if(($userArray['groupID'] == 'admin' OR $userArray['userID'] == $outputOrder[$i]['userAdd'] OR empty($outputOrder[$i]['userAdd'])) AND $outputOrder[$i]['orderStatus'] != '2' AND $outputOrder[$i]['orderStatus'] != '4'){?>
				<a target="_blank" href="/adm/?manageOrder/order/<? echo $outputOrder[$i]['orderGroupID'];?><?=$var_tab.$var_page.$var_filter.$var_user?>" ><img src="img/icon/edit.gif" onClick="this.src=edit_go.src;"  onMouseMove="this.src=edit_on.src;" onMouseOut="this.src=edit_out.src;" width="25" height="28" alt="Редактировать"></a>
				<? }?>
				<? if($userArray['groupID'] == 'admin'){?>
				<a href="/adm/?manageOrders/delete/<? echo $outputOrder[$i]['orderGroupID']; echo $var_tab.$var_page.$var_filter.$var_user; ?>" onClick="return confirm('Удалить заказ #<?=$outputOrder[$i]['orderGroupID']?>?')" ><img src="img/icon/delete.gif" onClick="this.src=delete_go.src;" onMouseMove="this.src=delete_on.src;" onMouseOut="this.src=delete_out.src;" width="25" height="28" alt="Удалить"></a>
				<? }?>
			</td>
			<?
			echo '</tr>';
		}
	?>
</table>
<table width="98%" cellpadding="5" cellspacing="1">
  <tr><td><input type="submit" name="ssearch" class="button" value="  Печать  "></td>
  <td align="right">
<?
//view pages
	if ($outputCount[0]['countOrders'] > $countEntity)
	{
		echo 'Страницы: ';
		if($numPage != 1)
			{
			echo '<a href="?manageOrders'.$sort.'/page/'.($numPage-1).$var_tab.$var_filter.$var_user.'" alt="Предыдущая"><strong>&#160;&laquo;&#160;</strong></a>';
			}
		if($numPage > $maxPage)
			{
				echo '<span class="small"><a href="?manageOrders'.$sort.'/page/'.($startPage-1).$var_tab.$var_filter.$var_user.'" class="small">&#160; &nbsp; ['.($startPage-$maxPage).' - '.($startPage-1).'] &nbsp; &#160;</a></span>';
			}
		for ($p = $startPage; $p < $endPage + 1; $p++)
		{	
			if($p == $numPage AND $viewModePage != 'all')
			{
				echo '<span class="note"> &#160;'.$p.'&#160; </span>';
			}
			else if($p == 1)
			{
				echo '<a href="?manageOrders/'.$sort.$var_tab.$var_filter.$var_user.'" class="small"> &#160;'.$p.'&#160; </a>';
			}
			else
			{
				echo '<a href="?manageOrders'.$sort.'/page/'.$p.$var_tab.$var_filter.$var_user.'" class="small"> &#160;'.$p.'&#160; </a>';
			}
		}
		if($countPages > $maxPage*($levelPage+1))
			{
				echo '<span class="small"><a href="?manageOrders'.$sort.'/page/'.($endPage+1).$var_tab.$var_filter.$var_user.'" class="small">&#160; &nbsp; ['.($endPage+1).' - '; if($countPages < $endPage+$maxPage){echo($countPages);}else{echo($endPage+$maxPage);} echo'] &nbsp; &#160;</a></span>';
			}
		if($numPage != $countPages)
			{
			echo '<a href="?manageOrders'.$sort.'/page/'.($numPage+1).$var_tab.$var_filter.$var_user.'" alt="Следующая"><strong>&#160;&raquo;&#160;</strong></a>';
			}
		if($viewModePage == 'all')
		{
			echo '<span class="note">&#160; все</span>';
		}
		else
		{
			echo '<a href="?manageOrders'.$sort.'/page/all'.$var_tab.$var_filter.$var_user.'" class="page" title="Показать все '.$categoryName.'">&#160; все</a>';
		}
	}

?>
</td></tr></table>
<br>
</center>
