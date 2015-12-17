<?php use yii\helpers\Html; ?>
<div class="noticia-container">
    <div class="col-lg-12">
        <?php if (!Yii::$app->user->isGuest) : ?>

            <div class="pull-right">
                <?= Html::a('Editar', Yii::$app->urlManager->createUrl(["/noticia/update", 'id' => $model->id]), ['class' => 'btn btn-default']) ?>
            </div>
            <div class="clearfix"></div>
        <?php endif; ?>

        <?php $tags = explode(',', $model->tags) ?>
        <div class="tags">
        <?php foreach($tags as $tag) : ?>
            <span class="label label-info"><?= $tag ?></span>
        <?php endforeach; ?>
        </div>
        <h2><?= $model->titulo ?></h2>
        <h4><?= $model->introducao ?></h4>
        <?= $model->image_file ?>
        <div class="corpo"><?= $model->corpo ?></div>
        <div class="fonte"><?= ($model->fonte != "") ? "Fonte: $model->fonte" : "" ?></div>
        <div class="n-visitas">Visitas: <?php echo $model->visitas ?></div>
    </div>
</div>
