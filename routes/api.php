<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


Route::get('/data', [ApiController::class, 'getData']);


Route::get('/images', function () {
    $files = Storage::files('public/images/'); // Get all files in 'public' directory
    
    $images = [];
    foreach ($files as $file) {
        $images[] = asset(str_replace('public', 'storage', $file));
    }

    return response()->json(['images' => $images]);
});

Route::get('/users', [ApiController::class, 'getusers']);
Route::get('/get-social-posts', [ApiController::class, 'getSocialPosts']);
Route::get('/getData', [ApiController::class, 'getData']);
Route::get('/get-science-posts', [ApiController::class, 'getSciencePosts']);
Route::post('/location', [ApiController::class, 'store']);
