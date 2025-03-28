<link rel="STYLESHEET" type="text/css" href="js/calendar/dhtmlxcalendar.css">
<script type="text/javascript" src="js/calendar/dhtmlxcommon.js"></script>
<script src="js/calendar/dhtmlxcalendar.js" type="text/javascript"></script>
<table width="95%" border="0"><tr><td>
<form name="formDate" action="<?=urlse?>/adm/?manageUsers" method="post" enctype="multipart/form-data">
	ФИО (ник) <input type="text" name="fion" style="width:135px;" value="<?=$_SESSION['USERS']['fion']?>">&nbsp;
	E-mail	<input type="text" name="email" style="width:135px;" value="<?=$_SESSION['USERS']['email']?>">&nbsp;
	Телефон 	<input type="text" name="phone" style="width:115px;" value="<?=$_SESSION['USERS']['phone']?>">&nbsp;
	Тип		<select name="type">
				<option selected="selected" value="">Все</option>
				<?=getSelectedDropDown('ddUserType2', $_SESSION['USERS']['type'])?>
			</select>&nbsp;
	Статус 	<select name="status">
				<option <? if($_SESSION['USERS']['status'] == 'default') echo 'selected="selected"'; ?> value="">Все</option>
				<option <? if($_SESSION['USERS']['status'] == '1') echo 'selected="selected"'; ?> value="active">Активный</option>
				<option <? if($_SESSION['USERS']['status'] == '0') echo 'selected="selected"'; ?> value="hidden">Скрытый</option>
			</select><br />
	<div style="height:8px;">&nbsp;</div>
	<div id="dhtmlxDblCalendar" style="position:absolute; margin-top:27px;"></div>
	Дата регистрации с <input type="text" id="fromDate" name="fromDate" style="width:100px;">  по <input type="text" id="toDate" name="toDate" style="width:100px;"> <img src="js/calendar/imgs/calendar.gif" onclick="showHide()">
	<script>
	<?
		if(!empty($_SESSION['USERS']['fromDate'])) echo 'var mDCalDateFrom="'.$_SESSION['USERS']['fromDate'].'";'; else echo 'var mDCalDateFrom="01.01.2009";';
		if(!empty($_SESSION['USERS']['toDate'])) echo 'var mDCalDateTo="'.$_SESSION['USERS']['toDate'].'";'; else echo 'var mDCalDateTo="'.date("t.m.Y").'";';
	?>
	</script>
	<script src="js/calendar/setcalendar.js" type="text/javascript"></script>
	&nbsp;&nbsp;&nbsp;&nbsp;	
	<input type="hidden" name="company" value="0">
	Компания <input type="checkbox" name="company" value="1" <? if($_SESSION['USERS']['company']) echo 'checked="checked"'; ?>>
	<input type="submit" name="search" value="Фильтровать">
	<input type="submit" name="reset" value="Сброс">
</form>
</td></tr></table>
<center>
<br>
<div style="margin-bottom:10px;">
[ <a href="/adm/?manageUser/user/<?php if(!empty($getvar['page'])) {echo '/page/'.$getvar['page'];}?>" >Добавить пользователя</a> ]
</div>
<?
echo '<div class="grey" style="width:95%;text-align:left;">Пользователей('.$outputCount[0]['count(permAll)'].')</div>';
// view pages
if(empty($numPage)) {$numPage = 1;}
$countPages = ceil(@ $outputCount[0]['count(permAll)']/$countEntity);
if($outputCount[0]['count(permAll)'] > $countEntity)
{
	$maxPage = 10;
	$levelPage = ceil($numPage/$maxPage)-1;
	//$maxPos = count($outputUser)-1;
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

	echo '<div class="grey" style="width:90%;padding-bottom:5px;text-align:right;">Страницы: ';
	if($numPage > $maxPage)
	{
		echo '<span class="grey"><a href="?manageUsers/page/'.($startPage-1).'" class="grey">&nbsp; ['.($startPage-$maxPage).' - '.($startPage-1).'] &nbsp;</a></span>';
	}
	for ($p = $startPage; $p < $endPage + 1; $p++)
	{
		if($p == $numPage)
		{
			echo '<a class="greensmall"><strong>&#160;'.$p.'&#160;</strong></a>';
		}
		else if($p == 1)
		{
			echo '<a href="?manageUsers" class="grey">&#160;'.$p.'&#160;</a>';
		}
		else
		{
			echo '<a href="?manageUsers/page/'.$p.'" class="grey">&#160;'.$p.'&#160;</a>';
		}
	}
	if($countPages > $maxPage*($levelPage+1))
	{
		echo '<span class="grey"><a href="?manageUsers/page/'.($endPage+1).'" class="grey">&#160; &nbsp; ['.($endPage+1).' - '; if($countPages < $endPage+$maxPage){echo($countPages);}else{echo($endPage+$maxPage);} echo '] &nbsp; &#160;</a></span>';
	}
	echo '</div>';
}
?>
<table width="95%" style="border:1px solid #FFFFFF" cellpadding="3" cellspacing="1">
<tr>
	<th width="5%">Фото</th>
	<th>Ник\Имя</th>
	<th width="10%">Тип</th>
	<th width="10%">E-mail</th>
	<th width="10%">Город</th>
	<th width="10%" style="font-size:11px;">Дата создания/<br>Дата изменения</th>
	<th width="10%">Статус</th>
	<th width="7%"></th>
