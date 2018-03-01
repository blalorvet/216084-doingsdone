<?php
if (!file_exists('config.php')) { // осуществляем проверку для $template_path существует ли такой файл, если нет возвращаем пустую строчку ""
    echo "Ошибка подключения к базе данных";
    exit;
}

include_once('config.php');

$db_connect = mysqli_connect($db['host'], $db['user'], $db['password'], $db['database']);
if (!$db_connect) {
    echo "Ошибка подключения к базе данных";
    exit;
}
mysqli_set_charset($db_connect, "utf8");