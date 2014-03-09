<div class="equip_title" ><img style="width:60px; height:44px;" src="/../www_site/img/equip_3.png"/>Экипировка для снегохода</div>
    <?if ( isset($widgets['main_slider6']['items'])>0):?>
            <ul class="equip_list clearfix">
            <?foreach($widgets['main_slider6']['items'] as $key6=>$value6):?>
                <li class="equip_unit">
                    <a class="sale_link" href="<?=$value6['item']->link;?>"><?=$value6['item']->title;?></a>
                    <div class="sale_img"><a href="<?=$value6['item']->link;?>"><img style="width:146px;height:130px" src="<?= base_url('/upload/images/banner/'.$value6['maxi']->getFilenameThumb()); ?>" alt=""/></a></div>
                </li>
            <?endforeach;?>
            </ul>
    <?endif;?>