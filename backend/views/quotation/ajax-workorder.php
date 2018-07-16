<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use common\models\Part;
use common\models\WorkOrder;

?>
<?php foreach( $dataWorkO as $work_order_id => $workOrder) { 
?>
<option value="<?= $work_order_id ?>"><?= $workOrder ?></option>
<?php } ?>
