<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use common\models\Part;
$dataPart = Part::dataPart();
/* <?= $soPartId ?> is part_id */
?>
<?php foreach ($stockDropdown as $stock_id => $s ) :  ?>
    <option value="<?=$stock_id?>"><?=$s?></option>
<?php endforeach; ?>