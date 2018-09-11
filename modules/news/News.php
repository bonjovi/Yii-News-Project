<?php

namespace app\modules\news;

/**
 * news module definition class
 */
class News extends \yii\base\Module
{
    /**
     * {@inheritdoc}
     */
    public $controllerNamespace = 'app\modules\news\controllers';
    public $defaultRoute = 'news';

    /**
     * {@inheritdoc}
     */
    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }
}
