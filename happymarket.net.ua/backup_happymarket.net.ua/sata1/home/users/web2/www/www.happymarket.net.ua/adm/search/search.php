<form name="form" action="<?=$urlse?>" method="get" style="margin-top:0; margin-bottom:0;">
<table>
	<tr>
		<td>Название товара:</td>
		<td><input type="text" name="s" value="<?=$_GET['s']?>" style="width:200px;"></td>
	</tr>
	<tr>
		<td>Бренд:</td>
		<td>
			<select name="b" style="width:200px;">
			
			<?
				echo getSelectedDropDown('ddBrand',$_GET['b']);
			?>
			</select>
		</td>
	</tr>

	<tr>
		<td>Рубрика:</td>
		<td>
			<select name="c" style="width:200px;">
			<?
				echo getSelectedDropDown('ddCat',$_GET['c']);
			?>
			</select>
		</td>
	</tr>
	<?
		if(isset($ddSubCat))
		{
			echo '<tr>';
				echo '<td style="width:200px;">Подрубрика:</td>';
				echo '<td>';
					echo '<select name="sc" style="width:200px;">';
						echo getSelectedDropDown('ddSubCat',$_GET['sc']);
					echo '</select>';
				echo '</td>';
			echo '</tr>';	
		}
	?>
	<tr>
		<td colspan="2" align="right">
			<input type="submit" value="Поиск" name="sab" class="button1">
		</td>
	</tr>
</table>
</form>
<?
$input = $_GET;

