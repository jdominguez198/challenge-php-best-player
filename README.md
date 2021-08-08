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

NOTE: You can use environment variables to change default options. These are:

- `SOURCE_DIRECTORY` => Define the path where the fileSets are. Default: `src/input`.
- `INPUT_FOLDER` => Define the folder there the `.csv` fileSets are. Default `challenge-csv-files`.
- `CSV_SEPARATOR` => Define the separator used to import the `.csv` files. Default `;`.

Example: I've provided two fileSets more, called `working-solution-1` and `working-solution-2`.
So for run the application use one of these sets, you will type:

```
INPUT_FOLDER=working-solution-1 php index.php
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

NOTE: You can use environment variables to change default options. These are:

- `SOURCE_DIRECTORY` => Define the path where the fileSets are. Default: `src/input`.
- `INPUT_FOLDER` => Define the folder there the `.csv` fileSets are. Default `challenge-csv-files`.
- `CSV_SEPARATOR` => Define the separator used to import the `.csv` files. Default `;`.

Example: I've provided two fileSets more, called `working-solution-1` and `working-solution-2`.
So for run the application use one of these sets, you will type:

```
INPUT_FOLDER=working-solution-2 docker-compose run --rm app
```

### Run tests

```
docker-compose run --rm tests
```
