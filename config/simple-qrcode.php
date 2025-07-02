<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Default QR Code Format
    |--------------------------------------------------------------------------
    */
    'format' => 'png',

    /*
    |--------------------------------------------------------------------------
    | Default Image Backend
    |--------------------------------------------------------------------------
    |
    | Simple QR Code provides various image backends to generate QR codes.
    | By default, it uses 'imagick' but you can change it to 'gd' if imagick
    | is not available on your system.
    |
    | Supported: "imagick", "gd"
    |
    */
    'image_backend' => 'gd',

    /*
    |--------------------------------------------------------------------------
    | Default Absolute Path to Fonts Directory
    |--------------------------------------------------------------------------
    */
    'fonts_path' => base_path('vendor/simplesoftwareio/simple-qrcode/src/SimpleSoftwareIO/QrCode/Generator/fonts/'),
];
