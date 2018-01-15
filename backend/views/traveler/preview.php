<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model common\models\Traveler */

$this->title = 'Worksheet Log for ' . $model->traveler_no;
$this->params['breadcrumbs'][] = ['label' => 'Travelers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="traveler-view">


    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <?= Html::encode($this->title) ?>
            <small></small>
        </h1>

                    <div class="col-sm-12 text-right">
                    <br>
                    <!-- /.box-header -->
                    </div>
    </section>
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header with-border">
                        <h3 class="box-title"></h3>
                        <button class="pull-right back-button btn btn-default">Back</button>
                    </div>

                    <div class="box-body">
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>
                                        Description
                                    </th>
                                    <th>
                                        Revision Date
                                    </th>
                                    <th>
                                        Revision No.
                                    </th>
                                    <th>
                                        Revised on
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($log as $lg) { ?>
                                    <tr>
                                        <td>
                                            <?php echo  nl2br($lg->description); ?>
                                        </td>
                                        <td>
                                            <?php echo $lg->date; ?>
                                        </td>
                                        <td>
                                            <?php echo $lg->revision_no; ?>
                                        </td>
                                        <td>
                                            <?php echo $lg->created; ?>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>

                </div>

            </div>
        </div>
    </section>
</div>
