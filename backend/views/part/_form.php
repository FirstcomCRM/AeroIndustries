<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

$backUrlFull = Yii::$app->request->referrer;
$exBackUrlFull = explode('?r=', $backUrlFull);

$backUrl = '#';
if ( isset ( $exBackUrlFull[1] ) ) {
$backUrl = $exBackUrlFull[1];
}

use common\models\PartCategory;
use common\models\Supplier;
use common\models\Unit;
/* @var $this yii\web\View */
/* @var $model common\models\Part */
/* @var $form yii\widgets\ActiveForm */
$dataUnit = ArrayHelper::map(Unit::find()->all(), 'id', 'unit');
$dataCategory = ArrayHelper::map(PartCategory::find()->all(), 'id', 'name');
$dataSupplier = Supplier::dataSupplier();
?>

<div class="part-form">
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
                            <?php 
                            echo
                             $form->field($model, 'category_id', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                            <div class="col-sm-7 col-xs-12">{input}</div><div class="col-sm-2 col-xs-12"><a href="?r=part-category/create" target="_blank">Add New Category</a></div>
                            {hint}
                            {error}'])->dropDownList($dataCategory,['class' => 'select2 form-control','prompt' => 'Please select category'])->label('Category') 
                            ?>


                        </div>

                        <div class="col-sm-12 col-xs-12">
                            <?= $form->field($model, 'supplier_id', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                            <div class="col-sm-9 col-xs-12">{input}</div>
                            {hint}
                            {error}'])->dropDownList($dataSupplier,['class' => 'select2'])->label('Supplier') ?>
                        </div>

                        <div class="col-sm-12 col-xs-12">
                            <?= $form->field($model, 'part_no', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                            <div class="col-sm-9 col-xs-12">{input}</div>
                            {hint}
                            {error}'])->textInput(['maxlength' => true]) ?>
                        </div>

                        <div class="col-sm-12 col-xs-12">
                            <?= $form->field($model, 'type', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                            <div class="col-sm-9 col-xs-12">{input}</div>
                            {hint}
                            {error}'])->dropDownList(['part' => 'Part', 'tool' => 'Tools']) ?>
                        </div>

                        <div class="col-sm-12 col-xs-12">
                            <?= $form->field($model, 'desc', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                            <div class="col-sm-9 col-xs-12">{input}</div>
                            {hint}
                            {error}'])->textArea(['maxlength' => true,'rows' => 5]) ?>
                        </div>


                        <div class="col-sm-12 col-xs-12">
                            <?= $form->field($model, 'unit_id', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                            <div class="col-sm-9 col-xs-12">{input}</div>
                            {hint}
                            {error}'])->dropDownList($dataUnit,['class' => 'select2'])->label('Unit') ?>
                        </div>

                        <div class="col-sm-12 col-xs-12">
                            <?= $form->field($model, 'manufacturer', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                            <div class="col-sm-9 col-xs-12">{input}</div>
                            {hint}
                            {error}'])->textInput(['maxlength' => true]) ?>
                        </div>
                        <div class="col-sm-12 col-xs-12">
                            <?= $form->field($model, 'default_unit_price', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                            <div class="col-sm-9 col-xs-12">{input}</div>
                            {hint}
                            {error}'])->textInput(['maxlength' => true]) ?>
                        </div>

                        <div class="col-sm-12 col-xs-12">
                            <?= $form->field($model, 'restock', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                            <div class="col-sm-9 col-xs-12">{input}</div>
                            {hint}
                            {error}'])->textInput() ?>
                        </div>
                        <div class="col-sm-12 col-xs-12">
                            <?= $form->field($model, 'status', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                            <div class="col-sm-9 col-xs-12">{input}</div>
                            {hint}
                            {error}'])->dropDownList([ 'active' => 'Active', 'inactive' => 'Inactive' ]) ?>
                        </div>
                        <div class="col-sm-12 col-xs-12">
                            <?= $form->field($model, 'is_shelf_life', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                            <div class="col-sm-9 col-xs-12">{input}</div>
                            {hint}
                            {error}'])->dropDownList([ '1' => 'Yes', '0' => 'No' ]) ?>
                        </div>

                        <div class="col-sm-12 text-right">
        	            <br>
        				    <div class="form-group">
        				        <?= Html::submitButton('<i class="fa fa-save"></i> Save', ['class' => 'btn btn-primary']) ?>
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