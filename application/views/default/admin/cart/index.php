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

<div class="admin_module_title">
    <h4>
        <?= !empty($module_title) ? $module_title : '' ; ?>
    </h4>
</div>

<div id="content">

    <form action="" method="get">
        <div class="admin_sort">
            <h5>Фильтрация:</h5>
            <div>
                <p class="sort_title">
                    <a href="">кол-во</a>
                </p>
                <select name="f_limit">
                    <option value="0" <?= ( $f_limit == 0 ) ? 'selected' : ''; ?>>Все</option>
                    <option value="1" <?= ( $f_limit == 1 ) ? 'selected' : ''; ?>>1</option>
                    <option value="5" <?= ( $f_limit == 5 ) ? 'selected' : ''; ?>>5</option>
                    <option value="10" <?= ( $f_limit == 10 ) ? 'selected' : ''; ?>>10</option>
                    <option value="20" <?= ( $f_limit == 20 ) ? 'selected' : ''; ?>>20</option>
                    <option value="50" <?= ( $f_limit == 50 ) ? 'selected' : ''; ?>>50</option>
                    <option value="100" <?= ( $f_limit == 100 ) ? 'selected' : ''; ?>>100</option>
                    <option value="500" <?= ( $f_limit == 500 ) ? 'selected' : ''; ?>>500</option>
                </select>
            </div>
            <div>
                <p class="sort_title">
                    <a href="">сортировка</a>
                </p>
                <select name="f_sort_by">
                    <option value="id" <?= ( $f_sort_by == 'id' ) ? 'selected' : ''; ?>>номер заказа</option>
                    <option value="date_created" <?= ( $f_sort_by == 'date_created' ) ? 'selected' : ''; ?>>дата заказа</option>
                    <option value="payment_method" <?= ( $f_sort_by == 'payment_method' ) ? 'selected' : ''; ?>>способ оплаты</option>
                </select>
                <select name="f_sort_type">
                    <option value="ASC" <?= ( $f_sort_type == 'ASC' ) ? 'selected' : ''; ?>>по возрастанию</option>
                    <option value="DESC" <?= ( $f_sort_type == "DESC" ) ? 'selected' : ''; ?>>по убыванию</option>
                </select>
            </div>
            <div>
                <p class="sort_title">
                    <a href="">дата</a>
                </p>
                <p>
                    с: <input name="f_date_from" type="text" id="datepicker1" style="width: 100px;"  value="<?= $f_date_from; ?>" />
                    по: <input name="f_date_to" type="text" id="datepicker2" style="width: 100px;" value="<?= $f_date_to; ?>" />
                </p>
            </div>
            <div>
                <button class="styler">Фильтровать</button>
            </div>
        </div>
    </form>

    <ul class="admin_list admin_mainlist">
        <? if ( ! empty($cart_history) ) : ?>


            <? foreach ( $cart_history as $key => $order_item ) : ?>
                <li class="no_bg list_li">
                    <div class="menuline clearfix">
                        <span class="left" title="Номер заказа">
                            <strong>Заказ №:</strong> <?= $order_item['order']->id; ?> |
                            <strong>заказчик:</strong> <?= $order_item['order']->full_name; ?> |
                            <strong>дата:</strong> <?= date('H:i:s d-m-Y', strtotime($order_item['order']->date_created)); ?>
                        </span>
                        <span class="right" title="Сумма заказа">
                            <strong>Сумма заказа:</strong> <?= $order_item['order']->order_total; ?> руб.
                        </span>
                    </div>

                    <div class="clearfix">
                        <ul class="admin_list">
                            <li class="no_bg">
                                <div class="menuline clearfix">
                                    <span class="left">
                                        <strong>тел.:</strong> <?= $order_item['order']->phone; ?>,
                                        <strong>e-mail:</strong> <?= $order_item['order']->email; ?>,
                                        <strong>адрес:</strong> <?= $order_item['order']->address; ?>
                                    </span>
                                </div>
                            </li>
                            <li class="no_bg">
                                <div class="menuline clearfix">
                                    <span class="left">
                                        <strong>Комментарий:</strong> <?= $order_item['order']->comments; ?>
                                    </span>
                                </div>
                            </li>
                            <li class="no_bg">
                                <div class="menuline clearfix">
                                    <span class="left">
                                        <strong>товары:</strong> <?= $order_item['order']->items_total; ?>,
                                        <strong>позиции:</strong> <?= $order_item['order']->positions_total; ?>,
                                        <strong>оплата:</strong> <?= $this->cart_mapper->_payment_method($order_item['order']->payment_method); ?>
                                    </span>
                                </div>
                            </li>
                            <? foreach ( $order_item['items'] as $index => $item ) : ?>
                                <li>
                                    <div class="menuline clearfix">
                                        <span class="left" title="Позиция">
                                            <a href="">
                                                <?= $index + 1; ?>.
                                            </a>
                                        </span>
                                        <span class="left" title="Дата заказа">
                                            <a href="<?= $item['catalog']->url(); ?>" target="_blank">
                                                <?= $item['catalog']->title; ?>
                                            </a>|
                                            <?= $item['cart']->qty; ?> шт. | <?= $item['cart']->base_price; ?> руб.
                                        </span>
                                    </div>
                                </li>
                            <? endforeach; ?>
                        </ul>
                    </div>
                </li>
            <? endforeach; ?>
        <? else: ?>
            <p>
                Список заказов пуст.
            </p>
        <? endif; ?>
    </ul>
    <ul class="module_menu">
        <li>
            <a href="#to_top">наверх</a>
        </li>
    </ul>
</div>

<script type="text/javascript">
    $(document).ready(function() {

        $(function() {
            $( "#datepicker1").datepicker({
                'dateFormat': 'yy-mm-dd'
            });
            $( "#datepicker2").datepicker({
                'dateFormat': 'yy-mm-dd'
            });
        });

    });
</script>