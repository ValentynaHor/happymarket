<script language="JavaScript" type="text/javascript" src="js/icon.js"></script>
<br>
<div style="margin-bottom:10px;">

	<?
	echo '<div style="text-align:left;padding-bottom:10px">';
		echo '<a href="/adm/?manageDepartments/">Отделы</a>&nbsp;/&nbsp;';
		echo '<a href="/adm/?manageCategories/dept/'.$getvar['dept'].'">'.$outputDepartment['departmentName'].'</a>&nbsp;/&nbsp;';
		echo '<a href="/adm/?manageSubCategories/category/'.$getvar['category'].'/dept/'.$getvar['dept'].'" >'.$currentCat[0]['categoryName'].'</a>&nbsp;/&nbsp;';
		echo $currentSub[0]['categoryName'].'&nbsp;/&nbsp;';
	echo '</div>';

	if(!empty($getvar['category'])) $hrefCategory = '/category/'.$getvar['category']; else $hrefCategory = '';
	if(!empty($getvar['sub'])) $hrefSub = '/sub/'.$getvar['sub']; else $hrefSub = '';
	if(!empty($getvar['brand'])) $hrefBrand = '/brand/'.$getvar['brand']; else $hrefBrand = '';
	if(!empty($getvar['dept'])) $hrefDept = '/dept/'.$getvar['dept']; else $hrefDept = '';
	if(!empty($getvar['page'])) $hrefPage = '/page/'.$getvar['page']; else $hrefPage = '';
	?>
	[ <a href="/adm/?manageResource<?=$hrefCategory.$hrefSub.$hrefBrand.$hrefDept?>" >Добавить товар</a> ]
	<div style="width:95%;text-align:center;padding-top:10px">
	<?
	if(empty($getvar['brand'])) echo 'Все';
	else  echo '<a href="/adm/?manageResources'.$hrefCategory.$hrefSub.$hrefDept.'" >Все</a>';
	for($b=0; $b < $outputBrand['rows']; $b++)
	{
		if($getvar['brand'] == $outputBrand[$b]['brandID']) echo ' | '.$outputBrand[$b]['brandName'];
		else echo ' | <a href="/adm/?manageResources'.$hrefCategory.$hrefSub.$hrefDept.'/brand/'.$outputBrand[$b]['brandID'].'" >'.$outputBrand[$b]['brandName'].'</a>';
	}
	?>
	</div>
</div>
<?
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

		echo '<div class="grey" style="padding-bottom:5px; padding-right:25px; float:right;">Страницы: ';
		if($numPage != 1)
		{
			echo '<a href="?manageResources'.$hrefCategory.$hrefSub.$hrefBrand.$hrefDept.'/page/'.($numPage-1).'" class="grey" style="font-size:14px;" title="Предыдущая"><strong>&#160;&laquo;&#160;</strong></a>';
		}
		if($numPage > $maxPage AND $viewModePage != 'all')
		{
			echo '<span class="grey"><a href="?manageResources'.$hrefCategory.$hrefSub.$hrefBrand.$hrefDept.'/page/'.($startPage-1).'" class="grey">&nbsp; ['.($startPage-$maxPage).' - '.($startPage-1).'] &nbsp;</a></span>';
		}
		for ($p = $startPage; $p < $endPage + 1; $p++)
		{
			if($p == $numPage)
			{
				echo '<a class="greensmall"><strong>&#160;'.$p.'&#160;</strong></a>';
			}
			else if($p == 1 AND $viewModePage != 'all')
			{
				echo '<a href="?manageResources'.$hrefCategory.$hrefSub.$hrefBrand.$hrefDept.'" class="grey">&#160;'.$p.'&#160;</a>';
			}
			else
			{
				echo '<a href="?manageResources'.$hrefCategory.$hrefSub.$hrefBrand.$hrefDept.'/page/'.$p.'" class="grey">&#160;'.$p.'&#160;</a>';
			}
		}
		if($countPages > $maxPage*($levelPage+1) AND $viewModePage != 'all')
		{
			echo '<span class="grey"><a href="?manageResources'.$hrefCategory.$hrefSub.$hrefBrand.$hrefDept.'/page/'.($endPage+1).'" class="grey">&nbsp; ['.($endPage+1).' - '; if($countPages < $endPage+$maxPage){echo($countPages);}else{echo($endPage+$maxPage);} echo '] &nbsp;</a></span>';
		}
		if($numPage != $countPages AND $viewModePage != 'all')
		{
			echo '<a href="?manageResources'.$hrefCategory.$hrefSub.$hrefBrand.$hrefDept.'/page/'.($numPage+1).'" class="grey" style="font-size:14px;" title="Следующая"><strong>&#160;&raquo;&#160;</strong></a>';
		}
		if($viewModePage == 'all')
		{
			echo '<a class="greensmall"><strong>&#160;все&#160;</strong></a>';
		}
		else
		{
			echo '<a href="?manageResources'.$hrefCategory.$hrefSub.$hrefBrand.$hrefDept.'/page/all" class="grey" title="Показать все '.$categoryName.'">&#160;все&#160;</a>';
		}
		echo '</div>';
	}
