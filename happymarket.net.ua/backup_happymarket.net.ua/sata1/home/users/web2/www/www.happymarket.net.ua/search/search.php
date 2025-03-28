<?
if($_GET['m'] == 'adv')
{
	echo '<form name="form" action="/search" method="get" style="margin-top:0; margin-bottom:0;">';
	echo '<input type="hidden" name="m" value="'.$_GET['m'].'" style="width:200px;">';
	echo '<table>';
		echo '<tr>';
			echo '<td>Название товара:</td>';
			echo '<td><input type="text" name="s" value="'.$_GET['s'].'" style="width:200px;"></td>';
		echo '</tr>';
		echo '<tr>';
			echo '<td>Рубрика:</td>';
			echo '<td>';
				echo '<select name="c" style="width:200px;">';
				echo getSelectedDropDown('ddCat',$_GET['c']);
				echo '</select>';
			echo '</td>';
		echo '</tr>';
		echo '<tr>';
			echo '<td>Бренд:</td>';
			echo '<td>';
				echo '<select name="b" style="width:200px;">';
				echo getSelectedDropDown('ddBrand',$_GET['b']);
				echo '</select>';
			echo '</td>';
		echo '</tr>';
		echo '<tr>';
			echo '<td colspan="2" align="right">';
				echo '<input type="submit" value="Поиск" class="button1">';
			echo '</td>';
		echo '</tr>';
	echo '</table>';
	echo '</form>';
}

