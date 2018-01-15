<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\Work Order */


$id = $model->id;
$this->title = $model->traveler_no;
?>
    <!-- Content Header (Page header) -->
<div class="print-area">
    <table width="646" cellpadding="32" cellspacing="0" border="0" align="center" class="devicewidth" style="background:white;border-radius:0.5rem; height: 100%">
        <tr>
            <td align="center">
                <h3>
                    Traveler
                    <small><?= Html::encode($model->traveler_no) ?></small>
                </h3>
            </td>
        </tr>
        <tr>
            <td align="center">
                <br>
            </td>
        </tr>
        <tr>
            <td>
                <div class="">

                    <table class="box-body preview-po traveler-table" width="100%">
                        <tr>
                            <td class="td-bg">
                                <label>Job Type</label>
                            </td>
                            <td class="td-bg">
                                <label>Description</label>
                            </td>
                            <td class="td-bg">
                                <label>Effectivity</label>
                            </td>
                            <td class="td-bg">
                                <label>Revision Number</label>
                            </td>
                            <td class="td-bg">
                                <label>Revision Date</label>
                            </td>
                        </tr>
                        <tr>
                            <td align="left">
                                <?= $model->job_type ?>
                            </td>
                            <td align="left">
                                <?= $model->desc ?>
                            </td>
                            <td align="left">
                                <?= $model->effectivity ?>
                            </td>
                            <td align="left">
                                <?= $model->revision_no ?>
                            </td>
                            <td align="left">
                                <?php 
                                    if ( $model->revision_date ) { 
                                    $exIssue = explode(' ',$model->revision_date);
                                    $is = $exIssue[0];
                                    
                                    $time = explode('-', $is);
                                    $monthNum = $time[1];
                                    $dateObj   = DateTime::createFromFormat('!m', $monthNum);
                                    $monthName = $dateObj->format('M'); // March
                                    $receDate = $time[2] . ' ' .$monthName . ' ' .$time[0] ;

                                ?>
                                <?= $receDate ?>
                                <?php } ?>
                            </td>
                        </tr>
                        
                    </table>

                </div>
            </td>
        </tr>
        <tr>
            <td align="">
                <div class="traveler-content">
                    <?php echo $model->content; ?>
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
