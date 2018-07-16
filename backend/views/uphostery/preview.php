<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\PurchaseOrder */

use common\models\Currency;
use common\models\Customer;
use common\models\Part;
use common\models\User;
use common\models\Staff;
use common\models\StorageLocation;
use common\models\Template;
use common\models\Unit;
use common\models\Setting;

$woNumber = 'Uphostery No Missing';
if ( $model->uphostery_scope && $model->uphostery_type ) {
    $woNumber = Setting::getUphosteryNo($model->uphostery_type,$model->uphostery_scope,$model->uphostery_no);
}


$id = $model->id;
$this->title = $woNumber;
$this->params['breadcrumbs'][] = ['label' => 'Uphosteries', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$dataLocation= StorageLocation::dataLocation();
$dataCustomer = Customer::dataCustomer();
$dataCurrency = Currency::dataCurrency();
$dataStaff = Staff::dataStaff();
$dataCurrencyISO = Currency::dataCurrencyISO();
$dataPart = Part::dataPart();
$dataPartDesc = Part::dataPartDesc();
$dataPartUnit = Part::dataPartUnit();
$dataUnit = Unit::dataUnit();
$dataUser = User::dataUser();
$dataTemplate = Template::dataTemplate();

/*plugins*/
use kartik\file\FileInput;
$files = User::find()->where(['id'=>Yii::$app->user->id])->one();
?>
<div class="uphostery-view" style="min-height: 1000px">


    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <?= Html::encode($woNumber) ?><br>
            <h5>Status: <?= $model->deleted == '1' ? 'uphostery order deleted' : '' ?><strong class="uppercase"><?= $model->status ?></strong></h5>
        </h1>
        <?php if ( $model->status === 'cancelled' ) { ?>
            This uphostery order has been cancelled
        <?php } ?>
    </section>
        <div class="col-sm-12 text-right">
                <?php if ( $model->status == 'Completed' ) { ?>
                    
                    <?php if ( $model->is_do ) { ?>
                        <?php echo Html::a('<i class="fa fa-eye"></i> Preview DO', ['delivery-order/index','delivery_order_id' => $model->delivery_order_id], ['class' => 'btn btn-success']) ?>
                    <?php } else { ?>
                        <?php echo Html::a('<i class="fa fa-edit"></i> Generate DO', ['delivery-order/new', 'id' => $model->id], ['class' => 'btn btn-danger']) ?>
                    <?php } ?>

                <?php } ?>

                <?php if ( $model->status != 'Completed' ) { ?>
                    <?php echo Html::a('<i class="fa fa-edit"></i> Update', ['edit', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                <?php } else if ( Yii::$app->user->identity->user_group_id == 1 ) { ?>
                    <?php echo Html::a('<i class="fa fa-edit"></i> Update', ['edit', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                <?php } ?>

                <?php if ( $model->status !== 'cancelled' ) { ?>

                <?php } ?>

                <?php if ( $model->deleted == '0' ) { ?>
                    <?php Html::a('<i class="fa fa-trash"></i> Delete', ['delete-column', 'id' => $model->id], [
                        'class' => 'btn btn-danger',
                        'data' => [
                            'confirm' => 'Are you sure you want to delete this uphostery order?',
                        ],
                    ]) ?>
                <?php } ?>

                <?= Html::a( 'Back', Url::to(['index']), array('class' => 'btn btn-default')) ?>
            <br>
            <br>
            <!-- /.box-header -->
        </div>
        <section class="content">
            <div class="row">
                <div class="col-xs-12">

                <?php /* general info */ ?>

                    <div class="box box-danger">
                        <div class="box-header with-border">
                          <h3 class="box-title">Customer Details</h3>
                        </div>


                        <div class="box-body preview-po">
                            <div class="row">
                                <div class="col-sm-6 col-xs-12">
                                    <div class="col-sm-5">
                                        <label>Customer:</label>
                                    </div>
                                    <div class="col-sm-7">
                                        <a href="?r=customer/update&id=<?=$customer->id?>" target="_blank"><?= $customer->name ?></a>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-xs-12">
                                    <div class="col-sm-5">
                                        <label>Contact Person:</label>
                                    </div>
                                    <div class="col-sm-7">
                                        1. <?= $customer->contact_person ?><br>
                                        2. <?= $customer->contact_person_2?><br>
                                        3. <?= $customer->contact_person_3?><br>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-xs-12">
                                    <div class="col-sm-5">
                                        <label>Email:</label>
                                    </div>
                                    <div class="col-sm-7">
                                        <?= $customer->email ?>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-xs-12">
                                    <div class="col-sm-5">
                                        <label>Contact No.:</label>
                                    </div>
                                    <div class="col-sm-7">
                                        <?= $customer->contact_no ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="box">
                        <div class="box-header with-border">
                          <h3 class="box-title">Uphostery Details</h3>
                        </div>


                        <div class="box-body preview-po">
                            <div class="row">
                                <div class="col-sm-6 col-xs-12">
                                    <div class="col-sm-5">
                                        <label>Product Type:</label>
                                    </div>
                                    <div class="col-sm-7 capitalize">
                                        <?= $model->uphostery_type ?>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-xs-12">
                                    <div class="col-sm-5">
                                        <label>Job Type:</label>
                                    </div>
                                    <div class="col-sm-7">
                                        <?= $model->uphostery_scope ?>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6 col-xs-12">
                                    <div class="col-sm-5">
                                        <label>Uphostery Creation Date</label>
                                    </div>
                                    <div class="col-sm-7">
                                        <?php
                                            if ( $model->date ) {
                                            $exIssue = explode(' ',$model->date);
                                            $is = $exIssue[0];

                                            $time = explode('-', $is);
                                            $monthNum = $time[1];
                                            $dateObj   = DateTime::createFromFormat('!m', $monthNum);
                                            $monthName = $dateObj->format('M'); // March
                                            $issueDate = $time[2] . ' ' .$monthName . ' ' .$time[0] ;
                                        ?>
                                        <?= $issueDate ?>
                                        <?php } ?>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-xs-12">
                                    <div class="col-sm-5">
                                        <label>Received Date:</label>
                                    </div>
                                    <div class="col-sm-7">
                                        <?php
                                            if ( $model->received_date ) {
                                            $exIssue = explode(' ',$model->received_date);
                                            $is = $exIssue[0];

                                            $time = explode('-', $is);
                                            $monthNum = $time[1];
                                            $dateObj   = DateTime::createFromFormat('!m', $monthNum);
                                            $monthName = $dateObj->format('M'); // March
                                            $issueDate = $time[2] . ' ' .$monthName . ' ' .$time[0] ;
                                        ?>
                                        <?= $issueDate ?>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6 col-xs-12">
                                    <div class="col-sm-5">
                                        <label>Approval Date :</label>
                                    </div>
                                    <div class="col-sm-7">
                                        <?php
                                            if ( $model->approval_date ) {
                                            $exIssue = explode(' ',$model->approval_date);
                                            $is = $exIssue[0];

                                            $time = explode('-', $is);
                                            $monthNum = $time[1];
                                            $dateObj   = DateTime::createFromFormat('!m', $monthNum);
                                            $monthName = $dateObj->format('M'); // March
                                            $issueDate = $time[2] . ' ' .$monthName . ' ' .$time[0] ;
                                        ?>
                                        <?= $issueDate ?>
                                        <?php } ?>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-xs-12">
                                    <div class="col-sm-5">
                                        <label>Date On Dock:</label>
                                    </div>
                                    <div class="col-sm-7">
                                        <?php
                                            if ( $model->on_dock_date ) {
                                            $exIssue = explode(' ',$model->on_dock_date);
                                            $is = $exIssue[0];

                                            $time = explode('-', $is);
                                            $monthNum = $time[1];
                                            $dateObj   = DateTime::createFromFormat('!m', $monthNum);
                                            $monthName = $dateObj->format('M'); // March
                                            $issueDate = $time[2] . ' ' .$monthName . ' ' .$time[0] ;
                                        ?>
                                        <?= $issueDate ?>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6 col-xs-12">
                                    <div class="col-sm-5">
                                        <label>Estimated Delivery Date:</label>
                                    </div>
                                    <div class="col-sm-7">
                                        <?php
                                            if ( $model->needs_by_date ) {
                                            $exIssue = explode(' ',$model->needs_by_date);
                                            $is = $exIssue[0];

                                            $time = explode('-', $is);
                                            $monthNum = $time[1];
                                            $dateObj   = DateTime::createFromFormat('!m', $monthNum);
                                            $monthName = $dateObj->format('M'); // March
                                            $issueDate = $time[2] . ' ' .$monthName . ' ' .$time[0] ;
                                        ?>
                                        <?= $issueDate ?>
                                        <?php } ?>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-xs-12">
                                    <div class="col-sm-5">
                                        <label>Customer PO:</label>
                                    </div>
                                    <div class="col-sm-7">
                                        <?= $model->customer_po_no ?>
                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>
                <?php /* product ordered */ ?>
                    <div class="box box-success">

                        <div class="box-header with-border">
                          <h3 class="box-title">Part Details</h3>
                        </div>
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                  <th>id</th>
                                    <th>Part No</th>
                                    <th>Description</th>
                                    <th>Serial No.</th>
                                    <th>Batch No.</th>
                                    <th>Eligibility</th>
                                    <th>Location</th>
                                    <th>Quantity</th>
                                    <th>Template</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($uphosteryParts) ) { ?>
                                    <?php foreach ( $uphosteryParts as $wop ) : ?>
                                        <?php 
                                            $isAllChecked = false;
                                            if ( $wop->is_processing == 1 && $wop->is_receiving == 1 && $wop->is_preliminary == 1 && $wop->is_hidden == 1 && $wop->is_traveler == 1 && $wop->is_final == 1 ) {
                                                $isAllChecked = true;
                                            }
                                        ?>
                                        <tr>
                                            <td><?= $wop->id ?></td>
                                            <td><?= $wop->part_no ?></td>
                                            <td><?= $wop->desc ?></td>
                                            <td><?= $wop->serial_no ?></td>
                                            <td><?= $wop->batch_no ?></td>
                                            <td><?= $wop->model ?></td>
                                            <td><?= $wop->location_id?$dataLocation[$wop->location_id]:'' ?></td>
                                            <td><?= $wop->quantity ?></td>
                                            <td><?= isset($wop->template_id)&&!empty($wop->template_id)?$dataTemplate[$wop->template_id]:'' ?></td>
                                            <td><?= $wop->status ?></td>
                                            <td class="wo-dropdown">
                                                <div class="btn-group">
                                                  <button type="button" class="btn btn-success">Actions</button>
                                                  <button type="button" class="btn btn-success dropdown-toggle generate-dropdown <?= $wop->id ?>" aria-expanded="true">
                                                    <span class="caret"></span>
                                                    <span class="sr-only">Toggle Dropdown</span>
                                                  </button>
                                                  <ul class="dropdown-menu drop-dropdown generate-dropdown-<?= $wop->id ?>" role="menu">
                                                      <?php if ( $model->status != 'Completed') { ?>
                                                        <li><?= Html::a( 'Processing Inspection', Url::to(['processing-inspection', 'id' => $model->id,'uphostery_part_id' => $wop->id])) ?></li>
                                                        <li><?= Html::a( 'Receiving Inspection', Url::to(['receiving-inspection', 'id' => $model->id,'uphostery_part_id' => $wop->id])) ?></li>
                                                        <li><?= Html::a( 'Preliminary Inspection', Url::to(['preliminary-inspection', 'id' => $model->id,'uphostery_part_id' => $wop->id])) ?></li>
                                                        <li><?= Html::a( 'Hidden Damage Inspection', Url::to(['hidden-damage', 'id' => $model->id,'uphostery_part_id' => $wop->id])) ?></li>
                                                        <li><?= Html::a( 'Uphosterysheet', Url::to(['uphostery-sheet', 'id' => $model->id,'uphostery_part_id' => $wop->id])) ?></li>
                                                        <li><hr></li>
                                                        <?php if ($wop->status!= 'scrapped' && $wop->status!='returned'): ?>
                                                          <?php if ($wop->status =='quarantined'): ?>
                                                            <li><?= Html::a( 'Move out of Quarantine', Url::to(['uphostery/remove-quarantined','uphostery_part_id' => $wop->id])) ?></li>
                                                          <?php else: ?>
                                                            <li><?= Html::a( 'Move to Quarantine', Url::to(['quarantine/new','uphostery_part_id' => $wop->id])) ?></li>
                                                          <?php endif; ?>

                                                          <li><?= Html::a( 'Return Back to Customer', Url::to(['uphostery/return-back','uphostery_part_id' => $wop->id])) ?></li>
                                                          <li><?= Html::a( 'Scrap Parts', Url::to(['scrap/new', 'uphostery_part_id' => $wop->id])) ?></li>
                                                        <?php endif; ?>
                                                        <li><hr></li>
                                                        <li><?= Html::a( 'Set Requisition', Url::to(['uphostery/requisition', 'id' => $model->id,'uphostery_part_id' => $wop->id])) ?></li>
                                                        <li><?= Html::a( 'Issue Parts', Url::to(['uphostery/issue', 'id' => $model->id,'uphostery_part_id' => $wop->id])) ?></li>
                                                        <li><?= Html::a( 'Return Parts', Url::to(['uphostery/return', 'id' => $model->id,'uphostery_part_id' => $wop->id])) ?></li>

                                                        <?php } else {?>
                                                            <?php if ( $isAllChecked ) { ?>
                                                                <li><?= Html::a( 'Generate ARC', Url::to(['uphostery-arc/generate', 'id' => $model->id,'uphostery_part_id' => $wop->id])) ?></li>
                                                            <?php } ?>
                                                        <?php } ?>
                                                  </ul>
                                                </div>
                                                <div class="btn-group">
                                                  <button type="button" class="btn btn-info">Print</button>
                                                  <button type="button" class="btn btn-info dropdown-toggle print-dropdown <?= $wop->id ?>" aria-expanded="true">
                                                    <span class="caret"></span>
                                                    <span class="sr-only">Toggle Dropdown</span>
                                                  </button>
                                                  <ul class="dropdown-menu drop-dropdown drop-dropdown-<?= $wop->id ?>" role="menu">
                                                    <li><?= Html::a( 'Receiving Inspection', Url::to(['print-receiving', 'id' => $model->id,'uphostery_part_id' => $wop->id]), array('target' => '_blank')) ?></li>
                                                    <li><?= Html::a( 'Detailed Inspection', Url::to(['print', 'id' => $model->id,'uphostery_part_id' => $wop->id]), array('target' => '_blank')) ?></li>
                                                    <li><?= Html::a( 'Disposition Report', Url::to(['print-disposition', 'id' => $model->id,'uphostery_part_id' => $wop->id]), array('target' => '_blank')) ?></li>
                                                    <li><?= Html::a( 'Uphosterysheet', Url::to(['print-traveler', 'id' => $model->id,'uphostery_part_id' => $wop->id]), array('target' => '_blank')) ?></li>
                                                    <li><?= Html::a( 'Repairable Sticker', Url::to(['repairable-sticker', 'id' => $model->id,'uphostery_part_id' => $wop->id]), array('target' => '_blank')) ?></li>
                                                    <?php if ( $model->status == 'Completed') { ?>
                                                        <li class="divider"></li>
                                                        <li><?= Html::a( 'MRF', Url::to(['print-mrf', 'id' => $model->id,'uphostery_part_id' => $wop->id]), array('target' => '_blank')) ?></li>
                                                        <li><?= Html::a( 'BOM', Url::to(['print-bom', 'id' => $model->id,'uphostery_part_id' => $wop->id]), array('target' => '_blank')) ?></li>
                                                        <li><?= Html::a( 'Release Sticker', Url::to(['final-sticker', 'id' => $model->id,'uphostery_part_id' => $wop->id]), array('target' => '_blank')) ?></li>
                                                        <li><?= Html::a( 'Final Inspection', Url::to(['print-final', 'id' => $model->id,'uphostery_part_id' => $wop->id]), array('target' => '_blank')) ?></li>
                                                        
                                                        <?php //if ( $wop->is_processing == 1 && $wop->is_receiving == 1 && $wop->is_preliminary == 1 && $wop->is_hidden == 1 && $wop->is_traveler == 1 && $wop->is_final == 1 ) { ?>
                                                            <?php foreach ( $uphosteryArc[$wop->id] as $woa ) {  ?>
                                                                <?php if ( $woa->type == 'CAAS' ) { ?>
                                                                    <li><?= Html::a( 'ARC - CAAS', Url::to(['uphostery-arc/print-caa', 'id' => $model->id, 'uphostery_part_id' => $wop->id]), array('target' => '_blank')) ?></li>
                                                                <?php } ?>
                                                                <?php if ( $woa->type == 'FAA' ) { ?>
                                                                    <li><?= Html::a( 'ARC - FAA', Url::to(['uphostery-arc/print-faa', 'id' => $model->id, 'uphostery_part_id' => $wop->id]), array('target' => '_blank')) ?></li>
                                                                <?php } ?>
                                                                <?php if ( $woa->type == 'EASA' ) { ?>
                                                                    <li><?= Html::a( 'ARC - EASA', Url::to(['uphostery-arc/print-easa', 'id' => $model->id, 'uphostery_part_id' => $wop->id]), array('target' => '_blank')) ?></li>
                                                                <?php } ?>
                                                                <?php if ( $woa->type == 'COC' ) { ?>
                                                                    <li><?= Html::a( 'ARC - COC', Url::to(['uphostery-arc/print-coc', 'id' => $model->id, 'uphostery_part_id' => $wop->id]), array('target' => '_blank')) ?></li>
                                                                <?php } ?>
                                                                <?php if ( $woa->type == 'CAAV' ) { ?>
                                                                    <li><?= Html::a( 'ARC - CAAV', Url::to(['uphostery-arc/print-caav', 'id' => $model->id, 'uphostery_part_id' => $wop->id]), array('target' => '_blank')) ?></li>
                                                                <?php } ?>
                                                                <?php if ( $woa->type == 'DCAM' ) { ?>
                                                                    <li><?= Html::a( 'ARC - DCAM', Url::to(['uphostery-arc/print-dcam', 'id' => $model->id, 'uphostery_part_id' => $wop->id]), array('target' => '_blank')) ?></li>
                                                                <?php } ?>
                                                            <?php } ?>
                                                        <?php// } ?>

                                                    <?php } ?>

                                                  </ul>
                                                </div>
                                                <?php if ($files->user_group_id == 1 || $wop->status != 'Completed'){ ?>
                                                <div class="btn-group">
                                                    <button type="button" class="btn btn-danger" data-toggle="modal" 
                                                        data-target="#checklistModalUp"
                                                        data-uphostery_id="<?=$model->id?>"
                                                        data-uphostery_part_id="<?=$wop->id?>">
                                                        Checklist
                                                    </button>
                                                </div>
                                                <?php } ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php } /* if got part s*/ else { ?>
                                    <tr>
                                        <td colspan="9" align="center">
                                            No part is added
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>

                    </div>
                    <!-- Modal -->
                    <div class="modal fade" id="checklistModalUp" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <form method="POST">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">Uphostery Checklist</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="modal-body">
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                        <button type="submit" class="btn btn-primary">Save changes</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>



                <?php /* BOM */ ?>

                    <?php if ( $UphosteryStockRequisition ) { ?>
                        <div class="box box-danger">
                            <div class="box-header with-border">
                              <h3 class="box-title">Material Issued</h3>
                            </div>
                            <div class="box-body preview-po">
                                <table class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <td>#</td>
                                            <td>Part Number</td>
                                            <td>Description</td>
                                            <td>Qty Required</td>
                                            <td>Qty Issued</td>
                                            <td>Qty Returned</td>
                                            <td>Unit</td>
                                            <!-- <td>Stock Quantity After Issued</td> -->
                                            <td>Record Created</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $loopNo = 1; ?>
                                        <?php foreach ($UphosteryStockRequisition as $wPU ) { ?>
                                            <tr>
                                                <td><?= $loopNo ?></td>
                                                <td><?= $dataPart[$wPU->part_id] ?></td>
                                                <td><?= $dataPartDesc[$wPU->part_id] ?></td>
                                                <td><?= $wPU->qty_required ?></td>
                                                <td><?= $wPU->qty_issued ?></td>
                                                <td><?= $wPU->qty_returned ?></td>
                                                <td><?= $dataUnit[$dataPartUnit[$wPU->part_id]] ?></td>
                                                <!-- <td><?= $wPU->qty_stock ?></td> -->
                                                <td><?= $wPU->created ?></td>
                                            </tr>
                                            <?php $loopNo++; ?>
                                        <?php } ?>
                                    </tbody>
                                </table>

                            </div>
                        </div>
                    <?php } ?>



            </div>
        </div>
    </section>
</div>


<?php


        /*    'type',
            'uphostery_no',
            'customer_id',
            'customer_po_no',
            'date',
            'part_no',
            'received_date',
            'qc_notes',
            'inspection',
            'corrective',
            'disposition_note',
            'hidden_damage',
            'arc_remark',
            'created',
            'created_by',
            'updated',
            'updated_by',
            'approved',
            'deleted',
*/
?>
