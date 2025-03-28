<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">

<html>

<head>

<title><?=$pageTitle?></title>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<meta http-equiv="Content-Language" content="ru" />

<? if(!empty($pageDescription)) echo '<meta name="Description" content="'.$pageDescription.'" />'; ?>

<meta name="Keywords" content="��������-�������,��������,�����,�������,������,����������,����������,������� �������,�������� �������,������� ������,
����-,�����-,��������� ��������,�������������,������������,��������,���������,Bluetooth,
����������������,��������������,��������������,�������������������,GPS ���������,������,��-������,����������,������������,�����, Alpine,Challenger,KENWOOD,
PIONEER,DLS,FOCAL,HERTZ,audison, CENTURION,Challenger,SHERIFF,�������,�������� ����,�������� �����,
��������,MP3/MP4 ������,����������� �������,����������� �����,���������� ������,����������,���������,������,
�������,�������/����� �������,���,��������,�������,��������,���������,Nokia,Samsung,����������,Hi-Fi �������,
������������,��������e��� �������,������� ������� �������,������ ������� �������,���������� �������������,
���������� ������������,�����������,������������,������������,���������� �������,������������� DVD,
��������,������������ �������,����������� ������,������� ��� ���. ������,���/����,�����,������������� ������,
��������,���������� ������,������������,������,�����,����������,���������,�������� ����,�������� ��������,
��������� ����,���������,�������������,������ ��� ���.�����,�������,�����,����,����������,��������������,
��������������,���������,��������� ��� ���������,����������,�������,�������,������ (�������� � ��,������,
���������� �����, �������,���������� ��� ���,�������� � ������">
<meta http-equiv="Content-Style-Type" content="text/css" />

<meta name="Author" CONTENT="Vitaliy Yatsenko" />

<meta name="Author-Email" content="webvit@ukr.net" />

<base href='<?=urlse?>/' />

<link type="text/css" rel="stylesheet" href="css/style.css" />

<script type="text/javascript" src="js/jquery-1.3.2.min.js"></script>



<script type="text/javascript" src="js/lightbox/jquery.lightbox-0.5.js"></script>

<link rel="stylesheet" type="text/css" href="css/jquery.lightbox-0.5.css" media="screen">

<script type="text/javascript" src="js/accordion/jquery.accordion.js"></script>

<script type="text/javascript" src="js/pngFix/jquery.pngFix.pack.js"></script>



<!-- IE8 as IE7 hack -->

<meta  http-equiv="X-UA-Compatible"  content="IE=EmulateIE7">

<script type="text/javascript"> 

$(document).ready(function(){ 

	$(document).pngFix({

		blankgif: 'images/classic/blank.gif'

	}); 

}); 

</script> 

</head>

<body>

<table border="0" width="100%" height="100%" cellpadding="0" cellspacing="0" align="center">

	<tr>

		<td height="272" valign="top">

		<table border="0" width="100%" cellpadding="0" cellspacing="0" align="center">

			<tr>

				<td id="logo_<?=$_SESSION['current_dept'];?>" width="422" height="164"  valign="top">

					<div><a href="<?=urlse?>"><img src="images/classic/blank.gif" style="width:180; height:140px;"></a></div>

				</td>

				<td id="sky" valign="top">

					<div id="skyContentMain">

						<div id="skyContent">

						<?

						for($i=0; $i < $outputDep['rows']; $i++)

						{

							if($outputDep[$i]['parentDepartmentID'] == 'top')

							{

								echo '<div class="depContainer">';

									echo '<a href="'.$outputDep[$i]['departmentAlias'].'/" class="depTitle">'.$outputDep[$i]['departmentHeadTitle'].'</a>';

									echo '<div class="depDescription">'.$outputDep[$i]['departmentName'].'</div>';

								echo '</div>';

							}

						}

						?>

						<br clear="all">

						</div>

						<div class="search">

							<form action="/search" method="get" style="margin-top:0; margin-bottom:0;" enctype="multipart/form-data">

								<input type="text" name="s" value="<?=$search?>" class="searchField">

								<input type="image" src="../images/classic/search.png" class="imgSubmit" width="125" height="95">

								<br clear="all">

								<div style="background:none; margin-right:0px; position:absolute; top:76; left:100;"><a href="/search?m=adv" style="font-size:11px; text-decoration:none">Расширенный поиск</a></div>

							</form>

						</div>

					</div>

				</td>

			</tr>

			<tr>

				<td id="logo2_<?=$_SESSION['current_dept'];?>" valign="top"><div style="font-size:15px; color:#fff; margin-left:16px; margin-top:8px;">Валюта</div></td>

				<td id="menu" valign="top">

					<div class="menuContainer">

					<div class="menuItem" style="background:none; margin-right:0px;"><a href="facts" class="menuItemHref">Новости</a></div>

					<div class="menuItem"><a href="contact" class="menuItemHref">Контакты</a></div>					

					<div class="menuItem"><a href="about" class="menuItemHref">О нас</a></div>

					<div class="menuItem"><a href="delivery" class="menuItemHref">Оплата и доставка</a></div>

					<div class="menuItem"><a href="buy" class="menuItemHref">Как купить?</a></div>

					<div class="menuItem"><a href="pricelist" class="menuItemHref">Прайс-лист</a></div>

					<div class="menuItem"><a href="<?=urlse?>" class="menuItemHref">Главная</a></div>

					</div>

				</td>

			</tr>

			<tr>

				<td id="logo3_<?=$_SESSION['current_dept'];?>" valign="top">

					<form action="<?=$urlse?>" method="post" style="margin-top:10; margin-bottom:0;" enctype="multipart/form-data">

					<select style="font-weight:bold; width:93px" name="currency" onChange="this.form.submit();"><? echo getSelectedDropDown('ddCurrency', $CURRENCY); ?></select>

					</form>

					<div style="margin-top:8px;">Курс: USD = <?=$outputSetting[0]['courseUSD']?> грн., EURO = <?=$outputSetting[0]['courseEURO']?> грн.</div>

				</td>

				<td id="submenu" valign="top">

					<div class="cart">

						<div style="margin-top:5px;">

						<?

						if(empty($_SESSION['incart_count'])) $_SESSION['incart_count'] = 0;

						if(empty($_SESSION['incart_total'])) $_SESSION['incart_total'] = 0;



						$print_total = $_SESSION['incart_total'];

						if(!empty($_SESSION['incart_total']))

						{

							if($CURRENCY == 'usd') $print_total = round($_SESSION['incart_total']/$outputSetting[0]['courseUSD'], 2);

							elseif($CURRENCY == 'euro') $print_total = round($_SESSION['incart_total']/$outputSetting[0]['courseEURO'], 2);

						}



						echo 'В Вашей <a class="orange" href="cart/">корзине</a>:<br>';

						echo 'товаров: '.$_SESSION['incart_count'].'<br>';

						echo 'на сумму: '.$print_total.' '.getValueDropDown('ddCurrency2', $CURRENCY);

						echo '</div>';

						?>

						</div>

					</div>

					<div class="tel-sep-cart"></div>

					<div class="tel">

						<div style="margin-top:14px;">

						<?

						for($i=1; $i<=3; $i++)

						{

							if(!empty($outputSetting[0]['phone'.$i])) echo '<div>'.$outputSetting[0]['phone'.$i].'</div>';

						}

						?>

						</div>

					</div>

					<?

					/*

					if(!empty($outputSetting[0]['address']))

					{

						echo '<div class="tel-sep-cart"></div>';

						echo '<div class="address">';

							echo '<div>'.nl2br($outputSetting[0]['address']).'</div>';

						echo '</div>';

					}

					*/

					?>

				</td>

			</tr>

		</table>

		</td>

	</tr>

	<tr>

		<td valign="top">

		<table border="0" width="100%" height="100%" cellpadding="0" cellspacing="0">

			<tr>

				<td width="253" style="background:#ebf2f6"  valign="top">

					<div class="caption">

						<div style="color:#fff; padding:6 0 0 16">

						<?

						if(!empty($CUR_DEP_ARRAY)) echo $CUR_DEP_ARRAY['departmentName'];

						else echo 'Отделы';

						?>

						</div>

					</div>

					<div class="category_container">

					<?

					if(!empty($CUR_DEP_ARRAY))

					{

						$SUB_DEP = '';

						if($CUR_DEP_ARRAY['parentDepartmentID'] == 'top')

						{

							for($j=0; $j < $outputDep['rows']; $j++)

							{

								if($outputDep[$j]['parentDepartmentID'] == $CUR_DEP_ARRAY['departmentID'])

								{

									echo '<div style="margin-bottom:1px"><a class="category_link" href="'.$outputDep[$j]['departmentAlias'].'/" >'.$outputDep[$j]['departmentName'].'</a></div>';

									$SUB_DEP .= $outputDep[$j]['departmentID'].'|';

								}

							}

						}



						if(empty($SUB_DEP))

						{

					?>

							<script type="text/javascript">

								jQuery().ready(function(){

									jQuery('#categories').accordion({

										header: 'a.category_link',

										selectedClass: 'category_link_sel',

										active: <?=$CUR_CAT_INDEX?>,

										alwaysOpen: false,

										autoheight: false

									});

								});

							</script>

							<?

							echo '<ul class="ul1" id="categories">';

							for ($i=0; $i<$outputCategoryMenu['rows']; $i++)

							{

								echo '<li><a class="category_link" href="'.$outputCategoryMenu[$i]['categoryAlias'].'/">'.$outputCategoryMenu[$i]['categoryName'].'</a><ul class="ul2">';

								for ($j=0; $j<$outputSubCategoryMenu[$outputCategoryMenu[$i]['categoryID']]['rows']; $j++)

								{

									if(!empty($getvar['sub']) AND $outputSubCategoryMenu[$outputCategoryMenu[$i]['categoryID']][$j]['categoryAlias'] == $getvar['sub']) $class = 'class="mg"'; else $class = 'class="m"';

									echo '<li><a '.$class.' href="'.$outputSubCategoryMenu[$outputCategoryMenu[$i]['categoryID']][$j]['categoryAlias'].'/" > '.$outputSubCategoryMenu[$outputCategoryMenu[$i]['categoryID']][$j]['categoryName'].'</a></li>';

								}

								if(empty($outputSubCategoryMenu[$outputCategoryMenu[$i]['categoryID']]['rows']))

								echo '<li>&nbsp;</li>';

	

								echo '</ul></li>';

							}

							echo '</ul>';

						}



					} else {



						for($i=0; $i<$outputDep['rows']; $i++)

						{

							if($outputDep[$i]['parentDepartmentID'] == 'top') echo '<div style="margin-bottom:1px"><a class="category_link" href="'.$outputDep[$i]['departmentAlias'].'/" >'.$outputDep[$i]['departmentName'].'</a></div>';

						}

					}

					?>

					<br clear="all">

					</div>

					

					<div class="caption">

						<div style="color:#fff; padding:6 0 0 16">Авторизация</div>

					</div>

					<div style="color:#FF0000; text-align:center; margin-top:10px">&nbsp;

					<? if($_POST['authentication'] == 'active' AND !empty($nologin)) echo $nologin; ?>

					</div>

					<? if(@$loginStatus != 'yes') { ?>

						<form name="login" action="<?=$lang.$sid?>" method="post" style="margin-top:0; margin-bottom:0;" enctype="multipart/form-data">

						<input type="hidden" name="authentication" value="active">

							<table border="0" cellpadding="0" cellspacing="0" align="center" style="margin-top:5px">

							<tr>

								<td valign="middle"><input type="text" name="userNik"  style="width:150px; height:21px; font-size:11px;"></td>

								<td rowspan="2"><input type="submit" name="Submit" value="Войти" class="loginButton"></td>

							</tr>

							<tr>

								<td valign="middle"><input type="password" name="userPassword" style="width:150px; height:21px; font-size:11px;"></td>

							</tr>

							<tr>

								<td valign="middle" colspan="2">

								<div style="margin:5 0 0 0;background:url('images/classic/button.png') center top no-repeat; width:101px; height:28px; text-align:center; padding-top:5px; font-size:14px;"><a href="registration/" class="black_nostyle">Регистрация</a></div>

								<div><a href="<?=$urlve?>restorepass">Забыли пароль?</a></div>

								</td>

							</tr>

							</table>

						</form>

					<? } else { ?>

						<div style="margin:0 0 20 15">

							<div style="font-weight:bold; color:#000; margin-bottom:5px;">Привет, <?=$userArray['userNik']?>!</div>

							<div>

								<a href="<?=$urlve?>profile">Профиль</a><br>

								<? /*<a href="<?=$urlve?>orders">История заказов</a><br>*/ ?>

								<a href="go/home/userstatus/logout">Выйти</a><br>

							</div>

						</div>

					<? } ?>

					<br><br>	

					

				</td>

				<td valign="top">

					<div class="caption2">

						<div style="color:#000; padding:6 0 0 26; font-weight:bold">

						<? if(!empty($naviStr)) echo $naviStr; else echo '<h1>'.$pageName.'</h1>'; ?>

						</div>

					</div>

					<div id="centerpiece"><? include_once($pageFile); ?></div>

				</td>

			</tr>

		</table>

		</td>

	</tr>

	<tr>

		<td class="footer" align="center" valign="bottom">

			<table border=0 cellpadding=0 cellspacing=0 align="center" height="26">

			<tr>

				<td style="color:#fff;">© 2010. Happy Market. Разработка и продвижение - интернет-агентство Finesse</td>

				<td style="padding-left:40px; " valign="middle"><? include_once('counter2.php'); ?></td>

			</tr>

			</table>

		</td>

	</tr>

</table>

</body>

</html>

