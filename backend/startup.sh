#!/bin/bash

cd /app

php artisan migrate &

php artisan serve --host=0.0.0.0 --port=8000