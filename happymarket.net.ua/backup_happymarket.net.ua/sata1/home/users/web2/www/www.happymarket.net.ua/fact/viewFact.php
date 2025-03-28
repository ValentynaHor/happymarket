<?
	//comment handle variables
	$c_wareID = $outputFact['factID'];
	$c_wareName = urlencode($outputFact['factTitle']);
	$c_wareAlias = $outputFact['factAlias'];
	$c_commentType = 'fact';
?>
<script language="JavaScript" type="text/javascript" src="../js/forum.js"></script>
<h1><?=$outputFact['factTitle']?></h1>
<?
if(!empty($outputFact['factImage'])) echo '<div style="text-align:center;padding:15px 0px 15px 0px;"><img src="images/fact/'.$outputFact['factImage'].'" alt="'.$outputFact['factImageAlt'].'"></div>';
?>
<div class="textArticle" style="margin-top:15px; margin-bottom:15px;"><?=nl2br($outputFact['factText'])?></div>
<a href="facts/" class="more">Все новости</a>