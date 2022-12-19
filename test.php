<?php
$file = 'datas/datas.json'; 
// mettre le contenu du fichier dans une variable
$data = file_get_contents($file); 
// décoder le flux JSON
$obj = json_decode($data); 
// accéder à l'élément approprié

echo count($obj->signals)."</br>";

for ($i=0; $i < count($obj->signals); $i++) { 
    if ($i == 2) {
       echo $obj->signals[$i]->jour."</br>";
       echo $obj->signals[$i]->message."</br>";
        echo count($obj->signals[$i]->values)."</br>";
        for ($n=0; $n < count($obj->signals[$i]->values); $n++) { 
            // echo $obj->signals[$i]->values[$n]->pas."</br>";
            echo $obj->signals[$i]->values[$n]->hvalue."</br>";
        }
        for ($x=0; $x < count($obj->signals[$i]->values); $x++) { 
            echo $obj->signals[$i]->values[$x]->pas."</br>";
            // echo $obj->signals[$i]->values[$n]->hvalue."</br>";
        }
    }
}
?>