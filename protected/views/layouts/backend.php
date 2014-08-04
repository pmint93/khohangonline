<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

    <link href="http://fonts.googleapis.com/css?family=Source+Sans+Pro%3A300%2C400%2C700%2C300italic%2C400italic%2C700italic&ver=1.0" type="text/css"
          rel="stylesheet"/>
    <link href="<?php echo Yii::app()->getBaseUrl(true) ?>/assets/css/bootstrap.min.css" type="text/css"
          rel="stylesheet"/>
    <link href="<?php echo Yii::app()->getBaseUrl(true) ?>/assets/css/bootstrap-select.min.css" type="text/css"
          rel="stylesheet"/>
    <link href="<?php echo Yii::app()->getBaseUrl(true) ?>/assets/css/jquery.datetimepicker.css" type="text/css"
          rel="stylesheet"/>
    <link href="<?php echo Yii::app()->getBaseUrl(true)?>/assets/css/social-buttons.css" type="text/css" rel="stylesheet"/>
    <link href="<?php echo Yii::app()->getBaseUrl(true) ?>/assets/css/uploadfile.css" type="text/css" rel="stylesheet"/>
    <script type="text/javascript"
            src="<?php echo Yii::app()->getBaseUrl(true) ?>/assets/js/jquery-2.0.3.min.js"></script>
    <script type="text/javascript"
            src="<?php echo Yii::app()->getBaseUrl(true) ?>/assets/js/jquery.tablesorter.js"></script>
    <script type="text/javascript"
            src="<?php echo Yii::app()->getBaseUrl(true) ?>/assets/js/jquery.tablesorter.pager.js"></script>
    <script type="text/javascript"
            src="<?php echo Yii::app()->getBaseUrl(true) ?>/assets/js/jquery.tablesorter.widgets.js"></script>
    <script type="text/javascript" src="<?php echo Yii::app()->getBaseUrl(true) ?>/assets/js/bootstrap.min.js"></script>
    <script type="text/javascript"
            src="<?php echo Yii::app()->getBaseUrl(true) ?>/assets/js/bootstrap-select.min.js"></script>
    <script type="text/javascript"
            src="<?php echo Yii::app()->getBaseUrl(true) ?>/assets/js/jquery.datetimepicker.js"></script>
    <script type="text/javascript"
            src="<?php echo Yii::app()->getBaseUrl(true) ?>/assets/js/jquery.uploadfile.min.js"></script>
    <link href="<?php echo Yii::app()->getBaseUrl(true) ?>/assets/css/style.css" type="text/css" rel="stylesheet"/>
    <title>Confession Line - Create for your Line</title>
</head>
<body>
<div id="wrapper">
    <div id="header">
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
        <div class="navbar-header" style="display: inline-block; vertical-align: top;">
<!--            <a class="navbar-brand" href="--><?php //Yii::app()->getBaseUrl(true); ?><!--/admin"><img-->
<!--                    src="--><?php //echo Yii::app()->getBaseUrl(true) ?><!--/assets/images/logo_c.png"></a>-->
        </div>
        <div class="navbar-menu">
            <ul style="display: inline-block; padding: 0px;">
                <?php
                $menu = Auth::getMenu(Yii::app()->session['auth_user']);
                foreach ($menu as $cat => $act) {
                    ?>
                    <li class="dropdown" style="display: inline-block; vertical-align: top;">
                        <div  data-toggle="dropdown"
                           class="dropdown-toggle" style="cursor: pointer; color: #fff;"><?php echo $cat; ?><span class="caret"></span></div>
                        <ul class="dropdown-menu pull-left list_drop" role="menu"
                            style="background: #fff; margin-right: 5px; padding: 10px 5px; white-space: nowrap; max-width: none; min-width: 80px; box-shadow: 0 2px 2px 0 rgba(0, 0, 0, 0.1),0 1px 0 0 rgba(0, 0, 0, 0.1);">
                            <?php
                            foreach ($act as $key => $value) {
                                ?>
                                <li>
                                    <a href="<?php echo Yii::app()->getBaseUrl(true) . "/" . $value['controller'] . "/" . $value['action']; ?>"><?php echo $key; ?></a>
                                </li>
                            <?php
                            }
                            ?>
                        </ul>
                    </li>
                <?php
                }
                ?>
            </ul>
        </div>
    </div>
    <?php echo $content; ?>
</div>
</body>
</html>
<script>
    $(".notification").bind("click",function(){
        $(".notification").hide();
    });
    $("#NotificationJS").bind("click",function(){
        $("#NotificationJS").removeClass("notification");
        $("#NotificationJS").hide();
    });
    Notification = {
        show: function(msg){
            $("#NotificationJS").removeClass("notification");
            $("#NotificationJS").html(msg+"<span class='close'>x</span>");
            $("#NotificationJS").show();
            $("#NotificationJS").addClass("notification");
        }
    }
</script>