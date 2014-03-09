<div class="equip_title" ><img style="width:60px; height:44px;" src="/../www_site/img/equip_1.png"/>Экипировка для квадроцикла</div>
    <?if ( isset($widgets['main_slider4']['items'])>0):?>
            <ul class="equip_list clearfix">
            <?foreach($widgets['main_slider4']['items'] as $key4=>$value4):?>
                <li class="equip_unit">
                    <a class="sale_link" href="<?=$value4['item']->link;?>"><?=$value4['item']->title;?></a>
                    <div class="sale_img"><a href="<?=$value4['item']->link;?>"><img style="width:146px;height:130px" src="<?= base_url('/upload/images/banner/'.$value4['maxi']->getFilenameThumb()); ?>" alt=""/></a></div>
                </li>
            <?endforeach;?>
            </ul>
    <?endif;?>