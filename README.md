# JWT

Generate key for jwt authorization

ssh-keygen -t rsa -b 2048 -m PEM -f private.key

openssl rsa -in private.key -pubout -outform PEM -out public.key

Installation
------------

Use composer to manage your dependencies and download PHP-JWT:

```bash
composer require sproduce/jwt
```

