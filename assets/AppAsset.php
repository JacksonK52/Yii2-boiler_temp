<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * Main application asset bundle.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        "css/bootstrap/styles.css",
        "css/fontawesome/css/all.min.css",
        "css/fontawesome-animation/font-awesome-animation.min.css",
        "css/animate/animate.min.css",
        "css/style.css",
    ];
    public $js = [
        "js/alertNotification.js",
        "js/bootstrap/bootstrap.min.js",
    ];
}
