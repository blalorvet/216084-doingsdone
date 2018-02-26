<?php
/** @var $auth_errors string[] */
/** @var $form string[] */
?>
<div class="modal">
<main class="content__main">
          <h2 class="content__main-heading">Регистрация аккаунта</h2>

          <form class="form" action="/index.php" method="post">
            <div class="form__row">
              <?php $classname = isset($reg_errors['reg_email']) ? "form__input--error" : "";
              $value = isset($form['reg_email']) ? $form['reg_email'] : ""; ?>
              <label class="form__label" for="reg_email">E-mail <sup>*</sup></label>

              <input class="form__input <?=$classname;?>" type="text" name="reg_email" id="reg_email" value="<?=$value;?>" placeholder="Введите e-mail">

             <!-- <p class="form__message">E-mail введён некорректно</p> -->
              <p class="<?= isset($reg_errors['reg_email']) ? "form__message" : "";?>">

                <?= isset($reg_errors['reg_email']) ? $reg_errors['reg_email'] : "";?>


            </div>

            <div class="form__row">
              <?php $classname = isset($reg_errors['reg_password']) ? "form__input--error" : "";
              $value = isset($form['reg_password']) ? $form['reg_password'] : ""; ?>
              <label class="form__label" for="reg_password">Пароль <sup>*</sup></label>

              <input class="form__input <?=$classname;?>" type="password" name="reg_password" id="reg_password" value="<?=$value;?>" placeholder="Введите пароль">

              <p class="<?= isset($reg_errors['reg_password']) ? "form__message" : "";?>">

                <?= isset($reg_errors['reg_password']) ? $reg_errors['reg_password'] : "";?>
            </div>

            <div class="form__row">

              <?php $classname = isset($reg_errors['reg_name']) ? "form__input--error" : "";
              $value = isset($form['reg_password']) ? $form['reg_name'] : ""; ?>
              <label class="form__label" for="reg_name">Имя <sup>*</sup></label>

              <input class="form__input <?=$classname;?>" type="password" name="reg_name" id="reg_name" value="<?=$value;?>" placeholder="Введите пароль">
              <p class="<?= isset($reg_errors['reg_name']) ? "form__message" : "";?>">

                <?= isset($reg_errors['reg_name']) ? $reg_errors['reg_name'] : "";?>
            </div>



            <div class="form__row form__row--controls">
              <?= isset($reg_errors['reg_email'])||
              isset($reg_errors['reg_password'])||
              isset($reg_errors['reg_name']) ?
                  '<p class="error-message">Пожалуйста, исправьте ошибки в форме</p>': "";?>


              <input class="button" type="submit" name="reg_form" value="Зарегистрироваться">
            </div>
          </form>
        </main>
  </div>