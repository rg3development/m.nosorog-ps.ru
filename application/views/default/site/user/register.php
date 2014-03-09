<div class="contact">
    <div class="contact_form" style="margin: 0 auto; float: none;">
        <form method="post" id="checkout" action="/<?= $form_url; ?>">
            <input type="hidden" name="form_type" value="1">

            <div style="color: red; text-align: center;">
                <?= validation_errors(); ?>
            </div>

            <ul class="forms">
                <li class="txt">Логин *</li>
                <li class="inputfield">
                    <input type="text" name="login" value="<?= set_value('login'); ?>" placeholder="Логин" class="bar required">
                </li>
            </ul>
            <ul class="forms">
                <li class="txt">E-mail *</li>
                <li class="inputfield">
                    <input type="text" name="email" value="<?= set_value('email'); ?>" placeholder="E-mail" class="bar required">
                </li>
            </ul>
            <ul class="forms">
                <li class="txt">Пароль *</li>
                <li class="inputfield">
                    <input type="password" name="password" value="" placeholder="Пароль" class="bar required">
                </li>
            </ul>

            <div class="clear"></div>
            <ul class="forms">
                <li>
                    <a href="#" id="sendmail" class="simplebtnsmall"><span>Регистрация</span></a>
                </li>
            </ul>
        </form>
        <div style="float: right; padding: 5px">
            <a href="/<?= $form_url; ?>?form=log" style="margin: 0 10px;">Авторизация</a>
            <a href="/<?= $form_url; ?>?form=rem" style="margin: 0 10px;">Восстановление пароля</a>
        </div>
        <div class="clear"></div>
    </div>
</div>

<script type="text/javascript">
  $('#sendmail').click(
    function ()
    {
      $('#checkout').submit();
    }
  );
</script>