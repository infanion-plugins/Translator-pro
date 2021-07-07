<?php

namespace ip\translatorpro\utilities;
use Craft;

class Database
{

    public function getDBConnection(){
        $DB_DRIVER   = Craft::parseEnv('$DB_DRIVER');
        $DB_SERVER   = Craft::parseEnv('$DB_SERVER');
        $DB_PORT     = Craft::parseEnv('$DB_PORT');
        $DB_DATABASE = Craft::parseEnv('$DB_DATABASE');
        $DB_USER     = Craft::parseEnv('$DB_USER');
        $DB_PASSWORD = Craft::parseEnv('$DB_PASSWORD');

    
        $connection = new \yii\db\Connection([
            'dsn' => "$DB_DRIVER:host=$DB_SERVER;port=$DB_PORT;dbname=$DB_DATABASE",
            'username' => "$DB_USER",
            'password' => "$DB_PASSWORD",
        ]);
        return $connection;
    }

}