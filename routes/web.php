<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/*Route::get('/', function () {
    return view('welcome');
})->middleware(['auth.shopify'])->name('home');*/


Route::middleware(['auth.shopify'])->group(function () {
    Route::get('/', function () {
        $shop = Auth::user();
        $domain = $shop->getDomain()->toNative();
        $webhooks = $shop->api()->rest('GET', '/admin/webhooks.json')['body']['container']['webhooks'];
        echo '<pre> all webhooks registered';
        print_r($webhooks);
        echo '</pre>';
        $scripts = $shop->api()->rest('GET', '/admin/script_tags.json')['body']['container']['script_tags'];
        echo '<pre> all script which I added';
        print_r($scripts);
        echo '</pre>';
        die();
        
        die();
        return view('welcome');
    })->name('home');

    // Other routes that need the shop user
});


//This will redirect user to login page.
Route::get('/login', function () {
    if (\Illuminate\Support\Facades\Auth::user()) {
        return redirect()->route('home');
    }
    return view('login');
})->name('login');