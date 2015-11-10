<?php

/* @var $this yii\web\View */
/* @var $model app\models\About */

use dosamigos\ckeditor\CKEditor;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = 'Edição da página Sobre';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">
    <div class="pull-right">
        <?= Html::a('Voltar a página Sobre', ['about'], ['class' => 'btn btn-default']) ?>
    </div>
    <div class="clearfix"></div>

    <h1><?= Html::encode($this->title) ?></h1>

    <?php $form = ActiveForm::begin() ?>

        <?= $form->field($model, 'conteudo')->widget(CKEditor::className(), [
            'options' => [
                'rows' => 6,
            ],
            'preset' => 'basic',
        ]) ?>

        <?= $form->field($model, 'status')->dropDownList([
            $model::STATUS_ATIVO => 'Ativo',
            $model::STATUS_INATIVO => 'Inativo',
        ], [
            'prompt' => '',
        ]) ?>

        <div class="form-group">
            <?= Html::submitButton('Salvar', ['class' => 'btn btn-success']) ?>
        </div>

    <?php ActiveForm::end() ?>
</div>
