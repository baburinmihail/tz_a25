<?php

namespace App\Presentation\Setting;

require_once 'App/Presentation/ORM/Orm.php'; use App\Presentation\ORM\Orm;

class Setting{

    /* alt connect db
    function __construct()
    {
        $setting_db = $this->global_setting_db();
        $myOrm = new Orm;
        $myOrm->setup( $setting_db['host'], $setting_db['port'], $setting_db['dbname'] , $setting_db['username'], $setting_db['password'] );
        echo 'connect tst';
    }
    */
    
    public function global_setting_db(){

        $db_connect = [
            'host' => '127.0.0.1',
            'port' => '3306',
            'dbname' => 'test_a25',
            'username' => 'root',
            'password' => '',
        ];

        return $db_connect;
    }
}