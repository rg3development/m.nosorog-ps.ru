<?= '<?xml version="1.0" encoding="utf-8"?>'."\n"; ?>
<rss version="2.0">
    <channel>
    <? if ( $news_category->show_title ) : ?>
        <title><?= $news_category->title; ?></title>
    <? else: ?>
        <title><?= RSS_DEFAULT_TITLE; ?></title>
    <? endif; ?>
    <link><?= base_url(); ?></link>
    <description>RSS Канал с сайта <?= parse_url(site_url(), PHP_URL_HOST); ?></description>
    <language><?= RSS_LANGUAGE; ?></language>
    <pubDate><?= date('r'); ?></pubDate>

    <lastBuildDate><?= date('r'); ?></lastBuildDate>
    <webMaster><?= RSS_WEBMASTER; ?></webMaster>
    <? if (sizeof($news_list) > 0) : ?>
        <? foreach ( $news_list as $key => $news ) : ?>
        <item>
            <title><?= $news->title; ?></title>
            <link><?= base_url("{$page_urls[$key]}?news_id={$news->id}"); ?></link>
            <description><?= strip_tags($news->anno); ?></description>
            <pubDate><?= date('r', $news->created); ?></pubDate>
        </item>
        <? endforeach; ?>
    <? endif; ?>
    </channel>
</rss>