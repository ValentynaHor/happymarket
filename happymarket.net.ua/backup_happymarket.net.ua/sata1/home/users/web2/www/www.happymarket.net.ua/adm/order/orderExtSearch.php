<br><br><?php 
if(!empty($getvar['page'])) $pageInsStr = 'page/'.$getvar['page'].'/'; else $pageInsStr = "";
if(!empty($getvar['filter'])) $filterInsStr = '/filter/'.$getvar['filter'].'/'; else $filterInsStr = "";
?>
<br><br>
<table width="98%" cellpadding="5" cellspacing="2" border="0"> 
  <tr>
	<td align="left">
<table cellpadding="5" cellspacing="2" border="0"> 
  <tr>
	<td align="left">
	<a href="/adm/?manageOrders/" >Упрощенный поиск</a>
    </td>
   </tr>
</table>
<form name="edit" action="?orderExtSearch/" method="post" enctype="multipart/form-data">
<table  cellpadding="5" cellspacing="2" border="0"> 
  <tr>
	<td><div style="width:20px; float:left; margin-top:5px">С</div>
		 <select name="fromDateDay">
		 <?=print_r(getSelectedDropDown('ddDays', $filter['fromDateDay']));?>
		 </select>
		 <select name="fromDateMonth">
		 <?=print_r(getSelectedDropDown('ddMonths_', $filter['fromDateMonth']));?>
		 </select>
		 <select name="fromDateYear">
		 <?=print_r(getSelectedDropDown('ddYears', $filter['fromDateYear']));?>
		 </select><br>
		<div style="width:20px; float:left; margin-top:5px">ПО</div>
		 <select name="toDateDay">
		 <?=print_r(getSelectedDropDown('ddDays', $filter['toDateDay']));?>
		 </select>
		 <select name="toDateMonth">
		 <?=print_r(getSelectedDropDown('ddMonths_', $filter['toDateMonth']));?>
		 </select>
		 <select name="toDateYear">
		 <?=print_r(getSelectedDropDown('ddYears', $filter['toDateYear']));?>
		 </select>
	  </td>
	  <td >
	  <div style="width:30px; float:left; margin-top:5px">ОТ $</div>
		<input type="text" name="fromPrice" style="width:50px;" value="<?=$filter['fromPrice']?>">	<br>	
	  <div style="width:30px; float:left; margin-top:5px">ДО $</div>
		<input type="text" name="toPrice" style="width:50px;" value="<?=$filter['toPrice']?>">		
	  </td>
	  <td valign="top">
	  <select name="wayPaying">
	  <?
	  if(empty($filter['wayPaying'])) $filter['wayPaying'] = "all";
		$ddWayPaying['all'] = 'все методы оплаты';
		print_r(getSelectedDropDown('ddWayPaying', $filter['wayPaying']));
	  ?>
	  </select><br>
	  <select name="approved">
	  <?
	  if(empty($filter['approved'])) $filter['approved'] = "all";
		print_r(getSelectedDropDown('ddApproved', $filter['approved']));
	  ?>
	  </select>
	  </td>
	  <td align="left" valign="top" >
	  <input type="submit" name="ffilter" class="button" style="margin-top:1px; margin-left:10px" value="  Фильтр  ">
	  <input type="submit" name="reset" class="button" style="margin-top:1px; margin-left:10px" value="  Сброс  ">
	  </td>
	</tr>
	</table>
	</form>
    </td>
   </tr>
    <tr>
	<td align="left">
	Всего найдено: <?=$outputCount[0]['countOrders']?>
    </td>
   </tr>
