﻿<?
//***************** Страница с завершением заказа ******************
session_start();
 
// формируем массив с товарами в заказе (если товар один - оставляйте только первый элемент массива)
$products_list = array(
    0 => array(
            'product_id' => '5',    //код товара (из каталога CRM)
            'price'      => '2535', //цена товара 1
            'count'      => '1',                     //количество товара 1
            // если есть смежные товары, тогда количество общего товара игнорируется

    ),

);
$products = urlencode(serialize($products_list));
$sender = urlencode(serialize($_SERVER));
$order_id = number_format(round(microtime(true)*10),0,'.','');
$_SESSION['order_id'] = $order_id;
// параметры запроса
$data = array(
    'key'             => 'e5c088c09b12c40fa4b82feaccbdd8a6', //Ваш секретный api токен
    'order_id'        => $order_id, //идентификатор (код) заказа (*автоматически*)
    'country'         => 'UA',                         // Географическое направление заказа
    'office'          => '7',                          // Офис (id в CRM)
    'products'        => $products,                    // массив с товарами в заказе
    'bayer_name'      => $_REQUEST['name'],            // покупатель (Ф.И.О)
    'phone'           => $_REQUEST['phone'],           // телефон
    'email'           => $_REQUEST['number'],           // электронка
    'comment'         => $_REQUEST['product_name'],    // комментарий
    'delivery'        => $_REQUEST['delivery'],        // способ доставки (id в CRM)
    'delivery_adress' => $_REQUEST['delivery_adress'], // адрес доставки
    'payment'         => '',                           // вариант оплаты (id в CRM)
    'sender'          => $sender,                        
    'utm_source'      => $_SESSION['utms']['utm_source'],  // utm_source
    'utm_medium'      => $_SESSION['utms']['utm_medium'],  // utm_medium
    'utm_term'        => $_SESSION['utms']['utm_term'],    // utm_term
    'utm_content'     => $_SESSION['utms']['utm_content'], // utm_content
    'utm_campaign'    => $_SESSION['utms']['utm_campaign'],// utm_campaign
    'additional_1'    => '',                               // Дополнительное поле 1
    'additional_2'    => '',                               // Дополнительное поле 2
    'additional_3'    => '',                               // Дополнительное поле 3
    'additional_4'    => ''                                // Дополнительное поле 4
);
 



$chat_id = '-4159477347';
$token = '6890323856:AAEFic41EgpeSFvT1W5IcnrTLLmMcN2AZm0';

$nameFieldset = "Ім'я: ";
$phoneFieldset = "Телефон: ";
$productFieldset = "Оффер: ";
$priceFieldset = "Ціна: ";

$name = $_REQUEST['name'];
$phone = $_REQUEST['phone'];

$arr = array(
    'Нове Замовлення! ' => '',
    $nameFieldset => $_REQUEST['name'],
    $phoneFieldset => $_REQUEST['phone'],
    $productFieldset => 'Путівник',
);


foreach ($arr as $key => $value) {
    $txt .= "<b>" . $key . "</b> " . $value . "\n";
};
$txt = urlencode($txt);
$sendToTelegram = fopen("https://api.telegram.org/bot{$token}/sendMessage?chat_id={$chat_id}&parse_mode=html&text={$txt}&disable_web_page_preview=true", "r");
if ($sendToTelegram) {
    header("Location: form.html?name=$name&phone=$phone");
    echo '<p class="success">Дякуємо за відправку вашого повідомлення!</p>';
    return true;
} else {
    echo '<p class="fail"><b>Помилка. Повідомлення не відправлено!</b></p>';
}






