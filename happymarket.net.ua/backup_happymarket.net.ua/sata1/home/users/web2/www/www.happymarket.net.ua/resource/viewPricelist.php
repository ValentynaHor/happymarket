<?
//if($depAlias == 'otdel-avtomobilnyh-aksessuarov') 
$class = 'class="a2"';
//else $class = '';
echo '<div class="d4">';
for($i=0; $i<$outputDep['rows']; $i++)
{
	if($outputDep[$i]['parentDepartmentID'] == 'top')
	{
		$FLAG = '';
		for($j=0; $j<$outputDep['rows']; $j++)
		{
			if($outputDep[$j]['parentDepartmentID'] == $outputDep[$i]['departmentID'])
			{
				if($depAlias == $outputDep[$j]['departmentAlias'])
					echo '<h1>'.$outputDep[$j]['departmentName'].'</h1>&nbsp;&nbsp;&nbsp;';
				else
					echo '<a '.$class.' href="pricelist/'.$outputDep[$j]['departmentAlias'].'/">'.$outputDep[$j]['departmentName'].'</a>&nbsp;&nbsp;&nbsp;';

				$FLAG .= $outputDep[$j]['departmentID'].'|';
			}
		}

		if(empty($FLAG))
		{
			if($depAlias == $outputDep[$i]['departmentAlias'])
				echo '<h1>'.$outputDep[$i]['departmentName'].'</h1>&nbsp;&nbsp;&nbsp;';
			else
				echo '<a '.$class.' href="pricelist/'.$outputDep[$i]['departmentAlias'].'/">'.$outputDep[$i]['departmentName'].'</a>&nbsp;&nbsp;&nbsp;';
		}
	}
}
echo '</div>';
echo '<div style="padding-top:30px; padding-left:50px; padding-right:50px;">';
if(!empty($alias))
{
	for($i=0; $i<$cat[$depAlias]['rows']; $i++)
	{
		echo '<div><a '.$class.' href="pricelist/'.$cat[$depAlias][$i]['categoryAlias'].'/">'.$cat[$depAlias][$i]['categoryName'].'</a></div>';
		if($cat[$depAlias][$i]['categoryAlias'] == $catAlias)
		{
			for($j=0; $j<$sub[$catAlias]['rows']; $j++)
			{
				echo '<div style="padding-left:20px;"><a '.$class.' href="pricelist/'.$sub[$catAlias][$j]['categoryAlias'].'/">'.$sub[$catAlias][$j]['categoryName'].'</a></div>';
				if($sub[$catAlias][$j]['categoryAlias'] == $subCatAlias)
				{
					for($k=0; $k<$resource[$subCatAlias]['rows']; $k++)
					{
						echo '<div style="float:left; padding:0px 0px 1px 40px;">'.$resource[$subCatAlias][$k]['resourceName'].'</div><div style="float:right;">'.$resource[$subCatAlias][$k]['resourcePrice'].' '.getValueDropDown('ddCurrency2',$CURRENCY).'</div>';
						echo '<div style="clear:both; margin:0px 0px 0px 38px; border-top:1px solid #999999;"></div>';
					}
				}
			}
		}
	}
}
echo '</div>';
?>