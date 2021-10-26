
# Store Web Api

## Overview

1. [Install prerequisites](#install-prerequisites)

   Before installing project make sure the following prerequisites have been met.

2. [Clone the project](#clone-the-project)

   We’ll download the code from its repository on GitHub.

5. [Run the application](#run-the-application)

   By this point we’ll have all the project pieces in place.
___

## Install prerequisites

For now, this project has been mainly created for Unix `(Linux/MacOS)`. Perhaps it could work on Windows.

All requisites should be available for your distribution. The most important are :

* [Git](https://www.digitalocean.com/community/tutorials/how-to-install-git-on-ubuntu-20-04)
* [Docker](https://www.digitalocean.com/community/tutorials/how-to-install-and-use-docker-on-ubuntu-18-04)
* [Docker Compose](https://www.digitalocean.com/community/tutorials/how-to-install-and-use-docker-compose-on-ubuntu-20-04)

Check if `docker-compose` is already installed by entering the following command :

```sh
which docker-compose
```

Check Docker Compose compatibility :

* [Compose file version 3 reference](https://docs.docker.com/compose/compose-file/)

The following is optional but makes life more enjoyable :

```sh
which make
```

On Ubuntu and Debian these are available in the meta-package build-essential. On other distributions, you may need to install the GNU C++ compiler separately.

```sh
sudo apt install build-essential
```

### Images to use

* [Nginx](https://hub.docker.com/_/nginx/)
* [MySQL](https://hub.docker.com/_/mysql/)
* [PHP-FPM](https://hub.docker.com/r/nanoninja/php-fpm/)

You should be careful when installing third party web servers such as MySQL or Nginx.

This project use the following ports :

| Server     | Port |
|------------|------|
| MySQL      | 33065 |
| Nginx      | 8001 |
| php        | 9001 |


___

## Clone the project

To install [Git](http://git-scm.com/book/en/v2/Getting-Started-Installing-Git), download it and install following the instructions :

```sh
git clone https://github.com/sjavadez/store
```

### Project tree

```sh
.
├── Docker
│   └── data
│       ├── mysql
│   └── mysql
│       ├── .env
│       └── .env.example
│   └── nginx
│       └── conf.d
│            ├── dumps
│       └── Dockerfile
│   └── php
│       └── supervisor
│            ├── conf
│       └── Dockerfile
└── web
    └── public
        └── index.php
├── docker-compose.yml
├── README.md
        
```

___

[comment]: <> (## Configure Xdebug)

[comment]: <> (If you use another IDE than [PHPStorm]&#40;https://www.jetbrains.com/phpstorm/&#41; or [Netbeans]&#40;https://netbeans.org/&#41;, go to the [remote debugging]&#40;https://xdebug.org/docs/remote&#41; section of Xdebug documentation.)

[comment]: <> (For a better integration of Docker to PHPStorm, use the [documentation]&#40;https://github.com/nanoninja/docker-nginx-php-mysql/blob/master/doc/phpstorm-macosx.md&#41;.)

[comment]: <> (1. Get your own local IP address :)

[comment]: <> (    ```sh)

[comment]: <> (    sudo ifconfig)

[comment]: <> (    ```)

[comment]: <> (2. Edit php file `etc/php/php.ini` and comment or uncomment the configuration as needed.)

[comment]: <> (3. Set the `remote_host` parameter with your IP :)

[comment]: <> (    ```sh)

[comment]: <> (    xdebug.remote_host=192.168.0.1 # your IP)

[comment]: <> (    ```)

[comment]: <> (___)

## Run the application

1. Copying the composer configuration file :

    ```sh
    cp web/.env.example web/.env
    cp Docker/mysql/.env.example Docker/mysql/.env
    ```

2. Start the application :

    ```sh
    docker-compose up -d --build
    ```

   **Please wait this might take a several minutes...**

    ```sh
    docker-compose logs -f # Follow log output
    ```
3. start  services supervisor

    ```sh
    docker exec  -it store_php service supervisor start
    ```
4. run migration

    ```sh
    docker exec  -it store_php php artisan migrate
    ```
5. Stop and clear services

    ```sh
    sudo docker-compose down -v
    ```

___

[comment]: <> (## Use Makefile)

[comment]: <> (When developing, you can use [Makefile]&#40;https://en.wikipedia.org/wiki/Make_&#40;software&#41;&#41; for doing the following operations :)

[comment]: <> (| Name          | Description                                  |)

[comment]: <> (|---------------|----------------------------------------------|)

[comment]: <> (| apidoc        | Generate documentation of API                |)

[comment]: <> (| clean         | Clean directories for reset                  |)

[comment]: <> (| code-sniff    | Check the API with PHP Code Sniffer &#40;`PSR2`&#41; |)

[comment]: <> (| composer-up   | Update PHP dependencies with composer        |)

[comment]: <> (| docker-start  | Create and start containers                  |)

[comment]: <> (| docker-stop   | Stop and clear all services                  |)

[comment]: <> (| gen-certs     | Generate SSL certificates for `nginx`        |)

[comment]: <> (| logs          | Follow log output                            |)

[comment]: <> (| mysql-dump    | Create backup of all databases               |)

[comment]: <> (| mysql-restore | Restore backup of all databases              |)

[comment]: <> (| phpmd         | Analyse the API with PHP Mess Detector       |)

[comment]: <> (| test          | Test application with phpunit                |)

[comment]: <> (### Examples)

[comment]: <> (Start the application :)

[comment]: <> (```sh)

[comment]: <> (sudo make docker-start)

[comment]: <> (```)

[comment]: <> (Show help :)

[comment]: <> (```sh)

[comment]: <> (make help)

[comment]: <> (```)

[comment]: <> (___)

[comment]: <> (## Use Docker commands)

[comment]: <> (### Installing package with composer)

[comment]: <> (```sh)

[comment]: <> (sudo docker run --rm -v $&#40;pwd&#41;/web/app:/app composer require symfony/yaml)

[comment]: <> (```)

[comment]: <> (### Updating PHP dependencies with composer)

[comment]: <> (```sh)

[comment]: <> (sudo docker run --rm -v $&#40;pwd&#41;/web/app:/app composer update)

[comment]: <> (```)

[comment]: <> (### Generating PHP API documentation)

[comment]: <> (```sh)

[comment]: <> (sudo docker-compose exec -T php php -d memory_limit=256M -d xdebug.profiler_enable=0 ./app/vendor/bin/apigen generate app/src --destination ./app/doc)

[comment]: <> (```)

[comment]: <> (### Testing PHP application with PHPUnit)

[comment]: <> (```sh)

[comment]: <> (sudo docker-compose exec -T php ./app/vendor/bin/phpunit --colors=always --configuration ./app)

[comment]: <> (```)

[comment]: <> (### Fixing standard code with [PSR2]&#40;http://www.php-fig.org/psr/psr-2/&#41;)

[comment]: <> (```sh)

[comment]: <> (sudo docker-compose exec -T php ./app/vendor/bin/phpcbf -v --standard=PSR2 ./app/src)

[comment]: <> (```)

[comment]: <> (### Checking the standard code with [PSR2]&#40;http://www.php-fig.org/psr/psr-2/&#41;)

[comment]: <> (```sh)

[comment]: <> (sudo docker-compose exec -T php ./app/vendor/bin/phpcs -v --standard=PSR2 ./app/src)

[comment]: <> (```)

[comment]: <> (### Analyzing source code with [PHP Mess Detector]&#40;https://phpmd.org/&#41;)

[comment]: <> (```sh)

[comment]: <> (sudo docker-compose exec -T php ./app/vendor/bin/phpmd ./app/src text cleancode,codesize,controversial,design,naming,unusedcode)

[comment]: <> (```)

[comment]: <> (### Checking installed PHP extensions)

[comment]: <> (```sh)

[comment]: <> (sudo docker-compose exec php php -m)

[comment]: <> (```)

[comment]: <> (### Handling database)

[comment]: <> (#### MySQL shell access)

[comment]: <> (```sh)

[comment]: <> (sudo docker exec -it mysql bash)

[comment]: <> (```)

[comment]: <> (and)

[comment]: <> (```sh)

[comment]: <> (mysql -u"$MYSQL_ROOT_USER" -p"$MYSQL_ROOT_PASSWORD")

[comment]: <> (```)

[comment]: <> (#### Creating a backup of all databases)

[comment]: <> (```sh)

[comment]: <> (mkdir -p data/db/dumps)

[comment]: <> (```)

[comment]: <> (```sh)

[comment]: <> (source .env && sudo docker exec $&#40;sudo docker-compose ps -q mysqldb&#41; mysqldump --all-databases -u"$MYSQL_ROOT_USER" -p"$MYSQL_ROOT_PASSWORD" > "data/db/dumps/db.sql")

[comment]: <> (```)

[comment]: <> (#### Restoring a backup of all databases)

[comment]: <> (```sh)

[comment]: <> (source .env && sudo docker exec -i $&#40;sudo docker-compose ps -q mysqldb&#41; mysql -u"$MYSQL_ROOT_USER" -p"$MYSQL_ROOT_PASSWORD" < "data/db/dumps/db.sql")

[comment]: <> (```)

[comment]: <> (#### Creating a backup of single database)

[comment]: <> (**`Notice:`** Replace "YOUR_DB_NAME" by your custom name.)

[comment]: <> (```sh)

[comment]: <> (source .env && sudo docker exec $&#40;sudo docker-compose ps -q mysqldb&#41; mysqldump -u"$MYSQL_ROOT_USER" -p"$MYSQL_ROOT_PASSWORD" --databases YOUR_DB_NAME > "data/db/dumps/YOUR_DB_NAME_dump.sql")

[comment]: <> (```)

[comment]: <> (#### Restoring a backup of single database)

[comment]: <> (```sh)

[comment]: <> (source .env && sudo docker exec -i $&#40;sudo docker-compose ps -q mysqldb&#41; mysql -u"$MYSQL_ROOT_USER" -p"$MYSQL_ROOT_PASSWORD" < "data/db/dumps/YOUR_DB_NAME_dump.sql")

[comment]: <> (```)


[comment]: <> (#### Connecting MySQL from [PDO]&#40;http://php.net/manual/en/book.pdo.php&#41;)

[comment]: <> (```php)

[comment]: <> (<?php)

[comment]: <> (    try {)

[comment]: <> (        $dsn = 'mysql:host=mysql;dbname=test;charset=utf8;port=3306';)

[comment]: <> (        $pdo = new PDO&#40;$dsn, 'dev', 'dev'&#41;;)

[comment]: <> (    } catch &#40;PDOException $e&#41; {)

[comment]: <> (        echo $e->getMessage&#40;&#41;;)

[comment]: <> (    })

[comment]: <> (?>)

[comment]: <> (```)

[comment]: <> (___)

## Help us

Any thought, feedback or (hopefully not!)
