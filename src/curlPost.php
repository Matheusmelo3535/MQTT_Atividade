<?php

namespace MQTT;


class curlPost {
    public $url;
    
    public function __construct($url) {
        $this->url = $url;
    }
    
    public function curlPostJson($message) {
        $url = $this->url;
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, $message);
        $resp = curl_exec($curl);
        var_dump($resp);
        curl_close($curl);
    }
    
}