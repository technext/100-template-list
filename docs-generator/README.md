Documentation generator
==================================

# Docker #

Simply `cd` to this directory and run `docker-compose up -d`. This will initialise and start all the containers, then leave them running in the background.

## Services exposed outside your environment ##

You can access your application via **`localhost`**.

Service|Address outside containers
------|---------
Webserver|[localhost:8080](http://localhost:8080)

## Hosts within your environment ##

You'll need to configure your application to use any services you enabled:

Service|Hostname|Port number
------|---------|-----------
php-fpm|php-fpm|9000

