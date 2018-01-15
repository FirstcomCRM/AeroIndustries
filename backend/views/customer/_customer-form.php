<?php

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

/* @var $this yii\web\View */
/* @var $model common\models\Customer */
/* @var $form yii\widgets\ActiveForm */
use common\models\Currency;
$dataCurrency = ArrayHelper::map(Currency::find()->where(['status' => 'active'])->all(), 'id', 'name');
?>

<div class="customer-form">
	<section class="content">
        <?php $form = ActiveForm::begin(); ?>
        <div class="form-group text-right">
            <?= Html::submitButton('<i class="fa fa-save"></i> Save', ['class' => 'btn btn-primary']) ?>
            <?= Html::a( 'Cancel', Url::to(['index']), array('class' => 'btn btn-default')) ?>
            &nbsp;
        </div>
        <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
                <li class="active"><a href="#tab_0" data-toggle="tab">Basic Info</a></li>
                <li><a href="#tab_1" data-toggle="tab">Company Address</a></li>
                <li><a href="#tab_2" data-toggle="tab">Shipping Information</a></li>
                <li><a href="#tab_3" data-toggle="tab">Billing Information</a></li>
            </ul>
            <div class="tab-content">
                <div class="tab-pane active" id="tab_0">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="box">
                                <div class="box-header with-border">
                                  <h3 class="box-title"><?= $subTitle ?></h3>
                                </div>
                                <!-- /.box-header -->

                                <div class="box-body ">
                                    <div class="col-sm-12 col-xs-12">    
                                        <?= $form->field($model, 'name', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                                        <div class="col-sm-9 col-xs-12">{input}</div>
                                        {hint}
                                        {error}'])->textInput(['maxlength' => true]) ?>
                                    </div>    

                                    <div class="col-sm-12 col-xs-12">    
                                        <?= $form->field($model, 'company_name', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                                        <div class="col-sm-9 col-xs-12">{input}</div>
                                        {hint}
                                        {error}'])->textInput(['maxlength' => true]) ?>
                                    </div>    

                                    <div class="col-sm-12 col-xs-12">    
                                        <?= $form->field($model, 'contact_person', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                                        <div class="col-sm-9 col-xs-12">{input}</div>
                                        {hint}
                                        {error}'])->textInput(['maxlength' => true]) ?>
                                    </div>   
                                    
                                    <div class="col-sm-12 col-xs-12">    
                                        <?= $form->field($model, 'title', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                                        <div class="col-sm-9 col-xs-12">{input}</div>
                                        {hint}
                                        {error}'])->textInput(['maxlength' => true]) ?>
                                    </div>  
 

                                    <div class="col-sm-12 col-xs-12">    
                                        <?= $form->field($model, 'email', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                                        <div class="col-sm-9 col-xs-12">{input}</div>
                                        {hint}
                                        {error}'])->textInput(['maxlength' => true]) ?>
                                    </div>    

                                    <div class="col-sm-12 col-xs-12">    
                                        <?= $form->field($model, 'contact_no', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                                        <div class="col-sm-9 col-xs-12">{input}</div>
                                        {hint}
                                        {error}'])->textInput(['maxlength' => true]) ?>
                                    </div>    

                                    <div class="col-sm-12 col-xs-12">    
                                        <?= $form->field($model, 'freight_forwarder', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                                        <div class="col-sm-9 col-xs-12">{input}</div>
                                        {hint}
                                        {error}'])->textInput(['maxlength' => true]) ?>
                                    </div>    

                                    <div class="col-sm-12 col-xs-12">    
                                        <?= $form->field($model, 'status', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                                        <div class="col-sm-9 col-xs-12">{input}</div>
                                        {hint}
                                        {error}'])->dropDownList([ 1=> 'Active' , 0 => 'Inactive']) ?>
                                    </div>                

            				    </div>
            			    </div>
            		    </div>
                    </div>
                
                </div>

                <div class="tab-pane" id="tab_1">
                    <div class="row">
                        <div class="col-xs-12">

                            <div class="box box-danger">
                                <div class="box-header with-border">
                                  <h3 class="box-title">Company Address</h3>
                                </div>
                                <!-- /.box-header -->
                                            
                                <div class="box-body">

                                    <div class="row company-addresses">


                                        <?php if (isset($currAddress)) { ?>
                                            <?php $loopNo = 1; ?>
                                            <?php foreach ($currAddress as $key => $crAddr) : ?>
                                                <?php if ($crAddr->address_type == 'address') { ?>
                                                    <div class="col-sm-12 col-xs-12">    
                                                        <div class="form-group field-address-address has-success">
                                                            <div class="col-sm-3 text-right">
                                                                <label class="control-label" for="address-address">Company Address <?=$loopNo?></label>
                                                            </div>
                                                            <div class="col-sm-9 col-xs-12">
                                                                <textarea id="address-address" class="form-control company-addresses-input" name="Address[address][]"><?=$crAddr->address?></textarea>
                                                            </div>

                                                            <div class="help-block"></div>
                                                        </div>                                            
                                                        <div class="form-group field-address-address_type">
                                                            <input type="hidden" id="address-address_type" class="form-control" name="Address[address_type][]" value="address">
                                                            <div class="help-block"></div>
                                                        </div>                                        
                                                    </div>
                                                    <?php $loopNo ++; ?>
                                                <?php } ?>
                                            <?php endforeach; ?>
                                        <?php } ?>

                                        <div class="col-sm-12 col-xs-12">    
                                            <?= $form->field($address, 'address[]', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                                            <div class="col-sm-9 col-xs-12">{input}</div>
                                            {hint}
                                            {error}'])->textArea(['maxlength' => true,'class' => 'form-control company-addresses-input'])->label('Company Address ' . (isset ($loopNo) ? $loopNo : '1') ) ?>
                                            <?= $form->field($address, 'address_type[]')->hiddenInput(['value' => 'address'])->label(false);?>
                                        </div>   

                                    </div>  

                                    <div class="row">
                                        <div class="col-sm-12 col-xs-12 text-right">
                                            <div class="form-group">
                                                <div class="help-block"></div>
                                                <a type="button" onclick="addCompanyAddress()" class="btn btn-default">Add Company Address</a>
                                            </div>
                                        </div>
                                    </div>

                                </div>             
                                
                            </div>
                        </div>
                    </div>

                </div>

                <div class="tab-pane" id="tab_2">
                    <div class="row">
                        <div class="col-xs-12">

                            <div class="box box-danger">
                                <div class="box-header with-border">
                                  <h3 class="box-title">Shipping Information</h3>
                                </div>
                                <!-- /.box-header -->
                                            
                                <div class="box-body ">

                                    <div class="row shipping-addresses">



                                        <?php if (isset($currAddress)) { ?>
                                            <?php $loopNo = 1; ?>
                                            <?php foreach ($currAddress as $key => $crAddr) : ?>
                                                <?php if ($crAddr->address_type == 'shipping') { ?>
                                                    <div class="col-sm-12 col-xs-12">    
                                                        <div class="form-group field-address-address has-success">
                                                            <div class="col-sm-3 text-right">
                                                                <label class="control-label" for="address-address">Shipping Address <?=$loopNo?></label>
                                                            </div>
                                                            <div class="col-sm-9 col-xs-12">
                                                                <textarea id="address-address" class="form-control shipping-addresses-input" name="Address[address][]"><?=$crAddr->address?></textarea>
                                                            </div>

                                                            <div class="help-block"></div>
                                                        </div>                                            
                                                        <div class="form-group field-address-address_type">
                                                            <input type="hidden" id="address-address_type" class="form-control" name="Address[address_type][]" value="shipping">
                                                            <div class="help-block"></div>
                                                        </div>                                        
                                                    </div>
                                                    <?php $loopNo ++; ?>
                                                <?php } ?>
                                            <?php endforeach; ?>
                                        <?php } ?>


                                        <div class="col-sm-12 col-xs-12">    
                                            <?= $form->field($address, 'address[]', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                                            <div class="col-sm-9 col-xs-12">{input}</div>
                                            {hint}
                                            {error}'])->textArea(['maxlength' => true,'class' => 'form-control shipping-addresses-input'])->label('Shipping Address ' . (isset ($loopNo) ? $loopNo : '1') ) ?>
                                            <?= $form->field($address, 'address_type[]')->hiddenInput(['value' => 'shipping'])->label(false);?>
                                        </div>    

                                    </div>  

                                    <div class="row">
                                        <div class="col-sm-12 col-xs-12 text-right">
                                            <div class="form-group">
                                                <div class="help-block"></div>
                                                <a type="button" onclick="addShippingAddress()" class="btn btn-default">Add Shipping Address</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>             
                                
                            </div>
                        </div>
                    </div>

                </div>

                <div class="tab-pane" id="tab_3">
                    <div class="row">
                        <div class="col-xs-12">

                            <div class="box box-danger">
                                <div class="box-header with-border">
                                  <h3 class="box-title">Billing Information</h3>
                                </div>
                                <!-- /.box-header -->
                                            
                                <div class="box-body ">

                                    <div class="row billing-addresses">

                                        <?php if (isset($currAddress)) { ?>
                                            <?php $loopNo = 1; ?>
                                            <?php foreach ($currAddress as $key => $crAddr) : ?>
                                                <?php if ($crAddr->address_type == 'billing') { ?>
                                                    <div class="col-sm-12 col-xs-12">    
                                                        <div class="form-group field-address-address has-success">
                                                            <div class="col-sm-3 text-right">
                                                                <label class="control-label" for="address-address">Billing Address <?=$loopNo?></label>
                                                            </div>
                                                            <div class="col-sm-9 col-xs-12">
                                                                <textarea id="address-address" class="form-control billing-addresses-input" name="Address[address][]"><?=$crAddr->address?></textarea>
                                                            </div>

                                                            <div class="help-block"></div>
                                                        </div>                                            
                                                        <div class="form-group field-address-address_type">
                                                            <input type="hidden" id="address-address_type" class="form-control" name="Address[address_type][]" value="billing">
                                                            <div class="help-block"></div>
                                                        </div>                                        
                                                    </div>
                                                    <?php $loopNo ++; ?>
                                                <?php } ?>
                                            <?php endforeach; ?>
                                        <?php } ?>

                                        <div class="col-sm-12 col-xs-12">    
                                            <?= $form->field($address, 'address[]', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                                            <div class="col-sm-9 col-xs-12">{input}</div>
                                            {hint}
                                            {error}'])->textArea(['maxlength' => true,'class' => 'form-control billing-addresses-input'])->label('Billing Address ' . (isset ($loopNo) ? $loopNo : '1') ) ?>
                                            <?= $form->field($address, 'address_type[]')->hiddenInput(['value' => 'billing'])->label(false);?>
                                        </div>    
                                         
                                    </div> 

                                    <div class="row">

                                        <div class="col-sm-12 col-xs-12">    
                                            <?= $form->field($model, 'b_term', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                                            <div class="col-sm-9 col-xs-12">{input}</div>
                                            {hint}
                                            {error}'])->textInput(['maxlength' => true])->label('Billing Term') ?>
                                        </div>    

                                        <div class="col-sm-12 col-xs-12">    
                                            <?= $form->field($model, 'b_currency', ['template' => '<div class="col-sm-3 text-right">{label}</div>
                                            <div class="col-sm-9 col-xs-12">{input}</div>
                                            {hint}
                                            {error}'])->dropDownList($dataCurrency,['class' => 'select2',])->label('Billing Currency') ?>
                                        </div>   

                                    </div>

                                    <div class="row">
                                        <div class="col-sm-12 col-xs-12 text-right">
                                            <div class="form-group">
                                                <div class="help-block"></div>
                                                <a type="button" onclick="addBillingAddress()" class="btn btn-default">Add Billing Address</a>
                                            </div>
                                        </div>
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