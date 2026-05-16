<?php

return [

    /*
    | Max video upload size in kilobytes (Laravel "max" rule for files).
    | 204800 = 200 MB. Keep this at or below PHP post_max_size / upload_max_filesize.
    */
    'video_max_kb' => (int) env('COURSE_VIDEO_MAX_KB', 204800),

    'video_mimes' => 'mp4,webm,mov,avi,mkv',

    'thumbnail_max_kb' => (int) env('COURSE_THUMBNAIL_MAX_KB', 5120),

];
