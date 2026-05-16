# Dev server with higher PHP upload limits for course videos
php -d upload_max_filesize=256M -d post_max_size=260M -d max_execution_time=600 -d memory_limit=512M artisan serve @args
