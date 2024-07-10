<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\Question;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/form',function(){
    return view('user.form');
});

Route::middleware('web')->post('/forms',function(Request $request){
    // Log::info('Form data received:', $request->all());
    // dd($request->all());
    $data = $request->all();
    // dd($request->all(), $request->title);
    // $validatedData = $request->validate([
    //     'formData' => 'required|array',
    //     // Add more validation rules as needed
    // ]);
    // $data = json_encode($request->json->all());
    // $data = json_decode($data);
    // Log::info('Form data validated:', $data[0]);
    // foreach($request->json()->all() as $data){
    //     Log::info('for eahc', $data['title']);

    // }

    return response()->json(['message' => 'Form data saved successfully'], 200);
});
