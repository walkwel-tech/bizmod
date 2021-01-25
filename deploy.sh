#!/bin/bash

set -xe

FOLDER_NAME=laravel-argon

WEB_ROOT=/var/www/html

unzip -o ${FOLDER_NAME}.zip -d ${FOLDER_NAME}

sudo cp -r ${FOLDER_NAME}/* ${WEB_ROOT}/${FOLDER_NAME}/

rm -r ${FOLDER_NAME} ${FOLDER_NAME}.zip

cd ${WEB_ROOT}

sudo chown -R www-data:www-data ${FOLDER_NAME}

cd ${FOLDER_NAME}

sudo -u www-data bash -c 'composer install'
sudo -u www-data bash -c 'php artisan migrate --force'
sudo -u www-data bash -c 'php artisan clear'
sudo -u www-data bash -c 'php artisan cache:clear'
