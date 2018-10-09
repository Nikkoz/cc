<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Class Select2Asset
 * @package admin\assets
 */
class Select2Asset extends AssetBundle {
    /**
     * @var string
     */
    public $sourcePath = '@backend/assets/select2';
    /**
     * @var array
     */
    public $css = [
		'select2.min.css',
	];
    /**
     * @var array
     */
    public $js = [
		'select2.full.min.js',
	];
    /**
     * @var array
     */
    public $depends = [
		'backend\assets\AppAsset',
	];
}