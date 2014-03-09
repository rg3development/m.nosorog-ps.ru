<div class="main_row">
            <?if ( isset($widgets['main_slider1']['items'])>0):?>
                <ul class="equipment_list">
                    <?foreach($widgets['main_slider1']['items'] as $key1=>$value1):?>
                        <li class="equipment_item">
                            <a class="equipment_link" href="/<?=$value1['item']->link;?>">
                                <img src="<?= base_url('/upload/images/banner/'.$value1['maxi']->getFilenameThumb()); ?>" alt=""/>
                                <?=$value1['item']->description;?>
                            </a>
                        </li>
                    <?endforeach;?>
                </ul>
            <?endif;?>
            <?if ( isset($widgets['main_slider2']['items'])>0):?>
                <div class="slider_wrapper">                
                    <div class="slider_pagination"></div>
                    <ul id="main_slider" class="main_slider">
                        <?foreach($widgets['main_slider2']['items'] as $key2=>$value2):?>
                            <li class="slide">
                                <div class="slide_caption"><?=$value2['item']->title;?></div>
                                <img src="<?= base_url('/upload/images/banner/'.$value2['maxi']->getFilenameThumb()); ?>" alt=""/>
                            </li>
                        <?endforeach;?>
                    </ul>
                </div>
            <?endif;?>
            <?$catalog_null=$this->diff_func_mapper->get_category_null();?>
            <?if(!empty($catalog_null)):?>
                <ul class="slide_menu">
                <?foreach($catalog_null as $index=> $cat_n):?>
                    <li class="menu_item drop_down">
                        <a class="menu_link yellow_btn icon_<?=$index+1;?>" href="#"><?=$cat_n->title;?></a>
                        <?$catalog_first=$this->diff_func_mapper->get_category_first($cat_n->id);?>
                        <?if(!empty($catalog_first)):?>
                            <ul class="drop_list">
                                <?foreach($catalog_first as $index=> $cat_f):?>
                                <?$catal=$this->catalog_mapper->get_category_item_list($cat_f->id);?>
                                    <?if(!empty($catal)):?>
                                        <li class="drop_item"><a class="drop_link" onclick="window.location.href='/catalog?cat=<?=$cat_f->id?>'" href="#"><?=$cat_f->title;?></a></li>
                                    <?endif;?>    
                                <?endforeach;?>
                            </ul>
                        <?else:?>
                            <?$catalog_first=$this->catalog_mapper->get_category_item_list($cat_n->id);?>
                            <?if(!empty($catalog_first)):?>
                                <ul class="drop_list">
                                    <?foreach($catalog_first as $index=> $cat_f):?>
                                        <li class="drop_item"><a class="drop_link" onclick="window.location.href='/catalog?item=<?=$cat_f->id?>'" href="#"><?=$cat_f->title;?></a></li>
                                    <?endforeach;?>
                                </ul>
                            <?endif;?>
                        <?endif;?>
                    </li>
                <?endforeach;?>    
                    <li class="menu_item mod_share ">
                        <a class="menu_link icon_1" href="/action">Акции</a>
                        <ul class="mod_vis">
                            <?=$menu;?>
                        </ul>
                    </li>
                </ul>
            <?endif;?>
            <?$sale_prod=$this->diff_func_mapper->get_sale_product(4);?>
            <?if(!empty($sale_prod)):?>                        
                <div class="page_title">Распродажа</div>
                <ul class="sales_block clearfix">
                <?foreach($sale_prod as $keys1=>$sale_p):?>
                    <li class="sale_unit">
                        <a class="sale_link" href="<?= $sale_p->url(); ?>"><?= $sale_p->title; ?></a>

                        <div class="sale_img"><a href="<?= $sale_p->url(); ?>"><img style="height: 120px;" src="<?= $sale_p->thumb(); ?>" alt=""/></a></div>
                        <div class="sale_price">
                        <?if( $sale_p->price_discount() !== $sale_p->price()):?>
                            <div class="old_price"><?=$sale_p->price(); ?> Руб.</div>
                            <div class="new_price"><?=$sale_p->price_discount(); ?><span> Руб.</span></div>
                        <?else:?>    
                            <div class="new_price"><?=$sale_p->price(); ?><span> Руб.</span></div>
                        <?endif;?>
                        </div>
                        <a class="add2cart_btn yellow_btn " href="<?= $sale_p->url(); ?>">Добавить в корзину</a>
                    </li>
                <?endforeach;?>
                </ul>
            <?endif;?>
            </div>