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
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m180904_125038_seeder cannot be reverted.\n";

        return false;
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
