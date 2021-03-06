<?php

/* @var $this yii\web\View */
/* @var $model app\models\About */

use yii\helpers\Html;

$this->title = 'Sobre';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-about">
    <?php if (!Yii::$app->user->isGuest) : ?>
        <div class="pull-right">
            <?= Html::a('Editar conteúdo', ['about-edit'], ['class' => 'btn btn-default']) ?>
        </div>
        <div class="clearfix"></div>
    <?php endif; ?>

    <h1><?= Html::encode($this->title) ?></h1>

    <?php if (isset($model) && $model->status == $model::STATUS_ATIVO) : ?>
        <?= htmlspecialchars_decode($model->conteudo, ENT_QUOTES) ?>
    <?php elseif (isset($model) && $model->status == $model::STATUS_INATIVO) : ?>
        <?php if (!Yii::$app->user->isGuest) : ?>
            <p class="alert alert-warning">
                O conteúdo desta página foi desativado. Para ativá-lo, clique no
                botão <strong>Editar conteúdo</strong> e altere o status para
                <strong>ativo</strong>.
            </p>
            <?= htmlspecialchars_decode($model->conteudo, ENT_QUOTES) ?>
        <?php else : ?>
            <p>
                Nenhum conteúdo foi adicionado nesta página!
            </p>
        <?php endif; ?>
    <?php else : ?>
        <p>
            Nenhum conteúdo foi adicionado nesta página!
        </p>
    <?php endif; ?>
</div>
