<div style="float:left; padding-top:10px; padding-left:75px;">
<?
	echo '<form name="filtration" action="'.$sid.'" method="post" enctype="multipart/form-data">';
	echo 'Категории:&nbsp;&nbsp;';
	echo '<select name="filter">';
		print_r(getSelectedDropDown('ddData', $filter));
	echo '</select>';
	$ddData='';
	echo '&nbsp;&nbsp;<input type="submit" style="height:19px; width:95px; margin-bottom:1px" name="Submit" class="button" value="Фильтровать">';
	echo '</form>';
?>
</div>
<form action="<?=$sid?>" method="post" onSubmit="submitonce(this)" enctype="multipart/form-data">
<div style="float:right; padding-top:15px; padding-right:75px;"><input type="submit" name="submit" class="button" style="width:150px;" value="Сохранить" /></div>
<table width="90%" border="0" style="padding-top:5px;clear:both;" cellpadding="5" cellspacing="1">
<input type="hidden" name="viewMode" value="saveArray" />
<input type="hidden" name="tableName" value="hitsales" >
<tr>
	<th width="15%">Фото</th>
	<th width="15%">Название</th>
	<th>Краткое описание</th>
	<th width="8%">Цена</th>
	<th width="7%">Тип</th>
	<th width="8%">Статус</th>
	<th width="8%">Позиция</th>
	<th width="10%"></th>
</tr>
<?php 
$ind = 0;
for ($i=0; $i<$output['rows']; $i++)
{ 
	if($output[$i]['hitsalesPrice'] == 0 OR $output[$i]['hitsalesPrice'] == '' OR $output[$i]['hitsalesImage'] == '' OR $output[$i]['hitsalesNote'] == '') $style = 'style="background-color:#FFD5D5"'; else $style = '';
	echo '<input type="hidden" name="arrayID['.$ind.']" value="'.$output[$i]['hitsalesID'].'">';

	echo '<tr align="center">';
		echo '<td style="border:1px solid #E1E4E7">';
			if(!empty($output[$i]['hitsalesImage'])) echo '<img src="../images/resource/'.$output[$i]['hitsalesCategoryAlias'].'/'.$output[$i]['hitsalesSubCategoryID'].'/2/'.$output[$i]['hitsalesImage'].'">'; else echo '&nbsp;';
		echo '</td>';
		echo '<td class="row1" '.$style.'><span style="color:#004B97;">'; if(!empty($output[$i]['hitsalesTitle'])) echo $output[$i]['hitsalesTitle']; else echo $output[$i]['hitsalesName']; echo '</span></td>';
		echo '<td class="row1" '.$style.' align="justify">'.$output[$i]['hitsalesNote'].'</td>';
		echo '<td class="row1" '.$style.'>';
			echo '<nobr>'.$output[$i]['hitsalesPrice'].' '.$CUR_CURRENCY[$output[$i]['hitsalesBrand']].'</nobr>';
			if(!empty($KOEF_CURRENCY[$output[$i]['hitsalesBrand']]) AND $KOEF_CURRENCY[$output[$i]['hitsalesBrand']] != 'grn') echo '<br><nobr><span style="font-size:10px;">('.@round($output[$i]['hitsalesBrand']*$KOEF_CURRENCY[$output[$i]['hitsalesBrand']],2).' грн.)</span></nobr>';
		echo '</td>';
		echo '<td class="row1" '.$style.'>'.getValueRadioButton('rbHitsalesType',$output[$i]['hitsalesType']).'</td>';
		echo '<td class="row1" '.$style.'>'.getValueDropDown('ddPermAll',$output[$i]['permAll']).'</td>';
		echo '<td class="row1" '.$style.' align="center">&#160;<input type="text" name="hitsales_hitsalesPosition['.$ind.']" value="'.$output[$i]['hitsalesPosition'].'" style="width:40px">';
		echo '<td class="row1" style="padding:0px;">';
			echo '<a target="_blank" href="/adm/?manageResource/category/'.$output[$i]['hitsalesCategoryID'].'/sub/'.$output[$i]['hitsalesSubCategoryID'].'/resource/'.$output[$i]['wareID'].'/type/'.$output[$i]['hitsalesType'];
			if(!empty($getvar['page'])) echo '/hitpage/'.$getvar['page'];
			echo '" ><img src="img/icon/edit.gif" onClick="this.src=edit_go.src;"  onMouseMove="this.src=edit_on.src;" onMouseOut="this.src=edit_out.src;" width="25" height="28" alt="Редактировать"></a> &#160; ';
	
			echo '<a href="/adm/?manageNovelties/del-hitsales/'.$output[$i]['hitsalesID'].'/';
			if(!empty($getvar['page'])) echo 'page/'.$getvar['page'];
			echo '" ><img src="img/icon/delete.gif" onClick="this.src=delete_go.src;" onMouseMove="this.src=delete_on.src;" onMouseOut="this.src=delete_out.src;" width="25" height="28" alt="Удалить"></a>';
		echo '</td>';
	echo '</tr>';
	$ind++;
}
?>
</form>
</table>

<table width="90%">
  <tr>
	<td align="center"><div style="width:15px; height:15px; background-color:#FFCCCC; ">&nbsp;</div></td>
	<td align="left"> - не проставлена цена, описание или фото (данный товар не будет отображаться на сайте).</td>
  </tr>
</table>

<?
	if ($outputCount[0]['count(permAll)'] > $countEntity)
	{
		echo '<div style="width:90%; margin-top:15px; margin-bottom:1px; text-align:center;"> Страницы: ';
		if($numPage != 1)
		{
			echo '<a href="/adm/?manageNovelties/page/'.($numPage-1).'" class="page" style="font-size:14px;" title="Предыдущая"><strong>&#160;&laquo;&#160;</strong></a>';
		}
		for ($p=1; $p<$countPages + 1; $p++)
		{	
			if($p == $numPage AND $viewModePage != 'all')
			{
				echo '<span class="note">&#160;'.$p.'&#160;</span>';
			}
			elseif($p == 1)
			{
				echo '<a href="/adm/?manageNovelties" class="page">&#160;'.$p.'&#160;</a>';
			}
			else
			{
				echo '<a href="/adm/?manageNovelties/page/'.$p.'" class="page">&#160;'.$p.'&#160;</a>';
			}
		}
		if($numPage != $countPages AND $viewModePage != 'all')
		{
			echo '<a href="/adm/?manageNovelties/page/'.($numPage+1).'" class="page" style="font-size:14px;" title="Следующая"><strong>&#160;&raquo;&#160;</strong></a>';
		}
		if($viewModePage == 'all')
		{
			echo '<span class="note">&#160; все</span>';
		}
		else
		{
			echo '<a href="/adm/?manageNovelties/page/all" class="page" title="Показать все '.$categoryName.'">&#160; все</a>';
		}
		echo '</div>';
	}
?>