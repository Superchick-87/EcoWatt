<?php
function replaceHMaj($tring){
    $tring = str_replace(":","h",$tring);
    $tring = str_replace("00","",$tring);
    return $tring;
}
?>