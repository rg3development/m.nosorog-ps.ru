<ul class="breadcrumbs">
    <?if($map[0]['url'] != '/'):?>
        <span> <a href="/">Главная</a></span>
    <?endif;?>
    <?foreach($map as $key=>$maps):?>
        <?if($map[0]['hkey'] == $key):?>
            <?break;?>
        <?endif;?>
    <?if($map[0]['url'] == '/'):?>
        <span> <a href="/">Главная</a></span>
    <?else:?>
        <span> <a href="/<?=$maps['url'];?>"><?=$maps['title'];?></a></span>
    <?endif;?>  
    <?endforeach;?>
    <?=$map[$key]['title'];?>
   
 </ul>
 