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

use ip\translatorpro\TranslatorPro;
use Craft;
use craft\base\Component;
use craft\helpers\App;
use ip\translatorpro\utilities\Database;
use craft\db\Connection;
use craft\helpers\Db;
use craft\db\Query;
use yii\i18n\MissingTranslationEvent;


class TranslatorProHelper
{
    /**
     * Handle event MissingTranslationEvent
     * inserts missing source strings to db
     */
    public static function handleMissingTranslation(MissingTranslationEvent $event) {
      $id = self::getIdIfExists($event);
      if(!$id) {
        try{
          $success = Db::insert('source_message', [
            'category' => $event->category,
            'message' => $event->message,
         ], false);
        }
        catch(\Exception $e){
          return;
        }
         
         if($success) {
           $id = self::getIdIfExists($event);
           if(!$id) return;
           $response = Db::insert('message', [
            'id' => $id,
            'language' => $event->language,
            'translation' => $event->message,
           ], false);
        }
      }
   }

  /**
   * check if source string exist by id
   */
   public static function getIdIfExists($event) {
     $result = (new Query())
            ->select('id')
            ->from('source_message')
            ->where(['category' => $event->category, 'message' => $event->message])
            ->limit(1)
            ->column();
     if($result && count($result) > 0) {
       return $result[0];
     }
     return false;
   }

  /**
   * check if translated string exist or not
   */
   public static function checkIfExists($data) {
     $result = (new Query())
            ->select('id')
            ->from('message')
            ->where(['language' => $data['language'], 'id' => $data['id']])
            ->limit(1)
            ->column();
     if($result && count($result) > 0) {
       return $result[0];
     }
     return false;
   }
}
