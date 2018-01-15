<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model common\models\User */
/* @var $form yii\widgets\ActiveForm */
$dataUserGroup = array( '1' => 'Admin', '2' => 'Engineer' , '3' => 'Mechanic', '4' => 'Purchasing', '5' => 'Quality Manager');
?>

<div class="user-form">

        <section class="content">
            <div class="row">
                <div class="col-xs-12">
                    <div class="box">
                        <div class="box-header with-border">
                          <h3 class="box-title"><?= $subTitle ?></h3>
                        </div>
                        <!-- /.box-header -->

                        <div class="box-body ">
						    <?php $form = ActiveForm::begin(); ?>
						    <div class="row">
							    <div class="col-sm-12 col-xs-12">
					                <?= $form->field($model, 'user_group_id', [
					                  'template' => "<div class='col-sm-3 text-right'>{label}</div>\n<div class='col-sm-9 col-xs-12'>{input}</div>\n{hint}\n{error}"
					                ])->dropDownList($dataUserGroup);  ?>
					            </div>
							    <div class="col-sm-12 col-xs-12">
					                <?= $form->field($model, 'username', [
					                  'template' => "<div class='col-sm-3 text-right'>{label}</div>\n<div class='col-sm-9 col-xs-12'>{input}</div>\n{hint}\n{error}"
					                ])->textInput(['maxlength' => true]);  ?>
					            </div>
				            </div>
						    <div class="row">
							    <div class="col-sm-12 col-xs-12">
					                <?= $form->field($model, 'email', [
					                  'template' => "<div class='col-sm-3 text-right'>{label}</div>\n<div class='col-sm-9 col-xs-12'>{input}</div>\n{hint}\n{error}"
					                ])->textInput();  ?>
					            </div>
							    <div class="col-sm-12 col-xs-12">
					                <?= $form->field($model, 'password', [
					                  'template' => "<div class='col-sm-3 text-right'>{label}</div>\n<div class='col-sm-9 col-xs-12'>{input}</div>\n{hint}\n{error}"
					                ])->passwordInput();  ?>
					            </div>
				            </div>


				            <div class="col-sm-12 text-right">
				            <br>
				                <div class="form-group">
				                    <?= Html::submitButton('Save', ['class' => 'btn btn-primary']) ?>
				                    <?php echo \yii\helpers\Html::a( 'Cancel', Url::to(['index']), array('class' => 'btn btn-default')); ?>
				                </div>
				            </div>
    						<?php ActiveForm::end(); ?>
					    </div>
				    </div>
			    </div>
		    </div>
	    </section>


</div>

<script type="text/javascript"> confi(); </script>