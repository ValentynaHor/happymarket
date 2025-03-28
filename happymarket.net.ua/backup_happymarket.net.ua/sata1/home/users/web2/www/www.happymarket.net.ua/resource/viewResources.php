<script language="javascript">
function checkelem(elm)
{
	var elem = document.getElementById(elm);
	if(elem.checked) elem.checked = false; else elem.checked = true;
	document.forms.filtration.submit();
}
</script>

<?

if(!empty($CUR_BRAND_ARRAY['brandNote'])) { echo '<div align="center" style="width:100%; color:#ff4709; padding-top:10px;">'.$CUR_BRAND_ARRAY['brandNote'].'</div>'; }

if(!empty($CUR_SUB_ARRAY['categoryDescription'])) {
	echo '<fieldset>';
		echo $CUR_SUB_ARRAY['categoryDescription'];
	echo '</fieldset>';
}

$INCCategory = '';
if(!empty($getvar['sub'])) {$INCSub = $CUR_SUB_ARRAY['categoryAlias'];}
if(!empty($getvar['page'])) {$INCPage = '/'.$getvar['page'];}
if(!empty($getvar['brand'])) {$INCBrand = '-'.$getvar['brand']; }

echo '<div style="width:100%; padding-bottom:20px; padding-top:10px;">';
if(!empty($getvar['page']))
{
	if(!empty($getvar['brand'])) $form_action = str_replace('/'.$getvar['page'].'-','/',$sid);
	else $form_action = str_replace('/'.$getvar['page'],'/',$sid);
}
echo '<form name="filtration" action="'.$form_action.'" style="margin:10px 0px 0px 0px;" method="post" enctype="multipart/form-data">';
echo '<input type="hidden" name="viewMode" value="filter" />';
echo '<fieldset>';
	echo '<legend>Фильтры и сортировка:</legend>';

	echo '<nobr><b>Сортировать:</b> ';
	echo '<select name="sort" style="width:150px; margin-left:8px">';
		if(empty($_SESSION['SESSION_RESOURCE'][$getvar['category']][$getvar['sub']][$getvar['brand']]['sort'])) $selected = 'selected="selected"'; else $selected = '';
		echo '<option '.$selected.' value="">Нет</option>';
		echo getSelectedDropDown('ddResourceSort', $_SESSION['SESSION_RESOURCE'][$getvar['category']][$getvar['sub']][$getvar['brand']]['sort']);
	echo '</select></nobr>';

	echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ';

	echo '<nobr><b>Наличие товара:</b> ';
	echo '<select name="presence" style="width:150px; margin-left:8px">';
		if($_SESSION['SESSION_RESOURCE'][$getvar['category']][$getvar['sub']][$getvar['brand']]['presence'] == 'all' OR empty($_SESSION['SESSION_RESOURCE'][$getvar['category']][$getvar['sub']][$getvar['brand']]['presence'])) $selected = 'selected="selected"'; else $selected = '';
		echo '<option '.$selected.' value="all">Все</option>';
		echo getSelectedDropDown('ddPresenceAdmin', $_SESSION['SESSION_RESOURCE'][$getvar['category']][$getvar['sub']][$getvar['brand']]['presence']);
	echo '</select></nobr>';

	echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ';

	echo '<input type="submit" value="Фильтровать" name="Submit" class="button1">';
echo '</fieldset>';
echo '</form>';
echo '</div>';

