<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use App\User;
use App\Model\Post;

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

Route::get('/update', function(){
 $affected = DB::update('update users set name = "DakhenUpdate" where id = ?',[2]);
 return "There is ".$affected." Updated.";
});

Route::get('/delete',function(){
    $deleted = DB::delete('delete from users where id=?', [2]);
    return "There is".$deleted." deleted";
});

Route::get('basicinsert',function(){
 $post = new Post;
 $post->title = 'New Eloquent title inserts here';
 $post->content = 'Eloquent is not difficult';
 $post->save();
});

Route::get('basicinsertupdate',function(){
    $post = Post::find(2);
    $post->title = 'New Eloquent title insert 2';
    $post->content = 'Eloquent is easy';
    $post->save();
});

Route::get('createmass', function(){
    Post::create(['title'=>'the create mass assignment',
    'content'=>'Here is the mass assignment createion']);
});

Route::get('/readall', function(){
    $posts = Post::all();
    foreach($posts as $post){
        echo "Read title".$post->time."content".$post->content."<br>";
    }
});

Route::get('find', function(){
    $post = Post::find(2);
    return "This is title".$post->title;
});

Route::get('/findwhere', function(){
    $posts = Post::where('id', 1)->orderBy('id', 'desc')->take(1)->get();
    foreach($posts as $post){
        echo $post->title.$post->content.$post->id;
    }
});

Route::get('findmore',function(){
    $post=Post::where('title', 'New Eloquent title inserts 2')->firstOrFail();
    return $posts;
});

Route::get('updateeloquent',function(){
    Post::where('id',3)->where('title','the create mass assignment')->update(['content'=>'This is updated from Eloquent',
    'title'=> 'the create mass assignment']);
});

Route::get('deleteeloquent', function(){
    $post=Post::find(3);
    $post->delete();
});

Route::get('destroyeloquent', function(){
    Post::destroy([3]);
});

Route::get('softdelete', function(){
    Post::find(5)->delete();
});

Route::get('readsoftdelete', function(){
    $posts = Post::onlyTrashed()->get();
    foreach($posts as $post){
        echo "Read title:".$post->time."content:".$post->content."deleted at".$post->deleted_at."<br>";
    }
});

Route::get('restore', function(){
    Post::withTrashed()->restore();
});

Route::get('getrestore', function(){
    Post::withTrashed()->where('id',5)->restore();
});

Route::get('forcedelete', function(){
    Post::withTrashed()->where('id', 5)->forceDelete();
});