<?php

namespace app\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\web\UploadedFile;
use yii\helpers\FileHelper;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "noticia".
 *
 * @property integer $id
 * @property integer $id_autor
 * @property string $nome_autor
 * @property string $titulo
 * @property string $introducao
 * @property string $imagem
 * @property string $corpo
 * @property string $fonte
 * @property string $tags
 * @property string $status
 * @property integer $visitas
 * @property string $created_at
 * @property string $updated_at
 * @property string $updated_by
 *
 * @property Users $idAutor
 * @property NoticiaDestaque[] $noticiaDestaques
 * @property NoticiaPertenceCategoria[] $noticiaPertenceCategorias
 * @property NoticiaCategoria[] $idNoticiaCategorias
 */
class Noticia extends ActiveRecord
{
    public $image_file;
    public $timeago;

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
        return 'noticia';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_autor',
              'nome_autor',
              'titulo',
              'introducao',
              'corpo',
             ],
             'required'
            ],
            [['status'], 'required'],
            [['image_file'], 'required', 'on' => 'insert'],
            [['id_autor', 'visitas'], 'integer'],
            [['introducao', 'corpo', 'status'], 'string'],
            [['created_at', 'updated_at', 'timeago'], 'safe'],
            [['nome_autor'], 'string', 'max' => 100],
            [['titulo', 'imagem', 'fonte', 'tags'], 'string', 'max' => 250]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_autor' => 'ID autor',
            'nome_autor' => 'Nome do autor',
            'titulo' => 'Título',
            'introducao' => 'Introdução',
            'imagem' => 'Imagem',
            'corpo' => 'Corpo',
            'fonte' => 'Fonte',
            'tags' => 'Tags',
            'status' => 'Status',
            'visitas' => 'Visualizações',
            'created_at' => 'Criado em',
            'updated_at' => 'Atualizado em',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAutor()
    {
        return $this->hasOne(Users::className(), ['id' => 'id_autor']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNoticiaDestaques()
    {
        return $this->hasMany(NoticiaDestaque::className(), ['id_noticia' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNoticiaPertenceCategorias()
    {
        return $this->hasMany(NoticiaPertenceCategoria::className(), ['id_noticia' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNoticiaCategorias()
    {
        return $this->hasMany(NoticiaCategoria::className(), ['id' => 'id_noticia_categoria'])->viaTable('noticia_pertence_categoria', ['id_noticia' => 'id']);
    }

    /**
     * @inheritdoc
     * @return NoticiaQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new NoticiaQuery(get_called_class());
    }

    public function uploadImagem()
    {
        if ($this->validate()) {
            if ($this->image_file != null) {
                # Cria o diretório se não existir
                FileHelper::createDirectory('uploads/img/noticias / ');
                $file = explode(' . ', $this->image_file->name);
                $this->image_file->saveAs(\Yii::getAlias('@webroot/uploads/img/noticias/') . $file[0] . ' - ' . date('YmdHis') . ' . ' . $this->image_file->extension);

                return $file[0] . ' - ' . date('YmdHis') . ' . ' . $this->image_file->extension;
            }
        } else {
            return false;
        }
    }

    public function getNoticiaActive()
    {
        return $this::find()->where(['status' => Noticia::STATUS_ACTIVE])->orderBy(['created_at' => SORT_DESC])->all();
    }

    public function afterFind()
    {
        parent::afterFind();

        $this->timeago = self::TimeAgo($this->created_at);
    }

    static function TimeAgo($time)
    {
        $time = time() - $time; // to get the time since that moment
        $time = ($time < 1) ? 1 : $time;
        $tokens = [
            31536000 => 'ano',
            2592000 => 'mes',
            604800 => 'semana',
            86400 => 'dia',
            3600 => 'hora',
            60 => 'minuto',
            1 => 'segundo'
        ];

        foreach ($tokens as $unit => $text) {
            if ($time < $unit) continue;
            $numberOfUnits = floor($time / $unit);

            return $numberOfUnits . ' ' . $text . (($numberOfUnits > 1) ? 's' : '');
        }
    }
}
