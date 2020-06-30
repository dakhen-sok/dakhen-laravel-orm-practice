<?php

use Illuminate\Support\Facades\Route;
use App\User;
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
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/getalluser', function(){
    $user = User::find(1);
    foreach($user as $usr){
        echo $usr;
    }
});

Route::get('/getById', 'HomeController@getUser');

Route::get('/read', function(){
    $result = DB::select('select * from users');
    foreach ( $result as $data){
        echo "Name is: ".$data->name . " and email is: ". $data->email . "<br/>";
    }
});

Route::get('/insert', function(){
    DB::insert('insert into users(name, email, password) values (?,?,?)',['test','test@gmail.com','123123']);
    echo "insert success";
});

