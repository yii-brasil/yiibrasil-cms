<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\NoticiaSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Noticias';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="noticia-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Nova Notícia', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget(
        [
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                'titulo',
                'status',
                'visitas',
                [
                    'attribute' => 'created_at',
                    'format' => 'raw',
                    'value' => function ($model) {
                        return Yii::$app->formatter->asDatetime($model->created_at) . "<br>Por: $model->nome_autor";
                    }
                ],
                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]
    ); ?>

</div>
