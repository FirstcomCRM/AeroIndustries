<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $traveler common\models\Uphostery */

use common\models\Customer;
use common\models\Setting;


$woNumber = 'Uphostery No Missing';
if ( $model->uphostery_scope && $model->uphostery_type ) {
    $woNumber = Setting::getUphosteryNo($model->uphostery_type,$model->uphostery_scope,$model->uphostery_no);
}

$id = $traveler->id;
$this->title = $traveler->traveler_no;

$dataCustomer = ArrayHelper::map(Customer::find()->all(), 'id', 'name');

?>
    <!-- Content Header (Page header) -->
<div class="print-area">
    <table width="646" cellpadding="32" cellspacing="0" border="0" align="center" class="devicewidth" style="background:white;border-radius:0.5rem; height: 100%">

        <?php include ('print-header.php');?>

        <tr>
            <td colspan="3" align="center">
                <h3>
                    Traveler
                    <small><?= Html::encode($traveler->traveler_no) ?></small>
                </h3>
            </td>
        </tr>
        <tr>
            <td colspan="3" align="center">
                <br>
            </td>
        </tr>
        <tr>
            <td colspan="3" align="center">
            </td>
        </tr>
        <tr>
            <td colspan="3" align="center">
                <br>
            </td>
        </tr>
    </table> 
    <table id="traveler-content-table" width="646px" cellpadding="32" cellspacing="0" border="0" align="center" class="devicewidth" style="background:white;border-radius:0.5rem; height: 100%">
        <tr>
            <td colspan="4">
                <div class="traveler-content">
                    <iframe src="uploads/traveler/<?=$traveler->value?>" style="width: 646px"></iframe>           
                </div>
            </td>
        </tr>
    </table>

</div>

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
