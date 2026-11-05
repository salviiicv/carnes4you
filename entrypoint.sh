#!/bin/bash

php artisan migrate --force --seed

exec apache2-foreground