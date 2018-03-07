<?PHP
//Форма для добавления новой категории(проекта)
/** @var $cat_errors string[] */


?>
<div class="modal">

    <?php $classname = isset($cat_errors) ? "form__input--error" : "";?>

  <button class="modal__close" type="button" name="button">Закрыть</button>

  <h2 class="modal__heading">Добавление проекта</h2>

  <form class="form"  action="/index.php" method="post">
    <div class="form__row">
      <label class="form__label" for="project_name">Название <sup>*</sup></label>

      <input class="form__input <?=$classname;?> " type="text" name="add_new_category" id="add_new_category" value="<?=html_sc($value);?>" placeholder="Введите название проекта">

      <p class="<?= isset($cat_errors) ? "form__message" : "";?>">

        <?= isset($cat_errors) ? $cat_errors : "";?>

      </p>


    </div>

    <div class="form__row form__row--controls">
      <input class="button" type="submit" name="add_category" value="Добавить">
    </div>
  </form>
</div>
