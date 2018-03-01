<?php
include_once('templates/config.php');
include_once('functions.php');
$db_error = "";
//$db[] = array(
//    "host" => "localhost",
//    "user" => "root",
//    "password" => "",
//    "database" => "doingsdone",
//);





$db_connect= mysqli_connect($db_host, $db_user, $db_password, $db_database);
//$link = mysqli_connect($db['host'], $db['user'], $db['password'], $db['database']);
mysqli_set_charset($db_connect, "utf8");

if (!$db_connect) {
    $db_error = ("Ошибка подключения: " . mysqli_connect_error());
    $page_content = render('templates/connect_error.php', [

        'db_error' => $db_error,



    ]);
    print($page_content);
}
else {
    $db_error =("Соединение установлено");

}



