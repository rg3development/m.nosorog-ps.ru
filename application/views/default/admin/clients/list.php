<div class="admin_module_title">
    <h4>
        <?= !empty($module_title) ? $module_title : '' ; ?>
    </h4>
</div>

<div id="content">
    <ul class="admin_list admin_mainlist">
        <? foreach ( $client_list as $key => $client ) : ?>
            <li>
                <div class="menuline clearfix">
                    <span class="left">
                        <a href="">
                            <?= $client->login; ?>
                        </a>
                    </span>
                    <span class="left">
                        (<?= $client->email; ?>)
                    </span>
                    <span class="right show" title="активность">
                        <?= ( $client->active ) ? '+' : '-'; ?>
                    </span>
                    <span class="right" title="Сумма покупок">
                        <?= $client->order_sum; ?>
                    </span>
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