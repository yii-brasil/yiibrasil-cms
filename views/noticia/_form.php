<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use dosamigos\ckeditor\CKEditor;

/* @var $this yii\web\View */
/* @var $model app\models\Noticia */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="noticia-form">

    <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>

    <?= $form->field($model, 'titulo')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'introducao')->textarea(['rows' => 4]) ?>

    <?= $form->field($model, 'image_file')->fileInput(
        ['maxlength' => true,
         'accept' => 'image/*'
        ]
    ) ?>

    <?/*= $form->field($model, 'corpo')->widget(
        CKEditor::className(), [
        'options' => [
            'rows' => 6,
        ],
        'preset' => 'basic',
    ]
    ) */?>

    <?= $form->field($model, 'corpo')->widget(\yii\redactor\widgets\Redactor::className()) ?>

    <?= $form->field($model, 'fonte')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'tags')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'status')->dropDownList(
        ['Ativo' => 'Ativo',
         'Inativo' => 'Inativo',
        ], ['prompt' => '']
    ) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Adicionar' : 'Atualizar', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
