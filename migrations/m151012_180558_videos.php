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
            'status' => "ENUM('ativo', 'inativo') NOT NULL DEFAULT 'ativo'",
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->addForeignKey('fk_videos_categoria', 'videos', 'id_categoria', 'category', 'id');
    }

    public function down()
    {
        $this->dropTable('videos');
    }
}
