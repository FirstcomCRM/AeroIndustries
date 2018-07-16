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
                                      <h3 class="box-title">Receiving Inspection</h3>
                                    </div>
                                    <div class="box-body arc-box">  

                                        <div class="col-sm-12 col-xs-12">    
                                            <?= $form->field($data['eworkOrderPart'], 'is_document', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                                                <div class="col-sm-9 col-xs-12">{input}{error}{hint}</div>
                                                '])->checkbox()
                                            ?>
                                        </div>  

                                        <div class="col-sm-12 col-xs-12">    
                                            <?= $form->field($data['eworkOrderPart'], 'is_tag', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                                                <div class="col-sm-9 col-xs-12">{input}{error}{hint}</div>
                                                '])->checkbox()
                                            ?>
                                        </div>  

                                        <div class="col-sm-12 col-xs-12">    
                                            <?= $form->field($data['eworkOrderPart'], 'is_id', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                                                <div class="col-sm-9 col-xs-12">{input}{error}{hint}</div>
                                                '])->checkbox()
                                            ?>
                                        </div>  

                                        <div class="col-sm-12 col-xs-12">    
                                            <?= $form->field($data['eworkOrderPart'], 'tag_type', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                                                <div class="col-sm-9 col-xs-12">{input}{error}{hint}</div>
                                                '])->dropDownList($dataIDType)
                                            ?>
                                        </div>  

                                        <div class="col-sm-12 col-xs-12">    
                                            <?= $form->field($data['eworkOrderPart'], 'identify_from', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                                                <div class="col-sm-9 col-xs-12">{input}{error}{hint}</div>
                                                '])->dropDownList($dataIdentifyFrom)
                                            ?>
                                        </div>  

                                        <div class="col-sm-12 col-xs-12">    
                                            <?= $form->field($data['eworkOrderPart'], 'part_no_1', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                                                <div class="col-sm-9 col-xs-12">{input}{error}{hint}</div>
                                                '])->textInput()
                                            ?>
                                        </div>  

                                        <div class="col-sm-12 col-xs-12">    
                                            <?= $form->field($data['eworkOrderPart'], 'part_no_2', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                                                <div class="col-sm-9 col-xs-12">{input}{error}{hint}</div>
                                                '])->textInput()
                                            ?>
                                        </div>  

                                        <div class="col-sm-12 col-xs-12">    
                                            <?= $form->field($data['eworkOrderPart'], 'part_no_3', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                                                <div class="col-sm-9 col-xs-12">{input}{error}{hint}</div>
                                                '])->textInput()
                                            ?>
                                        </div>  

                                        <div class="col-sm-12 col-xs-12">    
                                            <?= $form->field($data['eworkOrderPart'], 'is_discrepancy', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                                                <div class="col-sm-9 col-xs-12">{input}{error}{hint}</div>
                                                '])->checkbox()
                                            ?>
                                        </div>    

                                        <div class="col-sm-12 col-xs-12">    
                                            <?= $form->field($data['eworkOrderPart'], 'corrective', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                                                <div class="col-sm-9 col-xs-12">{input}{error}{hint}</div>
                                                '])->textArea(['rows' => 3])
                                            ?>
                                        </div>  

                                        <div class="col-sm-12 col-xs-12">    
                                            <?= $form->field($data['eworkOrderPart'], 'remarks', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                                                <div class="col-sm-9 col-xs-12">{input}{error}{hint}</div>
                                                '])->textArea(['rows' => 3])
                                            ?>
                                        </div>  

                                        <div class="col-sm-12 col-xs-12">
                                           <?= $form->field($data['woAttachment'], 'attachment[receiving][]', [
                                                  'template' => "<div class='col-sm-3 text-right'>{label}{hint}</div>\n<div class='col-sm-9 col-xs-12'>{input}{error}</div>\n\n"
                                                ])
                                                ->widget(FileInput::classname(), [
                                                'options' => ['accept' => 'image/*'],
                                            ])->fileInput(['multiple' => true,])->label('Upload Attachment(s)') ?>
                                        </div>      
                                        <div class='col-sm-3 text-right'>
                                            <label>Work Order Attachment</label>
                                        </div>
                                        <div class="col-sm-9 col-xs-12">
                                        <?php if ( !empty ( $data['currWoAtt'] ) ) { ?> 
                                            <?php foreach ( $data['currWoAtt'] as $at ) { 
                                                $currentAttachmentClass = explode('\\', get_class($at))[2]; ?>
                                                <?php 
                                                    $fileNameOnlyEx = explode('-', $at->value);

                                                ?>
                                                <div class="col-sm-3 col-xs-12">
                                                    <a href="<?= 'uploads/receiving/' .$at->value ?>" target="_blank"><?= $fileNameOnlyEx[1] ?></a> 
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
        <?php ActiveForm::end(); ?>
    </section>
</div>
<script type="text/javascript"> confi(); </script>
