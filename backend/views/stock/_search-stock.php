<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;

use common\models\Customer;
use common\models\Part;
use common\models\PartCategory;

/* @var $this yii\web\View */
/* @var $model common\models\SearchCustomer */
/* @var $form yii\widgets\ActiveForm */
$dataCustomer = ArrayHelper::map(Customer::find()->all(), 'id', 'name');
$dataPart = ArrayHelper::map(Part::find()->where(['<>','status','inactive'])->all(), 'id', 'part_no');
$dataPartCategory = ArrayHelper::map(PartCategory::find()->where(['<>','status','inactive'])->all(), 'id', 'name');
?>

<div class="customer-search">

    <div class="box">
        <div class="box-header with-border">
          <h3 class="box-title">Filter</h3>
        </div>
        <div class="box-body">
        <form action="" method="get">
            <input type="hidden" name="r" value="stock/stock">
            <div class='col-sm-3 col-xs-12'>    
                <select name="cat_id" class="form-control select2">
                    <option value="">All Categories</option>
                    <?php foreach ( $dataPartCategory as $catId => $name ) { ?>
                        <?php

                            $partCatSelected = ''; 
                            if ( isset( $_GET['cat_id'] ) && !empty( $_GET['cat_id'] ) ) { 
                                if ($_GET['cat_id'] == $catId ) {
                                    $partCatSelected = ' selected';
                                }
                            } 
                        ?>
                        <option value="<?= $catId ?>" <?= $partCatSelected ?>><?= $name ?></option>
                    <?php }  ?>
                </select>
            </div>
            <div class='col-sm-3 col-xs-12'>     
                <select name="part_id" class="form-control select2">
                    <option value="">All Parts</option>
                    <?php foreach ( $dataPart as $partId => $name ) { ?>
                        <?php

                            $partSelected = ''; 
                            if ( isset( $_GET['part_id'] ) && !empty( $_GET['part_id'] ) ) { 
                                if ($_GET['part_id'] == $partId ) {
                                    $partSelected = ' selected';
                                }
                            } 
                        ?>
                        <option value="<?= $partId ?>" <?= $partSelected ?>><?= $name ?></option>
                    <?php }  ?>
                </select>
            </div>
          

            <div class="col-sm-12 text-right">
                <div class="form-group">
                <br>
                    <?= Html::submitButton('<i class=\'fa fa-search\'></i> Search', ['class' => 'btn btn-primary']) ?>
                    <?= Html::a( 'Reset', Url::to(['stock']), array('class' => 'btn btn-default')) ?>
                </div>
            </div>
        </form>

        </div>
    </div>

</div>
