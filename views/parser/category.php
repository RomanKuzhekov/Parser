<?php foreach ($products as $item) { ?>
    <div class="items">
        <p><a href="<?=$item->url?>" target="_blank"><?=$item->title?></a></p>
        <p><img src="<?=$item->img?>" width="200"></p>
        <p>Цена: <?=$item->price?> руб.</p>
    </div>
<?php } ?>