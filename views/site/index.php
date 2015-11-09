<?php

/* @var $this yii\web\View */

$this->title = 'YiiBrasil CMS';
?>
<div class="site-index">
    <div class="body-content">
        <?php
        if (!empty($banners)) {
            echo yii\bootstrap\Carousel::widget(['items' => $banners]);
        }
        ?>

        <div class="row">
            <div class="col-lg-6">
                <h2>Últimas publicações</h2>

                <ul>
                    <li><a href="">Título 1</a></li>
                    <li><a href="">Título 2</a></li>
                    <li><a href="">Título 3</a></li>
                    <li><a href="">Título 4</a></li>
                    <li><a href="">Título 5</a></li>
                </ul>

                <p><a class="btn btn-default" href="#">Ver todas as publicações &raquo;</a></p>
            </div>

            <div class="col-lg-6">
                <h2>#6 Yii2 - O Famoso GII</h2>
                <iframe width="560" height="315" src="https://www.youtube.com/embed/x0BiGs6Ub7Q" frameborder="0" allowfullscreen></iframe>
            </div>
        </div>

    </div>
</div>
