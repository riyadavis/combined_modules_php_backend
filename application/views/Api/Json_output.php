<?php
    header('Access-Control-Allow-Origin: *');
    header('Content-type: application/json');    
    echo json_encode($items);
?>