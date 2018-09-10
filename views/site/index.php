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

                <?php 
                    foreach($dates as $date) {
                        $monthsArray[] = Yii::$app->formatter->asDate($date->date, 'M');   
                    }    
                    $monthsUniqueArray = array_count_values ($monthsArray);
                ?>

                <?php foreach( $monthsUniqueArray as $key => $value):?>
                    <p><a href="<?= Url::toRoute(['site/index', 'date'=>$key]);?>"><?=$key?></a> <small class="text-muted"><?=$value?></small></p>
                <?php endforeach; ?>

            </div>
            <div class="col-lg-10">
                <?php foreach($news as $newsitem):?>
                    <a href="<?= Url::toRoute(['site/view', 'id'=>$newsitem->news_id]);?>"><h3><?=$newsitem->title?></h3></a>
                    <small class="text-muted"><?=$newsitem->date?></small>
                    <small class="text-muted"><?=$newsitem->theme->theme_title?></small>
                    
                    <p><?=\yii\helpers\StringHelper::truncate($newsitem->text, 256, '...')?></p>
                    
                <?php endforeach; ?>
            </div>
        </div>

    </div>
</div>
