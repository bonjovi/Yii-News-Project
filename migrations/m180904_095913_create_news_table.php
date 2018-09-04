<?php

use yii\db\Migration;

/**
 * Handles the creation of table `news`.
 */
class m180904_095913_create_news_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('news', [
            'news_id' => $this->primaryKey(),
            'date' => $this->date(),
            'theme_id' => $this->integer(),
            'text' => $this->text()->append('CHARACTER SET utf8 COLLATE utf8_unicode_ci'),
            'title' => $this->string(255)->append('CHARACTER SET utf8 COLLATE utf8_unicode_ci'),
        ], 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB');

        $this->addForeignKey(
            'fk_theme_id',  
            'news', 
            'theme_id', 
            'themes', 
            'theme_id', 
            'CASCADE', 
            'CASCADE'  
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('news');

        $this->dropForeignKey(
            'fk_theme_id',
            'themes'
        );
    }
}
