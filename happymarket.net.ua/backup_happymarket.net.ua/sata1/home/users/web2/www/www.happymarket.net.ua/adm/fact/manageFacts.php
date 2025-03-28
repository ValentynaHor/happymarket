[ <a href="/adm/?manageFact/fact/<?php if(!empty($getvar['page'])) {echo '/page/'.$getvar['page'];}?>" >Добавить новость</a> ]
<?
echo '<div style="width:90%;padding-top:5px;">';

	echo '<div style="float:left">';
	echo '<form name="filtration" action="/adm/?manageFacts" method="post" enctype="multipart/form-data">';
	echo '<input type="hidden" name="viewMode" value="filter" />';
		echo 'Поиск:&nbsp; ';
		echo '<input type="text" name="title" style="width:150px;" value="'.$_SESSION['SESSION_FACT']['title'].'" />&nbsp; ';
		echo '<input type="submit" style="height:19px; width:95px; margin-bottom:1px" name="Submit" class="button" value="Фильтровать">';
	echo '</form>';
	echo '</div>';

	// view pages
	if(empty($numPage)) {$numPage = 1;}
	$countPages = ceil(@ $outputCount[0]['count(permAll)']/$countEntity);
	if($outputCount[0]['count(permAll)'] > $countEntity)
	{
		$maxPage = 10;
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

		echo '<div class="grey" style="float:right">Страницы: ';
		if($numPage > $maxPage)
		{
			echo '<span class="grey"><a href="?manageFacts/page/'.($startPage-1).'" class="grey">&#160; &nbsp; ['.($startPage-$maxPage).' - '.($startPage-1).'] &nbsp; &#160;</a></span>';
		}
		for ($p = $startPage; $p < $endPage + 1; $p++)
		{
			if($p == $numPage)
			{
				echo '<a class="greensmall"><strong>&#160;'.$p.'&#160;</strong></a>';
			}
			else if($p == 1)
			{
				echo '<a href="?manageFacts" class="grey">&#160;'.$p.'&#160;</a>';
			}
			else
			{
				echo '<a href="?manageFacts/page/'.$p.'" class="grey">&#160;'.$p.'&#160;</a>';
			}
		}
		if($countPages > $maxPage*($levelPage+1))
		{
			echo '<span class="grey"><a href="?manageFacts/page/'.($endPage+1).'" class="grey">&#160; &nbsp; ['.($endPage+1).' - '; if($countPages < $endPage+$maxPage){echo($countPages);}else{echo($endPage+$maxPage);} echo '] &nbsp; &#160;</a></span>';
		}
		echo '</div>';
	}
echo '</div>';
?>

<table width="90%" border="0"  bordercolor="#FFFFFF" cellpadding="5" cellspacing="1">
<tr>
	<th width="100px">Фото</th>
	<th width="20%">Название</th>
	<th>Краткое описание</th>
	<th width="10%" style="font-size:11px;">Дата создания/<br />Дата изменения</th>
	<th width="7%"></th>
</tr>
<?php 
	for ($i=0; $i<$outputFact['rows']; $i++)
	{
		if(!empty($outputFact[$i]['factImage']))
		{
			$infoImage = @GetImageSize('../images/fact/preview/'.$outputFact[$i]['factImage']);
			if($infoImage[0] > 100) $width = 'width="100px;"'; else $width = '';
		}
	
		echo '<tr>';
		echo '<td style="border:1px solid #E1E4E7;text-align:center">';
			if(!empty($outputFact[$i]['factImage'])) echo '<img '.$width.' src="../images/fact/preview/'.$outputFact[$i]['factImage'].'">'; else echo '&nbsp;';
		echo '</td>';
		echo '<td class="row1" style="color:#7C8DA3"><a class="green" href="/adm/?viewFact/fact/'.$outputFact[$i]['factID'].'" >'.$outputFact[$i]['factTitle'].'</a><div style="margin-top:4px;">'.$outputFact[$i]['factAlias'].'</div></td>';
		echo '<td class="row1" style="text-align:justify">'.$outputFact[$i]['factDescription'].'</td>';
		echo '<td class="row1" style="text-align:center;font-size:11px;">'.formatDate($outputFact[$i]['timeCreated'],'datetime').'<br>'.formatDate($outputFact[$i]['timeSaved'],'datetime').'</td>';
		?>
		<td class="row1" style="text-align:center">
			<a href="/adm/?manageFact/fact/<? echo $outputFact[$i]['factID']; if(!empty($getvar['page'])) {echo '/page/'.$getvar['page'];} ?>" ><img src="img/icon/edit.gif" onClick="this.src=edit_go.src;"  onMouseMove="this.src=edit_on.src;" onMouseOut="this.src=edit_out.src;" width="25" height="28" alt="Редактировать"></a>
			<a href="/adm/?manageFacts/del-fact/<? echo $outputFact[$i]['factID']; if(!empty($getvar['page'])) {echo '/page/'.$getvar['page'];} ?>" onClick="return confirm('Удалить статью ?')" ><img src="img/icon/delete.gif" onClick="this.src=delete_go.src;" onMouseMove="this.src=delete_on.src;" onMouseOut="this.src=delete_out.src;" width="25" height="28" alt="Удалить"></a>
		</td>
		<?
		echo '</tr>';
	}
?>
</table>

