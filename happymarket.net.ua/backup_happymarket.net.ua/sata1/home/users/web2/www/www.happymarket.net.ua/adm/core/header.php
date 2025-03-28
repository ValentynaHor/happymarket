<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
<title>Happymarket - Administration Sphere</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="Content-Language" content="en">
<meta http-equiv="Content-Script-Type" content="text/javascript">
<meta http-equiv="Content-Style-Type" content="text/css">
<link type="text/css" rel="stylesheet" href="css/style.css" />
<base href='<?php echo urlse; ?>/adm/' />
<script type="text/javascript" src="js/clock.js"></script>
<script language="JavaScript" src="js/validator.js"></script>
<script language="JavaScript" type="text/javascript" src="js/icon.js"></script>
<? if($url == 'manageContentPage' OR $url == 'manageDepartment' OR $url == 'manageSubCategory') { ?>
	<script type="text/javascript" src="<?=urlse?>/ckeditor/ckeditor.js"></script>
	<script src="<?=urlse?>/ckeditor/_samples/sample.js" type="text/javascript"></script>
	<link href="<?=urlse?>/ckeditor/_samples/sample.css" rel="stylesheet" type="text/css" />
	<!--
	Copyright (c) 2003-2010, CKSource - Frederico Knabben. All rights reserved.
	For licensing, see LICENSE.html or http://ckeditor.com/license
	-->
<? } ?>
<script language="javascript" type="text/javascript">
function initDynamicOptionLists(){}
</script>
</head>
<body onLoad="initDynamicOptionLists()" topmargin="0px" leftmargin="0px" rightmargin="0px" bottommargin="0px" >
<? include_once('js/menu.php'); ?>
<table width="100%" height="33" cellpadding="0" cellspacing="0" background="img/top.gif">
  <tr>
    <td width="380" valign="middle" style="padding-left:20px; font-size:16px; color:#7C8DA3;"><b>happymarket.<small>net.ua</small></b></td>
	<td align="right" id="time" class="clock"><script type="text/javascript">startClock();</script></td>
	<td width="15" nowrap></td>
  </tr>
</table>
<br>
<table align="center" width="98%" height="520" cellpadding="0" cellspacing="0" style="border:1px solid #D2D7DC" >
  <tr>
  	<td class="title">
	<?php
		//if($url == 'manageResource' OR $url == 'manageResources') echo $id_to_name[$getvar['category']].'&nbsp;/&nbsp;'.$id_to_name[$getvar['sub']].'&nbsp;/&nbsp;'; else 
		echo $pageTitle;
	?>
	</td>
  </tr>
  <tr>
    <td align="center" bordercolor="#FFFFFF" valign="top" style="padding:25px;">
	<? include_once($pathFile); ?>
	</td>
  </tr>
</table>
</body>
</html>