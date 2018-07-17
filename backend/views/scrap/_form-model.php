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

use common\models\Setting;
use common\models\WorkOrder;

/* @var $this yii\web\View */
/* @var $model common\models\Scrap */
/* @var $form yii\widgets\ActiveForm */

$wtype = [
  'work_order'=>'work_order',
  'upholstery'=>'upholstery',
];


$dataWorkOrder = WorkOrder::dataWorkOrder();
$dataWorkO = [];
foreach ( $dataWorkOrder as $id => $dwo ) {
    $workOrder = WorkOrder::getWorkOrder($id);
    if ( $workOrder->work_scope && $workOrder->work_type ) {
        $woNumber = Setting::getWorkNo($workOrder->work_type,$workOrder->work_scope,$workOrder->work_order_no);
        $dataWorkO[$id] = $woNumber;
    }
}
$workOrderId = '';
if ( isset( $_GET['work_order_id'] ) ) {
    $workOrderId = $_GET['work_order_id'];
}

$data = WorkOrder::find()->where(['id'=>$model->work_order_id])->one();
$woNumber = Setting::getWorkNo($data->work_type,$data->work_scope,$data->work_order_no);

$work_array = [
  $data->id=>$woNumber
];
//print_r($work_array);die();


?>

<div class="scrap-form">
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

                        <div class="col-sm-12 col-xs-12">
                              <?php //old variable in dropdownList is $dataWorkO ?>
                            <?= $form->field($model, 'work_order_id', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                                <div class="col-sm-9 col-xs-12">{input}</div>
                                {hint}
                                {error}'])->dropDownList($work_array, ['options' => [$workOrderId => ['Selected'=>'selected']],'class' => 'select2']) ?>

                        </div>


                        <div class="col-sm-12 col-xs-12">
                              <?php //old variable in dropdownList is $dataWorkO ?>
                              <?= $form->field($model, 'work_type', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                                        <div class="col-sm-9 col-xs-12">{input}</div>
                                        {hint}
                                        {error}'])->dropDownList($wtype) ?>

                        </div>

                        <div class="col-sm-12 col-xs-12">
                            <?= $form->field($model, 'part_no', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                            <div class="col-sm-9 col-xs-12">{input}</div>
                            {hint}
                            {error}'])->textInput(['maxlength' => true]) ?>

                        </div>
                        <div class="col-sm-12 col-xs-12">
                            <?= $form->field($model, 'description', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                            <div class="col-sm-9 col-xs-12">{input}</div>
                            {hint}
                            {error}'])->textInput(['maxlength' => true]) ?>

                        </div>
                        <div class="col-sm-12 col-xs-12">
                            <?= $form->field($model, 'serial_no', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                            <div class="col-sm-9 col-xs-12">{input}</div>
                            {hint}
                            {error}'])->textInput(['maxlength' => true]) ?>

                        </div>
                        <div class="col-sm-12 col-xs-12">
                            <?= $form->field($model, 'batch_no', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                            <div class="col-sm-9 col-xs-12">{input}</div>
                            {hint}
                            {error}'])->textInput(['maxlength' => true]) ?>

                        </div>
                        <div class="col-sm-12 col-xs-12">
                            <?= $form->field($model, 'date', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                            <div class="col-sm-9 col-xs-12">{input}</div>
                            {hint}
                            {error}'])->textInput(['id' => 'datepicker1','readonly' => true]) ?>

                        </div>
                        <div class="col-sm-12 col-xs-12">
                            <?= $form->field($model, 'remark', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                            <div class="col-sm-9 col-xs-12">{input}</div>
                            {hint}
                            {error}'])->textInput(['maxlength' => true]) ?>

                        </div>
                        <div class="col-sm-12 text-right">
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
