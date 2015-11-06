<?php

$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'language' => 'pt-br',
    'components' => [
        'formatter' => [
            'dateFormat' => 'dd/MM/yyyy',
            'datetimeFormat' => 'dd/MM/yyy H:i',
            'timeFormat' => 'H:i',
            'decimalSeparator' => ',',
            'thousandSeparator' => '.',
            'currencyCode' => 'R$',
        ],
        /*
         * Antes de inserir os dados no banco, formatá-los para se tornarem compatíveis com determinados tipos de campos.
         */
        'formatterDB' => [
            'class' => 'yii\i18n\Formatter',
            'dateFormat' => 'php:Y-m-d',
            'datetimeFormat' => 'php:Y-m-d H:i:s',
            'timeFormat' => 'php:H:i:s',
        ],
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'auo9mPQr4YFV-YTdDEhd9EPT8QYufhn6',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
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
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
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
        'db' => require(__DIR__ . '/db.php'),
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
    ];

    /*

    ------------------------------
    CONFIGURAÇÃO EXTRA DOS MODULES
    ------------------------------

    CONCEITO
    - Isto serve apenas para caso você necessite de algumas configurações extras nos módulos em seu ambiente de
    desenvolvimento.

    PASSO A PASSO
    - Crie um arquivo dentro do diretório "app/config" chamado "modules.php".
    - Para funcionar é preciso retornar um array.

    EXEMPLO DE CÓDIGO
    <?php
    return [
        'module' => [
            // Se STRING
            'property' => 'value',
            // Se ARRAY
            'property' => ['value'],
        ],
    ];

    */
    if (file_exists(__DIR__ . '/modules.php')) {
        $modules = require(__DIR__ . '/modules.php');
        foreach ($modules as $module_key => $module) {
            foreach ($module as $property_key => $property) {
                $config['modules'][$module_key][$property_key] = $property;
            }
        }
    }
}

return $config;
