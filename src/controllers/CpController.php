<?php

/**
 * Translator Pro plugin for Craft CMS 3.x
 *
 * Translator Pro is an easy to use and powerful solution to provide multilinguality for your Craft website, Craft Commerce and other plugins. With this plugin, you can easily manage the required translations in multiple languages.
 *
 * @link      https://www.infanion.com/
 * @copyright Copyright (c) 2021 Infanion
 */

namespace ip\translatorpro\controllers;

use ip\translatorpro\TranslatorPro;
use Craft;
use craft\web\Controller;
/**
 * Class Translator Pro Cp controller
 */
class CpController extends Controller
{

    // Protected Properties
    // =========================================================================
    protected $allowAnonymous = true;

    // Public Methods
    // =========================================================================
    public $enableCsrfValidation = false;


    /**
     * fetches all translation strings from db
     */
    public function actionFetch()
    {
        $data = Craft::$app->getRequest()->post();
        $result = TranslatorPro::$plugin->translatorProService->fetchData($data);
        $results = json_encode($result);
        return $results;
    }

    /**
     * action to handle index request
     */
    public function actionIndex()
    {
        $result = TranslatorPro::$plugin->translatorProService->fetchData();

        return $this->renderTemplate(                                                                                                                 
            'translator-pro/index',                                                                                                                              
            [                                                                                                                                                     
                'result' => $result,                                                                                                                              
                                                                                                                                                                  
            ]                                                                                                                                                     
        );
    }

    /**
     * renders the edit translation template
     */
    public function actionEdit()
    {
        $result = TranslatorPro::$plugin->translatorProService->fetchData();
        return $this->renderTemplate(                                                                                                                 
            'translator-pro/edit',                                                                                                                              
            [                                                                                                                                                     
                'result' => $result,                                                                                                                              
                                                                                                                                                                  
            ]                                                                                                                                                     
        );
    }

    /**
     * save the updated translation
     */
    public function actionSave()
    {
        $data = Craft::$app->getRequest()->post();
        TranslatorPro::$plugin->translatorProService->saveData();
        $destinationUrl = isset($_GET['destination']) ? $_GET['destination'] : false;
        if ($destinationUrl) {
          Craft::$app->getResponse()->redirect($destinationUrl);
          Craft::$app->end();
          return;
        }
    }
}
