<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use common\models\Part;

$dataPart = ArrayHelper::map(Part::find()->all(), 'id', 'part_no');
?>
<textarea class="hidden content-hidden-<?=$nn?>-<?=$nnn?>" name="TravelerContents[<?=$nn?>][<?=$nnn?>]"></textarea>