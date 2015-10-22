<?php

use yii\db\Schema;
use yii\db\Migration;

class m151009_144738_banners extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('banners', [
            'id' => $this->primaryKey(),
            'url_imagem' => $this->string(200)->notNull(),
            'descricao' => $this->string(140),
            'status' => "ENUM('ativo', 'inativo') NOT NULL DEFAULT 'ativo'",
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('banners');
    }
}
