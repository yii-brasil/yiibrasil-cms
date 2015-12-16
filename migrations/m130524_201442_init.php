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
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ], $tableOptions);

        $this->insert('users', [
            'id' => 1,
            'nome' => 'admin',
            'senha' => 'admin',
            'email' => 'admin@admin.com',
            'status' => 'ativo',
            'created_at' => strtotime("now"),
            'updated_at' => strtotime("now"),
        ]);
    }

    public function down()
    {
        $this->dropTable('users');
    }
}
