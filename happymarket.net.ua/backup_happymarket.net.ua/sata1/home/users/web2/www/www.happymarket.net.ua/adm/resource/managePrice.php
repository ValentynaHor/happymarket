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
	
		function profit(id, name)
		{
			var date = new Date();
			var year_full = new String(date.getFullYear());
			var year = year_full.slice(2,4);
			var hours = date.getHours();
			var minutes = date.getMinutes();
			var seconds = date.getSeconds();
			var month = date.getMonth()+1;
			hours = (hours <= 9) ? "0" + hours : hours;
			minutes = (minutes <= 9) ? "0" + minutes : minutes;
			seconds = (seconds <= 9) ? "0" + seconds : seconds;
			month = (month <= 9) ? "0" + month : month;
			dispTime = date.getDate() + "." + month + "." + year + " " + hours + ":" + minutes + ":" + seconds;
			
				if(name == 'price')
				{
					document.getElementById("usdProfit"+id).value = document.getElementById("price"+id).value - document.getElementById("enterprice"+id).value;
					document.getElementById("percentProfit"+id).value = Math.round(((document.getElementById("usdProfit"+id).value / document.getElementById("enterprice"+id).value) * 100)*10)/10;
				} else
				if(name == 'usdProfit')
				{
					document.getElementById("price"+id).value = parseFloat(document.getElementById("usdProfit"+id).value) + parseFloat(document.getElementById("enterprice"+id).value);
					document.getElementById("percentProfit"+id).value = Math.round(((document.getElementById("usdProfit"+id).value / document.getElementById("enterprice"+id).value) * 100)*10)/10;
				} else
				if(name == 'percentProfit')
				{	
					document.getElementById("price"+id).value = Math.round((document.getElementById("percentProfit"+id).value * document.getElementById("enterprice"+id).value) / 100) + parseFloat(document.getElementById("enterprice"+id).value);
					document.getElementById("usdProfit"+id).value = document.getElementById("price"+id).value - document.getElementById("enterprice"+id).value;
				}
				document.getElementById("datePrice"+id).value = dispTime;
				<?  
				if($userArray['userID'] == '555') echo 'document.getElementById("managerPrice"+id).value = "Admin";';
				else echo 'document.getElementById("managerPrice"+id).value = "'.getValueDropDown('ddManager',$userArray['userID']).'";';
				?>
			}
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
			<?
			/*
			if(!empty($outputList_2[0]['fieldData']))
			{
				$supplierArray = unserialize($outputList_2[0]['fieldData']);
				if(!empty($supplierArray))
				{
					foreach($supplierArray as $key=>$val) {$ddSupplier[$key] = $val;}
					echo '<div class="title">Поставщик:</div><SELECT name="search_supplier"  style="width:180px">';
						echo getSelectedDropDown('ddSupplier', $search_supplier);
						if($search_supplier == 'all') $selected = 'selected="selected"'; else $selected = '';
						echo '<option value="all" '.$selected.'>Все</option>';
					echo '</SELECT>';
				}
			}
			*/
			?>
	
		</form>
		<br />
		<form name="form" action="<?=$sid?>" method="post" onSubmit="submitonce(this)" enctype="multipart/form-data">
		<input type="image" src="img/money.jpg" name="submit" class="submit" border="0" style="width:200px" />
	</td>
