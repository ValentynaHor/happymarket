<? if(!empty($CUR_BRAND_ARRAY['brandID']) OR $url != 'brands') { ?>
	<center>
	<?
	if($url == 'brands')
	{
		echo '<div align="left" style="width:100%; padding-top:3px; font-size:12px;font-family: Verdana, Helvetica; color:#424242;"><b>  </b>&#160; ';
		foreach($ddAlphabet_en as $key => $val)
		{
			if(strpos($ACTIVE_LETTERS,'|'.$key.'|') === false AND strpos($ACTIVE_LETTERS,'|'.$val.'|') === false)
			{
				echo '<span class="gray">'.$key.'</span>&#160;';
			}
			else
			{
				if($val == 'a') echo '<a class="orange" href="'.$urlve.'brands/" >'.$key.'</a>&#160;';
				else echo '<a class="orange" href="'.$urlve.'brands/'.$val.'" >'.$key.'</a>&#160;';
			}
		}
		echo ' &#160; &#160; &#160; <a class="maroon" href="'.$urlve.'brands/ru" >А-Я</a>&#160;';
		echo '</div>';
	}
	elseif(!empty($CUR_CAT_ARRAY['categoryID']))
	{
		if($outputBrand['rows'] > 0)
		{
			echo '<div class="list-brands">';
			if(empty($CUR_BRAND_ARRAY['brandID'])) echo '<span>Все</span>';
			else
			{
				if(!empty($getvar['sub'])) $link = $getvar['sub'].'/'.$outputBrand[$i]['brandAlias'].''; elseif(!empty($getvar['category'])) $link = $getvar['category'].'/'; else $link = 'shop';
				echo '<a href="'.$link.'" >Все</a>';
			}
			for ($i=0; $i<$outputBrand['rows']; $i++)
			{
				$SEP = ' | ';
				if(!empty($getvar['sub'])) $link = $getvar['sub'].'/'.$outputBrand[$i]['brandAlias'].''; elseif(!empty($getvar['category'])) $link = $getvar['category'].'/'.$outputBrand[$i]['brandAlias'].'.html'; else $link = 'brands/'.$outputBrand[$i]['brandAlias'].'';
				if($CUR_BRAND_ARRAY['brandID'] == $outputBrand[$i]['brandID'])
					echo $SEP.'<span class="d3">'.$outputBrand[$i]['brandName'].'</span>';
				else
					echo $SEP.'<a href="'.$link.'" >'.$outputBrand[$i]['brandName'].'</a>';
			}
			echo '</div>';
		}
	}

	$COUNT_STRING = 0;
	for ($i=0; $i<$outputCategory['rows']; $i++)
	{
		$COUNT_STRING = $COUNT_STRING + 2 + $outputSubCategory[$outputCategory[$i]['categoryID']]['rows'];
	}
	$COUNT_STRING_DIV_2 = ceil($COUNT_STRING/2);

	if(!isset($SUB_CUR_DEP_ARRAY) AND !is_array($SUB_CUR_DEP_ARRAY))
	{
    if (file_exists('js/scroller/images_'.$CUR_DEP_ARRAY['departmentID'].'.xml')) {
		if(filesize('js/scroller/images_'.$CUR_DEP_ARRAY['departmentID'].'.xml')>0){
		?>
		<script type="text/javascript" src="<?=urlse?>/js/scroller/swfobject.js"></script>
		<script type="text/javascript" src="<?=urlse?>/js/scroller/prototype.js"></script>
		<script type="text/javascript" src="<?=urlse?>/js/scroller/scriptaculous.js?load=effects"></script>
		<table width="100%" style="padding-left:2%"><tr><td align="left">
		<div class="carousel">
			<div style="position:absolute; z-index:99; height:15px; width:100%; background:#fff">&nbsp;</div>
			<div id="ScrollerDiv">
				<a href="http://www.adobe.com/go/getflashplayer">
					<img src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="Get Adobe Flash player" />
				</a>
			</div>
		</div>

		<? if(('/'.$CUR_DEP_ARRAY['departmentAlias'].'/' == $sid || $sid == '/') && !empty($CUR_DEP_ARRAY['departmentText'])): ?>
			<div class="text-block"><?= $CUR_DEP_ARRAY['departmentText'] ?></div>
		<? endif; ?>

		<script type="text/javascript">
			var flashvars = {};
			flashvars.settingsXML= "<?=urlse?>/js/scroller/settings_<?=$CUR_DEP_ARRAY['departmentID']?>.xml";
			flashvars.folderPath = "../js/scroller/";
			var params = {};
			params.scale = "noscale";
			params.salign = "tl";
			params.wmode = "transparent";
			params.allowscriptaccress = "sameDomain";
			var attributes = {};
			swfobject.embedSWF("<?=urlse?>/js/scroller/imagescroller.swf", "ScrollerDiv", "600", "170", "9.0.0", false, flashvars, params, attributes);
		</script>
		</td></tr></table>
		<?
		}}
	}
	?>
	<table width="100%" cellpadding="0" cellspacing="0" border="0" class="categories-wrap">
	<?
	echo '<tr valign="top">';
		if(isset($SUB_CUR_DEP_ARRAY) AND is_array($SUB_CUR_DEP_ARRAY))
		{
			echo '<td width="50%" align="left" valign="bottom">';
				echo '<div class="d1">';
					echo '<a class="a3" href="'.$SUB_CUR_DEP_ARRAY[5]['departmentAlias'].'/">';
					echo '<img src="images/classic/cifrovaya-tehnika.jpg">';
					echo '<br>'.$SUB_CUR_DEP_ARRAY[5]['departmentHeadTitle'];
					echo '</a>';
				echo '</div>';
			echo '</td>';
			echo '<td align="center">';
				echo '<div class="d1">';
					echo '<a class="a3" href="'.$SUB_CUR_DEP_ARRAY[4]['departmentAlias'].'/">';
					echo '<img src="images/classic/bytovaya-tehnika.jpg">';
					echo '<br>'.$SUB_CUR_DEP_ARRAY[4]['departmentHeadTitle'];
					echo '</a>';
				echo '</div>';
		}
		else
		{
			echo '<td width="100%" align="'.($_SERVER['REQUEST_URI'] == '/' ? 'left' : 'center').'">';
			unset($outputCategory['rows']);
			?><div class="categories_main"><?
			foreach($outputCategory as $cat): ?>
	      <div class="category_container">
	        <div class="category_name_container">
	          <div class="category_name">
	            <div class="category_img_wrap">
	              <a href="/<?= $cat['categoryAlias'] ?>" class="category_img">
	                <img src="/images/resource/<?= $cat['categoryImage'] ?>">
	              </a>
	            </div>
	            <div class="d2">
	              <h2><?= $cat['categoryName'] ?></h2>
	            </div>
	          </div>
	        </div>
				</div>
				<? if (!empty($CUR_CAT_ARRAY)): ?>
					<div align=left class="category_links">
						<? for ($j=0; $j<$outputSubCategory[$cat['categoryID']]['rows']; $j++): ?>
							<? $sub_action = $outputSubCategory[$cat['categoryID']][$j]['categoryAlias'].'/'; ?>
							<? $sub_action .= (!empty($getvar['brand'])) ? $getvar['brand'] : ''; ?>
							<a class="a1" href="<?= $sub_action ?>" ><?= $outputSubCategory[$cat['categoryID']][$j]['categoryName'] ?></a><br>
						<? endfor; ?>
					</div>
				<? endif; ?>
			<? endforeach; ?>
			</div>
	  </td>
	<? } ?>
</tr>
</table>
</center>
	<?

	if(!empty($CUR_BRAND_ARRAY['brandName']))
	{
		echo '<br>';
		//echo '<div class="title">'.strtolower($CUR_BRAND_ARRAY['brandName']).'</div>';
		echo '<h1 class="brand">'.$CUR_BRAND_ARRAY['brandName'].'</h1>';
		echo '<div class="hr"></div>';
		if(!empty($CUR_BRAND_ARRAY['brandImage'])) echo '<img align="left" src="images/brand/'.$CUR_BRAND_ARRAY['brandImage'].'" alt="логотип '.$CUR_BRAND_ARRAY['brandName'].'" title="логотип '.$CUR_BRAND_ARRAY['brandName'].'" style="margin-right:10px;margin-bottom:5px;">';
		echo '<div style="text-align:left;margin-bottom:5px;text-align:justify;">'.nl2br($CUR_BRAND_ARRAY['brandDescription']).'</div>';
		echo '<div style="clear:both;padding-bottom:10px;">&nbsp;</div>';
	}

	if($outputArticle['rows'] > 0)
	{
		echo '<br><div style="text-align:left">';
		echo '<div class="title">статьи</div>';
		echo '<HR size="2" color="#ff4709" align="left">';
		echo '</div>';

		for ($i=0; $i<$outputArticle['rows']; $i++)
		{
			if(!empty($outputArticle[$i]['articleImage'])) echo '<img align="left" src="images/article/preview/'.$outputArticle[$i]['articleImage'].'" alt="'.$outputArticle[$i]['articleImageAlt'].'" style="margin:2px 10px 5px 0px;">';
			echo '<div style="text-align:left;"><a href="articles/'.$outputArticle[$i]['articleAlias'].'" class="title">'.$outputArticle[$i]['articleTitle'].'</a></div>';
			echo '<div style="text-align:left;margin-top:15px; margin-bottom:5px">'.$outputArticle[$i]['articleDescription2'].'</div>';
			echo '<div style="clear:both;padding-bottom:10px;">&nbsp;</div>';
		}
	}
	if($outputReview['rows'] > 0)
	{

		echo '<br><div style="text-align:left">';
		echo '<div class="title">обзоры</div>';
		echo '<HR size="2" color="#ff4709" align="left">';
		echo '</div>';
		for ($i=0; $i<$outputReview['rows']; $i++)
		{
			$reviewArray = unserialize($outputReview[$i]['reviewDescription2']);
			if(is_array($reviewArray))
			{
				foreach($reviewArray as $key => $val)
				{
					if(($key == 'cat' AND $url != 'brands') OR ($key == 'brand' AND $url == 'brands')) { $outputReview[$i]['reviewDescription2'] = $val; break; }
				}
			}

			if(!empty($outputReview[$i]['reviewImage'])) echo '<img align="left" src="images/review/preview/'.$outputReview[$i]['reviewImage'].'" alt="'.$outputReview[$i]['reviewImageAlt'].'" style="margin:2px 10px 5px 0px;">';
			echo '<div style="text-align:left;"><a href="obzory/'.$outputReview[$i]['reviewAlias'].'" class="title">'.$outputReview[$i]['reviewTitle'].'</a></div>';
			echo '<div style="text-align:left;margin-top:15px; margin-bottom:5px">'.$outputReview[$i]['reviewDescription2'].'</div>';
			echo '<div style="clear:both;padding-bottom:10px;">&nbsp;</div>';
		}
	}
} else { ?>
	<br>
	<img src="images/classic/title_brand.gif" width="85" height="20" alt="бренды">
	<HR size="2" width="100%" color="#424242" align="left">
	<center>
	<?
	foreach($ddAlphabet_en as $key => $val)
	{
		if(strpos($ACTIVE_LETTERS,'|'.$key.'|') === false AND strpos($ACTIVE_LETTERS,'|'.$val.'|') === false)
		{
			echo '<span class="gray">'.$key.'</span>&#160;';
		}
		else
		{
			if($getvar['letter'] == $val)
			{
				echo '<span class="black">'.$key.'</span>&#160;';
			}
			else
			{
				if($val == 'a') echo '<a class="orange" href="'.$urlve.'brands/" >'.$key.'</a>&#160;';
				else echo '<a class="orange" href="'.$urlve.'brands/'.$val.'" >'.$key.'</a>&#160;';
			}
		}
	}
	if($getvar['letter'] == 'ru')
		echo ' &#160; &#160; &#160; <span class="black">А-Я</span>&#160;';
	else
		echo ' &#160; &#160; &#160; <a class="maroon" href="'.$urlve.'brands/ru" >А-Я</a>&#160;';

	$cellcount=1;
	$maxImgHeight = 0;
	for ($i=0; $i<$outputBrand['rows']; $i++)
	{
		if(!empty($getvar['sub'])) $link = $getvar['sub'].'/'.$outputBrand[$i]['brandAlias'].''; elseif(!empty($getvar['category'])) $link = $getvar['category'].'/'.$outputBrand[$i]['brandAlias'].'.html'; else $link = 'brands/'.$outputBrand[$i]['brandAlias'].'';

		if($cellcount == 1){
			$maxImgHeight = 0;
			for ($c=$i; $c<=$i+4; $c++){
				$image = 'images/brand/'.$outputBrand[$c]['brandImage'];
				$imgInfo = @GetImageSize($image);
				$imgHeight = $imgInfo[1];
				if($imgInfo[0] > 125){
					$coef = ($imgInfo[0]/125);
					$imgHeight = ($imgInfo[1]/$coef);
				}
				if($maxImgHeight < $imgHeight)	$maxImgHeight = round($imgHeight,0);
			}
		}
		echo '<div style="display:table; width:125px; float:left; margin:25px; text-align:center;">';

				if(!empty($outputBrand[$i]['brandImage']))
				{
					echo '<div style="width:125px !important; width:125px; padding:2px;  height:'.$maxImgHeight.'px; border:1px solid #E5E5E5; text-align:center">';
					$this_imgInfo = @getImageSize('images/brand/'.$outputBrand[$i]['brandImage']);
					$width = $this_imgInfo[0];
					$height = $this_imgInfo[1];
					$margintop =0;

					if($width > 125){
						$coef = ($width/125);
						$width = 125;
						$height = round($height/$coef);

					}
					$margintop = floor(($maxImgHeight-$height)/2); if($margintop < 0) $margintop = 0;
					echo '<a href="'.$link.'"><img src="images/brand/'.$outputBrand[$i]['brandImage'].'" alt="логотип '.$outputBrand[$i]['brandName'].'" title="логотип '.$outputBrand[$i]['brandName'].'" style="margin-top:'.$margintop.'px" width="'.$width.'"></a>';
					echo '</div>';
				}
				else{
					echo '<div style="width:125px !important; width:125px; padding:2px;  height:'.$maxImgHeight.'px; border:1px solid #FFF; text-align:center">&nbsp;</div>';
				}

			echo '<div style="margin-top:8px;"><a href="'.$link.'">'.$outputBrand[$i]['brandName'].'</a></div>';
		echo '</div>';

		if($cellcount == 3) {echo '<div style="clear:both; display:block; height:4px"></div>'; $cellcount = 1;}
		else $cellcount++;
	}
	?>
<? } ?>
