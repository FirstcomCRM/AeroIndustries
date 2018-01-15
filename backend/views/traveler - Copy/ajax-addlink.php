<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use common\models\Part;

$dataPart = ArrayHelper::map(Part::find()->all(), 'id', 'part_no');
?>

<span class="section-link-<?=$nn?> section-links active">
    <a href="javascript:selectSection(<?=$nn?>)">Section <?=$nn?></a>&nbsp;&nbsp;&nbsp;<a href="javascript:removeSelection(<?=$nn?>)"><i class="fa fa-close"></i></a>  |
</span> 