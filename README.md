# php-rest-client

PHP-Rest-Client is a lightweight client for REST services for PHP applications. The PHP-Rest-Client is licensed under the Apache Licence, Version 2.0 (http://www.apache.org/licenses/LICENSE-2.0.html)

# simple example
```php
require_once('RestClient.php'); 
$server = 'https://httpbin.org';
$path = '/get';
$client = new RestClient($server);
$response = $client->get($path);
```

# simple with autorization
```php
require_once('RestClient.php'); 
$server = ''; //your server
$path = '/get';
$headers = array('Autorization' => 'Bear XXXXX'); //your token
$client = new RestClient($server);
$response = $client->get($path, null, $headers);
```
