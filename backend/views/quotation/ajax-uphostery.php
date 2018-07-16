<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use common\models\Part;
use common\models\Uphostery;

?>
<?php foreach( $dataUphoster as $uphostery_id => $uphostery) { 
?>
<option value="<?= $uphostery_id ?>"><?= $uphostery ?></option>
<?php } ?>
