<?php
ob_start();
/**
 * Created by PhpStorm.
 * User: Buminta
 * Date: 11/1/13
 * Time: 3:35 AM
 */
// change the following paths if necessary
    date_default_timezone_set('Asia/Ho_Chi_Minh');
    $yii=dirname(__FILE__).'/framework/yii.php';
    $config=dirname(__FILE__).'/protected/config/main.php';

// remove the following line when in production mode
// defined('YII_DEBUG') or define('YII_DEBUG',true);

require_once($yii);

Yii::createWebApplication($config)->run();

ob_flush();