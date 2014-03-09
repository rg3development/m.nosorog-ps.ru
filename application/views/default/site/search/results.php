<? if ( isset($search_result) && $search_result['count'] ) : ?>
    <? foreach ( $search_result['text'] as $key => $result ) : ?>
        <div>
            <a href="<?= $result['link']; ?>">
                <?= $result['object']->title; ?>
            </a>
        </div>
    <? endforeach; ?>
    <? foreach ( $search_result['news'] as $key => $result ) : ?>
        <div>
            <a href="<?= $result['link']; ?>">
                <?= $result['object']->title; ?>
            </a>
        </div>
    <? endforeach; ?>
    <? foreach ( $search_result['catalog'] as $key => $result ) : ?>
        <div>
            <a href="<?= $result['object']->url(); ?>">
                <?= $result['object']->title; ?>
            </a>
        </div>
    <? endforeach; ?>
<? else: ?>
    <div>
        По вашему запросу ничего не найдено.
    </div>
<? endif;?>