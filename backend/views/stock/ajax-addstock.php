<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use common\models\Part;
$dataPart = ArrayHelper::map(Part::find()->where(['<>','status','inactive'])->all(), 'id', 'part_no');
/* <?= $soPartId ?> is part_id */
?>
<tr class="required-added-<?= $n ?>">
    <td width="">
        <input type="text" class="form-control" readonly value="<?=$dataPart[$soPartId]?>">
        <input type="hidden" name="PartId[]" readonly value="<?= $soPartId ?>">
    </td>
    <td width="8%">
        <input type="text" name="WorkStockRequisition[qty_required][]" class="form-control stock-qty-<?= $soPartId ?>" readonly value="<?=$soQty ?>">
    </td>
    <td width="7%">
        <input type="text" name="WorkStockRequisition[uom][]" class="form-control stock-uom-<?= $soPartId ?>" readonly value="<?=$soUom ?>">
    </td>
    <td width="30%">
        <input type="text" name="WorkStockRequisition[remark][]" class="form-control" readonly value="<?=$soRemark ?>">
    </td>
    <td width="1%">
    </td>
    <td width="9%">
        <a href='javascript:removeStock(<?= $n ?>);'><i class="fa fa-trash"></i> Remove</a>
    </td>
    <td width="5%">
        <input type="hidden" id="gt" value="1">
        <input type="hidden" name="WorkStockRequisition[qty_stock][]" readonly value="<?=$stQty ?>">
    </td>
</tr>