//view pages
if ($outputCount[0]['count(permAll)'] > $countEntity)
{
	$maxPage = 10;
	$countPages = ceil($outputCount[0]['count(permAll)']/$countEntity);
	$levelPage = ceil($numPage/$maxPage)-1;
	//$maxPos = count($outputUser)-1;
	if(!empty($maxPage) AND ($numPage > $maxPage))
	{
		$startPage = $maxPage*$levelPage + 1;
	}
	else if(!empty($maxPage) AND ($numPage <= $maxPage))
	{
		$startPage = 1;
	}
	if($countPages < $maxPage*($levelPage+1)) { $endPage = $countPages; }
	else{ $endPage = $maxPage*($levelPage+1);}

	echo '<div style="clear:both;width:100%; word-spacing:2; font-family:Verdana; text-align:center;">';
	if($numPage != 1 AND $viewModePage != 'all')
	{
		if(($startPage-1) < 2) echo '<a href="'.$INCCategory.$INCSub.'/'.substr($INCBrand, -(strlen($INCBrand)-1)).'">назад</a> | ';
		else echo '<a href="'.$INCCategory.$INCSub.'/'.($numPage-1).''.$INCBrand.'">назад</a> | ';
	}
	if($numPage > $maxPage)
	{
		echo '<a href="'.$INCCategory.$INCSub.'/'.($startPage-1).''.$INCBrand.'">'.($startPage-$maxPage).'-'.($startPage-1).'</a> | ';
	}
	for ($p = $startPage; $p < $endPage + 1; $p++)
	{
		if($p == $numPage AND $viewModePage != 'all')
		{
			echo ''.$p.' | ';
		}
		elseif($p == 1)
		{
			echo '<a href="'.$INCCategory.$INCSub.'/'.substr($INCBrand, -(strlen($INCBrand)-1)).'">'.$p.'</a> | ';
		}
		else
		{
			echo '<a href="'.$INCCategory.$INCSub.'/'.$p.''.$INCBrand.'">'.$p.'</a> | ';
		}
	}
	if($countPages > $maxPage*($levelPage+1))
	{
		echo '<a href="'.$INCCategory.$INCSub.'/'.($endPage+1).''.$INCBrand.'">'.($endPage+1).'-'; if($countPages < $endPage+$maxPage){echo($countPages);}else{echo($endPage+$maxPage);} echo '</a> | ';
	}
	if($numPage != $countPages AND $viewModePage != 'all')
	{
		echo '<a href="'.$INCCategory.$INCSub.'/'.($numPage+1).''.$INCBrand.'">вперед</a> | ';
	}
	if($viewModePage == 'all')
	{
		echo 'все';
	}
	else
	{
		echo '<a href="'.$INCCategory.$INCSub.'/all'.$INCBrand.'">все</a>';
	}
	echo '</div>';
}

echo '<div align="center">';
for ($i=0; $i<$outputResource['rows']; $i++)
{
	echo '<table border="0" cellspacing="0" cellpadding="0" width="700">';
	echo '<tr>';
		echo '<td rowspan="0" width="190" align="center" valign="top">';
			if(!empty($outputResource[$i]['resourceImage']))
			{
				echo '<a href="'.$CUR_SUB_ARRAY['categoryAlias'].'/'.$outputResource[$i]['resourceAlias'].'-'.$wareBrandStr.$outputResource[$i]['resourceID'].'"><img src="images/resource/'.$CUR_CAT_ARRAY['categoryAlias'].'/'.$CUR_SUB_ARRAY['categoryID'].'/2/'.$outputResource[$i]['resourceImage'].'" class="imgResource"></a>';
			}
			else echo '<div style="padding-top:60px; width:140px; height:80px;" class="imgResource">Нет фото</div>';
			if($userArray['userID'] == '555' AND $CAT_ARRAY[$outputResource[$i]['categoryID']]['categoryDepartment'] != '3' OR $userArray['userID'] == '444' AND $CAT_ARRAY[$outputResource[$i]['categoryID']]['categoryDepartment'] == '3')
			{
				echo '<div style="text-align:center; padding-top:5px;"><a target="_blank" href="adm/?manageResource/resource/'.$outputResource[$i]['resourceID'].'/category/'.$outputResource[$i]['categoryID'].'/sub/'.$outputResource[$i]['subCategoryID'].'/dept/'.$CAT_ARRAY[$outputResource[$i]['categoryID']]['categoryDepartment'].'"><img src="images/classic/edit.gif" width="30" height="21"></a></div>';
			}
		echo '</td>';
		echo '<td  valign="top">';
			if(!empty($outputResource[$i]['resourceBrand']))
				$wareBrandStr = $BRAND_ARRAY[$outputResource[$i]['resourceBrand']]['brandAlias'].'-';
			else
				$wareBrandStr = '';
			echo '<div class="resourceName">';
				echo '<a href="'.$CUR_SUB_ARRAY['categoryAlias'].'/'.$outputResource[$i]['resourceAlias'].'-'.$wareBrandStr.$outputResource[$i]['resourceID'].'" class="resourceNameHref">'.$outputResource[$i]['resourceName'].'</a><br>';
				echo '<span style="color:#777; font-weight:normal; font-size:12px;">'.getValueDropDown('ddPresenceClient', $outputResource[$i]['presence']).'</span>';
			echo '</div>';

            if (!empty($outputResource[$i]['note'])) {
                echo '<div style="color:red;font-size:15px;font-weight:bold;text-align:center;margin-bottom:8px">'.nl2br($outputResource[$i]['note']).'</div>';
            }

			$description = $outputResource[$i]['resourceDescription'];
			$description = str_replace(', ', ',', $description);
			$description = str_replace(',', ', ', $description);
			$description = str_replace('<br>', '', $description);
			$description = str_replace('<BR>', '', $description);
			$description = str_replace('<br />', '', $description);
			$description = str_replace('<BR />', '', $description);
			$description = str_replace('<Br>', '', $description);
			$description = squash($description, 380, 360);
			$description = nl2br($description);

			if(!empty($outputResource[$i]['resourceArtikul'])) $description = 'Артикул: '.$outputResource[$i]['resourceArtikul'].'<br>'.$description;

			echo nl2br($description);

			echo '<div style="padding-top:5px;"><a href="'.$CUR_SUB_ARRAY['categoryAlias'].'/'.$outputResource[$i]['resourceAlias'].'-'.$wareBrandStr.$outputResource[$i]['resourceID'].'"><strong>Подробнее</strong></a></div>';
		echo '</td>';
		echo '<td align="right" valign="top" width="120">';

			if(!empty($outputResource[$i]['resourcePrice']) AND $outputResource[$i]['resourcePrice'] != '0.00'): ?>
				<? if($outputResource[$i]['resourceOffer'] == '1') $priceClass = 'resourcePriceRed'; else $priceClass = 'resourcePrice'; ?>

				<? if (empty($userArray['wholesale'])): ?>
					<div class="<?= $priceClass ?>">
						<div class="resourcePriceVal"><?= ceil($outputResource[$i]['resourcePrice']) ?> грн</div>
					</div>
				<? else: ?>
					<div class="resourcePrice two-prices">
						<div class="opt-price"><?= ceil($outputResource[$i]['wholesalePrice']) ?> грн</div>
						<div class="resourcePriceVal"><?= ceil($outputResource[$i]['resourcePrice']) ?> грн</div>
					</div>
				<? endif; ?>

			<? else: ?>
				<div class="resourcePriceEmpty">цену<br>уточняйте</div>
			<? endif; ?>

			<form name="purchase" action="cart" method="post" enctype="multipart/form-data">
				<input type="hidden" name="viewMode" value="purchase" />
				<input type="hidden" name="category" value="<?= $getvar['category'] ?>" />
				<input type="hidden" name="sub" value="<?= $getvar['sub'] ?>" />
				<input type="hidden" name="ware" value="<?= $outputResource[$i]['resourceID'] ?>" />
				<div class="bl-1"><input type="submit" class="inputnontext btn-main" value="Купить"></div>
			</form>
		</td>
	</tr>
	</table>
	<div style="height:38px; width:690px; background:url('images/classic/slash.jpg') center center repeat-x;"></div>
<? }
echo '</div>';

