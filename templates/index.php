<?php
/** @var $show_complete_tasks int*/
/** @var $tasks []*/
?>
<?= $show_popap_add_task; ?>
<h2 class="content__main-heading">Список задач</h2>

<form class="search-form" action="index.html" method="post">
    <input class="search-form__input" type="text" name="" value="" placeholder="Поиск по задачам">

    <input class="search-form__submit" type="submit" name="" value="Искать">
</form>

<div class="tasks-controls">
    <nav class="tasks-switch">
        <a href="/" class="tasks-switch__item tasks-switch__item--active">Все задачи</a>
        <a href="/" class="tasks-switch__item">Повестка дня</a>
        <a href="/" class="tasks-switch__item">Завтра</a>
        <a href="/" class="tasks-switch__item">Просроченные</a>
    </nav>

    <label class="checkbox">
        <a href="/?show_completed">
            <!--добавить сюда аттрибут "checked", если переменная $show_complete_tasks равна единице-->
            <!-- Вместо оператора if использовал тернарный оператор ?: -->
            <input class="checkbox__input visually-hidden"
                   type="checkbox" <?= ($show_complete_tasks === 1) ? "checked" : ""; ?> >
            <span class="checkbox__text">Показывать выполненные</span>



        </a>
    </label>
</div>

<!-- Цикл из массива, который создает список задач  и выводит активыные и нет задачи-->
<table class="tasks">

    <?php foreach ($tasks as $key => $item) : ?>
        <?php if ( $item['task_controls'] === "Нет" || $show_complete_tasks === 1) : ?>
            <tr class="tasks__item task <?= ($item['task_controls'] === "Да") ? "task--completed" : "";?> <?= html_sc(get_important_task_class_name($item ['task_date']));?> ">
                <td class="task__select">
                    <label class="checkbox task__checkbox">
                        <input class="checkbox__input visually-hidden"
                               type="checkbox" <?= ($item['task_controls'] === "Да") ? "checked" : ""; ?> >
                        <span class="checkbox__text"> <?= html_sc($item ['task_name']); ?> </span>
                    </label>
                </td>
                <td class="task__date"><?= html_sc($item ['task_date']); ?></td>

                <td class="task__controls">
                </td>
            </tr>
        <?php endif ?>
    <?php endforeach; ?>
</table>
