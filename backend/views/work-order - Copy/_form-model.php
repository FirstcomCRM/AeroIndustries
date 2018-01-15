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
?>

<div class="work-order-form">
	<section class="content">
        <?php $form = ActiveForm::begin(); ?>

            <div class="form-group text-right">
                <?= Html::submitButton('<i class="fa fa-save"></i> Save', ['class' => 'btn btn-primary']) ?>
                <?= Html::a( 'Cancel', Url::to(['index']), array('class' => 'btn btn-default')) ?>
                &nbsp;
            </div>

            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#tab_1" data-toggle="tab">Work Order Details</a></li>
                    <li><a href="#tab_rece" data-toggle="tab">Receiving Inspection</a></li>
                    <li><a href="#tab_2" data-toggle="tab">Part</a></li>
                    <li><a href="#tab_traver" data-toggle="tab">Worksheet</a></li>
                    <li><a href="#tab_3" data-toggle="tab">Preliminary Inspection</a></li>
                    <li><a href="#tab_4" data-toggle="tab">Hidden Damage Inspection</a></li>
                    <li><a href="#tab_6" data-toggle="tab">Employee</a></li>
                    <li><a href="#tab_7" data-toggle="tab">ARC</a></li>
                    <?php if ( $data['isEdit'] ) { ?> 
                        <li><a href="#tab_8" data-toggle="tab">Final Inspection</a></li>
                    <?php } ?>
                </ul>
                <div class="tab-content">
                    <?php /* Work order detail*/ ?>
                        <div class="tab-pane active" id="tab_1">
                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="">
                                        <div class="box-header with-border">
                                          <h3 class="box-title"><?= $data['subTitle'] ?></h3>
                                        </div>
                                        <!-- /.box-header -->

                                        <div class="box-body ">
                    							        
                                            
                                            <div class="col-sm-12 col-xs-12">    
                                                <?= $form->field($data['model'], 'customer_id', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                                                    <div class="col-sm-9 col-xs-12">{input}{error}{hint}</div>
                                                    '])->dropDownList($dataCustomer,['class' => 'select2 form-control',])->label('Customer') 
                                                ?>

                                            </div>    
                                            
                                            <div class="col-sm-12 col-xs-12">    
                                                <?= $form->field($data['model'], 'customer_po_no', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                                                    <div class="col-sm-9 col-xs-12">{input}{error}{hint}</div>
                                                    '])->textInput(['maxlength' => true])->label("Customer PO No.") 
                                                ?>

                                            </div>    
                                            
                                            <div class="col-sm-12 col-xs-12">    
                                                <?= $form->field($data['model'], 'work_scope', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                                                    <div class="col-sm-9 col-xs-12">{input}{error}{hint}</div>
                                                    '])->dropDownList($dataWorkScope) 
                                                ?>

                                            </div>    
                                            
                                            <div class="col-sm-12 col-xs-12">    
                                                <?= $form->field($data['model'], 'date', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                                                    <div class="col-sm-9 col-xs-12">{input}{error}{hint}</div>
                                                    '])->textInput(['id'=>'datepicker', 'autocomplete' => 'off', 'placeholder' => 'Please select date','readonly' => true])
                                                ?>

                                            </div>  

                                            <div class="col-sm-12 col-xs-12">    
                                                <?= $form->field($data['model'], 'received_date', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                                                    <div class="col-sm-9 col-xs-12">{input}{error}{hint}</div>
                                                    '])->textInput(['id'=>'datepicker2', 'autocomplete' => 'off', 'placeholder' => 'Please select date','readonly' => true]) 
                                                ?>

                                            </div>  
                      
                                            <div class="col-sm-12 col-xs-12">    
                                                <?= $form->field($data['model'], 'approval_date', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                                                    <div class="col-sm-9 col-xs-12">{input}{error}{hint}</div>
                                                    '])->textInput(['id'=>'datepicker5', 'autocomplete' => 'off', 'placeholder' => 'Please select date','readonly' => true]) 
                                                ?>

                                            </div>  

                                            <div class="col-sm-12 col-xs-12">    
                                                <?= $form->field($data['model'], 'on_dock_date', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                                                    <div class="col-sm-9 col-xs-12">{input}{error}{hint}</div>
                                                    '])->textInput(['id'=>'datepicker3', 'autocomplete' => 'off', 'placeholder' => 'Please select date','readonly' => true]) 
                                                ?>

                                            </div>    
                      
                                            <div class="col-sm-12 col-xs-12">    
                                                <?= $form->field($data['model'], 'needs_by_date', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                                                    <div class="col-sm-9 col-xs-12">{input}{error}{hint}</div>
                                                    '])->textInput(['id'=>'datepicker4', 'autocomplete' => 'off', 'placeholder' => 'Please select date','readonly' => true]) 
                                                ?>

                                            </div>  
                      
                                            <div class="col-sm-12 col-xs-12">    
                                                <?= $form->field($data['model'], 'disposition_date', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                                                    <div class="col-sm-9 col-xs-12">{input}{error}{hint}</div>
                                                    '])->textInput(['id'=>'datepicker7', 'autocomplete' => 'off', 'placeholder' => 'Please select date','readonly' => true]) 
                                                ?>

                                            </div>  
                      
                                            <div class="col-sm-12 col-xs-12">    
                                                <?= $form->field($data['model'], 'status', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                                                    <div class="col-sm-9 col-xs-12">{input}{error}{hint}</div>
                                                    '])->dropDownList($dataWorkStatus, ['class' => 'select2 form-control']) 
                                                ?>
                                            </div>   
                                            
                                            <div class="col-sm-12 col-xs-12">
                                               <?= $form->field($data['woAttachment'], 'attachment[wo][]', [
                                                      'template' => "<div class='col-sm-3 text-right'>{label}{hint}</div>\n<div class='col-sm-9 col-xs-12'>{input}{error}</div>\n\n"
                                                    ])
                                                    ->widget(FileInput::classname(), [
                                                    'options' => ['accept' => 'image/*'],
                                                ])->fileInput(['multiple' => true,])->label('Upload Attachment(s)') ?>
                                            </div>      
                                            <?php if ( $data['isEdit'] ) { ?> 
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
                                                            <a href="<?= 'uploads/wo/' .$at->value ?>" target="_blank"><?= $fileNameOnlyEx[1] ?></a> 
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
       
                                            <?php } ?>
       
                                            <div class="col-sm-12 col-xs-12">    
                                                <?= $form->field($data['model'], 'complaint', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                                                    <div class="col-sm-9 col-xs-12">{input}{error}{hint}</div>
                                                    '])->textArea(['maxlength' => true,'rows' => 2]) 
                                                ?>
                                            </div> 
                                            

                                            <div class="col-sm-12 col-xs-12">    
                                                <?= $form->field($data['model'], 'qc_notes', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                                                    <div class="col-sm-9 col-xs-12">{input}{error}{hint}</div>
                                                    '])->textArea(['maxlength' => true,'rows' => 4]) 
                                                ?>
                                            </div>    
                    				    </div>
                    			    </div>
                    		    </div>
                            </div>
                        </div>

                    <?php /* Receiving Inspection  */  ?>

                        <div class="tab-pane" id="tab_rece">
                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="box-header with-border">
                                      <h3 class="box-title">Receiving Inspection</h3>
                                    </div>
                                        <!-- /.box-header -->
                                    <div class="box-body arc-box">  

                                        <div class="col-sm-12 col-xs-12">    
                                            <?= $form->field($data['model'], 'is_document', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                                                <div class="col-sm-9 col-xs-12">{input}{error}{hint}</div>
                                                '])->checkbox()
                                            ?>
                                        </div>  

                                        <div class="col-sm-12 col-xs-12">    
                                            <?= $form->field($data['model'], 'is_tag', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                                                <div class="col-sm-9 col-xs-12">{input}{error}{hint}</div>
                                                '])->checkbox()
                                            ?>
                                        </div>  

                                        <div class="col-sm-12 col-xs-12">    
                                            <?= $form->field($data['model'], 'is_id', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                                                <div class="col-sm-9 col-xs-12">{input}{error}{hint}</div>
                                                '])->checkbox()
                                            ?>
                                        </div>  

                                        <div class="col-sm-12 col-xs-12">    
                                            <?= $form->field($data['model'], 'tag_type', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                                                <div class="col-sm-9 col-xs-12">{input}{error}{hint}</div>
                                                '])->dropDownList($dataIDType)
                                            ?>
                                        </div>  

                                        <div class="col-sm-12 col-xs-12">    
                                            <?= $form->field($data['model'], 'identify_from', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                                                <div class="col-sm-9 col-xs-12">{input}{error}{hint}</div>
                                                '])->dropDownList($dataIdentifyFrom)
                                            ?>
                                        </div>  

                                        <div class="col-sm-12 col-xs-12">    
                                            <?= $form->field($data['model'], 'part_no_1', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                                                <div class="col-sm-9 col-xs-12">{input}{error}{hint}</div>
                                                '])->textInput()
                                            ?>
                                        </div>  

                                        <div class="col-sm-12 col-xs-12">    
                                            <?= $form->field($data['model'], 'part_no_2', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                                                <div class="col-sm-9 col-xs-12">{input}{error}{hint}</div>
                                                '])->textInput()
                                            ?>
                                        </div>  

                                        <div class="col-sm-12 col-xs-12">    
                                            <?= $form->field($data['model'], 'part_no_3', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                                                <div class="col-sm-9 col-xs-12">{input}{error}{hint}</div>
                                                '])->textInput()
                                            ?>
                                        </div>  

                                        <div class="col-sm-12 col-xs-12">    
                                            <?= $form->field($data['model'], 'is_discrepancy', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                                                <div class="col-sm-9 col-xs-12">{input}{error}{hint}</div>
                                                '])->checkbox()
                                            ?>
                                        </div>    

                                        <div class="col-sm-12 col-xs-12">    
                                            <?= $form->field($data['model'], 'corrective', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                                                <div class="col-sm-9 col-xs-12">{input}{error}{hint}</div>
                                                '])->textArea(['rows' => 3])
                                            ?>
                                        </div>  

                                        <div class="col-sm-12 col-xs-12">    
                                            <?= $form->field($data['model'], 'remarks', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                                                <div class="col-sm-9 col-xs-12">{input}{error}{hint}</div>
                                                '])->textArea(['rows' => 3])
                                            ?>
                                        </div>  

                                    </div>  

                                </div>
                            </div>
                        </div>

                    <?php /* part */ ?>
                        <div class="tab-pane" id="tab_2">

                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="">
                                        <div class="box-header with-border">
                                          <h3 class="box-title">Part Details</h3>
                                        </div>
                                        <!-- /.box-header -->

                                        <div class="box-body">
                                        
                                        
                                            <div class="col-sm-12 col-xs-12">    
                                                <?= $form->field($data['model'], 'work_type', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                                                    <div class="col-sm-9 col-xs-12">{input}{error}{hint}</div>
                                                    '])->dropDownList($dataWorkType) 
                                                ?>
                                            </div>   
                                        

                                            <div class="col-sm-12 col-xs-12">    
                                                <?= $form->field($data['model'], 'part_no', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                                                    <div class="col-sm-9 col-xs-12">{input}{error}{hint}
                                                        <ul id="search-result" style="display: none;" class="dropdown-menu collapse">
                                                        </ul>
                                                    </div>
                                                    '])->dropDownList($dataPartNo,['class' => 'select2','prompt' => 'Please select'])
                                                ?>
                                            </div> 

                                            <?php if ( $data['isEdit'] ) { ?>
                                                <div class="col-sm-12 col-xs-12">    
                                                    <?= $form->field($data['model'], 'new_part_no', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                                                        <div class="col-sm-9 col-xs-12">{input}{error}{hint}
                                                            <ul id="search-result" style="display: none;" class="dropdown-menu collapse">
                                                            </ul>
                                                        </div>
                                                        '])->textInput(['maxlength' => true])
                                                    ?>
                                                </div>  
                                            <?php } ?>

                                            <div class="col-sm-12 col-xs-12">    
                                                <?= $form->field($data['model'], 'desc', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                                                    <div class="col-sm-9 col-xs-12">{input}{error}{hint}</div>
                                                    '])->textInput() 
                                                ?>
                                            </div>  
                                            

                                            <div class="col-sm-12 col-xs-12">    
                                                <?= $form->field($data['model'], 'manufacturer', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                                                    <div class="col-sm-9 col-xs-12">{input}{error}{hint}</div>
                                                    '])->textInput() 
                                                ?>
                                            </div>  

                                            <div class="col-sm-12 col-xs-12">    
                                                <?= $form->field($data['model'], 'model', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                                                    <div class="col-sm-9 col-xs-12">{input}{error}{hint}</div>
                                                    '])->textInput() 
                                                ?>
                                            </div>  

                                            <div class="col-sm-12 col-xs-12">    
                                                <?= $form->field($data['model'], 'ac_tail_no', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                                                    <div class="col-sm-9 col-xs-12">{input}{error}{hint}</div>
                                                    '])->textInput() 
                                                ?>
                                            </div>  

                                            <div class="col-sm-12 col-xs-12">    
                                                <?= $form->field($data['model'], 'ac_msn', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                                                    <div class="col-sm-9 col-xs-12">{input}{error}{hint}</div>
                                                    '])->textInput() 
                                                ?>
                                            </div>  

                                            <div class="col-sm-12 col-xs-12">    
                                                <?= $form->field($data['model'], 'serial_no', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                                                    <div class="col-sm-9 col-xs-12">{input}{error}{hint}</div>
                                                    '])->textInput() 
                                                ?>
                                            </div>  

                                            <div class="col-sm-12 col-xs-12">    
                                                <?= $form->field($data['model'], 'batch_no', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                                                    <div class="col-sm-9 col-xs-12">{input}{error}{hint}</div>
                                                    '])->textInput() 
                                                ?>
                                            </div>   
                                        

                                            <div class="col-sm-12 col-xs-12">    
                                                <?= $form->field($data['model'], 'location_id', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                                                    <div class="col-sm-9 col-xs-12">{input}{error}{hint}
                                                        <ul id="search-result" style="display: none;" class="dropdown-menu collapse">
                                                        </ul>
                                                    </div>
                                                    '])->dropDownList($dataLocation,['class' => 'select2','prompt' => 'Please select'])
                                                ?>
                                            </div> 

                                            <div class="col-sm-12 col-xs-12">   
                                                <div class="form-group field-workorder-batch_no">
                                                    <div class="col-sm-3 text-right">
                                                        <label class="control-label" for="workorder-batch_no">Template</label>
                                                    </div>
                                                    <div class="col-sm-9 col-xs-12">
                                                        <?php if ( $data['gotTemplate'] ) { ?>
                                                            <div class="yes-template">
                                                                Yes
                                                            <br>
                                                            <br>
                                                            </div>
                                                            <div class="no-template hidden">
                                                                Template not found
                                                            </div>

                                                        <?php } else { ?>
                                                            <div class="yes-template hidden">
                                                                Yes
                                                            <br>
                                                            <br>
                                                            </div>
                                                            <div class="no-template">
                                                                Template not found
                                                            </div>
                                                        <?php } ?>

                                                    </div>
                                                </div>
                                            </div>  


                                            <div class="col-sm-12 col-xs-12 hidden">    
                                                <?= $form->field($data['model'], 'template_id', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                                                    <div class="col-sm-9 col-xs-12">{input}{error}{hint}</div>
                                                    '])->dropDownList($dataTemplate)
                                                ?>
                                            </div>  

                                            <div class="col-sm-12 col-xs-12">    
                                                <?= $form->field($data['model'], 'quantity', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                                                    <div class="col-sm-9 col-xs-12">{input}{error}{hint}</div>
                                                    '])->textInput() 
                                                ?>
                                            </div>  
 

                                            <div class="col-sm-12 col-xs-12">    
                                                <?= $form->field($data['model'], 'pma_used', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                                                    <div class="col-sm-9 col-xs-12">{input}{error}{hint}</div>
                                                    '])->textArea() 
                                                ?>
                                            </div>  
                                                             
                                        </div>  

                                    </div>  
                                </div>  
                            </div>   

                        </div>

                    <?php   /* TRAVELER  */  ?>

                        <div class="tab-pane" id="tab_traver">
                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="box-header with-border">
                                      <h3 class="box-title">Worksheet</h3>
                                    </div>
                                        <!-- /.box-header -->
                                    <div class="box-body arc-box">  

                                        <div class="col-sm-12 col-xs-12">    
                                            <?= $form->field($data['model'], 'traveler_id', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                                                <div class="col-sm-9 col-xs-12">{input}{error}{hint}</div>
                                                '])->dropDownList($dataTraveler,['class' => 'select2 form-control'])
                                            ?>
                                        </div>  


                                        <div class="col-sm-12 col-xs-12">    
                                           <?= $form->field($data['woAttachment'], 'attachment[traveler][]', [
                                                  'template' => "<div class='col-sm-3 text-right'>{label}{hint}</div>\n<div class='col-sm-9 col-xs-12'>{input}{error}</div>\n\n"
                                                ])
                                                ->widget(FileInput::classname(), [
                                                'options' => ['accept' => 'image/*'],
                                            ])->fileInput(['multiple' => true,])->label('Upload Attachment(s)') ?>
                                        </div>  
                                    </div>  

                                </div>
                            </div>
                        </div>

                    <?php /* pre inspection */ ?>
                        <div class="tab-pane" id="tab_3">

                            <div class="row">
                                <div class="col-xs-12">

                                    <div class="">
                                        <div class="box-header with-border">
                                          <h3 class="box-title">Preliminary Inspection</h3>
                                        </div>
                                        <div class="box-body">

                                            

                                            <div class="col-sm-12 col-xs-12">    
                                                <?= $form->field($data['model'], 'preliminary_date', ['template' => '<div class="col-sm-3 text-right">{label}</div>
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
                                            <?php if ($data['isEdit']) { ?>
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
                                               <?= $form->field($data['woAttachment'], 'attachment[wo_pre][]', [
                                                      'template' => "<div class='col-sm-3 text-right'>{label}{hint}</div>\n<div class='col-sm-9 col-xs-12'>{input}{error}</div>\n\n"
                                                    ])
                                                    ->widget(FileInput::classname(), [
                                                    'options' => ['accept' => 'image/*'],
                                                ])->fileInput(['multiple' => true,])->label('Inspection Attachment(s)') ?>
                                            </div>   

                                            <div class="col-sm-12 col-xs-12">
                                            <?php if ( $data['isEdit'] ) { ?> 
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
                                                            <a href="<?= 'uploads/wo_pre/' .$at->value ?>" target="_blank"><?= $fileNameOnlyEx[1] ?></a>
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
                                            <?php } ?> 
                                            </div>   

                                            
                                            <div class="col-sm-12 col-xs-12">
                                               <?= $form->field($data['woAttachment'], 'attachment[wo_dis][]', [
                                                      'template' => "<div class='col-sm-3 text-right'>{label}{hint}</div>\n<div class='col-sm-9 col-xs-12'>{input}{error}</div>\n\n"
                                                    ])
                                                    ->widget(FileInput::classname(), [
                                                    'options' => ['accept' => 'image/*'],
                                                ])->fileInput(['multiple' => true,])->label('Disposition Attachment(s)') ?>
                                            </div>   

                                            <div class="col-sm-12 col-xs-12">
                                            <?php if ( $data['isEdit'] ) { ?> 
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
                                                            <a href="<?= 'uploads/wo_dis/' .$at->value ?>" target="_blank"><?= $fileNameOnlyEx[1] ?></a>
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
                                            <?php } ?> 
                                            </div>   
                                        </div>
                                    </div>
                                </div>  
                            </div>  

                        </div>

                    <?php /* hidden damage inspection */ ?>

                        <div class="tab-pane" id="tab_4">

                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="">
                                        <div class="box-header with-border">
                                          <h3 class="box-title">Hidden Damage Inspection</h3>
                                        </div>
                                        <!-- /.box-header -->

                                        <div class="box-body ">


                                            <div class="col-sm-12 col-xs-12">    
                                                <?= $form->field($data['model'], 'hidden_date', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                                                    <div class="col-sm-9 col-xs-12">{input}{error}{hint}</div>
                                                    '])->textInput(['id' => 'datepicker9','readonly' => true]) 
                                                ?>
                                            </div>  

                                            <div class="col-sm-12 text-right">

                                                <button type="button" class="btn btn-primary" onclick="addHiddenDiscrepancy()">Add Discrepancy</button>
                                                <br>
                                                <br>
                                            </div>
                                                
                                            <div class="extra-hdiscrepancy">
                                                <?php if ($data['isEdit']) { ?>
                                                    <?php foreach ($data['hiddenDamage'] as $hD) { ?>

                                                        <?php if (isset($hD->discrepancy)) { ?>
                                                            <div class="col-sm-12 col-xs-12">    
                                                                <div class="form-group field-workhiddendamage-discrepancy">
                                                                    <div class="col-sm-3 text-right">
                                                                        <label class="control-label" for="workhiddendamage-discrepancy">Discrepancy</label>
                                                                    </div>
                                                                    <div class="col-sm-9 col-xs-12">
                                                                        <textarea id="workhiddendamage-discrepancy" class="form-control" name="WorkHiddenDamage[discrepancy][]" rows="4"><?=$hD->discrepancy?></textarea>
                                                                        <div class="help-block">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div> 
                                                        <?php } ?>


                                                        <?php if (isset($hD->corrective)) { ?>
                                                            <div class="col-sm-12 col-xs-12">    
                                                                <div class="form-group field-workhiddendamage-corrective">
                                                                    <div class="col-sm-3 text-right">
                                                                        <label class="control-label" for="workhiddendamage-corrective">Corrective</label>
                                                                    </div>
                                                                    <div class="col-sm-9 col-xs-12">
                                                                        <textarea id="workhiddendamage-corrective" class="form-control" name="WorkHiddenDamage[corrective][]" rows="4"><?=$hD->corrective?></textarea>
                                                                        <div class="help-block">
                                                                        </div>
                                                                    </div>

                                                                </div>
                                                            </div>  
                                                        <?php } ?>
                                                    <?php } ?>
                                                <?php } ?>
                                                        <div class="col-sm-12 col-xs-12">    
                                                            <div class="form-group field-workhiddendamage-discrepancy">
                                                                <div class="col-sm-3 text-right">
                                                                    <label class="control-label" for="workhiddendamage-discrepancy">Discrepancy</label>
                                                                </div>
                                                                <div class="col-sm-9 col-xs-12">
                                                                    <textarea id="workhiddendamage-discrepancy" class="form-control" name="WorkHiddenDamage[discrepancy][]" rows="4"></textarea>
                                                                    <div class="help-block">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div> 


                                                        <div class="col-sm-12 col-xs-12">    
                                                            <div class="form-group field-workhiddendamage-corrective">
                                                                <div class="col-sm-3 text-right">
                                                                    <label class="control-label" for="workhiddendamage-corrective">Corrective</label>
                                                                </div>
                                                                <div class="col-sm-9 col-xs-12">
                                                                    <textarea id="workhiddendamage-corrective" class="form-control" name="WorkHiddenDamage[corrective][]" rows="4"></textarea>
                                                                    <div class="help-block">
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

                    <?php  /* Worker  */ ?>
                        <div class="tab-pane" id="tab_6">
                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="box-header with-border">
                                      <h3 class="box-title">Employee</h3>
                                    </div>
                                        <!-- /.box-header -->

                                    <?php  $n = 1;  ?>
                                    <?php if ( $data['isEdit'] ) {  ?>
                                        <?php /* is edit */ ?>

                                        <div class="box-body ">
                                                        
                                            <div class="col-sm-12 col-xs-12">    
                                                <div class="form-group field-workorderstaff-staff_name has-success">
                                                    <div class="col-sm-3 text-right">
                                                        <label class="control-label" for="workorderstaff-staff_name">Supervisor</label>
                                                    </div>
                                                    <div class="col-sm-9 col-xs-12">
                                                        <select id="workorderstaff-staff_name" class="form-control select2" name="WorkOrderStaff[staff_name][]">
                                                            <?php foreach ( $dataStaff  as $dsf) { ?>
                                                                <?php $data['supervisor']->staff_name == $dsf ? $selected = ' selected' : $selected = ''; ?>
                                                                <option value="<?= $dsf ?>" <?= $selected ?>><?= $dsf ?></option>
                                                            <?php } ?>
                                                        </select>
                                                        <div class="help-block"></div>
                                                    </div>
                                                </div>
                                                <div class="form-group field-workorderstaff-staff_type">
                                                    <input type="hidden" id="workorderstaff-staff_type" class="form-control" name="WorkOrderStaff[staff_type][]" value="supervisor">
                                                    <div class="help-block"></div>
                                                </div>
                                            </div> 
                                            
                                                        
                                            <div class="col-sm-12 col-xs-12">    
                                                <div class="form-group field-workorderstaff-staff_name has-success">
                                                    <div class="col-sm-3 text-right">
                                                        <label class="control-label" for="workorderstaff-staff_name">Final Inspector</label>
                                                    </div>
                                                    <div class="col-sm-9 col-xs-12">
                                                        <select id="workorderstaff-staff_name" class="form-control select2" name="WorkOrderStaff[staff_name][]">
                                                            <?php foreach ( $dataStaff  as $dsf) { ?>
                                                                <?php $data['finalInspector']->staff_name == $dsf ? $selected = ' selected' : $selected = ''; ?>
                                                                <option value="<?= $dsf ?>" <?= $selected ?>><?= $dsf ?></option>
                                                            <?php } ?>
                                                        </select>
                                                        <div class="help-block"></div>
                                                    </div>
                                                </div>
                                                <div class="form-group field-workorderstaff-staff_type">
                                                    <input type="hidden" id="workorderstaff-staff_type" class="form-control" name="WorkOrderStaff[staff_type][]" value="final inspector">
                                                    <div class="help-block"></div>
                                                </div>
                                            </div> 
                                        </div>  
                                        <div class="box-body technician-add">
                                            <div class="col-sm-12 text-right">
                                                <button type="button" class="btn btn-primary add-tech">Add Technician</button>
                                                <br>
                                                <br>
                                            </div>

                                            <?php foreach ( $data['technician'] as $key => $tecc) { ?>

                                                <div class="tec-<?= $n ?>">
                                                    <div class="col-sm-6 col-xs-12">    
                                                        <div class="form-group field-workorderstaff-staff_name">
                                                            <div class="col-sm-3 text-right">
                                                                <label class="control-label" for="workorderstaff-staff_name">Technician</label>
                                                            </div>
                                                            <div class="col-sm-9 col-xs-12">
                                                                <select id="workorderstaff-staff_name" class="form-control" name="WorkOrderStaff[staff_name][]">
                                                                    <?php foreach ( $dataStaff  as $dsf) { ?>
                                                                        <?php $tecc->staff_name == $dsf ? $selected = ' selected' : $selected = ''; ?>
                                                                        <option value="<?= $dsf ?>" <?= $selected ?>><?= $dsf ?></option>
                                                                    <?php } ?>
                                                                </select>
                                                                <div class="help-block"></div>  
                                                            </div>
                                                        </div>                                            
                                                        <div class="form-group field-workorderstaff-staff_type">
                                                            <input type="hidden" id="workorderstaff-staff_type" class="form-control" name="WorkOrderStaff[staff_type][]" value="technician">
                                                            <div class="help-block"></div>
                                                        </div>
                                                    </div>

                                                    <div class="col-sm-5 col-xs-12">    
                                                        <div class="form-group field-workorderstaff-staff_name">
                                                            <div class="col-sm-3 text-right">
                                                                <label class="control-label" for="workorderstaff-staff_name">Inspector</label>
                                                            </div>
                                                            <div class="col-sm-9 col-xs-12">
                                                                <select id="workorderstaff-staff_name" class="form-control" name="WorkOrderStaff[staff_name][]">
                                                                    <?php foreach ( $dataStaff  as $dsf) { ?>
                                                                        <?php $data['inspector'][$key]['staff_name'] == $dsf ? $selected = ' selected' : $selected = ''; ?>
                                                                        <option value="<?= $dsf ?>" <?= $selected ?>><?= $dsf ?></option>
                                                                    <?php } ?>
                                                                </select>
                                                                <div class="help-block"></div>
                                                            </div>
                                                        </div>                                            
                                                        <div class="form-group field-workorderstaff-staff_type">
                                                            <input type="hidden" id="workorderstaff-staff_type" class="form-control" name="WorkOrderStaff[staff_type][]" value="inspector">
                                                        <div class="help-block"></div>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-1">
                                                        <a href="javascript:unassignStaff(<?= $n ?>)">Unassign</a>
                                                    </div>
                                                </div>

                                                <?php $n ++ ; ?>
                                            <?php } /* foreach technician row */ ?> 
                                        </div>   

                                    <?php } else {  ?>
                                        
                                        <div class="box-body ">
                                            <div class="col-sm-12 col-xs-12">    
                                                <?= $form->field($data['staff'], 'staff_name[]', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                                                    <div class="col-sm-9 col-xs-12">{input}{error}{hint}</div>
                                                    '])->dropDownList($dataStaff,['class' => 'select2 form-control',])->label('Supervisor')
                                                ?>
                                                <?= $form->field($data['staff'], 'staff_type[]')->hiddenInput(['value' => 'supervisor'])->label(false) ?>
                                            </div>   
                                            <div class="col-sm-12 col-xs-12">    
                                                <?= $form->field($data['staff'], 'staff_name[]', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                                                    <div class="col-sm-9 col-xs-12">{input}{error}{hint}</div>
                                                    '])->dropDownList($dataStaff,['class' => 'select2 form-control',])->label('Final Inspector')
                                                ?>
                                                <?= $form->field($data['staff'], 'staff_type[]')->hiddenInput(['value' => 'final inspector'])->label(false) ?>
                                            </div>    
                                        </div>  
                                        <div class="box-body technician-add">
                                            <div class="col-sm-12 text-right">
                                                <button type="button" class="btn btn-primary add-tech">Add Technician and Inspector</button>
                                                <br>
                                                <br>
                                            </div>
                                            <div class="tec-<?=$n?>">
                                                <div class="col-sm-6 col-xs-12">    
                                                    <?= $form->field($data['staff'], 'staff_name[]', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                                                        <div class="col-sm-9 col-xs-12">{input}{error}{hint}</div>
                                                        '])->dropDownList($dataStaff,['class' => 'form-control',])->label('Technician')
                                                    ?>
                                                    <?= $form->field($data['staff'], 'staff_type[]')->hiddenInput(['value' => 'technician'])->label(false) ?>

                                                </div>   
                                                <div class="col-sm-5 col-xs-12">    
                                                    <?= $form->field($data['staff'], 'staff_name[]', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                                                        <div class="col-sm-9 col-xs-12">{input}{error}{hint}</div>
                                                        '])->dropDownList($dataStaff,['class' => 'form-control',])->label('Inspector')
                                                    ?>
                                                    <?= $form->field($data['staff'], 'staff_type[]')->hiddenInput(['value' => 'inspector'])->label(false) ?>
                                                </div> 
                                                <div class="col-sm-1">
                                                    <a href="javascript:unassignStaff(<?= $n ?>)">Unassign</a>
                                                </div>  
                                            </div>   
                                        </div> 

                                    <?php } /* if else edit */ ?>
                                    <input type="hidden" id="n" value="<?= $n ?>">

                                </div>
                            </div>
                        </div>

                    <?php   /* ARC  */  ?>

                        <div class="tab-pane" id="tab_7">
                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="box-header with-border">
                                      <h3 class="box-title">Create ARC</h3>
                                    </div>
                                        <!-- /.box-header -->
                                    <div class="box-body arc-box">
                                        <div class="col-sm-12 col-xs-12">    
                                            <?= $form->field($data['model'], 'arc_status', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                                                <div class="col-sm-9 col-xs-12">{input}{error}{hint}</div>
                                                '])->dropDownList($dataArcStatus) 
                                            ?>
                                        </div> 
                                        <div class="col-sm-12 col-xs-12">    
                                            <?= $form->field($data['model'], 'arc_remark', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                                                <div class="col-sm-9 col-xs-12">{input}{error}{hint}</div>
                                                '])->textArea(['maxlength' => true,'rows' => 8]) 
                                            ?>
                                        </div> 
                                    </div>  

                                </div>
                            </div>
                        </div>


                    <?php if ( $data['isEdit'] ) { ?> 
                        <?php   /* Final Inspection  */  ?>

                            <div class="tab-pane" id="tab_8">
                                <div class="row">
                                    <div class="col-xs-12">
                                        <div class="box-header with-border">
                                          <h3 class="box-title">Final Inspection</h3>
                                        </div>
                                            <!-- /.box-header -->
                                        <div class="box-body arc-box">
                                            <div class="col-sm-12 col-xs-12">    
                                                <?= $form->field($data['model'], 'final_inspection_date', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                                                    <div class="col-sm-9 col-xs-12">{input}{error}{hint}</div>
                                                    '])->textInput(['id' => 'datepicker6','readonly' => true]) 
                                                ?>
                                            </div> 

                                            <div class="col-sm-12 col-xs-12">
                                               <?= $form->field($data['woAttachment'], 'attachment[wo_final][]', [
                                                      'template' => "<div class='col-sm-3 text-right'>{label}{hint}</div>\n<div class='col-sm-9 col-xs-12'>{input}{error}</div>\n\n"
                                                    ])
                                                    ->widget(FileInput::classname(), [
                                                    'options' => ['accept' => 'image/*'],
                                                ])->fileInput(['multiple' => true,])->label('Upload Attachment(s)') ?>
                                            </div>      
                                            <div class="col-sm-12 col-xs-12">
                                                <?php if ( $data['isEdit'] ) { ?> 
                                                    <div class='col-sm-3 text-right'>
                                                        <label>Final Inspection Attachment</label>
                                                    </div>
                                                    <div class="col-sm-9 col-xs-12">
                                                    <?php if ( !empty ( $data['currFinalAtt'] ) ) { ?> 
                                                        <?php foreach ( $data['currFinalAtt'] as $at ) { 
                                                            $currentAttachmentClass = explode('\\', get_class($at))[2]; ?>
                                                            <?php 
                                                                $fileNameOnlyEx = explode('-', $at->value);
                                                            ?>
                                                            <div class="col-sm-3 col-xs-12">
                                                                <a href="<?= 'uploads/wo_final/' .$at->value ?>" target="_blank"><?= $fileNameOnlyEx[1] ?></a> 
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
                                                <?php } ?>
                                            </div>
                                        </div>  

                                    </div>


                                </div>
                            </div>

                    <?php } ?>  
                </div>
    	    </div>
        <?php ActiveForm::end(); ?>
    </section>
</div>