//view pages
if ($outputCount[0]['count(permAll)'] > $countEntity)
{
	echo '<div style="clear:both;width:100%; word-spacing:2; font-family:Verdana; text-align:center;">';
	if($numPage != 1 AND $viewModePage != 'all')
	{
		if(($startPage-1) < 2) echo '<a href="'.$INCCategory.$INCSub.'/'.substr($INCBrand, -(strlen($INCBrand)-1)).'">назад</a> | ';
		else echo '<a href="'.$INCCategory.$INCSub.'/'.($numPage-1).''.$INCBrand.'">назад</a> | ';
	}
	if($numPage > $maxPage)
	{
		echo '<a href="'.$INCCategory.$INCSub.'/'.($startPage-1).''.$INCBrand.'">'.($startPage-$maxPage).'-'.($startPage-1).'</a> | ';
	}
	for ($p = $startPage; $p < $endPage + 1; $p++)
	{
		if($p == $numPage AND $viewModePage != 'all')
		{
			echo ''.$p.' | ';
		}
		elseif($p == 1)
		{
			echo '<a href="'.$INCCategory.$INCSub.'/'.substr($INCBrand, -(strlen($INCBrand)-1)).'">'.$p.'</a> | ';
		}
		else
		{
			echo '<a href="'.$INCCategory.$INCSub.'/'.$p.''.$INCBrand.'">'.$p.'</a> | ';
		}
	}
	if($countPages > $maxPage*($levelPage+1))
	{
		echo '<a href="'.$INCCategory.$INCSub.'/'.($endPage+1).''.$INCBrand.'">'.($endPage+1).'-'; if($countPages < $endPage+$maxPage){echo($countPages);}else{echo($endPage+$maxPage);} echo '</a> | ';
	}
	if($numPage != $countPages AND $viewModePage != 'all')
	{
		echo '<a href="'.$INCCategory.$INCSub.'/'.($numPage+1).''.$INCBrand.'">вперед</a> | ';
	}
	if($viewModePage == 'all')
	{
		echo 'все';
	}
	else
	{
		echo '<a href="'.$INCCategory.$INCSub.'/all'.$INCBrand.'">все</a>';
	}
	echo '</div>';
}
?>
