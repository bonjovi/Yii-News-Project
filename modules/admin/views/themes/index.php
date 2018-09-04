<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ThemesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Themes';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="themes-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Create Themes', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'theme_id',
            'theme_title',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
</div>
