<?php
function connectDB(){
 $connectdb = @mysql_pconnect(db_host, db_user, db_pass) or die ("Ошибка соединения с БД!");
 @mysql_query ('SET NAMES UTF8') or die ("Ошибка соединения с БД!");
 @mysql_query ('SET CHARACTER SET UTF8') or die ("Ошибка соединения с БД!");
 $selectdb = @mysql_select_db(db_name) or die ("БД не выбрана!");;
}

$globalInsertID = '';
$globalInsertAutoID = '';

function saveData($input){
	connectDB();

    if (empty($input['query'])) {
	    $entityID = $input['entityID'];
	    //set time add end save
	    if (empty($entityID))
	    {
		    if(empty($input[$input['tableName'].'_timeCreated']))
		    {
			    $input[$input['tableName'].'_timeCreated'] = getNewDate();
		    }
	    }
	    elseif(!empty($input['timeSaved']))
	    {
		    $input[$input['tableName'].'_timeSaved'] = $input['timeSaved'];
	    }
	    else
	    {
		    $input[$input['tableName'].'_timeSaved'] = getNewDate();
	    }
	    //set nаme and values fields database
	    $fieldsNames = '';
	    $fieldsValues = '';
	    $fieldsNamesValues = '';
	    $comma = '';
	    while ( list($inputName, $inputValue) = each($input) )
	    {
		    if (strstr($inputName,$input['tableName']."_"))
		    {
			    $explode = explode("_",$inputName);
			    $fieldsNames .= $comma.$explode[1];
			    if(is_array($inputValue))
			    {
				    while (list($inArrayName, $inArrayValue) = each($inputValue))
				    {
					    $inString .= '<'.$inArrayName.'>'.$inArrayValue.'</'.$inArrayName.'>';
				    }
				    $inputValue = $inString;
			    }
			    $inString ='';
			    $inputValue = addslashes($inputValue);
			    $fieldsValues .= $comma."'".$inputValue."'";
			    $fieldsNamesValues .= $comma.$explode[1]."="."'".$inputValue."'";
			    $comma = ',';
		    }
	    }
	    //query (insert or update) to database 
		if (empty($entityID))
		{
			if ($input['auto_increment']=='yes'){$entityID="";}
			else{$entityID = getNewID();}
			$query = "insert into table_".$input['tableName']." (".$input['tableName']."ID,".$fieldsNames.") values ('".$entityID."',".$fieldsValues.")";
		}
		else
		{
			$query = "update table_".$input['tableName']." set ".$fieldsNamesValues." where ".$input['tableName']."ID='".$entityID."'";
		}

		global $globalInsertID;
		$globalInsertID = $entityID;
    } else {
        $query = $input['query'];
    }

	//print_r($query);print_r('<br>***<br>');
	if(mysql_query($query) AND empty($input['entityID']))
	{
		global $globalInsertAutoID;
		$globalInsertAutoID = mysql_insert_id();

		return $resultMessage = "okSave";
	}
	elseif(mysql_query($query) AND !empty($input['entityID']))
	{
		return $resultMessage = "okEdit";
	}
	else
	{
		return $resultMessage = "error";
	}
}
function saveArray($input){
	connectDB();
	$tempInput = $input;
	for ($k=0; $k < count($input['arrayID']); $k++)
	{
		//print_r($input['arrayID'][$k]);
		$input = $tempInput;
		$input1 = $input;
		while ( list($inputName1, $inputValue1) = each($input1) )
		{
			if (strstr($inputName1,$input['tableName']."_") AND is_array($inputValue1))
			{
				$temp[$inputName1] = $inputValue1;
				
				$input[$inputName1] = $inputValue1[$k];
			}
		}
		
		$entityID = $input['arrayID'][$k];
		//set name and values fields database
		$fieldsNames = '';
		$fieldsValues = '';
		$fieldsNamesValues = '';
		$comma = '';
		$input[$input['tableName'].'_timeSaved'] = getNewDate();
		
		while ( list($inputName, $inputValue) = each($input) )
		{
			if (strstr($inputName,$input['tableName']."_"))
			{
				$explode = explode ("_",$inputName);
				$fieldsNames .= $comma.$explode[1];
				if(is_array($inputValue))
				{
					while (list($inArrayName, $inArrayValue) = each($inputValue))
					{
						$inString .= '<'.$inArrayName.'>'.$inArrayValue.'</'.$inArrayName.'>';
					}
					$inputValue = $inString;
				}
				$inString ='';
				//print_r($inputValue);
				$inputValue = addslashes($inputValue);
				
				$fieldsValues .= $comma."'".$inputValue."'";
				$fieldsNamesValues .= $comma.$explode[1]."="."'".$inputValue."'";
				$comma = ',';
			}
		}
		
		//query (insert or update) to database 
		$query = "update table_".$input['tableName']." set ".$fieldsNamesValues." where ".$input['tableName']."ID='".$entityID."'";
		//print_r($query);print_r('<br>***<br>');
		$result = mysql_query($query);
	}//for
}

