<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "about".
 *
 * @property integer $id
 * @property string $conteudo
 * @property string $status
 * @property string $created_at
 * @property string $updated_at
 */
class About extends \yii\db\ActiveRecord
{
    const STATUS_ATIVO = 'ativo';
    const STATUS_INATIVO = 'inativo';

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'about';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['conteudo', 'status'], 'required'],
            [['conteudo'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['status'], 'in', 'range' => [self::STATUS_ATIVO, self::STATUS_INATIVO]],
            [['status'], 'default', 'value' => self::STATUS_ATIVO],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'conteudo' => 'Conteúdo',
            'status' => 'Status',
            'created_at' => 'Criado em',
            'updated_at' => 'Atualizado em',
        ];
    }
}
