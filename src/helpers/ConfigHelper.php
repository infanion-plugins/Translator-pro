<?php
/**
 * Translator Pro plugin for Craft CMS 3.x
 *
 * Translator Pro is an easy to use and powerful solution to provide multilinguality for your Craft website, Craft Commerce and other plugins. With this plugin, you can easily manage the required translations in multiple languages.
 *
 * @link      https://www.infanion.com/
 * @copyright Copyright (c) 2021 Infanion
 */

namespace ip\translatorpro\helpers;


use Craft;


/**
 * provides configuarations/settings for Translator Pro
 */
class ConfigHelper
{
    static function translatorproConfig(){
        return [
                    'class' => craft\i18n\I18N::class,
                    'messageFormatter' => [
                        'class' => craft\i18n\MessageFormatter::class,
                    ],
                    'translations' => [
                        'yii' => [
                            'class' => \ip\translatorpro\i18n\DbMessageSource::class,
                            'sourceLanguage' => 'en-US',
                            'language' => '',
                            'basePath' => '@yii/messages',
                            'forceTranslation' => true,
                            'allowOverrides' => false,
                            'on missingTranslation' => ['ip\translatorpro\helpers\TranslatorProHelper', 'handleMissingTranslation']
                        ],
                        'app' => [
                            'class' => \ip\translatorpro\i18n\DbMessageSource::class,
                            'sourceLanguage' => 'en-US',
                            'basePath' => '@app/translations',
                            'forceTranslation' => true,
                            'allowOverrides' => false,
                            'on missingTranslation' => ['ip\translatorpro\helpers\TranslatorProHelper', 'handleMissingTranslation']
                        ],
                        'site' => [
                            'class' => \ip\translatorpro\i18n\DbMessageSource::class,
                            'sourceLanguage' => 'en-US',
                            'basePath' => '@translations',
                            'forceTranslation' => true,
                            'on missingTranslation' => ['ip\translatorpro\helpers\TranslatorProHelper', 'handleMissingTranslation']
                        ],
                        '*' => [
                            'class' => \ip\translatorpro\i18n\DbMessageSource::class,
                            'sourceLanguage' => 'en-US',
                            'basePath' => '',
                            'forceTranslation' => true,
                            'on missingTranslation' => ['ip\translatorpro\helpers\TranslatorProHelper', 'handleMissingTranslation']
                        ],
                ],
        ];
        
    }

    /**
     * configuarations for craft built in translations
     */
    static function craftConfig(){
        return [
                    'class' => craft\i18n\I18N::class,
                    'messageFormatter' => [
                        'class' => craft\i18n\MessageFormatter::class,
                    ],
                    'translations' => [
                        'yii' => [
                            'class' => craft\i18n\PhpMessageSource::class,
                            'sourceLanguage' => 'en-US',
                            'basePath' => '@yii/messages',
                            'forceTranslation' => true,
                            'allowOverrides' => true,
                        ],
                        'app' => [
                            'class' => craft\i18n\PhpMessageSource::class,
                            'sourceLanguage' => 'en-US',
                            'basePath' => '@app/translations',
                            'forceTranslation' => true,
                            'allowOverrides' => true,
                        ],
                        'site' => [
                            'class' => craft\i18n\PhpMessageSource::class,
                            'sourceLanguage' => 'en-US',
                            'basePath' => '@translations',
                            'forceTranslation' => true,
                        ],
                ],
        ];
        
    }
}
