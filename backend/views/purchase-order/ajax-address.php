<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use common\models\Part;

?>
<?php if ( $supplier->p_addr_1 ) { ?>
<option value="<?= $supplier->p_addr_1 ?>"><?= $supplier->p_addr_1 ?></option>
<?php } ?>
<?php if ( $supplier->p_addr_2 ) { ?>
<option value="<?= $supplier->p_addr_2 ?>"><?= $supplier->p_addr_2 ?></option>
<?php } ?>
<?php if ( $supplier->p_addr_3 ) { ?>
<option value="<?= $supplier->p_addr_3 ?>"><?= $supplier->p_addr_3 ?></option>
<?php } ?>
