<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model app\models\Banners */

$this->title = 'Inserir um novo banner';
$this->params['breadcrumbs'][] = ['label' => 'Banners', 'url' => ['index']];
$this->params['breadcrumbs'][] = 'Novo Banner';
?>
<div class="banners-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
