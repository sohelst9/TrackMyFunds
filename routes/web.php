<?php

use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});

// This route handles all GET requests to any path
Route::get('/{any}', function() {
    // Return the welcome view for the matched route
    return view('welcome');
})->where('any', '.*'); // Allow the 'any' parameter to match any characters



