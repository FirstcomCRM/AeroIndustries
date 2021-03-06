<?php
// $session = Yii::$app->session;
// d($session->get('receiving_inspection'));
// d($session->get('worksheet'));
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
/* @var $data['model'] common\models\WorkOrder */
/* @var $form yii\widgets\ActiveForm */
$dataCustomer = Customer::dataCustomer();
$dataStaff = Staff::dataStaff();
$dataStaffId = Staff::dataStaffId();
$dataStaffTechnician = Staff::dataStaffTechnician();
$dataCurrency = Currency::dataCurrency();
$dataPart = Part::dataPart();
$dataPartDesc = Part::dataPartDesc();
$dataPartUnit = Part::dataPartUnit();
$dataTemplate = Template::dataTemplate();
$dataWorkType = Setting::dataWorkType();
$dataWorkScope = Setting::dataWorkScope();
$dataIDType = Setting::dataIDType();
$dataIdentifyFrom = Setting::dataIdentifyFrom();
$dataPartNo = Capability::dataPartNo();
$dataUnit = Unit::dataUnit();
$dataTraveler = Traveler::dataTraveler();
$dataLocation = StorageLocation::dataLocation();
$dataWorkStatus = Setting::dataWorkStatus();
$dataArcStatus = Setting::dataArcStatus();
/*plugins*/
use kartik\file\FileInput;
/* k6 */

$woNumber = 'Work Order No Missing';
if ( $data['model']->work_scope && $data['model']->work_type ) {
    $woNumber = Setting::getWorkNo($data['model']->work_type,$data['model']->work_scope,$data['model']->work_order_no);
}

?>

