#!/bin/bash
php /home/site/wwwroot/artisan queue:work --queue=medium --sleep=3 --tries=3