<?php

use yii\db\Schema;
use yii\db\Migration;

class m130524_201442_init extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('users', [
            'id' => $this->primaryKey(),
            'nome' => $this->string(80)->notNull(),
            'senha' => $this->string(32)->notNull(),
            'email' => $this->string(150)->notNull(),
            'status' => "ENUM('ativo', 'inativo') NOT NULL DEFAULT 'ativo'",
            'created_at' => $this->datetime()->notNull(),
            'updated_at' => $this->datetime()->notNull(),
        ], $tableOptions);
    }

    public function down()
    {
        $this->dropTable('users');
    }
}