<div class="work-order-form">
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
                <li class="active"><a href="#tab_1" data-toggle="tab">Work Order <?= $woNumber ?></a></li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="tab_rece">
                    <div class="box-body arc-box">  
                        <div class="row">
                            <div class="col-sm-3 col-xs-6">
                                <label>Work Order No.</label>
                            </div>
                            <div class="col-sm-3 col-xs-6">
                                <?= $woNumber ?>
                            </div>
                            <div class="col-sm-3 col-xs-6">
                                <label>Part No.</label>
                            </div>
                            <div class="col-sm-3 col-xs-6">
                                <?= $data['eworkOrderPart']->part_no ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-3 col-xs-6">
                                <label>Description</label>
                            </div>
                            <div class="col-sm-3 col-xs-6">
                                <?= $data['eworkOrderPart']->desc ?>
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
                          <h3 class="box-title">Preliminary Inspection</h3>
                      </div>
                      <div class="box-body arc-box">  

                         <div class="">
                          <div class="box-body">


                            <div class="col-sm-12 col-xs-12">    
                            <?= $form->field($data['eworkOrderPart'], 'pma_used', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                                    <div class="col-sm-9 col-xs-12">{input}{error}{hint}</div>
                                    '])->textArea() 
                                    ?>
                                </div>  


                                <div class="col-sm-12 col-xs-12">    
                                    <?= $form->field($data['eworkOrderPart'], 'repair_supervisor', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                                        <div class="col-sm-9 col-xs-12">{input}{error}{hint}</div>
                                        '])->dropDownList($dataStaffId) 
                                        ?>
                                    </div>  


                                    <div class="col-sm-12 col-xs-12">    
                                        <?= $form->field($data['eworkOrderPart'], 'preliminary_date', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                                            <div class="col-sm-9 col-xs-12">{input}{error}{hint}</div>
                                            '])->textInput(['id' => 'datepicker8','readonly' => true]) 
                                            ?>
                                        </div>  

                                        <div class="col-sm-12 text-right">
                                            <button type="button" class="btn btn-primary" onclick="addDiscrepancy()">Add Discrepancy</button>
                                            <br>
                                            <br>
                                        </div>
                                        <div class="extra-discrepancy">
                                                <?php if ( $data['workPreliminary'] ) { ?>
                                                    <?php foreach ($data['workPreliminary'] as $workPreliminary) { ?>
                                                        <?php if (isset($workPreliminary->discrepancy)) { ?>
                                                        <div class="col-sm-12 col-xs-12">    
                                                            <div class="form-group field-workpreliminary-discrepancy">
                                                                <div class="col-sm-3 text-right">
                                                                    <label class="control-label" for="workpreliminary-discrepancy">Discrepancy</label>
                                                                </div>
                                                                <div class="col-sm-9 col-xs-12">
                                                                    <textarea id="workpreliminary-discrepancy" class="form-control" name="WorkPreliminary[discrepancy][]" rows="4"><?=$workPreliminary->discrepancy?></textarea>
                                                                    <div class="help-block">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div> 
                                                        <?php } ?>

                                                        <?php if (isset($workPreliminary->corrective)) { ?>
                                                        <div class="col-sm-12 col-xs-12">    
                                                            <div class="form-group field-workpreliminary-corrective">
                                                                <div class="col-sm-3 text-right">
                                                                    <label class="control-label" for="workpreliminary-corrective">Corrective</label>
                                                                </div>
                                                                <div class="col-sm-9 col-xs-12">
                                                                    <textarea id="workpreliminary-corrective" class="form-control" name="WorkPreliminary[corrective][]" rows="4"><?=$workPreliminary->corrective?></textarea>
                                                                    <div class="help-block">
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>  
                                                        <?php } ?>
                                                    <?php } ?>
                                                <?php } ?>
                                            <div class="col-sm-12 col-xs-12">    
                                                <div class="form-group field-workpreliminary-discrepancy">
                                                    <div class="col-sm-3 text-right">
                                                        <label class="control-label" for="workpreliminary-discrepancy">Discrepancy</label>
                                                    </div>
                                                    <div class="col-sm-9 col-xs-12">
                                                        <textarea id="workpreliminary-discrepancy" class="form-control" name="WorkPreliminary[discrepancy][]" rows="4"></textarea>
                                                        <div class="help-block">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div> 

                                            <div class="col-sm-12 col-xs-12">    
                                                <div class="form-group field-workpreliminary-corrective">
                                                    <div class="col-sm-3 text-right">
                                                        <label class="control-label" for="workpreliminary-corrective">Corrective</label>
                                                    </div>
                                                    <div class="col-sm-9 col-xs-12">
                                                        <textarea id="workpreliminary-corrective" class="form-control" name="WorkPreliminary[corrective][]" rows="4"></textarea>
                                                        <div class="help-block">
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>  

                                        </div>   
                                    </div>  
                                </div>  

                                <div class="">
                                    <div class="box-header with-border">
                                    </div>
                                    <!-- /.box-header -->

                                    <div class="box-body ">

                                        <div class="col-sm-12 col-xs-12">
                                         <?= $form->field($data['woAttachment'], 'attachment[preliminary_inspection][]', [
                                          'template' => "<div class='col-sm-3 text-right'>{label}{hint}</div>\n<div class='col-sm-9 col-xs-12'>{input}{error}</div>\n\n"
                                          ])
                                         ->widget(FileInput::classname(), [
                                            'options' => ['accept' => 'image/*'],
                                            ])->fileInput(['multiple' => true,])->label('Inspection Attachment(s)') ?>
                                        </div>   

                                        <div class="col-sm-12 col-xs-12">
                                            <div class='col-sm-3 text-right'>
                                            </div>

                                            <div class="col-sm-9 col-xs-12">
                                                <?php if ( !empty ( $data['currPreAtt'] ) ) { ?> 
                                                <?php foreach ( $data['currPreAtt'] as $at ) { 
                                                    $currentAttachmentClass = explode('\\', get_class($at))[2]; ?>
                                                    <?php 
                                                    $fileNameOnlyEx = explode('-', $at->value);

                                                    ?>
                                                    <div class="col-sm-3 col-xs-12">
                                                        <a href="<?= 'uploads/preliminary_inspection/' .$at->value ?>" target="_blank"><?= $fileNameOnlyEx[1] ?></a>
                                                        <?= Html::a(' <i class="fa fa-close"></i> ', ['work-order/remove-woa', 'id' => $at->id], [
                                                            'data' => [
                                                            'confirm' => 'Are you sure you want to remove this attachment?',
                                                            ],
                                                            ]) ?>
                                                        </div>
                                                        <?php } ?> 
                                                        <?php } else { ?> 
                                                        <div class="col-sm-12 col-xs-12">
                                                            No attachment found!
                                                        </div>
                                                        <?php } ?> 
                                                    </div>
                                                </div>   


                                                <div class="col-sm-12 col-xs-12">
                                                 <?= $form->field($data['woAttachment'], 'attachment[disposition][]', [
                                                  'template' => "<div class='col-sm-3 text-right'>{label}{hint}</div>\n<div class='col-sm-9 col-xs-12'>{input}{error}</div>\n\n"
                                                  ])
                                                 ->widget(FileInput::classname(), [
                                                    'options' => ['accept' => 'image/*'],
                                                    ])->fileInput(['multiple' => true,])->label('Disposition Attachment(s)') ?>
                                                </div>   

                                                <div class="col-sm-12 col-xs-12">
                                                        <div class='col-sm-3 text-right'>
                                                        </div>

                                                        <div class="col-sm-9 col-xs-12">
                                                            <?php if ( !empty ( $data['currDisAtt'] ) ) { ?> 
                                                                <?php foreach ( $data['currDisAtt'] as $at ) { 
                                                                    $currentAttachmentClass = explode('\\', get_class($at))[2]; ?>
                                                                    <?php 
                                                                    $fileNameOnlyEx = explode('-', $at->value);

                                                                    ?>
                                                                    <div class="col-sm-3 col-xs-12">
                                                                        <a href="<?= 'uploads/disposition/' .$at->value ?>" target="_blank"><?= $fileNameOnlyEx[1] ?></a>
                                                                        <?= Html::a(' <i class="fa fa-close"></i> ', ['work-order/remove-woa', 'id' => $at->id], [
                                                                            'data' => [
                                                                            'confirm' => 'Are you sure you want to remove this attachment?',
                                                                            ],
                                                                            ]) ?>
                                                                    </div>
                                                                <?php } ?> 
                                                            <?php } else { ?> 
                                                                <div class="col-sm-12 col-xs-12">
                                                                    No attachment found!
                                                                </div>
                                                            <?php } ?> 
                                                        </div>
                                                        </div>   
                                                    </div>
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
