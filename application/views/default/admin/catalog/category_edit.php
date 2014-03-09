<div class="admin_module_title">
    <h4><?= $module['title']; ?></h4>
</div>
<div id="content">
    <div class="text_module">
        <form action="<?= $category->link('edit'); ?>" method="post">
            <input type="hidden" name="cmd" value="1">
            <input type="hidden" name="parent_section_id" value="<?= $section->id; ?>">
            <table class="admin_module_form photo_module_edit">
                <tr>
                    <td class="admin_module_form_title"></td><td class="admin_error_message"><?=validation_errors();?></td>
                </tr>
                <tr>
                    <td class="admin_module_form_title">Каталог</td>
                    <td>
                        <input name="section_title" type="text" disabled="disabled" value="<?= $section->title; ?>">
                    </td>
                </tr>
                <tr>
                    <td class="admin_module_form_title">родительская категория</td>
                    <td>
                        <select name="parent_category_id" class="page_select_list">
                            <option value="0">не выбрано</option>
                            <optgroup label="категории">
                                <? foreach ( $category_list as $cur_category ): ?>
                                    <option value="<?= $cur_category['item']->id; ?>" id="<?= $cur_category['item']->id; ?>" <?= ( $cur_category['item']->id == $category->parent_category_id ) ? 'selected' : ''; ?>>
                                        <?= $cur_category['item']->title; ?>
                                    </option>
                                    <? foreach ( $cur_category['list'] as $subcategory ): ?>
                                        <option value="<?= $subcategory->id; ?>" id="<?= $subcategory->id; ?>" <?= ( $subcategory->id == $category->parent_category_id ) ? 'selected' : ''; ?>>
                                            <?= '-- '.$subcategory->title; ?>
                                        </option>
                                    <? endforeach; ?>
                                <? endforeach; ?>
                            </optgroup>
                        </select>
                <input type="submit" value="сохранить" name="save" class="admin_module_form_submit g-button" />
                <a class="g-button" style="float:right" href="<?= $links['section_index']; ?>">в начало</a>
            </td>
        </tr>
        <tr>
            <td class="admin_module_form_title">название</td>
            <td><input type="text" name="title" value='<?= $category->title; ?>' /></td>
        </tr>
        <tr>
            <td class="admin_module_form_title">Скидка в рублях</td>
            <td><input class="styler" type="text" name="discount-price" value='<?= $category->discount_price; ?>' /></td>
        </tr>
        <tr>
            <td class="admin_module_form_title">Скидка в процентах (приоритетная)</td>
            <td><input class="styler" type="text" name="discount-percent" value='<?= $category->discount_percent; ?>' /></td>
        </tr>
        <tr>
            <td class="admin_module_form_title">приоритет</td>
            <td>
                <input type="text" style="width: 100px;" name="priority" value="<?= $category->priority; ?>" />
            </td>
        </tr>
    </table>
</form>
</div>
</div>
