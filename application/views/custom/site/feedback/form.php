<div class="order_caption">
    <?= $fb_form->title; ?>
</div>
<p class="error">
    <?= validation_errors(); ?>
</p>
<div class="order_form">
    <form name="form" id="contact_<?= $fb_form->id; ?>" action="" method="post">
        <? foreach ( $fb_fields as $key => $field ) : ?>
            <? $field_name = "fname_{$fb_form->id}_{$key}"; ?>
            <? if ( $field->type == 4 ) : ?>
                <textarea class="text_order" name="<?= $field_name; ?>" ><?= set_value($field_name); ?></textarea>

            <? elseif ( $field->type == 5 ) : ?>
                <select name="<?= $field_name; ?>">
                    <? $cur_fields = explode(',', $field->selector_val); ?>
                    <? foreach ( $cur_fields as $key => $value ) : ?>
                        <option value="<?= $value; ?>"><?= $value; ?></option>
                    <? endforeach; ?>
                </select>

            <? else: ?>
                <input class="input_order" type="text" name="<?= $field_name; ?>" placeholder="<?= $field->title; ?>" value='<?= set_value($field_name); ?>'>

            <? endif; ?>
        <? endforeach; ?>        
    </form>
</div>
<div class="buy_controls clearfix">
    <a href="/" class="gray_btn go_shopping">Отменить</a>
    <a href="#" onclick='document.forms["form"].submit();' class="yellow_btn go_checkout">Написать</a>
</div>
<div class="cart_tip">* Обязятельные для заполнения поля. Убедитесь в
                                      правильности заполнения данных, иначе мы не
                                      сможем доставить вам заказ
</div>