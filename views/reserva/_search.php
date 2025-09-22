<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\ReservaSearch $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="reserva-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'sala_id') ?>

    <?= $form->field($model, 'user_id') ?>

    <?= $form->field($model, 'titulo_evento') ?>

    <?= $form->field($model, 'publico_alvo') ?>

    <?php // echo $form->field($model, 'data_do_evento') ?>

    <?php // echo $form->field($model, 'hora_de_inicio_do_evento') ?>

    <?php // echo $form->field($model, 'hora_final_do_evento') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
