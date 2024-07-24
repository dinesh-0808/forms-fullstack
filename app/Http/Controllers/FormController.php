<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Form;
use App\Models\Question;
use App\Models\Response;
use App\Models\Answer;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response as FacadeResponse;
use Illuminate\Support\Facades\Validator;

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
        $data = $request->all();
        // Log::info("logg info", $request->json()->all());
        // dd($request->json()->all());
        $rules = [
            '0.title' => 'required|string|max:255',
            '0.description' => 'nullable|string|max:1000',
            '1.type' => 'required|integer|in:1,2,3,4,5',
            '1.name' => 'required|string|max:255',
            '1.options' => 'array',
            '1.options.*' => 'string|max:255',
            '1.required' => 'required|boolean',
        ];

        $messages = [
            '0.title.required' => 'The form title is required.',
            '0.title.string' => 'The form title must be a string.',
            '0.title.max' => 'The form title must not exceed 255 characters.',
            '0.description.string' => 'The description must be a string.',
            '0.description.max' => 'The description must not exceed 1000 characters.',
            '1.type.required' => 'The question type is required.',
            '1.type.in' => 'The question type must be one of: 1 (short text), 2 (long text), 3 (multiple choice), 4 (dropdown), or 5 (checkbox).',
            '1.name.required' => 'The question name is required.',
            '1.name.string' => 'The question name must be a string.',
            '1.name.max' => 'The question name must not exceed 255 characters.',
            '1.options.array' => 'The options must be an array.',
            '1.options.*.string' => 'Each option must be a string.',
            '1.options.*.max' => 'Each option must not exceed 255 characters.',
            '1.required.required' => 'The required field is required.',
            '1.required.boolean' => 'The required field must be true or false.'
        ];

        // Applying the same set of rules for all items starting from index 1
        for ($i = 1; $i < count($data); $i++) {
            $rules["$i.type"] = 'required|integer|in:1,2,3,4,5';
            $rules["$i.name"] = 'required|string|max:255';
            $rules["$i.options"] = 'array';
            $rules["$i.options.*"] = 'string|max:255';
            $rules["$i.required"] = 'required|boolean';
        }

        $validator = Validator::make($data, $rules, $messages);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $title = $data[0]['title'];
        $desc = $data[0]['description'];
        if (!$desc) {
            $desc = "";
        }
        $form = Form::create([
            'name' => $title,
            'user_id' => $user->id,
            'description' => $desc,
            'published' => false,
            'accept_response' => false,
        ]);
        // echo($form->id);
        $form_id = $form->id;
        $question_order = [];
        for ($i = 1; $i < count($data); $i++) {
            $type = $data[$i]['type'];
            $name = $data[$i]['name'];
            $options = $data[$i]['options'];
            $required = $data[$i]['required'];


            $attributes = [
                'form_id' => $form_id,
                'type' => (int)$type,
                'name' => $name,
                'options' => $options,
                'required' => $required,
            ];

            $question = Question::create($attributes);
            $question_order[] = $question->id;
        }
        $form->question_order = $question_order;
        $form->save();
        session()->flash('form-create-message',"Form: $form->name created successfully!!");

        return response()->json(['message' => 'Form data saved successfully'], 200);
    }

    public function edit($id)
    {
        $form = Form::findOrFail($id);
        $questionOrder = $form->question_order;

        if (count($questionOrder) > 0) {
            $questionMarks = implode(',', array_fill(0, count($questionOrder), '?'));
            $questions = Question::whereIn('id', $questionOrder)
                ->orderByRaw("FIELD(id, {$questionMarks})", $questionOrder)
                ->get();
        } else {
            $questions = collect();
        }
        return view('user.form-edit',compact(['form','questions']));
    }

    public function update($id, Request $request){
        $user = Auth::user();
        $data = $request->all();

        $rules = [
            '1.title' => 'required|string|max:255',
            '1.description' => 'nullable|string|max:1000',
        ];

        // Applying rules for each question starting from index 2
        for ($i = 2; $i < count($data); $i++) {
            $rules["$i.id"] = 'required|string';  // Each question must have a numeric ID
            $rules["$i.type"] = 'required|integer|in:1,2,3,4,5';
            $rules["$i.name"] = 'required|string|max:255';
            $rules["$i.options"] = 'array';
            $rules["$i.options.*"] = 'string|max:255';
            $rules["$i.required"] = 'required|boolean';
        }

        $messages = [
            '0.id.required' => 'The form ID is required.',
            '0.id.integer' => 'The form ID must be an integer.',
            '1.title.required' => 'The form title is required.',
            '1.title.string' => 'The form title must be a string.',
            '1.title.max' => 'The form title must not exceed 255 characters.',
            '1.description.string' => 'The description must be a string.',
            '1.description.max' => 'The description must not exceed 1000 characters.',
            '*.id.required' => 'The question ID is required.',
            '*.id.integer' => 'The question ID must be an integer.',
            '*.type.required' => 'The question type is required.',
            '*.type.in' => 'The question type must be one of: 1 (short text), 2 (long text), 3 (multiple choice), 4 (dropdown), or 5 (checkbox).',
            '*.name.required' => 'The question name is required.',
            '*.name.string' => 'The question name must be a string.',
            '*.name.max' => 'The question name must not exceed 255 characters.',
            '*.options.array' => 'The options must be an array.',
            '*.options.*.string' => 'Each option must be a string.',
            '*.options.*.max' => 'Each option must not exceed 255 characters.',
            '*.required.required' => 'The required field is required.',
            '*.required.boolean' => 'The required field must be true or false.'
        ];

        $validator = Validator::make($data, $rules, $messages);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $form = Form::findOrFail($id);
        $title = $data[1]['title'];
        $description = $data[1]['description'];
        if (!$description) {
            $description = "";
        }
        // dd($description);
        // dd($data);
        $form_id = $form->id;
        $form->name = $title;
        $form->description = $description;
        // $form->save();
        $question_order = [];
        for ($i = 2; $i < count($data); $i++) {
            $question_id = $data[$i]['id'];
            $type = $data[$i]['type'];
            $name = $data[$i]['name'];
            $options = $data[$i]['options'];
            $required = $data[$i]['required'];

            $question_id = $question_id == 0 ? false : $question_id;

            $attributes = [
                'form_id' => $form_id,
                'type' => (int)$type,
                'name' => $name,
                'options' => $options,
                'required' => $required,
            ];

            $question = Question::updateOrCreate(['id' => $question_id], $attributes);
            $question_order[] = $question->id;
        }
        $form->question_order = $question_order;
        $form->save();
        // dd($form);
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

    public function toggleAcceptResponse($id)
    {
        $user = Auth::user();
        $form = Form::findOrFail($id);
        if($form->accept_response === 1){
            $form->accept_response = 0;
            // session()->flash('not-accept-message','form not accepting responses');
        }
        else {
            $form->accept_response = 1;
            // session()->flash('accept-message','form accepting responses');
        }
        $form->save();
        $responses = $form->responses;
        return view('user.responses', compact(['user', 'form','responses']));
    }

    public function togglePublish($id)
    {
        $user = Auth::user();
        $form = Form::findOrFail($id);
        // if($form->accept_response === 1){
        //     $form->accept_response = 0;
        //     // session()->flash('not-accept-message','form not accepting responses');
        // }
        // else {
        //     $form->accept_response = 1;
        //     // session()->flash('accept-message','form accepting responses');
        // }
        $form->published = 1;
        $form->save();
        $responses = $form->responses()->paginate(1);
        return view('user.responses', compact(['user', 'form','responses']));
    }

    public function response($id)
    {
        $user = Auth::user();
        $form = Form::findOrFail($id);
        $responses = $form->responses()->paginate(1);
        // $paginatedQuestion = $form->questions()->paginate(1);
        $questionOrder = $form->question_order;
        if (count($questionOrder) > 0) {
            $questionMarks = implode(',', array_fill(0, count($questionOrder), '?'));
            $questions = Question::whereIn('id', $questionOrder)
                ->orderByRaw("FIELD(id, {$questionMarks})", $questionOrder)
                ->get();
        } else {
            $questions = collect();
        }
        return view('user.responses', compact(['form','responses','questions']));
    }

    public function getResponse($id)
    {
        $user = Auth::user();
        $form = Form::findOrFail($id);
        $questionOrder = $form->question_order;

        if (count($questionOrder) > 0) {
            $questionMarks = implode(',', array_fill(0, count($questionOrder), '?'));
            $questions = Question::whereIn('id', $questionOrder)
                ->orderByRaw("FIELD(id, {$questionMarks})", $questionOrder)
                ->get();
        } else {
            $questions = collect();
        }
        return view('user.getResponse', compact(['user', 'form','questions']));
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

    public function export($id)
    {
        $form = Form::findOrFail($id);
        $questions = $form->questions;
        $question_names = ["Sr no.","Sender emailId"];
        foreach($questions as $question){
            $question_names[] = $question->name;
        }



        $csvFileName = 'responses_' . date('Y-m-d_H-i-s') . '.csv';
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $csvFileName . '"',
        ];
        $handle = fopen('php://output', 'w');
        fputcsv($handle, $question_names);

        $responses = $form->responses;
        $i = 1;
        foreach($responses as $response){
            $answers = [$i,$response->user->email];
            foreach($form->questions as $question){
                $answer = [""];
                if($question->answers->where('response_id',$response->id)->isNotEmpty() ){
                    $answer = $question->answers->where('response_id',$response->id)->first()->answer;
                }
                // print_r($answer);
                if(is_array($answer)){
                    $answer = implode(', ', $answer);
                }
                $answers[] = $answer;
            }
            fputcsv($handle, $answers);
            $i++;
        }
        fclose($handle);

        return FacadeResponse::make('', 200, $headers);
    }
}

