<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;


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


// Route::get('/', function () {
//     return view('frontend.connexion');
// });

// Route::get('/login', function () {
//     return view('frontend.connexion');
// });

// Route::get('/register', function () {
//     return view('frontend.register');
// });


Route::get('/', function () {
    return view('VueBackend.login');
});
Route::get('/login', function () {
    return view('VueBackend.login');
});
Route::get('/register', function () {
    return view('VueBackend.register');
});

Route::get('/dashbord', function () {
    return view('VueBackend.dashboard');
});

//bulletin
Route::get('/bulletin', function () {
    return view('frontend.bulletin');
});







Route::group(['namespace'	=>	"Connexion"], function(){
	Route::post("checkLogin", 'ConnexionController@checkLogin');
	// Route::post("register_count", 'ConnexionController@creationCompte');
	Route::get("logout", 'ConnexionController@logout');
	
	
});

Route::group(['namespace'	=>	"User"], function(){
	Route::post("insert_personne", 'UserController@insert_user');
	
});



Route::post('/register_count', function(Request $request){
	 $data = DB::insert('insert into users (name, email,password,remember_token,id_role,sexe,telephone,avatar) values (:name, :email,:password,:remember_token,:id_role,:sexe,:telephone,:avatar)', [
            ':name'             =>  $request->name, 
            ':email'            =>  $request->email,
            ':password'         =>  Hash::make($request->password),
            ':remember_token'   =>  Hash::make(rand(0,10)),
            ':id_role'          =>  2,
            ':sexe'             =>  $request->sexe,
            ':telephone'        =>  $request->telephone,
            ':avatar'           =>  "avatar.png"
        ]);

	 return response()->json([
	 	'data'		=>	"Création de compte avec succès",
	 	'success'	=>	$data
	 ]);
});




Route::get('/{any}', function () {
    return view('VueBackend.dashboard');
})->where('any', '.*');




