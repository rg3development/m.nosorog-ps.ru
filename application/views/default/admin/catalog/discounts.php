<style type="text/css">
    .set_table {
        padding: 0px 0px 0px 80px;
        margin: 0px auto 0px auto;
    }
    .set_table input[type="text"] {
        width: 200px;
    }
    .set_title {
        width: 230px !important;
        padding-bottom: 10px;
    }
    .set_form {
        margin: 0 auto;
    }
</style>

<div class="admin_module_title">
    <h4>
        <?= $module['title']; ?>
    </h4>
</div>

<div id="content">
    <ul class="module_menu">
        <li>
            <a href="<?= $links['section_index']; ?>" title="вернуться к списку каталогов">
                <button class="styler">в каталог</button>
            </a>
        </li>
    </ul>

    <form action="/admin/catalog/discounts" method="post" class="set_form">
        <table class="set_table">
            <tr>
                <td colspan="3" class="admin_error_message"><?=validation_errors();?></td>
            </tr>
            <tr class="disc_row">
                <td colspan="3">
                    <input type="button" class="styler addField" value="Добавить" />
                    <input type="button" class="styler delField" value="Удалить" />
                </td>
            </tr>
            <? if ( !empty($discounts) ) : ?>
                <? foreach ( $discounts as $key => $value ) : ?>
                    <tr class="disc_row">
                        <td class="">
                            <p>Лимит</p>
                            <input type="text" name="order_limit[]" value="<?= $value->order_limit; ?>" />
                        </td>
                        <td class="">
                            <p>Скидка в рублях</p>
                            <input type="text" name="discount_price[]" value="<?= $value->discount_price; ?>" />
                        </td>
                        <td class="">
                            <p>Скидка в процентах (приоритетная)</p>
                            <input type="text" name="discount_percent[]" value="<?= $value->discount_percent; ?>" />
                        </td>
                    </tr>
                <? endforeach; ?>
            <? endif; ?>
            <tr>
                <td colspan="3">
                    <input type="submit" value="сохранить настройки" name="save" class="g-button" style="float: right;" />
                </td>
            </tr>
        </table>
    </form>

    <ul class="module_menu">
        <li>
            <a href="#to_top">наверх</a>
        </li>
    </ul>
</div>

<script language="javascript">

    $(document).ready(function() {

        $('input.addField').click(function() {
            $('tr.disc_row:last').after(
                '<tr class="disc_row">' +
                    '<td class="">' +
                        '<p>Лимит</p>' +
                        '<input type="text" name="order_limit[]" value="0" />' +
                    '</td>' +
                    '<td class="">' +
                        '<p>Скидка в рублях</p>' +
                        '<input type="text" name="discount_price[]" value="0" />' +
                    '</td>' +
                    '<td class="">' +
                        '<p>Скидка в процентах (приоритетная)</p>' +
                        '<input type="text" name="discount_percent[]" value="0" />' +
                    '</td>' +
                '</tr>'
            );
            $('input').styler();
        });

        $('input.delField').click(function() {
            var count = $('.disc_row').length;
            if ( count > 0 )
            {
                $('.disc_row:last').remove();
                $('input').styler();
            } else {
                alert('Не возможно удалить поле!');
            }
        });

    });

</script>