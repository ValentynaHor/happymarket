
<? if(!empty($userArray['userID'])) { 
echo '<div align="center">';
echo '<table width="740" cellpadding="3" cellspacing="2" class="cart_table" border=0>';
echo '<tr align="center">';
	echo '<td width="30px" class="thrift_price">№</td>';
	echo '<td class="thrift_price">товары</td>';
	echo '<td width="15%" class="thrift_price">сумма</td>';
echo '</tr>';
for($i=0; $i<$outputOrder['rows']; $i++)
{
	if($outputOrder[$i]['orderCourse'] == '0.00')
	{
		if($outputOrder[$i]["payMethod"] == '0' AND !empty($outputOrder[$i]["delivery"])) $outputOrder[$i]['orderCourse'] = $outputSetting[0]['courseUSD'];
		elseif($outputOrder[$i]["payMethod"] == '3' OR $outputOrder[$i]["payMethod"] == '1') $outputOrder[$i]['orderCourse'] = $outputSetting[0]['courseNonCashNonNDSUSD'];
		else $outputOrder[$i]['orderCourse'] = $outputSetting[0]['courseNonCashUSD'];
	}
	if($outputOrder[$i]['wareCount'] == '0') $outputOrder[$i]['wareCount'] = 1;

	echo '<tr align="center">';
		echo '<td>'.$outputOrder[$i]['orderGroupID'].'</td>';
		echo '<td align="left">';
			if($outputOrder[$i]['delivery'] == 1) echo "без доставки";
			elseif($outputOrder[$i]['delivery'] == 2) echo "доставка по Киеву";
			elseif($outputOrder[$i]['delivery'] == 3) echo "доставка по Украине";
			else echo "без доставки";
			echo ' | '.formatDate($outputOrder[$i]['timeCreated'], 'datetime');

			$outputOrder[$i]['wareNames'] = del_tags($outputOrder[$i]['wareNames']);
			$arrayID = explode("||",$outputOrder[$i]['wareID']);
			$arrayName = explode("||",$outputOrder[$i]['wareNames']);
			$arrayCount = explode("||",$outputOrder[$i]['wareCount']);
			$arrayPrice = explode("||",$outputOrder[$i]['warePrice']);
	
			echo '<a class="orange" style="display:block;" href="'.$urlve.'order/'.$outputOrder[$i]['orderGroupID'].'">';
			echo '<table width="100%" cellpadding="1" cellspacing="0">';
			for($j=0; $j < count($arrayID); $j++)
			{
				echo '<tr><td width="50%" style="border:0px !important; font-size:11px; color:#e93900;">'.$arrayName[$j].' ['.$arrayCount[$j].' шт.]'.$arrayPos[$j].'</td><td width="15px" align="center" style="border:0px !important; font-size:11px; color:#e93900;">..</td><td align="right" style="border:0px !important; font-size:11px; color:#e93900;">'.round($arrayPrice[$j]*$arrayCount[$j], 2).' грн. (1 шт. - '.round($arrayPrice[$j], 2).' грн.)</td></tr>';
			}
			echo '</table>';
			echo '</a>';
		echo '</td>';
		echo '<td>'.round($outputOrder[$i]['wareSum'], 2).' грн.</td>';
	echo '</tr>';
}
echo '</table>';
echo '</div>';
?>
<?
}
else
{
	include_once('session/login.php');
}
?>