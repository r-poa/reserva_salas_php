<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Sala $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="sala-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nome_da_sala')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'descricao_da_sala')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'mensagem_de_aviso')->textarea(['rows' => 6]) ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
