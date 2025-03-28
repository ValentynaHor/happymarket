<script language="JavaScript" type="text/javascript" src="js/icon.js"></script>
<br>
<div style="margin-bottom:10px;">
<div style="text-align:left;padding-bottom:10px">
<a href="/adm/?manageDepartments/" >Отделы</a>&nbsp;/&nbsp;<?=$outputDepartment['departmentName']?></div>
[ <a href="/adm/?manageCategory/dept/<?=$getvar['dept']?><?php if(!empty($getvar['page'])) {echo '/page/'.$getvar['page'];}?>" >Добавить раздел</a> ]
</div>
<table width="80%" border="0"  bordercolor="#FFFFFF" cellpadding="5" cellspacing="1">
<form action="<?=$sid?>" method="post" enctype="multipart/form-data">
<input type="hidden" name="viewMode" value="saveArray" />
<input type="hidden" name="tableName" value="category" >
<tr>
	<td colspan="7" align="right">
	<?
		// view pages
		// if(empty($numPage)) {$numPage = 1;}
		// $countPages = ceil(@ $outputCount[0]['count(permAll)']/$countEntity);
		// if($outputCount[0]['count(permAll)'] > $countEntity)
		// {
			// echo '<div class="grey" style="padding-bottom:5px;">Страницы: ';
			// for ($p=1; $p<$countPages + 1; $p++)
			// {	
				// if($p == $numPage)
				// {
					// echo '<a class="greensmall"><strong>&#160;'.$p.'&#160;</strong></a>';
				// }
				// else if($p == 1)
				// {
					// echo '<a href="?manageCategories" class="grey">&#160;'.$p.'&#160;</a>';
				// }
				// else
				// {
					// echo '<a href="?manageCategories/page/'.$p.'" class="grey">&#160;'.$p.'&#160;</a>';
				// }
			// }
			// echo '</div>';
		// }
	?>
	</td>
</tr>
<tr>
	<th width="35px">#</th>
	<th>Название</th>
	<th width="15%">Псевдоним</th>
	<th width="15%" style="font-size:11px;"><nobr>Создан&nbsp;/&nbsp;Изменен</nobr></th>
	<th width="10%">Статус</th>
	<th width="70px"></th>
</tr>
<?php 
	for ($i=0; $i<$outputCat['rows']; $i++)
	{
		echo '<tr>';
			echo '<input type="hidden" name="arrayID[]" value="'.$outputCat[$i]['categoryID'].'">';	
			echo '<td class="row1" align="left"><input type="text" name="category_categoryPosition[]" value="'.$outputCat[$i]['categoryPosition'].'" style="padding:0px; width:20px"></td>';
			echo '<td class="row1">';
				echo '<a class="green" href="/adm/?manageSubCategories/category/'.$outputCat[$i]['categoryID'].'/dept/'.$getvar['dept'].'" ><b>'.$outputCat[$i]['categoryName'].'</b></a>';
			echo '</td>';
			echo '<td class="row1" align="center" style="font-size:11px;">'.$outputCat[$i]['categoryAlias'].'</td>'; 
			echo '<td class="row1" align="center" style="font-size:10px;">'.formatDate($outputCat[$i]['timeCreated'], 'datetime').'<br>'.formatDate($outputCat[$i]['timeSaved'], 'datetime').'</td>';
			echo '<td class="row1" align="center"><select name="category_permAll[]">'.getSelectedDropDown('ddPermAll', $outputCat[$i]['permAll']).'</select></td>';
			?>
			<td class="row1" style="text-align:center; padding:0px;">
				<a href="/adm/?manageCategory/category/<?=$outputCat[$i]['categoryID']?>/dept/<?=$getvar['dept']?><? if(!empty($getvar['page'])) echo '/page/'.$getvar['page']; ?>" ><img src="img/icon/edit.gif" onClick="this.src=edit_go.src;"  onMouseMove="this.src=edit_on.src;" onMouseOut="this.src=edit_out.src;" width="25" height="28" alt="Редактировать"></a>
				<a href="/adm/?manageCategories/del-category/<?=$outputCat[$i]['categoryID']?>/dept/<?=$getvar['dept']?><? if(!empty($getvar['page'])) echo '/page/'.$getvar['page']; ?>" onClick="return confirm('Подтвердите удаление')" ><img src="img/icon/delete.gif" onClick="this.src=delete_go.src;" onMouseMove="this.src=delete_on.src;" onMouseOut="this.src=delete_out.src;" width="25" height="28" alt="Удалить"></a>
			</td>
			<?
		echo '</tr>';
		$jcount = 1;
		for($j=0; $j<$outputSubCat['rows']; $j++){
			if($outputSubCat[$j]['parentCategoryID'] == $outputCat[$i]['categoryID']){
				echo '<tr>';
					echo '<input type="hidden" name="arrayID[]" value="'.$outputSubCat[$j]['categoryID'].'">';	
					echo '<td class="row1" align="center"><nobr><b>'.$outputCat[$i]['categoryPosition'].'. </b><input type="text" name="category_categoryPosition[]" value="'.$outputSubCat[$j]['categoryPosition'].'" style="padding:0px; width:20px"></nobr></td>';
					echo '<td class="row1" style="padding-left:18px">';
						echo '<a class="green" href="/adm/?manageResources/category/'.$outputSubCat[$j]['parentCategoryID'].'/sub/'.$outputSubCat[$j]['categoryID'].'/dept/'.$getvar['dept'].'" >'.$outputSubCat[$j]['categoryName'].'</a>';
					echo '</td>';
					echo '<td class="row1" align="center" style="font-size:11px;">'.$outputSubCat[$j]['categoryAlias'].'</td>'; 
					echo '<td class="row1" align="center" style="font-size:10px;">'.formatDate($outputSubCat[$j]['timeCreated'], 'datetime').'<br>'.formatDate($outputSubCat[$j]['timeSaved'], 'datetime').'</td>';
					echo '<td class="row1" align="center"><select name="category_permAll[]">'.getSelectedDropDown('ddPermAll', $outputSubCat[$j]['permAll']).'</select></td>';
					?>
					<td class="row1" style="text-align:center; padding:0px;">
						<a href="/adm/?manageSubCategory/category/<?=$outputSubCat[$j]['parentCategoryID']?>/sub/<?=$outputSubCat[$j]['categoryID']?>/dept/<?=$getvar['dept']?><? if(!empty($getvar['page'])) echo '/page/'.$getvar['page']; ?>" ><img src="img/icon/edit.gif" onClick="this.src=edit_go.src;"  onMouseMove="this.src=edit_on.src;" onMouseOut="this.src=edit_out.src;" width="25" height="28" alt="Редактировать"></a>
						<a href="/adm/?manageCategories/del-category/<?=$outputSubCat[$j]['categoryID']?>/dept/<?=$getvar['dept']?><? if(!empty($getvar['page'])) echo '/page/'.$getvar['page']; ?>" onClick="return confirm('Подтвердите удаление')" ><img src="img/icon/delete.gif" onClick="this.src=delete_go.src;" onMouseMove="this.src=delete_on.src;" onMouseOut="this.src=delete_out.src;" width="25" height="28" alt="Удалить"></a>
					</td>
					<?
				echo '</tr>';
			}
		}
		echo '<tr><td colspan="6" class="row1"  style="font-size:6px">&nbsp;</td></tr>';
	}
?>
<tr>
	<td colspan="7" align="center">
		<input type="submit" name="Submit" class="button" value="  Сохранить  ">
	</td>
</tr>
</form>
</table>
