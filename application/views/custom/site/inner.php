<div class="main_row" style="min-height: 400px;">
    <?if(($page_info['show_title'])>0):?>
    <div class="order_caption">
        <?= $page_info['title']; ?>
    </div>
    <?endif;?>
    <?= $content; ?>

</div>