function getData($input){
	connectDB();
	if (sitetype == 'client' AND empty($input['permAll'])) {$input['filter'] .= " AND permAll = '1'";}
	if (empty($input['select'])) {$input['select']='*';}
	if(!empty($input['group']))
		$query = "select ".$input['select']." from table_".$input['tableName']." ".$input['group']." having 1=1 ".$input['filter']." ".$input['sort']." ".$input['limit'];
		//$query = "select ".$input['select']." from table_".$input['tableName']." ".$input['group']." having 1=1 ".$input['filter']." ".$input['limit'];
	else
		$query = "select ".$input['select']." from table_".$input['tableName']." where 1=1 ".$input['filter']." ".$input['sort']." ".$input['limit'];

	//$query = "select ".$input['select']." from table_".$input['tableName']." where 1=1 ".$input['filter']." ".$input['sort']." ".$input['limit'];
	//$query = "select ".$input['select']." from table_".$input['tableName']." where 1=1 ".$input['filter']." ".$input['sort']." ".$input['limit'];
	//print_r($query);print_r('<br>***<br>');
	$result = mysql_query($query);
	
	$num_results = 0;
	$num_fields = 0;

	if(!empty($result))
	{
		$num_results = mysql_num_rows($result);
		$num_fields = mysql_num_fields($result);
	}
		
	for ($i=0; $i< $num_results; $i++)
	{
		$row = mysql_fetch_row($result);

		for ($j=0; $j< $num_fields; $j++)
		{
			$field_name[$j] = mysql_field_name($result, $j);
			$$field_name[$j]=$row[$j];
			$$field_name[$j] = stripslashes($$field_name[$j]);
			
			global $langDefault;
			if($input['lang'] != 'no') $checkLangTags = strstr($$field_name[$j], '<'.$langDefault.'>');
			else $checkLangTags = '';
			if(!empty($checkLangTags))
			{
				//print_r($langDefault);echo '<br>------------------<br>';
				global $outputLang;
				for($lg=0; $lg < $outputLang['rows']; $lg++)
				{
					$$field_name[$j] = str_replace("\n","{n}",$$field_name[$j]);
					preg_match("|<".$outputLang[$lg]['langAlias'].">(.*)<\/".$outputLang[$lg]['langAlias'].">|U", $$field_name[$j], $inArray);
					$inArray[1] = str_replace("{n}","\n",$inArray[1]);
					$output[$i][$field_name[$j]][$outputLang[$lg]['langAlias']] = $inArray[1];
				}
			}
			else
			{
				$output[$i][$field_name[$j]] = $$field_name[$j];
			}
		}
	}

	$output['rows'] = $num_results;
	$input='';
	return $output;
}

function delData($input){
	connectDB();
	if (!empty($input['filter']))
	{
		$query = "delete from table_".$input['tableName']." where 1=1 ".$input['filter'];
	}
	//print_r($query."<br>");
	$result = mysql_query($query);
}



