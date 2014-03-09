<div class="contact">
    <div class="contact_form" style="margin: 0 auto; float: none;">
        <form method="post" action="/<?= $form_url; ?>" id="checkout">
            <input type="hidden" name="form_type" value="4">

            <input type="hidden" name="rem_user" value="<?= $rem_user; ?>">
            <input type="hidden" name="rem_hash" value="<?= $rem_hash; ?>">

            <div style="color: red; text-align: center;">
                <?= validation_errors(); ?>
            </div>

            <ul class="forms">
                <li class="txt">Пароль *</li>
                <li class="inputfield">
                    <input type="password" name="password" value="" placeholder="Пароль" class="bar required">
                </li>
            </ul>
            <ul class="forms">
                <li class="txt">Повторить *</li>
                <li class="inputfield">
                    <input type="password" name="password2" value="" placeholder="Пароль" class="bar required">
                </li>
            </ul>

            <div class="clear"></div>
            <ul class="forms">
                <li>
                    <a href="#" id="sendmail" class="simplebtnsmall"><span>Изменить</span></a>
                </li>
            </ul>
        </form>
        <div style="float: right; padding: 5px">
        	<a href="/<?= $form_url; ?>?form=reg" style="margin: 0 10px;">Регистрация</a>
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