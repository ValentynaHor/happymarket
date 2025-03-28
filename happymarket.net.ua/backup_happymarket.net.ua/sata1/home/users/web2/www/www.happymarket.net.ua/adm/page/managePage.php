<br>
<table width="80%" border="0" cellpadding="3" cellspacing="1">
  <tr>
	<td  align="left">
	<p align="left">
	[ <a href="/adm/?managePages" >Назад</a> ]
	</p>
	<form name="edit" action="<?=$sid?>" method="post" enctype="multipart/form-data">
	<input type="hidden" name="viewMode" value="save" />
	<input type="hidden" name="tableName" value="page" />
	<input type="hidden" name="entityID" value="<?=$output[0]['pageID']?>" />
	<input type="hidden" name="page_userID" value="<?=$userArray['userID']?>" />
	<table border="0" cellpadding="3" cellspacing="1">
	  <tr>
		<td class="row2" width="100px">Название:</td>
		<td><input type="text" name="page_pageName" style="width:400px" value="<? echo $output[0]['pageName']; ?>" /></td>
	  </tr>
	  <tr>
		<td colspan="2"><hr width="100%" style="border:0px solid #FF7700; background-color:#D2D7DC; height:1px;"></td>
	  </tr>
	  <tr>
		<td class="row2">Title:</td>
		<td><input type="text" name="page_pageTitle" style="width:400px" value="<? echo $output[0]['pageTitle']; ?>" /></td>
	  </tr>
	   <tr>
		<td class="row2">Description:</td>
		<td><textarea name="page_pageDescription" style="width:600px" rows="2" ><? echo $output[0]['pageDescription']; ?></textarea></td>
	  </tr> 
	  <tr>
		<td class="row2">Keywords:</td>
		<td><textarea name="page_pageKeywords" style="width:600px" rows="2" ><? echo $output[0]['pageKeywords']; ?></textarea></td>
	  </tr>
	  <tr>
		<td class="row2">Текст:</td>
			<td width="280px" class="lang"><textarea name="page_pageText" style="width:600px" rows="20" onkeypress="treatment_keys()"><?=$output[0]['pageText']?></textarea>&nbsp;&nbsp; </td>
	  </tr>
	  <tr> 
     	<td>Фото:</td>
    	<td>
        <? if(!empty($output[0]['pageImage'])) echo '<img src="../images/page/'.$output[0]['pageImage'].'"><br />';?>
		<input type="hidden" name="MAX_FILE_SIZE" value="10000000"><input type="file" name="page_pageImage" style="width:250px"/>
        </td>
	  </tr>
	  <tr>
		<td colspan="2"><hr width="100%" style="border:0px solid #FF7700; background-color:#D2D7DC; height:1px;"></td>
	  </tr>
	  <tr>
		<td class="row2">Псевдоним:</td>
		<td><input type="text" name="page_pageAlias" style="width:200px" value="<? echo $output[0]['pageAlias']; ?>" /></td>
	  </tr>
	  <tr>
		<td class="row2">URL:</td>
		<td><input type="text" name="page_pageURL" style="width:200px" value="<? echo $output[0]['pageURL']; ?>" /></td>
	  </tr>
	  <tr>
		<td class="row2">Модуль:</td>
		<td>
		<select name="page_pageModule" style="width:100px;">
			<?
			for($i=0; $i < count($modarray); $i++)
			{
				if($output[0]['pageModule'] == $modarray[$i])
				{
					echo '<option value="'.$modarray[$i].'" selected="selected">'.$modarray[$i].'</option>';
				}
				else
				{
					echo '<option value="'.$modarray[$i].'">'.$modarray[$i].'</option>';
				}
			}
			?>
		</select>
		</td>
	  </tr>
	  <tr>
		<td class="row2">Статус:</td>
		<td>
		<select name="page_permAll" style="width:100px;">
		<?
			if(empty($output[0]['pageID'])) $output[0]['permAll'] = '1';
			echo getSelectedDropDown('ddPermAll', $output[0]['permAll']);
		?>
		</select>
		</td>
	  </tr>
	  <tr>
	  	<td class="row2">Карта сайта</td>
	  	<td>
		<?php
			if($output[0]['pageMap'] == 1) $check = 'checked'; else $check = '';
			echo '<input type="hidden" name="page_pageMap" value="0">';
			echo '<input type="checkbox" name="page_pageMap" value="1" '.$check.'>';
		?>
		</td>
	  </tr>
	  <tr>
		<td class="row2">Позиция:</td>
		<td><input type="text" name="page_pagePosition" maxlength="4" style="width:40px" value="<? echo $output[0]['pagePosition']; ?>" /></td>
	  </tr>
	  <tr>
		<td width="60" class="row2"><br />
		<input type="submit" name="save" value="Сохранить" /></td>
		<td></td>
	  </tr>
	</table>
	</form>
	</td>
  </tr>
</table>
