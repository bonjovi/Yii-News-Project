<?php

/* @var $this yii\web\View */

$this->title = 'My Yii Application';

use yii\helpers\Url;
use yii\widgets\LinkPager;
?>
<div class="site-index">

    <div class="jumbotron">
        <h1>Test News Project</h1>
    </div>

    <div class="body-content">

        <div class="row">
            <div class="col-lg-12">
                
                <h3><?=$news->title?></h3>
                <small class="text-muted"><?=$news->date?></small>
                <small class="text-muted"><?=$news->theme->theme_title?></small>
                <p><?=$news->text?></p>
                <p><a href="<?= Url::toRoute(['site/index']);?>">Все новости</a></p>
            </div>
        </div>

    </div>
</div>
