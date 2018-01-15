<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use common\models\Part;

$dataPart = ArrayHelper::map(Part::find()->all(), 'id', 'part_no');
?>
<tr class="item-<?= $n ?>">
    <td style="width: 5%;">
        <div class="form-group field-qty0">
            <input type="text" class="form-control" id="selected-<?= $n ?>-group" name="QuotationDetail[<?= $n ?>][group]" value="<?= $group ?>" readonly>
        </div>  
    </td>
    <td style="width: 8%;">
        <div class="form-group field-qty0">
            <input type="text" class="form-control" id="selected-<?= $n ?>-qty" name="QuotationDetail[<?= $n ?>][quantity]" value="<?= $qty ?>" readonly onchange="updateQuoSubtotal(<?= $n ?>)">
        </div> 
    </td>
    <td> 
        <div class="form-group field-quotationdetail-part_id">
            <input type="hidden" id="item-type" value="part">

            <textarea id="quotationdetail-service_details" name="QuotationDetail[<?= $n ?>][service_details]" class="form-control" readonly placeholder="Service Detail" ><?= $serviceDetail ?></textarea>
        </div> 
    </td>
    <td style="width: 12%;">
        <div class="form-group field-quotationdetail-part_id">
            <input type="text" class="form-control" id="selected-<?= $n ?>-qty" name="QuotationDetail[<?= $n ?>][work_type]" value="<?= $workType ?>" readonly>
        </div>     
    </td>
    <td style="width: 15%;">
        <div class="form-group field-unit">
            <input type="text" class="form-control" id="selected-<?= $n ?>-unit" name="QuotationDetail[<?= $n ?>][unit_price]" value="<?= $unit ?>" readonly onchange="updateQuoSubtotal(<?= $n ?>)">
        </div>    
    </td>
    <td style="width: 15%;">
        <div class="form-group field-quotationdetail-unit_price">
            <input type="text" class="form-control subTotalGroup" id="selected-<?= $n ?>-subTotal" name="QuotationDetail[<?= $n ?>][subTotal]" value="<?= $subTotal ?>" readonly>
        </div>
    </td>
    <td style="width: 15%;" align="center"> 
        <span class="edit-button<?= $n ?> edit-button">
            <a href="javascript:editQuoItem(<?= $n ?>)"><i class="fa fa-pencil"></i> Edit</a>
        </span>
        <span class="save-button<?= $n ?> save-button hidden">
            <a href="javascript:saveQuoItem(<?= $n ?>)"><i class="fa fa-save"></i> Save</a>
        </span>
        <span class="remove-button">
            <a href="javascript:removeQuoItem(<?= $n ?>)">&nbsp;&nbsp;<i class="fa fa-trash"></i> Remove</a>
        </span>
    </td>
</tr>
