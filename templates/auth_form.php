<?PHP
/**Формма аутентификации пользователя */
/** @var $auth_errors string[] */
/** @var $form string[] */

?>

<div class="modal">
    <button class="modal__close" type="button" name="button"  >Закрыть</button>

    <h2 class="modal__heading">Вход на сайт</h2>

    <form class="form" action="/index.php" method="post">
        <div class="form__row">
            <?php $classname = isset($auth_errors['email']) ? "form__input--error" : "";
            $value = isset($form['email']) ? $form['email'] : ""; ?>
            <label class="form__label" for="email">E-mail <sup>*</sup></label>

            <input class="form__input <?=$classname;?>" type="text" name="email" id="email" value="<?=$value;?>" placeholder="Введите e-mail">

            <p class="<?= isset($auth_errors['email']) ? "form__message" : "";?>">

                <?= isset($auth_errors['email']) ? $auth_errors['email'] : "";?>

            </p>

        </div>

        <div class="form__row">
            <?php $classname = isset($auth_errors['password']) ? "form__input--error" : "";
            $value = isset($form['password']) ? $form['password'] : ""; ?>
            <label class="form__label" for="password">Пароль <sup>*</sup></label>

            <input class="form__input <?=$classname;?>" type="password" name="password" id="password" value="<?=$value;?>" placeholder="Введите пароль">
            <p class="<?= isset($auth_errors['password']) ? "form__message" : "";?>">
                <?= isset($auth_errors['password']) ? $auth_errors['password'] : "";?>

            </p>
        </div>

        <div class="form__row form__row--controls">
            <input class="button" type="submit" name="auth_form" value="Войти">
        </div>

    </form>
</div>