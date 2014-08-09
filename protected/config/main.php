<?php

// uncomment the following to define a path alias
// Yii::setPathOfAlias('local','path/to/local-folder');

// This is the main Web application configuration. Any writable
// CWebApplication properties can be configured here.
return array(
    'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
    'name'=>'Kho hàng online',

    // preloading 'log' component
    'preload'=>array('log'),

    // autoloading model and component classes
    'import'=>array(
        'application.models.*',
        'application.components.*',
    ),

    'defaultController'=>'home',

    // application components
    'components'=>array(
        'db'=>array(
            'connectionString' => 'mysql:host=127.0.0.1;dbname=khohangonline',
            'emulatePrepare' => true,
            'username' => 'root',
            'password' => '',
//            'password' => 'windjs19901993',
            'charset' => 'utf8',
        ),
        'errorHandler'=>array(
            // use 'error' action to display errors
            'errorAction'=>'error',
        ),
        'urlManager'=>array(
            'urlFormat'=>'path',
            'showScriptName'=>false,
            'urlSuffix'=>'.html',
            'rules'=>array(
                '<controller:\w+>/<id:\d+>'=>'<controller>/index',
                '<controller:\w+>/<action:\w+>/<id:\d+>'=>'<controller>/<action>',
                '<controller:\w+>/<action:\w+>'=>'<controller>/<action>',
            ),
        ),
        'log'=>array(
            'class'=>'CLogRouter',
            'routes'=>array(
                array(
                    'class'=>'CFileLogRoute',
                    'levels'=>'error, warning',
                ),
                // uncomment the following to show log messages on web pages
                /*
                array(
                    'class'=>'CWebLogRoute',
                ),
                */
            ),
        ),
    ),

    // application-level parameters that can be accessed
    // using Yii::app()->params['paramName']
    'language'=>'en',
    'params'=>require(dirname(__FILE__).'/params.php'),
);