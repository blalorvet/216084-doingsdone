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
$db_task_user_id = $user_sesion['id'];
$db_task_category_id = (int)$_POST['project'];
$db_task_deadline = $_POST['date'];
$category_exist = false;

foreach ($categories as $category) {

    if ($db_task_category_id == $category['id']) {
        $category_exist = true;
    }

}
if ($category_exist === false) {
    $errors['project'] = 'Проект не найден';
}
if (empty($errors)) {
    $files_path = null;
    if (isset($_FILES['preview'])) { // Загрузка файла в корневую дирректорию

        $res = move_uploaded_file($_FILES['preview']['tmp_name'], __DIR__ . '/' . $_FILES['preview']['name']);
        $files_path = $_FILES['preview']['name'];
    }


    $sql = "INSERT INTO tasks (name, user_id , category_id, deadline, date_add, files_path) VALUE (?,?,?,?,NOW(),?)";
    $stmt = db_get_prepare_stmt($db_connect, $sql,
        [$db_task_name, $db_task_user_id, $db_task_category_id, $db_task_deadline, $files_path]);
    $res = mysqli_stmt_execute($stmt);

    if (!$res) {


        echo(mysqli_error($db_connect));
        exit;

    }
    header("Location: http://" . $_SERVER['SERVER_NAME']);


}