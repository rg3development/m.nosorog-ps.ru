<?= '<?xml version="1.0" encoding="utf-8"?>'."\n"; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
<? foreach ( $sitemap_xml as $key => $page_level ) : ?>
    <? foreach ( $page_level as $index => $page ) : ?>
        <url>
            <loc><?= base_url($page->url); ?></loc>
            <priority><?= number_format(1 - ($page->level*0.1), 1); ?></priority>
        </url>
    <? endforeach; ?>
<? endforeach; ?>
</urlset>