<?php
namespace dukt\twitter\web\assets\searchwidget;

use craft\web\AssetBundle;
use craft\web\assets\cp\CpAsset;

/**
 * Class TwitterAsset
 *
 * @author Dukt <support@dukt.net>
 * @since  3.0
 */
class SearchWidgetAsset extends AssetBundle
{
    /**
     * @inheritdoc
     */
    public function init()
    {
        // define the path that your publishable resources live
        $this->sourcePath = '@dukt/twitter/resources';

        // define the dependencies
        $this->depends = [
            CpAsset::class,
        ];

        // define the relative path to CSS/JS files that should be registered with the page
        // when this asset bundle is registered
        $this->js = [
            'js/SearchWidget.js',
        ];

        $this->css = [
            'css/twitter.css',
            'css/widget.css',
        ];

        parent::init();
    }
}