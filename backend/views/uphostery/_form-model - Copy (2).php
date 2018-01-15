<?php
$session = Yii::$app->session;
d($session->get('receiving_inspection'));
d($session->get('uphosterysheet'));
d($session->get('preliminary'));

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

                </ul>
                <div class="tab-content">
                    
                    <?php /* Uphostery order detail*/ ?>
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
                                                <?= $form->field($data['model'], 'uphostery_type', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                                                    <div class="col-sm-9 col-xs-12">{input}{error}{hint}</div>
                                                    '])->dropDownList($dataUphosteryType) 
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
                                                <?= $form->field($data['model'], 'status', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                                                    <div class="col-sm-9 col-xs-12">{input}{error}{hint}</div>
                                                    '])->dropDownList($dataUphosteryStatus, ['class' => 'select2 form-control']) 
                                                ?>
                                            </div>   
                                            
       
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
                                               <?= $form->field($data['upAttachment'], 'attachment[uphostery][]', [
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
                                                        <div class="col-sm-5 col-xs-12">
                                                            <a href="<?= 'uploads/uphostery/' .$at->value ?>" target="_blank"><?= $fileNameOnlyEx[1] ?></a> 
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

                    <?php /* Part */ ?>
                        <div class="tab-pane active" id="tab_2">

                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="">
                                        <div class="box-header with-border">
                                          <h3 class="box-title">Part Details</h3>
                                        </div>
                                        <!-- /.box-header -->

                                        <div class="box-body">

                                            <div class="col-sm-12 col-xs-12">    
                                                <?php /* $form->field($data['model'], 'part_no', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                                                    <div class="col-sm-9 col-xs-12">{input}{error}{hint}</div>
                                                    '])->dropDownList($dataPartNo,['class' => 'select2','prompt' => 'Please select']) */
                                                ?>
                                                <?= $form->field($data['uphosteryPart'], 'part_no', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                                                    <div class="col-sm-9 col-xs-12">{input}{error}{hint}
                                                        <ul id="search-result" style="display: none;" class="dropdown-menu collapse">
                                                        </ul>
                                                    </div>
                                                    '])->textInput(['maxlength' => true,'autocomplete' => 'off'])
                                                ?>
                                            </div> 

                                            <?php if ( $data['isEdit'] ) { ?>
                                                <div class="col-sm-12 col-xs-12">    
                                                    <?= $form->field($data['uphosteryPart'], 'new_part_no', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                                                        <div class="col-sm-9 col-xs-12">{input}{error}{hint}
                                                            <ul id="search-result" style="display: none;" class="dropdown-menu collapse">
                                                            </ul>
                                                        </div>
                                                        '])->textInput(['maxlength' => true])
                                                    ?>
                                                </div>  
                                            <?php } ?>

                                            <div class="col-sm-12 col-xs-12">    
                                                <?= $form->field($data['uphosteryPart'], 'desc', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                                                    <div class="col-sm-9 col-xs-12">{input}{error}{hint}</div>
                                                    '])->textInput() 
                                                ?>
                                            </div>  
                                            

                                            <div class="col-sm-12 col-xs-12">    
                                                <?= $form->field($data['uphosteryPart'], 'manufacturer', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                                                    <div class="col-sm-9 col-xs-12">{input}{error}{hint}</div>
                                                    '])->textInput() 
                                                ?>
                                            </div>  

                                            <div class="col-sm-12 col-xs-12">    
                                                <?= $form->field($data['uphosteryPart'], 'model', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                                                    <div class="col-sm-9 col-xs-12">{input}{error}{hint}</div>
                                                    '])->textInput() 
                                                ?>
                                            </div>  

                                            <div class="col-sm-12 col-xs-12">    
                                                <?= $form->field($data['uphosteryPart'], 'ac_tail_no', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                                                    <div class="col-sm-9 col-xs-12">{input}{error}{hint}</div>
                                                    '])->textInput() 
                                                ?>
                                            </div>  

                                            <div class="col-sm-12 col-xs-12">    
                                                <?= $form->field($data['uphosteryPart'], 'ac_msn', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                                                    <div class="col-sm-9 col-xs-12">{input}{error}{hint}</div>
                                                    '])->textInput() 
                                                ?>
                                            </div>  

                                            <div class="col-sm-12 col-xs-12">    
                                                <?= $form->field($data['uphosteryPart'], 'serial_no', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                                                    <div class="col-sm-9 col-xs-12">{input}{error}{hint}</div>
                                                    '])->textInput() 
                                                ?>
                                            </div>  

                                            <div class="col-sm-12 col-xs-12">    
                                                <?= $form->field($data['uphosteryPart'], 'batch_no', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                                                    <div class="col-sm-9 col-xs-12">{input}{error}{hint}</div>
                                                    '])->textInput() 
                                                ?>
                                            </div>   
                                        

                                            <div class="col-sm-12 col-xs-12">    
                                                <?= $form->field($data['uphosteryPart'], 'location_id', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                                                    <div class="col-sm-9 col-xs-12">{input}{error}{hint}
                                                        <ul id="search-result" style="display: none;" class="dropdown-menu collapse">
                                                        </ul>
                                                    </div>
                                                    '])->dropDownList($dataLocation,['class' => 'select2','prompt' => 'Please select'])
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
                                                <?= $form->field($data['uphosteryPart'], 'template_id', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                                                    <div class="col-sm-9 col-xs-12">{input}{error}{hint}</div>
                                                    '])->dropDownList($dataTemplate)
                                                ?>
                                            </div>  

                                            <div class="col-sm-12 col-xs-12">    
                                                <?= $form->field($data['uphosteryPart'], 'quantity', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                                                    <div class="col-sm-9 col-xs-12">{input}{error}{hint}</div>
                                                    '])->textInput() 
                                                ?>
                                            </div>  
                                                             
                                        </div>  

                                    </div>  
                                </div>  
                            </div>   

                        </div>

                        <button onclick="addPart();" class="btn btn-success">Add Part</button>

                        <div class="row part-added">
                            <div class="col-xs-12">
                                <div class="">
                                    <div class="box-header with-border">
                                      <h3 class="box-title">Parts Added</h3>
                                    </div>
                                    <!-- /.box-header -->

                                    <div class="box-body">
                                       <table class="table table-striped table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>Part No</th>
                                                    <th>Model</th>
                                                    <th>Quantity</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <?php /* modal form - receiving inspection */ ?>
                            <div id="receivingModal" class="modal fade uphosteryModal" role="dialog">
                              <div class="modal-dialog"   style="width: 80%;">

                                <!-- Modal content-->
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title">Receiving Inspection</h4>
                                  </div>
                                  <div class="modal-body">
                                    <div class="tab-pane" id="tab_rece">
                                        <div class="row">
                                            <div class="col-xs-12">
                                                    <!-- /.box-header -->
                                                <div class="box-body arc-box">  

                                                    <div class="col-sm-12 col-xs-12">    
                                                        <?= $form->field($data['uphosteryPart'], 'is_document', ['template' => '<div class="col-sm-5 text-right">{label}</div>
                                                            <div class="col-sm-7 col-xs-12">{input}{error}{hint}</div>
                                                            '])->checkbox()
                                                        ?>
                                                    </div>  

                                                    <div class="col-sm-12 col-xs-12">    
                                                        <?= $form->field($data['uphosteryPart'], 'is_tag', ['template' => '<div class="col-sm-5 text-right">{label}</div>
                                                            <div class="col-sm-7 col-xs-12">{input}{error}{hint}</div>
                                                            '])->checkbox()
                                                        ?>
                                                    </div>  

                                                    <div class="col-sm-12 col-xs-12">    
                                                        <?= $form->field($data['uphosteryPart'], 'is_id', ['template' => '<div class="col-sm-5 text-right">{label}</div>
                                                            <div class="col-sm-7 col-xs-12">{input}{error}{hint}</div>
                                                            '])->checkbox()
                                                        ?>
                                                    </div>  

                                                    <div class="col-sm-12 col-xs-12">    
                                                        <?= $form->field($data['uphosteryPart'], 'tag_type', ['template' => '<div class="col-sm-5 text-right">{label}</div>
                                                            <div class="col-sm-7 col-xs-12">{input}{error}{hint}</div>
                                                            '])->dropDownList($dataIDType)
                                                        ?>
                                                    </div>  

                                                    <div class="col-sm-12 col-xs-12">    
                                                        <?= $form->field($data['uphosteryPart'], 'identify_from', ['template' => '<div class="col-sm-5 text-right">{label}</div>
                                                            <div class="col-sm-7 col-xs-12">{input}{error}{hint}</div>
                                                            '])->dropDownList($dataIdentifyFrom)
                                                        ?>
                                                    </div>  

                                                    <div class="col-sm-12 col-xs-12">    
                                                        <?= $form->field($data['uphosteryPart'], 'part_no_1', ['template' => '<div class="col-sm-5 text-right">{label}</div>
                                                            <div class="col-sm-7 col-xs-12">{input}{error}{hint}</div>
                                                            '])->textInput()
                                                        ?>
                                                    </div>  

                                                    <div class="col-sm-12 col-xs-12">    
                                                        <?= $form->field($data['uphosteryPart'], 'part_no_2', ['template' => '<div class="col-sm-5 text-right">{label}</div>
                                                            <div class="col-sm-7 col-xs-12">{input}{error}{hint}</div>
                                                            '])->textInput()
                                                        ?>
                                                    </div>  

                                                    <div class="col-sm-12 col-xs-12">    
                                                        <?= $form->field($data['uphosteryPart'], 'part_no_3', ['template' => '<div class="col-sm-5 text-right">{label}</div>
                                                            <div class="col-sm-7 col-xs-12">{input}{error}{hint}</div>
                                                            '])->textInput()
                                                        ?>
                                                    </div>  

                                                    <div class="col-sm-12 col-xs-12">    
                                                        <?= $form->field($data['uphosteryPart'], 'is_discrepancy', ['template' => '<div class="col-sm-5 text-right">{label}</div>
                                                            <div class="col-sm-7 col-xs-12">{input}{error}{hint}</div>
                                                            '])->checkbox()
                                                        ?>
                                                    </div>    

                                                    <div class="col-sm-12 col-xs-12">    
                                                        <?= $form->field($data['uphosteryPart'], 'corrective', ['template' => '<div class="col-sm-5 text-right">{label}</div>
                                                            <div class="col-sm-7 col-xs-12">{input}{error}{hint}</div>
                                                            '])->textArea(['rows' => 3])
                                                        ?>
                                                    </div>  

                                                    <div class="col-sm-12 col-xs-12">    
                                                        <?= $form->field($data['uphosteryPart'], 'remarks', ['template' => '<div class="col-sm-5 text-right">{label}</div>
                                                            <div class="col-sm-7 col-xs-12">{input}{error}{hint}</div>
                                                            '])->textArea(['rows' => 3])
                                                        ?>
                                                    </div>  
                                                    <input type="text" class="partTemp">
                                                </div>  

                                            </div>
                                        </div>
                                    </div>
                                  </div>
                                  <div class="modal-footer">
                                        <button type="button" class="btn btn-primary" onclick="addReceivingInspection()">Save</button>
                                        <button type="button" class="btn btn-default close-modal" data-dismiss="modal">Close</button>
                                  </div>
                                </div>

                              </div>
                            </div>

                        <?php /* modal form - uphosterysheet */ ?>
                            <div id="uphosterysheetModal" class="modal fade uphosteryModal" role="dialog">
                              <div class="modal-dialog"   style="width: 80%;">

                                <!-- Modal content-->
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title">Uphosterysheet</h4>
                                  </div>
                                  <div class="modal-body">
                                    <div class="tab-pane" id="tab_rece">
                                        <div class="row">
                                            <div class="col-xs-12">
                                                    <!-- /.box-header -->
                                                <div class="box-body arc-box">  

                                                    <div class="tab-pane" id="tab_traver">
                                                        <div class="row">
                                                            <div class="col-xs-12">
                                                                    <!-- /.box-header -->
                                                                <div class="box-body arc-box">  

                                                                    <div class="col-sm-12 col-xs-12">    
                                                                        <?= $form->field($data['uphosteryPart'], 'traveler_id', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                                                                            <div class="col-sm-9 col-xs-12">{input}{error}{hint}</div>
                                                                            '])->dropDownList($dataTraveler,['class' => 'select2 form-control'])
                                                                        ?>
                                                                    </div>  


                                                                    <div class="col-sm-12 col-xs-12">    
                                                                       <?php /* $form->field($data['upAttachment'], 'attachment[traveler][]', [
                                                                              'template' => "<div class='col-sm-3 text-right'>{label}{hint}</div>\n<div class='col-sm-9 col-xs-12'>{input}{error}</div>\n\n"
                                                                            ])
                                                                            ->widget(FileInput::classname(), [
                                                                            'options' => ['accept' => 'image/*'],
                                                                        ])->fileInput(['multiple' => true,])->label('Upload Attachment(s)')*/ ?>
                                                                    </div>  
                                                                </div>  

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <input type="text" class="partTemp">
                                                </div>  

                                            </div>
                                        </div>
                                    </div>
                                  </div>
                                  <div class="modal-footer">
                                        <button type="button" class="btn btn-primary" onclick="addUphosterysheet()">Save</button>
                                        <button type="button" class="btn btn-default close-modal" data-dismiss="modal">Close</button>
                                  </div>
                                </div>

                              </div>
                            </div>    
                       
                        <?php /* modal form - preliminary */ ?>
                            <div id="preliminaryModal" class="modal fade uphosteryModal" role="dialog">
                              <div class="modal-dialog"   style="width: 80%;">

                                <!-- Modal content-->
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title">Preliminary Inspection</h4>
                                  </div>
                                  <div class="modal-body">
                                    <div class="tab-pane" id="tab_rece">
                                        <div class="row">
                                            <div class="col-xs-12">
                                                    <!-- /.box-header -->
                                                <div class="box-body arc-box">  
                                                    <div class="tab-pane" id="tab_3">

                                                        <div class="row">
                                                            <div class="col-xs-12">
                                                                <div class="">
                                                                    <div class="box-body">
                                                                        <div class="col-sm-12 col-xs-12">    
                                                                            <?= $form->field($data['uphosteryPart'], 'repair_supervisor', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                                                                                <div class="col-sm-9 col-xs-12">{input}{error}{hint}</div>
                                                                                '])->textInput() 
                                                                            ?>
                                                                        </div>  
                                                                        
                                                                        <div class="col-sm-12 col-xs-12">    
                                                                            <?= $form->field($data['uphosteryPart'], 'preliminary_date', ['template' => '<div class="col-sm-3 text-right">{label}</div>
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
                                                                                <?php if ( $data['uphosteryPreliminary'] ) { ?>
                                                                                    <?php foreach ($data['uphosteryPreliminary'] as $uphosteryPreliminary) { ?>
                                                                                        <?php if (isset($uphosteryPreliminary->discrepancy)) { ?>
                                                                                            <div class="col-sm-12 col-xs-12">    
                                                                                                <div class="form-group field-uphosterypreliminary-discrepancy">
                                                                                                    <div class="col-sm-3 text-right">
                                                                                                        <label class="control-label" for="uphosterypreliminary-discrepancy">Discrepancy</label>
                                                                                                    </div>
                                                                                                    <div class="col-sm-9 col-xs-12">
                                                                                                        <textarea id="uphosterypreliminary-discrepancy" class="form-control" name="UphosteryPreliminary[discrepancy][]" rows="4"><?=$uphosteryPreliminary->discrepancy?></textarea>
                                                                                                        <div class="help-block">
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </div> 
                                                                                        <?php } ?>

                                                                                        <?php if (isset($uphosteryPreliminary->corrective)) { ?>
                                                                                            <div class="col-sm-12 col-xs-12">    
                                                                                                <div class="form-group field-uphosterypreliminary-corrective">
                                                                                                    <div class="col-sm-3 text-right">
                                                                                                        <label class="control-label" for="uphosterypreliminary-corrective">Corrective</label>
                                                                                                    </div>
                                                                                                    <div class="col-sm-9 col-xs-12">
                                                                                                        <textarea id="uphosterypreliminary-corrective" class="form-control" name="UphosteryPreliminary[corrective][]" rows="4"><?=$uphosteryPreliminary->corrective?></textarea>
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
                                                                                <div class="form-group field-uphosterypreliminary-discrepancy">
                                                                                    <div class="col-sm-3 text-right">
                                                                                        <label class="control-label" for="uphosterypreliminary-discrepancy">Discrepancy</label>
                                                                                    </div>
                                                                                    <div class="col-sm-9 col-xs-12">
                                                                                        <textarea id="uphosterypreliminary-discrepancy" class="form-control" name="UphosteryPreliminary[discrepancy][]" rows="4"></textarea>
                                                                                        <div class="help-block">
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div> 

                                                                            <div class="col-sm-12 col-xs-12">    
                                                                                <div class="form-group field-uphosterypreliminary-corrective">
                                                                                    <div class="col-sm-3 text-right">
                                                                                        <label class="control-label" for="uphosterypreliminary-corrective">Corrective</label>
                                                                                    </div>
                                                                                    <div class="col-sm-9 col-xs-12">
                                                                                        <textarea id="uphosterypreliminary-corrective" class="form-control" name="UphosteryPreliminary[corrective][]" rows="4"></textarea>
                                                                                        <div class="help-block">
                                                                                        </div>
                                                                                    </div>

                                                                                </div>
                                                                            </div>  
                                                                            
                                                                        </div>   
                                                                    </div>  
                                                                </div>  

                                                                <?php  /* ?>
                                                                    <div class="">
                                                                        <div class="box-header with-border">
                                                                        </div>
                                                                        <!-- /.box-header -->

                                                                        <div class="box-body ">
                                                                            <div class="col-sm-12 col-xs-12">
                                                                               <?= $form->field($data['upAttachment'], 'attachment[preliminary_inspection][]', [
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
                                                                                            <a href="<?= 'uploads/preliminary_inspection/' .$at->value ?>" target="_blank"><?= $fileNameOnlyEx[1] ?></a>
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

                                                                            
                                                                            <div class="col-sm-12 col-xs-12">
                                                                               <?= $form->field($data['upAttachment'], 'attachment[disposition][]', [
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
                                                                                            <a href="<?= 'uploads/disposition/' .$at->value ?>" target="_blank"><?= $fileNameOnlyEx[1] ?></a>
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
                                                                <?php  */ ?>
                                                            </div>  
                                                        </div>  
                                                    </div>
                                                    <input type="text" class="partTemp">
                                                </div>  

                                            </div>
                                        </div>
                                    </div>
                                  </div>
                                  <div class="modal-footer">
                                        <button type="button" class="btn btn-primary" onclick="addUphosterysheet()">Save</button>
                                        <button type="button" class="btn btn-default close-modal" data-dismiss="modal">Close</button>
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
