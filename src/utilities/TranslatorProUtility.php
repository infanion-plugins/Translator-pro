<?php
/**
 * Translator Pro plugin for Craft CMS 3.x
 *
 * The Translator Pro is an easy to use and powerful solution to provide multilinguality for your Craft website, Craft Commerce and other plugins. With this plugin, you can easily manage the required translations in multiple languages.
 *
 * @link      https://www.infanion.com/
 * @copyright Copyright (c) 2021 Infanion
 */

namespace ip\translatorpro\utilities;

use ip\translatorpro\TranslatorPro;
use ip\translatorpro\assetbundles\translatorproutilityutility\TranslatorProUtilityUtilityAsset;

use Craft;
use craft\base\Utility;

/**
 * Translator Pro Utility
 *
 * Utility is the base class for classes representing Control Panel utilities.
 *
 * https://craftcms.com/docs/plugins/utilities
 *
 * @author    Infanion
 * @package   TranslatorPro
 * @since     1.0.0
 */
class TranslatorProUtility extends Utility
{
    // Static
    // =========================================================================

    /**
     * Returns the display name of this utility.
     *
     * @return string The display name of this utility.
     */
    public static function displayName(): string
    {
        return Craft::t('translator-pro', 'TranslatorProUtility');
    }

    /**
     * Returns the utility’s unique identifier.
     *
     * The ID should be in `kebab-case`, as it will be visible in the URL (`admin/utilities/the-handle`).
     *
     * @return string
     */
    public static function id(): string
    {
        return 'translatorpro-translator-pro-utility';
    }

    /**
     * Returns the path to the utility's SVG icon.
     *
     * @return string|null The path to the utility SVG icon
     */
    public static function iconPath()
    {
        return Craft::getAlias("@ip/translatorpro/assetbundles/translatorproutilityutility/dist/img/TranslatorProUtility-icon.svg");
    }

    /**
     * Returns the number that should be shown in the utility’s nav item badge.
     *
     * If `0` is returned, no badge will be shown
     *
     * @return int
     */
    public static function badgeCount(): int
    {
        return 0;
    }

    /**
     * Returns the utility's content HTML.
     *
     * @return string
     */
    public static function contentHtml(): string
    {
        Craft::$app->getView()->registerAssetBundle(TranslatorProUtilityUtilityAsset::class);

        $someVar = 'Have a nice day!';
        return Craft::$app->getView()->renderTemplate(
            'translator-pro/_components/utilities/TranslatorProUtility_content',
            [
                'someVar' => $someVar
            ]
        );
    }
}
