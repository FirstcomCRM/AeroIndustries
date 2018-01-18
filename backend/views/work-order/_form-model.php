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

use common\models\User;
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
?>

<?php
	$files = User::find()->where(['id'=>Yii::$app->user->id])->one();
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
                    <li class="active"><a href="#tab_1" data-toggle="tab">Work Order</a></li>
                    <li><a href="#tab_2" data-toggle="tab">Part</a></li>
                    <li><a href="#tab_3" data-toggle="tab">Employee</a></li>
                </ul>
                <div class="tab-content">
                    <?php /* Work order detail*/ ?>
                        <div class="tab-pane active" id="tab_1">
                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="">
                                        <div class="box-header with-border">
                                          <h3 class="box-title">Work Order Details</h3>
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
                                                    '])->textInput(['maxlength' => true,'autocomplete' => 'off'])->label("Customer PO No.")
                                                ?>
                                            </div>
                                            <div class="col-sm-12 col-xs-12">
                                                <?= $form->field($data['model'], 'work_scope', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                                                    <div class="col-sm-9 col-xs-12">{input}{error}{hint}</div>
                                                    '])->dropDownList($dataWorkScope)
                                                ?>
                                            </div>
                                            <div class="col-sm-12 col-xs-12">
                                                <?= $form->field($data['model'], 'work_type', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                                                    <div class="col-sm-9 col-xs-12">{input}{error}{hint}</div>
                                                    '])->dropDownList($dataWorkType)
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
                                                <?= $form->field($data['workOrderPart'], 'disposition_date', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                                                    <div class="col-sm-9 col-xs-12">{input}{error}{hint}</div>
                                                    '])->textInput(['id'=>'datepicker7', 'autocomplete' => 'off', 'placeholder' => 'Please select date','readonly' => true])
                                                ?>

                                            </div>

																						<div class="col-sm-12 col-xs-12">
																						<!---edr if the work order is cancelled, status cannot be edited unless user is super admin--->
																						<?php if ($data['model']['status']=='cancelled'): ?>
																							<?php if ($files->user_group_id == 1): ?>
																								<?= $form->field($data['model'], 'status', ['template' => '<div class="col-sm-3 text-right">{label}</div>
																										<div class="col-sm-9 col-xs-12">{input}{error}{hint}</div>
																										'])->dropDownList($dataWorkStatus, ['class' => 'select2 form-control'])
																								?>
																							<?php endif; ?>
																						<?php else: ?>
																							<?= $form->field($data['model'], 'status', ['template' => '<div class="col-sm-3 text-right">{label}</div>
																									<div class="col-sm-9 col-xs-12">{input}{error}{hint}</div>
																									'])->dropDownList($dataWorkStatus, ['class' => 'select2 form-control'])
																							?>
																						<?php endif; ?>
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
                                               <?= $form->field($data['woAttachment'], 'attachment[work_order][]', [
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
                                                        <div class="col-sm-5 col-xs-12">
                                                            <a href="<?= 'uploads/work_order/' .$at->value ?>" target="_blank"><?= $fileNameOnlyEx[1] ?></a>
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

                    <?php /* Part */ ?>
                        <div class="tab-pane" id="tab_2">

                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="">
                                        <div class="box-header with-border">
                                          <h3 class="box-title">Part Details</h3>
                                        </div>
                                        <!-- /.box-header -->

                                        <div class="box-body add-part-section">
                                            <?php if ( $data['isEdit'] ) { ?>
                                                <?= $form->field($data['workOrderPart'], 'id[]')->hiddenInput()->label(false) ?>
                                                <?= $form->field($data['workOrderPart'], 'deleted[]')->hiddenInput()->label(false) ?>
                                            <?php } ?>

                                            <div class="col-sm-4 col-xs-12">
                                                <?= $form->field($data['workOrderPart'], 'part_no[]', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                                                    <div class="col-sm-9 col-xs-12">{input}{error}{hint}
                                                        <ul id="search-result" style="display: none;" class="dropdown-menu collapse">
                                                        </ul>
                                                    </div>
                                                    '])->textInput(['maxlength' => true,'autocomplete' => 'off'])
                                                ?>
                                            </div>

                                            <?php if ( $data['isEdit'] ) { ?>
                                                <div class="col-sm-4 col-xs-12">
                                                    <?= $form->field($data['workOrderPart'], 'new_part_no[]', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                                                        <div class="col-sm-9 col-xs-12">{input}{error}{hint}
                                                            <ul id="search-result" style="display: none;" class="dropdown-menu collapse">
                                                            </ul>
                                                        </div>
                                                        '])->textInput(['maxlength' => true,'autocomplete' => 'off'])
                                                    ?>
                                                </div>

                                                <div class="col-sm-4 col-xs-12">
                                                    <?= $form->field($data['workOrderPart'], 'man_hour[]', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                                                        <div class="col-sm-9 col-xs-12">{input}{error}{hint}</div>
                                                        '])->textInput(['autocomplete' => 'off'])
                                                    ?>
                                                </div>

                                                <div class="col-sm-4 col-xs-12">
                                                    <?= $form->field($data['workOrderPart'], 'productive_hour[]', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                                                        <div class="col-sm-9 col-xs-12">{input}{error}{hint}</div>
                                                        '])->textInput(['autocomplete' => 'off'])
                                                    ?>
                                                </div>

                                            <?php } else { ?>

                                                    <?= $form->field($data['workOrderPart'], 'new_part_no[]')->hiddenInput(['autocomplete' => 'off'])->label(false) ?>
                                                    <?= $form->field($data['workOrderPart'], 'man_hour[]')->hiddenInput(['autocomplete' => 'off'])->label(false) ?>
                                                    <?= $form->field($data['workOrderPart'], 'productive_hour[]')->hiddenInput(['autocomplete' => 'off'])->label(false) ?>

                                            <?php } ?>


                                            <div class="col-sm-4 col-xs-12">
                                                <?= $form->field($data['workOrderPart'], 'desc[]', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                                                    <div class="col-sm-9 col-xs-12">{input}{error}{hint}</div>
                                                    '])->textInput(['autocomplete' => 'off'])
                                                ?>
                                            </div>

                                            <div class="col-sm-4 col-xs-12">
                                                <?= $form->field($data['workOrderPart'], 'manufacturer[]', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                                                    <div class="col-sm-9 col-xs-12">{input}{error}{hint}</div>
                                                    '])->textInput(['autocomplete' => 'off'])
                                                ?>
                                            </div>

                                            <div class="col-sm-4 col-xs-12">
                                                <?= $form->field($data['workOrderPart'], 'model[]', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                                                    <div class="col-sm-9 col-xs-12">{input}{error}{hint}</div>
                                                    '])->textInput(['autocomplete' => 'off'])
                                                ?>
                                            </div>

                                            <div class="col-sm-4 col-xs-12">
                                                <?= $form->field($data['workOrderPart'], 'ac_tail_no[]', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                                                    <div class="col-sm-9 col-xs-12">{input}{error}{hint}</div>
                                                    '])->textInput(['autocomplete' => 'off'])
                                                ?>
                                            </div>

                                            <div class="col-sm-4 col-xs-12">
                                                <?= $form->field($data['workOrderPart'], 'ac_msn[]', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                                                    <div class="col-sm-9 col-xs-12">{input}{error}{hint}</div>
                                                    '])->textInput(['autocomplete' => 'off'])
                                                ?>
                                            </div>

                                            <div class="col-sm-4 col-xs-12">
                                                <?= $form->field($data['workOrderPart'], 'serial_no[]', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                                                    <div class="col-sm-9 col-xs-12">{input}{error}{hint}</div>
                                                    '])->textInput(['autocomplete' => 'off'])
                                                ?>
                                            </div>

                                            <div class="col-sm-4 col-xs-12">
                                                <?= $form->field($data['workOrderPart'], 'batch_no[]', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                                                    <div class="col-sm-9 col-xs-12">{input}{error}{hint}</div>
                                                    '])->textInput(['autocomplete' => 'off'])
                                                ?>
                                            </div>

                                            <div class="col-sm-4 col-xs-12">
                                                <?= $form->field($data['workOrderPart'], 'quantity[]', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                                                    <div class="col-sm-9 col-xs-12">{input}{error}{hint}</div>
                                                    '])->textInput(['autocomplete' => 'off'])
                                                ?>
                                            </div>

                                            <div class="col-sm-4 col-xs-12">
                                                <?= $form->field($data['workOrderPart'], 'location_id[]', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                                                    <div class="col-sm-9 col-xs-12">{input}{error}{hint}
                                                        <ul id="search-result" style="display: none;" class="dropdown-menu collapse">
                                                        </ul>
                                                    </div>
                                                    '])->dropDownList($dataLocation,['class' => 'select2','prompt' => 'Please select'])
                                                ?>
                                            </div>

                                            <div class="col-sm-4 col-xs-12">
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

                                            <div class="col-sm-4 col-xs-12 hidden">
                                                <?= $form->field($data['workOrderPart'], 'template_id[]', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                                                    <div class="col-sm-9 col-xs-12">{input}{error}{hint}</div>
                                                    '])->dropDownList($dataTemplate)
                                                ?>
                                            </div>

                                        </div>

                                    </div>
                                </div>
                            </div>
                            <button type="button" onclick="addPart();" class="btn btn-success add-button">Add Part</button>
                            <button type="button" onclick="savePart();" class="btn btn-primary save-button hidden">Save Part</button>
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
                                                        <th>Manufacturer</th>
                                                        <th>Model</th>
                                                        <th>Quantity</th>
                                                        <th>Remove</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                <?php $n = 0; ?>
                                                <?php if ($data['isEdit']) { ?>
                                                    <?php foreach ( $data['eworkOrderPart'] as $eworkOrderPart) : ?>
                                                        <tr class="part-<?=$n?>">
                                                            <td>
                                                                <?= $eworkOrderPart['part_no'] ?>
                                                                <input type='hidden' name='WorkOrderPart[id][]' class="edit-id-<?=$n?>" value='<?=$eworkOrderPart['id']?>'>
                                                                <input type='hidden' name='WorkOrderPart[part_no][]' class="edit-part_no-<?=$n?>" value='<?=$eworkOrderPart['part_no']?>'>
                                                                <input type='hidden' name='WorkOrderPart[desc][]' class="edit-desc-<?=$n?>" value='<?=$eworkOrderPart['desc']?>'>
                                                                <input type='hidden' name='WorkOrderPart[manufacturer][]' class="edit-manufacturer-<?=$n?>" value='<?=$eworkOrderPart['manufacturer']?>'>
                                                                <input type='hidden' name='WorkOrderPart[model][]' class="edit-model-<?=$n?>" value='<?=$eworkOrderPart['model']?>'>
                                                                <input type='hidden' name='WorkOrderPart[ac_tail_no][]' class="edit-ac_tail_no-<?=$n?>" value='<?=$eworkOrderPart['ac_tail_no']?>'>
                                                                <input type='hidden' name='WorkOrderPart[ac_msn][]' class="edit-ac_msn-<?=$n?>" value='<?=$eworkOrderPart['ac_msn']?>'>
                                                                <input type='hidden' name='WorkOrderPart[serial_no][]' class="edit-serial_no-<?=$n?>" value='<?=$eworkOrderPart['serial_no']?>'>
                                                                <input type='hidden' name='WorkOrderPart[batch_no][]' class="edit-batch_no-<?=$n?>" value='<?=$eworkOrderPart['batch_no']?>'>
                                                                <input type='hidden' name='WorkOrderPart[template_id][]' class="edit-template_id-<?=$n?>" value='<?=$eworkOrderPart['template_id']?>'>
                                                                <input type='hidden' name='WorkOrderPart[location_id][]' class="edit-location_id-<?=$n?>" value='<?=$eworkOrderPart['location_id']?>'>
                                                                <input type='hidden' name='WorkOrderPart[quantity][]' class="edit-quantity-<?=$n?>" value='<?=$eworkOrderPart['quantity']?>'>
                                                                <input type='hidden' name='WorkOrderPart[deleted][]' class="edit-deleted-<?=$n?>" value='<?=$eworkOrderPart['deleted']?>'>
                                                                <input type='hidden' name='WorkOrderPart[man_hour][]' class="edit-man_hour-<?=$n?>" value='<?=$eworkOrderPart['man_hour']?>'>
                                                                <input type='hidden' name='WorkOrderPart[productive_hour][]' class="edit-productive_hour-<?=$n?>" value='<?=$eworkOrderPart['productive_hour']?>'>
                                                                <input type='hidden' name='WorkOrderPart[new_part_no][]' class="edit-new_part_no-<?=$n?>" value='<?=$eworkOrderPart['new_part_no']?>'>
                                                            </td>
                                                            <td>
                                                                <?= $eworkOrderPart['manufacturer'] ?>
                                                            </td>
                                                            <td>
                                                                <?= $eworkOrderPart['model'] ?>
                                                            </td>
                                                            <td>
                                                                <?= $eworkOrderPart['quantity'] ?>
                                                            </td>
                                                            <td>
                                                                <button type="button" class="btn btn-warning" onclick="editPart(<?=$n?>)">Edit</button>
                                                                <button type="button" class="btn btn-danger" onclick="removePart(<?=$n?>)">Remove</button>
                                                            </td>
                                                        </tr>
                                                        <?php $n ++ ; ?>
                                                    <?php endforeach; ?>

                                                <?php } else { /* if else edit */ ?>
                                                    <tr class="empty-cart">
                                                            <td colspan="5">
                                                            Please add part
                                                            </td>
                                                        </tr>

                                                <?php } /* if else edit */ ?>

                                                    <input type='hidden' id="n" value="<?=$n?>">
                                                    <input type='hidden' id="m" value="">
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                    <?php  /* Worker  */ ?>
                        <div class="tab-pane" id="tab_3">
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


                </div>
    	    </div>
        <?php ActiveForm::end(); ?>
    </section>
</div>
<script type="text/javascript"> confi(); </script>
