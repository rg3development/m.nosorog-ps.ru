<div class="equip_title"><img style="width:60px; height:44px;" src="/../www_site/img/equip_2.png"/>Экипировка для гидроцикла</div>
    <?if ( isset($widgets['main_slider5']['items'])>0):?>
            <ul class="equip_list clearfix">
            <?foreach($widgets['main_slider5']['items'] as $key5=>$value5):?>
                <li class="equip_unit">
                    <a class="sale_link" href="<?=$value5['item']->link;?>"><?=$value5['item']->title;?></a>
                    <div class="sale_img"><a href="<?=$value5['item']->link;?>"><img style="width:146px;height:130px" src="<?= base_url('/upload/images/banner/'.$value5['maxi']->getFilenameThumb()); ?>" alt=""/></a></div>
                </li>
            <?endforeach;?>
            </ul>
    <?endif;?>