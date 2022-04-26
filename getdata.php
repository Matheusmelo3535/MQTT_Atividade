<?php

$filename = dirname(__FILE__)."/dadosMqtt.json";

$lastmodif = isset($_GET['timestamp']) ? $_GET['timestamp']: 0 ;
$currentmodif =filemtime($filename);


while ($currentmodif <= $lastmodif) {
  usleep(10000);
  clearstatcache();
  $currentmodif = filemtime($filename);
 }
 
 $response = array();
 $response['msg'] = Date("h:i:s")." ".file_get_contents($filename);
 $response['timestamp'] = $currentmodif;
 echo json_encode($response);
?>