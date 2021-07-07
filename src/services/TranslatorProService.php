<?php
/**
 * Translator Pro plugin for Craft CMS 3.x
 *
 * The Translator Pro is an easy to use and powerful solution to provide multilinguality for your Craft website, Craft Commerce and other plugins. With this plugin, you can easily manage the required translations in multiple languages.
 *
 * @link      https://www.infanion.com/
 * @copyright Copyright (c) 2021 Infanion
 */

namespace ip\translatorpro\services;

use ip\translatorpro\TranslatorPro;
use Craft;
use craft\base\Component;
use craft\helpers\App;
use ip\translatorpro\utilities\Database;
use ip\translatorpro\helpers\TranslatorProHelper as TransHelper;
use craft\db\Connection;
use craft\helpers\Db;
use craft\services;
use ip\translatorpro\helpers\TranslatorProHelper;
use yii\i18n\MissingTranslationEvent;

/**
 * TranslatorProService Service
 *
 * All of your plugin’s business logic should go in services, including saving data,
 * retrieving data, etc. They provide APIs that your controllers, template variables,
 * and other plugins can interact with.
 *
 * https://craftcms.com/docs/plugins/services
 *
 * @author    Infanion
 * @package   TranslatorPro
 * @since     1.0.0
 */
class TranslatorProService extends Component
{
    // Public Methods
    // =========================================================================

    
    
    /**
     * function to get translations from db
     */
    public function fetchData () {
        $allSites = Craft::$app->sites->getAllSites();
        $languages = $this->getValidSites($allSites);
        $query = new \craft\db\Query();
        $selectFields = ['s.id', 's.message'];
        $joins = '';
        foreach($languages as $language) {
          $lang = explode('-',$language)[0];
          $joins .= " LEFT JOIN {{%message%}} $lang ON ($lang.id=s.id and $lang.language='$language')";
          $selectFields[] = $lang.'.translation as message_'.$lang;
        }
        $selectFieldString = implode(',', $selectFields); 
        $result = $query->select($selectFieldString)
                        ->from(['{{%source_message}} s'.$joins])
                        ->orderBy('message asc');
        $conditions = self::getWhereConditions();
        foreach($conditions as $key => $condition) {
          $result->where($condition);
        }
        $results = $result->all();
        return $results;
        
    }  
      
    /**
     * adding conditions to query
     */
    public function getWhereConditions() {
        $data = Craft::$app->getRequest()->get();
        $conditions = [];
        if($data){
          if(isset($data['id'])) {
            $conditions[] = ['=', 's.id', $data['id']];
          }
          else {
            if(isset($data['source'])) {
              $conditions[] = ['ilike', 's.message', $data['source']];
            }

            $allSites = Craft::$app->sites->getAllSites();
            foreach($allSites as $site) {
              if(!$site->enabled) continue;
              $lang = explode('-',$site->language)[0];
              if(isset($data[$lang])) {
                $conditions[] = ['ilike', $lang.'.translation', $data[$lang]];
              }
            }
          }
        }
        return $conditions;
    }

    // function to save translated strings
    public function saveData()
    {
        $data = Craft::$app->getRequest()->post();
        $allSites = Craft::$app->sites->getAllSites();
        $id = $data['id'];
        foreach($allSites as $site) {
          if(!$site->enabled) continue;
          $lang = explode('-',$site->language)[0];
          $translation = $data[$lang];
          $conditions = ['id'=>$id, 'language' => $site->language];
          $tid = TranslatorProHelper::checkIfExists($conditions);
          if(!$tid && !empty($translation)) {
            Db::insert('message', [
              'id' => $id,
              'language' => $site->language,
              'translation' => $translation,
            ], false);
          } 
          else if($tid){
            Db::update('message', [
              'translation' => $translation,
            ],
            $conditions, [], false);
          }
        }
        return true;
    }

    // insert missing strings to db
    public function insertData()
    {
        $data = Craft::$app->getRequest()->post();
        $siteInfo = Craft::$app->getSites()->getCurrentSite();
        foreach($data['data'] as $string) {
           $transEvent = new MissingTranslationEvent();
           $transEvent->category = 'app';
           $transEvent->message = $string;
           $transEvent->language = $siteInfo->language;
           TranslatorProHelper::handleMissingTranslation($transEvent); 
        }
        return true;
    }

    public function getValidSites($allsites){
      $sites = [];
      foreach($allsites as $site){
        if($site->enabled){
          array_push($sites, $site);
        }
      }
      return array_unique(array_column($sites, 'language'));
    }
}
