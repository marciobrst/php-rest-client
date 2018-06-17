<?php

/*
 * Copyright 2018 <http://www.muiraquitec.com.br>.
 * Author: Márcio Braga dos Santos <https://github.com/marciobrst>.
 * 
 * Simple-REST - Lightweight PHP REST Library
 *
 * Licensed under the Apache License, Version 2.0 (the "License"); you may
 * not use this file except in compliance with the License. You may obtain
 * a copy of the License at
 *
 * http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS, WITHOUT
 * WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied. See the
 * License for the specific language governing permissions and limitations
 * under the License. 
 */

class RestClient {

  var $headers = array('Content-type: application/json');
  
  function __construct($base_url) {
    $this -> base_url = $base_url;
  }

  function put($path, $data = array(), $headers = array()) {
    $service_url = $this -> prepare_url($path);
    $curl = curl_init($service_url);     
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "PUT");
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);    
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($curl, CURLOPT_HTTPHEADER, $this -> prepare_headers($headers));
    $curl_response = curl_exec($curl);
    $this->check_response($curl);
    curl_close($curl);
    $decoded = json_decode($curl_response);
    return $decoded;
  }

  function delete($path, $query_array = array(), $headers = array()) {
    $service_url = $this -> prepare_url($path, $query_array);
    $curl = curl_init($service_url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "DELETE"); 
    curl_setopt($curl, CURLOPT_HTTPHEADER, $this -> prepare_headers($headers));
    $curl_response = curl_exec($curl);
    $this->check_response($curl);
    curl_close($curl);
    $decoded = json_decode($curl_response);
    return $decoded;
  }

  function post($path, $data = array(), $headers = array()) {   
    $service_url = $this -> prepare_url($path);
    $curl = curl_init($service_url);  
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_POST, true);
    curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($curl, CURLOPT_HTTPHEADER, $this -> prepare_headers($headers));
    $curl_response = curl_exec($curl);    
    $this->check_response($curl);
    curl_close($curl);
    $decoded = json_decode($curl_response);
    return $decoded;
  }

  function get($path, $query_array = null, $headers = array()) {    
    $service_url = $this -> prepare_url($path, $query_array);
    $curl = curl_init($service_url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $this -> prepare_headers($headers));
    $curl_response = curl_exec($curl);
    $this->check_response($curl);
    curl_close($curl);
    $decoded = json_decode($curl_response);    
    return $decoded;
  }

  private function prepare_headers($headers = array()) {
    return array_merge($this -> headers, $headers);
  }

  private function prepare_url($path, $query_array = null) {
    $service_url = $this -> base_url . $path;  
    if($query_array) {
      $query = http_build_query($query_array);  
      $service_url .= "?" . $query;
    }
    print_r($service_url);
    return $service_url;
  }

  private function check_response($curl) {    
    $info = curl_getinfo($curl);
    if ($info["http_code"] == 500) {
        curl_close($curl);
        throw new Exception('Error in service');
    } elseif ($info["http_code"] == 401) {
        curl_close($curl);
        throw new Exception('Not authorized');
    } elseif ($info["http_code"] == 404) {
        curl_close($curl);
        throw new Exception('Not found');
    }
  }
}



?>

