<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
<title><?=$pageTitle?></title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="Content-Language" content="ru" />
<meta name="Description" content="<?=$pageDescription?>" />
<meta name="Keywords" content="<?=$pageKeywords?>">
<meta http-equiv="Content-Style-Type" content="text/css" />
<meta name="Author" CONTENT="Vitaliy Yatsenko" />
<meta name="Author-Email" content="webvit@ukr.net" />
<base href='<?=urlse?>/' />
<link type="text/css" rel="stylesheet" href="css/style.css?ver=1.0" />
<script type="text/javascript" src="js/jquery-1.4.2.min.js"></script>

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
    
    $(window).resize(function() {
        alignCounter();
    });
    alignCounter();
}); 

function alignCounter(){
    if($('#mainintro').width() >1400)
    {
        var newRightMargin = (($('#mainintro').width() - 1400) /2 ) + 10;
        $('#conterHome').css({'right':newRightMargin+'px'})
    }
    else
    {
        $('#conterHome').css({'right':'10px'})
    }
}
</script>
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
<div id="mainintro" align="center">
        <div id="refCont">
            <div id="smiley">
                <div class="titleHomeMain" style="margin-top:435px">Интернет-супермаркет</div>
                <div class="titleHomeMain2" style="margin-top:0px">Мы сэкономим Ваше время и деньги</div>
            </div>
            <div id="vehicle">
                <a href="<?=$DEP_ARRAY[3]['departmentAlias']?>/"><img src="images/classic/blank.gif" width="244" height="110"></a>
                <div style="position:absolute; top:112; left:38">
                    <a href="<?=$DEP_ARRAY[3]['departmentAlias']?>/" class="titleHome" style=""><?=$DEP_ARRAY[3]['departmentHeadTitle']?></a>
                    <div class="titleHome2" style="margin-top:0px"><h1><?=$DEP_ARRAY[3]['departmentName']?></h1></div>
                </div>
            </div>
            <div id="kids">
                <a href="<?=$DEP_ARRAY[2]['departmentAlias']?>/"><img src="images/classic/blank.gif" width="207" height="180"></a>
                <div style="position:absolute; top:181; left:23">
                    <a href="<?=$DEP_ARRAY[2]['departmentAlias']?>/" class="titleHome" style=""><?=$DEP_ARRAY[2]['departmentHeadTitle']?></a>
                    <div class="titleHome2" style="margin-top:0px"><h1><?=$DEP_ARRAY[2]['departmentName']?></h1></div>
                </div>
            </div>
            <div id="hobby">
                <a href="<?=$DEP_ARRAY[1]['departmentAlias']?>/"><img src="images/classic/blank.gif" width="218" height="150"></a>
                <div style="position:absolute; top:175; left:53">
                    <a href="<?=$DEP_ARRAY[1]['departmentAlias']?>/" class="titleHome" style=""><?=$DEP_ARRAY[1]['departmentHeadTitle']?></a>
                    <div class="titleHome2" style="margin-top:3px"><h1><?=$DEP_ARRAY[1]['departmentName']?></h1></div>
                </div>
            </div>
            <div id="comfort">
                <a href="<?=$DEP_ARRAY[6]['departmentAlias']?>/"><img src="images/classic/blank.gif" width="218" height="150"></a>
                <div style="position:absolute; top:140; left:34">
                    <a href="<?=$DEP_ARRAY[6]['departmentAlias']?>/" class="titleHome" style=""><?=$DEP_ARRAY[6]['departmentHeadTitle']?></a>
                    <div class="titleHome2" style="margin-top:6px"><h1><?=$DEP_ARRAY[6]['departmentName']?></h1></div>
                </div>
            </div>
            <div id="footerHome">© 2010. Happy Market. Разработка и продвижение - интернет-агентство Finesse</div>
        </div>
        <div id="conterHome"><? include_once('counter2.php'); include_once('counter.php'); ?></div>
        </div>
</html>