<?php
// $session = Yii::$app->session;
// d($session->get('receiving_inspection'));
// d($session->get('uphosterysheet'));
// d($session->get('preliminary'));
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
use common\models\Customer;
use common\models\Staff;
use common\models\Part;
use common\models\Template;
use common\models\Capability;
use common\models\StorageLocation;
use common\models\Traveler;
use common\models\Unit;
use common\models\Setting;
/* @var $this yii\web\View */
/* @var $data['model'] common\models\Uphostery */
/* @var $form yii\widgets\ActiveForm */
$dataCustomer = Customer::dataCustomer();
$dataStaff = Staff::dataStaff();
$dataStaffTechnician = Staff::dataStaffTechnician();
$dataCurrency = Currency::dataCurrency();
$dataPart = Part::dataPart();
$dataPartDesc = Part::dataPartDesc();
$dataPartUnit = Part::dataPartUnit();
$dataTemplate = Template::dataTemplate();
$dataUphosteryType = Setting::dataUphosteryType();
$dataUphosteryScope = Setting::dataUphosteryScope();
$dataIDType = Setting::dataIDType();
$dataIdentifyFrom = Setting::dataIdentifyFrom();
$dataPartNo = Capability::dataPartNo();
$dataUnit = Unit::dataUnit();
$dataTraveler = Traveler::dataTraveler();
$dataLocation = StorageLocation::dataLocation();
$dataUphosteryStatus = Setting::dataUphosteryStatus();
$dataArcStatus = Setting::dataArcStatus();
/*plugins*/
use kartik\file\FileInput;
/* k6 */

$upNumber = 'Uphostery No Missing';
if ( $data['model']->uphostery_scope && $data['model']->uphostery_type ) {
    $upNumber = Setting::getUphosteryNo($data['model']->uphostery_type,$data['model']->uphostery_scope,$data['model']->uphostery_no);
}

?>

<div class="uphostery-order-form">
	<section class="content">
        <?php $form = ActiveForm::begin(); ?>
            <div class="form-group text-right">
                <?= Html::submitButton('<i class="fa fa-save"></i> Save', ['class' => 'btn btn-primary']) ?>
                <?php Html::a( 'Cancel', Url::to(['index']), array('class' => 'btn btn-default')) ?>
                <button class="btn btn-default back-button">Cancel</button>
                &nbsp;
            </div>
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#tab_1" data-toggle="tab">Uphostery <?= $upNumber ?></a></li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="tab_rece">
                        <div class="box-body arc-box">  
                            <div class="row">
                                <div class="col-sm-3 col-xs-6">
                                    <label>Uphostery No.</label>
                                </div>
                                <div class="col-sm-3 col-xs-6">
                                    <?= $upNumber ?>
                                </div>
                                <div class="col-sm-3 col-xs-6">
                                    <label>Part No.</label>
                                </div>
                                <div class="col-sm-3 col-xs-6">
                                    <?= $data['euphosteryPart']->part_no ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-3 col-xs-6">
                                    <label>Description</label>
                                </div>
                                <div class="col-sm-3 col-xs-6">
                                    <?= $data['euphosteryPart']->desc ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="box box-success">

                   <?php /* Receiving Inspection  */  ?>

                        <div class="tab-pane active" id="tab_rece">
                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="box-header with-border">
                                      <h3 class="box-title">ARC</h3>
                                    </div>
                                    <div class="box-body arc-box">  
                    
                                        <!-- /.box-header -->
                                        <div class="col-sm-12 col-xs-12">    
                                            <?= $form->field($data['euphosteryPart'], 'arc_status', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                                                <div class="col-sm-9 col-xs-12">{input}{error}{hint}</div>
                                                '])->dropDownList($dataArcStatus) 
                                            ?>
                                        </div> 
                                        <div class="col-sm-12 col-xs-12">    
                                            <?= $form->field($data['euphosteryPart'], 'arc_remarks', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                                                <div class="col-sm-9 col-xs-12">{input}{error}{hint}</div>
                                                '])->textArea(['maxlength' => true,'rows' => 8]) 
                                            ?>
                                        </div> 

                                    </div>  

                                </div>
                            </div>
                        </div>

                </div>
    	    </div>
        <?php ActiveForm::end(); ?>
    </section>
</div>
<script type="text/javascript"> confi(); </script>
