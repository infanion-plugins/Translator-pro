<?php
/**
 * Translator Pro plugin for Craft CMS 3.x
 *
 * Translator Pro is an easy to use and powerful solution to provide multilinguality for your Craft website, Craft Commerce and other plugins. With this plugin, you can easily manage the required translations in multiple languages.
 *
 * @link      https://www.infanion.com/
 * @copyright Copyright (c) 2021 Infanion
 */

namespace ip\translatorpro\assetbundles\translatorpro;

use Craft;
use craft\web\AssetBundle;
use craft\web\assets\cp\CpAsset;

/**
 * @author    Infanion
 * @package   TranslatorPro
 * @since     1.0.0
 */
class TranslatorproAsset extends AssetBundle
{
    // Public Methods
    // =========================================================================

    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->sourcePath = "@ip/translatorpro/assetbundles/translatorpro/dist";

        $this->depends = [
            CpAsset::class,
        ];

        $this->js = [
            'js/Translatorpro.js',
        ];

        $this->css = [
            'css/Translatorpro.css',
        ];

        parent::init();
    }
}
