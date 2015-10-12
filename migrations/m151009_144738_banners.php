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
            'status' => $this->string(7)->notNull()->defaultValue('ativo'),
            'created_at' => $this->datetime()->notNull(),
            'updated_at' => $this->datetime()->notNull(),
        ], $tableOptions);
    }

    public function down()
    {
        echo "m151009_144738_banners cannot be reverted.\n";

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
