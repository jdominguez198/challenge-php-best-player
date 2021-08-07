# Best Multi-eSports Player

## Introduction

This repository is a Challenge for a PHP Developer position.

## Run the Application

### Install dependencies

Under `src/` directory, run the following command:

```
composer install
```

### Run the Challenge script

Once you have installed the dependencies, you just have to run the command:

```
php index.php
```

### Run tests

To run the unit tests, type the command under `src/` directory too:

```
vendor/bin/phpunit
```

## Run the Application using Docker

### Install dependencies

Under root directory (where you have the `docker-compose.yaml` file), run the command:

```
docker-compose run --rm composer install
```

### Run the Challenge script

```
docker-compose run --rm app
```

### Run tests

```
docker-compose run --rm tests
```
