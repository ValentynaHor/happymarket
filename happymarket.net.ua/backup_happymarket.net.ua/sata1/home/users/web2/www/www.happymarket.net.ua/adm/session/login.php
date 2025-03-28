<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
<title>Administration Sphere</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="Content-Language" content="en">
<meta http-equiv="Content-Script-Type" content="text/javascript">
<meta http-equiv="Content-Style-Type" content="text/css">
<link type="text/css" rel="stylesheet" href="css/style.css" />
<base href='<?php echo urlse; ?>/adm/' />
<script type="text/javascript" src="js/clock.js"></script>
<script language="JavaScript" src="js/validator.js"></script>
<script language="javascript" type="text/javascript">
function initDynamicOptionLists(){}
</script>
</head>
<body >
<table cellpadding="0" cellspacing="10" width="100%" height="100%" align="center" border="0">
  <tr>
    <td>

<p class="error" align="center"><strong><? echo $nologin; ?></strong></p>
<form name="edit" action="<? echo $sid; ?>" method="post" enctype="multipart/form-data">
<input  type="hidden" name="authentication" value="active">
<table cellpadding="0" cellspacing="10" style="border:1px solid #D2D7DC" width="200" align="center">
  <tr bordercolor="#FFFFFF">
    <td style="border-width:0;" align="left" width="50" class="text">Login:</td>
	<td style="border-width:0;" align="left"><input class="login" type="text" name="userNik" style="width:115px"></td>
  </tr>
  <tr bordercolor="#FFFFFF">
    <td style="border-width:0;" align="left" class="text">Password:</td>
	<td style="border-width:0;" align="left"><input class="login" type="password" name="userPassword"  style="width:115px"></td>
  </tr>
   <tr bordercolor="#FFFFFF">
    <td style="border-width:0;" align="center" class="text" colspan="2"><input class="authentication" type="submit" value="Authentication" size="20"></td>
  </tr>
</table>
</form>
<br />
<br />
<br />
<br />
	</td>
  </tr>
</table>

</body>
</html>