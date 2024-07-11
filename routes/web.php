<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\Question;
use App\Models\Form;
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

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Route::get('/form', function () {
//     return view('user.form');
// });

// Route::post('/forms', function (Request $request) {


//     $data = $request->json()->all();
//     Log::info("logg info", $request->json()->all());

//     $title = $data[0]['title'];
//     $description = $data[0]['description'];
//     if(!$description){
//         $description = "";
//     }
//     // dump($title, $description);

//     $form = Form::create([
//         'name' => $title,
//         'user_id' => 1,
//         'description' => $description,
//         'published' => true,
//     ]);
//     // dump($form);
//     $form_id = $form->id;

//     for ($i = 1; $i < count($data); $i++) {
//         if ($data[$i]['question_type'] === 'short_text') {
//             $question = Question::create([
//                 'form_id' => $form_id,
//                 'type' => 1,
//                 'name' => $data[$i]['question_text'],
//                 'options' => json_encode([]),
//                 'required' => $data[$i]['required'],
//             ]);
//             dump($question);
//         } else if ($data[$i]['question_type'] === 'long_text') {
//             $question = Question::create([
//                 'form_id' => $form_id,
//                 'type' => 2,
//                 'name' => $data[$i]['question_text'],
//                 'options' => json_encode([]),
//                 'required' => $data[$i]['required'],
//             ]);
//             dump($question);
//         } else if ($data[$i]['question_type'] === 'multiple-choice') {
//             $options = [];
//             foreach ($data[$i]['options'] as $option) {
//                 array_push($options, $option);
//             }
//             $question = Question::create([
//                 'form_id' => $form_id,
//                 'type' => 3,
//                 'name' => $data[$i]['question_text'],
//                 'options' => json_encode($options),
//                 'required' => $data[$i]['required'],
//             ]);
//             dump($question);
//         } else if ($data[$i]['question_type'] === 'drop-down') {
//             $options = [];
//             foreach ($data[$i]['options'] as $option) {
//                 array_push($options, $option);
//             }
//             $question = Question::create([
//                 'form_id' => $form_id,
//                 'type' => 4,
//                 'name' => $data[$i]['question_text'],
//                 'options' => json_encode($options),
//                 'required' => $data[$i]['required'],
//             ]);
//             dump($question);
//         } else if ($data[$i]['question_type'] === 'checkbox') {
//             $options = [];
//             foreach ($data[$i]['options'] as $option) {
//                 array_push($options, $option);
//             }
//             $question = Question::create([
//                 'form_id' => $form_id,
//                 'type' => 5,
//                 'name' => $data[$i]['question_text'],
//                 'options' => json_encode($options),
//                 'required' => $data[$i]['required'],
//             ]);
//             dump($question);
//         }
//     }



//     return response()->json(['message' => 'Form data saved successfully'], 200);
// });
