<?php

/* @var $this yii\web\View */

$this->title = 'My Yii Application';

use yii\helpers\Url;
use yii\widgets\LinkPager;
use yii\helpers\StringHelper;
?>
<div class="site-index">

    <div class="jumbotron">
        <h1>Test News Project</h1>
    </div>

    <div class="body-content">

        <div class="row">
            <div class="col-lg-2">

                <?php $uniqueObj = null; ?>

                <?php foreach($dates as $date): ?>
                    <?php if($date['year'] != $uniqueObj): ?>
                        <?=$date['year']?>
                    <?php endif; ?>

                    <?php $uniqueObj = $date['year']; ?>

                    <p>
                        <a href='
                            <?= Url::toRoute(['news/index', 'year'=>$date['year'], 'month'=>$date['month']]);?>
                        '>
                            <?=monthword($date['month'])?>
                        </a>
                        <small class="text-muted">
                            <?=$date['count']?>
                        </small>
                    </p>
                <?php endforeach; ?>

                <?='<br>'?>

                <?php foreach($themes as $theme): ?>
                    <p>
                        <a href='
                            <?= Url::toRoute(['news/index', 'theme_id'=>$theme['theme_id']]);?>
                        '>
                            <?=$theme['theme_title']?>
                        </a>
                        <small class="text-muted">
                            <?=$theme['count']?>
                        </small>
                    </p>
                <?php endforeach; ?>
                

            </div>
            <div class="col-lg-10">
                <?php foreach($news as $newsitem):?>
                    <a href="<?= Url::toRoute(['news/view', 'id'=>$newsitem->news_id]);?>"><h3><?=$newsitem->title?></h3></a>
                    <small class="text-muted"><?=$newsitem->date?></small>
                    <small class="text-muted"><?=$newsitem->theme->theme_title?></small>
                    
                    <p><?=\yii\helpers\StringHelper::truncate($newsitem->text, 256, '...')?></p>
                    <p><a href="<?= Url::toRoute(['news/view', 'id'=>$newsitem->news_id]);?>">Читать далее</a></p>
                    
                <?php endforeach; ?>

                <?php
                    echo LinkPager::widget([
                        'pagination' => $pagination,
                    ]);
                ?>
            </div>
        </div>

    </div>
</div>
