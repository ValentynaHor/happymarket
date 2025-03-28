<?php
require_once "../js/JsHttpRequest/JsHttpRequest.php";
require_once "../../lib/config.php";
require_once "../../lib/coreDataSource.php";
require_once "../../lib/loader.php";
$JsHttpRequest =& new JsHttpRequest("utf-8");
$selectCategories = @$_REQUEST['categories'];
$selectCategory =  @$_REQUEST['category'];
$wareName =  @$_REQUEST['searchWareName'];
$wareID =  @$_REQUEST['selectWareID'];
$numWare =  @$_REQUEST['numWare'];

if(!empty($wareName))
{
	$wareName = eregi_replace("[  ]+"," ",trim($wareName));
	$wareName = explode(' ',$wareName);
	$arrayWares = '';
	$more = '';
	$resultWares = '';
	$global_i = 0;
	if($global_i < 10)
	{
		$inputWare = '';
		$searchNameFilter = '';
		$inputWare['tableName'] = 'resource';
		//$inputWare['select'] = 'resourceID, resourceName, categoryID, subCategoryID ';
		$inputWare['select'] = 'resourceID, resourceName ';
		$inputWare['limit'] = ' limit 11 ';
		for($i=0; $i < count($wareName); $i++)
		{
			$searchNameFilter .=  " AND resourceName like '%".$wareName[$i]."%'";
		}
		$inputWare['filter'] = $searchNameFilter;
		$outputWare = getData($inputWare);
		for($i=0; $i < $outputWare['rows']; $i++)
		{
			
			if($global_i < 10)
			{
				$resultWares .= '<div id="move" onclick="javascript: selectWare(\''.$outputWare[$i]["resourceID"].'\',\''.$category.'\', '.$numWare.')">'.$outputWare[$i]["resourceName"].'</div>';
				$global_i ++;
			}
			else $more = '&middot;&middot;&middot;&middot;&middot;';
		}
	}
	if(!empty($resultWares)) 
	{
		$resultWares = '<div style="border-right:3px solid #EEEEEE; border-bottom:3px solid #EEEEEE; position:absolute;  background-color:white; "><div style=" padding:3px 5px 3px 5px; line-height:17px; text-align:left; border:1px solid #B9B9B9; margin-left:1px;">'.$resultWares.'<div style="width:256px; font-size:18px;">'.$more.'</div></div></div>';	
	}
	$GLOBALS['_RESULT'] = array("resultSearch" => $resultWares);
}
else if(!empty($wareID))
{
	include_once('../../lib/commonMethods.php');
	$inputWare['tableName'] = 'resource';
	$inputWare['select'] = 'resourceID, resourceName, resourcePrice, categoryID, subCategoryID, presence';
	$inputWare['limit'] = ' limit 1 ';
	$inputWare['filter_resourceID'] = $wareID;
	$inputWare['filter'] = getFilter($inputWare);
	$outputWare = getData($inputWare);
	
	$orderCource =  @$_REQUEST['cource'];
	$resultWare = '<td style="border:1px solid #E1E4E7; background-color:white;"><img src="img/marker.gif">
	<input type="hidden" name="order_wareID['.$numWare.']" value="'.$outputWare[0]['resourceID'].'">
	<input type="hidden" name="order_wareCategory['.$numWare.']" value="'.$outputWare[0]['categoryID'].'">
	<input type="hidden" name="order_wareSubCategory['.$numWare.']" value="'.$outputWare[0]['subCategoryID'].'">
	</td><td>#'.($numWare+1).'</td><td><input name="order_wareName['.$numWare.']" value="'.$outputWare[0]['resourceName'].'" type="text" autocomplete="off" style="width:270px;" onkeydown=\'thisobject = this; window.setTimeout("searchWare(thisobject.value,'.$numWare.')",100)\' onblur="hiddenResult(this,'.$numWare.')">
	<div id="result'.$numWare.'"></div></td><td>'.getValueDropDown('ddPresenceAdmin', $outputWare[0]['presence']).'</td><td><input name="order_warePrice['.$numWare.']" value="'.$outputWare[0]['resourcePrice'].'" type="text" style="width:50px;" ></td><td><input name="order_wareCount['.$numWare.']" value="1" type="text" style="width:30px;"></td><td></td>';
	$addNew =  @$_REQUEST['addNew'];
	$resultNewWare = '';
	if($addNew == 1)
	{
		$numWare ++;
		$resultNewWare = '<td style="border:1px solid #E1E4E7; background-color:white;">&nbsp;</td><td>#'.$numWare.'</td><td><input name="wareName'.$numWare.'" value="" type="text" autocomplete="off" style="width:270px;" onkeydown=\'thisobject = this; window.setTimeout("searchWare(thisobject.value,'.$numWare.')",100)\' onblur="hiddenResult(this,'.$numWare.')">
		<div id="result'.$numWare.'"></div></td><td></td><td></td><td></td><td></td>';
	}
	$GLOBALS['_RESULT'] = array("resultSearch" => $resultWare, "resultNewWare" => $resultNewWare, "resultWareName" => $outputWare[0]['resourceName']);
}
?>
<pre>
<div>
<b>Request метод:</b> <?=$_SERVER['REQUEST_METHOD'] . "\n"?>
<b>Loader used:</b> <?=$JsHttpRequest->LOADER . "\n"?>
<b>_REQUEST:</b> <?=$resultWare?><br />
</pre>