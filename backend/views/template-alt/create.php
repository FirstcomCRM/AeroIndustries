<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\TemplateAlt */

$this->title = 'Template Alt';
$this->params['breadcrumbs'][] = ['label' => 'Template Alts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$subTitle = 'Create Template Alt';
?>
<div class="template-alt-create">

        <section class="content-header">
    		<h1><?= Html::encode($this->title) ?></h1>
            <small>Please key in the following fields</small>
        </section>

    <?= $this->render('_form', [
        'model' => $model,
        'subTitle' => $subTitle,
    ]) ?>

</div>
