<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <link href="http://fonts.googleapis.com/css?family=Source+Sans+Pro%3A300%2C400%2C700%2C300italic%2C400italic%2C700italic&ver=1.0" type="text/css"
          rel="stylesheet"/>
    <link href="<?php echo Yii::app()->getBaseUrl(true)?>/assets/css/bootstrap.min.css" type="text/css" rel="stylesheet"/>
    <link href="<?php echo Yii::app()->getBaseUrl(true)?>/assets/css/social-buttons.css" type="text/css" rel="stylesheet"/>
    <link href="//netdna.bootstrapcdn.com/font-awesome/4.0.3/css/font-awesome.css" rel="stylesheet">
    <link href="<?php echo Yii::app()->getBaseUrl(true) ?>/assets/css/bootstrap-select.min.css" type="text/css"
          rel="stylesheet"/>
    <link href="<?php echo Yii::app()->getBaseUrl(true)?>/assets/css/style.css" type="text/css" rel="stylesheet"/>
    <script type="text/javascript" src="<?php echo Yii::app()->getBaseUrl(true)?>/assets/js/jquery-2.0.3.min.js"></script>
    <script type="text/javascript" src="<?php echo Yii::app()->getBaseUrl(true)?>/assets/js/bootstrap.min.js"></script>
    <script type="text/javascript"
            src="<?php echo Yii::app()->getBaseUrl(true) ?>/assets/js/bootstrap-select.min.js"></script>
    <script type="text/javascript" src="<?php echo Yii::app()->getBaseUrl(true)?>/assets/js/Line.js"></script>
    <link rel="shortcut icon" href="<?php echo Yii::app()->getBaseUrl(true)?>/assets/images/favicon.ico" type="image/x-icon">
    <link rel="apple-touch-icon" href="<?php echo Yii::app()->getBaseUrl(true)?>/assets/images/favicon.png">
    <title>Confession Line - Create for your Line</title>
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
        <?php echo $content;?>
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
