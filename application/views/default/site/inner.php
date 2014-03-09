<div>
    <h1>
        <?= $page_info['title']; ?>
    </h1>

    <? if ( isset($widgets['search_form']) ) : ?>
        <?= $widgets['search_form']; ?>
    <? endif; ?>

    <?= $content; ?>

</div>