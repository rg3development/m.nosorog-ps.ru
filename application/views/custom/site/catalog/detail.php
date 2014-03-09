<?
// цикл получения всех изображений товара.
/*
  <? foreach ( $item->images() as $product_image ) : ?>
    <img src="<?= $item->img_src($product_image); ?>" />
  <? endforeach; ?>
*/

// форма добавления товара в корзину
// менять только селектор обработчика JS .click()
/*
  <? $item->add_to_cart(); ?>
*/

// массив похожих товаров
/*
  $similar
*/
/*
  $item->description()    = полное описание товара (с форматрованием)
  $item->description(100) = краткое описание товара (без форматрованием)
*/
/*
  $item->in_stock()       = строковое представление поля "Товар в наличии"
  $item->in_stock(TRUE)   = булево представление поля "Товар в наличии"
*/
?>


<div class="item_controls_block clearfix">
<?$cat= $item->category();?>
                <a class="yellow_btn go_back_btn" href="<?= $cat->category_link ();?>">Назад</a>

                        <div class="new_price"><?= $item->price_discount() !== $item->price() ? $item->price_discount() : $item->price() ; ?><span> Руб.</span></div>
                   
            </div>
            <div class="slider_title"><?= $item->title; ?></div>
            <div class="item_slider_w">
                <div class="item_next"></div>
                <div class="item_prev"></div>
                <?$images=$item->images();?>
                <ul id="item_slider" class="item_slider">
                <?if(!empty($images)):?>  
                    <?foreach($images as $key=>$img):?>
                    <li class="item_slide"><img style="width: 320px;" src="<?= $item->img_src_thumb($img); ?>" alt=""/></li>
                    <?endforeach;?>
                <?endif;?>    
                </ul>
            </div>
            <div class="buy_controls clearfix">
                <a href="#" id="add_to_cart" class="yellow_btn add_item">Добавить в корзину</a>
                    <form id="cart_add" method="post">
                        <input type="hidden" name="type" value="add" />
                        <input type="hidden" name="qty" value="1" />
                        <input type="hidden" name="item_id" value="<?=$item->id;?>" />
                        <?if(!empty($item->size)):?> 
                        <?$sizer=explode(';',$item->size);?>
                        <?$sizes=$this->diff_func_mapper->get_size($sizer[0]);?>
                        
                        <input name="size2" class="size2" value="<?=$sizes['title'];?>" type="hidden"/>
                        <?endif;?>
                    </form>
                <a id="buy_1_click" href="#" class="yellow_btn go_checkout">Купить в 1 клик</a>
            </div>
            
            


            <div class="item_dimensions clearfix">
            <? if ( validation_errors() ) : ?>
              <div class="alert">
               <?= validation_errors(); ?>
              </div>
              </br>
            <? endif; ?>
                <?if(!empty($item->size)):?>
                <?$sizer=explode(';',$item->size);?>

                   
                <div class="select_box">
                
                    <div class="select_label">Размер</div>
                    <div class="select_drop_down">
                    
                    <?$sizes=$this->diff_func_mapper->get_size($sizer[0]);?>
                        <div class="select_value"><?=$sizes['title'];?></div>
                        <ul class="select_list">
                        <?foreach($sizer as $key=>$size):?>
                         <?$size=$this->diff_func_mapper->get_size($size);?> 
                         <?if(!empty($size)):?>
                            <li class="dels select_item"><?=$size['title'];?></li> 
                         <?endif;?>
                        <?endforeach;?>
                        </ul>
                   
                    </div>
                </div>
                 
                <?endif;?>
                <?if(!empty($item->color)):?>
                <?$color=$this->diff_func_mapper->get_colour($item->color);?>                
                <div class="select_box">
                    <div class="select_label">Цвет</div>
                    <div class="select_drop_down">
                        <div class="select_value"><?=$color['title'];?></div>                    
                        <ul class="select_list">
                            <li class="sels select_item"><?=$color['title'];?></li>  
                        </ul> 
                    </div>
                </div>
                <?endif;?>
                <?if(!empty($item->brend_kol)):?>
                <?$brend=$this->diff_func_mapper->get_brend($item->brend_kol);?>                
                <div class="select_box">
                    <div class="select_label">Бренд</div>
                    <div class="select_drop_down">
                        <div class="select_value"><?=$brend['title'];?></div>                    
                        <ul class="select_list">
                            <li class="sels select_item"><?=$brend['title'];?></li>  
                        </ul> 
                    </div>
                </div>
                <?endif;?>

            </div>
            <div class="yellow_btn page_title2 mod_slide_down " style=" color: #FFF;">Описание</div>
            <div class="item_info">
                <div class="item_description">
                    <?= $item->description(); ?>
                </div>
                <div>
                    <p>
                      <?= $item->in_stock(); ?>
                    </p>
                </div>
            </div>


<script>

  $(document).ready(function() {

    $('#add_to_cart').click(function() {
      $('#cart_add').submit();
      return false;
    });

  });

</script>