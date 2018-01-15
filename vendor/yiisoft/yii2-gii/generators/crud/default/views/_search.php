<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

echo "<?php\n";
?>

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model <?= ltrim($generator->searchModelClass, '\\') ?> */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-search">

    <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Filter</h3>
        </div>
        <div class="box-body">
                <?= "<?php " ?>$form = ActiveForm::begin([
                    'action' => ['index'],
                    'method' => 'get',
                ]); ?>

            <?php
            $count = 0;
            foreach ($generator->getColumnNames() as $attribute) {
                if (++$count < 6) {
                    echo "<div class='col-sm-3 col-xs-12'>";
                    echo "    <?= " . $generator->generateActiveSearchField($attribute) . " ?>\n\n";
                    echo "</div>";
                } else {
                    echo "    <?php // echo " . $generator->generateActiveSearchField($attribute) . " ?>\n\n";
                }
            }
            ?>
        <div class="col-sm-12 text-right">
            <div class="form-group">
                <?= "<?= " ?>Html::submitButton(<?= $generator->generateString('<i class="fa fa-search"></i> Search') ?>, ['class' => 'btn btn-primary']) ?>
                <?= "<?= " ?>Html::a( 'Reset', Url::to(['index']), array('class' => 'btn btn-default')) ?>
                
            </div>
        </div>

        <?= "<?php " ?>ActiveForm::end(); ?>
        </div>
    </div>

</div>
