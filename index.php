<?php


require_once 'App/Infrastructure/sdbh.php'; use sdbh\sdbh;
require_once 'App/Presentation/ORM/Orm.php'; use App\Presentation\ORM\Orm;
require_once 'App/Presentation/Adapter/adapter_sdbh.php'; use adapter_sdbh\adapter_sdbh;
require_once 'App/Presentation/Setting/Setting.php'; use App\Presentation\Setting\Setting;

$setting = new Setting;
$db_connect = $setting->global_setting_db();

$id_product = 1;
$action = new adapter_sdbh($db_connect);
$tarif = $action->tarif_setka_data($id_product);

?>
<html>
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
          crossorigin="anonymous">
    <link href="assets/css/style.css" rel="stylesheet"/>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
            crossorigin="anonymous"></script>
</head>
<body>
<div class="container">
    <div id='row-header_conteiner'  class="row row-header">
        <div class="col-12" id="count">
            <img src="assets/img/logo.png" alt="logo" style="max-height:50px"/>
            <h1>Прокат Y</h1>
        </div>
    </div>
<!-- -------------------------------------------------- -->
    <div id='point'><h2 id='dashbord_massage'>Тарифная сетка</h2></div>
    <table id="table" class="table">
        <thead>
            <tr>
            <th scope="col">День</th>
            <th scope="col">Ценна</th>
            </tr>
        </thead>
        <tbody>
            <?php 
                for ($i = 0; $i <= array_key_last($tarif); $i++) {
                    if (!isset($tarif[$i])){
                    }else{
                    ?>  
                        <tr>
                            <th scope="row"><?php  echo $i ?></th>
                            <td><?php echo $tarif[$i] ?></td>
                        </tr>  
                    <?php
                    }
                }
            ?>
        </tbody>
    </table>
<!-- -------------------------------------------------- -->
    <div class="row row-form">
        <div class="col-12">
            <form action="App/calculate.php" method="POST" id="form">

                <?php $products = $action->my_make_query('a25_products', null );
                if (is_array($products)) { ?>
                    <label class="form-label" for="product">Выберите продукт:</label>
                    <select class="form-select" name="product" id="product">
                        <?php foreach ($products as $product) {
                            $name = $product['NAME'];
                            $price = $product['PRICE'];
                            $tarif = $product['TARIFF'];
                            ?>
                            <option value="<?= $product['ID']; ?>"><?= $name; ?></option>
                        <?php } ?>
                    </select>
                <?php } ?>

                <label for="customRange1" class="form-label" id="count">Количество дней:</label>
                <input type="number" name="days" class="form-control" id="customRange1" min="1" max="30">

                <?php $services = unserialize($action->my_mselect_rows('a25_settings', 'services' , 0 , 1 , 'id' , 0 , 'set_value' , $db_connect));
                if (is_array($services)) {
                    ?>
                    <label for="customRange1" class="form-label">Дополнительно:</label>
                    <?php
                    $index = 0;
                    foreach ($services as $k => $s) {
                        ?>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="services[]" value="<?= $s; ?>" id="flexCheck<?= $index; ?>">
                            <label class="form-check-label" for="flexCheck<?= $index; ?>">
                                <?= $k ?>: <?= $s ?>
                            </label>
                        </div>
                    <?php $index++; } ?>
                <?php } ?>

                <button type="submit" class="btn btn-primary">Рассчитать</button>
            </form>

            <h5>Итоговая стоимость: <span id="total-price"></span></h5>
        </div>
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        $("#form").submit(function(event) {
            event.preventDefault();

            $.ajax({
                url: 'calculate.php',
                type: 'POST',
                data: $(this).serialize(),
                success: function(response) {
                    $("#total-price").text(response);
                },
                error: function() {
                    $("#total-price").text('Ошибка при расчете');
                }
            });
        });
    });
</script>
<script>
    $('#product').change( function() {
    $(this).find(":selected").each(function () {
        event.preventDefault();
        let formData = $('select[name="product"]').serialize();    
        $.ajax({
                url: 'tarif.php',
                type: 'POST',
                data: formData,
                success: function(response) {
                    create_table_tarif(response);
                },
                error: function() {
                    $("#dashbord_massage").text('Ошибка при расчете');
                }
            });
        });

    });

    function create_table_tarif(response){
        
        console.log(response);
        jsonArray = JSON.parse(response);
        let keys = Object.keys(jsonArray);
        let th_sting = '';
        let old_table_delet = document.querySelector('#table');
        old_table_delet.remove();

            for (let i = 0; i < keys.length; i++) { 
                th_sting = th_sting + '<th scope=`row`>' + keys[i] + '</th><td>' + jsonArray[keys[i]] +'</td></tr>';
            }

        create_table(th_sting);
    }  
    
    function create_table(th_sting){
        let table = document.createElement('table');
        const point = document.querySelector('#point');
        table.className = "table";
        table.id = "table";
        table.innerHTML = '<thead><tr><th scope=`col`>День</th><th scope=`col`>Ценна</th></tr></thead><tbody id=`table` class=`table`><tr>'+th_sting+'</tr></tbody>';
        point.after(table);
    }




</script>
</body>
</html>