?>	
<table width="95%" border="0"  bordercolor="#FFFFFF" cellpadding="5" cellspacing="1" style="clear:both;padding-top:10px;">
<form action="<?=$sid?>" method="post" enctype="multipart/form-data">
<input type="hidden" name="viewMode" value="saveArray" />
<input type="hidden" name="tableName" value="resource" >
<tr>
	<th width="40px">#</th>
	<th width="120px">Фото</th>
	<th>Название/Описание</th>
	<th width="8%">Бренд</th>
	<th width="8%">Вх. цена</th>
	<th width="8%">Цена</th>
	<th width="10%">Создан/Изменен</th>
	<th width="100px">Статус</th>
	<th width="50px"></th>
	</tr>
	<?php 
	for ($i=0; $i<$outputResource['rows']; $i++)
	{
		echo '<input type="hidden" name="arrayID['.$i.']" value="'.$outputResource[$i]['resourceID'].'">';	
		echo '<tr align="center">';
			echo '<td class="row1"><input type="text" name="resource_resourcePosition['.$i.']" value="'.$outputResource[$i]['resourcePosition'].'" size="2"></td>';
			echo '<td style="border:1px solid #E1E4E7; text-align:center">';
				if(!empty($outputResource[$i]['resourceImage'])) echo '<img src="../images/resource/'.$currentCat[0]['categoryAlias'].'/'.$outputResource[$i]['subCategoryID'].'/2/'.$outputResource[$i]['resourceImage'].'">'; else echo '<img src="img/bullet.gif">';
			echo '</td>';
			echo '<td class="row1" align="left">';
				echo '<font style="color:#004B97;">'.$outputResource[$i]['resourceName'].'</font>';
				echo '<div style="text-align:justify;padding-top:5px;">'.$outputResource[$i]['resourceDescription'];
			echo '</td>';
			echo '<td class="row1">'.getValueDropDown('ddBrand', $outputResource[$i]['resourceBrand']).'</td>';
			echo '<td class="row1" align="center">';
				echo '<nobr>'.$outputResource[$i]['enterPrice'].'&nbsp;'.getValueDropDown('ddCurrency2', $outputResource[$i]['resourceCurrency']).'</nobr>';
			echo '</td>';
			echo '<td class="row1" align="center">';
				echo '<nobr>'.$outputResource[$i]['resourcePrice'].'&nbsp;'.getValueDropDown('ddCurrency2', $outputResource[$i]['resourceCurrency']).'</nobr>';
			echo '</td>';
			echo '<td class="row1" style="font-size:11px;">'.formatDate($outputResource[$i]['timeCreated'],'datetime').'<br>'.formatDate($outputResource[$i]['timeSaved'],'datetime').'</td>';
			echo '<td class="row1"><select name="resource_permAll['.$i.']">'.getSelectedDropDown('ddPermAll', $outputResource[$i]['permAll']).'</select></td>';
			?>
			<td class="row1" style="padding:0px;">
				<a href="/adm/?manageResource/resource/<? echo $outputResource[$i]['resourceID']; echo $hrefCategory.$hrefSub.$hrefBrand.$hrefDept.$hrefPage; ?>" ><img src="img/icon/edit.gif" onClick="this.src=edit_go.src;"  onMouseMove="this.src=edit_on.src;" onMouseOut="this.src=edit_out.src;" width="25" height="28" alt="Редактировать"></a>
				<a href="/adm/?manageResources/del-resource/<? echo $outputResource[$i]['resourceID']; echo $hrefCategory.$hrefSub.$hrefBrand.$hrefDept.$hrefPage; ?>" onClick="return confirm('Подтвердите удаление')" ><img src="img/icon/delete.gif" onClick="this.src=delete_go.src;" onMouseMove="this.src=delete_on.src;" onMouseOut="this.src=delete_out.src;" width="25" height="28" alt="Удалить"></a>
			</td>
			<?
		echo '</tr>';
	}
	?>
<tr>
<td colspan="7" align="center">
<input type="submit" name="Submit" class="button" value="  Сохранить  ">
</td>
</tr>
</form>
</table>