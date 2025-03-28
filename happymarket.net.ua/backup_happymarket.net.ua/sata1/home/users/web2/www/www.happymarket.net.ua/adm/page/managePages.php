<p>
	[ <a href="/adm/?managePage" >Добавить страницу</a> ]
</p>
<table width="90%" border="0" cellpadding="3" cellspacing="1">
<tr>
	<th width="5%"></th>
	<th>Название</th>
	<th width="10%">URL</th>
	<th width="10%">Модуль</th>
	<th width="5%">Позиция</th>
	<th width="5%">Статус</th>
	<th>Карта сайта</th>
	<th width="15%">Дата создания</th>
	<th width="15%">Дата сохранения</th>
	<th width="5%"></th>
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
		echo '<td class="row1">'.$output[$i]['pageModule'].'</td>';
		echo '<td class="row1">'.$output[$i]['pagePosition'].'</td>';
		echo '<td class="row1">'.getValueDropDown('ddPermAll',$output[$i]['permAll']).'</td>';
		
		echo '<td class="row1">';
			if($output[$i]['pageMap'] == 1) $check = 'checked'; else $check = '';
			echo '<input type="hidden" name="page_pageMap['.$i.']" value="0">';
			echo '<input type="checkbox" name="page_pageMap['.$i.']" value="1" '.$check.'>';
		echo '</td>';
		
		echo '<td class="row1">'.$output[$i]['timeCreated'].'</td>';
		echo '<td class="row1">'.$output[$i]['timeSaved'].'</td>';
		?>
			<td class="row1" style="padding:0;margin:0px;">
			<a href="/adm/?managePage/page/<?=$output[$i]['pageID']?>" ><img src="img/icon/edit.gif" onClick="this.src=edit_go.src;"  onMouseMove="this.src=edit_on.src;" onMouseOut="this.src=edit_out.src;" width="25" height="28" alt="Редактировать"></a>
			<a href="/adm/?managePages/del-page/<?=$output[$i]['pageID']?>" onClick="return confirm('Удалить страницу &quot;<?=lang($output[$i]['pageName'])?>&quot; ?')" ><img src="img/icon/delete.gif" onClick="this.src=delete_go.src;" onMouseMove="this.src=delete_on.src;" onMouseOut="this.src=delete_out.src;" width="25" height="28" alt="Удалить"></a>
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
