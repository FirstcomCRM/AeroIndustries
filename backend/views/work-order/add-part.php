<?php 
    $returndata = '';
    if ( !empty ( $data ) ) {
        $n = $data['n'];

        $returndata = "
        	<tr class='part-$n'>
        		<td>
                    " . $data['part_no'] ;
                    foreach ($data as $variableName => $value) {
                        $returndata .= "<input type='hidden' placeholder='$variableName' id='added-$variableName' name='WorkOrderPart[$variableName][]' class='edit-$variableName-$n' value='$value'>";
                    }        
        $returndata .="
                </td>
                <td>
                    " . $data['manufacturer'] . "
                </td>
                <td>
                    " . $data['model'] . "
                </td>
        		<td>
        			" . $data['quantity'] . "
        		</td>
                <td>
                    <button type='button' onclick='editPart($n)'>Edit</button>
                    <button type='button' onclick='removePart($n)'>Remove</button>
                </td>
        	</tr>
    	";
    } else {
        $returndata = '';
    }
echo json_encode($returndata);