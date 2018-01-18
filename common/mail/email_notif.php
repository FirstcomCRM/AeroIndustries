<?php
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use common\models\Stock;
use common\models\PurchaseOrder;
use common\models\Supplier;
use common\models\Currency;
use common\models\Part;


$stocks = Stock::find()->where(['purchase_order_id'=>$purchaseOrder->id])->asArray()->all();
 ?>



 <table id="backgroundTable" width="100%" bgcolor="#f9f9f9" cellpadding="0" cellspacing="0" border="0" style="font-family: Tahoma">
     <tbody>
       <tr>
           <td valign="bottom" style="padding:20px 16px 12px;text-align:left;">
             <p style="font-size:16px">
               <?php  $number = PurchaseOrder::getPONo($purchaseOrder->purchase_order_no,$purchaseOrder->created)?>
               <?php echo $number ?> has been received.
             </p>
           </td>
       </tr>
         <tr>
             <td>
                 <table width="1000"  id="PO-details" cellpadding="32" cellspacing="0" border="0" align="center" class="devicewidth" style="background:white;border-radius:0.5rem;margin-bottom:1rem">
                     <tbody>
                         <tr>
                             <td width="100%"  valign="top">
                                	<table width="100%" cellpadding="5" cellspacing="0" border="1" align="center">
                                 <tr>
                                   <td colspan=4 style="text-align:center;padding:5px">PO ORDER DETAILS</td>
                                 </tr>
                                   <tbody>
                                     <tr>
                                       <th style="padding:5px">Supplier</th>
                                       <td style="padding:5px">
                                         <?php $supp = Supplier::find()->where(['id'=>$purchaseOrder->supplier_id])->one() ?>
                                         <?php echo $supp->company_name ?>
                                       </td>
                                       <th style="padding:5px">Payment Currency</th>
                                       <td style="padding:5px">
                                         <?php $curr = Currency::find()->where(['id'=>$purchaseOrder->p_currency])->one() ?>
                                         <?php echo $curr->iso ?>
                                       </td>
                                     </tr>
                                     <tr>
                                       <th style="padding:5px">Date Issued</th>
                                       <td style="padding:5px">
                                         <?php $date_issued = date('d M Y', strtotime($purchaseOrder->issue_date) ) ?>
                                         <?php echo $date_issued ?>
                                       </td>
                                       <th style="padding:5px">Delivery Date</th>
                                       <td style="padding:5px">
                                         <?php $delivery_date = date('d M Y', strtotime($purchaseOrder->delivery_date) ) ?>
                                         <?php echo $delivery_date ?>
                                       </td>
                                     </tr>
                                     <tr>
                                       <th style="padding:5px">Status</th>
                                       <td style="padding:5px">
                                           <?= $purchaseOrder->status == 1 ? "Paid" : "Unpaid" ?>
                                       </td>
                                       <th style="padding:5px">Remarks</th>
                                       <td style="padding:5px">
                                         <?= $purchaseOrder->remark ?>
                                       </td>
                                     </tr>

                                    </tbody>
 	                            </table>

                             </td>
                         </tr>
                     </tbody>
                 </table>

             </td>
         </tr>

         <tr>
               <table width="1000"  id="stock-details" cellpadding="32" cellspacing="0" border="0" align="center" class="devicewidth" style="background:white;border-radius:0.5rem;margin-bottom:1rem">
                   <tbody>
                       <tr>
                           <td width="100%"  valign="top">
                               <table width="100%" cellpadding="5" cellspacing="0" border="1" align="center">
                                   <tr>
                                     <th colspan=5 style="text-align:center;padding:5px">Stock Details</th>
                                   </tr>

                                   <tr>
                                     <th style="padding:5px">Part</th>
                                     <th style="padding:5px">Qty</th>
                                     <th style="padding:5px">Received</th>
                                     <th style="padding:5px">Batch No</th>
                                     <th style="padding:5px">Shell Life</th>
                                   </tr>

                                 <tbody>
                                   <?php foreach ($stocks as $key => $value): ?>
                                     <tr>
                                       <td style="padding:5px">
                                         <?php $parts = Part::find()->where(['id'=>$value['part_id'] ])->one() ?>
                                        <?php echo $parts->part_no ?>
                                       </td>
                                       <td style="padding:5px">
                                         <?php echo  $value['quantity']?>
                                       </td>
                                       <td style="padding:5px">
                                         <?php echo  $value['quantity']?>
                                       </td>
                                       <td style="padding:5px">
                                          <?php echo  $value['batch_no']?>
                                       </td>
                                       <td style="padding:5px">
                                           <?php echo  $value['shelf_life']?>
                                       </td>
                                     </tr>

                                   <?php endforeach; ?>

                                 </tbody>
                             </table>

                           </td>
                       </tr>
                   </tbody>
               </table>
         </tr>

     </tbody>
 </table>
