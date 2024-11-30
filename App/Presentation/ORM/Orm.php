<?php

namespace App\Presentation\ORM;

use PDO;
use PDOException;
require_once 'App/Presentation/Setting/Setting.php'; use App\Presentation\Setting\Setting;

class Orm{

    function __construct()
    {
        $setting = new Setting;
        $db_connect = $setting->global_setting_db();
        return $db_connect;

    }
    
    public function setup($host,$port,$dbname,$login,$pass){
        try{
            
            return $connection = new PDO("mysql:host=$host;dbname=$dbname;port=$port;", $login,$pass);

        }catch(PDOException $exception){
            echo $exception->getMessage();
            die();
        };
        /*
        echo '<pre>';
        print_r(PDO::getAvailableDrivers());
        echo '</pre>';
        */
    }

    public function all_data($table , $connection ){

        $sql = "SELECT * FROM $table";
        $stmt = $connection->prepare($sql);
        $stmt ->execute();
        $entity = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $entity;
    }

    public function targete_id_data($table , $connection , $id ){
        $sql = "SELECT * FROM $table WHERE id = ?";
        $stmt = $connection->prepare($sql);
        $stmt ->execute([$id]);
        $entity = $stmt->fetch(PDO::FETCH_ASSOC);
        return $entity;
    }

    public function insert_target_data($table , $connection, ){
        $data ='string';
        $sql = "INSERT INTO $table (name) VALUES (?)";
        echo $sql;
        $stmt = $connection->prepare($sql);
        $stmt ->execute([$data]);
    }

    public function targete_colum($table , $connection, $colum ){

        $sql = "SELECT $colum FROM $table";
        $stmt = $connection->prepare($sql);
        $stmt ->execute();
        $entity = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $entity;
    }


}