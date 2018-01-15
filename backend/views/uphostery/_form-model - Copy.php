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
use common\models\Traveler;
use common\models\Setting;
/* @var $this yii\web\View */
/* @var $data['model'] common\models\Uphostery */
/* @var $form yii\widgets\ActiveForm */
$dataCustomer = Customer::dataCustomer();
$dataStaff = Staff::dataStaff();
$dataStaffTechnician = Staff::dataStaffTechnician();
$dataCurrency = Currency::dataCurrency();
$dataPart = Part::dataPart();
$dataTemplate = Template::dataTemplate();
$dataUphosteryType = Setting::dataUphosteryType();
$dataUphosteryScope = Setting::dataUphosteryScope();
$dataPartNo = Capability::dataPartNo();
$dataTraveler = Traveler::dataTraveler();

/*plugins*/
use kartik\file\FileInput;
?>

<div class="uphostery-order-form">
	<section class="content">
        <?php $form = ActiveForm::begin(); ?>

            <div class="form-group text-right">
                <?= Html::submitButton('<i class="fa fa-save"></i> Save', ['class' => 'btn btn-primary']) ?>
                <?= Html::a( 'Cancel', Url::to(['index']), array('class' => 'btn btn-default')) ?>
                &nbsp;
            </div>

            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                  <li class="active"><a href="#tab_1" data-toggle="tab">Uphostery Details</a></li>
                  <li><a href="#tab_2" data-toggle="tab">Part</a></li>
                  <li><a href="#tab_3" data-toggle="tab">Preliminary Inspection</a></li>
                  <li><a href="#tab_4" data-toggle="tab">Hidden Damage Inspection</a></li>
                  <li><a href="#tab_6" data-toggle="tab">Uphosteryer</a></li>
                  <li><a href="#tab_7" data-toggle="tab">ARC</a></li>
                </ul>
                <div class="tab-content">
                    <?php /* uphostery order detail*/ ?>
                        <div class="tab-pane" id="tab_1">
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
                                                <?= $form->field($data['model'], 'uphostery_scope', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                                                    <div class="col-sm-9 col-xs-12">{input}{error}{hint}</div>
                                                    '])->dropDownList($dataUphosteryScope) 
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
                      
                                            <?php $data['model']->status = 'pending'; ?>
                                            <div class="col-sm-12 col-xs-12">    
                                                <?= $form->field($data['model'], 'status', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                                                    <div class="col-sm-9 col-xs-12">{input}{error}{hint}</div>
                                                    '])->dropDownList(['pending' => 'Pending', 'closed' => 'Closed', ], ['class' => 'select2 form-control','prompt' => '']) 
                                                ?>

                                            </div>   
                                            
                                            <div class="col-sm-12 col-xs-12">
                                               <?= $form->field($data['upAttachment'], 'attachment[]', [
                                                      'template' => "<div class='col-sm-3 text-right'>{label}{hint}</div>\n<div class='col-sm-9 col-xs-12'>{input}{error}</div>\n\n"
                                                    ])
                                                    ->widget(FileInput::classname(), [
                                                    'options' => ['accept' => 'image/*'],
                                                ])->fileInput(['multiple' => true,])->label('Upload Attachment(s)') ?>
                                            </div>      
                                            <?php if ( $data['isEdit'] ) { ?> 
                                                <div class='col-sm-3 text-right'>
                                                    <label>Uphostery Attachment</label>
                                                </div>
                                                <div class="col-sm-9 col-xs-12">
                                                <?php if ( !empty ( $data['currWoAtt'] ) ) { ?> 
                                                    <?php foreach ( $data['currWoAtt'] as $at ) { 
                                                        $currentAttachmentClass = explode('\\', get_class($at))[2]; ?>
                                                        <?php 
                                                            $fileNameOnlyEx = explode('-', $at->value);

                                                        ?>
                                                        <div class="col-sm-3 col-xs-12">
                                                            <a href="<?= 'uploads/up/' .$at->value ?>" target="_blank"><?= $fileNameOnlyEx[1] ?></a> 
                                                            <?= Html::a(' <i class="fa fa-close"></i> ', ['uphostery-order/remove-upa', 'id' => $at->id], [
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
                                                <?= $form->field($data['model'], 'uphostery_type', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                                                    <div class="col-sm-9 col-xs-12">{input}{error}{hint}</div>
                                                    '])->dropDownList($dataUphosteryType) 
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
                                                <?= $form->field($data['model'], 'model', ['template' => '<div class="col-sm-3 text-right">{label}</div>
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
                                                <div class="form-group field-uphosteryorder-batch_no">
                                                    <div class="col-sm-3 text-right">
                                                        <label class="control-label" for="uphosteryorder-batch_no">Template</label>
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
                                                <?= $form->field($data['model'], 'traveler_id', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                                                    <div class="col-sm-9 col-xs-12">{input}{error}{hint}</div>
                                                    '])->dropDownList($dataTraveler,['class' => 'select2 form-control'])
                                                ?>
                                            </div>  
                                                             
                                        </div>  

                                    </div>  
                                </div>  
                            </div>   

                        </div>

                    <?php /* pre inspection */ ?>
                        <div class="tab-pane active" id="tab_3">

                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="">
                                        <div class="box-header with-border">
                                          <h3 class="box-title">Preliminary Inspection</h3>
                                        </div>
                                        <!-- /.box-header -->

                                        <div class="box-body ">
                                            

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
                                            
                                            <div class="col-sm-12 col-xs-12">
                                               <?= $form->field($data['preAttachment'], 'attachment[]', [
                                                      'template' => "<div class='col-sm-3 text-right'>{label}{hint}</div>\n<div class='col-sm-9 col-xs-12'>{input}{error}</div>\n\n"
                                                    ])
                                                    ->widget(FileInput::classname(), [
                                                    'options' => ['accept' => 'image/*'],
                                                ])->fileInput(['multiple' => true,])->label('Inspection Attachment(s)') ?>
                                            </div>   

                                            <div class="col-sm-12 col-xs-12">
                                            <?php if ( $data['isEdit'] ) { ?> 
                                                <div class='col-sm-3 text-right'>
                                                    <label>Inspection Attachment(s)</label>
                                                </div>
                                               
                                                <div class="col-sm-9 col-xs-12">
                                                <?php if ( !empty ( $data['currPreAtt'] ) ) { ?> 
                                                    <?php foreach ( $data['currPreAtt'] as $at ) { 
                                                        $currentAttachmentClass = explode('\\', get_class($at))[2]; ?>
                                                        <?php 
                                                            $fileNameOnlyEx = explode('-', $at->value);

                                                        ?>
                                                        <div class="col-sm-3 col-xs-12">
                                                            <a href="<?= 'uploads/up_pre/' .$at->value ?>" target="_blank"><?= $fileNameOnlyEx[1] ?></a>
                                                             <?= Html::a(' <i class="fa fa-close"></i> ', ['uphostery-order/remove-uppa', 'id' => $at->id], [
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
                                               <?= $form->field($data['disAttachment'], 'attachment[]', [
                                                      'template' => "<div class='col-sm-3 text-right'>{label}{hint}</div>\n<div class='col-sm-9 col-xs-12'>{input}{error}</div>\n\n"
                                                    ])
                                                    ->widget(FileInput::classname(), [
                                                    'options' => ['accept' => 'image/*'],
                                                ])->fileInput(['multiple' => true,])->label('Disposition Attachment(s)') ?>
                                            </div>   

                                            <div class="col-sm-12 col-xs-12">
                                            <?php if ( $data['isEdit'] ) { ?> 
                                                <div class='col-sm-3 text-right'>
                                                    <label>Disposition Attachment(s)</label>
                                                </div>
                                               
                                                <div class="col-sm-9 col-xs-12">
                                                <?php if ( !empty ( $data['currDisAtt'] ) ) { ?> 
                                                    <?php foreach ( $data['currDisAtt'] as $at ) { 
                                                        $currentAttachmentClass = explode('\\', get_class($at))[2]; ?>
                                                        <?php 
                                                            $fileNameOnlyEx = explode('-', $at->value);

                                                        ?>
                                                        <div class="col-sm-3 col-xs-12">
                                                            <a href="<?= 'uploads/up_dis/' .$at->value ?>" target="_blank"><?= $fileNameOnlyEx[1] ?></a>
                                                             <?= Html::a(' <i class="fa fa-close"></i> ', ['uphostery-order/remove-upda', 'id' => $at->id], [
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
                                    <div class="box box-warning">
                                        <div class="box-body">
                                            <div class="col-sm-12">
                                                <div class="box-header with-border">
                                                  <h3 class="box-title">Discrepancy and Corrective Action</h3>
                                                </div>
                                            </div>
                                            <div class="col-sm-12 text-right">
                                                <button type="button" class="btn btn-primary" onclick="addDiscrepancy()">Add Discrepancy</button>
                                                <br>
                                                <br>
                                            </div>
                                            <div class="extra-discrepancy">
                                            <?php if ( count($data['uphosteryPreliminary']) > 0 ) { ?>
                                                <?php foreach ($data['uphosteryPreliminary'] as $uphosteryPreliminary) { ?>
                                                    <div class="col-sm-12 col-xs-12">    
                                                        <?= $form->field($data['uphosteryPreliminary'], 'discrepancy[]', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                                                            <div class="col-sm-9 col-xs-12">{input}{error}{hint}</div>
                                                            '])->textArea(['maxlength' => true,'rows' => 4,]) 
                                                        ?>
                                                    </div>    
                                                    <div class="col-sm-12 col-xs-12">    
                                                        <?= $form->field($data['uphosteryPreliminary'], 'corrective[]', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                                                            <div class="col-sm-9 col-xs-12">{input}{error}{hint}</div>
                                                            '])->textArea(['maxlength' => true,'rows' => 4]) 
                                                        ?>
                                                    </div>   
                                                <?php } ?>
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
                                                <?= $form->field($data['hiddenDamage'], 'discrepancy[]', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                                                    <div class="col-sm-9 col-xs-12">{input}{error}{hint}</div>
                                                    '])->textArea(['maxlength' => true,'rows' => 8]) 
                                                ?>

                                            </div> 
                                            
                                            <div class="col-sm-12 col-xs-12">    
                                                <?= $form->field($data['hiddenDamage'], 'corrective[]', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                                                    <div class="col-sm-9 col-xs-12">{input}{error}{hint}</div>
                                                    '])->textArea(['maxlength' => true,'rows' => 8]) 
                                                ?>

                                            </div>  
                                            
                                            <div class="col-sm-12 col-xs-12">    
                                                <?= $form->field($data['hiddenDamage'], 'repair_supervisor[]', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                                                    <div class="col-sm-9 col-xs-12">{input}{error}{hint}</div>
                                                    '])->dropDownList($dataStaff,['class' => 'form-control select2']) 
                                                ?>

                                            </div>


                                            <div class="col-sm-12 border-top">

                                                <div class="box-header with-border">
                                                  <h3 class="box-title">Additional Hidden Damage Inspection and Evaluation</h3>
                                                </div>
                                            </div>

                                            <div class="col-sm-12 text-right">

                                                <button type="button" class="btn btn-primary" onclick="addHiddenDiscrepancy()">Add Discrepancy</button>
                                                <br>
                                                <br>
                                            </div>
                                                
                                            <div class="extra-hdiscrepancy">
                                            </div>   
    
                                        </div>  
                                    </div>  
                                </div>  
                            </div>  

                        </div>

                    <?php  /* Uphosteryer  */ ?>
                        <div class="tab-pane" id="tab_6">
                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="box-header with-border">
                                      <h3 class="box-title">Uphosteryer</h3>
                                    </div>
                                        <!-- /.box-header -->

                                    <?php if ( ! $data['isEdit'] ) {  ?>
                                    <div class="box-body ">
                                                    
                                        
                                        <div class="col-sm-12 col-xs-12">    
                                            <?= $form->field($data['staff'], 'staff_name[]', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                                                <div class="col-sm-9 col-xs-12">{input}{error}{hint}</div>
                                                '])->dropDownList($dataStaff,['class' => 'select2 form-control',])->label('Supervisor')
                                            ?>
                                            <?= $form->field($data['staff'], 'staff_group_id[]')->hiddenInput(['value' => '3'])->label(false) ?>

                                        </div>   
                                        
                                        <div class="col-sm-12 col-xs-12">    
                                            <?= $form->field($data['staff'], 'staff_name[]', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                                                <div class="col-sm-9 col-xs-12">{input}{error}{hint}</div>
                                                '])->dropDownList($dataStaff,['class' => 'select2 form-control',])->label('Inspector')
                                            ?>
                                            <?= $form->field($data['staff'], 'staff_group_id[]')->hiddenInput(['value' => '4'])->label(false) ?>

                                        </div>    
                                    </div>  

                                    <div class="box-body technician-add">
                                        <div class="col-sm-12 text-right">
                                            <button type="button" class="btn btn-primary add-tech">Add Technician</button>
                                            <br>
                                            <br>
                                        </div>
                                        <div class="col-sm-12 col-xs-12">    
                                            <?= $form->field($data['staff'], 'staff_name[]', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                                                <div class="col-sm-9 col-xs-12">{input}{error}{hint}</div>
                                                '])->dropDownList($dataStaffTechnician,['class' => 'form-control',])->label('Technician')
                                            ?>
                                            <?= $form->field($data['staff'], 'staff_group_id[]')->hiddenInput(['value' => '5'])->label(false) ?>

                                        </div>   

                                    </div>  
                                    <?php } else {  ?>

                                    <div class="box-body ">
                                                    
                                        <div class="col-sm-12 col-xs-12">    
                                            <div class="form-group field-uphosteryorderstaff-staff_name has-success">
                                                <div class="col-sm-3 text-right">
                                                    <label class="control-label" for="uphosteryorderstaff-staff_name">Supervisor</label>
                                                </div>
                                                <div class="col-sm-9 col-xs-12">
                                                    <select id="uphosteryorderstaff-staff_name" class="form-control select2" name="UphosteryStaff[staff_name][]">
                                                        <?php foreach ( $dataStaff  as $dsf) { ?>
                                                            <?php $data['supervisor']->staff_name == $dsf ? $selected = ' selected' : $selected = ''; ?>
                                                            <option value="<?= $dsf ?>" <?= $selected ?>><?= $dsf ?></option>
                                                        <?php } ?>
                                                    </select>
                                                    <div class="help-block"></div>
                                                </div>
                                            </div>
                                            <div class="form-group field-uphosteryorderstaff-staff_group_id">
                                                <input type="hidden" id="uphosteryorderstaff-staff_group_id" class="form-control" name="UphosteryStaff[staff_group_id][]" value="3">
                                                <div class="help-block"></div>
                                            </div>
                                        </div> 
                                        
                                                    
                                        <div class="col-sm-12 col-xs-12">    
                                            <div class="form-group field-uphosteryorderstaff-staff_name has-success">
                                                <div class="col-sm-3 text-right">
                                                    <label class="control-label" for="uphosteryorderstaff-staff_name">Inspector</label>
                                                </div>
                                                <div class="col-sm-9 col-xs-12">
                                                    <select id="uphosteryorderstaff-staff_name" class="form-control select2" name="UphosteryStaff[staff_name][]">
                                                        <?php foreach ( $dataStaff  as $dsf) { ?>
                                                            <?php $data['inspector']->staff_name == $dsf ? $selected = ' selected' : $selected = ''; ?>
                                                            <option value="<?= $dsf ?>" <?= $selected ?>><?= $dsf ?></option>
                                                        <?php } ?>
                                                    </select>
                                                    <div class="help-block"></div>
                                                </div>
                                            </div>
                                            <div class="form-group field-uphosteryorderstaff-staff_group_id">
                                                <input type="hidden" id="uphosteryorderstaff-staff_group_id" class="form-control" name="UphosteryStaff[staff_group_id][]" value="4">
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

                                      
                                        <?php foreach ( $data['technician']  as $tecc) { ?>
                                                  
                                        <div class="col-sm-12 col-xs-12 tec-<?= $tecc->id ?>">    
                                            <div class="form-group field-uphosteryorderstaff-staff_name has-success">
                                                <div class="col-sm-3 text-right">
                                                    <label class="control-label" for="uphosteryorderstaff-staff_name">Technician</label>
                                                </div>
                                                <div class="col-sm-8 col-xs-12">
                                                    <select id="uphosteryorderstaff-staff_name" class="form-control select2" name="UphosteryStaff[staff_name][]">
                                                        <?php foreach ( $dataStaff  as $dsf) { ?>
                                                            <?php $tecc->staff_name == $dsf ? $selected = ' selected' : $selected = ''; ?>
                                                            <option value="<?= $dsf ?>" <?= $selected ?>><?= $dsf ?></option>
                                                        <?php } ?>
                                                    </select>
                                                    <div class="help-block"></div>
                                                </div>
                                                <div class="col-sm-1">
                                                    <a href="javascript:unassignStaff(<?= $tecc->id ?>)">Unassign</a>
                                                </div>
                                            </div>
                                            <div class="form-group field-uphosteryorderstaff-staff_group_id">
                                                <input type="hidden" id="uphosteryorderstaff-staff_group_id" class="form-control" name="UphosteryStaff[staff_group_id][]" value="5">
                                                <div class="help-block"></div>
                                            </div>
                                        </div> 

                                        <?php } ?> 
                                    </div>  
                                    <?php } /* if else edit */ ?>


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
                                            <?= $form->field($data['model'], 'arc_remark', ['template' => '<div class="col-sm-3 text-right">{label}</div>
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
