<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Form;
use App\Models\Question;
use App\Models\Response;
use App\Models\Answer;

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



        return response()->json(['message' => 'Form data saved successfully'], 200);
    }

    public function destroy(Request $request, $id)
    {
        $user = Auth::user();
        $form = Form::findOrFail($id);

        $form->delete();
        $forms = Form::all();
        return view('home', compact(['user', 'forms']));
    }

    public function toggle($id)
    {
        $user = Auth::user();
        $form = Form::findOrFail($id);
        $form->published = ($form->published === 1) ? 0 : 1;
        $form->save();
        return view('user.responses', compact(['user', 'form']));
    }

    public function response($id)
    {
        $user = Auth::user();
        $form = Form::findOrFail($id);
        // $responses = $form->responses()->
        return view('user.responses', compact(['form']));
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
                $text = $request["1" . $i];
                $answer = Answer::create([
                    'response_id' => $response->id,
                    'question_id' => $question->id,
                    'answer' => $text,
                ]);
            } else if ($question->type == 2) {
                $text = $request["2" . $i];
                $answer = Answer::create([
                    'response_id' => $response->id,
                    'question_id' => $question->id,
                    'answer' => $text,
                ]);
            } else if ($question->type == 3) {
                $optionNumber = $request["3" . $i];
                $answer = Answer::create([
                    'response_id' => $response->id,
                    'question_id' => $question->id,
                    'answer' => $optionNumber,
                ]);
            } else if ($question->type == 4) {
                $optionNumber = $request["4" . $i];
                $answer = Answer::create([
                    'response_id' => $response->id,
                    'question_id' => $question->id,
                    'answer' => $optionNumber,
                ]);
            } else if ($question->type == 5) {
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

            $i++;
        }

        return view('user.form-submitted', compact('form'));
    }
}
