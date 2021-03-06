<?php
/** @var $categories string[] */
/** @var $task_fields string[] */
/** @var $errors string[] */
?>

<div class="modal">
    <button class="modal__close" type="button" name="button">Закрыть</button>

    <h2 class="modal__heading">Добавление задачи</h2>


    <form class="form" action="/index.php" method="post" enctype="multipart/form-data">


        <?php $class_name = isset($errors['add_task_name']) ? "form__input--error" : "";
        $value = isset($add_new_task['add_task_name']) ? $add_new_task['add_task_name'] : "";

        ?>

        <div class="form__row">
            <label class="form__label" for="add_task_name">Название <sup>*</sup></label>

            <input
                class="form__input <?= $class_name ?> "
                type="text"
                name="add_task_name"
                id="add_task_name"
                value="<?= isset($task_fields['add_task_name']) ? $task_fields['add_task_name']: "" ;?>"
                placeholder="Введите название">
            <p class="<?= isset($errors['add_task_name'])? "form__message" : "" ; ?> ">Заполните это поле</p>
        </div>

        <?php $class_project = isset($errors['project']) ? "form__input--error" : "";
        $value = isset($add_new_task['project']) ? $add_new_task['project'] : "";
        ?>

        <div class="form__row">
            <label class="form__label" for="project">Проект <sup>*</sup></label>

            <select class="form__input form__input--select <?= $class_project ?> " name="project" id="project"  >
                <option value="">Выберите проект</option>
               <? array_shift($categories);// удалил первый элемент из массива ?>

                <?PHP foreach ($categories as  $category) : ?>
                    <option
                        value="<?= $category['id']; ?>">
                        <?= $category['name'] ?>
                        <?= isset($task_fields['project'])&& $task_fields['project']=$category ['name']? 'selected' :"" ?>
                    </option>
                <?php endforeach; ?>

            </select>
            <p class="<?= isset($errors['project']) ? "form__message": "";?>" >Заполните это поле</p>

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
