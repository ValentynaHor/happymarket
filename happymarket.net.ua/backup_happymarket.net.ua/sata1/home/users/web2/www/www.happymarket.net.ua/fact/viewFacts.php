<?
for ($i=0; $i<$outputFact['rows']; $i++)
{
	if(!empty($outputFact[$i]['factImage']))
	{
		$infoImage = @GetImageSize('images/fact/preview/'.$outputFact[$i]['factImage']);
		if($infoImage[0] > 100) $width = 'width="100px;"'; else $width = '';
	}

	if(!empty($outputFact[$i]['factImage'])) echo '<img '.$width.' align="left" src="images/fact/preview/'.$outputFact[$i]['factImage'].'" alt="'.$outputFact[$i]['factImageAlt'].'" style="margin:3px 10px 5px 0px;">';
	echo '<div><a href="facts/'.$outputFact[$i]['factAlias'].'" class="title">'.$outputFact[$i]['factTitle'].'</a></div>';
	echo '<div class="text">'.$outputFact[$i]['factDescription'].'</div>';
	echo '<div style="clear:both;padding-bottom:10px;">&nbsp;</div>';
}

// view pages
if(empty($numPage)) {$numPage = 1;}
$countPages = ceil(@ $outputCount[0]['count(permAll)']/$countEntity);
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
	if($numPage != 1)
	{
		if($numPage == 2) echo '<a href="'.$url.'">назад</a> | ';
		else echo '<a href="'.$url.'/'.($numPage-1).'">назад</a> | ';
	}
	else
	{
		echo 'назад | ';
	}
	if($numPage > $maxPage)
	{
		echo '<a href="'.$url.'/'.($startPage-1).'">'.($startPage-$maxPage).'-'.($startPage-1).'</a> | ';
	}
	for ($p = $startPage; $p < $endPage + 1; $p++)
	{
		if($numPage != 1 and $p == 1)
		{
			echo '<a href="'.$url.'">'.$p.'</a> | ';
		}
		else if($p == $numPage AND $viewModePage != 'all')
		{
			echo ' '.$p.' | ';
		}
		else
		{
			echo '<a href="'.$url.'/'.$p.'">'.$p.'</a> | ';
		}
	}
	if($countPages > $maxPage*($levelPage+1))
	{
		echo '<a href="'.$url.'/'.($endPage+1).'">'.($endPage+1).'-'; if($countPages < $endPage+$maxPage){echo($countPages);}else{echo($endPage+$maxPage);} echo '</a> | ';
	}
	if($numPage != $countPages AND $viewModePage != 'all')
	{
		echo '<a href="'.$url.'/'.($numPage+1).'">вперед</a>';
	}
	else
	{
		echo 'вперед';
	}
	echo '</div>';
}
?>
