<?php 

    if ( !empty ( $template ) ) {
        $data = $template->id;
    } else {
        $data = false;
    }

echo $data;