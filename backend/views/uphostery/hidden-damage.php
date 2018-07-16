<?php
// $session = Yii::$app->session;
// d($session->get('receiving_inspection'));
// d($session->get('uphosterysheet'));
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

$woNumber = 'Uphostery Order No Missing';
if ( $data['model']->uphostery_scope && $data['model']->uphostery_type ) {
    $woNumber = Setting::getUphosteryNo($data['model']->uphostery_type,$data['model']->uphostery_scope,$data['model']->uphostery_no);
}

?>

<div class="uphostery-form">
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
                <li class="active"><a href="#tab_1" data-toggle="tab">Uphostery Order <?= $woNumber ?></a></li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="tab_rece">
                    <div class="box-body arc-box">  
                        <div class="row">
                            <div class="col-sm-3 col-xs-6">
                                <label>Uphostery Order No.</label>
                            </div>
                            <div class="col-sm-3 col-xs-6">
                                <?= $woNumber ?>
                            </div>
                            <div class="col-sm-3 col-xs-6">
                                <label>Part No.</label>
                            </div>
                            <div class="col-sm-3 col-xs-6">
                                <?= $data['euphosteryPart']->part_no ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-3 col-xs-6">
                                <label>Description</label>
                            </div>
                            <div class="col-sm-3 col-xs-6">
                                <?= $data['euphosteryPart']->desc ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="box box-success">

             <?php /* Receiving Inspection  */  ?>

                <div class="tab-pane active" id="tab_rece">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="">
                                <div class="box-header with-border">
                                  <h3 class="box-title">Hidden Damage Inspection</h3>
                                </div>
                                <!-- /.box-header -->

                                <div class="box-body ">


                                    <div class="col-sm-12 col-xs-12">    
                                        <?= $form->field($data['uphosteryPart'], 'hidden_date', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                                            <div class="col-sm-9 col-xs-12">{input}{error}{hint}</div>
                                            '])->textInput(['id' => 'datepicker9','readonly' => true]) 
                                        ?>
                                    </div>  

                                    <div class="col-sm-12 text-right">

                                        <button type="button" class="btn btn-primary" onclick="addHiddenDiscrepancy()">Add Discrepancy</button>
                                        <br>
                                        <br>
                                    </div>
                                        
                                    <div class="extra-hdiscrepancy">
                                        <?php if ( isset($data['hiddenDamage'][0]) ) { ?>
                                            <?php foreach ($data['hiddenDamage'] as $key => $hD) : ?>

                                                <?php if (isset($hD->discrepancy)) { ?>
                                                    <div class="col-sm-12 col-xs-12">    
                                                        <div class="form-group field-uphosteryhiddendamage-discrepancy">
                                                            <div class="col-sm-3 text-right">
                                                                <label class="control-label" for="uphosteryhiddendamage-discrepancy">Discrepancy</label>
                                                            </div>
                                                            <div class="col-sm-9 col-xs-12">
                                                                <textarea id="uphosteryhiddendamage-discrepancy" class="form-control" name="UphosteryHiddenDamage[discrepancy][]" rows="4"><?=$hD->discrepancy?></textarea>
                                                                <div class="help-block">
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div> 
                                                <?php } ?>


                                                <?php if (isset($hD->corrective)) { ?>
                                                    <div class="col-sm-12 col-xs-12">    
                                                        <div class="form-group field-uphosteryhiddendamage-corrective">
                                                            <div class="col-sm-3 text-right">
                                                                <label class="control-label" for="uphosteryhiddendamage-corrective">Corrective</label>
                                                            </div>
                                                            <div class="col-sm-9 col-xs-12">
                                                                <textarea id="uphosteryhiddendamage-corrective" class="form-control" name="UphosteryHiddenDamage[corrective][]" rows="4"><?=$hD->corrective?></textarea>
                                                                <div class="help-block">
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>  
                                                <?php } ?>

                                               
                                                <div class='col-sm-3 text-right'>
                                                </div>
                                               

                                                <div class="col-sm-9 col-xs-12">

                                                <?php if ( !empty ( $data['currHidAtt'] ) ) { ?> 
                                                    <?php foreach ( $data['currHidAtt'] as $at ) { 
                                                        $currentAttachmentClass = explode('\\', get_class($at))[2]; ?>
                                                        <?php 
                                                            $fileNameOnlyEx = explode('-', $at->value);

                                                        ?>
                                                        <div class="col-sm-3 col-xs-12">
                                                            <a href="<?= 'uploads/hidden_damage/' .$at->value ?>" target="_blank"><?= $fileNameOnlyEx[1] ?></a>
                                                             <?= Html::a(' <i class="fa fa-close"></i> ', ['uphostery/remove-woa', 'id' => $at->id], [
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

                                            <?php endforeach; ?>
                                        <?php } ?>


                                        <div class="col-sm-12 col-xs-12">    
                                            <div class="form-group field-uphosteryhiddendamage-discrepancy">
                                                <div class="col-sm-3 text-right">
                                                    <label class="control-label" for="uphosteryhiddendamage-discrepancy">Discrepancy</label>
                                                </div>
                                                <div class="col-sm-9 col-xs-12">
                                                    <textarea id="uphosteryhiddendamage-discrepancy" class="form-control" name="UphosteryHiddenDamage[discrepancy][]" rows="4"></textarea>
                                                    <div class="help-block">
                                                    </div>
                                                </div>
                                            </div>
                                        </div> 


                                        <div class="col-sm-12 col-xs-12">    
                                            <div class="form-group field-uphosteryhiddendamage-corrective">
                                                <div class="col-sm-3 text-right">
                                                    <label class="control-label" for="uphosteryhiddendamage-corrective">Corrective</label>
                                                </div>
                                                <div class="col-sm-9 col-xs-12">
                                                    <textarea id="uphosteryhiddendamage-corrective" class="form-control" name="UphosteryHiddenDamage[corrective][]" rows="4"></textarea>
                                                    <div class="help-block">
                                                    </div>
                                                </div>

                                            </div>
                                        </div>  

                                              
                                    </div> 

                                    <div class="col-sm-12 col-xs-12">
                                       <?= $form->field($data['woAttachment'], 'attachment[hidden_damage][][]', [
                                              'template' => "<div class='col-sm-3 text-right'>{label}{hint}</div>\n<div class='col-sm-9 col-xs-12'>{input}{error}</div>\n\n"
                                            ])
                                            ->widget(FileInput::classname(), [
                                            'options' => ['accept' => 'image/*'],
                                        ])->fileInput(['multiple' => true,])->label('Hidden Damage Attachment(s)') ?>
                                    </div>  
                                </div>  
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
