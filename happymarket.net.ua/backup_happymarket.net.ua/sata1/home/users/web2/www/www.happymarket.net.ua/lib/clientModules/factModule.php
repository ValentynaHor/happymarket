<?php
$input = $_POST;

if($sid === '/facts')
{
	header("HTTP/1.1 301 Moved Permanently"); header("Location: ".urlse."/facts/"); exit();
}

if(!empty($getvar[0]) AND !is_numeric($getvar[0]))
{
	$pageAlias = 'viewFact'; $pageFile = $pageModule.'/'.$pageAlias.'.php';
}
if ($pageAlias == 'viewFacts') 
{	
	$input['tableName'] = "fact";
	$input['select'] = 'count(permAll)';
	$outputCount = getData($input);
	$input = '';

	if(empty($getvar['page'])) $getvar['page'] = $getvar[0];
	$numPage = $getvar['page'];
	if(empty($numPage)) {$numPage = 1;}
	$countEntity = 7;
	if($numPage == 1) { $startPos = 0; } else { $startPos = $numPage*$countEntity - $countEntity; }

	if((!is_numeric($getvar[0]) AND $getvar[0] != '') OR $getvar[0] > ceil($outputCount[0]['count(permAll)']/$countEntity))
	{
		header("HTTP/1.1 404 Not Found"); include_once('content/404.html'); exit();
	}

	$input['tableName'] = "fact";
	$input['sort_timeCreated'] = 'desc';
	$input['sort'] = sortData($input);
	$input['limit'] = ' limit '.$startPos.', '.$countEntity;
	$outputFact = getData($input);
	$input = "";

	/* === [ TITELS] === */
	$pageTitle = 'Новости';
	$pageDescription = ''; $SEP = '';
	for($i=0; $i < 5; $i++)
	{
		if(!empty($outputFact[$i]['factTitle'])) { $pageDescription .= $SEP.$outputFact[$i]['factTitle']; $SEP = ', '; }
	}
}

if ($pageAlias == 'viewFact') 
{
	if(!empty($getvar[0]))
	{
		$factAliasConcate = implode("-", $getvar);
		$input['filter_factAlias'] = $factAliasConcate;
		$input['filter'] = getFilter($input);
		$input['tableName'] = 'fact';
		$outputFact = getData($input);
		$outputFact = $outputFact[0];
		$input = '';

		if(empty($outputFact['factID']))
		{
			header("HTTP/1.1 404 Not Found"); include_once('content/404.html'); exit();
		}

		/* === [ TITELS] === */
		$pageTitle = $outputFact['factTitle'];
		$pageDescription = squash($outputFact['factDescription'], 200, 150);
		$pageKeywords = $outputFact['factKeywords'];
	}
}

$pageTitle .= ' — Интернет-Супермаркет HappyMarket.net.ua';
?>