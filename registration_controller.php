<?php
$form = $_POST;
$required = ['reg_email', 'reg_password', 'reg_name'];

foreach ($required as $field) {
    if (empty($form[$field])) {
        $reg_errors[$field] = 'Это поле надо заполнить';

    }

}
//    Проверка валидности e-mail адреса
if (!(filter_var($form['reg_email'], FILTER_VALIDATE_EMAIL))) {
    $reg_errors['reg_email'] = "Введен некорректный e-mail адрес";
}
//Если ошибок нет, то передаем данные полей в переменные
if (!count($reg_errors)) {


    $db_reg_email = $form['reg_email'];
    $form['reg_password'] = password_hash($form['reg_password'], PASSWORD_DEFAULT); // Хэшированние пароля
    $db_reg_name = $form['reg_name'];

    $sql = "INSERT INTO users (email, password, first_name, date_reg) VALUE (?,?,?,NOW())";
    $stmt = db_get_prepare_stmt($db_connect, $sql, [$form['reg_email'], $form['reg_password'], $form['reg_name']]);
    $res = mysqli_stmt_execute($stmt);

}


if (count($reg_errors)) {

    $layout_way_to_page = 'templates/guest.php';
    $popap_add_task = render('templates/registration.php',
        ['form' => $form, 'reg_errors' => $reg_errors, 'users' => $users]);
} else {

    header("Location: /index.php?enter");


}