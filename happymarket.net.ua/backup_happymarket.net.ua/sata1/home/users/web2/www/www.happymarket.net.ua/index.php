<?php
session_start();
header('Content-Type: text/html; charset=utf-8');
define ('sitetype','client');
include_once('lib/config.php');
include_once('lib/coreDataSource.php');
include_once('lib/loader.php');
include_once('lib/commonMethods.php');
include_once('lib/clientController.php');
include_once('core/header.php');
?>
