<div class="contact">
    <div class="contact_form" style="margin: 0 auto; float: none;">
    	<div style="padding: 10px;">
	    	<h1>
	    		<?= $message; ?>
	    	</h1>
    	</div>
    	<div style="float: right; padding: 5px">
    		<a href="/<?= $form_url; ?>?form=reg" style="margin: 0 10px;">Регистрация</a>
            <a href="/<?= $form_url; ?>?form=log" style="margin: 0 10px;">Авторизация</a>
            <a href="/<?= $form_url; ?>?form=rem" style="margin: 0 10px;">Восстановление пароля</a>
        </div>
        <div class="clear"></div>
    </div>
</div>