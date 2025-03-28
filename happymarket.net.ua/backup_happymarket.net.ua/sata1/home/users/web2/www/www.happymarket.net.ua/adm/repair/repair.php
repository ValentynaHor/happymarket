<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
<title>Administration Sphere</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<meta http-equiv="Content-Language" content="ru">
<meta name="Description" content="Каталог: мониторы, процессоры, материнские платы, видеокарты, винчестеры, память, CD-ROM, CD-RW, DVD, корпуса, клавиатуры, мышки, принтеры, сканеры, модемы...">
<meta name="Keywords" content="компьютерный каталог, интернет-магазин компьютеры Киев, каталог комплектующих, периферия, офисная техника, покупка, продажа, модернизация, доставка">
<meta http-equiv="Content-Script-Type" content="text/javascript">
<meta http-equiv="Content-Style-Type" content="text/css">
<meta name="Author" CONTENT="Vitaliy Yatsenko">
<meta name="Author-Email" content="webvit@ukr.net">
<link type="text/css" rel="stylesheet" href="css/style.css" />
<?php if(@$getvar['userstatus'] == 'logout') echo '<META http-equiv="refresh" content="0; url='.urlse.'/adm/">'; ?>
<base href='<?php echo urlse; ?>/adm/' />
<script type="text/javascript" src="js/clock.js"></script>
<script language="JavaScript" type="text/javascript" src="js/icon.js"></script>
<script language="javascript" type="text/javascript">
function initDynamicOptionLists(){}
</script>
</head>
<body leftmargin="20px" >
<div style="margin:30px">
<a href="?repair/op/incCount">[Подсчет сообщений]</a><br> 	
<a href="?repair/op/delBlank">[Удаление не связаных сообщений, тем]</a><br>
<a href="?repair/op/userMsgRank">[Подсчет сообщений пользователя, ранг]</a><br>
<!--a href="?repair/op/imgSize">[Подгонка превьюшек]</a><br-->
[Подгонка превьюшек]<br>
<? /*<a href="?repair/op/adverCategory">[Подгонка категорий в барахолке]</a><br>*/?>
[Подгонка категорий в барахолке]<br>
<a href="?repair/op/countComments">[Подсчет комментариев(Новости, Статьи, Обзоры, Интервью, Рецепты, Товары)]</a><br>
[Оптимизация барахолки]<br>
<? /* <a href="?repair/op/optimizationFleamarket">[Оптимизация барахолки]</a><br> */?>
[Создание псевдонима в товарах]<br>
<? /* <a href="?repair/op/genAlias">[Создание псевдонима в товарах]</a><br> */?>
[Подгонка фото для пользователей]<br>
<? /* <a href="?repair/op/imgSizeUser">[Подгонка фото для пользователей]</a><br>*/?>
[Создание псевдонима в темах форума]<br>
<? /* <a href="?repair/op/genAliasForum">[Создание псевдонима в темах форума]</a><br>*/?>
<a href="?repair/op/changeCatFleamarket">[Подгонка не связаных категорий в барахолке]</a><br>
<!--a href="?repair/op/imgSizePos">[Подгонка фото для позиций]</a><br-->
[Подгонка фото для позиций]<br>
<!--a href="?repair/op/removeArtikul">[Перенос поля Артикул из менеджера полей]</a><br-->
[Перенос поля Артикул из менеджера полей]<br>
<!--a href="?repair/op/removeResPosImages">[Перенос фото в папки для товаров и позиций]</a><br-->
[Перенос фото в папки для товаров и позиций]<br>
<!--a href="?repair/op/removeHitsalesImages">[Перенос фото для hitsales из ../1/ в ../2/]</a><br-->
[Перенос фото для hitsales из ../1/ в ../2/]<br>
<a href="?repair/op/cutDescriptionArticles">[Добавить предложение в описание статей]</a><br>
<a href="?repair/op/cutDescriptionReviews">[Добавить предложение в описание обзоров]</a><br>
<a href="?repair/op/addCatSubHitsales">[Подгонка категорий для хитов(мы рекомендуем)]</a><br>


<a href="?repair/op/clearTechnix">[Чистка отдела техники]</a><br>
<center>
<br><br>
<div style="background-color:#EFEFEF; width:90%; text-align:left; padding:10px"><?=$resultOutput?></div>

</center>
</body>
</html>
