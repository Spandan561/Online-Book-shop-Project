<?php
function is_empty($var, $text, $location, $ms, $data){
    if(empty($var)){
        #erreor msg
        $em = "The ".$text." is required";
        header("Location: $location?$ms=$em&$data");
        exit;
    }
    return 0;
}
?>