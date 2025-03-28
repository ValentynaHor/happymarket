<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
<title><?=$pageTitle?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Content-Language" content="ru" />
<? if(!empty($pageDescription)) echo '<meta name="Description" content="'.$pageDescription.'" />'; ?>
<? if(!empty($pageKeywords)) echo '<meta name="Keywords" content="'.$pageKeywords.'">'; ?>
<meta http-equiv="Content-Style-Type" content="text/css" />
<meta name="Author" CONTENT="Vitaliy Yatsenko" />
<meta name="Author-Email" content="webvit@ukr.net" />
<base href='<?=urlse?>/' />
<link href='https://fonts.googleapis.com/css?family=Open+Sans:400,300,700' rel='stylesheet' type='text/css'>
<link href='https://fonts.googleapis.com/css?family=Candal' rel='stylesheet' type='text/css'>
<link href="/images/favicon.ico" rel="shortcut icon" type="image/x-icon">
<link type="text/css" rel="stylesheet" href="css/style.css?ver=1.11" />
<script type="text/javascript" src="js/jquery-1.4.2.min.js"></script>

<script type="text/javascript" src="js/jquery.tools.min.js"></script>
<link rel="stylesheet" type="text/css" href="css/scrollable-horizontal.css" media="screen">
<link rel="stylesheet" type="text/css" href="css/scrollable-navigator.css" media="screen">
<link rel="stylesheet" type="text/css" href="css/scrollable-buttons.css" media="screen">

<script type="text/javascript" src="js/lightbox/jquery.lightbox-0.5.js"></script>
<link rel="stylesheet" type="text/css" href="css/jquery.lightbox-0.5.css" media="screen">
<script type="text/javascript" src="js/accordion/jquery.accordion.js"></script>
<script type="text/javascript" src="js/popups.js"></script>
<script type="text/javascript" src="js/pngFix/jquery.pngFix.pack.js"></script>

