<?php
use yii\helpers\Html;
 ?>

 <style>
   .p-image{
     display: block;
     margin: 0 auto;
   }
 </style>


<div class="part-image text-center">

  <?php if (empty($parts) ): ?>
  <h4>NO IMAGE ADDED</h4>
  <?php else: ?>
    <?php foreach ($parts as $value): ?>
      <?php echo Html::img('@web/'.$value['file_path'], ['class'=>'img-responsive p-image', 'width'=>'50%', 'height'=>'auto']) ?>
    <?php endforeach; ?>

  <?php endif; ?>



</div>
