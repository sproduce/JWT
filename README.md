# JWT
Generate key for jwt authorization

ssh-keygen -t rsa -b 2048 -m PEM -f privare.key

openssl rsa -in private.key -pubout -outform PEM -out public.key
