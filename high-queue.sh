#!/bin/bash
php /home/site/wwwroot/artisan queue:work --queue=high --sleep=3 --tries=3
