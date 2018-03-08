<?php
include_once('mysql_helper.php');
/**
 * @param $template_path string - путь до файла
 * @param $template_data string - переменная в которую мы будем отправлять страницу
 * @return string - возвращает содержимое буфера
 */
function render(
    $template_path,
    $template_data
) // функция render с двумя аргументами - $template_path путь до файла, $template_data - переменная в которую мы будем отправлять страницу
{
    if (!file_exists($template_path)) { // осуществляем проверку для $template_path существует ли такой файл, если нет возвращаем пустую строчку ""
        return "";
    }
    extract($template_data); //если файл существует то с помощью функции extract - превращаем ассоциации массива в переменные
    ob_start(); // осуществляем буферизацию
    include_once $template_path; // путь к файлу буферизации
    return ob_get_clean();// возвращем содержимое буфера

}


/**
 * Функция для поиска e-mail пользователя в БД
 * @param $email - пользователя для которого
 * @param $db_connect - соединение с БД
 * @return string[]- возвращает email, если он существует в БД
 */
function searchUserByEmail($email, $db_connect)
{
    $users = [];
    $sql = "SELECT * FROM users WHERE email = ?";
    $res = mysqli_prepare($db_connect, $sql);
    $stmt = db_get_prepare_stmt($db_connect, $sql, [$email]);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    $users = mysqli_fetch_assoc($res);
    return $users;
}


/**
 *  Функция приведения даты к формату ДД.ММ.ГГГГ, без времени.
 * @param $date int - изменяемая дата
 * @return int- возвращает дату в нужном формате
 */
function formate_task_date($date)
{
    if (empty($date)) {
        return 'Нет';
    }
    $time = strtotime($date);
    if ($time === false) {
        return 'Нет';
    }
    return date('d.m.Y', $time);

}


/**
 *  Функция изменения статуса задачи выполнена или нет
 * @param $task_id - ID задачи для которой делаем изменения
 * @param $db_connect - соединение с БД
 */
function add_data_end_to_task($task_id, $db_connect)
{
    $sql = "  UPDATE  tasks SET     date_end = IF(date_end IS NULL, NOW(), NULL)
WHERE    id = ? AND user_id = ?";

    $stmt = db_get_prepare_stmt($db_connect, $sql,
        [$task_id, $_SESSION['user']['id']]);
    $res = mysqli_stmt_execute($stmt);

    if ($res) {


        echo(mysqli_error($db_connect));


    }
}


/**
 * Функция поиска категорий пользователя
 * @param $id_user - ID пользователя для которого ищем категории
 * @param $db_connect - соединение с БД
 * @return string[]- возвращает категории для выбранного пользователя
 */
function searchUserCategories($id_user, $db_connect)
{
    $categories = [];
    $sql = "SELECT * FROM categories WHERE user_id = ?";
    $res = mysqli_prepare($db_connect, $sql);
    $stmt = db_get_prepare_stmt($db_connect, $sql, [$id_user]);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    $name_categories = mysqli_fetch_all($res, MYSQLI_ASSOC);
    foreach ($name_categories as $key => $item) {
        $categories[$item['id']] = $item;

    }

    return $categories;
}


/**
 * Функция поиска задач пользователя
 * @param $id_user - ID пользователя для которого ищем задачи
 * @param $db_connect - соединение с БД
 * @return string[]- возвращает задачи для выбранного пользователя
 */
function searchUserTasks($id_user, $db_connect)
{
    $tasks = [];
    $sql = "SELECT id AS id, name AS task_name, deadline AS task_date,  category_id AS task_category, date_end AS task_controls FROM tasks WHERE user_id = ?";
    $res = mysqli_prepare($db_connect, $sql);
    $stmt = db_get_prepare_stmt($db_connect, $sql, [$id_user]);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    $name_tasks = mysqli_fetch_all($res, MYSQLI_ASSOC);
    foreach ($name_tasks as $key => $item) {
        $tasks[] = $item;
    }

    return $tasks;
}


/**
 * функция подсчитывае общее количество задач в категориях
 * @param $massif_fun - в  эту переменную отправляется массив
 * @param $category_fun - в эту переменную отправляется ключ массива
 * @return int - возвращает обшее количество задачь
 */
function calc_category($massif_fun, $category_fun)
{
    $sum_fun = 0;
    if ($category_fun === 0) {
        $sum_fun = count($massif_fun);
    } else {
        foreach ($massif_fun as $key => $item) {
            if ($item['task_category'] === $category_fun) {
                $sum_fun++;
            }
        }
    }
    return $sum_fun;
}


/**
 * функция фильтрации входящих данных
 * @param $str - входящие данные преобразования специальнях символов в HTML-сущности
 * @return string возвращает строчку в котоой преобразованы специальные символы в HTML-сущности
 */
function html_sc($str)
{
    $text = htmlspecialchars($str);

    return $text;
}


/**
 * Функция подсчета разницы между текущей датой и датой задачи
 * @param $task_data_calc string дата в формате d.m.Y
 * @return string возвращает название класса важной задачи task--important или пустую строку
 */
function get_important_task_class_name($task_data_calc)
{
    $result = "";
    if (!($task_date_calc = strtotime($task_data_calc)) === false) {
        $task_data = (strtotime($task_data_calc));
        $cur_data = (strtotime("now"));

        if ((($task_data - $cur_data) / 86400) <= 1) {

            $result = 'task--important';

        }

    }
    return $result;
}


/**
 * Функция обработки даты для функции deadline_filter
 * @param $date_1 string - первая дата, текущая
 * @param $date_2 string - вторая дата,  дата задачи
 * @return string возвращает название класса важной задачи task--important или пустую строку
 */
function dateDifference($date_1, $date_2, $differenceFormat = '%r%a')
{
    $datetime1 = date_create($date_1);
    $datetime2 = date_create($date_2);

    $interval = date_diff($datetime1, $datetime2, false);

    return $interval->format($differenceFormat);

}

/**
 * Функция фильтрации задач по дате
 * @param $tasks string[] - массив с задачами
 * @param $deadline_filter -  значение куки
 * @return string возвращает массив с отфильтрованными задачами
 */
function deadline_filter($tasks, $deadline_filter = 'task_all')
{

    $cur_data = date('Y-m-d');
    $new_tasks = [];


    foreach ($tasks as $key => $item) {

        $date_differrent = dateDifference($cur_data, $item['task_date']);
        switch ($deadline_filter) {

            case 'task_all':
                $new_tasks[] = $item;
                break;

            case 'task_today':
                if ($date_differrent == 0) {
                    $new_tasks[] = $item;
                }
                break;

            case 'task_tomorrow':
                if ($date_differrent == 1) {
                    $new_tasks[] = $item;
                }
                break;

            case 'task_overdue':
                if ($date_differrent < 0) {
                    $new_tasks[] = $item;
                }
                break;

            default :

                $new_tasks[] = $item;

        }


    }
    return $new_tasks;

}