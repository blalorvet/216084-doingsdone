<?php
/** @var $categories string[] */
/** @var $task_fields string[] */
/** @var $errors string[] */
?>

<div class="modal">
    <button class="modal__close" type="button" name="button">Закрыть</button>

    <h2 class="modal__heading">Добавление задачи</h2>


    <form class="form" action="/index.php" method="post">


        <?php $class_name = isset($errors['name']) ? "form__input--error" : "";
        $value = isset($add_new_task['name']) ? $add_new_task['name'] : "";
        ?>

        <div class="form__row">
            <label class="form__label" for="name">Название <sup>*</sup></label>

            <input
                class="form__input <?= $class_name ?> "
                type="text"
                name="name"
                id="name"
                value="<?= isset($task_fields['name']) ? $task_fields['name']: "" ;?>"
                placeholder="Введите название">
        </div>

        <?php $class_project = isset($errors['project']) ? "form__input--error" : "";
        $value = isset($add_new_task['project']) ? $add_new_task['project'] : "";
        ?>

        <div class="form__row">
            <label class="form__label" for="project">Проект <sup>*</sup></label>

            <select class="form__input form__input--select <?= $class_project ?> " name="project" id="project"  >
                <option value="">Выберите проект</option>
                <?PHP foreach ($categories as $index => $category) : ?>
                    <option
                        value="<?= $category; ?>">
                        <?= $category; ?>
                        <?= isset($task_fields['project'])&& $task_fields['project']=$category ? 'selected' :"" ?>
                    </option>
                <?php endforeach; ?>


            </select>
        </div>

        <div class="form__row">
            <label class="form__label" for="date">Дата выполнения</label>

            <input class="form__input form__input--date" type="date" name="date" id="date" value=""
                   placeholder="Введите дату в формате ДД.ММ.ГГГГ">
        </div>

        <div class="form__row">
            <label class="form__label" for="preview">Файл</label>

            <div class="form__input-file">
                <input class="visually-hidden" type="file" name="preview" id="preview" value="">

                <label class="button button--transparent" for="preview">
                    <span>Выберите файл</span>
                </label>
            </div>
        </div>

        <div class="form__row form__row--controls">
            <input class="button" type="submit" name="add_task" value="Добавить">
        </div>
    </form>
</div>
