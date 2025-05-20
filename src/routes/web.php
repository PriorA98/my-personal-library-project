<?php
use App\Http\Controllers\ExportDownloadController;

Route::get('/', function () {
    return view('home');
});

Route::get('/exports/download', 'ExportDownloadController@__invoke')->name('exports.download');
