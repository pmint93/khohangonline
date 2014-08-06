<!DOCTYPE html>
<html  lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<!--    <link href="http://fonts.googleapis.com/css?family=Source+Sans+Pro%3A300%2C400%2C700%2C300italic%2C400italic%2C700italic&ver=1.0" type="text/css" rel="stylesheet"/>-->
    <link href="<?php echo Yii::app()->getBaseUrl(true)?>/assets/css/social-buttons.css" type="text/css" rel="stylesheet"/>
    <link href="<?php echo Yii::app()->getBaseUrl(true) ?>/assets/css/bootstrap-select.min.css" type="text/css"
          rel="stylesheet"/>
    <script type="text/javascript" src="<?php echo Yii::app()->getBaseUrl(true)?>/assets/js/jquery-2.0.3.min.js"></script>
    <script type="text/javascript" src="<?php echo Yii::app()->getBaseUrl(true)?>/assets/js/bootstrap.min.js"></script>
    <script type="text/javascript"
            src="<?php echo Yii::app()->getBaseUrl(true) ?>/assets/js/bootstrap-select.min.js"></script>
    <link rel="shortcut icon" href="<?php echo Yii::app()->getBaseUrl(true)?>/assets/images/favicon.ico" type="image/x-icon">
    <link rel="apple-touch-icon" href="<?php echo Yii::app()->getBaseUrl(true)?>/assets/images/favicon.png">
    <title>Confession Line - Create for your Line</title>

    <!-- ACE Admin -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <!-- basic styles -->
    <link href="<?php echo Yii::app()->getBaseUrl(true)?>/assets/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="<?php echo Yii::app()->getBaseUrl(true)?>/assets/css/font-awesome.min.css" />
    <!--[if IE 7]>
    <link rel="stylesheet" href="<?php echo Yii::app()->getBaseUrl(true)?>/assets/css/font-awesome-ie7.min.css" />
    <![endif]-->

    <!-- page specific plugin styles -->
    <link rel="stylesheet" href="<?php echo Yii::app()->getBaseUrl(true)?>/assets/css/chosen.css" />
    <!-- fonts -->

    <link rel="stylesheet" href="<?php echo Yii::app()->getBaseUrl(true)?>/assets/css/ace-fonts.css" />

    <!-- ace styles -->

    <link rel="stylesheet" href="<?php echo Yii::app()->getBaseUrl(true)?>/assets/css/ace.min.css" />
    <link rel="stylesheet" href="<?php echo Yii::app()->getBaseUrl(true)?>/assets/css/ace-rtl.min.css" />
    <link rel="stylesheet" href="<?php echo Yii::app()->getBaseUrl(true)?>/assets/css/ace-skins.min.css" />

    <!--[if lte IE 8]>
    <link rel="stylesheet" href="<?php echo Yii::app()->getBaseUrl(true)?>/assets/css/ace-ie.min.css" />
    <![endif]-->

    <!-- inline styles related to this page -->

    <!-- ace settings handler -->

    <script src="<?php echo Yii::app()->getBaseUrl(true)?>/assets/js/ace-extra.min.js"></script>

    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->

    <!--[if lt IE 9]>
    <script src="<?php echo Yii::app()->getBaseUrl(true)?>/assets/js/html5shiv.js"></script>
    <script src="<?php echo Yii::app()->getBaseUrl(true)?>/assets/js/respond.min.js"></script>
    <![endif]-->
    <!-- ACE Admin -->

    <link href="<?php echo Yii::app()->getBaseUrl(true)?>/assets/css/style.css" type="text/css" rel="stylesheet"/>
</head>
<body>
<div id="wrapper">
    <div id="NotificationJS" style="display: none;"></div>
    <?php
    if(isset(Yii::app()->params['notification'])&&(Yii::app()->params['notification']!="")){
        ?>
        <div class="notification"><?php echo Yii::app()->params['notification'];?><span class="close">x</span></div>
        <?php
        Yii::app()->session['notification'] = "";
    }
    else if(isset(Yii::app()->session['notification'])&&(Yii::app()->session['notification']!="")){
        ?>
        <div class="notification"><?php if(Yii::app()->session['notification']==1) echo Functions::T("Success"); else echo Yii::app()->session['notification'];?><span class="close">x</span></div>
        <?php
        Yii::app()->session['notification'] = "";
    }
    ?>
    <?php require_once("header.php");?>
    <div class="main-container">
        <script type="text/javascript">
            try{ace.settings.check('main-container' , 'fixed')}catch(e){}
        </script>
        <div class="main-container-inner">
            <?php require_once("menu.php");?>
            <div class="main-content">
                <?php require_once("breadcrumb.php");?>
                <div class="page-content">
                    <?php echo $content;?>
                </div>
            </div>
            <?php require_once("ace_settings.php");?>
        </div>
        <a href="#" id="btn-scroll-up" class="btn-scroll-up btn btn-sm btn-inverse">
            <i class="icon-double-angle-up icon-only bigger-110"></i>
        </a>
    </div>
    <?php require_once("footer.php"); ?>
</div>
</body>
</html>
<script type="text/javascript">
    $(".notification").bind("click",function(){
        $(".notification").hide();
    });
    $("#NotificationJS").bind("click",function(){
        $("#NotificationJS").removeClass("notification");
        $("#NotificationJS").hide();
    });
    _HOST = "<?php echo Yii::app()->getBaseUrl(true);?>";
    Notification = {
        show: function(msg){
            $("#NotificationJS").removeClass("notification");
            $("#NotificationJS").html(msg+"<span class='close'>x</span>");
            $("#NotificationJS").show();
            $("#NotificationJS").addClass("notification");
        }
    }
    $(".tablesorter-filter").addClass('form-control');
    $(".pagedisplay").addClass('form-control');
    $(".pagedisplay").css({
        'width':'200px',
        'display':'inline-block'
    });
    $(".pagesize").addClass('form-control');
    $(".pagesize").css({
        'width':'50px',
        'display':'inline-block',
        'padding': '0px'
    });
</script>
