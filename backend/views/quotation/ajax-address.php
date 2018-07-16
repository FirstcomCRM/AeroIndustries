<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use common\models\Part;

?>
<?php foreach( $address as $addr ) { ?>
<option value="<?= $addr->id ?>"><?= $addr->address ?></option>
<?php } ?>
