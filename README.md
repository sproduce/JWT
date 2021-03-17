# JWT

Generate key for jwt authorization

ssh-keygen -t rsa -b 2048 -m PEM -f private.key

openssl rsa -in private.key -pubout -outform PEM -out public.key

Installation
------------

Use composer to manage your dependencies and download JWT:

```bash
composer require sproduce/jwt
```

Example generate JWT access token
-------
```php
use\Sproduce\JWT\JWT


    JWT::loadPublicKeyFromFile("path to file");

    $date = new \DateTime();
    $date->modify('+7 day');
    $payload=array("exp"=>$date->getTimestamp(),
                   "iss"=>"some data"
                );
    $accessToken=JWT::encode($payload);

```