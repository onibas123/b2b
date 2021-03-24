<?php
require_once('../controller/B2bController.php');
$b2b = new B2bController();
$action = $_POST['action'];
switch ($action) {
    case 'get_sales':
        $b2b->get_sales_by_products();
        break;
    case 'load_data':
        $b2b->load_data();
        break;
    case 'report':
        $b2b->get_cadena_sales_by_date();
        break;
    default:
        //302 Found HTTP CODE STATUS
        echo 'default';
}

?>