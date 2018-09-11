<?php

namespace app\models;
use yii\data\Pagination;

use Yii;

/**
 * This is the model class for table "news".
 *
 * @property int $news_id
 * @property string $date
 * @property int $theme_id
 * @property string $text
 * @property string $title
 *
 * @property Themes $theme
 */
class News extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'news';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['date'], 'required'],
            [['date'], 'safe'],
            [['theme_id'], 'integer'],
            [['text'], 'required'],
            [['text'], 'string'],
            [['title'], 'required'],
            [['title'], 'string', 'max' => 255],
            [['theme_id'], 'exist', 'skipOnError' => true, 'targetClass' => Themes::className(), 'targetAttribute' => ['theme_id' => 'theme_id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'news_id' => 'News ID',
            'date' => 'Date',
            'theme_id' => 'Theme ID',
            'text' => 'Text',
            'title' => 'Title',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */



    public static function getAll($pageSize = 15)
    {
        
        $query = News::find();
        
        $count = $query->count();
        
        $pagination = new Pagination(['totalCount' => $count, 'pageSize'=>$pageSize]);
        
        $news = $query->offset($pagination->offset)
            ->limit($pagination->limit)
            ->all();
        
        $data['news'] = $news;
        $data['pagination'] = $pagination;

        
        
        return $data;
    }

    public function getTheme()
    {
        return $this->hasOne(Themes::className(), ['theme_id' => 'theme_id']);
    }

    

    
}
