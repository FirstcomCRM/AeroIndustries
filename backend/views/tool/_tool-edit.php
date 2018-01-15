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

use common\models\Part;
use common\models\StorageLocation;
use common\models\Unit;
use common\models\GeneralPo;
use common\models\Supplier;
/* @var $this yii\web\View */
/* @var $model common\models\Tool */
/* @var $form yii\widgets\ActiveForm */
$dataSupplier = ArrayHelper::map(Supplier::find()->where(['<>','status','inactive'])->all(), 'id', 'company_name');
$dataStorage = ArrayHelper::map(StorageLocation::find()->where(['<>', 'deleted', 1])->andWhere(['<>','status','inactive'])->all(), 'id', 'name');
$dataPart = ArrayHelper::map(Part::find()->where(['<>','status','inactive'])->all(), 'id', 'part_no');
$dataUnit = ArrayHelper::map(Unit::find()->where(['<>','status','inactive'])->all(), 'id', 'unit');
$dataAllGPO = GeneralPo::dataAllGPO();
$dataAllGPOCreated = GeneralPo::dataAllGPOCreated();

foreach ( $dataAllGPO as $id => $dp) {
    $created = $dataAllGPOCreated[$id];
    $dataGeneralPo[$id] = GeneralPo::getGPONo($dp,$created);
}
/*plugins*/
use kartik\file\FileInput;

?>

