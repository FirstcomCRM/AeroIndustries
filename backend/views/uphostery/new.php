<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Uphostery */

$this->title = 'Uphostery';
$this->params['breadcrumbs'][] = ['label' => 'Uphosterys', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$subTitle = 'Create Uphostery';
$data['isEdit'] = false;
$data['subTitle'] = $subTitle;
?>
<div class="uphostery-order-create">

        <section class="content-header">
    		<h1><?= Html::encode($subTitle) ?></h1>
            <small>Please key in the following fields</small>
        </section>

    <?= $this->render('_form-model', [
        'data' => $data,
    ]) ?>

</div>
