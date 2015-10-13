<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;

$this->title = $name;
?>
<div class="site-error">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="alert alert-danger">
        <?= nl2br(Html::encode($message)) ?>
    </div>

    <p>
        O acima erro ocorreu enquanto o servidor Web foi processar o pedido.
    </p>
    <p>
        Entre em contato conosco se você acha que isso é um erro no servidor. Obrigado.
    </p>

</div>
