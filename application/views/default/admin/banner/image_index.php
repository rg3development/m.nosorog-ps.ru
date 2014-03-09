<div class="admin_module_title">
    <h4><?=!empty($module_title) ? $module_title : '';?></h4>
</div>
<div id="content">
    <div class="photo_module">
    <?$keyz=0;?>
    <? if ( !empty($list) ) : ?>
        <? foreach ($list as $keyz => $item2) : ?>
        <?endforeach;?>
    <?endif;?>
    
    <?if($parent_id == 8):?>
        <?if ($keyz <3):?>
        <div class="admin_module_form right_buttons">
            <a href="<?= base_url("admin/banner/add_image/{$parent_id}"); ?>"><button class="g-button">создать</button></a>
        </div>
        <?endif;?>
    <?else:?>
        <div class="admin_module_form right_buttons">
            <a href="<?= base_url("admin/banner/add_image/{$parent_id}"); ?>"><button class="g-button">создать</button></a>
        </div>
    <?endif;?>
        <div class="admin_module_list">
            <ul class="admin_list photo_image_list">
                <? if ( !empty($list) ) : ?>
                    <? foreach ($list as $key => $item) : ?>
                        <li id="text<?=$item->id;?>" onmouseover="$(this).children().children().css('color', '#0099cc')" onmouseout="$(this).children().children().css('color', '#666666')">
                            <a href="<?= base_url("admin/banner/edit_image/{$item->id}/{$parent_id}"); ?>" title="редактировать">
                                <em><?=$item->title;?></em>
                            </a>
                            <a href="<?= base_url("admin/banner/delete_image/{$item->id}/{$parent_id}"); ?>" class="admin_form_action_page" onclick="if (confirm('Вы уверены?')) return true; else return false;" title="удалить">
                                <img title="удалить" alt="удалить" src="<?= base_url('www_admin/img/icon_delete_1.5.png'); ?>" />
                            </a>
                            <a href="<?= base_url("admin/banner/edit_image/{$item->id}/{$parent_id}"); ?>" class="admin_form_action_page" title="редактировать">
                                <img title="редактировать" alt="редактировать" src="<?= base_url('www_admin/img/icon_edit_1.5.png'); ?>"/>
                            </a>
                            <span class="admin_form_action_page" style="margin: 0 15px 0;" title="Приоритет">
                                <?= $item->priority; ?>
                            </span>
                            <? if ( isset($images[$key]) && $images[$key] ) : ?>
                                <a href="<?= base_url("admin/banner/edit_image/{$item->id}/{$parent_id}"); ?>" title="редактировать">
                                    <img src="<?= base_url("{$path_to_image}/{$images[$key]}"); ?>" class="admin_form_action_page" width="100" />
                                </a>
                            <? else: ?>
                                <img src="<?= base_url('www_admin/img/noimage160.png'); ?>" class="admin_form_action_page" width="100" />
                            <? endif; ?>
                            <div class="banner_admin_visibility">
                                <a id="<?=$item->id;?>_<?=$parent_id;?>" href="#" onclick="swap(<?=$item->id;?>,<?=$parent_id;?>); return false;">
                                    <?= $item->display ? "видим" : "скрыт" ?>
                                </a>
                            </div>
                            <? if ( $item->link ) : ?>
                                <br>
                                <p class="banner_admin_link">
                                    <a target="_blank" href="<?=$item->link?>"><?=$item->link?></a>
                                </p>
                            <? endif; ?>
                            <div class="clear"></div>
                        </li>
                    <? endforeach; ?>
                <? endif; ?>
            </ul>
        </div>
    </div>
</div>

<script>
    function swap(aa,bb) {
        $.get('/admin/banner/edit_image/'+aa+'/'+bb+'/1', function(data) {
            console.log(data);
            if ( data < 0 )
            {
                alert("Уже задано максимальное количество картинок!");
                return false;
            }
            $('#'+aa+'_'+bb).text((data==1)?"видим":"скрыт");
        });
    }
</script>