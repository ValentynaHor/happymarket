<table  border="0" cellpadding="0" cellspacing="5">
<form name="edit" action="<?=$sid?>" method="post" enctype="multipart/form-data">
<input type="hidden" name="viewMode" value="search" />
  <tr>
    <td colspan="3" valign="top">
	<div>Название:</div>
	<input type="text" name="search_name" value="<?=$search_name?>" style="width:500px" >&nbsp;
	<input type="submit" class="button" name="save" value="Найти" style="margin-bottom:1px;height:22px;"/>
	<? if($getvar['type'] != 'advanced') echo '<br><a href="/adm/?manageSearch/type/advanced/">Расширенный поиск</a>'; ?>
	</td>
  </tr>
  <? if($getvar['type'] == 'advanced') {?>
  <tr>
	<td valign="top">
		<div>Категория:</div>
		<SELECT name="search_category[]" multiple="multiple" style="width:180px" size="7">
			<?php
			if(empty($search_presence)) $search_category = 'all';
			if(strstr('all',$search_category)) $selected = 'selected="selected"'; else $selected = '';
			echo '<option value="all" '.$selected.'>Все</option>';
			for ($i=0; $i<$outputCat['rows']; $i++)
			{
				if(strstr($search_category, '&'.$outputCat[$i]['categoryID'].'&'))  $select = ' selected="selected" '; else $select = '';
				echo '<option value="'.$outputCat[$i]['categoryID'].'" '.$select.'>'.$outputCat[$i]['categoryName'].'</option>';
			}
			?>
		</SELECT>
	</td>
	<td valign="top">
		<div>Наличие:</div>
		<SELECT name="search_presence[]" multiple="multiple" style="width:180px" size="7">
		 <?	
		 	if(empty($search_presence)) $search_presence = '1&2';
			if(strstr('all',$search_presence)) $selected = 'selected="selected"'; else $selected = '';
			echo '<option value="all" '.$selected.'>Все</option>';
			echo getSelectedMultyDropDown('ddPresenceAdmin', $search_presence,'&');
		 ?>
		</SELECT>
	</td>
    <td valign="top">
		<div style="padding-bottom:5px;">Описание:<br>
			<input type="text" name="search_description" value="<?=$search_description?>" style="width:180px" >
		</div>
		<div style="padding-bottom:5px;">
			<span>Цена<br>&nbsp; &nbsp;от&nbsp;<input type="text" name="search_minprice" value="<?=$search_minprice?>" style="width:60px" ></span>
			<span>&nbsp;до&nbsp;<input type="text" name="search_maxprice" value="<?=$search_maxprice?>" style="width:60px" >&nbsp;$</span>
		</div>
		<div style="padding-bottom:5px;">Статус:<br>
			<SELECT name="search_status" style="width:180px">
				<option value="all" selected="selected">Все</option>
				<?php echo getSelectedDropDown('ddPermAll1', $search_status); ?>
			</SELECT>
		</div>
	</td>
  </tr>
  <? }?>
</form>
</table>
<?
if($output['rows'] > 0) echo '<div style="width:95%;text-align:left;font-size:14px;">Всего найдено: '.$output['rows'].'</div>';
?>
<div style="text-align:right;width:95%;padding:5px;">
	<a name="top" href="<?=$sid?>#bottom"><img src="../adm/img/icon/down.gif"></a>
</div>
<table width="95%" style="border:1px solid #FFFFFF" cellpadding="5" cellspacing="1">
<tr>
	<th width="5%">ID</th>
	<th width="10%">Фото</th>
	<th>Название/Описание</th>
	<th width="8%">Бренд</th>
	<th width="8%">Вх. цена</th>
	<th width="8%">Цена</th>
	<th width="5%">Наличие</th>
	<!--th width="10%" style="font-size:11px;">Дата создания/<br>Дата сохранения</th-->
	<th width="5%">Позиция</th>
	<th width="7%">Статус</th>
	<th width="5%"></th>
