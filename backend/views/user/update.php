<?php

use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use common\models\User;
use common\models\UserGroup;

/* @var $this yii\web\View */
/* @var $model common\models\User */
$dataUser = ArrayHelper::map(User::find()->all(), 'id', 'username');
$dataUserGroup = ArrayHelper::map(UserGroup::find()->all(), 'id', 'name');

$this->title =  $dataUser[$model->id];
$this->params['breadcrumbs'][] = ['label' => 'Users', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
$subTitle = 'Update User';
?>
<div class="user-update">


    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            <?= Html::encode($this->title) ?>
            <small><?= $dataUserGroup[$model['user_group_id']]?></small>
        </h1>
    </section>

    <?= $this->render('_form', [
        'model' => $model,
        'subTitle'=>$subTitle,
    ]) ?>

</div>
