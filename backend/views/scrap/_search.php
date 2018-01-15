<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

use common\models\WorkOrder;
/* @var $this yii\web\View */
/* @var $model common\models\SearchScrap */
/* @var $form yii\widgets\ActiveForm */
$dataWorkOrder = ArrayHelper::map(WorkOrder::find()->where(['<>','deleted','1'])->all(), 'id', 'work_order_no');
?>

<div class="scrap-search">

    <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Filter</h3>
        </div>
        <div class="box-body">
                <?php $form = ActiveForm::begin([
                    'action' => ['index'],
                    'method' => 'get',
                ]); ?>

            <div class='col-sm-3 col-xs-12'>    
                <?= $form->field($model, 'work_order_id')->dropDownList($dataWorkOrder,['class' => 'select2', 'prompt' => 'All Work Order'])->label(false) ?>
            </div>
            <div class='col-sm-3 col-xs-12'>    
                <?= $form->field($model, 'part_no')->textInput(['autocomplete' => 'off', 'placeholder' => 'Part No.'])->label(false) ?>
            </div>
            <div class='col-sm-3 col-xs-12'>    
                <?= $form->field($model, 'serial_no')->textInput(['autocomplete' => 'off', 'placeholder' => 'Serial No.'])->label(false) ?>
            </div>    
<?php // echo $form->field($model, 'date') ?>

    <?php // echo $form->field($model, 'remark') ?>

    <?php // echo $form->field($model, 'created') ?>

    <?php // echo $form->field($model, 'created_by') ?>

    <?php // echo $form->field($model, 'updated') ?>

    <?php // echo $form->field($model, 'updated_by') ?>

    <?php // echo $form->field($model, 'deleted') ?>

        <div class="col-sm-12 text-right">
            <div class="form-group">
                <?= Html::submitButton('<i class=\"fa fa-search\"></i> Search', ['class' => 'btn btn-primary']) ?>
                <?= Html::a( 'Reset', Url::to(['index']), array('class' => 'btn btn-default')) ?>
                
            </div>
        </div>

        <?php ActiveForm::end(); ?>
        </div>
    </div>

</div>
