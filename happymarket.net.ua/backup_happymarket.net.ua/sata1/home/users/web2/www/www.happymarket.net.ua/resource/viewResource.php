<?
	//comment handle variables
	$c_wareID = $outputResource['resourceID'];
	$c_wareName = urlencode($outputResource['resourceName']);
	$c_wareAlias = $outputResource['resourceAlias'];
	$c_categoryID = $getvar['category'];
	$c_subCategoryID = $getvar['sub'];
	$c_wareBrand = $CUR_BRAND_ARRAY['brandAlias'];
	$c_commentType = 'resource';
?>
<script type="text/javascript">
$(document).ready(function() {
	$('a.lightbox').lightBox({
		displayRel: false,
		fixedNavigation: true,
		minImageWidth: 300,
		overlayBgColor: '#444',
		overlayOpacity:	0.8,
		txtImage: "Фото",
		txtOf: "из"
	});
});
</script>
<script language="JavaScript" type="text/javascript" src="../js/forum.js"></script>
<?
$COD = 'WINDOWS-1251';
$win1251_sm = iconv('UTF-8', $COD, 'абвгдеёжзийклмнопрстуфхцчшщъыьэюяієї');
$win1251_bg = iconv('UTF-8', $COD, 'АБВГДЕЁЖЗИЙКЛМНОПРСТУФХЦЧШЩЪЫЬЭЮЯІЄЇ');

echo '<form name="purchase" action="cart" method="post" enctype="multipart/form-data">';
echo '<input type="hidden" name="viewMode" value="purchase" />';
echo '<input type="hidden" name="category" value="'.$getvar['category'].'" />';
echo '<input type="hidden" name="sub" value="'.$getvar['sub'].'" />';
echo '<input type="hidden" name="ware" value="'.$outputResource['resourceID'].'" />';

echo '<div align="center">';
	echo '<table border="0" cellspacing="0" cellpadding="0" width="700">';
	echo '<tr>';
		echo '<td rowspan="0" width="190" align="center" valign="top">';
			if(!empty($outputResource['resourceImage']))
			{
				echo '<a href="images/resource/'.$CUR_CAT_ARRAY['categoryAlias'].'/'.$CUR_SUB_ARRAY['categoryID'].'/1/'.$outputResource['resourceImage'].'" class="lightbox"><img src="images/resource/'.$CUR_CAT_ARRAY['categoryAlias'].'/'.$CUR_SUB_ARRAY['categoryID'].'/2/'.$outputResource['resourceImage'].'" class="imgResource"></a>';
			}
			else echo '<div style="padding-top:60px; width:140px; height:80px;" class="imgResource">Нет фото</div>';
			if($userArray['userID'] == '555' AND $CAT_ARRAY[$outputResource['categoryID']]['categoryDepartment'] != '3' OR $userArray['userID'] == '444' AND $CAT_ARRAY[$outputResource['categoryID']]['categoryDepartment'] == '3')
			{
				echo '<div style="text-align:center; padding-top:5px;"><a target="_blank" href="adm/?manageResource/resource/'.$outputResource['resourceID'].'/category/'.$outputResource['categoryID'].'/sub/'.$outputResource['subCategoryID'].'/dept/'.$CAT_ARRAY[$outputResource['categoryID']]['categoryDepartment'].'"><img src="images/classic/edit.gif" width="30" height="21"></a></div>';
			}
			echo '<div style="margin-top:0px;">';
			//additional images
			for($i=1; $i<=4; $i++)
			{
				if(!empty($outputResource['resourceImage'.$i]))
				{
					$explode = explode('|',$outputResource['resourceImage'.$i]);
					$outputResource['resourceImage'.$i] = $explode[0];
					$outputResource['Alt'.$i] = $explode[1];

					echo '<a href="images/resource/'.$CUR_CAT_ARRAY['categoryAlias'].'/'.$CUR_SUB_ARRAY['categoryID'].'/1/'.$outputResource['resourceImage'.$i].'" rel="gallery" class="lightbox" title="'.$outputResource['Alt'.$i].'"><img src="images/resource/'.$CUR_CAT_ARRAY['categoryAlias'].'/'.$CUR_SUB_ARRAY['categoryID'].'/2/'.$outputResource['resourceImage'.$i].'" alt="'.$outputResource['Alt'.$i].'" class="preview"></a>';
				}
			}
			echo '</div>';

		echo '</td>';
		echo '<td  valign="top">';
			echo '<div class="resourceName">';
				echo '<h1>'.$outputResource['resourceName'].'</h1>';
				echo '<span style="color:#777; font-weight:normal; font-size:12px;">'.getValueDropDown('ddPresenceClient', $outputResource['presence']).'</span>';
			echo '</div>';
            if (!empty($outputResource['note'])) {
                echo '<div style="color:red;font-size:15px;font-weight:bold;text-align:center">'.nl2br($outputResource['note']).'</div>';
            }
			if(!empty($outputResource['resourceArtikul'])) echo '<p><strong>Артикул</strong>: '.$outputResource['resourceArtikul'].'</p>';
			echo '<p align=justify>'.nl2br($outputResource['resourceDescription']).'</p>';
		echo '</td>';
		echo '<td align="right" valign="top" width="120">';
			if(!empty($outputResource['resourcePrice']) AND $outputResource['resourcePrice'] != '0.00')
			{
				if($outputResource['resourceOffer'] == '1') $priceClass = 'resourcePriceRed'; else $priceClass = 'resourcePrice';

				if (empty($userArray['wholesale'])): ?>
					<div class="<?= $priceClass ?>">
						<div class="resourcePriceVal"><?= ceil($outputResource['resourcePrice']) ?> грн</div>
					</div>
				<? else: ?>
					<div class="resourcePrice two-prices">
						<div class="opt-price"><?= ceil($outputResource['wholesalePrice']) ?> грн</div>
						<div class="resourcePriceVal"><?= ceil($outputResource['resourcePrice']) ?> грн</div>
					</div>
				<? endif;
			}
			else
			{
				echo '<div class="resourcePriceEmpty" style="margin-top:1px;">цену<br>уточняйте</div>';
			}
			?><div class="bl-1"><input type="submit" class="inputnontext btn-main" value="Купить"></div><?
		echo '</td>';
	echo '</tr>';
	echo '</table>';
echo '</div>';

echo '</form>';
?>
