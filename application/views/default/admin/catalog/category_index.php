<div class="admin_module_title">
    <h4>
        <?= $module['title']; ?>
    </h4>
</div>

<div id="content">
    <ul class="module_menu">
        <li>
            <a href="<?= $section->link('cat_add'); ?>" title="создать новую категорию">
                <button class="styler">создать категорию</button>
            </a>
        </li>
        <li>
            <a href="<?= $links['section_index']; ?>" title="вернуться к списку каталогов">
                <button class="styler">в начало</button>
            </a>
        </li>
    </ul>
    <ul class="admin_list admin_mainlist">
        <h6>Список категорий в каталоге: <em class="sub_title"><?= $section->title; ?></em></h6>
        <? foreach ( $category_list as $category ): ?>
            <li>
                <div class="menuline clearfix">
                    <span class="left">
                        <a href="<?= $category['item']->link('items'); ?>" title="просмотреть список товаров в категории">
                            <?= $category['item']->title; ?>
                        </a>
                    </span>
                    <span class="right">
                        <a href="<?= $category['item']->link('del'); ?>" class="admin_form_action_page" onclick="if (confirm('Вы уверены? Будут удалены все категории в данном каталоге!')) return true; else return false;" title="удалить">
                            <img title="удалить" alt="удалить" src="/www_admin/img/icon_delete_1.5.png" />
                        </a>
                    </span>
                    <span class="right">
                        <a href="<?= $category['item']->link('edit'); ?>" class="admin_form_action_page" title="редактировать">
                            <img title="редактировать" alt="редактировать" src="/www_admin/img/icon_edit_1.5.png"/>
                        </a>
                    </span>
                    <span class="right catalogs" title="кол-во товаров">
                        Товары: <?= $category['item']->num_products(); ?>
                    </span>
                    <span class="right priority" title="порядок">
                        <?= $category['item']->priority; ?>
                    </span>
                    <? if ($category['item']->discount_price > 0) : ?>
                        <span class="right" title="скидка">
                            <strong>Скидка:</strong> <?= $category['item']->discount_price; ?>
                        </span>
                    <? endif; ?>
                    <? if ($category['item']->discount_percent > 0) : ?>
                        <span class="right" title="скидка %">
                            <strong>Скидка %:</strong> <?= $category['item']->discount_percent; ?>
                        </span>
                    <? endif; ?>
                </div>
                <div class="clearfix">
                    <ul class="admin_list">
                        <? foreach ( $category['list'] as $key => $subvalue ) : ?>
                            <li>
                                <div class="menuline clearfix">
                                    <span class="left">
                                        <a href="<?= $subvalue->link('items'); ?>" title="просмотреть список товаров в категории">
                                            <?= $subvalue->title; ?>
                                        </a>
                                    </span>
                                    <span class="right">
                                        <a href="<?= $subvalue->link('del'); ?>" class="admin_form_action_page" onclick="if (confirm('Вы уверены? Будут удалены все категории в данном каталоге!')) return true; else return false;" title="удалить">
                                            <img title="удалить" alt="удалить" src="/www_admin/img/icon_delete_1.5.png" />
                                        </a>
                                    </span>
                                    <span class="right">
                                        <a href="<?= $subvalue->link('edit'); ?>" class="admin_form_action_page" title="редактировать">
                                            <img title="редактировать" alt="редактировать" src="/www_admin/img/icon_edit_1.5.png"/>
                                        </a>
                                    </span>
                                    <span class="right catalogs" title="кол-во товаров">
                                        Товары: <?= $subvalue->num_products(); ?>
                                    </span>
                                    <span class="right priority" title="порядок">
                                        <?= $subvalue->priority; ?>
                                    </span>
                                    <? if ($subvalue->discount_price > 0) : ?>
                                        <span class="right" title="скидка">
                                            <strong>Скидка:</strong> <?= $subvalue->discount_price; ?>
                                        </span>
                                    <? endif; ?>
                                    <? if ($subvalue->discount_percent > 0) : ?>
                                        <span class="right" title="скидка %">
                                            <strong>Скидка %:</strong> <?= $subvalue->discount_percent; ?>
                                        </span>
                                    <? endif; ?>
                                </div>
                            </li>
                        <? endforeach; ?>
                    </ul>
                </div>
            </li>
        <? endforeach; ?>
    </ul>
    <ul class="module_menu">
        <li>
            <a href="#to_top">наверх</a>
        </li>
    </ul>

    <ul class="module_menu">
        <li>
            <a href="<?= $section->link('item_add'); ?>" title="создать новый товар">
                <button class="styler">создать товар</button>
            </a>
        </li>
        <li>
            <a href="<?= $links['section_index']; ?>" title="вернуться к списку каталогов">
                <button class="styler">в начало</button>
            </a>
        </li>
    </ul>
    <ul class="admin_list admin_mainlist">
        <h6>Список товаров в каталоге: <em class="sub_title"><?= $section->title; ?></em></h6>
        <? foreach ( $item_list as $item ): ?>
            <li>
                <div class="menuline clearfix">
                    <span class="left">
                        <a href="<?= $item->link('item_list'); ?>" title="посмотреть список категорий товара">
                            <?= $item->title; ?>
                        </a>
                    </span>
                    <span class="right">
                        <a href="<?= $item->link('del'); ?>" class="admin_form_action_page" onclick="if (confirm('Вы уверены? Будут удалены все категории в данном каталоге!')) return true; else return false;" title="удалить">
                            <img title="удалить" alt="удалить" src="/www_admin/img/icon_delete_1.5.png" />
                        </a>
                    </span>
                    <span class="right">
                        <a href="<?= $item->link('edit'); ?>" class="admin_form_action_page" title="редактировать">
                            <img title="редактировать" alt="редактировать" src="/www_admin/img/icon_edit_1.5.png"/>
                        </a>
                    </span>
                    <span class="right catalogs" title="кол-во категорий">
                        Категории: <?= $item->num_categories(); ?>
                    </span>
                    <span class="right priority" title="порядок">
                        <?= $item->priority; ?>
                    </span>

                    <span class="right" title="артикул">
                        <strong>Артикул:</strong> <?= $item->article; ?>
                    </span>
                    <? if ($item->discount_price > 0) : ?>
                        <span class="right" title="скидка">
                            <strong>Скидка:</strong> <?= $item->discount_price; ?>
                        </span>
                    <? endif; ?>
                    <? if ($item->discount_percent > 0) : ?>
                        <span class="right" title="скидка %">
                            <strong>Скидка %:</strong> <?= $item->discount_percent; ?>
                        </span>
                    <? endif;?>
                    <span class="right">
                        <strong>&nbsp;</strong>
                    </span>
                    <span class="right" title="цена">
                        <strong>Цена:</strong> <?= $item->price; ?>
                    </span>
                    <? if ($item->discount_percent > 0 || $item->discount_price > 0) : ?>
                        <span class="right" title="цена со скидкой">
                            <strong>Цена со скидкой:</strong> <?= $item->get_discount_price(); ?>
                        </span>
                    <? endif; ?>

                </div>
            </li>
        <? endforeach; ?>
    </ul>
    <ul class="module_menu">
        <li>
            <a href="#to_top">наверх</a>
        </li>
    </ul>
</div>