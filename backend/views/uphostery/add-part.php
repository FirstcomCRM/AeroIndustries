<?php 
    $returndata = '';
    if ( !empty ( $data ) ) {
        $n = $data['n'];

        $returndata = "
        	<tr class='part-$n'>
        		<td>
                    <span class='display-part-no-$n'>" . $data['part_no'] . "</span>" ;
                    foreach ($data as $variableName => $value) {
                        $returndata .= "<input type='hidden' placeholder='$variableName' id='added-$variableName' name='UphosteryPart[$variableName][]' class='edit-$variableName-$n' value='$value'>";
                    }        
        $returndata .="
                </td>
                <td class='display-manufacturer-$n'>
                    " . $data['manufacturer'] . "
                </td>
                <td class='display-model-$n'>
                    " . $data['model'] . "
                </td>
                <td class='display-quantity-$n'>
        			" . $data['quantity'] . "
        		</td>
                <td>
                    <button type='button' class='btn btn-warning' onclick='editUpPart($n)'>Edit</button>
                    <button type='button' class='btn btn-danger' onclick='removeUpPart($n)'>Remove</button>
                </td>
        	</tr>
    	";
    } else {
        $returndata = '';
    }
echo json_encode($returndata);