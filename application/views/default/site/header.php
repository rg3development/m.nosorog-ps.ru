<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <title><?=$page_info['title'];?> - <?=$site_settings['title'];?></title>
    <meta name="keywords" content="<?=!empty($page_info['keywords']) ? $page_info['keywords'] : $site_settings['keywords'];?>">
    <meta name="description" content="<?=!empty($page_info['description']) ? $page_info['description'] : $site_settings['description'];?>">

    <link rel="stylesheet" href="/www_site/css/empty.css" type="text/css" media="screen"/>

    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>

</head>
<div id="wrap">
    <header class="header">
        <div class="marker"></div>
        <div class="banner-top"><img src="/img/site/animation.gif" alt=""></div>
        <div id="logo"><a href="/"><?=$site_settings['logo'] ? "<img class='logo' src={$site_settings['logo']} />" : '';?></a></div>
        <nav class="menu">
            <ul>
                <?=$menu;?>
            </ul>
        </nav>
        <div class="auth-link"><a href="#">Вход в кабинет</a></div>
    </header>
    <div class="content">