if($outputResource['rows'] > 0)
{
	echo '<div style="text-align:center;color:#ff4709;font-size:14px;">Найдено: '.$outputCount[0]['count(permAll)'].' товар(а,ов).</div>';
	echo '<HR size="2" width="100%" color="#ff4709" align="center">';
	//pages
	if($outputCount[0]['count(permAll)'] > $countEntity)
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
			echo '<a href="search?'.$INCsearch.$INCcat.$INCbrand.$INCmod.'&page='.($numPage-1).'">назад</a> | ';
		}
		if($numPage > $maxPage)
		{
			echo '<a href="search?'.$INCsearch.$INCcat.$INCbrand.$INCmod.'&page='.($startPage-1).'">'.($startPage-$maxPage).'-'.($startPage-1).'</a> | ';
		}
		for ($p = $startPage; $p < $endPage + 1; $p++)
		{
			if($p == $numPage AND $viewModePage != 'all')
			{
				echo ''.$p.' | ';
			}
			else if($p == 1)
			{
				echo '<a href="search?'.$INCsearch.$INCcat.$INCbrand.$INCmod.'">'.$p.'</a> | ';
			}
			else
			{
				echo '<a href="search?'.$INCsearch.$INCcat.$INCbrand.$INCmod.'&page='.$p.'">'.$p.'</a> | ';
			}
		}
		if($countPages > $maxPage*($levelPage+1))
		{
			echo '<a href="search?'.$INCsearch.$INCcat.$INCbrand.$INCmod.'&page='.($endPage+1).'">'.($endPage+1).'-'; if($countPages < $endPage+$maxPage){echo($countPages);}else{echo($endPage+$maxPage);} echo '</a> | ';
		}
		if($numPage != $countPages AND $viewModePage != 'all')
		{
			echo '<a href="search?'.$INCsearch.$INCcat.$INCbrand.$INCmod.'&page='.($numPage+1).'">вперед</a> | ';
		}
		if($viewModePage == 'all')
		{
			echo 'все';
		}
		else
		{
			echo '<a  href="search?'.$INCsearch.$INCcat.$INCbrand.$INCmod.'&page=all">все</a>';
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
					echo '<a href="'.$CAT_ARRAY[$outputResource[$i]['subCategoryID']]['categoryAlias'].'/'.$outputResource[$i]['resourceAlias'].'-'.$wareBrandStr.$outputResource[$i]['resourceID'].'"><img src="images/resource/'.$CAT_ARRAY[$outputResource[$i]['categoryID']]['categoryAlias'].'/'.$outputResource[$i]['subCategoryID'].'/2/'.$outputResource[$i]['resourceImage'].'" class="imgResource"></a>';
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
				echo '<div class="resourceName"><a href="'.$CAT_ARRAY[$outputResource[$i]['subCategoryID']]['categoryAlias'].'/'.$outputResource[$i]['resourceAlias'].'-'.$wareBrandStr.$outputResource[$i]['resourceID'].'" class="resourceNameHref">'.$outputResource[$i]['resourceName'].'</a></div>';

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

				echo '<div style="padding-top:5px;"><a href="'.$CAT_ARRAY[$outputResource[$i]['subCategoryID']]['categoryAlias'].'/'.$outputResource[$i]['resourceAlias'].'-'.$wareBrandStr.$outputResource[$i]['resourceID'].'"><strong>Подробнее</strong></a></div>';
			echo '</td>';
			echo '<td align="right" valign="top" width="120">';

				$priceClass = 'resourcePrice';
				for($h=0; $h < $outputHotoffer['rows']; $h++) { if(strstr($outputHotoffer[$h]['hotofferResource'],'|'.$outputResource[$i]['resourceID'].'|')) { $priceClass = 'resourcePriceRed'; break;} }

				if (empty($userArray['wholesale'])): ?>
					<div class="<?= $priceClass ?>">
						<div class="resourcePriceVal"><?= ceil($outputResource[$i]['resourcePrice']) ?> грн</div>
					</div>
				<? else: ?>
					<div class="resourcePrice two-prices">
						<div class="opt-price"><?= ceil($outputResource[$i]['wholesalePrice']) ?> грн</div>
						<div class="resourcePriceVal"><?= ceil($outputResource[$i]['resourcePrice']) ?> грн</div>
					</div>
				<? endif; ?>

				<form name="purchase" action="cart" method="post" enctype="multipart/form-data">
					<input type="hidden" name="viewMode" value="purchase" />
					<input type="hidden" name="ware" value="<?= $outputResource[$i]['resourceID'] ?>" />
					<div class="bl-1"><input type="submit" class="inputnontext btn-main" value="Купить"></div>
				</form>
			<?
			echo '</td>';
		echo '</tr>';
		echo '</table>';
		echo '<div style="height:38px; width:690px; background:url(\'images/classic/slash.jpg\') center center repeat-x;"></div>';
	}
	echo '</div>';

	//pages
	if($outputCount[0]['count(permAll)'] > $countEntity)
	{
		echo '<div style="clear:both;width:100%; word-spacing:2; font-family:Verdana; text-align:center;">';
		if($numPage != 1 AND $viewModePage != 'all')
		{
			echo '<a href="search?'.$INCsearch.$INCcat.$INCbrand.$INCmod.'&page='.($numPage-1).'">назад</a> | ';
		}
		if($numPage > $maxPage)
		{
			echo '<a href="search?'.$INCsearch.$INCcat.$INCbrand.$INCmod.'&page='.($startPage-1).'">'.($startPage-$maxPage).'-'.($startPage-1).'</a> | ';
		}
		for ($p = $startPage; $p < $endPage + 1; $p++)
		{
			if($p == $numPage AND $viewModePage != 'all')
			{
				echo ''.$p.' | ';
			}
			else if($p == 1)
			{
				echo '<a href="search?'.$INCsearch.$INCcat.$INCbrand.$INCmod.'">'.$p.'</a> | ';
			}
			else
			{
				echo '<a href="search?'.$INCsearch.$INCcat.$INCbrand.$INCmod.'&page='.$p.'">'.$p.'</a> | ';
			}
		}
		if($countPages > $maxPage*($levelPage+1))
		{
			echo '<a href="search?'.$INCsearch.$INCcat.$INCbrand.$INCmod.'&page='.($endPage+1).'">'.($endPage+1).'-'; if($countPages < $endPage+$maxPage){echo($countPages);}else{echo($endPage+$maxPage);} echo '</a> | ';
		}
		if($numPage != $countPages AND $viewModePage != 'all')
		{
			echo '<a href="search?'.$INCsearch.$INCcat.$INCbrand.$INCmod.'&page='.($numPage+1).'">вперед</a> | ';
		}
		if($viewModePage == 'all')
		{
			echo 'все';
		}
		else
		{
			echo '<a  href="search?'.$INCsearch.$INCcat.$INCbrand.$INCmod.'&page=all">все</a>';
		}
		echo '</div>';
	}
}
elseif(!empty($resultMessage))
{
	echo $resultMessage;
}


?>
