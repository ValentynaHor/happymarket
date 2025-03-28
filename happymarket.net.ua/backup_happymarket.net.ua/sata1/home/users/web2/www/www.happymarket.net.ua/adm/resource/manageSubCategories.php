<script language="JavaScript" type="text/javascript" src="js/icon.js"></script>
<br>
<div style="margin-bottom:10px;">
<div style="text-align:left;padding-bottom:10px"><a href="/adm/?manageDepartments/">Отделы</a>&nbsp;/&nbsp;<a href="/adm/?manageCategories/dept/<?=$getvar['dept']?>"><?=$outputDepartment['departmentName']?></a>&nbsp;/&nbsp;<?=$currentCat[0]['categoryName']?>&nbsp;/&nbsp;</div>
[ <a href="/adm/?manageSubCategory<?php echo '/category/'.$getvar['category'].'/dept/'.$getvar['dept']; if(!empty($getvar['page'])) {echo '/page/'.$getvar['page'];}?>" >Добавить подраздел</a> ]
<table width="80%" border="0"  bordercolor="#FFFFFF" cellpadding="5" cellspacing="1">
<form action="<?=$sid?>" method="post" enctype="multipart/form-data">
<input type="hidden" name="viewMode" value="saveArray" />
<input type="hidden" name="tableName" value="category" >
<tr>
	<td colspan="6" align="right">
	<?
		// view pages
		if(empty($numPage)) {$numPage = 1;}
		$countPages = ceil(@ $outputCount[0]['count(permAll)']/$countEntity);
		if($outputCount[0]['count(permAll)'] > $countEntity)
		{
			echo '<div class="grey" style="padding-bottom:5px;">Страницы: ';
			for ($p=1; $p<$countPages + 1; $p++)
			{	
				if($p == $numPage)
				{
					echo '<a class="greensmall"><strong>&#160;'.$p.'&#160;</strong></a>';
				}
				else if($p == 1)
				{
					echo '<a href="?manageSubCategories/category/'.$getvar['category'].'/dept/'.$getvar['dept'].'" class="grey">&#160;'.$p.'&#160;</a>';
				}
				else
				{
					echo '<a href="?manageSubCategories/category/'.$getvar['category'].'/dept/'.$getvar['dept'].'/page/'.$p.'" class="grey">&#160;'.$p.'&#160;</a>';
				}
			}
			echo '</div>';
		}
	?>
	</td>
</tr>
<tr>
	<th width="25px">#</th>
	<th>Название</th>
	<th width="15%">Псевдоним</th>
	<th width="15%"><nobr>Создан&nbsp;/&nbsp;Изменен</nobr></th>
	<th width="10%">Статус</th>
	<th width="10%"></th>
</tr>
<?php
	for ($j=0; $j<$outputSub['rows']; $j++)
	{
		echo '<tr>';
			echo '<input type="hidden" name="arrayID['.$j.']" value="'.$outputSub[$j]['categoryID'].'">';	
			//echo '<td class="row1" align="center"><input type="text" name="category_categoryPosition['.$j.']" value="'.$outputSub[$j]['categoryPosition'].'" style="padding:0px; width:20px"></td>';
			echo '<td class="row1" align="center"><strong>'.($j+1).'.</strong></td>';
			echo '<td class="row1" style="padding-left:20px;">&bull;&nbsp;<a class="green" href="/adm/?manageResources/category/'.$outputSub[$j]['parentCategoryID'].'/sub/'.$outputSub[$j]['categoryID'].'/dept/'.$getvar['dept'].'" >'.$outputSub[$j]['categoryName'].'</a></td>';
			echo '<td class="row1" align="center" style="font-size:11px;">'.$outputSub[$j]['categoryAlias'].'</td>'; 
			echo '<td class="row1" align="center" style="font-size:11px;">'.formatDate($outputSub[$j]['timeCreated'], 'datetime').'<br>'.formatDate($outputSub[$j]['timeSaved'], 'datetime').'</td>'; 
			echo '<td class="row1" align="center"><select name="category_permAll['.$j.']">'.getSelectedDropDown('ddPermAll', $outputSub[$j]['permAll']).'</select></td>';
			?>
			<td class="row1" style="text-align:center; padding:0px;">
				<a href="/adm/?manageSubCategory/category/<?=$outputSub[$j]['parentCategoryID']?>/sub/<?=$outputSub[$j]['categoryID']?>/dept/<?=$getvar['dept']?><? if(!empty($getvar['page'])) echo '/page/'.$getvar['page']; ?>" ><img src="img/icon/edit.gif" onClick="this.src=edit_go.src;"  onMouseMove="this.src=edit_on.src;" onMouseOut="this.src=edit_out.src;" width="25" height="28" alt="Редактировать"></a>
				<a href="/adm/?manageSubCategories/del-category/<?=$outputSub[$j]['categoryID']?>/category/<?=$outputSub[$j]['parentCategoryID']?>/dept/<?=$getvar['dept']?><? if(!empty($getvar['page'])) echo '/page/'.$getvar['page']; ?>" onClick="return confirm('Подтвердите удаление')" ><img src="img/icon/delete.gif" onClick="this.src=delete_go.src;" onMouseMove="this.src=delete_on.src;" onMouseOut="this.src=delete_out.src;" width="25" height="28" alt="Удалить"></a>
			</td>
			<?
		echo '</tr>';
	}
?>
<tr>
	<td colspan="6" align="center">
		<input type="submit" name="Submit" class="button" value="  Сохранить  ">
	</td>
</tr>
</form>
</table>