<?php

use yii\db\Migration;

/**
 * Handles the creation of table `theme`.
 */
class m180904_095612_create_themes_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('themes', [
            'theme_id' => $this->primaryKey(),
            'theme_title' => $this->string(255)->notNull(),
        ], 'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('themes');
    }
}
