<?php

use App\Mail\MailtrapExample;
use Illuminate\Support\Facades\Mail;
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

Route::get('/', function () {
    //return view('welcome');
    echo 'Hello';
});


Route::get('/send-mail', function () {
    Mail::to('newuser@example.com')->send(new MailtrapExample());
    return 'A message has been sent to Mailtrap!';
});
