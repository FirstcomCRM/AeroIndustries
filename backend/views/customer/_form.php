<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;

$backUrlFull = Yii::$app->request->referrer;
$exBackUrlFull = explode('?r=', $backUrlFull);
$backUrl = '#';
if ( isset ( $exBackUrlFull[1] ) ) {
$backUrl = $exBackUrlFull[1];
}

use common\models\Currency;
/* @var $this yii\web\View */
/* @var $model common\models\Customer */
/* @var $form yii\widgets\ActiveForm */
$dataCurrency = ArrayHelper::map(Currency::find()->where(['status' => 'active'])->all(), 'id', 'name');
?>

<div class="customer-form">
	<section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header with-border">
                      <h3 class="box-title"><?= $subTitle ?></h3>
                    </div>
                    <!-- /.box-header -->

                    <div class="box-body ">
				    <?php $form = ActiveForm::begin(); ?>
							    <div class="col-sm-12 col-xs-12">    <?= $form->field($model, 'name', ['template' => '<div class="col-sm-3 text-right">{label}</div>
<div class="col-sm-9 col-xs-12">{input}</div>
{hint}
{error}'])->textInput(['maxlength' => true]) ?>

    </div>    <div class="col-sm-12 col-xs-12">    <?= $form->field($model, 'addr_1', ['template' => '<div class="col-sm-3 text-right">{label}</div>
<div class="col-sm-9 col-xs-12">{input}</div>
{hint}
{error}'])->textInput(['maxlength' => true]) ?>

    </div>    <div class="col-sm-12 col-xs-12">    <?= $form->field($model, 'addr_2', ['template' => '<div class="col-sm-3 text-right">{label}</div>
<div class="col-sm-9 col-xs-12">{input}</div>
{hint}
{error}'])->textInput(['maxlength' => true]) ?>

    </div>    <div class="col-sm-12 col-xs-12">    <?= $form->field($model, 'contact_person', ['template' => '<div class="col-sm-3 text-right">{label}</div>
<div class="col-sm-9 col-xs-12">{input}</div>
{hint}
{error}'])->textInput(['maxlength' => true]) ?>

    </div>    <div class="col-sm-12 col-xs-12">    <?= $form->field($model, 'email', ['template' => '<div class="col-sm-3 text-right">{label}</div>
<div class="col-sm-9 col-xs-12">{input}</div>
{hint}
{error}'])->textInput(['maxlength' => true]) ?>

    </div>    <div class="col-sm-12 col-xs-12">    <?= $form->field($model, 'contact_no', ['template' => '<div class="col-sm-3 text-right">{label}</div>
<div class="col-sm-9 col-xs-12">{input}</div>
{hint}
{error}'])->textInput(['maxlength' => true]) ?>

    </div>    <div class="col-sm-12 col-xs-12">    <?= $form->field($model, 'title', ['template' => '<div class="col-sm-3 text-right">{label}</div>
<div class="col-sm-9 col-xs-12">{input}</div>
{hint}
{error}'])->textInput(['maxlength' => true]) ?>

    </div>    <div class="col-sm-12 col-xs-12">    <?= $form->field($model, 's_addr_1', ['template' => '<div class="col-sm-3 text-right">{label}</div>
<div class="col-sm-9 col-xs-12">{input}</div>
{hint}
{error}'])->textInput(['maxlength' => true]) ?>

    </div>    <div class="col-sm-12 col-xs-12">    <?= $form->field($model, 's_addr_2', ['template' => '<div class="col-sm-3 text-right">{label}</div>
<div class="col-sm-9 col-xs-12">{input}</div>
{hint}
{error}'])->textInput(['maxlength' => true]) ?>

    </div>    <div class="col-sm-12 col-xs-12">    <?= $form->field($model, 'b_addr_1', ['template' => '<div class="col-sm-3 text-right">{label}</div>
<div class="col-sm-9 col-xs-12">{input}</div>
{hint}
{error}'])->textInput(['maxlength' => true]) ?>

    </div>    <div class="col-sm-12 col-xs-12">    <?= $form->field($model, 'b_addr_2', ['template' => '<div class="col-sm-3 text-right">{label}</div>
<div class="col-sm-9 col-xs-12">{input}</div>
{hint}
{error}'])->textInput(['maxlength' => true]) ?>

    </div>    <div class="col-sm-12 col-xs-12">    <?= $form->field($model, 'b_term', ['template' => '<div class="col-sm-3 text-right">{label}</div>
<div class="col-sm-9 col-xs-12">{input}</div>
{hint}
{error}'])->textInput(['maxlength' => true]) ?>

    </div>    <div class="col-sm-12 col-xs-12">    <?= $form->field($model, 'b_currency', ['template' => '<div class="col-sm-3 text-right">{label}</div>
<div class="col-sm-9 col-xs-12">{input}</div>
{hint}
{error}'])->dropDownList($dataCurrency, ['class' => 'select2'])->label('Currency')  ?>

    </div>    <div class="col-sm-12 col-xs-12">    <?= $form->field($model, 'status', ['template' => '<div class="col-sm-3 text-right">{label}</div>
<div class="col-sm-9 col-xs-12">{input}</div>
{hint}
{error}'])->textInput(['maxlength' => true]) ?>

    </div>    <div class="col-sm-12 col-xs-12">    <?= $form->field($model, 'created', ['template' => '<div class="col-sm-3 text-right">{label}</div>
<div class="col-sm-9 col-xs-12">{input}</div>
{hint}
{error}'])->textInput() ?>

    </div>    <div class="col-sm-12 col-xs-12">    <?= $form->field($model, 'updated', ['template' => '<div class="col-sm-3 text-right">{label}</div>
<div class="col-sm-9 col-xs-12">{input}</div>
{hint}
{error}'])->textInput() ?>

    </div>		            <div class="col-sm-12 text-right">
		            <br>
					    <div class="form-group">
					        <?= Html::submitButton('<i class=\'fa fa-save\'></i> Save', ['class' => 'btn btn-primary']) ?>
		                    <?= Html::a( 'Cancel', Url::to('?r='.$backUrl), array('class' => 'btn btn-default')) ?>
					    </div>
				    </div>

				    <?php ActiveForm::end(); ?>
				    </div>
			    </div>
		    </div>
	    </div>
    </section>
</div>

<script type="text/javascript"> confi(); </script>