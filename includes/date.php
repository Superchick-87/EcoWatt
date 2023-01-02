<?php
date_default_timezone_set('Europe/Paris');
// $date = date('dmY');
$jour = date('d-m-Y');
$date = date('d-m-Y', strtotime($jour. ' + 1 days'));
?>