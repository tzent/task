#!/bin/bash

set -e

composer install --no-interaction
composer dump-autoload
php-fpm
