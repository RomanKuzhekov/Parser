<!doctype html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <title>Парсер с сайта av.ru</title>
    <link rel="stylesheet" href="/assets/css/styles.css" type="text/css" media="all"/>
</head>
<body>
<div class="container">
    <div class="header">
        <h2>Парсер с сайта: <a href="https://av.ru" target="_blank">av.ru</a></h2>
    </div>
    <div class="content">
        <div class="sidebar">
            <button onclick="javascript:window.location.reload()">Обновить страницу</button>
            <p>Меню:</p>
            <p><a href="/">Главная страница</a></p>
            <ul>
                <?php foreach ($categories as $item) { ?>
                    <li><a href="/product/<?=$item['category_id']?>"><?=$item['title']?></a></li>
                <? } ?>
            </ul>
        </div>
        <div class="parser">
            <?=$content?>
        </div>
    </div>
    <div class="footer">
        <p><i>Парсер написан в ознакомительных целях.</i></p>
    </div>
</div>
</body>
</html>