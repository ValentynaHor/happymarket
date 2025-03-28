<SCRIPT src="js/dynamicOptionList.js"></SCRIPT>
<br />
<table border="0" width="98%" align="right">
<tr>
	<td width="200px" valign="top" align="left">
		<? $sid = str_replace('/sort/name','',$sid); ?>
		<form name="search" action="<?=$sid?>" method="post" onSubmit="submitonce(this)" enctype="multipart/form-data">
		<br>
		<div>Поиск</div>
		<script language="javascript" type="text/javascript">
		var cat = new DynamicOptionList();
		cat.addDependentFields("search_category","search_sub");
		cat.setFormName("search");
		cat.setFormIndex(1);
		<?php
			for ($cat=0; $cat<$outputCat['rows']; $cat++)
			{
				$sub_length = $outputSubCat[$outputCat[$cat]['categoryID']]['rows'];
				echo 'cat.forValue("'.$outputCat[$cat]['categoryID'].'").addOptionsTextValue(';
				for ($sub=0; $sub<$sub_length; $sub++)
					{
						echo '"'.$outputSubCat[$outputCat[$cat]['categoryID']][$sub]['categoryName'].'",';
						echo '"'.$outputSubCat[$outputCat[$cat]['categoryID']][$sub]['categoryID'].'",';
					}
				echo '"Все производители", ""';
				echo ');';
			}
			echo 'cat.forValue("'.$search_category.'").setDefaultOptions("'.$search_sub.'");';
		?>
		</script>
		<input type="hidden"  name="viewMode" value="search" >
		<input type="text" name="search_name" value="<?=$search_name?>"  style="width:180px" ><br>
		<div style="padding-top:5px;">Категория:</div>
		<SELECT name="search_category"  style="width:180px">
			<?php
			for ($i=0; $i<$outputCat['rows']; $i++)
			{
				if($search_category == $outputCat[$i]['categoryID'])  $select = ' selected="selected" '; else $select = '';
				echo '<option value="'.$outputCat[$i]['categoryID'].'" '.$select.'>'.$outputCat[$i]['categoryName'].'</option>';
			}
			?>
		</SELECT>
		<div style="padding-top:5px;">Подкатегория:</div>
		<SELECT name="search_sub" style="width:180px">
			<script>cat.printOptions("search_sub")</script>
		</SELECT> 
		<div style="padding-top:5px;">Наличие:</div>
		<SELECT name="search_presence[]" multiple="multiple" style="width:180px" size="7">
			<?	
			if(empty($search_presence)) $search_presence = '1&2';
			if(strstr('all',$search_presence)) $selected = 'selected="selected"'; else $selected = '';
			echo '<option value="all" '.$selected.'>Все</option>';
			echo getSelectedMultyDropDown('ddPresenceAdmin', $search_presence,'&');
			?>
		</SELECT>
		<div style="font-size:11px; color:#999999">Удерживая клавишу CTRL, можно<br /> выбрать несколько пизиций</div>
		<table border="0" cellpadding="0" cellspacing="2">
		<tr>
			<td valign="top">
				<span>От:<br/><input type="text" name="search_minprice" value="<?=$search_minprice?>" style="width:60px" ></span>
			</td>
			<td  valign="top">
				<span>&nbsp;до:<br/>&nbsp;<input type="text" name="search_maxprice" value="<?=$search_maxprice?>" style="width:60px" >&nbsp;$</span>
			</td>
			<td valign="bottom" align="right" width="30">
				<input type="image" src="img/icon/go.gif" name="submit" onMouseMove="this.src=go_on.src;" onMouseOut="this.src=go_out.src;" class="submit" border="0" style="border-bottom:3px solid #FFFFFF;"/>
			</td>
		</tr>
		</table>
		<div style="padding-top:5px;">Показывать:</div>
		<? if($search_imageshow == '1') $checked = 'checked'; else $checked = ''; ?>
		<div style="padding-top:2px;"><input type="hidden" name="search_imageshow" value="0"/><input type="checkbox" name="search_imageshow" value="1" <?=$checked?>/> - Фото</div>
		<? if($search_descriptionshow == '1') $checked = 'checked'; else $checked = ''; ?>
		<div style="padding-top:2px;"><input type="hidden" name="search_descriptionshow" value="0"/><input type="checkbox" name="search_descriptionshow" value="1" <?=$checked?>/> - Описание</div>
		<?
		if($outputCatBrand['rows'] > 0)
		{
			echo '<div style="padding-top:5px;">Бренд:</div><SELECT name="search_brand"  style="width:180px">';
				echo getSelectedDropDown('ddBrand', $search_brand);
				if(empty($search_brand) OR $search_brand == 'all') $selected = 'selected="selected"'; else $selected = '';
				echo '<option value="all" '.$selected.'>Все</option>';
			echo '</SELECT>';
		}
		?>
		</form>
		<br />
		<form name="form" action="<?=$sid?>" method="post" onSubmit="submitonce(this)" enctype="multipart/form-data">
	</td>
