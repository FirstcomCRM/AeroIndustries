<?php 

    $data = '';
    if ( !empty ( $getCapability ) ) {
        $data = 'Please select the part: <br>';
        foreach ( $getCapability as $gR ) {
            $data .= '<a href="javascript:woSelectPart(\''.$gR["part_no"].'\')">'.$gR["part_no"].'</a><br>';
        }
    } else {
        $data = 'No result found!';
    }

echo $data;