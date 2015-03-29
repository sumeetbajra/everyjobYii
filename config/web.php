<?php

$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'au63y5XBEKEYZQgj9xHZHvPTNsOKtLzp',
        ],
         'image' =>[
                'class' => 'yii\image\ImageDriver',
                'driver' => 'GD',  //GD or Imagick                
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'function'=>[
        'class' => 'app\models\Functions',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
             'viewPath' => '@app/mail',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => false,//set this property to false to send mails to real email addresses
        //comment the following array to send mail using php's mail function
        'transport' => [
            'class' => 'Swift_SmtpTransport',
            'host' => 'smtp.ntc.net.np',
            'username' => 'sbajracharya@mdevsolutions.com',
            'password' => 'nazionale55',
            'port' => '587',
            'encryption' => 'tls',
                        ],
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'urlManager' => [
        'class' => 'yii\web\UrlManager',
        // Disable index.php
        'showScriptName' => false,
        // Disable r= routes
        'enablePrettyUrl' => true,
        'rules' => array(
                'post/view/<id:\d+>/<slug:[a-zA-Z0-9-]+>/'=>'post/view/',
                'user/profile/<user:[a-zA-Z0-9-_]+>/'=>'user/profile/',
                'user/sendmessage/<user:[a-zA-Z0-9-_]+>/'=>'user/sendmessage/',
                '<controller:\w+>/<id:\d+>' => '<controller>/view',
                '<controller:\w+>/<action:\w+>/<id:\d+>' => '<controller>/<action>',
                '<controller:\w+>/<action:\w+>' => '<controller>/<action>',
        ),
        ],        
        'db' => require(__DIR__ . '/db.php'),
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = 'yii\debug\Module';

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = 'yii\gii\Module';
}

return $config;
