<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\Work Order */

use common\models\Currency;
use common\models\Customer;
use common\models\Part;
use common\models\FinalInspection;
use common\models\User;
use common\models\Setting;
use dosamigos\ckeditor\CKEditorInline;

$woNumber = 'Work Order No Missing';
if ( $model->work_scope && $model->work_type ) {
    $woNumber = Setting::getWorkNo($model->work_type,$model->work_scope,$model->work_order_no);
}
$id = $model->id;
$this->title = $woNumber;
$this->params['breadcrumbs'][] = ['label' => 'Purchase Orders', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$dataCustomer = ArrayHelper::map(Customer::find()->all(), 'id', 'name');
$dataCurrency = ArrayHelper::map(Currency::find()->all(), 'id', 'name');
$dataCurrencyISO = ArrayHelper::map(Currency::find()->all(), 'id', 'iso');
$dataPart = ArrayHelper::map(Part::find()->all(), 'id', 'part_no');
$dataUser = ArrayHelper::map(User::find()->all(), 'id', 'username');
$dataFinal = ArrayHelper::map(FinalInspection::find()->all(), 'id', 'build');
?>

    <!-- Content Header (Page header) -->
<div class="row">
    <div class="col-sm-4">
    </div>
    <div class="col-sm-3">
        <select class="form-control" id="final-inspection-selection" onchange="getFinal()">
            <option value="0">-- Please select final inspection form -- </option>
            <?php foreach ( $dataFinal as $finalId => $finalBuildNo ) { ?>
                <option value="<?= $finalId ?>"> <?= $finalBuildNo ?></option>
            <?php } ?>
        </select>
    </div>
</div>
<div class="print-area">

    <table width="646" cellpadding="32" cellspacing="0" border="0" align="center" class="devicewidth" style="background:white;border-radius:0.5rem;margin-top:40px">
       
        <?php include ('print-header.php');?>

        <tr>
            <td align="center" colspan="11">
                <h3>
                    Final Inspection - Checklist
                </h3>
            </td>
        </tr>
        <tr>
            <td class="final-title" colspan="11">
               
                
            </td>
        </tr>
        <tr>
            <td class="final-content" colspan="11">
               
                
            </td>
        </tr>
    </table>
    <div class="print-footer">

        <table width="646" cellpadding="32" cellspacing="0" border="0" align="center" class="devicewidth" style="background:white;border-radius:0.5rem;">
            <tr>
                <td class="final-form-no" colspan="11" style="text-align: right;font-weight: bold;">
                    
                </td>
            </tr>
        </table>
    </div>
</div>

<?php
/*
 <tr>
                        <td class="final-underline" width="50px" height="50px">
                            
                        </td>
                        <td width="10px">
                        </td>
                        <td valign="bottom">
                            <?php CKEditorInline::begin(['preset' => 'basic']);?>
                                Ensure that all requirements of the customers ro have been met, and that all requested maintenance has been performed
                            <?php CKEditorInline::end();?>
                        </td>
                    </tr>
*/
?>
<div class="row text-center">
    <div class="col-sm-4">
    </div>
    <div class="col-sm-2"><br>
        <button class="btn btn-danger form-control print-button">Print</button>
    </div>
    <div class="col-sm-2"><br>
        <button class="btn btn-default form-control close-button">Close</button>
    </div>
</div>
