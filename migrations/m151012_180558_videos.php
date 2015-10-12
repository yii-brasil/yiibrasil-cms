<?php

use yii\db\Schema;
use yii\db\Migration;

class m151012_180558_videos extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('videos', [
            'id' => $this->primaryKey(),
            'id_categoria' => $this->integer()->notNull(),
            'titulo' => $this->string(200),
            'descricao' => $this->string(255),
            'url' => $this->string(255),
            'status' => $this->string(7)->notNull()->defaultValue('ativo'),
            'created_at' => $this->datetime()->notNull(),
            'updated_at' => $this->datetime()->notNull(),
        ], $tableOptions);

        $this->addForeignKey('fk_videos_categoria', 'videos', 'id_categoria', 'category', 'id');
    }

    public function down()
    {
        echo "m151012_180558_videos cannot be reverted.\n";

        return false;
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
