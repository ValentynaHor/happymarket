<br><br>
<table width="80%" border="0" cellpadding="3" cellspacing="1">
<tr>
	<td  align="left">

	<p align="left">[ <a href="/adm/?manageContentPages" >Назад</a> ]</p>

	<form name="edit" action="<?=$sid?>" method="post" enctype="multipart/form-data">
	<input type="hidden" name="viewMode" value="save" />
	<input type="hidden" name="tableName" value="page" />
	<input type="hidden" name="entityID" value="<?=$output[0]['pageID']?>" />
	<input type="hidden" name="page_userID" value="<?=$userArray['userID']?>" />
	<table border="0" width="80%" cellpadding="3" cellspacing="1">
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
		<td width="280px" class="lang"><textarea class="ckeditor" id="editor1" name="page_pageText"><?=$output[0]['pageText']?></textarea>&nbsp;&nbsp; </td>
	</tr>
	<tr>
		<td colspan="2"><hr width="100%" style="border:0px solid #FF7700; background-color:#D2D7DC; height:1px;"></td>
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
		<td class="row2">Позиция:</td>
		<td><input type="text" name="page_pagePosition" maxlength="4" style="width:40px" value="<? echo $output[0]['pagePosition']; ?>" /></td>
	</tr>
	<tr>
		<td width="60" class="row2"><br /><input type="submit" name="save" value="Сохранить" /></td>
		<td></td>
	</tr>
	</table>
	</form>

	</td>
</tr>
</table>
