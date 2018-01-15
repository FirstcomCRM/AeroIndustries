<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
?>
<div class="row">
    <div class="col-sm-1 col-xs-12">    
        <?php echo $noLoop; ?>
    </div>    

    <div class="col-sm-2 col-xs-12">    
        <div class="form-group field-deliveryorderdetail-work_order_no">
            <input type="text" id="deliveryorderdetail-work_order_no" class="form-control" name="DeliveryOrderDetail[work_order_no][]" placeholder="Work Order">
            <div class="help-block"></div>
        </div>
    </div>  

    <div class="col-sm-2 col-xs-12">    
        <div class="form-group field-deliveryorderdetail-part_no">
            <input type="text" id="deliveryorderdetail-part_no" class="form-control" name="DeliveryOrderDetail[part_no][]" placeholder="Part No.">
            <div class="help-block"></div>
        </div>
    </div>    

    <div class="col-sm-2 col-xs-12">    
        <div class="form-group field-deliveryorderdetail-desc">
            <input type="text" id="deliveryorderdetail-desc" class="form-control" name="DeliveryOrderDetail[desc][]" maxlength="45" placeholder="Description">
            <div class="help-block"></div>
        </div>
    </div>    

    <div class="col-sm-1 col-xs-12">    
        <div class="form-group field-deliveryorderdetail-quantity">
            <input type="text" id="deliveryorderdetail-quantity" class="form-control" name="DeliveryOrderDetail[quantity][]" placeholder="Qty">
            <div class="help-block"></div>
        </div>
    </div>    

    <div class="col-sm-2 col-xs-12">    
        <div class="form-group field-deliveryorderdetail-remark">
            <input type="text" id="deliveryorderdetail-remark" class="form-control" name="DeliveryOrderDetail[remark][]" maxlength="45" placeholder="Remark">
            <div class="help-block"></div>
        </div>
    </div> 

    <div class="col-sm-2 col-xs-12">    
        <div class="form-group field-deliveryorderdetail-po_no">
            <input type="text" id="deliveryorderdetail-po_no" class="form-control" name="DeliveryOrderDetail[po_no][]" maxlength="45" placeholder="PO No.">
            <div class="help-block"></div>
        </div>
    </div>  
</div>  
