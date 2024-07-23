#!/bin/bash
php /home/site/wwwroot/artisan queue:work --queue=low --sleep=3 --tries=3