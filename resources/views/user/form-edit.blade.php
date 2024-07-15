@extends('layouts.master-forms')

@section('css')
<link rel="stylesheet" href="{{ asset('css/styles.css') }}">

@endsection


@section('content')


<div class="container mt-5 custom-container">
    <div id="form-container-title">
        <div class="bg-white rounded shadow-sm p-4 question-box preview-button">
            <h1 style="text-align: center;">MY FORMS</h1>
            <button type="button" class="btn btn-secondary mt-3 btn-preview" onclick="openPreview()"><i class="fa-solid fa-eye"></i></button>
        </div>


        <div class="bg-white rounded shadow-sm p-4 question-box title-box">
            <div class="formTitleAndDesc">
                <div class="form-group">
                    <input type="text" class="form-control" id="formTitle" aria-describedby="headerHelp" value="{{ $form->name }}">
                </div>
                <br>
                <div class="form-group">
                    <input type="text" class="form-control" id="formDesc" aria-describedby="headerHelp" placeholder="Form Description" value="{{ $form->description }}">
                </div>
            </div>
        </div>

    </div>
</div>


<div class="container mt-5 custom-container">


    <div id="form-container">
        @foreach ($form->questions as $question)

            @if($question->type==1)
            <div class="bg-white rounded shadow-sm p-4 question-box drag-box" id="question-box1{{ $loop->iteration }}" question-box="1{{ $loop->iteration }}" >
                <div class="shortText">
                    <div class="form-group header">
                        <div class="question"><input type="text" class="form-control" id="inputHeader" aria-describedby="headerHelp" placeholder="Question" value="{{ $question->name }}"></div>
                        <select class="dropdown" dropdown="{{ $loop->iteration }}" onchange="dropdownChangeButton(event)">
                            <option value="short-text" selected>Short Text</option>
                            <option value="long-text">Long Text</option>
                            <option value="multiple-choice">Multiple Choice</option>
                            <option value="dropdown">Dropdown</option>
                            <option value="checkboxes">Checkboxes</option>
                        </select>
                    </div>
                    <br>
                    <div class="form-group">
                        <input type="text" class="form-control" id="inputHeader" aria-describedby="headerHelp" placeholder="write question here" disabled=true >
                    </div>
                    <hr>

                    <button type="button" class="btn btn-secondary mt-2 bottom-right" id="deleteButton1{{ $loop->iteration }}" deleteButton="1{{ $loop->iteration }}" onclick="deleteQuestionBoxEdit(event)">
                        <i class="fa-solid fa-trash" deleteButton="1{{ $loop->iteration }}"></i>
                    </button>
                    <div class="toggle-container" toggleButton="1{{ $loop->iteration }}">
                                <span class="status">Required</span>
                                <label class="toggle-switch">
                                    <input type="checkbox" class="toggleButton">
                                    <span class="slider"></span>
                                </label>
                    </div>
                </div>
            </div>
            @elseif ($question->type==2)
            <div class="bg-white rounded shadow-sm p-4 question-box drag-box" id="question-box2{{ $loop->iteration }}" question-box="2{{ $loop->iteration }}" >
                <div class="longText">
                    <div class="form-group header">
                        <div class="question"><input type="text" class="form-control" id="inputHeader" aria-describedby="headerHelp" placeholder="Question" value="{{ $question->name }}"></div>
                        <select class="dropdown" dropdown="{{ $loop->iteration }}" onchange="dropdownChangeButton(event)">
                            <option value="short-text">Short Text</option>
                            <option value="long-text" selected>Long Text</option>
                            <option value="multiple-choice">Multiple Choice</option>
                            <option value="dropdown">Dropdown</option>
                            <option value="checkboxes">Checkboxes</option>
                        </select>
                    </div>
                    <br>
                    <div class="form-group">
                        <input type="text" class="form-control" id="inputHeader" aria-describedby="headerHelp" placeholder="write question here" disabled=true value="{{ $question->name }}">
                    </div>
                    <hr>

                    <button type="button" class="btn btn-secondary mt-2 bottom-right" id="deleteButton2{{ $loop->iteration }}" deleteButton="2{{ $loop->iteration }}" onclick="deleteQuestionBoxEdit(event)">
                        <i class="fa-solid fa-trash" deleteButton="2{{ $loop->iteration }}"></i>
                    </button>
                    <div class="toggle-container" toggleButton="2{{ $loop->iteration }}">
                                <span class="status">Required</span>
                                <label class="toggle-switch">
                                    <input type="checkbox" class="toggleButton">
                                    <span class="slider"></span>
                                </label>
                    </div>
                </div>
            </div>
            @elseif ($question->type == 3)
            <div class="bg-white rounded shadow-sm p-4 question-box drag-box" id="question-box3{{ $loop->iteration }}" question-box="3{{ $loop->iteration }}"  >
                <div class="MultipleChoice">
                    <div class="form-group header">
                        <div class="question"><input type="text" class="form-control" id="inputHeader" aria-describedby="headerHelp" placeholder="Question" value="{{ $question->name }}"></div>
                        <select class="dropdown" dropdown="{{ $loop->iteration }}" onchange="dropdownChangeButton(event)">
                            <option value="short-text">Short Text</option>
                            <option value="long-text">Long Text</option>
                            <option value="multiple-choice" selected>Multiple Choice</option>
                            <option value="dropdown">Dropdown</option>
                            <option value="checkboxes">Checkboxes</option>
                        </select>
                    </div>
                    <br>
                    <div id="mcq-options{{ $loop->iteration }}">
                        @foreach ($question->options as $option)
                        <div class="form-check" id="MultipleChoiceBox{{ $loop->iteration }}">
                            <input type="radio" class="form-check-input" name="mcq" id="mcqOption{{ $loop->parent->iteration }}{{ $loop->iteration }}" value={{ $option }} disabled=true>
                            <label class="form-check-label" for="mcqOption{{ $loop->iteration }}"><input type="text" class='form-control' value="{{ $option }}"></label>
                        </div>
                            @endforeach
                    </div>
                    <button type="button" class="btn btn-secondary mt-2 addButton" id="mcqOptionsButton{{ $loop->iteration }}" mcqOptionsButton="{{ $loop->iteration }}" onclick="addMultipleChoiceOptionButton(event)"><i class="fa-solid fa-plus" mcqOptionsButton="{{ $loop->iteration }}"></i></button>
                    <hr>

                    <button type="button" class="btn btn-secondary mt-2 bottom-right" id="deleteButton3{{ $loop->iteration }}" deleteButton="3{{ $loop->iteration }}" onclick="deleteQuestionBoxEdit(event)">
                        <i class="fa-solid fa-trash" deleteButton="3{{ $loop->iteration }}"></i>
                    </button>
                    <div class="toggle-container" toggleButton="3{{ $loop->iteration }}">
                                <span class="status">Required</span>
                                <label class="toggle-switch">
                                    <input type="checkbox" class="toggleButton">
                                    <span class="slider"></span>
                                </label>
                    </div>
                </div>
            </div>
            @elseif ($question->type==4)
            <div class="bg-white rounded shadow-sm p-4 question-box drag-box" id="question-box4{{ $loop->iteration }}" question-box="4{{ $loop->iteration }}" >
                <div class="dropDown">
                    <div class="form-group header">
                        <div class="question"><input type="text" class="form-control" id="inputHeader" aria-describedby="headerHelp" placeholder="Question" value="{{ $question->name }}"></div>
                        <select class="dropdown" dropdown="{{ $loop->iteration }}" onchange="dropdownChangeButton(event)">
                            <option value="short-text">Short Text</option>
                            <option value="long-text">Long Text</option>
                            <option value="multiple-choice">Multiple Choice</option>
                            <option value="dropdown" selected>Dropdown</option>
                            <option value="checkboxes">Checkboxes</option>
                        </select>
                    </div>
                    <br>
                    <div class="form-group">
                        @foreach ($question->options as $option)
                        <div class="form-control" id="dropdownQuestion{{ $loop->iteration }}">
                            <p id="dropdownBox{{ $loop->parent->iteration }}{{ $loop->iteration }}"><input type="text" width="50" class='form-control dropdownOptions' value="{{ $option }}" width="10px"></p>

                        </div>
                        <button type="button" class="btn btn-secondary mt-2 addButton" id="dropdownOptionsButton${{ $loop->iteration }}" dropdownOptionsButton="{{ $loop->iteration }}" onclick="addDropdownOptionButton(event)"><i class="fa-solid fa-plus" dropdownOptionsButton="{{ $loop->iteration }}"></i></button>
                        @endforeach
                    </div>
                    <hr>

                    <button type="button" class="btn btn-secondary mt-2 bottom-right" id="deleteButton4{{ $loop->iteration }}" deleteButton="4{{ $loop->iteration }}" onclick="deleteQuestionBoxEdit(event)">
                        <i class="fa-solid fa-trash" deleteButton="4{{ $loop->iteration }}"></i>
                    </button>
                    <div class="toggle-container" toggleButton="4{{ $loop->iteration }}">
                                <span class="status">Required</span>
                                <label class="toggle-switch">
                                    <input type="checkbox" class="toggleButton">
                                    <span class="slider"></span>
                                </label>
                    </div>
                </div>
            </div>
            @elseif ($question->type == 5)
            <div class="bg-white rounded shadow-sm p-4 question-box drag-box" id="question-box5{{ $loop->iteration }}" question-box="5{{ $loop->iteration }}" >
                <div class="dropDown">
                    <div class="form-group header">
                        <div class="question"><input type="text" class="form-control" id="inputHeader" aria-describedby="headerHelp" placeholder="Question" value="{{ $question->name }}"></div>
                        <select class="dropdown" dropdown="{{ $loop->iteration }}" onchange="dropdownChangeButton(event)">
                            <option value="short-text">Short Text</option>
                            <option value="long-text">Long Text</option>
                            <option value="multiple-choice">Multiple Choice</option>
                            <option value="dropdown">Dropdown</option>
                            <option value="checkboxes" selected>Checkboxes</option>
                        </select>
                    </div>
                    <br>
                    <div id="checkbox-options{{ $loop->iteration }}">
                        @foreach ($question->options as $option)
                        <div class="form-check" id="checkboxBox{{ $loop->parent->iteration }}{{ $loop->iteration }}">
                            <input class="form-check-input" type="checkbox" id="checkboxOption{{ $loop->iteration }}" name="checkbox" value="{{ $option }}" disabled=true>
                            <label class="form-check-label" for="checkboxOption{{ $loop->iteration }}"><input type="text" class='form-control' value="{{ $option }}"></label>
                        </div>
                        @endforeach
                    </div>
                    <button type="button" class="btn btn-secondary mt-2 addButton" id="checkboxOptionsButton{{ $loop->iteration }}" checkboxOptionsButton="{{ $loop->iteration }}" onclick="addCheckBoxOptionButton(event)"><i class="fa-solid fa-plus" checkboxOptionsButton="{{ $loop->iteration }}"></i></button>
                    <hr>

                    <button type="button" class="btn btn-secondary mt-2 bottom-right" id="deleteButton5{{ $loop->iteration }}" deleteButton="5{{ $loop->iteration }}" onclick="deleteQuestionBoxEdit(event)">
                        <i class="fa-solid fa-trash" deleteButton="5{{ $loop->iteration }}"></i>
                    </button>
                    <div class="toggle-container" toggleButton="5{{ $loop->iteration }}">
                                <span class="status">Required</span>
                                <label class="toggle-switch">
                                    <input type="checkbox" class="toggleButton">
                                    <span class="slider"></span>
                                </label>
                    </div>
                </div>
            </div>
            @endif

        @endforeach



    </div>

    <div class="floating-bar" id="question-type">
        <button value="multiple-choice" class="floating-button"><i class="fa-solid fa-plus"></i></button>
    </div>
    <button id="form-edit" class="btn btn-primary" form="{{ $form->id }}">Save</button>

</div>


<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
<script src="{{ asset('js/script.js') }}"></script>
<script src="{{ asset('js/scriptNew.js') }}"></script>
<script src="{{ asset('js/script2.js') }}"></script>
<script src="{{ asset('js/edit_script.js') }}"></script>
<script src="{{ asset('js/json_script.js') }}"></script>


@endsection
