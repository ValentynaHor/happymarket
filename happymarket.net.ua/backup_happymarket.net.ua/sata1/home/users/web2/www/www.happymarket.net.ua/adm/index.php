<?php
session_start();
header('Content-Type: text/html; charset=utf-8');
define ('sitetype','admin');
include_once('../lib/config.php');
include_once('../lib/data/adminData.php');
include_once('../lib/coreDataSource.php');
include_once('../lib/loader.php');
include_once('../lib/commonMethods.php');
include_once('../lib/adminController.php');
//аutentification

if($loginStatus == 'yes' AND ($userArray['userType'] == 'admin' OR $userArray['userType'] == 'auto'))
{
	include_once('core/header.php');
}
else
{

	include_once('session/login.php');
}
?>
