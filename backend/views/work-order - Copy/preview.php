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

$woNumber = 'Work Order No Missing';
if ( $model->work_scope && $model->work_type ) {
    $woNumber = Setting::getWorkNo($model->work_type,$model->work_scope,$model->work_order_no);
}


$id = $model->id;
$this->title = $woNumber;
$this->params['breadcrumbs'][] = ['label' => 'Work Orders', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

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
?>
<div class="purchase-order-view">


    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <?= Html::encode($woNumber) ?>
            <small><?= $model->deleted == '1' ? 'work order deleted' : '' ?><span class="capitalize"><?= $model->status ?></span></small>
        </h1>
        <?php if ( $model->status === 'cancelled' ) { ?>
            This work order has been cancelled
        <?php } ?>
    </section>
        <div class="col-sm-12 text-right">

                <?php if ( $model->status == 'Completed' ) { ?>
                    <?php echo Html::a('<i class="fa fa-edit"></i> Generate ARC', ['work-order-arc/generate', 'id' => $model->id], ['class' => 'btn btn-success']) ?>
                    <?php echo Html::a('<i class="fa fa-edit"></i> Generate DO', ['delivery-order/new', 'id' => $model->id], ['class' => 'btn btn-danger']) ?>
                <?php } ?> 

                <?php echo Html::a('<i class="fa fa-edit"></i> Update', ['edit', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>


                <?php if ( $model->status !== 'cancelled' ) { ?>
                <div class="btn-group">
                  <button type="button" class="btn btn-info">Print</button>
                  <button type="button" class="btn btn-info dropdown-toggle print-dropdown" data-toggle="dropdown" aria-expanded="true">
                    <span class="caret"></span>
                    <span class="sr-only">Toggle Dropdown</span>
                  </button>
                  <ul class="dropdown-menu drop-dropdown" role="menu">

                    <li><?= Html::a( 'Work Order', Url::to(['print', 'id' => $model->id]), array('target' => '_blank')) ?></li>
                    <li><?= Html::a( 'Receiving Inspection', Url::to(['print-receiving', 'id' => $model->id]), array('target' => '_blank')) ?></li>
                    <li><?= Html::a( 'Disposition Report', Url::to(['print-disposition', 'id' => $model->id]), array('target' => '_blank')) ?></li>
                    <li><?= Html::a( 'Traveler', Url::to(['print-traveler', 'id' => $model->id]), array('target' => '_blank')) ?></li>
                    <li><?= Html::a( 'Repairable Sticker', Url::to(['repairable-sticker', 'id' => $model->id]), array('target' => '_blank')) ?></li>

                    <?php if ( $model->status == 'Completed') { ?>

                        <li class="divider"></li>
                        <li><?= Html::a( 'MRF', Url::to(['print-mrf', 'id' => $model->id]), array('target' => '_blank')) ?></li>
                        <li><?= Html::a( 'BOM', Url::to(['print-bom', 'id' => $model->id]), array('target' => '_blank')) ?></li>
                        <li><?= Html::a( 'Release Sticker', Url::to(['final-sticker', 'id' => $model->id]), array('target' => '_blank')) ?></li>
                        <li><?= Html::a( 'Final Inspection', Url::to(['print-final', 'id' => $model->id]), array('target' => '_blank')) ?></li>
                        <?php foreach ( $workOrderArc as $woa ) {  ?>
                            <?php if ( $woa->type == 'CAAS' ) { ?>
                                <li><?= Html::a( 'ARC - CAAS', Url::to(['work-order-arc/print-caa', 'id' => $model->id]), array('target' => '_blank')) ?></li>
                            <?php } ?>
                            <?php if ( $woa->type == 'FAA' ) { ?>
                                <li><?= Html::a( 'ARC - FAA', Url::to(['work-order-arc/print-faa', 'id' => $model->id]), array('target' => '_blank')) ?></li>
                            <?php } ?>
                            <?php if ( $woa->type == 'EASA' ) { ?>
                                <li><?= Html::a( 'ARC - EASA', Url::to(['work-order-arc/print-easa', 'id' => $model->id]), array('target' => '_blank')) ?></li>
                            <?php } ?>
                            <?php if ( $woa->type == 'COC' ) { ?>
                                <li><?= Html::a( 'ARC - COC', Url::to(['work-order-arc/print-coc', 'id' => $model->id]), array('target' => '_blank')) ?></li>
                            <?php } ?>
                        <?php } ?>

                    <?php } ?>

                  </ul>
                </div>
                <?php } ?>

                <?php if ( $model->deleted == '0' ) { ?>
                    <?php Html::a('<i class="fa fa-trash"></i> Delete', ['delete-column', 'id' => $model->id], [
                        'class' => 'btn btn-danger',
                        'data' => [
                            'confirm' => 'Are you sure you want to delete this work order?',
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
                    <div class="box">
                        <div class="box-header with-border">
                          <h3 class="box-title"><?= Html::encode($woNumber) ?></h3>
                        </div>

                        
                        <div class="box-body preview-po">
                            <div class="row">
                                <div class="col-sm-6 col-xs-12">
                                    <div class="col-sm-4">
                                        <label>Customer:</label>
                                    </div>
                                    <div class="col-sm-8">
                                        <?= $dataCustomer[$model->customer_id] ?>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-xs-12">
                                    <div class="col-sm-4">
                                        <label>Customer PO:</label>
                                    </div>
                                    <div class="col-sm-8">
                                        <?= $model->customer_po_no ?>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6 col-xs-12">
                                    <div class="col-sm-4">
                                        <label>Product Type:</label>
                                    </div>
                                    <div class="col-sm-8 capitalize">
                                        <?= $model->work_type ?>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-xs-12">
                                    <div class="col-sm-4">
                                        <label>Job Type:</label>
                                    </div>
                                    <div class="col-sm-8">
                                        <?= $model->work_scope ?>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6 col-xs-12">
                                    <div class="col-sm-4">
                                        <label>Date Issued:</label>
                                    </div>
                                    <div class="col-sm-8">
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
                                    <div class="col-sm-4">
                                        <label>Date Received:</label>
                                    </div>
                                    <div class="col-sm-8">
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
                                    <div class="col-sm-4">
                                        <label>Date On Dock:</label>
                                    </div>
                                    <div class="col-sm-8">
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
                                <div class="col-sm-6 col-xs-12">
                                    <div class="col-sm-4">
                                        <label>Date Needed:</label>
                                    </div>
                                    <div class="col-sm-8">
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
                                    <div class="col-sm-4">
                                        <label>Approval Date :</label>
                                    </div>
                                    <div class="col-sm-8">
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
                                    <div class="col-sm-4">
                                        <label>Status :</label>
                                    </div>
                                    <div class="col-sm-8 capitalize">
                                        <?= $model->status ?>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6 col-xs-12">
                                    <div class="col-sm-4">
                                        <label>Supervisor:</label>
                                    </div>
                                    <div class="col-sm-8">
                                        <?= $supervisor->staff_name ?>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-xs-12">
                                    <div class="col-sm-4">
                                        <label>Final Inspector:</label>
                                    </div>
                                    <div class="col-sm-8">
                                        <?= $finalInspector->staff_name?>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="col-sm-4">
                                        <label>Technician:</label>
                                    </div>
                                    <div class="col-sm-8">
                                        <?php $loop = 1; ?>
                                        <?php foreach ( $technician as $teccc) { ?> 
                                            <?= $teccc->staff_name ?><br>
                                            <?php $loop ++ ; ?>
                                        <?php } ?>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="col-sm-4">
                                        <label>Inspector:</label>
                                    </div>
                                    <div class="col-sm-8">
                                        <?php $loop = 1; ?>
                                        <?php foreach ( $inspector as $ins) { ?> 
                                            <?= $ins->staff_name ?><br>
                                            <?php $loop ++ ; ?>
                                        <?php } ?>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                <?php /* product ordered */ ?>
                    <div class="box box-success">

                        <div class="box-header with-border">
                          <h3 class="box-title">Part</h3>
                        </div>

                        <div class="box-body preview-po">
                            <div class="row">
                                <div class="col-sm-12 col-xs-12">
                                    <div class="col-sm-4 text-right">
                                        <label>Part Number:</label>
                                    </div>
                                    <div class="col-sm-8">
                                        <?= $model->part_no ?>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-xs-12">
                                    <div class="col-sm-4 text-right">
                                        <label>Serial No.:</label>
                                    </div>
                                    <div class="col-sm-8">
                                        <?= $model->serial_no ?>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-xs-12">
                                    <div class="col-sm-4 text-right">
                                        <label>Batch No.:</label>
                                    </div>
                                    <div class="col-sm-8">
                                        <?= $model->batch_no ?>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-xs-12">
                                    <div class="col-sm-4 text-right">
                                        <label>Eligibility:</label>
                                    </div>
                                    <div class="col-sm-8">
                                        <?= $model->model ?>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-xs-12">
                                    <div class="col-sm-4 text-right">
                                        <label>Template:</label>
                                    </div>
                                    <div class="col-sm-8">
                                        <?= $dataTemplate[$model->template_id] ?>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-xs-12">
                                    <div class="col-sm-4 text-right">
                                        <label>Description:</label>
                                    </div>
                                    <div class="col-sm-8">
                                        <?= nl2br($model->desc) ?>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-xs-12">
                                    <div class="col-sm-4 text-right">
                                        <label>Reason for removal:</label>
                                    </div>
                                    <div class="col-sm-8">
                                        <?= nl2br($model->complaint) ?>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-xs-12">
                                    <div class="col-sm-4 text-right">
                                        <label>QC Notes:</label>
                                    </div>
                                    <div class="col-sm-8">
                                        <?= nl2br($model->qc_notes) ?>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-xs-12">
                                    <div class="col-sm-4 text-right">
                                        <label>Storage Location:</label>
                                    </div>
                                    <div class="col-sm-8">
                                        <?php if (!empty($model->location_id) ) { ?>
                                        <?php $storage_location = StorageLocation::getStorageLocation($model->location_id); ?>
                                        <?= isset($storage_location) && !empty($storage_location)?$storage_location->name:'' ?>
                                        <?php } else { ?>
                                            Not found!
                                        <?php } ?>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-xs-12">
                                    <div class="col-sm-4 text-right">
                                        <label>ARC Remarks:</label>
                                    </div>
                                    <div class="col-sm-8">
                                        <?= nl2br($model->arc_remark) ?>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
               
                <?php /* preliminary */ ?>
                    <?php if ( $workPreliminary ) { ?>

                        <div class="box box-warning">
                            <div class="box-header with-border">
                              <h3 class="box-title">Preliminary Inspection</h3>
                            </div>
                            <div class="box-body preview-po">
                                <div class="row">
                                    <?php foreach ( $workPreliminary as $wP ) { ?>
                                        <div class="col-sm-12 col-xs-12">
                                            <div class="col-sm-4 text-right">
                                                <label>Discrepancy:</label>
                                            </div>
                                            <div class="col-sm-8">
                                                <?= nl2br($wP->discrepancy) ?>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-xs-12">
                                            <div class="col-sm-4 text-right">
                                                <label>Corrective Action:</label>
                                            </div>
                                            <div class="col-sm-8">
                                                <?= nl2br($wP->corrective) ?>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    <?php } ?>

                <?php /* hidden damage */ ?>

                    <?php if ( $hiddenDamage ) { ?>
                        <div class="box box-danger">
                            <div class="box-header with-border">
                              <h3 class="box-title">Hidden Damage</h3>
                            </div>
                            <div class="box-body preview-po">
                                <div class="row">
                                    <?php foreach ($hiddenDamage as $hD ) { ?>
                                        <div class="col-sm-12 col-xs-12">
                                            <div class="col-sm-4 text-right">
                                                <label>Discrepancy:</label>
                                            </div>
                                            <div class="col-sm-8">
                                                <?= nl2br($hD->discrepancy) ?>
                                            </div>
                                        </div>
                                        <div class="col-sm-12 col-xs-12">
                                            <div class="col-sm-4 text-right">
                                                <label>Corrective Action:</label>
                                            </div>
                                            <div class="col-sm-8">
                                                <?= nl2br($hD->corrective) ?>
                                            </div>
                                        </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    <?php } ?>

                <?php /* BOM */ ?>
                
                    <?php if ( $WorkStockRequisition ) { ?>
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
                                            <td>Stock Quantity After Issued</td>
                                            <td>Record Created</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $loopNo = 1; ?>
                                        <?php foreach ($WorkStockRequisition as $wPU ) { ?>
                                            <tr>
                                                <td><?= $loopNo ?></td>
                                                <td><?= $dataPart[$wPU->part_id] ?></td>
                                                <td><?= $dataPartDesc[$wPU->part_id] ?></td>
                                                <td><?= $wPU->qty_required ?></td>
                                                <td><?= $wPU->qty_issued ?></td>
                                                <td><?= $wPU->qty_returned ?></td>
                                                <td><?= $dataUnit[$dataPartUnit[$wPU->part_id]] ?></td>
                                                <td><?= $wPU->qty_stock ?></td>
                                                <td><?= $wPU->created ?></td>
                                            </tr>
                                            <?php $loopNo++; ?>
                                        <?php } ?>
                                    </tbody>
                                </table>
                                
                            </div>
                        </div>
                    <?php } ?>



                <?php /* attachment*/ ?>
                    <h3 class="box-title">Attachments</h3>
                    <div class="col-md-6">
                        <div class="box box-solid">
                            <div class="box-header with-border">
                                <i class="fa fa-file-archive-o"></i>
                                <h3 class="box-title">Work Order</h3>
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body">
                                <?php if ( !empty ( $currWoAtt ) ) { ?> 
                                    <?php foreach ( $currWoAtt as $at ) { 
                                        $currentAttachmentClass = explode('\\', get_class($at))[2]; ?>
                                        <?php 
                                            $fileNameOnlyEx = explode('-', $at->value);
                                        ?>
                                        <div class="col-sm-3 col-xs-12">
                                            <a href="<?= 'uploads/wo/' .$at->value ?>" target="_blank"><?= $fileNameOnlyEx[1] ?></a>
                                        </div>
                                    <?php } ?> 
                                <?php } else { ?> 
                                    <div class="col-sm-12 col-xs-12">
                                        No attachment found!
                                    </div>
                                <?php } ?> 
                            </div>
                        <!-- /.box-body -->
                        </div>
                      <!-- /.box -->
                    </div>

                    <div class="col-md-6">
                        <div class="box box-solid">
                            <div class="box-header with-border">
                                <i class="fa fa-file-archive-o"></i>
                                <h3 class="box-title">Preliminary Inspection</h3>
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body">
                                 <?php if ( !empty ( $currPreAtt ) ) { ?> 
                                    <?php foreach ( $currPreAtt as $at ) { 
                                        $currentAttachmentClass = explode('\\', get_class($at))[2]; ?>
                                        <?php 
                                            $fileNameOnlyEx = explode('-', $at->value);

                                        ?>
                                        <div class="col-sm-3 col-xs-12">
                                            <a href="<?= 'uploads/wo_pre/' .$at->value ?>" target="_blank"><?= $fileNameOnlyEx[1] ?></a>
                                        </div>
                                    <?php } ?> 
                                <?php } else { ?> 
                                        <div class="col-sm-12 col-xs-12">
                                            No attachment found!
                                        </div>
                                <?php } ?> 
                            </div>
                        <!-- /.box-body -->
                        </div>
                      <!-- /.box -->
                    </div>

                    <div class="col-md-6">
                        <div class="box box-solid">
                            <div class="box-header with-border">
                                <i class="fa fa-file-archive-o"></i>
                                <h3 class="box-title">Disposition</h3>
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body">
                                 <?php if ( !empty ( $currDisAtt ) ) { ?> 
                                    <?php foreach ( $currDisAtt as $at ) { 
                                        $currentAttachmentClass = explode('\\', get_class($at))[2]; ?>
                                        <?php 
                                            $fileNameOnlyEx = explode('-', $at->value);

                                        ?>
                                        <div class="col-sm-3 col-xs-12">
                                            <a href="<?= 'uploads/wo_dis/' .$at->value ?>" target="_blank"><?= $fileNameOnlyEx[1] ?></a>
                                        </div>
                                    <?php } ?> 
                                <?php } else { ?> 
                                        <div class="col-sm-12 col-xs-12">
                                            No attachment found!
                                        </div>
                                <?php } ?> 
                            </div>
                        <!-- /.box-body -->
                        </div>
                      <!-- /.box -->
                    </div>

                    <div class="col-md-6">
                        <div class="box box-solid">
                            <div class="box-header with-border">
                                <i class="fa fa-file-archive-o"></i>
                                <h3 class="box-title">Final Inspection</h3>
                            </div>
                            <!-- /.box-header -->
                            <div class="box-body">
                                 <?php if ( !empty ( $currFinalAtt ) ) { ?> 
                                    <?php foreach ( $currFinalAtt as $at ) { 
                                        $currentAttachmentClass = explode('\\', get_class($at))[2]; ?>
                                        <?php 
                                            $fileNameOnlyEx = explode('-', $at->value);

                                        ?>
                                        <div class="col-sm-3 col-xs-12">
                                            <a href="<?= 'uploads/wo_final/' .$at->value ?>" target="_blank"><?= $fileNameOnlyEx[1] ?></a>
                                        </div>
                                    <?php } ?> 
                                <?php } else { ?> 
                                        <div class="col-sm-12 col-xs-12">
                                            No attachment found!
                                        </div>
                                <?php } ?> 
                            </div>
                        <!-- /.box-body -->
                        </div>
                      <!-- /.box -->
                    </div>

                <?php /* attachmente */ ?>

            </div>
        </div>
    </section>
</div>


<?php 


        /*    'type',
            'work_order_no',
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