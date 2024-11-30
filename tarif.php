<?php
namespace App;
require_once 'App/Presentation/Adapter/adapter_sdbh.php'; use adapter_sdbh\adapter_sdbh;
require_once 'App/Presentation/Setting/Setting.php'; use App\Presentation\Setting\Setting;



class Tarif
{
    public function tarif_change()
    {

        $setting = new Setting;
        $db_connect = $setting->global_setting_db();

        $action = new adapter_sdbh($db_connect);

        $product_id = isset($_POST['product']) ? $_POST['product'] : 0;
        $tarif_string  = $action->tarif_setka_data($product_id );
        
        echo json_encode($tarif_string);

    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $instance = new Tarif();
    $instance->tarif_change();
}
