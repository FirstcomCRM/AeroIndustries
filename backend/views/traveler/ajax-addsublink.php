<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use common\models\Part;

$dataPart = ArrayHelper::map(Part::find()->all(), 'id', 'part_no');
?>
<span class="sub-section-<?=$nn?>-<?=$nnn?> sub-sections-<?=$nn?> sub-sections active">
    <a href="javascript:selectSubSection('<?=$nn?>-<?=$nnn?>')">Sub <?=$nnn?></a>&nbsp;&nbsp;&nbsp;<a href="javascript:removeSubSelection('<?=$nn?>-<?=$nnn?>')"><i class="fa fa-close"></i></a>  |
</span> 