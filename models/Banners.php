<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\web\UploadedFile;
use yii\helpers\FileHelper;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "banners".
 *
 * @property integer $id
 * @property string $url_imagem
 * @property string $descricao
 * @property string $status
 * @property string $created_at
 * @property string $updated_at
 */
class Banners extends ActiveRecord
{
    public $image_file;
    const STATUS_INACTIVE = 'Inativo';
    const STATUS_ACTIVE = 'Ativo';

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
        return 'banners';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status'], 'required'],
            [['image_file'], 'required', 'on' => 'insert'],
            [['image_file'], 'file'],
            [['status'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['descricao'], 'string', 'max' => 140],
            [['url_imagem'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'url_imagem' => 'Banner',
            'descricao' => 'Descrição',
            'status' => 'Status',
            'created_at' => 'Criado em',
            'updated_at' => 'Atualizado em',
            'image_file' => 'Banner',
        ];
    }

    public function uploadBanner()
    {
        if ($this->validate()) {
            if ($this->image_file != null) {
                //Cria o diretório se não existir
                FileHelper::createDirectory('uploads/img/banners/');
                $file = explode('.', $this->image_file->name);
                $this->image_file->saveAs(\Yii::getAlias('@webroot/uploads/img/banners/') . $file[0] . '-' . date('YmdHis') . '.' . $this->image_file->extension);

                return $file[0] . '-' . date('YmdHis') . '.' . $this->image_file->extension;
            }
        } else {
            return false;
        }
    }

    public function deleteBanner($file)
    {
        if (unlink(\Yii::getAlias('@webroot/uploads/img/banners/').$file)) {
            return true;
        } else {
            return false;
        }
    }

    public function getBannerIsActive()
    {
        $banners = (new \yii\db\Query())
            ->select(['url_imagem', 'descricao'])
            ->from($this->tableName())
            ->where(['status' => Banners::STATUS_ACTIVE])
            ->orderBy('created_at DESC')
            ->all();

        return $banners;
    }

    public function buildBannerObject()
    {
        $banners = $this->getBannerIsActive();
        $listaBanner = [];

        foreach ($banners as $key => $banner) {
            $listaBanner[$key] = [
                'content' => '<img src="' . \Yii::getAlias('@web/uploads/img/banners/') .
                    $banner['url_imagem'] . '" width="1140px" height="584px" />',
                'caption' => '<h4>' . $banner['descricao'] . '</h4>',
            ];
        }

        return $listaBanner;
    }
}
