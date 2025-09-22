<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Reserva $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="reserva-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'sala_id')->textInput() ?>

    <?= $form->field($model, 'user_id')->textInput() ?>

    <?= $form->field($model, 'titulo_evento')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'publico_alvo')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'data_do_evento')->textInput() ?>

    <?= $form->field($model, 'hora_de_inicio_do_evento')->textInput() ?>

    <?= $form->field($model, 'hora_final_do_evento')->textInput() ?>

    <?= $form->field($model, 'evento_publico')->textInput(['maxlength' => true]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
