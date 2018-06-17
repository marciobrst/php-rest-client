<?php
require_once('RestClient.php'); 


$base = 'https://jsonplaceholder.typicode.com';
$client = new RestClient($base);

//Exemplo de post
$path = '/posts';
$data = array("title" => "save post", "body" => "create test");
$response = $client->post($path, $data);
print_r($response);

//Exemplo de get
$path = "/posts/1";
$response = $client->get($path);
print_r($response);

//Exemplo de put
$path = "/posts/1";
$data = array("title" => "update post", "body" => "update test");
$response = $client->put($path, $data);
print_r($response);

$path = "/posts/1";
$response = $client->delete($path);
print_r($response);

?>