<div class="tool-form">
	<section class="content">
        <?php $form = ActiveForm::begin(); ?>
        <div class="form-group text-right">
            <?= Html::submitButton('<i class="fa fa-save"></i> Save', ['class' => 'btn btn-primary']) ?>
            <button type="button" class="back-button btn btn-default">Cancel</button>
            &nbsp;
        </div>

        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#tab_1" data-toggle="tab">Basic Info</a></li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="tab_1">
                    <div class="row">
                        <div class="col-xs-12">

                            <div class="box">
                                <div class="box-header with-border">
                                  <h3 class="box-title">Update <?= $dataPart[$model->part_id] ?></h3>
                                </div>
                                <!-- /.box-header -->
            							    
                                <div class="box-body ">

                                    <div class="col-sm-12 col-xs-12">

                                        <div class="col-sm-3 text-right">
                                            <label>
                                                Purchase Order
                                            </label>
                                        </div>
                                        <div class="col-sm-9 col-xs-12">
                                            <input type="text" class="form-control" value="<?= $dataGeneralPo[$model->general_po_id] ?>" readonly="">
                                            <div class="help-block"></div>
                                        </div>
                                        <?= $form->field($model, 'general_po_id')->hiddenInput()->label(false) ?>
                                    </div>

                                    <div class="col-sm-12 col-xs-12">
                                        <div class="col-sm-3 text-right">
                                            <label>
                                                Supplier
                                            </label>
                                        </div>
                                        <div class="col-sm-9 col-xs-12">
                                            <input type="text" class="form-control" value="<?= $dataSupplier[$model->supplier_id] ?>" readonly="">
                                            <div class="help-block"></div>
                                        </div>
                                        <?= $form->field($model, 'supplier_id')->hiddenInput()->label(false) ?>
                                    </div>

                                    <div class="col-sm-12 col-xs-12">
                                        <div class="col-sm-3 text-right">
                                            <label>
                                                Part
                                            </label>
                                        </div>
                                        <div class="col-sm-9 col-xs-12">
                                            <input type="text" class="form-control" value="<?= $dataPart[$model->part_id] ?>" readonly="">
                                            <div class="help-block"></div>
                                        </div>
                                        <?= $form->field($model, 'part_id')->hiddenInput()->label(false) ?>
                                    </div>
                                    
                                    <div class="col-sm-12 col-xs-12">
                                        <?= $form->field($model, 'desc', 
                                        ['template' => '<div class="col-sm-3 text-right">{label}</div><div class="col-sm-9 col-xs-12">{input}{error}</div>
                                            {hint}
                                            '
                                        ])->textInput(['maxlength' => true]) ?>
                                    </div>
                                    
                                    <div class="col-sm-12 col-xs-12">
                                        <?= $form->field($model, 'storage_location_id', 
                                        ['template' => '<div class="col-sm-3 text-right">{label}</div><div class="col-sm-9 col-xs-12">{input}{error}</div>
                                            {hint}
                                            '
                                        ])->dropDownList($dataStorage, ['class' => 'select2 form-control','prompt' => 'Please select location'])->label('Storage') ?>
                                    </div>
                                    
                                    <div class="col-sm-12 col-xs-12">
                                        <?= $form->field($model, 'batch_no', 
                                        ['template' => '<div class="col-sm-3 text-right">{label}</div><div class="col-sm-9 col-xs-12">{input}{error}</div>
                                            {hint}
                                            '
                                        ])->textInput(['maxlength' => true]) ?>
                                    </div>
                                    
                                    <div class="col-sm-12 col-xs-12">
                                        <?= $form->field($model, 'serial_no', 
                                        ['template' => '<div class="col-sm-3 text-right">{label}</div><div class="col-sm-9 col-xs-12">{input}{error}</div>
                                            {hint}
                                            '
                                        ])->textInput(['maxlength' => true]) ?>
                                    </div>
                                    
                                    <div class="col-sm-12 col-xs-12">
                                        <?= $form->field($model, 'note', 
                                        ['template' => '<div class="col-sm-3 text-right">{label}</div><div class="col-sm-9 col-xs-12">{input}{error}</div>
                                            {hint}
                                            '
                                        ])->textInput(['maxlength' => true]) ?>
                                    </div>
                                    
                                    
                                    <div class="col-sm-12 col-xs-12">
                                        <?= $form->field($model, 'unit_id', 
                                        ['template' => '<div class="col-sm-3 text-right">{label}</div><div class="col-sm-9 col-xs-12">{input}{error}</div>
                                            {hint}
                                            '
                                        ])->dropDownList($dataUnit,['class' => 'select2'])->label('Unit') ?>
                                    </div>
                                    
                                    
                                    <div class="col-sm-12 col-xs-12">
                                        <?= $form->field($model, 'unit_price', 
                                        ['template' => '<div class="col-sm-3 text-right">{label}</div><div class="col-sm-9 col-xs-12">{input}{error}</div>
                                            {hint}
                                            '
                                        ])->textInput(['maxlength' => true]) ?>
                                    </div>
                                    
                                    <div class="col-sm-12 col-xs-12">
                                        <?= $form->field($model, 'received', 
                                        ['template' => '<div class="col-sm-3 text-right">{label}</div><div class="col-sm-9 col-xs-12">{input}{error}</div>
                                            {hint}
                                            '
                                        ])->textInput(['id' => 'datepicker', 'autocomplete' => 'off', 'placeholder' => 'Please select date', 'value' => date('Y-m-d')]) ?>
                                    </div>
                                    
                                    <div class="col-sm-12 col-xs-12">
                                        <?= $form->field($model, 'time_used', 
                                        ['template' => '<div class="col-sm-3 text-right">{label}</div><div class="col-sm-9 col-xs-12">{input}{error}</div>
                                            {hint}
                                            '
                                        ])->textInput(['maxlength' => true]) ?>

                                    </div>
                                    
                                    <div class="col-sm-12 col-xs-12">
                                        <?= $form->field($model, 'shelf_life', 
                                        ['template' => '<div class="col-sm-3 text-right">{label}</div><div class="col-sm-9 col-xs-12">{input}{error}</div>
                                            {hint}
                                            '
                                        ])->textInput(['maxlength' => true]) ?>

                                    </div>
                                    
                                    <div class="col-sm-12 col-xs-12">
                                        <?= $form->field($model, 'hour_used', 
                                        ['template' => '<div class="col-sm-3 text-right">{label}</div><div class="col-sm-9 col-xs-12">{input}{error}</div>
                                            {hint}
                                            '
                                        ])->textInput(['maxlength' => true]) ?>

                                    </div>
                                    
                                    <div class="col-sm-12 col-xs-12">
                                        <?= $form->field($model, 'expiration_date', 
                                        ['template' => '<div class="col-sm-3 text-right">{label}</div><div class="col-sm-9 col-xs-12">{input}{error}</div>
                                            {hint}
                                            '
                                        ])->textInput(['id' => 'datepicker2', 'autocomplete' => 'off', 'placeholder' => 'Please select date']) ?>

                                    </div>
                                    
                                    <div class="col-sm-12 col-xs-12">
                                        <?= $form->field($model, 'status', 
                                        ['template' => '<div class="col-sm-3 text-right">{label}</div><div class="col-sm-9 col-xs-12">{input}{error}</div>
                                            {hint}
                                            '
                                        ])->dropDownList([ 1 => 'Active', 0 => 'Inactive']) ?>

                                    </div>	



                                </div>
                            </div> <!-- box -->
                        </div>
                    </div>
                </div>

            </div> <!--  tab content -->
        </div>
        <?php ActiveForm::end(); ?>
    </section>
</div>
