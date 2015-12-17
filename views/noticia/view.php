<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Noticia */

$this->title = 'Notícia';
$this->params['breadcrumbs'][] = ['label' => 'Noticias', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="noticia-view">

    <h1><?= Html::encode($this->title) ?></h1>

   <p>
        <?= Html::a('Atualizar', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Deletar', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Deseja deletar esse item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget(
        [
            'model' => $model,
            'template' => "<tr><th style='width: 150px;'>{label}</th><td>{value}</td></tr>",
            'attributes' => [
                'id',
                'id_autor',
                'nome_autor',
                'titulo',
                'introducao:ntext',
                [
                    'attribute' => 'imagem',
                    'value'=>"<img src='uploads/img/noticias/$model->imagem' alt='$model->imagem' width='200'/>",
                    'format' => 'raw',
                ],
                [
                    'attribute' => 'corpo',
                    'format' => 'html'
                ],
                'fonte',
                'tags',
                'status',
                'visitas',
                'created_at:datetime',
                'updated_at:datetime',
            ],
        ]
    ) ?>

</div>
