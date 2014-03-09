                <ul class="buy_block">
                <form action="/catalog" method="post" name="order">
                    <input type="hidden" name="type" value="upd">
                    <? foreach ( $this->cart->contents() as $index => $item ): ?>
                      <? $cur_item = $this->catalog_mapper->get_object($item['id'], 'item'); ?>
                        <li class="buy_unit clearfix">
                            <div class="buy_img"><a href="<?= $cur_item->url(); ?>"><img style="width: 71px;" src="<?= $cur_item->image(); ?>" alt=""/></a></div>
                            <a class="sale_link" href="<?= $cur_item->url(); ?>"><?= $cur_item->title; ?></a>

                            <div class="buy_price">
                                <div class="new_price"><?= $cur_item->price_discount(); ?><span> Руб.</span></div>
                                <input type="hidden" name="my_ids[]" value="<?= $item['rowid']; ?>">
                                <input  class="buy_quantity" size="4" value="<?= $item['qty']; ?>" name="my_qty[]">
                                <a class="remove" style="position: absolute;right: 20%;bottom: 17%;text-decoration: initial;color: cornflowerblue;font: 22px/1 RobotoReg, sans-serif;" title="Удалить из корзины" href="#" onclick='document.forms["delete<?= $item['id']; ?>"].submit();'>×</a>
                            </div>
                            <div class="buy_info">
                                <p>Размер: <?= $item['size']; ?></p>
                                <?if(!empty($cur_item->color)):?>
                                    <?$color=$this->diff_func_mapper->get_colour($cur_item->color);?> 
                                    <p>Цвет: <?=$color['title'];?></p>
                                <?endif;?>    
                                <?if(!empty($cur_item->brend_kol)):?>
                                    <?$brend=$this->diff_func_mapper->get_brend($cur_item->brend_kol);?>  
                                    <p>Бренд: <?=$brend['title'];?></p>
                                <?endif;?>
                            </div>
                        </li>
                    <?endforeach;?>
                </form>

                </ul>
                <div class="center_holder">
                    <div class="total_price">Сумма всех заказов:
                        <div class="new_price"><?= $total_price; ?><span>  Руб.</span></div>
                    </div>
                </div>
                <div class="buy_controls clearfix">
                    
                    <a class="yellow_btn go_checkout2"  href="/catalog" >Продолжить покупки</a>
                    <a href="#"  class="gray_btn go_shopping2" onclick='document.forms["order"].submit();'>Обновить корзину</a>
                    <a class="yellow_btn go_checkout2"  href="#" onclick='document.forms["checkout"].submit();'>Оформить заказ</a>
                </div>


      <? foreach ( $this->cart->contents() as $index => $item ): ?>
        <form name="delete<?=$item['id'];?>" action="/catalog" method="post">
          <input type="hidden" name="rowid" value="<?= $item['rowid']; ?>">
          <input type="hidden" name="type" value="del">
        </form>
      <? endforeach; ?>
      <form name="checkout" method="post">
        <input type="hidden" name="type" value="order_1">
      </form>
    </tbody>
  </table>
</div>

