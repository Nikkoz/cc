<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/minimal/purple.css',
        'css/daterangepicker.min.css',
        'css/dataTables.bootstrap.min.css',
        'https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic',
        'css/site.css',
    ];
    public $js = [
        'js/icheck.min.js',
        'js/moment.min.js',
        'js/daterangepicker.min.js',
        'js/jquery.dataTables.min.js',
        'js/dataTables.bootstrap.min.js',
        'js/script.min.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
    ];
}
