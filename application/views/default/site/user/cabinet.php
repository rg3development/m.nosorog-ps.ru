<?
/*
Array (
    [order] => stdClass Object
    [items] => Array (
        [cart]    => stdClass Object
        [catalog] => Catalog_Item Object
    )
);
*/
?>
<div class="contact">
    <div class="contact_form" style="width: 680px;">
        <div style="padding: 10px;">
            <h1>
                История заказов
            </h1>
            <? if ( ! empty($order_list) ) : ?>
                <? foreach ( $order_list as $key => $order_item ) : ?>
                    <ul class="order_list">
                        <li class="order_num">
                            <p>
                                Номер заказа: <?= $order_item['order']->id; ?>
                            </p>
                            <p>
                                Дата заказа: <?= date('H:i:s d-m-Y', strtotime($order_item['order']->date_created)); ?>
                            </p>
                            <p>
                                Сумма заказа: <?= $order_item['order']->order_total; ?> руб.
                            </p>
                        </li>
                        <? foreach ( $order_item['items'] as $index => $item ) : ?>
                            <li class="order_item">
                                <span>
                                    <?= $index + 1; ?>.
                                </span>
                                <a href="<?= $item['catalog']->url(); ?>">
                                    <?= $item['catalog']->title; ?>
                                </a>|
                                <?= $item['cart']->qty; ?> шт. | <?= $item['cart']->base_price; ?> руб.
                            </li>
                        <? endforeach; ?>
                    </ul>
                <? endforeach; ?>
            <? else: ?>
                <p>
                    Список заказов пуст.
                </p>
            <? endif; ?>
        </div>
        <div style="float: right; padding: 5px">
            <a href="/<?= $form_url; ?>?cmd=logout" style="margin: 0 10px;">Выход</a>
        </div>
        <div class="clear"></div>
    </div>
</div>