<script language="JavaScript" type="text/javascript" src="js/icon.js"></script>
<table width="80%" border="0"  bordercolor="#FFFFFF" cellpadding="5" cellspacing="1">
<form action="<?=$sid?>" method="post" enctype="multipart/form-data">
<input type="hidden" name="viewMode" value="saveArray" />
<input type="hidden" name="tableName" value="department" >
<tr>
	<td colspan="7" align="right">
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
					echo '<a href="?manageDepartments" class="grey">&#160;'.$p.'&#160;</a>';
				}
				else
				{
					echo '<a href="?manageDepartments/page/'.$p.'" class="grey">&#160;'.$p.'&#160;</a>';
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
	$ind = 0; $cat = 0;
	for ($i=0; $i<$outputDepartment['rows']; $i++)
	{
		if($outputDepartment[$i]['departmentID'] == '3' AND $userArray['userID'] == '444' OR $outputDepartment[$i]['departmentID'] != '3' AND $userArray['userID'] == '555')
		{
			if($outputDepartment[$i]['parentDepartmentID'] == 'top')
			{
				echo '<tr>';
					echo '<input type="hidden" name="arrayID['.$ind.']" value="'.$outputDepartment[$i]['departmentID'].'">';	
					echo '<td class="row1" align="center"><strong>'.($cat+1).'.</strong></td>';
					echo '<td class="row1">';
						echo '<a href="/adm/?manageCategories/dept/'.$outputDepartment[$i]['departmentID'].'">'.$outputDepartment[$i]['departmentName'].'</a>';
					echo '</td>';
					echo '<td class="row1" align="center" style="font-size:11px;">'.$outputDepartment[$i]['departmentAlias'].'</td>'; 
					echo '<td class="row1" align="center" style="font-size:11px;">'.formatDate($outputDepartment[$i]['timeCreated'], 'datetime').'<br>'.formatDate($outputDepartment[$i]['timeSaved'], 'datetime').'</td>';
					echo '<td class="row1" align="center"><select name="department_permAll['.$ind.']">'.getSelectedDropDown('ddPermAll', $outputDepartment[$i]['permAll']).'</select></td>';
					?>
					<td class="row1" style="text-align:center; padding:0px;">
						<a href="/adm/?manageDepartment/department/<?=$outputDepartment[$i]['departmentID']?><? if(!empty($getvar['page'])) echo '/page/'.$getvar['page']; ?>" ><img src="img/icon/edit.gif" onClick="this.src=edit_go.src;"  onMouseMove="this.src=edit_on.src;" onMouseOut="this.src=edit_out.src;" width="25" height="28" alt="Редактировать"></a>
						<? /* <a href="/adm/?manageDepartments/del-department/<?=$outputDepartment[$i]['departmentID']?><? if(!empty($getvar['page'])) echo '/page/'.$getvar['page']; ?>" onClick="return confirm('Подтвердите удаление')" ><img src="img/icon/delete.gif" onClick="this.src=delete_go.src;" onMouseMove="this.src=delete_on.src;" onMouseOut="this.src=delete_out.src;" width="25" height="28" alt="Удалить"></a> */ ?>
						<img src="img/icon/delete0.gif" width="25" height="28" alt="Удалить">
					</td>
					<?
				echo '</tr>';
				$ind++;
				$cat++;

				for ($j=0; $j<$outputDepartment['rows']; $j++)
				{
					if($outputDepartment[$j]['parentDepartmentID'] == $outputDepartment[$i]['departmentID'] )
					{
						echo '<tr>';
							echo '<input type="hidden" name="arrayID['.$ind.']" value="'.$outputDepartment[$j]['departmentID'].'">';	
							echo '<td class="row1" align="center">&nbsp;</td>';
							echo '<td class="row1">';
								echo '&nbsp;&bull;&nbsp;<a href="/adm/?manageCategories/dept/'.$outputDepartment[$j]['departmentID'].'">'.$outputDepartment[$j]['departmentName'].'</a>';
							echo '</td>';
							echo '<td class="row1" align="center" style="font-size:11px;">'.$outputDepartment[$j]['departmentAlias'].'</td>'; 
							echo '<td class="row1" align="center" style="font-size:11px;">'.formatDate($outputDepartment[$j]['timeCreated'], 'datetime').'<br>'.formatDate($outputDepartment[$j]['timeSaved'], 'datetime').'</td>';
							echo '<td class="row1" align="center"><select name="department_permAll['.$ind.']">'.getSelectedDropDown('ddPermAll', $outputDepartment[$j]['permAll']).'</select></td>';
							?>
							<td class="row1" style="text-align:center; padding:0px;">
								<a href="/adm/?manageDepartment/department/<?=$outputDepartment[$j]['departmentID']?><? if(!empty($getvar['page'])) echo '/page/'.$getvar['page']; ?>" ><img src="img/icon/edit.gif" onClick="this.src=edit_go.src;"  onMouseMove="this.src=edit_on.src;" onMouseOut="this.src=edit_out.src;" width="25" height="28" alt="Редактировать"></a>
								<? /* <a href="/adm/?manageDepartments/del-department/<?=$outputDepartment[$i]['departmentID']?><? if(!empty($getvar['page'])) echo '/page/'.$getvar['page']; ?>" onClick="return confirm('Подтвердите удаление')" ><img src="img/icon/delete.gif" onClick="this.src=delete_go.src;" onMouseMove="this.src=delete_on.src;" onMouseOut="this.src=delete_out.src;" width="25" height="28" alt="Удалить"></a> */ ?>
								<img src="img/icon/delete0.gif" width="25" height="28" alt="Удалить">
							</td>
							<?
						echo '</tr>';
						$ind++;
					}
				}
			}
		}
	}
?>
<tr>
	<td colspan="7" align="center">
		<input type="submit" name="Submit" class="button" value="  Сохранить  ">
	</td>
</tr>
</form>
</table>
