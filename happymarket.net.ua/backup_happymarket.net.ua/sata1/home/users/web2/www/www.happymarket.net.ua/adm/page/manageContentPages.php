<table width="70%" border="0" cellpadding="3" cellspacing="1">
<tr>
	<th width="5%"></th>
	<th>Название</th>
	<th width="10%">URL</th>
	<th width="15%" style="font-size:11px;">Дата созд./сохр.</th>
	<th width="10%">Позиция</th>
	<th width="10%">Статус</th>
	<th width="30px"></th>
</tr>
<form action="<?=$sid?>" method="post" encarticletheme="multipart/form-data">
<input type="hidden" name="viewMode" value="saveArray" />
<input type="hidden" name="tableName" value="page" >
<?php 
	for ($i=0; $i<$output['rows']; $i++)
	{
		echo '<input type="hidden" name="arrayID['.$i.']" value="'.$output[$i]['pageID'].'">';	
		echo '<tr align="center"><td class="row1"><img src="img/bullet.gif"></td>';
		echo '<td class="row1" align="left" style="padding-left:10px;"><a class="green" >'.$output[$i]['pageName'].'</a></td>';
		echo '<td class="row1">'.$output[$i]['pageURL'].'</td>';
		echo '<td class="row1" style="font-size:11px;">'.formatDate($output[$i]['timeCreated'], 'datetime').'<br>'.formatDate($output[$i]['timeSaved'], 'datetime').'</td>';
		echo '<td class="row1" align="center"><input type="text" name="page_pagePosition[]" value="'.$output[$i]['pagePosition'].'" style="padding:0px; width:50px"></td>';
		echo '<td class="row1" align="center"><select name="page_permAll['.$i.']">'.getSelectedDropDown('ddPermAll', $output[$i]['permAll']).'</select></td>';
		?>
			<td class="row1" style="padding:0;margin:0px;">
			<a href="/adm/?manageContentPage/page/<?=$output[$i]['pageID']?>" ><img src="img/icon/edit.gif" onClick="this.src=edit_go.src;"  onMouseMove="this.src=edit_on.src;" onMouseOut="this.src=edit_out.src;" width="25" height="28" alt="Редактировать"></a>
			</td>
		<?
		echo '</tr>';
	}
?>
<tr>
	<td colspan="10" align="center">
		<input type="submit" name="Submit" class="button" value="  Сохранить  ">
	</td>
</tr>
</form>

</table>
