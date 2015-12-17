<?php

namespace app\models;

/**
 * This is the ActiveQuery class for [[Noticia]].
 *
 * @see Noticia
 */
class NoticiaQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        $this->andWhere('[[status]]=1');
        return $this;
    }*/

    /**
     * @inheritdoc
     * @return Noticia[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Noticia|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}