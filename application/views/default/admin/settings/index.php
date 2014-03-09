<div class="admin_module_title">
    <h4><?=!empty($module_title) ? $module_title : '';?></h4>
</div>
<div id="content">
    <form action="<?= base_url('admin/settings'); ?>" method="post" enctype="multipart/form-data">
        <table class="admin_module_form">
            <tr><td class="admin_module_form_title"></td><td class="admin_error_message"><?=validation_errors();?></td></tr>
            <tr>
                <td class="admin_module_form_title">загрузить логотип</td>
                <td>
                    <input type="file" name="SITE_LOGO" size="255" /><br/>
                    <? if ( ! empty($settings['SITE_LOGO'])) : ?>
                        <img width="200px;"src="<?= $settings['SITE_LOGO']; ?>"/>
                    <? endif; ?>
                </td>
            </tr>
            <tr>
                <td class="admin_module_form_title">название</td>
                <td>
                    <input type="text" name="SITE_TITLE" size="255" value="<?= $settings['SITE_TITLE']; ?>" />
                </td>
            </tr>
            <tr>
                <td class="admin_module_form_title">описание</td>
                <td>
                    <textarea name="SITE_DESCRIPTION"><?= $settings['SITE_DESCRIPTION']; ?></textarea>
                </td>
            </tr>
            <tr>
                <td class="admin_module_form_title">ключевые слова</td>
                <td>
                    <input type="text" name="SITE_KEYWORDS" value="<?= $settings['SITE_KEYWORDS']; ?>"/>
                </td>
            </tr>
            <tr>
                <td class="admin_module_form_title">укажите отправителя</td>
                <td>
                    <input type="text" name="EMAIL" size="255" value="<?= $settings['EMAIL']; ?>"/>
                </td>
            </tr>
            <tr>
                <td class="admin_module_form_title">email пересылки</td>
                <td>
                    <input type="text" name="MY_EMAIL" size="255" value="<?= $settings['MY_EMAIL']; ?>"/>
                </td>
            </tr>
            <tr>
                <td class="admin_module_form_title">счетчики</td>
                <td>
                    <textarea name="SITE_COUNTERS"><?= $settings['SITE_COUNTERS']; ?></textarea>
                </td>
            </tr>
            <tr>
                <td class="admin_module_form_title">sitemap.xml</td>
                <td>
                    <a href="<?= base_url('sitemap.xml'); ?>" target="_blank">
                        <?= base_url('sitemap.xml'); ?>
                    </a>
                </td>
            </tr>
            <tr>
                <td class="admin_module_form_title">robots.txt</td>
                <td>
                    <textarea name="ROBOTS_TXT"><?= $settings['ROBOTS_TXT']; ?></textarea>
                </td>
            </tr>
            <tr>
                <td></td>
                <td>
                    <a href="<?= base_url('robots.txt'); ?>" target="_blank">
                        <?= base_url('robots.txt'); ?>
                    </a>
                </td>
            </tr>

            <tr>
                <td class="admin_module_form_title"></td>
                <td>
                    <input type="submit" value="сохранить" class="admin_module_form_submit" />
                </td>
            </tr>
        </table>
     </form>
</div>