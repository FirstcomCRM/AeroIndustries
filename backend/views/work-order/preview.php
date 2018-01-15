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
            <?= Html::encode($woNumber) ?><br>
            <h5>Status: <?= $model->deleted == '1' ? 'work order deleted' : '' ?><strong class="uppercase"><?= $model->status ?></strong></h5>
        </h1>
        <?php if ( $model->status === 'cancelled' ) { ?>
            This work order has been cancelled
        <?php } ?>
    </section>
        <div class="col-sm-12 text-right">
                <?php if ( $model->status == 'Completed' ) { ?>
                    <?php echo Html::a('<i class="fa fa-edit"></i> Generate DO', ['delivery-order/new', 'id' => $model->id], ['class' => 'btn btn-danger']) ?>
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
                                    <div class="col-sm-5">
                                        <label>Customer:</label>
                                    </div>
                                    <div class="col-sm-7">
                                        <?= $dataCustomer[$model->customer_id] ?>
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
                            <div class="row">
                                <div class="col-sm-6 col-xs-12">
                                    <div class="col-sm-5">
                                        <label>Product Type:</label>
                                    </div>
                                    <div class="col-sm-7 capitalize">
                                        <?= $model->work_type ?>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-xs-12">
                                    <div class="col-sm-5">
                                        <label>Job Type:</label>
                                    </div>
                                    <div class="col-sm-7">
                                        <?= $model->work_scope ?>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-6 col-xs-12">
                                    <div class="col-sm-5">
                                        <label>Work Order Creation Date</label>
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
                                    <th>Part No</th>
                                    <th>Description</th>
                                    <th>Serial No.</th>
                                    <th>Batch No.</th>
                                    <th>Eligibility</th>
                                    <th>Location</th>
                                    <th>Quantity</th>
                                    <th>Template</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($workOrderParts) ) { ?>
                                    <?php foreach ( $workOrderParts as $wop ) : ?>
                                        <tr>
                                            <td><?= $wop->part_no ?></td>
                                            <td><?= $wop->desc ?></td>
                                            <td><?= $wop->serial_no ?></td>
                                            <td><?= $wop->batch_no ?></td>
                                            <td><?= $wop->model ?></td>
                                            <td><?= $wop->location_id ?></td>
                                            <td><?= $wop->quantity ?></td>
                                            <td><?= isset($wop->template_id)&&!empty($wop->template_id)?$dataTemplate[$wop->template_id]:'' ?></td>
                                            <td>
                                                <div class="btn-group">
                                                  <button type="button" class="btn btn-success">Actions</button>
                                                  <button type="button" class="btn btn-success dropdown-toggle generate-dropdown <?= $wop->id ?>" aria-expanded="true">
                                                    <span class="caret"></span>
                                                    <span class="sr-only">Toggle Dropdown</span>
                                                  </button>
                                                  <ul class="dropdown-menu drop-dropdown generate-dropdown-<?= $wop->id ?>" role="menu">
                                                      <?php if ( $model->status != 'Completed') { ?>
                                                        <li><?= Html::a( 'Processing Inspection', Url::to(['processing-inspection', 'id' => $model->id,'work_order_part_id' => $wop->id])) ?></li>
                                                        <li><?= Html::a( 'Receiving Inspection', Url::to(['receiving-inspection', 'id' => $model->id,'work_order_part_id' => $wop->id])) ?></li>
                                                        <li><?= Html::a( 'Preliminary Inspection', Url::to(['preliminary-inspection', 'id' => $model->id,'work_order_part_id' => $wop->id])) ?></li>
                                                        <li><?= Html::a( 'Hidden Damage Inspection', Url::to(['hidden-damage', 'id' => $model->id,'work_order_part_id' => $wop->id])) ?></li>
                                                        <li><?= Html::a( 'Worksheet', Url::to(['work-sheet', 'id' => $model->id,'work_order_part_id' => $wop->id])) ?></li>
                                                      <?php } ?>
                                                        <li><?= Html::a( 'Generate ARC', Url::to(['work-order-arc/generate', 'id' => $model->id,'work_order_part_id' => $wop->id])) ?></li>
                                                        <li><?= Html::a( 'Set Requisition', Url::to(['work-order/requisition', 'id' => $model->id,'work_order_part_id' => $wop->id])) ?></li>
                                                        <li><?= Html::a( 'Issue Parts', Url::to(['work-order/issue', 'id' => $model->id,'work_order_part_id' => $wop->id])) ?></li>
                                                        <li><?= Html::a( 'Return Parts', Url::to(['work-order/return', 'id' => $model->id,'work_order_part_id' => $wop->id])) ?></li>
                                                  </ul>
                                                </div>
                                                <div class="btn-group">
                                                  <button type="button" class="btn btn-info">Print</button>
                                                  <button type="button" class="btn btn-info dropdown-toggle print-dropdown <?= $wop->id ?>" aria-expanded="true">
                                                    <span class="caret"></span>
                                                    <span class="sr-only">Toggle Dropdown</span>
                                                  </button>
                                                  <ul class="dropdown-menu drop-dropdown drop-dropdown-<?= $wop->id ?>" role="menu">
                                                    <li><?= Html::a( 'Receiving Inspection', Url::to(['print-receiving', 'id' => $model->id,'work_order_part_id' => $wop->id]), array('target' => '_blank')) ?></li>
                                                    <li><?= Html::a( 'Detailed Inspection', Url::to(['print', 'id' => $model->id,'work_order_part_id' => $wop->id]), array('target' => '_blank')) ?></li>
                                                    <li><?= Html::a( 'Disposition Report', Url::to(['print-disposition', 'id' => $model->id,'work_order_part_id' => $wop->id]), array('target' => '_blank')) ?></li>
                                                    <li><?= Html::a( 'Traveler', Url::to(['print-traveler', 'id' => $model->id,'work_order_part_id' => $wop->id]), array('target' => '_blank')) ?></li>
                                                    <li><?= Html::a( 'Repairable Sticker', Url::to(['repairable-sticker', 'id' => $model->id,'work_order_part_id' => $wop->id]), array('target' => '_blank')) ?></li>
                                                    <?php if ( $model->status == 'Completed') { ?>
                                                        <li class="divider"></li>
                                                        <li><?= Html::a( 'MRF', Url::to(['print-mrf', 'id' => $model->id,'work_order_part_id' => $wop->id]), array('target' => '_blank')) ?></li>
                                                        <li><?= Html::a( 'BOM', Url::to(['print-bom', 'id' => $model->id,'work_order_part_id' => $wop->id]), array('target' => '_blank')) ?></li>
                                                        <li><?= Html::a( 'Release Sticker', Url::to(['final-sticker', 'id' => $model->id,'work_order_part_id' => $wop->id]), array('target' => '_blank')) ?></li>
                                                        <li><?= Html::a( 'Final Inspection', Url::to(['print-final', 'id' => $model->id,'work_order_part_id' => $wop->id]), array('target' => '_blank')) ?></li>
                                                        <?php foreach ( $workOrderArc as $woa ) {  ?>
                                                            <?php if ( $woa->type == 'CAAS' ) { ?>
                                                                <li><?= Html::a( 'ARC - CAAS', Url::to(['work-order-arc/print-caa', 'id' => $model->id, 'work_order_part_id' => $wop->id]), array('target' => '_blank')) ?></li>
                                                            <?php } ?>
                                                            <?php if ( $woa->type == 'FAA' ) { ?>
                                                                <li><?= Html::a( 'ARC - FAA', Url::to(['work-order-arc/print-faa', 'id' => $model->id, 'work_order_part_id' => $wop->id]), array('target' => '_blank')) ?></li>
                                                            <?php } ?>
                                                            <?php if ( $woa->type == 'EASA' ) { ?>
                                                                <li><?= Html::a( 'ARC - EASA', Url::to(['work-order-arc/print-easa', 'id' => $model->id, 'work_order_part_id' => $wop->id]), array('target' => '_blank')) ?></li>
                                                            <?php } ?>
                                                            <?php if ( $woa->type == 'COC' ) { ?>
                                                                <li><?= Html::a( 'ARC - COC', Url::to(['work-order-arc/print-coc', 'id' => $model->id, 'work_order_part_id' => $wop->id]), array('target' => '_blank')) ?></li>
                                                            <?php } ?>
                                                        <?php } ?>

                                                    <?php } ?>

                                                  </ul>
                                                </div>
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
                                            <!-- <td>Stock Quantity After Issued</td> -->
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