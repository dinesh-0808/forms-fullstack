<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Form;
use App\Models\Question;
use App\Models\Response;
use App\Models\Answer;
use Illuminate\Support\Facades\Log;

class FormController extends Controller
{
    //

    public function index()
    {
        $user = Auth::user();

        return view('user.form', compact('user'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $data = $request->json()->all();
        // Log::info("logg info", $request->json()->all());

        $title = $data[0]['title'];
        $description = $data[0]['description'];
        if (!$description) {
            $description = "";
        }
        // dump($title, $description);

        $form = Form::create([
            'name' => $title,
            'user_id' => $user->id,
            'description' => $description,
            'published' => true,
        ]);
        // dump($form);
        $form_id = $form->id;

        for ($i = 1; $i < count($data); $i++) {
            if ($data[$i]['question_type'] === 'short_text') {
                $question = Question::create([
                    'form_id' => $form_id,
                    'type' => 1,
                    'name' => $data[$i]['question_text'],
                    'options' => [],
                    'required' => $data[$i]['required'],
                ]);
                // dump($question);
            } else if ($data[$i]['question_type'] === 'long_text') {
                $question = Question::create([
                    'form_id' => $form_id,
                    'type' => 2,
                    'name' => $data[$i]['question_text'],
                    'options' => [],
                    'required' => $data[$i]['required'],
                ]);
                // dump($question);
            } else if ($data[$i]['question_type'] === 'multiple-choice') {
                $options = [];
                foreach ($data[$i]['options'] as $option) {
                    array_push($options, $option);
                }
                $question = Question::create([
                    'form_id' => $form_id,
                    'type' => 3,
                    'name' => $data[$i]['question_text'],
                    'options' => $options,
                    'required' => $data[$i]['required'],
                ]);
                // dump($question);
            } else if ($data[$i]['question_type'] === 'drop-down') {
                $options = [];
                foreach ($data[$i]['options'] as $option) {
                    array_push($options, $option);
                }
                $question = Question::create([
                    'form_id' => $form_id,
                    'type' => 4,
                    'name' => $data[$i]['question_text'],
                    'options' => $options,
                    'required' => $data[$i]['required'],
                ]);
                // dump($question);
            } else if ($data[$i]['question_type'] === 'checkbox') {
                $options = [];
                foreach ($data[$i]['options'] as $option) {
                    array_push($options, $option);
                }
                $question = Question::create([
                    'form_id' => $form_id,
                    'type' => 5,
                    'name' => $data[$i]['question_text'],
                    'options' => $options,
                    'required' => $data[$i]['required'],
                ]);
                // dump($question);
            }
        }

        session()->flash('form-create-message',"Form: $form->name created successfully!!");

        return response()->json(['message' => 'Form data saved successfully'], 200);
    }

    public function edit($id)
    {
        $form = Form::findOrFail($id);
        return view('user.form-edit',compact(['form']));
    }

    public function update($id, Request $request){
        $user = Auth::user();
        $data = $request->json()->all();
        // dd("fkdjsdafkljdslkf",$data);
        // Log::info("logg info", $request->json()->all());
        $form = Form::findOrFail($id);
        $form->questions()->delete();
        // dump($data[1]['title']);
        $title = $data[1]['title'];
        $description = $data[1]['description'];
        if (!$description) {
            $description = "";
        }
        // dd($description);

        $form_id = $form->id;
        $form->name = $title;
        $form->description = $description;
        // dd($form);
        for ($i = 2; $i < count($data); $i++) {
            if ($data[$i]['question_type'] === 'short_text') {
                $question = Question::create([
                    'form_id' => $form_id,
                    'type' => 1,
                    'name' => $data[$i]['question_text'],
                    'options' => [],
                    'required' => $data[$i]['required'],
                ]);
                // dump($question);
            } else if ($data[$i]['question_type'] === 'long_text') {
                $question = Question::create([
                    'form_id' => $form_id,
                    'type' => 2,
                    'name' => $data[$i]['question_text'],
                    'options' => [],
                    'required' => $data[$i]['required'],
                ]);
                // dump($question);
            } else if ($data[$i]['question_type'] === 'multiple-choice') {
                $options = [];
                foreach ($data[$i]['options'] as $option) {
                    array_push($options, $option);
                }
                $question = Question::create([
                    'form_id' => $form_id,
                    'type' => 3,
                    'name' => $data[$i]['question_text'],
                    'options' => $options,
                    'required' => $data[$i]['required'],
                ]);
                // dump($question);
            } else if ($data[$i]['question_type'] === 'drop-down') {
                $options = [];
                foreach ($data[$i]['options'] as $option) {
                    array_push($options, $option);
                }
                $question = Question::create([
                    'form_id' => $form_id,
                    'type' => 4,
                    'name' => $data[$i]['question_text'],
                    'options' => $options,
                    'required' => $data[$i]['required'],
                ]);
                // dump($question);
            } else if ($data[$i]['question_type'] === 'checkbox') {
                $options = [];
                foreach ($data[$i]['options'] as $option) {
                    array_push($options, $option);
                }
                $question = Question::create([
                    'form_id' => $form_id,
                    'type' => 5,
                    'name' => $data[$i]['question_text'],
                    'options' => $options,
                    'required' => $data[$i]['required'],
                ]);
                // dump($question);
            }
        }
        $form->save();
        session()->flash('form-create-message',"Form: $form->name updated successfully!!");

        return response()->json(['message' => 'Form data updated successfully'], 200);


    }

    public function destroy(Request $request, $id)
    {
        $user = Auth::user();
        $form = Form::findOrFail($id);

        $form->delete();
        $forms = Form::all();
        session()->flash('form-delete-message',"Form: $form->name deleted successfully!!");
        return view('home', compact(['user', 'forms']));
    }

    public function toggle($id)
    {
        $user = Auth::user();
        $form = Form::findOrFail($id);
        if($form->published === 1){
            $form->published = 0;
            // session()->flash('not-accept-message','form not accepting responses');
        }
        else {
            $form->published = 1;
            // session()->flash('accept-message','form accepting responses');
        }
        $form->save();
        $responses = $form->responses;
        return view('user.responses', compact(['user', 'form','responses']));
    }

    public function response($id)
    {
        $user = Auth::user();
        $form = Form::findOrFail($id);
        $responses = $form->responses()->paginate(1);
        // $responses = $form->responses()->
        return view('user.responses', compact(['form','responses']));
    }

    public function getResponse($id)
    {
        $user = Auth::user();
        $form = Form::findOrFail($id);

        return view('user.getResponse', compact(['user', 'form']));
    }

    public function saveResponse(Request $request, $id)
    {
        $user = Auth::user();
        $form = Form::findOrFail($id);
        // dump($request->all());
        $request = $request->all();
        $response = Response::create([
            'form_id' => $form->id,
            'user_id' => $user->id,
        ]);

        $questions = $form->questions()->orderBy('id', 'asc')->get();

        // dump($request["55"]);
        $i = 1;
        foreach ($questions as $question) {
            if ($question->type == 1) {
                if(isset($request["1" . $i])){
                    $text = $request["1" . $i];
                    $answer = Answer::create([
                        'response_id' => $response->id,
                        'question_id' => $question->id,
                        'answer' => $text,
                    ]);
                }
            } else if ($question->type == 2) {
                if(isset($request["2" . $i])){
                    $text = $request["2" . $i];
                    $answer = Answer::create([
                        'response_id' => $response->id,
                        'question_id' => $question->id,
                        'answer' => $text,
                    ]);
                }
            } else if ($question->type == 3) {
                if(isset($request["3" . $i])){
                    $optionNumber = $request["3" . $i];
                    $answer = Answer::create([
                        'response_id' => $response->id,
                        'question_id' => $question->id,
                        'answer' => $optionNumber,
                    ]);
                }
            } else if ($question->type == 4) {
                if(isset($request["4" . $i])){
                    $optionNumber = $request["4" . $i];
                    $answer = Answer::create([
                        'response_id' => $response->id,
                        'question_id' => $question->id,
                        'answer' => $optionNumber,
                    ]);
                }
            } else if ($question->type == 5) {
                if(isset($request["5" . $i])){
                    $optionsChecked = [];
                    $j = 0;
                    foreach ($request["5" . $i] as $opt) {
                        array_push($optionsChecked, $opt);
                        $j++;
                    }
                    // dd($optionsChecked);
                    $answer = Answer::create([
                        'response_id' => $response->id,
                        'question_id' => $question->id,
                        'answer' => $optionsChecked,
                    ]);
                }
            }

            $i++;
        }

        return view('user.form-submitted', compact('form'));
    }
}
