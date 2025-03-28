<script language="JavaScript" type="text/javascript" src="js/validator.js"></script>
<div style="text-align:center;padding:10px;">
<?
	if(!empty($getvar['page'])) $INCpage = '/page/'.$getvar['page']; else $INCpage = '';
	if(!empty($getvar['letter'])) $INCletter = '/letter/'.$getvar['letter']; else $INCletter = '';
	if(!empty($getvar['status'])) $INCstatus = '/status/'.$getvar['status']; else $INCstatus = '';
	if(!empty($messageText)) echo '<div style="color:#FF0000;font-size:16;padding:10px;">'.$messageText.'</div>';
	echo '<div style="padding:10px;">[ <a href="?manageBrand'.$INCstatus.$INCletter.$INCpage.'">Новый бренд</a> ]</div>';
?>
</div>
<?
	foreach($ddAlphabet_en as $key => $val)
	{
		if(strpos($ACTIVE_LETTERS,'|'.$key.'|') === false AND strpos($ACTIVE_LETTERS,'|'.$val.'|') === false)
		{
			echo '<span style="color:#CDC9C9;">'.$key.'</span>&#160;';
		}
		else
		{
			if($key == $getvar['letter'] OR $val == $getvar['letter']) echo '<span class="black"><b>'.$key.'</b></span>&#160;';
			else echo '<a href="'.$urlve.'?manageBrands'.$INCstatus.'/letter/'.$val.'" >'.$key.'</a>&#160;';
		}
	}
	echo ' &#160; &#160; &#160; ';
	if($getvar['letter'] == 'ru') echo '<span class="black"><b>А-Я</b></span>&#160;';
	else echo '<a href="'.$urlve.'?manageBrands'.$INCstatus.'/letter/ru" >А-Я</a>&#160;';
	echo '</div>';
	echo '<div style="height:5px;"></div>';
?>
<div style="width:700px;">
<div style="float:left;">
	Количество: <?=$outputCount[0]['count(permAll)']?> (<?=$countBrands?>)
</div>
<div style="float:right;">
	<?
		if(isset($getvar['status'])) echo '<a href="?manageBrands'.$INCletter.'">все</a>&nbsp;|'; else echo 'все&nbsp;|';
		if($getvar['status'] != 'active') echo '<a href="?manageBrands/status/active'.$INCletter.'">активные</a>&nbsp;|'; else echo 'активные</a>&nbsp;|';
		if($getvar['status'] != 'hidden') echo '<a href="?manageBrands/status/hidden'.$INCletter.'">скрытые</a>'; else echo 'скрытые';
	?>
</div>	
</div>
<table width="700px" border="0"  bordercolor="#FFFFFF" cellpadding="3" cellspacing="1">
  <tr>
	<th>Название</th>
	<th width="10%">Статус</th>
	<th width="20%" style="font-size:11px;">Дата создания/<br />сохранения</th>
	<th width="10%"></th>
  </tr>

<?
	for ($i=0; $i<$output['rows']; $i++)
	{
		echo '<tr align="center">';
			echo '<td class="row1" align="left">'.$output[$i]['brandName'].'</td>';
			echo '<td class="row1" align="center">'.getValueDropDown('ddPermAll',$output[$i]['permAll']).'</td>';
			echo '<td class="row1" align="center" style="font-size:11px;">'.formatDate($output[$i]['timeCreated'],'datetime').'<br>'.formatDate($output[$i]['timeSaved'],'datetime').'</td>';
			?>
			<td class="row1" style="padding:0px;margin:0px;">
				<a href="/adm/?manageBrand/brand/<? echo $output[$i]['brandID']; ?><? echo $INCstatus.$INCletter.$INCpage; ?>" ><img src="img/icon/edit.gif" onClick="this.src=edit_go.src;"  onMouseMove="this.src=edit_on.src;" onMouseOut="this.src=edit_out.src;" width="25" height="28" alt="Редактировать"></a>
				<a href="/adm/?manageBrands/del-brand/<? echo $output[$i]['brandID'];?><? echo $INCstatus.$INCletter.$INCpage; ?>" onClick="return confirm('Удалить <?=$output[$i]['brandName']?>?')" ><img src="img/icon/delete.gif" onClick="this.src=delete_go.src;" onMouseMove="this.src=delete_on.src;" onMouseOut="this.src=delete_out.src;" width="25" height="28" alt="Удалить"></a>
			</td>
			<?
		echo '</tr>';
	}
?>
<tr>
	<td colspan="4" align="center">
	<?
	// view pages
	if(empty($numPage)) {$numPage = 1;}
	$countPages = ceil($outputCount[0]['count(permAll)']/$countEntity);

	if ($outputCount[0]['count(permAll)'] > $countEntity)
	{
		echo '<div class="grey" style="padding-top:5px;text-align:center;">Страницы: ';
		for ($p=1; $p<$countPages + 1; $p++)
		{	
			if($p == $numPage)
			{
				echo '<a class="greensmall"><strong>&#160;'.$p.'&#160;</strong></a>';
			}
			else if($p == 1)
			{
				echo '<a href="?manageBrands'.$INCstatus.$INCletter.'" class="grey">&#160;'.$p.'&#160;</a>';
			}
			else
			{
				echo '<a href="?manageBrands'.$INCstatus.$INCletter.'/page/'.$p.'" class="grey">&#160;'.$p.'&#160;</a>';
			}
		}
		echo '</div>';
	}
	?>	
	</td>
</tr>
</table>
