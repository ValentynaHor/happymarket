<SCRIPT src="js/dynamicOptionList.js"></SCRIPT>
<table border="0" cellpadding="5" cellspacing="0">
<tr>
	<td valign="top" align="center">
		<form name="change" action="<?=$sid?>" method="post" onSubmit="submitonce(this)" enctype="multipart/form-data">
		<input type="hidden"  name="viewMode" value="change" >
		<table border="0" cellpadding="0" cellspacing="2">
		<tr>
			<td valign="bottom">
				<div style="padding-top:5px;">Бренд:</div>
				<SELECT name="change_brand" style="width:180px">
					
					<?php
					echo '<option value="">- выбрать -</option>';
					echo getSelectedDropDown('ddBrand', $change_brand);
					?>
				</SELECT>
			</td>
			<td valign="bottom">
				<div style="padding-top:5px;">Наличие:</div>
				<SELECT name="change_presence" style="width:180px">
					<?
					echo '<option value="">- выбрать -</option>';
					echo getSelectedDropDown('ddPresenceAdmin', $change_presence);
					?>
				</SELECT>
			</td>
			<td valign="bottom" align="right" width="30">
				<input type="image" src="img/icon/go.gif" name="submit" onMouseMove="this.src=go_on.src;" onMouseOut="this.src=go_out.src;" class="submit" border="0" style="border-bottom:3px solid #FFFFFF;"/>
			</td>
		</tr>
		</table>
		</form>
	</td>
</tr>
<? if($_POST['viewMode'] == 'change' AND $rowsChanged > 0) { ?>
<tr>
	<td valign="top" align="left">
		Для <strong><?=$rowsChanged?></strong> товар(а,ов) производителя <strong><?=getValueDropDown('ddBrand', $change_brand)?></strong> выставлен статус <strong><?=getValueDropDown('ddPresenceAdmin', $change_presence)?></strong>.
	</td>
</tr>
<? } ?>
</table>