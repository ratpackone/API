BankT Prototype
================

Install
-------

Run Composer:

    $ composer install

Generate Key: (see [lexik/LexikJWTAuthenticationBundle](https://github.com/lexik/LexikJWTAuthenticationBundle/blob/v1.4.3/Resources/doc/index.md))

    $ mkdir -p app/var/jwt
    $ openssl genrsa -out app/var/jwt/private.pem -aes256 4096
    $ openssl rsa -pubout -in app/var/jwt/private.pem -out app/var/jwt/public.pem

Create a Google Cloud Messaging Key: see [https://developers.google.com/cloud-messaging/](https://developers.google.com/cloud-messaging/)

Create Database

    $ php bin/console doctrine:database:create
    $ php bin/console doctrine:schema:update -f
