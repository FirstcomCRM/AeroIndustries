<?php

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

$this->title = 'User Permission';
/* @var $this yii\web\View */
/* @var $model common\models\UserPermission */
/* @var $form yii\widgets\ActiveForm */
isset($getModelName[0])?$modelName = $getModelName[0]:$modelName = '';

// $layman = [
// 	"index" => "$modelName Listing",
// 	"view" => "Preview $modelName",
// 	"create" => "Create $modelName",
// 	"update" => "Edit $modelName",
// 	"delete" => "Delete $modelName",
// ];

?>

<div class="user-permission-form">
	<section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header with-border">
                      <h3 class="box-title">Permission Setting</h3>
                    </div>
                    <!-- /.box-header -->

                    <div class="box-body ">
				    <?php $form = ActiveForm::begin(); ?>
				    	<div class="row">
					    	<div class="col-sm-3 col-xs-12">
								<select id="controllerName" name="controllerName" class="form-control">
						    	<?php foreach ( $controllerList as $cName => $cL ) {  ?>

						    		<?php  $selected = $controllerNameChosen == $cName ?  'selected' : ''?>
						    		<option value="<?= $cName ?>" <?= $selected ?>><?= $cName ?></option>
					    		<?php } ?>
					    		</select>
				    		</div>
					    	<div class="col-sm-3 col-xs-12">
								<select id="userGroup" name="userGroup" class="form-control">
									<option vale="0">Please select</option>
				    				<?php foreach ( $userGroup as $uG ) { ?>
				    					<?php  $selected = $userGroupId == $uG->id ?  'selected' : ''?>
				    					<option value="<?= $uG->id ?>" <?= $selected ?>><?= $uG->name ?></option>
			    					<?php } /* foreach */ ?>
			    				</select>
				    		</div>
					    	
			    		</div>
				    <?php ActiveForm::end(); ?>
				    <br>
					    <div class="row capitalize">
				    		<?php $form = ActiveForm::begin(); ?>
				    		<div class="col-sm-1">
				    		</div>
						    <div class="item col-sm-11">
					    		<input type="hidden" name="controllerName" value="<?= $controllerNameLong ?>">
					    		<input type="hidden" name="controllerNameChosen" value="<?= $controllerNameChosen ?>">
					    		<input type="hidden" name="userGroup" value="<?= $userGroupId ?>">
				    			<?php if ( $controllerActions ) {  ?>

				    				<?php 
				    					foreach ( $controllerActions as $cA ) { ?>
				    					<?php 
				    					/* if within the permission table */
				    					$checked = '';
				    					if ( in_array($cA, $permission, true) ){
				    						$checked = 'checked';
				    					}

				    					?>
				    					<input type="checkbox" name="checkBox[<?= $cA ?>]" <?= $checked ?> >&nbsp;&nbsp;&nbsp;<?= isset($layman[$cA])? $layman[$cA]: $cA?> <br>
			    					<?php } /* foreach */ ?>
					    		<input type="hidden" name="controllerNameChosen" value="<?= $controllerNameChosen ?>">
					    		<div class=" col-sm-12 text-right">
								    <div class="form-group">
					    				<input type="button" id="select-all" value="Select All" class="btn btn-success">
								        <?= Html::submitButton('<i class=\'fa fa-save\'></i> Save', ['class' => 'btn btn-primary']) ?>
								    </div>
							    </div>
			    				<?php } /* if */ ?>
				    		</div>
				    		<?php ActiveForm::end(); ?>
					    </div>
				    </div>


				    </div>
			    </div>
		    </div>
	    </div>
    </section>
</div>