<!-- IE8 as IE7 hack -->
<meta  http-equiv="X-UA-Compatible"  content="IE=EmulateIE7">
<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-23617360-1']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>
</head>
<body>
<table border="0" width="100%" height="100%" cellpadding="0" cellspacing="0" align="center">
	<tr>
    <td valign="top" class="header-block">
      <div class="header clearfix">
        <div class="header-top clearfix">
          <div class="logo">
            <a href="<?=urlse?>">
              <img src="images/logo.png" alt="Интернет-Супермаркет Happy Market" title="Интернет-Супермаркет Happy Market">
              <span>Happymarket.net.ua</span>
            </a>
          </div>

          <div id="submenu">
            <div class="cart">
              <?php
                if(empty($_SESSION['incart_count'])) $_SESSION['incart_count'] = 0;
                if(empty($_SESSION['incart_total'])) $_SESSION['incart_total'] = 0;
              ?>
              В Вашей <a class="orange" href="cart/">корзине</a>:<br>
              товаров: <?= $_SESSION['incart_count'] ?><br>
              на сумму: <?= $_SESSION['incart_total'] ?> грн
            </div>
            <div class="tel-sep-cart"></div>
            <div class="tel">
              <div>
                <?php
                for($i=1; $i<=3; $i++) {
    							if(!empty($outputSetting[0]['phone'.$i])) echo '<div>'.$outputSetting[0]['phone'.$i].'</div>';
    						}
                ?>
              </div>
            </div>
          </div>
          <div class="search">
            <form action="/search" method="get" enctype="multipart/form-data">
              <input type="text" name="s" value="" class="searchField" placeholder="Поиск">
              <input type="submit" class="imgSubmit" value="">
              <br clear="all">
              <div class="more-search">
                <a href="/search?m=adv" style="">Расширенный поиск</a>
              </div>
            </form>
          </div>

        </div>
        <div id="menu">
          <div class="menuContainer">
            <div class="menuItem"><a href="facts" class="menuItemHref">Новости</a></div>
            <div class="menuItem"><a href="contact" class="menuItemHref">Контакты</a></div>
            <div class="menuItem"><a href="about" class="menuItemHref">О нас</a></div>
            <div class="menuItem"><a href="delivery" class="menuItemHref">Оплата и доставка</a></div>
            <div class="menuItem"><a href="buy" class="menuItemHref">Как купить?</a></div>
            <div class="menuItem"><a href="pricelist" class="menuItemHref">Прайс-лист</a></div>
            <div class="menuItem"><a href="http://www.happymarket.net.ua" class="menuItemHref">Главная</a></div>
          </div>
        </div>
        <div class="line"></div>
      </div>
		</td>
	</tr>
	<tr>
		<td valign="top">
		<table border="0" width="100%" height="100%" cellpadding="0" cellspacing="0">
			<tr>
        <td class="aside">
          <table cellpadding="0" cellspacing="0"><tr><td class="aside-top">
            <? if($_SERVER['REQUEST_URI'] != '/' && !empty($CUR_DEP_ARRAY) && $url != 'categories'): ?>

              <div class="caption"><table><tr><td class="td1" valign="middle">
                <?= $CUR_DEP_ARRAY['departmentName'] ?>
              </td></tr></table>
              </div>

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

              <div class="category_container"><?
							echo '<ul class="ul1" id="categories">';
							for ($i=0; $i<$outputCategoryMenu['rows']; $i++)
							{
								echo '<li><a class="category_link" href="'.$outputCategoryMenu[$i]['categoryAlias'].'/">'.$outputCategoryMenu[$i]['categoryName'].'</a><ul class="ul2">';
								for ($j=0; $j<$outputSubCategoryMenu[$outputCategoryMenu[$i]['categoryID']]['rows']; $j++)
								{
									if(!empty($getvar['sub']) AND $outputSubCategoryMenu[$outputCategoryMenu[$i]['categoryID']][$j]['categoryAlias'] == $getvar['sub']) {
										$class = 'class="mg"';
										$strBrand = '';
										for($k=0; $k<$outputBrand['rows']; $k++){
										if(strpos($outputSubCategoryMenu[$outputCategoryMenu[$i]['categoryID']][$j]['categoryBrand'], '|'.$outputBrand[$k]['brandID'].'|') !== false AND strpos($outputCategoryMenu[$i]['categoryBrand'], '|'.$outputBrand[$k]['brandID'].'|') !== false)
										{
											$strBrand .= '<a class="a4'; if($getvar['brand'] == $outputBrand[$k]['brandAlias']) $strBrand .= '_act'; $strBrand .= '" href="'.$getvar['sub'].'/'.$outputBrand[$k]['brandAlias'].'">'.$outputBrand[$k]['brandName'].'</a><br>';
										}}
									} else {
										$class = 'class="m"';
										$strBrand = '';
									}
									echo '<li><a '.$class.' href="'.$outputSubCategoryMenu[$outputCategoryMenu[$i]['categoryID']][$j]['categoryAlias'].'/" > '.$outputSubCategoryMenu[$outputCategoryMenu[$i]['categoryID']][$j]['categoryName'].'</a></li>';
									echo $strBrand;
								}
								if(empty($outputSubCategoryMenu[$outputCategoryMenu[$i]['categoryID']]['rows']))
								echo '<li>&nbsp;</li>';

								echo '</ul></li>';
							}
							echo '</ul>';?>
            </div>
            <? else:?>

            <div class="categories-block wrap-hover">
              <div class="caption popup-link-hover" data-selector="#categoriesPopup"><table><tr><td class="td1" valign="middle">
                <i></i>Разделы
              </td></tr></table></div>

              <div class="popup-categories popup-anim-hover" id="categoriesPopup">
                <div class="popup-categories-wrap">
                  <div class="popup-categories-mid">
                    <div class="popup-drop"></div>
                    <ul>
                      <?php for ($i=0; $i<$outputCategoryMenu['rows']; $i++): ?>
                        <li>
                          <a href="<?= $outputCategoryMenu[$i]['categoryAlias'] ?>/"><span class="title-category"><?= $outputCategoryMenu[$i]['categoryName'] ?></span></a>
                        </li>
                      <? endfor; ?>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
            <br>
          <? endif; ?>

          <? if ($_POST['authentication'] == 'active' AND !empty($nologin)): ?>
            <div style="color:#FF0000; text-align:center; margin-top:10px">&nbsp;
              <?= $nologin ?>
            </div>
          <? endif; ?>

					<? if(@$loginStatus != 'yes') { ?>
						<form name="login" action="<?=$lang.$sid?>" method="post" style="margin-top:0; margin-bottom:0;" enctype="multipart/form-data">
						<input type="hidden" name="authentication" value="active">
							<table border="0" cellpadding="0" cellspacing="0" align="center" class="login-block">
							<tr>
								<td valign="middle"><input type="text" name="userNik"></td>
								<td rowspan="2" class="login-but"><input type="submit" name="Submit" value="Войти" class="loginButton btn-main"></td>
							</tr>
							<tr>
								<td valign="middle"><input type="password" name="userPassword"></td>
							</tr>
							<tr>
								<td valign="middle" colspan="2">
								<div class="registration"><a href="registration/">Регистрация</a></div>
								<div class="remember"><a href="<?=$urlve?>restorepass">Забыли пароль?</a></div>
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
        </td></tr>
        <tr><td class="bl-count">

					<div style="text-align:center">
						<?
							include_once('counter2.php');
							echo '<br><br>';
							include_once('counter.php');
						?>
					</div>
        </td></tr></table>
				</td>
				<td valign="top">
          <? if ($_SERVER['REQUEST_URI'] != '/'): ?>
            <div class="caption2">
              <div style="color:#000; padding:6 0 0 26; font-weight:bold">
			          <? if(!empty($naviStr)) echo $naviStr; else echo '<h1>'.$pageName.'</h1>'; ?>
              </div>
            </div>
          <? endif ?>
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
				<td></td>
			</tr>
			</table>
		</td>
	</tr>
</table>
</body>
</html>
