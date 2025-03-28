<?php

/* === FUNCTIONS === */

/* === FUNCTIONS === */

function arrayToList($array_var) {
    for ($i = 0; $i <= $array_var['rows'] - 1; $i++) {

        $res_arr[] = $array_var[$i]['categoryID'];
    }

    $res_str = implode(', ', $res_arr);

    return $res_str;
}

if ($url == 'repair' AND isset($getvar['op']))
{
	// count msgs in theme
	if($getvar['op'] == "")
	{
		$resultOutput = "";
	}
    if ($getvar['op'] == 'clearTechnix')
    {
        $departments = "4,5";

        $categories = getData(array(
            'tableName' => 'category',
            'select'    => '`categoryID`',
            'filter'    => "AND `categoryDepartment` IN ({$departments})",
        ));

        $cats_filter = arrayToList($categories);

        $sub_categories = getData(array(
            'tableName' => 'category',
            'select'    => '`categoryID`',
            'filter'    => "AND `parentCategoryID` IN ({$cats_filter})",
        ));

        $sub_filter = arrayToList($sub_categories);

        if (!empty($cats_filter)) {
            $resources = delData(array(
                'tableName' => 'resource',
                'filter'    => "AND `categoryID` IN ({$cats_filter})",
            ));

            $cats_to_del = $cats_filter.", ".$sub_filter;

            $del_cats = delData(array(
                'tableName' => 'category',
                'filter'    => "AND `categoryID` IN ({$cats_to_del})",
            ));
        }

        if (!empty($departments)) {
            $del_departments = delData(array(
                'tableName' => 'department',
                'filter'     => "AND `departmentID` IN ({$departments})",
            ));
        }

        header("location: ".$_SERVER['HTTP_REFERER']);
    }
}
?>