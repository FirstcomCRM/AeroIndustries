<?php

use yii\helpers\ArrayHelper;
use common\models\Stock;
use common\models\PurchaseOrder;

?>
<table id="backgroundTable" width="100%" bgcolor="#f9f9f9" cellpadding="0" cellspacing="0" border="0" style="font-family: Tahoma">
    <tbody>
      <tr>
          <td valign="bottom" style="padding:20px 16px 12px;text-align:left;">
            <p style="font-size:16px">Stock (insert PO number something)something has been received</p>
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
                                  <td colspan=4 style="text-align:center;padding:5px">PO ORDER SOMETHING</td>
                                </tr>
                                  <tbody>
                                    <tr>
                                      <th style="padding:5px">Supplier</th>
                                      <td style="padding:5px">dasdad</td>
                                      <th style="padding:5px">Payment Currency</th>
                                      <td style="padding:5px">DAta</td>
                                    </tr>
                                    <tr>
                                      <th style="padding:5px">Date Issued</th>
                                      <td style="padding:5px">dasdad</td>
                                      <th style="padding:5px">Delivery Date</th>
                                      <td style="padding:5px">DAta</td>
                                    </tr>
                                    <tr>
                                      <th style="padding:5px">Status</th>
                                      <td style="padding:5px">dasdad</td>
                                      <th style="padding:5px">Remarks</th>
                                      <td style="padding:5px">DAta</td>
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
                                    <th style="padding:5px">Batch/Lot</th>
                                    <th style="padding:5px">Shell Life</th>
                                  </tr>

                                <tbody>
                                  <tr>
                                    <td style="padding:5px">13242</td>
                                    <td style="padding:5px">asdada</td>
                                    <td style="padding:5px">5</td>
                                    <td style="padding:5px">333</td>
                                    <td style="padding:5px">-1</td>
                                  </tr>

                                </tbody>
                            </table>

                          </td>
                      </tr>
                  </tbody>
              </table>
        </tr>

    </tbody>
</table>
