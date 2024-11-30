<?php

namespace adapter_sdbh;
require_once 'App/Presentation/ORM/Orm.php'; use App\Presentation\ORM\Orm;
require_once 'App/Infrastructure/sdbh.php'; use sdbh\sdbh;
require_once 'App/Presentation/Setting/Setting.php'; use App\Presentation\Setting\Setting;




class adapter_sdbh{

    function prepeare_conect()
    {
        $setting = new Setting;
        $conect = new ORM;
        $db_connect = $setting->global_setting_db();
        
        return $conect->setup( $db_connect['host'], 
                        $db_connect['port'], 
                        $db_connect['dbname'] ,
                        $db_connect['username'] ,
                        $db_connect['password']);

    }

    /**
     * @param table: is the table for the query
     *
     * @param id: if this parameter is present , 
     *            the request is made with the id attribute
    */  
    public function my_make_query($table , $id ){



        if (isset($id)){
            $query = 'SELECT * FROM '.$table.' WHERE ID = '.$id;
        }else{
            $query = 'SELECT * FROM '.$table;
        }
        //echo $query;

        $dbh = new sdbh();

        return $dbh->make_query($query);    
    }

    /**
     * * By given parameters generates SELECT query, executes it and returns
     * answer in array. Data values in select_array and $from, $amount
     * fields are escaped and intval-ed respectively, others !!are not!!.
     * @param table: is the table for the query
     *
     * @param set_key: the value in the set_key column
     * 
     * @param from: the beginning of the request boundary
     * 
     * @param amount: end of the request boundary
     * 
     * @param order_by: filter data by this parameter
     * 
     * @param id: filter data by this parameter
     * 
     * @param set_value: the name of the price list column
    */

    public function my_mselect_rows($table , $set_key, $from , $amount, $order_by, $id, $set_value , $db_connect){
       
        $dbh = new sdbh($settings=[], $db_connect );
        return $dbh->mselect_rows($table, ['set_key' => $set_key], $from, $amount, $order_by)[$id][ $set_value];
    }

    public function tarif_setka_data($id){

        $all_quevy = new ORM;
        $data_array=$all_quevy->targete_id_data('a25_products', $this->prepeare_conect(), $id );
        
        //$test = $data_array[0]['TARIFF'] ;
        if (isset($data_array['TARIFF'])){
            $result = unserialize($data_array['TARIFF']);
        }else{
            $result = [ 30 => $data_array['PRICE']];
        }
        

        return $result;
        
    }

    public function tarif_setka_data_unserialize($id){

        $all_quevy = new ORM;
        $data_array=$all_quevy->targete_id_data('a25_products', $this->prepeare_conect(), $id );
        
        //$test = $data_array[0]['TARIFF'] ;
        if (isset($data_array['TARIFF'])){
            $result = $data_array['TARIFF'];
        }else{
            $result = serialize([ 30 => $data_array['PRICE']]);
        }
        

        return $result;
        
    }


}



