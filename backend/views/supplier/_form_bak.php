<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;;
use yii\helpers\Url;
$backUrlFull = Yii::$app->request->referrer;
$exBackUrlFull = explode('?r=', $backUrlFull);
$backUrl = '#';
if ( isset ( $exBackUrlFull[1] ) ) {
$backUrl = $exBackUrlFull[1];
}

use common\models\Currency;


/* @var $this yii\web\View */
/* @var $model common\models\Supplier */
/* @var $form yii\widgets\ActiveForm */
$dataCurrency = ArrayHelper::map(Currency::find()->where(['<>','status','inactive'])->all(), 'id', 'name');


/*plugins*/
use kartik\file\FileInput;
?>

<div class="supplier-form">


    <section class="content">

        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]); ?>
                <!-- Custom Tabs -->

                <div class="form-group text-right">
                    <?= Html::submitButton('<i class="fa fa-save"></i> Save', ['class' => 'btn btn-primary']) ?>
                    <?= Html::a( 'Cancel', Url::to(['index']), array('class' => 'btn btn-default')) ?>
                    &nbsp;
                </div>

            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                  <li class="active"><a href="#tab_1" data-toggle="tab">Basic Info</a></li>
                  <li><a href="#tab_2" data-toggle="tab">Payment Information</a></li>
                  <li><a href="#tab_3" data-toggle="tab">Attachment</a></li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="tab_1">
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="">
                                    <div class="box-header with-border">
                                      <h3 class="box-title"><?= $subTitle ?></h3>
                                    </div>
                                    <!-- /.box-header -->

                                    <div class="box-body ">

                                        <div class="col-sm-12 col-xs-12">
                                            <?= $form->field($model, 'company_name', [
                                              'template' => "<div class='col-sm-3 text-right'>{label}</div>\n<div class='col-sm-9 col-xs-12'>{input}</div>\n{hint}\n{error}"
                                            ])->textInput(['maxlength' => true]);  ?>
                                        </div>

                                        <div class="col-sm-12 col-xs-12">
                                            <?= $form->field($model, 'addr', [
                                              'template' => "<div class='col-sm-3 text-right'>{label}</div>\n<div class='col-sm-9 col-xs-12'>{input}</div>\n{hint}\n{error}"
                                            ])->textArea(['maxlength' => true])->label('Address') ?>
                                        </div>

                                        <div class="col-sm-12 col-xs-12">
                                            <?= $form->field($model, 'contact_person', [
                                              'template' => "<div class='col-sm-3 text-right'>{label}</div>\n<div class='col-sm-9 col-xs-12'>{input}</div>\n{hint}\n{error}"
                                            ])->textInput(['maxlength' => true]);  ?>
                                        </div>

                                        <div class="col-sm-12 col-xs-12">
                                            <?= $form->field($model, 'title', [
                                              'template' => "<div class='col-sm-3 text-right'>{label}</div>\n<div class='col-sm-9 col-xs-12'>{input}</div>\n{hint}\n{error}"
                                            ])->textInput(['maxlength' => true]);  ?>
                                        </div>

                                        <div class="col-sm-12 col-xs-12">
                                            <?= $form->field($model, 'email', [
                                              'template' => "<div class='col-sm-3 text-right'>{label}</div>\n<div class='col-sm-9 col-xs-12'>{input}</div>\n{hint}\n{error}"
                                            ])->textInput(['maxlength' => true]);  ?>
                                        </div>

                                        <div class="col-sm-12 col-xs-12">
                                            <?= $form->field($model, 'contact_no', [
                                              'template' => "<div class='col-sm-3 text-right'>{label}</div>\n<div class='col-sm-9 col-xs-12'>{input}</div>\n{hint}\n{error}"
                                            ])->textInput(['maxlength' => true]);  ?>
                                        </div>

                                        <div class="col-sm-12 col-xs-12">
                                            <?= $form->field($model, 'scope_of_approval', [
                                              'template' => "<div class='col-sm-3 text-right'>{label}</div>\n<div class='col-sm-9 col-xs-12'>{input}</div>\n{hint}\n{error}"
                                            ])->textInput(['maxlength' => true]);  ?>
                                        </div>

                                        <div class="col-sm-12 col-xs-12">
                                            <?= $form->field($model, 'survey_date', [
                                              'template' => "<div class='col-sm-3 text-right'>{label}</div>\n<div class='col-sm-9 col-xs-12'>{input}</div>\n{hint}\n{error}"
                                            ])->textInput(['maxlength' => true,'id' => 'datepicker']);  ?>
                                        </div>

                                        <div class="col-sm-12 col-xs-12">
                                            <?= $form->field($model, 'status', [
                                              'template' => "<div class='col-sm-3 text-right'>{label}</div>\n<div class='col-sm-9 col-xs-12'>{input}</div>\n{hint}\n{error}"
                                            ])->dropDownList([ 'active' => 'Active', 'inactive' => 'Inactive'])  ?>
                                        </div>

                                        <div class="col-sm-12 col-xs-12">
                                            <?= $form->field($model, 'approval_status', [
                                              'template' => "<div class='col-sm-3 text-right'>{label}</div>\n<div class='col-sm-9 col-xs-12'>{input}</div>\n{hint}\n{error}"
                                            ])->dropDownList([ 'Pending' => 'Pending', 'Approved' => 'Approved', 'Disapproved' => 'Disapproved'])  ?>
                                        </div>



                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

              <!-- /.tab-pane -->
                    <div class="tab-pane" id="tab_2">
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="">
                                    <div class="box-header with-border">
                                      <h3 class="box-title"><?= $subTitle ?></h3>
                                    </div>
                                    <!-- /.box-header -->

                                    <div class="box-body ">


                                        <div class="col-sm-12 col-xs-12">
                                            <?= $form->field($model, 'p_addr_1', [
                                              'template' => "<div class='col-sm-3 text-right'>{label}</div>\n<div class='col-sm-9 col-xs-12'>{input}</div>\n{hint}\n{error}"
                                            ])->textArea(['maxlength' => true])->label('Payment Address 1');  ?>
                                        </div>

                                        <div class="col-sm-12 col-xs-12">
                                            <?= $form->field($model, 'p_addr_2', [
                                              'template' => "<div class='col-sm-3 text-right'>{label}</div>\n<div class='col-sm-9 col-xs-12'>{input}</div>\n{hint}\n{error}"
                                            ])->textArea(['maxlength' => true])->label('Payment Address 2');  ?>
                                        </div>

                                        <div class="col-sm-12 col-xs-12">
                                            <?= $form->field($model, 'p_addr_3', [
                                              'template' => "<div class='col-sm-3 text-right'>{label}</div>\n<div class='col-sm-9 col-xs-12'>{input}</div>\n{hint}\n{error}"
                                            ])->textArea(['maxlength' => true])->label('Payment Address 3');  ?>
                                        </div>

                                        <div class="col-sm-12 col-xs-12">
                                            <?= $form->field($model, 'p_currency', [
                                              'template' => "<div class='col-sm-3 text-right'>{label}</div>\n<div class='col-sm-9 col-xs-12'>{input}</div>\n{hint}\n{error}"
                                            ])->dropDownList($dataCurrency, ['class' => 'select2'])->label('Currency')  ?>
                                        </div>
                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                  <!-- /.tab-pane -->

                  <!-- /.tab-pane -->
                <div class="tab-pane" id="tab_3">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="">
                                <div class="box-header with-border">
                                  <h3 class="box-title"><?= $subTitle ?></h3>
                                </div>
                                <!-- /.box-header -->

                                <div class="box-body ">

                                    <div class="col-sm-12 col-xs-12">
                                       <?= $form->field($supplierAttachment, 'attachment[]', [
                                              'template' => "<div class='col-sm-3 text-right'>{label}</div>\n<div class='col-sm-9 col-xs-12'>{input}</div>\n{hint}\n{error}"
                                            ])
                                            ->widget(FileInput::classname(), [
                                            'options' => ['accept' => 'image/*'],
                                        ])->fileInput(['multiple' => true,])->label('Select Attachment(s)') ?>
                                    </div>
                                    
                                    <div class="col-sm-12 col-xs-12">
                                        <?= $form->field($supplierAttachment, 'remark', [
                                          'template' => "<div class='col-sm-3 text-right'>{label}</div>\n<div class='col-sm-9 col-xs-12'>{input}</div>\n{hint}\n{error}"
                                        ])->textInput(['maxlength' => true]);  ?>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12">
                            <?php if ($oldSA) { ?>
                            <div class="box">
                                <div class="box-header with-border">
                                  <h3 class="box-title">Attachments</h3>
                                </div>
                                <div class="box-body ">
                                    <?php  foreach ($oldSA as $oS) { 
                                        $supplierAttachmentClass = explode('\\', get_class($oS))[2];
                                        ?>

                                        <div class="col-sm-3">
                                            <a href="<?= 'uploads/'.$supplierAttachmentClass.'/'. $oS->value ?>" target="_blank"><?= $oS->value ?></a>
                                        </div>

                                    <?php } ?>
                                </div>
                            </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
              <!-- /.tab-pane -->
            </div>
            <!-- /.tab-content -->
        </div>
              <!-- nav-tabs-custom -->


        <?php ActiveForm::end(); ?>
        
    </section>
</div>
<script type="text/javascript"> confi(); </script>