function getFilter($input)
{
	$filter = '';
	while ( list($inputName, $inputValue) = each($input) )
	{
		if (strstr($inputName,"filter_"))
		{
			$explode = explode ("_",$inputName);
			$inputName = $explode[1];
			$filter .= " AND ".$inputName."='".$inputValue."'";
		}
	}
	$output = $filter;
	return $output;
}

function getFilters($input)
{
	$filter = '';
	while ( list($inputName, $inputValue) = each($input) )
	{
		if (strstr($inputName,"filter_"))
		{
			$explode = explode ("_",$inputName);
			$inputName = $explode[1];
			$or = "";
			for($c=0; $c < count($inputValue); $c++)
			{
				//print_r($input);
				$filter .= " ".$or." ".$inputName."='".$inputValue[$c]."'";
				$or = "OR";
			}
		}
	}
	$output = " AND (".$filter.")";
	return $output;
}

function sortData($input)
{
	while ( list($inputName, $inputValue) = each($input) )
	{
		if (strstr($inputName,"sort_"))
		{
			$explode = explode ("_",$inputName);
			$inputName = $explode[1];
			$sort = " order by ".$inputName." ".$inputValue."";
		}
	}
	$output = $sort;
	return $output;
}
function printLang($stringLang, $paramLang)
{
	global $outputLang;
	for ($i=0; $i < $outputLang['rows']; $i++)
	{	
		$strLang = $stringLang;
		$output .= str_replace('{langAlias}',$outputLang[$i]['langAlias'],$strLang);
		foreach($paramLang as $key => $value)
		{
			if(is_array($value)) $textLang = $value[$outputLang[$i]['langAlias']];
			else $textLang = $value; 
			
			$output = str_replace('{'.$key.'}',$textLang,$output);
		}
	}
	return $output;
}

function lang($stringLang)
{
	global $outputLang;
	for ($i=0; $i < $outputLang['rows']; $i++)
	{	
		if(is_array($stringLang))
		{
			global $langDefault, $lang;
			if($outputLang[$i]['langAlias'] == $lang) $output  = $stringLang[$lang];
			if(empty($output)) $output  = $stringLang[$langDefault];
		}
		else
		{
			$output  = $stringLang;
		}
	}
	return $output;
}

function getCode($codes)
{
	global $langDefault, $lang, $code;
	if(empty($lang)) $codeLang = $langDefault; else $codeLang = $lang;
	$input['tableName'] = 'dictionary';
	$filterCode = implode("' OR  dictionaryAlias = '",$codes);
	$input['filter'] = "AND ( dictionaryAlias = '".$filterCode."' )";
	$outputCode = getData($input);
	foreach($outputCode as $key=>$value)
	{
		if(!empty($value['dictionaryAlias']))
		{
			$code[$value['dictionaryAlias']] = $value['dictionaryText'][$codeLang];
		
		}
		if(empty($code[$value['dictionaryAlias']])) $code[$value['dictionaryAlias']] = $value['dictionaryText'][$langDefault];
	}
}
/*
function createField($input){
	$query = "ALTER TABLE `table_".$input['field_fieldTable']."` ADD `".$input['field_fieldName']."` ".$input['field_fieldType']." NOT NULL ;";
	$result = mysql_query($query);
}
function changeField($input){
	$query = "ALTER TABLE `table_".$input['field_fieldTable']."` CHANGE `".$input['field_fieldName']."` `".$input['field_fieldName']."` ".$input['field_fieldType']." NOT NULL ;";
	$result = mysql_query($query);
}

function dropTable($input){
	$output = getData($input);
	if ($output[0]['parentCategoryID']=='top')
	{
		$query = "drop table `table_".$output[0]['categoryAlias']."`";
		$result = mysql_query($query);
	}
}

function dropField($input){
	$output = getData($input);
	$query = "alter table `table_".$output[0]['fieldTable']."` drop `".$output[0]['fieldName']."`";
	$result = mysql_query($query);
}
*/
?>
