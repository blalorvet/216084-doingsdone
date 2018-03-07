<?php
/** Шаблон, который выводит список задач */
/** @var $show_complete_tasks */
/** @var $tasks [] */
/** @var $show_popap_add_task [] */


?>

<h2 class="content__main-heading">Список задач</h2>

<form class="search-form" action="index.html" method="post">
    <input class="search-form__input" type="text" name="" value="" placeholder="Поиск по задачам">

    <input class="search-form__submit" type="submit" name="" value="Искать">
</form>

<div class="tasks-controls">
    <nav class="tasks-switch">
        <a href="/?deadline_filter=task_all" class="tasks-switch__item
        <?= $_COOKIE['deadline_filter'] === 'task_all' ? "tasks-switch__item--active" : ""; ?>">Все задачи</a>

        <a href="/?deadline_filter=task_today" class="tasks-switch__item
        <?= $_COOKIE['deadline_filter'] === 'task_today' ? "tasks-switch__item--active" : ""; ?>">Повестка дня</a>

        <a href="/?deadline_filter=task_tomorrow" class="tasks-switch__item
        <?= $_COOKIE['deadline_filter'] === 'task_tomorrow' ? "tasks-switch__item--active" : ""; ?>">Завтра</a>

        <a href="/?deadline_filter=task_overdue" class="tasks-switch__item
        <?= $_COOKIE['deadline_filter'] === 'task_overdue' ? "tasks-switch__item--active" : ""; ?>">Просроченные</a>
    </nav>

    <label class="checkbox">
        <a href="/?show_completed">
            <!--добавить сюда аттрибут "checked", если переменная $show_complete_tasks равна единице-->

            <input class="checkbox__input visually-hidden"

                   type="checkbox" <?= ($show_complete_tasks == 1) ? "checked" : ""; ?> >

            <span class="checkbox__text">Показывать выполненные</span>


        </a>
    </label>
</div>

<!-- Цикл из массива, который создает список задач  и выводит активыные и нет задачи-->
<table class="tasks">

    <?php foreach ($tasks as $key => $item) : ?>
        <?php if ($item['task_controls'] === null || $show_complete_tasks == 1) : ?>
            <tr class="tasks__item task <?= ($item['task_controls'] != null) ? "task--completed" : ""; ?> <?= html_sc(get_important_task_class_name($item ['task_date'])); ?> ">
                <td class="task__select">
                    <label class="checkbox task__checkbox">
                        <a href="?toggle_task=<?= $item['id'] ?>">
                            <input class="checkbox__input visually-hidden"
                                   type="checkbox" <?= !empty($item['task_controls']) ? "checked" : ""; ?> >


                            <span class="checkbox__text"> <?= html_sc($item ['task_name']); ?> </span>
                        </a>
                    </label>
                </td>
                <td class="task__date">  <?= html_sc(formate_task_date($item ['task_date'])); ?></td>

                <td class="task__controls">
                </td>
            </tr>
        <?php endif ?>
    <?php endforeach; ?>
</table>
