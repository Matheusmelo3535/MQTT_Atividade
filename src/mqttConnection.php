<?php

namespace MQTT;

require('../vendor/autoload.php');

use \PhpMqtt\Client\MqttClient;
use \PhpMqtt\Client\ConnectionSettings;
use MQTT;


function executeMqtt()
{
    $server   = '127.0.0.1';
    $port     = 1883;
    $clientId = rand(5, 15);
    $username = 'mosquitto_user';
    $password = null;
    $clean_session = false;
  
    $connectionSettings  = new ConnectionSettings();
    $connectionSettings
    ->setUsername($username)
    ->setPassword(null)
    ->setKeepAliveInterval(60)
    ->setLastWillTopic('mosquitto/topic/last-will')
    ->setLastWillMessage('client disconnect')
    ->setLastWillQualityOfService(1);
  
  
    $mqtt = new MqttClient($server, $port, $clientId);
    
    $mqtt->connect($connectionSettings, $clean_session);
    printf("Cliente conectado\n");
  
    $mqtt->subscribe('mosquitto/topic', function ($topic, $message) {
        $url = "http://localhost:8000/mqttData";
        $curl = new curlPost($url);
        $curl->curlPostJson($message);
    }, 0);
  
    for ($i = 0; $i<= 0; $i++) {
      $payload = array(
      'date' => date('Y-m-d H:i:s')
    );
        $mqtt->publish(
      // topic
      'mosquitto/topic',
      // payload
      json_encode($payload),
      // qos
      1,
      // retain
      true
        );
        printf("msg $i send\n");
        sleep(1);
    }
    $mqtt->loop(true);
    
}
executeMqtt();
