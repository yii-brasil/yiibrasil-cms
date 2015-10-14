<?php

use yii\db\Schema;
use yii\db\Migration;

class m151009_144703_posts extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('posts', [
            'id' => $this->primaryKey(),
            'id_autor' => $this->integer()->notNull(),
            'id_categoria' => $this->integer()->notNull(),
            'titulo' => $this->string(200)->notNull(),
            'noticia' => $this->text()->notNull(),
            'tags' => $this->string(250),
            'status' => "ENUM('ativo', 'inativo') NOT NULL DEFAULT 'ativo'",
            'visualizacoes' => $this->smallInteger()->defaultValue(0),
            'created_at' => $this->datetime()->notNull(),
            'updated_at' => $this->datetime()->notNull(),
        ]);

        $this->addForeignKey('fk_posts_autor', 'posts', 'id_autor', 'users', 'id');
        $this->addForeignKey('fk_posts_categoria', 'posts', 'id_categoria', 'category', 'id');
    }

    public function down()
    {
        echo "m151009_144703_posts cannot be reverted.\n";

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