<?
	if(!empty($output['rows']))
	{
?>
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
		<input type="hidden" name="search_supplier" value="<?=$search_supplier?>">
		<td valign="top">
		<?php 
		$ddData = array();
		if (empty($getvar['category'])) 
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
			<div align="left" valign="middle">&#160;Найдено: &#160;<?=$output['rows']?></div>
			</td>
  			<td align="right"><input type="submit" name="submit" class="button" style="width:150px;" value="Сохранить" /></td>
 		</tr>
		</table>
		<?
			echo '<table width="100%" border="0"  bordercolor="#FFFFFF" cellpadding="2" cellspacing="1">';
			echo '<tr><th><a href="?managePrice/sort/name">Название</a></th><th width="120px">Статус</th><th width="120px">Вх. цена</th><th width="120px">Цена</th><th width="100px">Дата редак.</th><th width="120px">Прибыль</th><th width="110px">Прибыль (%)</th><th>&nbsp;</th></tr>';
			for ($i=0; $i<$output['rows']; $i++)
			{
				$output[$i]['datePrice'] = @explode('|', $output[$i]['datePrice']);
				echo '<input type="hidden" name="datePresence['.$i.']" value="'.$output[$i]['datePrice'][1].'">';
				$output[$i]['datePrice'] = $output[$i]['datePrice'][0];
				
				$managerPrice = ''; $expManagerPrice = '';
				if($output[$i]['disabled'] == 1) {$checked = 'checked';} else {$checked = '';}
				echo '<tr>';
					echo '<td align="left"  class="row1">&#160; '.$output[$i]['resourceName'].'</td>';
					echo '<td class="row1" align="center">';
						echo '<select style="width:100px" name="resource_presence['.$i.']" onChange="profit(\''.$i.'\', \'price\');">'.getSelectedDropDown('ddPresenceAdmin', $output[$i]['presence']).'</select>';
					echo '</td>';
					echo '<td class="row1" align="left"><nobr><input type="text" id="enterprice'.$i.'" name="resource_enterPrice['.$i.']" onBlur="profit(\''.$i.'\', \'price\');" value="'.$output[$i]['enterPrice'].'" style="width:60px;  margin-left:5px;" onClick="profit('.$i.')">&#160;'.$CUR_CURRENCY[$output[$i]['resourceBrand']].'&nbsp;'.getValueDropDown('ddCurrency2', $output[$i]['resourceCurrency']).'</nobr></td>';
					echo '<td class="row1" align="left"><nobr><input type="text" id="price'.$i.'" name="resource_resourcePrice['.$i.']" onBlur="profit(\''.$i.'\', \'price\');" value="'.$output[$i]['resourcePrice'].'" style="width:60px;  margin-left:5px;">&nbsp;'.getValueDropDown('ddCurrency2', $output[$i]['resourceCurrency']).'</nobr></td>';
					echo '<td class="row1" align="left">';
						echo '<input type="text" id="datePrice'.$i.'" name="resource_datePrice['.$i.']" value="'.$output[$i]['datePrice'].'" style="width:92px; font-size:10px; background-color:#E1E4E7; border: 1px #E1E4E7 solid;"><br>';
						if(!empty($output[$i]['datePrice']))
						{
							$expManagerPrice = explode('||',$output[$i]['userID']);
							if($expManagerPrice[1] != '555') $managerPrice = getValueDropDown('ddManager', $expManagerPrice[1]);
							else $managerPrice = 'Admin';
						}
						echo '<input type="text" id="managerPrice'.$i.'" name="managerPrice['.$i.']" value="'.$managerPrice.'" style="width:78px; font-size:10px; background-color:#E1E4E7; border: 1px #E1E4E7 solid;">';
					echo '</td>';
					echo '<td class="row1" align="left"><nobr><input type="text" id="usdProfit'.$i.'" name="usdProfit['.$i.']" value="'.($output[$i]['resourcePrice'] - $output[$i]['enterPrice']).'" onBlur="profit(\''.$i.'\', \'usdProfit\');" style="width:60px; margin-left:5px; background-color:#F7F8F8; background-color:#F7F8F8; border: 1px #7C8DA3 solid;">&nbsp;'.getValueDropDown('ddCurrency2', $output[$i]['resourceCurrency']).'</nobr></td>';
					echo '<td class="row1" align="center"><nobr><input type="text" id="percentProfit'.$i.'" name="percentProfit['.$i.']" value="'.@round((($output[$i]['resourcePrice'] - $output[$i]['enterPrice']) / $output[$i]['enterPrice']) * 100,1).'" onBlur="profit(\''.$i.'\', \'percentProfit\');" style="width:45px; background-color:#F7F8F8; border: 1px #7C8DA3 solid;">&nbsp;%</nobr></td>';
					echo '<td class="row1" align="center">';
					?>
						<a target="_blank" href="/adm/?manageResource/dept/<?=$CAT_ARRAY[$search_category]['categoryDepartment']?>/resource/<?=$output[$i]['resourceID']?>/category/<?=$getvar['category']?>/sub/<?=$getvar['sub']?>" ><img src="img/icon/edit.gif" onClick="this.src=edit_go.src;"  onMouseMove="this.src=edit_on.src;" onMouseOut="this.src=edit_out.src;" width="25" height="28" alt="Редактировать"></a>
					<?
					echo '</td>';
				echo '</tr>';
				echo '<input type="hidden" name="dateCompare['.$i.']" value="'.$output[$i]['datePrice'].'">';
				echo '<input type="hidden" name="arrayID['.$i.']" value="'.$output[$i]['resourceID'].'">';
			}
			echo '<tr><td colspan="'.(10).'" align="right"><input type="submit" name="submit" class="button" style="width:150px;" value="Сохранить" /></td></tr>';	
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