<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Banners */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="banners-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'image_file')->fileInput([
        'maxlength' => true ,
        'accept' => 'image/*'
    ]) ?>

    <?= $form->field($model, 'descricao')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->dropDownList(['ativo' => 'Ativo',
        'inativo' => 'Inativo', ], ['prompt' => '']) ?>

    <?= $form->field($model, 'created_at')->textInput(['value' => date('Y-m-d h:i:s')]) ?>

    <?= $form->field($model, 'updated_at')->textInput(['value' => date('Y-m-d h:i:s')]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Gravar' : 'Atualizar',
            ['class' => $model->isNewRecord ? 'btn btn-success' :
            'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
