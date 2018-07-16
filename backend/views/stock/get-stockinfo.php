<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use common\models\Part;
$dataPart = Part::dataPart();
/* <?= $soPartId ?> is part_id */
?>
<div class="row">
    <div class="col-sm-3">
        <label>Part No:</label>
    </div>
    <div class="col-sm-9">
        <?=$dataPart[$part_id]?>
    </div>
</div>
<div class="row">
    <div class="col-sm-3">
        <label>Shelf Life:</label>
    </div>
    <div class="col-sm-9">
        <?=$shelf_life?>
    </div>
</div>
<div class="row">
    <div class="col-sm-3">
        <label>Batch No:</label>
    </div>
    <div class="col-sm-9">
        <?=$batch_no?>
    </div>
</div>
<div class="row">
    <div class="col-sm-3">
        <label>Hour Used:</label>
    </div>
    <div class="col-sm-9">
        <?=$hour_used?>
    </div>
</div>
<div class="row">
    <div class="col-sm-3">
        <label>Expiration Date:</label>
    </div>
    <div class="col-sm-9">
        <?=$expiration_date?>
    </div>
</div>