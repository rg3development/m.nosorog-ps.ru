<?
// цикл получения всех изображений товара. доступно внутри цикла
// foreach ( $catalog_products as $index => $product )
/*
  <? foreach ( $product->images() as $product_image ) : ?>
    <img src="<?= $product->img_src($product_image); ?>" />
  <? endforeach; ?>
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
<div class="catalog_description">
                            <?$main_slider7 = $this->banner_mapper->get_widget(7);?>
            <?if ( isset($main_slider7['items'])>0):?>
                
                    <?foreach($main_slider7['items'] as $key7=>$value7):?>
                        
                            <?=$value7['item']->description;?>

                    <?endforeach;?>
                
            <?endif;?>
            </div>

            <?if(!empty($_GET['cat'])):?>
                <?$categor=$this->catalog_mapper->get_category_2($_GET['cat']);?>
            <div class="page_title mod_1"><?=$categor->title;?>
            <?else:?>
            <div class="page_title mod_1">Каталог
            <?endif;?>
                <div class="filter_block">Фильтры</div>
            </div>
            <?$sizes =$this->diff_func_mapper->sizes();?>
            <?$brends =$this->diff_func_mapper->brends();?>
            <?$colours =$this->diff_func_mapper->colours();?>
            <div class="filter_drop_down clearfix">

                <div class="select_box">
                    <div class="select_label">Размер</div>
                    <div class="select_drop_down">
                    
                        <div class="select_value">ALL</div>
                        <?if(!empty($sizes)):?>
                        <ul class="select_list mod_wide" style="">
                            <?foreach($sizes as $key=>$size):?>
                            <?if($size['title'] != ''):?>
                                <li class="sel1 select_item"><?=$size['title']?></li>
                            <?endif;?>
                            <?endforeach;?>
                        </ul>
                        <?endif;?>
                    </div>
                </div>
                <div class="select_box">
                    <div class="select_label">Цвет</div>
                    <div class="select_drop_down">
                        <div class="select_value">ALL</div>
                        <?if(!empty($colours)):?>
                        <ul class="select_list mod_wide">
                            <?foreach($colours as $key=>$colour):?>
                                <li class="sel2 select_item"><?=$colour['title']?></li>
                            <?endforeach;?>
                        </ul>
                        <?endif;?>
                    </div>
                </div>
                <div class="select_box">
                    <div class="select_label">Бренд</div>
                    <div class="select_drop_down">
                        <div class="select_value">All</div>
                        <?if(!empty($brends)):?>
                        <ul class="select_list mod_wide">
                            <?foreach($brends as $key=>$brend):?>
                                <li class="sel3 select_item"><?=$brend['title']?></li>
                            <?endforeach;?>
                        </ul>
                        <?endif;?>
                    </div>
                </div>

                <a href="#" onclick='document.forms["filter"].submit();' class="gray_btn go_shopping filter_apply_btn">Применить</a>

            </div>
            <? if ( isset($catalog_products) && !empty($catalog_products) ) : ?>
            <ul class="sales_block mod_catalog_2 clearfix">
            <? foreach ( $catalog_products as $index => $product ) : ?>
                <li class="sale_unit">
                    <div style="height: 28px;"><a class="sale_link" href="<?= $product->url(); ?>"><?= $product->title; ?></a></div>

                    <div class="sale_img"><a href="<?= $product->url(); ?>"><img style="max-width: 140px; height: 120px;" src="<?= $product->thumb(); ?>" alt=""/></a></div>
                    <div class="sale_price">
                    <?if($product->price_discount() !== $product->price()):?>
                        <div class="new_price"><?= $product->price_discount(); ?><span> Руб.</span></div>
                        <div class="old_price"><?= $product->price(); ?><span> Руб.</span></div>
                    <?else:?>
                        <div class="new_price"><?= $product->price(); ?><span> Руб.</span></div>
                    <?endif;?>
                    </div>
                    <a class="add2cart_btn yellow_btn " href="<?= $product->url(); ?>">Добавить в корзину</a>
                </li>
                <?endforeach;?>
            </ul>
            <?endif;?>
            <div class="pagination_block">
                <?= ! empty($paginator) ? $paginator : ''; ?>
            </div>
            <form action="#" method="get" id="filter">
                <?if(!empty($_GET['cat'])):?>
                    <input type="hidden" name="cat" value="<?=$_GET['cat'];?>"/>
                <?endif;?>
                <input type="hidden" name="type" value="filter">
                <input type="hidden" name="sizez" class="item1" value="0">
                <input type="hidden" name="colorz" class="item2" value="0">
                <input type="hidden" name="brendz" class="item3" value="0">
            </form>