</tr>
    <?php 
	for ($cat=0; $cat<count($outputCategory); $cat++)
	{
		$category = $outputCategory[$cat]['categoryID'];
		echo '<tr>';
			echo '<th colspan="11" align="left"><b>'.$outputCategory[$cat]['categoryName'].'</b></th>';
		echo '</tr>';
		
		for ($i=0; $i<$outputResource[$category]['rows']; $i++)
		{
			echo '<tr align="center">';	
			echo '<td class="row1">'.$outputResource[$category][$i]['resourceID'].'</td>';
				if(!empty($outputResource[$category][$i]['resourceImage'])) {echo '<td style="border:1px solid #E1E4E7"><img src="../images/resource/'.$CAT_ARRAY[$category]['categoryAlias'].'/'.$outputResource[$category][$i]['subCategoryID'].'/2/'.$outputResource[$category][$i]['resourceImage'].'"></td>';}
				else {echo '<td class="row1"><img src="img/bullet.gif"></td>';}
			echo '<td class="row1">';
				echo '<div style="text-align:left;padding-bottom:5px;"><font style="color:#004B97;">'.$outputResource[$category][$i]['resourceName'].'</font></div>';
				echo '<div style="text-align:left">'.$outputResource[$category][$i]['resourceDescription'].'</div>';
			echo '</td>';
			echo '<td class="row1">'.$BRAND_ARRAY[$outputResource[$category][$i]['resourceBrand']]['brandName'].'</td>';
			echo '<td class="row1" align="center">';
				echo '<nobr>'.$outputResource[$category][$i]['enterPrice'].'&nbsp;'.getValueDropDown('ddCurrency2', $outputResource[$category][$i]['resourceCurrency']).'</nobr>';
			echo '</td>';
			echo '<td class="row1" align="center">';
				echo '<nobr>'.$outputResource[$category][$i]['resourcePrice'].'&nbsp;'.getValueDropDown('ddCurrency2', $outputResource[$category][$i]['resourceCurrency']).'</nobr>';
			echo '</td>';
			echo '<td class="row1">'.getValueDropDown('ddPresenceAdmin',$outputResource[$category][$i]['presence']).'</td>';
			//echo '<td class="row1" style="font-size:11px;">'.formatDate($outputResource[$category][$i]['timeCreated'],'datetime').'<br>'.formatDate($outputResource[$category][$i]['timeSaved'],'datetime').'</td>';
			echo '<td class="row1">'.$outputResource[$category][$i]['resourcePosition'].'</td>';
			echo '<td class="row1">'.getValueDropDown('ddPermAll',$outputResource[$category][$i]['permAll']).'</td>';
			?>
			<td class="row1" style="padding:0px;">
				<a target="_blank" href="/adm/?manageResource/category/<?=$outputResource[$category][$i]['categoryID']?>/sub/<?=$outputResource[$category][$i]['subCategoryID']?>/resource/<?=$outputResource[$category][$i]['resourceID']?>" ><img src="img/icon/edit.gif" onClick="this.src=edit_go.src;"  onMouseMove="this.src=edit_on.src;" onMouseOut="this.src=edit_out.src;" width="25" height="28" alt="Редактировать"></a>&#160; 
				<!--a target="_blank" onClick="return confirm('Удалить <?//$outputResource[$category][$i]['resourceName'];?>?');" href="/adm/?manageSearch/del-resource/<?=$outputResource[$category][$i]['resourceID']?>"><img src="img/icon/delete.gif" onClick="this.src=delete_go.src;" onMouseMove="this.src=delete_on.src;" onMouseOut="this.src=delete_out.src;" width="25" height="28" alt="Удалить"></a--> 
			</td>
			<?
			echo '</tr>';
		}
	}
	?>
</table>
<div style="text-align:right;width:95%;padding:5px;">
<a name="bottom" href="<?=$sid?>#top"><img src="../adm/img/icon/up.gif"></a>
</div>