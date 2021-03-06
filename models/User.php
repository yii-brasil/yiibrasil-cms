<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * User model
 *
 * @property integer $id
 * @property string $nome
 * @property string $senha
 * @property string $email
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 */

class User extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
    const STATUS_INACTIVE  = 'inativo';
    const STATUS_ACTIVE    = 'ativo';

    public $repete_senha;

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
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nome' => 'Nome de Usuário',
            'email' => 'E-mail',
            'status' => 'Status',
            'created_at' => 'Criado em',
            'updated_at' => 'Atualizado em',
            'created_by' => 'Criado por',
            'updated_by' => 'Atualizado por',
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['nome', 'filter', 'filter' => 'trim'],
            ['nome', 'unique', 'message' => 'Este usuário já encontra-se em uso.'],
            [['nome'], 'string', 'min' => 2, 'max' => 255],
            [['nome', 'email'], 'required'],
            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'message' => 'Este e-mail já está sendo utilizado por outro usuário.'],
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_INACTIVE]],
            [['senha','repete_senha'], 'required', 'on' => 'insert'],
            [['senha','repete_senha'], 'string', 'min' => 4],
            ['repete_senha','compare',  'compareAttribute' => 'senha', 'on' => ['insert','update']]
        ];
    }


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%users}}';
    }

    public function getName()
    {
        return $this->nome;
    }

    /**
     * @inheritdoc
     */
    public function beforeSave($insert)
    {
        if (empty($this->senha)) {
            unset($this->senha);
        } else {
            $this->setPassword($this->senha);
        }
        
        return parent::beforeSave($insert);
    }

    public function init()
    {
        parent::init();
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['nome' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return '';
        //Not implemented
        //return $this->authKey;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param  string  $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->senha);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->senha = Yii::$app->security->generatePasswordHash($password);
    }
}
