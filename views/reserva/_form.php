<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use app\models\Sala; 
?>

<div class="reserva-form">

    <?php echo "<br> <font color=red>  Nova reserva pro dia ". $model->data_do_evento . "</font> <br><br><br> "; ?>
	
	   <?php $form = ActiveForm::begin(); ?>
	
	

    <?= $form->field($model, 'sala_id')->dropDownList(
        ArrayHelper::map(Sala::find()->all(), 'id', 'nome_da_sala'),
        ['prompt' => 'Selecione uma sala']
    ) ?>

    <?= $form->field($model, 'titulo_evento')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'publico_alvo')->textInput(['maxlength' => true]) ?>


	<?= $form->field($model, 'data_do_evento')->hiddenInput()->label(false) ?>	
	
	<?= $form->field($model, 'hora_de_inicio_do_evento')->input('time') ?>
	<?= $form->field($model, 'hora_final_do_evento')->input('time') ?>



    <?= $form->field($model, 'evento_publico')->textInput(['maxlength' => true]) ?>
	 

    <div class="form-group">
        <?= Html::submitButton('Salvar', ['class' => 'btn btn-success'])
    ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>