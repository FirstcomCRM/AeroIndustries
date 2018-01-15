<?php

use yii\helpers\Inflector;
use yii\helpers\StringHelper;

/* @var $this yii\web\View */
/* @var $generator yii\gii\generators\crud\Generator */

$urlParams = $generator->generateUrlParams();

echo "<?php\n";
?>

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model <?= ltrim($generator->modelClass, '\\') ?> */

$this->title = <?= $generator->generateString(Inflector::camel2words(StringHelper::basename($generator->modelClass))) ?>;
$this->params['breadcrumbs'][] = ['label' => <?= $generator->generateString(Inflector::pluralize(Inflector::camel2words(StringHelper::basename($generator->modelClass)))) ?>, 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model-><?= $generator->getNameAttribute() ?>, 'url' => ['view', <?= $urlParams ?>]];
$this->params['breadcrumbs'][] = <?= $generator->generateString('Update') ?>;
$subTitle = <?= $generator->generateString('Update ', ['modelClass' => Inflector::camel2words(StringHelper::basename($generator->modelClass))]) ?> . $model-><?= $generator->getNameAttribute() ?>;
?>
<div class="<?= Inflector::camel2id(StringHelper::basename($generator->modelClass)) ?>-update">
        <section class="content-header">
		    <h1><?= "<?= " ?>Html::encode($this->title) ?></h1>
	    </section>

		    <?= "<?= " ?>$this->render('_form', [
		        'model' => $model,
		        'subTitle' => $subTitle,
		    ]) ?>

</div>
