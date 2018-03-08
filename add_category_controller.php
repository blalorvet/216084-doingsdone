<?php


$required = ['add_new_category'];
//В цикле проверяем заполнено поле или нет, если не заполнено то передаем значение не заполненного поля в масси Errors
foreach ($required as $key) {

    if ( empty( trim($_POST[$key]))) {

        $cat_errors[$key] = 'Это поле надо заполнить';


    } else {

        $task_fields[$key] = $_POST[$key];

    }
}
$value_errors = '';
$db_cat_name = trim($_POST['add_new_category']);
foreach ($categories as $category){
    if ($category['name']== $db_cat_name){
        $cat_errors['add_new_category'] = 'Такой проект уже существует';
        $value_errors = $category['name'];
        break;
    }
}
if (empty($cat_errors)) {

    $db_cat_user_id = $user_sesion['id'];



    $sql = "INSERT INTO categories (name, user_id ) VALUE (?,?)";
    $stmt = db_get_prepare_stmt($db_connect, $sql, [$db_cat_name, $db_cat_user_id]);
    $res = mysqli_stmt_execute($stmt);

    if (!$res) {

        echo(mysqli_error($db_connect));

    }

}
if (count($cat_errors)) {

    $layout_way_to_page = 'templates/layout.php';

    $popap_add_task = render('templates/add_category.php', [
        'cat_errors' => $cat_errors['add_new_category'],
        'value_errors' => $value_errors
    ]);

} else {

    header("Location: /index.php");


}