</table>
<center>
<br>
<?
	if ($outputCount[0]['countOrders'] > $countEntity)
	{
		$maxPage = 30;
		$countPages = ceil($outputCount[0]['countOrders']/$countEntity);
		$levelPage = ceil($numPage/$maxPage)-1;
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
			echo '<a href="?orderExtSearch'.$sort.'/page/'.($numPage-1).$filterInsStr.'" alt="Предыдущая"><strong>&#160;&laquo;&#160;</strong></a>';
			}
		if($numPage > $maxPage)
			{
				echo '<span class="small"><a href="?orderExtSearch'.$sort.'/page/'.($startPage-1).$filterInsStr.'" class="small">&#160; &nbsp; ['.($startPage-$maxPage).' - '.($startPage-1).'] &nbsp; &#160;</a></span>';
			}
		for ($p = $startPage; $p < $endPage + 1; $p++)
		{	
			if($p == $numPage AND $viewModePage != 'all')
			{
				echo '<span class="note"> &#160;'.$p.'&#160; </span>';
			}
			else if($p == 1)
			{
				echo '<a href="?orderExtSearch'.$sort.$filterInsStr.'" class="small"> &#160;'.$p.'&#160; </a>';
			}
			else
			{
				echo '<a href="?orderExtSearch'.$sort.'/page/'.$p.$filterInsStr.'" class="small"> &#160;'.$p.'&#160; </a>';
			}
		}
		if($countPages > $maxPage*($levelPage+1))
			{
				echo '<span class="small"><a href="?orderExtSearch'.$sort.'/page/'.($endPage+1).$filterInsStr.'" class="small">&#160; &nbsp; ['.($endPage+1).' - '; if($countPages < $endPage+$maxPage){echo($countPages);}else{echo($endPage+$maxPage);} echo'] &nbsp; &#160;</a></span>';
			}
		if($numPage != $countPages)
			{
			echo '<a href="?orderExtSearch'.$sort.'/page/'.($numPage+1).$filterInsStr.'" alt="Следующая"><strong>&#160;&raquo;&#160;</strong></a>';
			}
		if($viewModePage == 'all')
		{
			echo '<span class="note">&#160; все</span>';
		}
		else
		{
			echo '<a href="?orderExtSearch'.$sort.'/page/all'.$filterInsStr.'" class="page" title="Показать все '.$categoryName.'">&#160; все</a>';
		}
		echo '</div>';
	}
?>

<table width="98%" style="border:1px solid #FFFFFF" cellpadding="5" cellspacing="2">
  <tr>
    <th>#</th>
    <th width="120px">ФИО\E-mail</th>
	<th>Товары</th>
	<th>Сумма</th>
	<th>Доставка/Сумма</th>
	<th>Тип оплаты</th>
	<th width="60px">Дата</th>
	<th>Подтверждено</th>
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
			echo '<td class="row1" align="center">'.$outputOrder[$i]['orderGroupID'].'</td>';
			echo '<td class="row1" align="center">'; if(!empty($outputOrder[$i]['userID'])) echo '<a class="green" href="/adm/?viewUser/user/'.$outputOrder[$i]['userID'].'" ><div style="text-align:left;">'.$outputOrder[$i]['userFamily'].' '.$outputOrder[$i]['userName'].'</div><div style="text-align:right;">'.$outputOrder[$i]['userPatronymic'].'</div></a>'; else echo '<div style="text-align:left;">'.$outputOrder[$i]['userFamily'].' '.$outputOrder[$i]['userName'].'</div><div style="text-align:right;">'.$outputOrder[$i]['userPatronymic'].'</div>'; echo '<a href=mailto:'.$outputOrder[$i]['userEmail'].'>'.$outputOrder[$i]['userEmail'].'</a></td>';
			echo '<td class="row1">';
				$outputOrder[$i]['wareNames'] = del_tags($outputOrder[$i]['wareNames']);
				$arrayID = explode(",",$outputOrder[$i]['wareID']);
				$arrayName = explode(",",$outputOrder[$i]['wareNames']);
				$arrayCat = explode(",",$outputOrder[$i]['wareCategory']);
				$arraySub = explode(",",$outputOrder[$i]['wareSubCategory']);
				$SEP = '';
				for($j=0; $j < count($arrayID); $j++)
				{
					echo $SEP.'<a target="_blank" href="?manageWare/edit-'.$arrayCat[$j].'/'.$arrayID[$j].'/category/'.$arrayCat[$j].'/sub/'.$arraySub[$j].'">'.$arrayName[$j].'</a>';
					$SEP = ', ';
				}
			echo '</td>';
			echo '<td class="row1" align="center">';
				echo '<b>$'.$outputOrder[$i]['wareSum'].'</b><br><font style="font-size:11px"><nobr>('.round($outputOrder[$i]['wareSum']*$outputOrder[$i]['orderCourse']).' грн.)</nobr></font>';
			echo '</td>';
			echo '<td class="row1" align="center">';
				if($outputOrder[$i]['delivery'] == 1) echo "без доставки";
				elseif($outputOrder[$i]['delivery'] == 2) echo "доставка по Киеву";
				elseif($outputOrder[$i]['delivery'] == 3) {echo "доставка по Украине"; if(!empty($outputOrder[$i]['userCity'])) echo '&nbsp;('.$outputOrder[$i]['userCity'].')';}
				else echo $code['cart_delivery_1'];
				if($outputOrder[$i]['delivery'] == 3 AND !empty($outputOrder[$i]['deliveryPrice']))
					echo '<br><nobr><b>$'.(round($outputOrder[$i]['deliveryPrice']/$outputOrder[$i]['orderCourse'],2)).'</b>&nbsp;<font style="font-size:11px">('.$outputOrder[$i]['deliveryPrice'].' грн.)</font></nobr>';
				elseif($outputOrder[$i]['delivery'] == 2 AND !empty($outputOrder[$i]['deliveryPrice']))
					echo '<br><nobr><b>$'.(round(@($outputOrder[$i]['deliveryPrice']/count($arrayID))/$outputOrder[$i]['orderCourse'],2)).'</b>&nbsp;<font style="font-size:11px">('.(@$outputOrder[$i]['deliveryPrice']/count($arrayID)).' грн.)</font></nobr>';
			echo '</td>';
			echo '<td class="row1" align="center">'.getValueDropDown('ddWayPaying', $outputOrder[$i]['payMethod']).'</td>';
			echo '<td class="row1" align="center">'.formatDate($outputOrder[$i]['timeCreated'], 'datetime').'</td>';
			echo '<td class="row1" align="center">'.$outputOrder[$i]['approvedby'].'</td>';
			?>
			<td class="row1" style="text-align:center">
				<a href="/adm/?manageOrder/order/<? echo $outputOrder[$i]['orderGroupID'];?><?=$filterInsStr?><?=$pageInsStr?>" ><img src="img/icon/select.gif" onClick="this.src=select_go.src;" onMouseMove="this.src=select_on.src;" onMouseOut="this.src=select_out.src;" width="25" height="28" alt="Подтвердить"></a>
				<a href="/adm/?orderExtSearch/delete/<? echo $outputOrder[$i]['orderGroupID']; if(!empty($getvar['page'])) echo '/page/'.$getvar['page'];?>" onClick="return confirm('Удалить заказ #<?=$outputOrder[$i]['orderGroupID']?>?')" ><img src="img/icon/delete.gif" onClick="this.src=delete_go.src;" onMouseMove="this.src=delete_on.src;" onMouseOut="this.src=delete_out.src;" width="25" height="28" alt="Удалить"></a>
			</td>
			<?
			echo '</tr>';
		}
	?>
