<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Snappy PDF / Image Configuration
    |--------------------------------------------------------------------------
    |
    | This option contains settings for PDF generation.
    |
    | Enabled:
    |    
    |    Whether to load PDF / Image generation.
    |
    | Binary:
    |    
    |    The file path of the wkhtmltopdf / wkhtmltoimage executable.
    |
    | Timout:
    |    
    |    The amount of time to wait (in seconds) before PDF / Image generation is stopped.
    |    Setting this to false disables the timeout (unlimited processing time).
    |
    | Options:
    |
    |    The wkhtmltopdf command options. These are passed directly to wkhtmltopdf.
    |    See https://wkhtmltopdf.org/usage/wkhtmltopdf.txt for all options.
    |
    | Env:
    |
    |    The environment variables to set while running the wkhtmltopdf process.
    |
    */
    
    'pdf' => array(
        'enabled' => true,
        // 'binary' =>  "C:\Progra~1\wkhtmltopdf\bin\wkhtmltopdf.exe",
        // 'binary' => base_path('vendor/wemersonjanuario/wkhtmltopdf-windows/bin/64bit/wkhtmltopdf'),
         'binary' => '/app/vendor/bin/wkhtmltopdf-amd64',
        'timeout' => false,
        'images' => true,
        'options' => [
            'enable-local-file-access' => true,
            'images' => true,
            'orientation'   => 'landscape',
            'encoding'      => 'UTF-8'
        ],
        'env' => array(),
    ),
    'image' => array(
        'enabled' => true,
        // 'binary' => "C:\Progra~1\wkhtmltopdf\bin\wkhtmltoimage.exe",
        // 'binary' => 'vendor\wemersonjanuario\wkhtmltopdf-windows\bin\64bit\wkhtmltoimage',
        'binary' => '/app/vendor/bin/wkhtmltoimage-amd64',
        'timeout' => false,
        'options' => [
            'enable-local-file-access' => true,
            'images' => true,
            'orientation'   => 'landscape',
            'encoding'      => 'UTF-8'
         ],
        'env' => array(),
    ), 'env'     => [],
];
