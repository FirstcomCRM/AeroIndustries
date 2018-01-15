<?php

use yii\helpers\ArrayHelper;
use common\models\Part;
?>
<table id="backgroundTable" width="100%" bgcolor="#f9f9f9" cellpadding="0" cellspacing="0" border="0" style="font-family: Arial">
    <tbody>
        <tr>
            <td valign="bottom" style="padding:20px 16px 12px;text-align:left;">
				
				<p style="font-size:18px">Hi Sir/Ms,</p>
                
                <h3 style="color:#2ab27b;line-height:30px;margin-bottom:12px;margin:0 0 12px">The following tools need to be calibrated soon!</h3>
                
            </td>
        </tr>
        <tr>
            <td>
                <table width="846" cellpadding="32" cellspacing="0" border="0" align="center" class="devicewidth" style="background:white;border-radius:0.5rem;margin-bottom:1rem">
                    <tbody>
                        <tr>
                            <td width="100%" align="left" valign="top">
                               	
                               	<table width="100%" cellpadding="0" cellspacing="0" border="0" align="center">
                               		<thead>
                                        <th align="left" style="padding: 5px 0">Tool</th>
                                        <th align="left" style="padding: 5px 0">Description</th>
                                        <th align="center" style="padding: 5px 0">Last Calibration Date</th>
                                        <th align="center" style="padding: 5px 0">Next Calibration Date</th>
                                    </thead>	
	                                <tbody>
                    				<?php foreach ( $toolCalibration as $cali) {  ?>
                                        <tr>
                                            <td><?=Part::dataPart()[$cali->part_id]?></td>
                                            <td><?=$cali->desc?></td>
                                            <td><?=$cali->last_cali?></td>
                                            <td><?=$cali->next_cali?></td>
                                        </tr>
                                    <?php } /* foreach */ ?>
	                                </tbody>
	                            </table>
                                Click <a href="http://localhost/aero/?r=tool/tool">HERE</a> to check the tools
                            </td>
                        </tr>
                    </tbody>
                </table>
                
            </td>
        </tr>
        <tr>
            <td valign="bottom" style="font-size:12px;color:#989ea6;padding:10px 16px 30px;text-align:center;">
                Aero Industries &copy; All right reserved.
            </td>
        </tr>
    </tbody>
</table> 	