<?
	if(!empty($output['rows']))
	{
?>
		<form action="<?=$sid?>" method="post" onSubmit="submitonce(this)" enctype="multipart/form-data">
		<input type="hidden" name="viewMode" value="saveArray" />
		<input type="hidden" name="viewMode2" value="search" >
		<input type="hidden" name="tableName" value="resource" >
		<input type="hidden" name="category" value="<?=$search_category?>" >
		<input type="hidden" name="search_sub" value="<?=$search_sub?>" >
		<input type="hidden" name="search_presence" value="<?=$search_presence?>" >
		<input type="hidden" name="search_minprice" value="<?=$search_minprice?>" >
		<input type="hidden" name="search_maxprice" value="<?=$search_maxprice?>" >
		<input type="hidden" name="search_name" value="<?=$search_name?>" >
		<input type="hidden" name="search_category" value="<?=$search_category?>">
		<input type="hidden" name="search_brand" value="<?=$search_brand?>">
		<input type="hidden" name="search_descriptionshow" value="<?=$search_descriptionshow?>">
		<input type="hidden" name="search_imageshow" value="<?=$search_imageshow?>">
		<td valign="top">
		<?php 
		$ddData = array();
		if(empty($getvar['category'])) 
		{ 
			$getvar['category'] = $search_category;
			$getvar['sub'] = $search_sub;
		}
		?>
 		<table width="100%" align="center" valign="middle"  border="0">
  		<tr>
  			<td colspan="2" align="center" >
			<?
			if (($viewMode == "search" OR $viewMode2 == "search") AND !empty($output['rows']))
			{
				echo '[ <a href="/adm/?manageResource/category/'.$getvar['category'].'/sub/'.$getvar['sub'].'" >Добавить товар</a> ]</div>';
			}
			?>
			</td>
		</tr>
		<tr>
  			<td width="50%">
			<?	echo '<div align="left" valign="middle">&#160;Найдено: &#160;'.$output['rows'].'';?>
 		    </td>
  			<td align="right"><input type="submit" name="submit" class="button" style="width:150px;" value="Сохранить" /></td>
 		</tr>
		</table>

	<?php 
		echo '<table width="100%" border="0"  bordercolor="#FFFFFF" cellpadding="3" cellspacing="1" style="margin:2px 0px 4px 0px;">';
		echo '<tr><th>Название</th><th>Бренд</th>';
		//if($search_nameshow) echo '<th>Название</th>';
		if($search_imageshow == '1') echo '<th>Фото</th>';
		if($search_descriptionshow == '1') echo '<th>Описание</th>';
		for ($i=0; $i<$outputList['rows']; $i++)
		{
			echo '<th>'.$outputList[$i]['fieldTitle'].'</th>';
		}
		echo '<th width="50px">Позиция</th><th width="35px">Ред.</th>';
		echo '</tr>';
		for ($i=0; $i<$output['rows']; $i++)
		{
			echo '<input type="hidden" name="arrayID['.$i.']" value="'.$output[$i]['resourceID'].'">';

			echo '<tr>';
			//echo '<td align="left"  class="row1">&#160; '.$output[$i]['resourceName'].'</td>';
			echo '<td class="row1" align="center">';
				echo '<input type="text" style="width:180px" name="resource_resourceName['.$i.']" value="'.$output[$i]['resourceName'].'">';
			echo '</td>';
			echo '<td class="row1" align="center">';
				echo '<select name="resource_resourceBrand['.$i.']" style="width:147px">';
				if(empty($output[$i]['resourceBrand'])) $selected = 'selected="selected"'; else $selected = '';
				echo '<option '.$selected.' value="">не задано</option>';
				echo getSelectedDropDown('ddBrand', $output[$i]['resourceBrand']);
				echo '</select>';
			echo '</td>';
			if($search_imageshow == '1')
			{
				echo '<td style="border:1px solid #E1E4E7; text-align:center">';
					if(!empty($output[$i]['resourceImage'])) echo '<img src="../images/resource/'.$CAT_ARRAY[$output[$i]['categoryID']]['categoryAlias'].'/'.$output[$i]['subCategoryID'].'/2/'.$output[$i]['resourceImage'].'"><br>';
					echo '<input type="hidden" name="resource_resourceImage['.$i.']" value="'.$output[$i]['resourceImage'].'">';
					echo '<input type="hidden" name="MAX_FILE_SIZE" value="10000000"><input type="file" name="resource_resourceImage['.$i.']" size="5" style="width:150px"/>';
				echo '</td>';
			}
			if($search_descriptionshow == '1')
			{
				echo '<td class="row1" align="center">';
					echo '<textarea style="width:180px; height:63px" name="resource_resourceDescription['.$i.']" >'.$output[$i]['resourceDescription'].'</textarea>';
				echo '</td>';
			}
			//echo '<td class="row1" align="center">&#160;<input type="text" name="resource_guarantee['.$i.']" value="'.$output[$i]['guarantee'].'" style="width:30px"> мес.</td>';
			for ($c=0; $c<$outputList['rows']; $c++)
			{
				$ddData = '';
				if($outputList[$c]['fieldType'] ==  'list' OR $outputList[$c]['fieldType'] ==  'checkbox')
				{
					if(!empty($outputList[$c]['fieldData']))
					{
						$data = unserialize($outputList[$c]['fieldData']);
						if(!empty($data))
						{
							foreach($data as $key=>$val) {$ddData[$key] = $val;}
						}
					}
				}
				echo '<td class="row1" align="center">';
				if($outputList[$c]['fieldType'] ==  'list')
				{
					echo '<select name="resource_'.$outputList[$c]['fieldName'].'['.$i.']" style="width:147px">'.getSelectedDropDown('ddData', $output[$i][$outputList[$c]['fieldName']]).'</select>';
				}
				else if($outputList[$c]['fieldType'] ==  'checkbox')
				{
					echo '<select name="resource_'.$outputList[$c]['fieldName'].'['.$i.']" style="width:147px">';
						//getSelectedDropDown('ddData', $output[$i][$outputList[$c]['fieldName']]);
						if(empty($output[$i][$outputList[$c]['fieldName']])) $selected = 'selected="selected"'; else $selected = '';
						echo '<option '.$selected.' value="">не задано</option>';
						foreach($ddData as $key => $val)
						{
							if(strstr($output[$i][$outputList[$c]['fieldName']], '&'.$key.'&')) $selected = 'selected="selected"'; else $selected = '';
							echo '<option '.$selected.' value="&'.$key.'&">'.$val.'</option>';
						}
					echo '</select>';
				}
				else if($outputList[$c]['fieldType'] ==  'text')
				{
					echo '<textarea style="width:180px; height:63px" name="resource_'.$outputList[$c]['fieldName'].'['.$i.']" >'.$output[$i][$outputList[$c]['fieldName']].'</textarea>';
				}
				else
				{
					echo '<input type="text" style="width:180px" name="resource_'.$outputList[$c]['fieldName'].'['.$i.']" value="'.$output[$i][$outputList[$c]['fieldName']].'">';
				}
				echo '</td>';
			}
			echo '<td class="row1" align="center"><input type="text" name="resource_resourcePosition['.$i.']" value="'.$output[$i]['resourcePosition'].'" style="width:40px">';
			echo '<td class="row1" align="center">';
			?>
			<a target="_blank" href="/adm/?manageResource/resource/<?=$output[$i]['resourceID']?>/category/<?=$getvar['category']?>/sub/<?=$getvar['sub']?>" ><img src="img/icon/edit.gif" onClick="this.src=edit_go.src;"  onMouseMove="this.src=edit_on.src;" onMouseOut="this.src=edit_out.src;" width="25" height="28" alt="Редактировать"></a>
			<?
			echo '</td>';
			echo '</tr>';
		}
		echo '<tr><td colspan="'.(4+$outputList['rows']).'" align="right"><input type="submit" name="submit" class="button" style="width:150px;" value="Сохранить" /></td></tr>';
		echo '</table>';
?>
	</td>
	</form>
<?
	}
	else
	{
		echo '<td class="rowgrey" valign="top"><br/><br/>&#160;Товар не выбран. Для этого используйте поиск</td>';
	}
?>
	</tr>
</table>