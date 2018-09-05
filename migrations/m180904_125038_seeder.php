<?php

use yii\db\Migration;

/**
 * Class m180904_125038_seeder
 */
class m180904_125038_seeder extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        Yii::$app->db->createCommand()->batchInsert('themes', ['theme_title'], [
            ['Наука'],
            ['Спорт'],
            ['Интернет'],
            ['Авто'],
            ['Глямур'],
            ['Искусство'],
        ])->execute();

        Yii::$app->db->createCommand()->batchInsert('news', ['title', 'text', 'theme_id', 'date'], [
            ['1-я новость', 'Текст 1-й новости', '1', '2018-08-31'],
            ['2-я новость', 'Текст 2-й новости', '2', '2018-09-01'],
            ['3-я новость', 'Текст 3-й новости', '3', '2018-09-02'],
            ['4-я новость', 'Текст 4-й новости', '4', '2018-09-03'],
            ['5-я новость', 'Текст 5-й новости', '5', '2018-09-04'],
            ['6-я новость', 'Текст 6-й новости', '6', '2018-09-05'],
        ])->execute();
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        Yii::$app->db->createCommand()->delete('themes', ['in', 'theme_id', [1, 2, 3, 4, 5, 6]]
        )->execute();

        Yii::$app->db->createCommand()->delete('news', ['in', 'news_id', [1, 2, 3, 4, 5, 6]]
        )->execute();

        
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m180904_125038_seeder cannot be reverted.\n";

        return false;
    }
    */
}