</tr>
<?php 
	for ($i=0; $i<$outputUser['rows']; $i++)
	{
		//echo '<input type="hidden" name="arrayID['.$i.']" value="'.$outputUser[$i]['userID'].'">';
		//echo '<input type="hidden" name="user_timeSaved['.$i.']" value="'.$outputUser[$i]['timeSaved'].'">';

		echo '<tr align="center">';
		echo '<td style="border:1px solid #E1E4E7;text-align:center">';
			if(!empty($outputUser[$i]['userImage'])) { echo '<img width="100px" src="../images/uploaduser/'.$outputUser[$i]['userImage'].'">'; }
			else { echo '<img src="img/bullet.gif">'; }
		echo '</td>';
		echo '<td class="row1" ><a class="green" href="/adm/?viewUser/user/'.$outputUser[$i]['userID'].'" >'.$outputUser[$i]['userNik'].'</a><br>'.$outputUser[$i]['userName'].' '.$outputUser[$i]['userFamily'].'</td>';
		echo '<td class="row1" align="center">'.getValueDropDown('ddUserType2', $outputUser[$i]['userType']).'</td>';
		echo '<td class="row1" style="text-align:center"><a href=mailto:'.$outputUser[$i]['userEmail'].'>'.$outputUser[$i]['userEmail'].'</a></td>';
		echo '<td class="row1">'.$outputUser[$i]['userCity'].'</td>';
		echo '<td class="row1" style="font-size:11px;">'.formatDate($outputUser[$i]['timeCreated'],'datetime').'<br>'.formatDate($outputUser[$i]['timeSaved'],'datetime').'</td>';
		echo '<td class="row1" align="center">'.getValueDropDown('ddPermAll', $outputUser[$i]['permAll']).'</td>';
		?>
		<td class="row1" style="text-align:center">
			<a href="/adm/?manageUser/user/<? echo $outputUser[$i]['userID']; if(!empty($getvar['page'])) {echo '/page/'.$getvar['page'];} ?>" ><img src="img/icon/edit.gif" onClick="this.src=edit_go.src;"  onMouseMove="this.src=edit_on.src;" onMouseOut="this.src=edit_out.src;" width="25" height="28" alt="Редактировать"></a>
			<a href="/adm/?manageUsers/del-user/<? echo $outputUser[$i]['userID']; if(!empty($getvar['page'])) {echo '/page/'.$getvar['page'];} ?>" onClick="return confirm('Удалить пользователя <?=$outputUser[$i]['userNik']?>?')" ><img src="img/icon/delete.gif" onClick="this.src=delete_go.src;" onMouseMove="this.src=delete_on.src;" onMouseOut="this.src=delete_out.src;" width="25" height="28" alt="Удалить"></a>
		</td>
		<?
		echo '</tr>';
	}
?>
</table>
<!--<div style="text-align:center; padding:5px;"><input type="submit" name="Submit" class="button" value="  Сохранить  "></div>-->
<?
if($outputCount[0]['count(permAll)'] > $countEntity)
{
	$maxPage = 10;
	$levelPage = ceil($numPage/$maxPage)-1;
	//$maxPos = count($outputUser)-1;
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

	echo '<div class="grey" style="width:95%;padding-top:5px;text-align:right;">Страницы: ';
	if($numPage > $maxPage)
	{
		echo '<span class="grey"><a href="?manageUsers/page/'.($startPage-1).'" class="grey">&#160; &nbsp; ['.($startPage-$maxPage).' - '.($startPage-1).'] &nbsp; &#160;</a></span>';
	}
	for ($p = $startPage; $p < $endPage + 1; $p++)
	{
		if($p == $numPage)
		{
			echo '<a class="greensmall"><strong>&#160;'.$p.'&#160;</strong></a>';
		}
		else if($p == 1)
		{
			echo '<a href="?manageUsers" class="grey">&#160;'.$p.'&#160;</a>';
		}
		else
		{
			echo '<a href="?manageUsers/page/'.$p.'" class="grey">&#160;'.$p.'&#160;</a>';
		}
	}
	if($countPages > $maxPage*($levelPage+1))
	{
		echo '<span class="grey"><a href="?manageUsers/page/'.($endPage+1).'" class="grey">&#160; &nbsp; ['.($endPage+1).' - '; if($countPages < $endPage+$maxPage){echo($countPages);}else{echo($endPage+$maxPage);} echo '] &nbsp; &#160;</a></span>';
	}
	echo '</div>';
}
?>
<br>
</center>