</table>

<?
//view pages
	if ($outputCount[0]['countOrders'] > $countEntity)
	{
		echo '<div style="width:98%; margin-top:5px; margin-bottom:1px" align="right"> Страницы: ';
		if($numPage != 1)
			{
			echo '<a href="?orderExtSearch'.$sort.'/page/'.($numPage-1).$filterInsStr.'" alt="Предыдущая"><strong>&#160;&laquo;&#160;</strong></a>';
			}
		if($numPage > $maxPage)
			{
				echo '<span class="small"><a href="?orderExtSearch'.$sort.'/page/'.($startPage-1).$filterInsStr.'" class="small">&#160; &nbsp; ['.($startPage-$maxPage).' - '.($startPage-1).'] &nbsp; &#160;</a></span>';
			}
		for ($p = $startPage; $p < $endPage + 1; $p++)
		{	
			if($p == $numPage AND $viewModePage != 'all')
			{
				echo '<span class="note"> &#160;'.$p.'&#160; </span>';
			}
			else if($p == 1)
			{
				echo '<a href="?orderExtSearch'.$sort.$filterInsStr.'" class="small"> &#160;'.$p.'&#160; </a>';
			}
			else
			{
				echo '<a href="?orderExtSearch'.$sort.'/page/'.$p.$filterInsStr.'" class="small"> &#160;'.$p.'&#160; </a>';
			}
		}
		if($countPages > $maxPage*($levelPage+1))
			{
				echo '<span class="small"><a href="?orderExtSearch'.$sort.'/page/'.($endPage+1).$filterInsStr.'" class="small">&#160; &nbsp; ['.($endPage+1).' - '; if($countPages < $endPage+$maxPage){echo($countPages);}else{echo($endPage+$maxPage);} echo'] &nbsp; &#160;</a></span>';
			}
		if($numPage != $countPages)
			{
			echo '<a href="?orderExtSearch'.$sort.'/page/'.($numPage+1).$filterInsStr.'" alt="Следующая"><strong>&#160;&raquo;&#160;</strong></a>';
			}
		if($viewModePage == 'all')
		{
			echo '<span class="note">&#160; все</span>';
		}
		else
		{
			echo '<a href="?orderExtSearch'.$sort.'/page/all'.$filterInsStr.'" class="page" title="Показать все '.$categoryName.'">&#160; все</a>';
		}

		echo '</div>';
	}
?>
<br>
</center>