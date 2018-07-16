<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use common\models\Part;

$dataPart = ArrayHelper::map(Part::find()->all(), 'id', 'part_no');
?>

<tr class="item-<?= $n ?>">
    <td>    
        <div class="form-group field-generalpodetail-part_id">
            <input type="text" class="form-control" id="selected-<?= $n ?>-part" value="<?= $part ?>" readonly>
            <input type="hidden" class="form-control" name="GeneralPoDetail[<?= $n ?>][part_id]" value="<?= $partId ?>" readonly>
        </div>                                    
    </td>
    <td> 
        <div class="form-group field-qty0">
            <input type="text" class="form-control" id="selected-<?= $n ?>-qty" name="GeneralPoDetail[<?= $n ?>][quantity]" value="<?= $qty ?>" readonly onchange="updatePOSubtotal(<?= $n ?>)">
        </div>                                    
    </td>
    <td> 
        <div class="form-group field-unit">
            <input type="text" class="form-control unitGroup" id="selected-<?= $n ?>-unit" value="<?= $unit ?>" readonly onchange="updatePOSubtotal(<?= $n ?>)">
        </div>                                    
    </td>
    <td> 
        <div class="form-group field-unit">
            <input type="text" class="form-control converted_unit" id="selected-<?= $n ?>-converted_unit" name="GeneralPoDetail[<?= $n ?>][unit_price]" value="<?= $converted_unit ?>" readonly onchange="updatePOSubtotal(<?= $n ?>)">
        </div>                                    
    </td>
    <td> 
        <div class="form-group field-unit-m">
            <input type="text" class="form-control" id="selected-<?= $n ?>-unitm" value="<?= $unitM->unit ?>" readonly>
            <input type="hidden" name="GeneralPoDetail[<?= $n ?>][unit_id]" value="<?= $unitM->id ?>" readonly>
        </div>                                    
    </td>
    <td> 
        <div class="form-group field-generalpodetail-unit_price">
            <input type="text" class="form-control subTotalGroup" id="selected-<?= $n ?>-subTotal" name="GeneralPoDetail[<?= $n ?>][subTotal]" value="<?= $subTotal ?>" readonly>
        </div>
    </td>
    <td> 
        <?php /* <span class="edit-button<?= $n ?> edit-button"> 
            <a href="javascript:editPOItem(<?= $n ?>)"><i class="fa fa-pencil"></i> Edit</a>
        </span> */ ?>
        <span class="save-button<?= $n ?> save-button hidden">
            <a href="javascript:savePOItem(<?= $n ?>)"><i class="fa fa-save"></i> Save</a>
        </span>
        <span class="remove-button">
            <a href="javascript:removePOItem(<?= $n ?>)">&nbsp;&nbsp;<i class="fa fa-trash"></i> Remove</a>
        </span>
    </td>
</tr>