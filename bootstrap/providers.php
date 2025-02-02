<?php

return [
    App\Providers\AppServiceProvider::class,
    App\Providers\AuthServiceProvider::class,
    Spatie\Activitylog\ActivitylogServiceProvider::class,
    Yajra\DataTables\DataTablesServiceProvider::class,
    Milon\Barcode\BarcodeServiceProvider::class,
    Mccarlosen\LaravelMpdf\LaravelMpdfServiceProvider::class,
    \Torann\GeoIP\GeoIPServiceProvider::class,
    Alexusmai\LaravelFileManager\FileManagerServiceProvider::class,
];

