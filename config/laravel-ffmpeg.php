<?php

return [
    'ffmpeg' => [
        'binaries' => [
            'ffmpeg' => '/chemin/vers/ffmpeg',
        ],
        'threads' => 12,
    ],

    'ffprobe' => [
        'binaries' => [
            'ffprobe' => '/chemin/vers/ffprobe',
        ],
    ],

    'timeout' => 3600,

    'log_channel' => env('LOG_CHANNEL', 'stack'),

    'temporary_files_root' => env('FFMPEG_TEMPORARY_FILES_ROOT', sys_get_temp_dir()),

    'temporary_files_encrypted_hls' => env('FFMPEG_TEMPORARY_ENCRYPTED_HLS',
     env('FFMPEG_TEMPORARY_FILES_ROOT', sys_get_temp_dir())),
];

