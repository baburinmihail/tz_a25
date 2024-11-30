<?php
namespace App;
require_once 'App/Infrastructure/sdbh.php'; use sdbh\sdbh; 
require_once 'App/Presentation/Adapter/adapter_sdbh.php'; use adapter_sdbh\adapter_sdbh;


class Calculate
{
    public function calculate1()
    {

        //$dbh = new sdbh();
        $action = new adapter_sdbh();
        $days = isset($_POST['days']) ? $_POST['days'] : 0;
        $days = (int)$days; 
        $product_id = isset($_POST['product']) ? $_POST['product'] : 0;
        $selected_services = isset($_POST['services']) ? $_POST['services'] : [0 => 0];
        //$product = $dbh->make_query("SELECT * FROM a25_products WHERE ID = $product_id");
        $product = $action->my_make_query('a25_products', $product_id );
        if ($product) {
            $product = $product[0];
            $price = $product['PRICE'];
            $tarif = $product['TARIFF'];
        } else {
            echo "Ошибка, товар не найден!";
            return;
        }

        $tarifs = unserialize($tarif);
        if (is_array($tarifs)) {
            $product_price = $price;
            foreach ($tarifs as $day_count => $tarif_price) {
                if ($days >= $day_count) {
                    $product_price = $tarif_price;
                }
            }
            $total_price = $product_price * $days;
        }else{
            $total_price = $price * $days;
        }

        $services_price = 0;
        foreach ($selected_services as $service) {
            $services_price += (float)$service * $days;
        }

        $total_price += $services_price;

        echo $total_price;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $instance = new Calculate();
    $instance->calculate1();
}
