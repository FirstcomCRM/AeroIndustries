<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\User */

$this->title = 'Create User';
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
$subTitle = 'Create User';
?>
<div class="user-create">


        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                <?= Html::encode($this->title) ?>
                <small>Please key in the following fields</small>
            </h1>
        </section>

	    <?= $this->render('_form', [
	        'model' => $model,
	        'subTitle'=>$subTitle,
	    ]) ?>

</div>
