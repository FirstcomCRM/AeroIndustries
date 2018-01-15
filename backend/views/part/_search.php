<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

use common\models\PartCategory;
/* @var $this yii\web\View */
/* @var $model common\models\SearchPart */
/* @var $form yii\widgets\ActiveForm */
$dataCategory = ArrayHelper::map(PartCategory::find()->all(), 'id', 'name');
?>

<div class="part-search">

    <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Filter</h3>
        </div>
        <div class="box-body">
            <?php $form = ActiveForm::begin([
                'action' => ['index'],
                'method' => 'get',
            ]); ?>
            <div class="col-sm-3 col-xs-12">
                <?= $form->field($model, 'category_id')->dropDownList($dataCategory, ['class' => 'select2 form-control','prompt' => 'All Category'])->label(false) ?>
            </div>
            <div class="col-sm-3 col-xs-12">
                <?= $form->field($model, 'part_no')->textInput(['autocomplete' => 'off', 'placeholder' => 'Part No.'])->label(false) ?>
            </div>
            <div class="col-sm-3 col-xs-12">
                <?= $form->field($model, 'status')->dropDownList([ 1 => 'Active', 0 => 'Inactive'], ['class' => 'select2 form-control','prompt' => 'All Status'])->label(false) ?>
            </div>
            <div class="col-sm-2 col-xs-12 pull-right">
                <div class="form-group">
                    <?= Html::submitButton('<i class="fa fa-search"></i> Search', ['class' => 'btn btn-primary']) ?>
                    <?= Html::a( 'Reset', Url::to(['index']), array('class' => 'btn btn-default')); ?>
                </div>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>

</div>
