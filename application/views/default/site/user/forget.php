<div class="contact">
    <div class="contact_form" style="margin: 0 auto; float: none;">
        <form method="post" action="/<?= $form_url; ?>" id="checkout">
            <input type="hidden" name="form_type" value="3">

            <div style="color: red; text-align: center;">
                <?= validation_errors(); ?>
            </div>

            <ul class="forms">
                <li class="txt">E-mail *</li>
                <li class="inputfield">
                    <input type="text" name="email" value="" placeholder="E-mail" class="bar required">
                </li>
            </ul>

            <div class="clear"></div>
            <ul class="forms">
                <li>
                    <a href="#" id="sendmail" class="simplebtnsmall"><span>Восстановить</span></a>
                </li>
            </ul>
        </form>
        <div style="float: right; padding: 5px">
        	<a href="/<?= $form_url; ?>?form=reg" style="margin: 0 10px;">Регистрация</a>
        	<a href="/<?= $form_url; ?>?form=log" style="margin: 0 10px;">Авторизация</a>
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