<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

/* @var $model \yii\db\ActiveRecord */
$model = new $generator->modelClass();
$safeAttributes = $model->safeAttributes();
if (empty($safeAttributes)) {
    $safeAttributes = $model->attributes();
}

echo "<?php\n";
?>

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;

$backUrlFull = Yii::$app->request->referrer;
$exBackUrlFull = explode('?r=', $backUrlFull);
$backUrl = '#';
if ( isset ( $exBackUrlFull[1] ) ) {
$backUrl = $exBackUrlFull[1];
}

/* @var $this yii\web\View */
/* @var $model <?= ltrim($generator->modelClass, '\\') ?> */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-form">
	<section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header with-border">
                      <h3 class="box-title"><?= "<?= " ?>$subTitle ?></h3>
                    </div>
                    <!-- /.box-header -->

                    <div class="box-body ">
				    <?= "<?php " ?>$form = ActiveForm::begin(); ?>
							<?php foreach ($generator->getColumnNames() as $attribute) {
							    if (in_array($attribute, $safeAttributes)) {
						    		echo '    <div class="col-sm-12 col-xs-12">';
							        echo "    <?= " . $generator->generateActiveField($attribute) . " ?>\n\n";
						    		echo '    </div>';
							    }
							} ?>
		            <div class="col-sm-12 text-right">
		            <br>
					    <div class="form-group">
					        <?= "<?= " ?>Html::submitButton(<?= $generator->generateString('<i class=\'fa fa-save\'></i> Save') ?>, ['class' => 'btn btn-primary']) ?>
		                    <?= "<?= " ?>Html::a( 'Cancel', Url::to('?r='.$backUrl), array('class' => 'btn btn-default')) ?>
					    </div>
				    </div>

				    <?= "<?php " ?>ActiveForm::end(); ?>
				    </div>
			    </div>
		    </div>
	    </div>
    </section>
</div>
