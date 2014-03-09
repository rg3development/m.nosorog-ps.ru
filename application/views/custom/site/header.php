<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <title><?=$page_info['title'];?> - <?=$site_settings['title'];?></title>
    <meta name="viewport" content="width=device-width">
    <meta name="keywords" content="<?=!empty($page_info['keywords']) ? $page_info['keywords'] : $site_settings['keywords'];?>">
    <meta name="description" content="<?=!empty($page_info['description']) ? $page_info['description'] : $site_settings['description'];?>">

    <script src="/../www_site/js/jquery-1.9.0.min.js"></script>
    <script src="/../www_site/js/modernizr.2.js"></script>
    <script src="/../www_site/js/respond.src.js"></script>
    <script src="/../www_site/js/jquery.bxslider.min.js"></script>
    <script src="/../www_site/js/jquery.validate.js"></script>
    <link rel="stylesheet" href="/../www_site/css/style.css" media="all">
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:400,600&subset=latin,cyrillic' rel='stylesheet'
          type='text/css'>

    <!--[if gt IE 8]><!-->
    <!--<![endif]-->
    <!--[if IE 8]>
    <link rel="stylesheet" href="css/ie8.css" media="all">
    <![endif]-->
    <script src="/../www_site/js/script.js"></script>
</head>
<body>
<?$catalog_null=$this->diff_func_mapper->get_category_null();?>
<div class="wrapper">
    <div id="mega_menu" class="mega_menu">
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
                <a class="menu_link icon_6" href="/action">Акции</a>
                <ul class="mod_vis">
                    <?=$menu;?>
                </ul>
            </li>
        </ul>
    <?endif;?>
    </div>
    <div class="base">
        <div class="overlay"></div>
        <?if(!empty($_GET['item'])):?>
        <div id="one_click_form" class="one_click_form">
            <div class="form_title ">Купить в один клик</div>
            <div class="form_body">
                <form name="check" class="checks" method="post" action="#">
                    <div class="form_description">Чтобы оформить заказ, заполните форму. С вами свяжется менеджер и
                                                  уточнит детали заказа а так-же время доставки.
                    </div>
                      <? if ( validation_errors() ) : ?>
                      <div class="alert">
                        <?= validation_errors(); ?>
                      </div>
                    <? endif; ?>
                    <input name="name2" class="input_order" placeholder="Имя*" type="text"/>
                    <input name="tel2" class="input_order" placeholder="Телефон*" type="text"/>
                    <input name="email2" class="input_order" placeholder="Email*" type="text"/>
                    <input name="id_tovar" value="<?=$_GET['item'];?>" type="hidden"/>
                    <input name="size1" value="L" type="hidden"/>
                    <input name="type" value="quick_click" type="hidden"/>
                    <label class="order_comment_label" for="order_comment">Адрес доставки и комментарий к заказу</label>
                    <textarea name="adr2" id="order_comment" class="order_comment input_order"></textarea>

                    <div class="center_holder">
                        <a href="#" class="gou yellow_btn go_checkout">Оформить заказ</a>
                    </div>
                </form>
            </div>
        </div>
        <?endif;?>
        <div class="header clearfix">
            <?$cur_item2=0;?>
            
                <? foreach ( $this->cart->contents() as $index => $item ): ?>
                    <? $cur_item2 = $item['qty']+$cur_item2;?>
                <?endforeach;?>
            <?if(($this->cart->format_number($this->cart->total()))!=0):?>
            <div class="yellow_btn cart_btn" onclick="window.location.href='/cart'" ><?=$cur_item2;?></div>
            <?else:?>
            <div class="yellow_btn cart_btn" onclick="window.location.href='/cart'" >0</div>
            <?endif;?>
            <a id="main_menu_btn" class="menu yellow_btn" href="#">МЕНЮ</a>
            <a href="/" ><img class="logo" src="<?=$site_settings['logo'];?>"></a>
            <?if ( isset($widgets['main_slider3']['items'])>0):?>
            <a class="phone_header" href="tel:<?=strip_tags($widgets['main_slider3']['items'][0]['item']->description);?>"><?=strip_tags($widgets['main_slider3']['items'][0]['item']->description);?></a>
            <?endif;?>
        </div>
        <div class="search_block">
            <? if ( isset($widgets['search_form']) ) : ?>
                <?= $widgets['search_form']; ?>
            <? endif; ?>
        </div>