if($outputResource['rows'] > 0 OR !empty($CUR_BRAND_ARRAY['brandID']))
{
	echo '<div style="text-align:center;color:#ff4709;font-size:14px;">Найдено: '.$outputCount[0]['count(permAll)'].' товар(а,ов).</div>';
	echo '<HR size="2" width="100%" color="#ff4709" align="center">';

	if(!empty($CUR_BRAND_ARRAY['brandID']))
	{
		$COUNT_STRING = 0;
		for ($i=0; $i<$outputCategory['rows']; $i++)
		{
			$COUNT_STRING = $COUNT_STRING + 2 + $outputSubCategory[$outputCategory[$i]['categoryID']]['rows'];
		}
		$COUNT_STRING_DIV_2 = ceil($COUNT_STRING/2);
		?><center><table width="100%" cellpadding="0" cellspacing="0" border="0" style="margin-top:22px;"><?
		echo '<tr valign="top">';
			echo '<td width="50%">';
			$CUR_STRING = 0; $FLAG = true;
			for ($i=0; $i<$outputCategory['rows']; $i++)
			{
				$CUR_STRING = $CUR_STRING + 2;
				$CUR_SUB_DIV_2 = $CUR_STRING + round($outputSubCategory[$outputCategory[$i]['categoryID']]['rows']/2);
	
				if($FLAG AND $i != 0 AND $COUNT_STRING_DIV_2 < ($CUR_STRING + $outputSubCategory[$outputCategory[$i]['categoryID']]['rows']) AND $CUR_SUB_DIV_2 > $COUNT_STRING_DIV_2)
				{
					echo '</td>';
					echo '<td>';
					$CUR_STRING = 0;
					$FLAG = false;
				}
				
				echo '<div class="category_container">';

					echo '<div class="category_name_container">';
					echo '<div class="category_frame"><img src="images/classic/category_top.gif" width="125" height="3" style="margin:0"></div>';
					echo '<div align=left class="category_name">'.$outputCategory[$i]['categoryName'].'</div>';
					echo '<div class="category_frame"><img src="images/classic/category_bottom.gif" width="125" height="3" style="margin:0"></div>';
					echo '</div>';
					
					echo '<div align=left class="category_links">';
					
					for ($j=0; $j<$outputSubCategory[$outputCategory[$i]['categoryID']]['rows']; $j++)
					{
						$CUR_STRING++;
						$sub_action = $outputSubCategory[$outputCategory[$i]['categoryID']][$j]['categoryAlias'].'/'.$CUR_BRAND_ARRAY['brandAlias'].'';
						echo '<a class="grey" href="'.$sub_action.'" >'.$outputSubCategory[$outputCategory[$i]['categoryID']][$j]['categoryName'].' ('.$outputSubCategory[$outputCategory[$i]['categoryID']][$j]['resourceCount'].')</a><br>';
					}
					echo '<br></div>';
			
				echo '</div>';
			}
			echo '</td>';
		echo '</tr>';
		?></table></center><?

		if(!empty($CUR_BRAND_ARRAY['brandID']) AND $outputCategory['rows'] > 0)
		{
			echo '<br>';
			echo '<h1 class="brand">'.$CUR_BRAND_ARRAY['brandName'].'</h1>';
			echo '<HR size="2" color="#ff4709" align="left">';
			if(!empty($CUR_BRAND_ARRAY['brandImage'])) echo '<img align="left" src="images/brand/'.$CUR_BRAND_ARRAY['brandImage'].'" alt="логотип '.$CUR_BRAND_ARRAY['brandName'].'" title="логотип '.$CUR_BRAND_ARRAY['brandName'].'" style="margin-right:10px;margin-bottom:5px;">';
			echo '<div style="text-align:left;margin-bottom:5px;text-align:justify;">'.nl2br($CUR_BRAND_ARRAY['brandDescription']).'</div>';
			echo '<div style="clear:both;padding-bottom:10px;">&nbsp;</div>';
		}

	}
	else
	{
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
				echo '<a href="search?s='.$_GET['s'].'&b='.$_GET['b'].'&c='.$_GET['c'].'&sc='.$_GET['sc'].'&sab='.$_GET['sab'].'&page='.($numPage-1).'">назад</a> | ';
			}
			if($numPage > $maxPage)
			{
				echo '<a href="search?s='.$_GET['s'].'&b='.$_GET['b'].'&c='.$_GET['c'].'&sc='.$_GET['sc'].'&sab='.$_GET['sab'].'&page='.($startPage-1).'">'.($startPage-$maxPage).'-'.($startPage-1).'</a> | ';
			}
			for ($p = $startPage; $p < $endPage + 1; $p++)
			{
				if($p == $numPage AND $viewModePage != 'all')
				{
					echo ''.$p.' | ';
				}
				else if($p == 1)
				{
					echo '<a href="search?s='.$_GET['s'].'&b='.$_GET['b'].'&c='.$_GET['c'].'&sc='.$_GET['sc'].'&sab='.$_GET['sab'].'">'.$p.'</a> | ';
				}
				else
				{
					echo '<a href="search?s='.$_GET['s'].'&b='.$_GET['b'].'&c='.$_GET['c'].'&sc='.$_GET['sc'].'&sab='.$_GET['sab'].'&page='.$p.'">'.$p.'</a> | ';
				}
			}
			if($countPages > $maxPage*($levelPage+1))
			{
				echo '<a href="search?s='.$_GET['s'].'&b='.$_GET['b'].'&c='.$_GET['c'].'&sc='.$_GET['sc'].'&sab='.$_GET['sab'].'&page='.($endPage+1).'">'.($endPage+1).'-'; if($countPages < $endPage+$maxPage){echo($countPages);}else{echo($endPage+$maxPage);} echo '</a> | ';
			}
			if($numPage != $countPages AND $viewModePage != 'all')
			{
				echo '<a href="search?s='.$_GET['s'].'&b='.$_GET['b'].'&c='.$_GET['c'].'&sc='.$_GET['sc'].'&sab='.$_GET['sab'].'&page='.($numPage+1).'">вперед</a> | ';
			}
			if($viewModePage == 'all')
			{
				echo 'все';
			}
			else
			{
				echo '<a  href="search?s='.$_GET['s'].'&b='.$_GET['b'].'&c='.$_GET['c'].'&sc='.$_GET['sc'].'&sab='.$_GET['sab'].'&page=all">все</a>';
			}
			echo '</div>';
		}
	
		echo '<div align="center">';
		for ($i=0; $i<$outputResource['rows']; $i++)
		{
			if(!empty($outputResource[$i]['resourceBrand']))
				$wareBrandStr = $BRAND_ARRAY[$outputResource[$i]['resourceBrand']]['brandAlias'].'-';
			else
				$wareBrandStr = '';

			echo '<table border="0" cellspacing="0" cellpadding="0" width="740">';
			echo '<tr>';
				echo '<td rowspan="3" width="190" align="center" valign="top">';
					if(!empty($outputResource[$i]['resourceImage']))
					{
						echo '<a href="'.$CAT_ARRAY[$outputResource[$i]['subCategoryID']]['categoryAlias'].'/'.$outputResource[$i]['resourceAlias'].'-'.$wareBrandStr.$outputResource[$i]['resourceID'].'"><img src="images/resource/'.$CAT_ARRAY[$outputResource[$i]['categoryID']]['categoryAlias'].'/'.$outputResource[$i]['subCategoryID'].'/2/'.$outputResource[$i]['resourceImage'].'" class="imgResource"></a>';
					}
					else echo '<div style="padding-top:60px; width:140px; height:80px;" class="imgResource">Нет фото</div>';
					if($userArray['userID'] == '555') echo '<div style="text-align:center; padding-top:5px;"><a target="_blank" href="adm/?manageResource/resource/'.$outputResource[$i]['resourceID'].'/category/'.$outputResource[$i]['categoryID'].'/sub/'.$outputResource[$i]['subCategoryID'].'"><img src="images/classic/edit.gif" width="30" height="21"></a></div>';
				echo '</td>';
				echo '<td  valign="top" height="55">';
					echo '<div class="resourceName"><a href="'.$CAT_ARRAY[$outputResource[$i]['subCategoryID']]['categoryAlias'].'/'.$outputResource[$i]['resourceAlias'].'-'.$wareBrandStr.$outputResource[$i]['resourceID'].'" class="resourceNameHref">'.$BRAND_ARRAY[$outputResource[$i]['resourceBrand']]['brandName'].' '.$outputResource[$i]['resourceName'].'</a></div>';
					
		
					$description = $outputResource[$i]['resourceDescription'];
					$description = str_replace(', ', ',', $description);
					$description = str_replace(',', ', ', $description);
					$description = str_replace('<br>', '', $description);
					$description = str_replace('<BR>', '', $description);
					$description = str_replace('<br />', '', $description);
					$description = str_replace('<BR />', '', $description);
					$description = str_replace('<Br>', '', $description);
					$description = squash($description, 220, 200);
					$description = nl2br($description);
		
					if(!empty($outputResource[$i]['resourceArtikul'])) $description = 'Артикул: '.$outputResource[$i]['resourceArtikul'].'<br>'.$description;
				
					echo nl2br($description);
		
					echo '<div style="padding-top:5px;"><a href="'.$CAT_ARRAY[$outputResource[$i]['subCategoryID']]['categoryAlias'].'/'.$outputResource[$i]['resourceAlias'].'-'.$wareBrandStr.$outputResource[$i]['resourceID'].'">Детальніше</a></div>';
				echo '</td>';
				echo '<td>';
		
					$priceClass = 'resourcePrice';
					for($h=0; $h < $outputHotoffer['rows']; $h++) { if(strstr($outputHotoffer[$h]['hotofferResource'],'|'.$outputResource[$i]['resourceID'].'|')) { $priceClass = 'resourcePriceRed'; break;} }
					
					echo '<div class="'.$priceClass.'"><div class="resourcePriceVal"><b>'.$outputResource[$i]['resourcePrice'].'</b></div></div>';
		
					echo '<form name="purchase" action="cart" method="post" enctype="multipart/form-data">';
					echo '<input type="hidden" name="viewMode" value="purchase" />';
					echo '<input type="hidden" name="category" value="'.$CAT_ARRAY[$outputResource[$i]['categoryID']]['categoryAlias'].'" />';
					echo '<input type="hidden" name="sub" value="'.$CAT_ARRAY[$outputResource[$i]['subCategoryID']]['categoryAlias'].'" />';
					echo '<input type="hidden" name="ware" value="'.$outputResource[$i]['resourceID'].'" />';
					echo '<div style="padding-top:30px;"><input type="image" src="images/classic/buy_b.png" width="76" height="49" class="inputnontext" style="margin-right:14px; margin-top:50px;"></div>';
					echo '</form>';
				echo '</td>';
			echo '</tr>';
			echo '</table>';
			// echo '<div style="height:1px; width:90%; border-bottom:3px dotted #ccc; margin:14 0px;"></div>';
			echo '<div style="height:38px; width:720px; background:url(\'images/classic/slash.jpg\') center center repeat-x;"></div>';
		}
		echo '</div>';
	
		//pages
		if($outputCount[0]['count(permAll)'] > $countEntity)
		{
			echo '<div style="clear:both;width:100%; word-spacing:2; font-family:Verdana; text-align:center;">';
			if($numPage != 1 AND $viewModePage != 'all')
			{
				echo '<a href="search?s='.$_GET['s'].'&b='.$_GET['b'].'&c='.$_GET['c'].'&sc='.$_GET['sc'].'&sab='.$_GET['sab'].'&page='.($numPage-1).'">назад</a> | ';
			}
			if($numPage > $maxPage)
			{
				echo '<a href="search?s='.$_GET['s'].'&b='.$_GET['b'].'&c='.$_GET['c'].'&sc='.$_GET['sc'].'&sab='.$_GET['sab'].'&page='.($startPage-1).'">'.($startPage-$maxPage).'-'.($startPage-1).'</a> | ';
			}
			for ($p = $startPage; $p < $endPage + 1; $p++)
			{
				if($p == $numPage AND $viewModePage != 'all')
				{
					echo ''.$p.' | ';
				}
				else if($p == 1)
				{
					echo '<a href="search?s='.$_GET['s'].'&b='.$_GET['b'].'&c='.$_GET['c'].'&sc='.$_GET['sc'].'&sab='.$_GET['sab'].'">'.$p.'</a> | ';
				}
				else
				{
					echo '<a href="search?s='.$_GET['s'].'&b='.$_GET['b'].'&c='.$_GET['c'].'&sc='.$_GET['sc'].'&sab='.$_GET['sab'].'&page='.$p.'">'.$p.'</a> | ';
				}
			}
			if($countPages > $maxPage*($levelPage+1))
			{
				echo '<a href="search?s='.$_GET['s'].'&b='.$_GET['b'].'&c='.$_GET['c'].'&sc='.$_GET['sc'].'&sab='.$_GET['sab'].'&page='.($endPage+1).'">'.($endPage+1).'-'; if($countPages < $endPage+$maxPage){echo($countPages);}else{echo($endPage+$maxPage);} echo '</a> | ';
			}
			if($numPage != $countPages AND $viewModePage != 'all')
			{
				echo '<a href="search?s='.$_GET['s'].'&b='.$_GET['b'].'&c='.$_GET['c'].'&sc='.$_GET['sc'].'&sab='.$_GET['sab'].'&page='.($numPage+1).'">вперед</a> | ';
			}
			if($viewModePage == 'all')
			{
				echo 'все';
			}
			else
			{
				echo '<a  href="search?s='.$_GET['s'].'&b='.$_GET['b'].'&c='.$_GET['c'].'&sc='.$_GET['sc'].'&sab='.$_GET['sab'].'&page=all">все</a>';
			}
			echo '</div>';
		}
	}
}
elseif($input['s'] == 'catalog')
{
	echo '<div style="text-align:center;color:#FF0000;font-size:14px;">Поиск не дал результатов.</div>';
}


?>