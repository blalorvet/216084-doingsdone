<?php


$required = ['add_task_name', 'project'];
//В цикле проверяем заполнены поля или нет, если не заполнены то передаем значение не заполненного поля в масси Errors
foreach ($required as $key) {

    if (empty($_POST[$key])) {

        $errors[$key] = 'Это поле надо заполнить';

    } else {

        $task_fields[$key] = $_POST[$key];

    }
}
$db_task_name = $_POST['add_task_name'];
if (empty($errors)) {


    $db_task_user_id = $user_sesion['id'];
    $db_task_category_id = $_POST['project'];
    $db_task_deadline = $_POST['date'];

    $sql = "INSERT INTO tasks (name, user_id , category_id, deadline, date_add) VALUE (?,?,?,?,NOW())";
    $stmt = db_get_prepare_stmt($db_connect, $sql,
        [$db_task_name, $db_task_user_id, $db_task_category_id, $db_task_deadline]);
    $res = mysqli_stmt_execute($stmt);

    if ($res) {


        echo(mysqli_error($db_connect));


    }


    if (isset($_FILES['preview']['add_task_name'])) { // Загрузка файла в корневую дирректорию

        $path = $_FILES['preview']['add_task_name'];
        $res = move_uploaded_file($_FILES['preview']['tmp_name'], '' . $path);

    }
}