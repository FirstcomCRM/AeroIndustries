<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\UserPermission */

$this->title = 'User Permission';
$this->params['breadcrumbs'][] = ['label' => 'User Permissions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$subTitle = 'Create User Permission';
?>
<div class="user-permission-create">

        <section class="content-header">
    		<h1><?= Html::encode($this->title) ?></h1>
            <small>Please key in the following fields</small>
        </section>

    <?= $this->render('_form-model', [
        'model' => $model,
        'subTitle' => $subTitle,
    ]) ?>

</div>
