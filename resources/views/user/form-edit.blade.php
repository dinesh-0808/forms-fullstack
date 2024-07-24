@extends('layouts.master-forms')

@section('css')
<link rel="stylesheet" href="{{ asset('css/styles.css') }}">

@endsection


@section('content')
<div id="app">
    <nav class="navbar navbar-light shadow-sm" style="background-color: #673AB7;">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/home') }}" style="color: white;">
                {{ config('app.name', 'MY FORMS') }}
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                {{-- <!-- Left Side Of Navbar -->
                <ul class="navbar-nav me-auto">

                </ul> --}}

                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ms-auto">
                    <!-- Authentication Links -->
                    @guest
                        @if (Route::has('login'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}" style="color: white;">{{ __('Login') }}</a>
                            </li>
                        @endif

                        @if (Route::has('register'))
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('register') }}" style="color: white;">{{ __('Register') }}</a>
                            </li>
                        @endif
                    @else
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" style="color: white;" href="#" role="button"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                {{ Auth::user()->name }}
                            </a>

                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="{{ route('logout') }}"
                                    onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                    @csrf
                                </form>
                            </div>
                        </li>
                    @endguest
                </ul>
            </div>
        </div>
    </nav>
</div>

<div class="container mt-5 custom-container">
    <div id="form-container-title">
        <div class="bg-white rounded shadow-sm p-4 mb-3 preview-button">
            <h1 style="text-align: center;">MY FORMS</h1>
            <button type="button" class="btn btn-secondary mt-3 btn-preview" onclick="openPreview()"><i class="fa-solid fa-eye"></i></button>
        </div>


        <div class="bg-white rounded shadow-sm p-4 question-box title-box active-border">
            <div class="formTitleAndDesc">
                <div class="form-group">
                    <input type="text" class="form-control" id="formTitle" aria-describedby="headerHelp" value="{{ $form->name }}">
                </div>
                <br>
                <div class="form-group">
                    <input type="text" class="form-control" id="formDesc" aria-describedby="headerHelp" placeholder="Form Description" value="{{ $form->description }}">
                </div>
            </div>
            <button value="multiple-choice" id="add-section-btn" class="btn btn-primary floating-button" onclick="addQuestion(event)"><i class="fa-solid fa-plus"></i></button>
        </div>

    </div>
</div>


<div class="container custom-container">


    <div id="form-container">

        @foreach ($questions as $question)

            @if($question->type==1)
            <div class="bg-white rounded shadow-sm p-4 question-box drag-box" id="question-box6{{ $loop->iteration }}" question-box="6{{ $loop->iteration }}" >
                <input type="hidden" name="question_id" value="{{ $question->id }}">
                <div class="shortText">
                    <div class="form-group header">
                        <div class="question"><input type="text" class="form-control question-name" id="inputHeader" aria-describedby="headerHelp" placeholder="question" value="{{ $question->name }}"></div>
                        <select class="dropdown" dropdown="{{ $loop->iteration }}" onchange="dropdownChangeButton(event)">
                            <option value="short-text" selected>Short Text</option>
                            <option value="long-text">Long Text</option>
                            <option value="multiple-choice">Multiple Choice</option>
                            <option value="dropdown">Dropdown</option>
                            <option value="checkboxes">Checkboxes</option>
                        </select>
                    </div>
                    <br>
                    <div class="form-group" style="margin-left: 20px">
                        <input type="text" class="form-control" id="inputHeader" aria-describedby="headerHelp" placeholder="write answer here" disabled=true >
                    </div>
                    <hr>
                    <button type="button" class="btn btn-secondary mt-2 bottom-right" id="deleteButton6{{ $loop->iteration }}" deleteButton="6{{ $loop->iteration }}" onclick="deleteQuestionBoxEdit(event)">
                        <i class="fa-solid fa-trash" deleteButton="6{{ $loop->iteration }}"></i>
                    </button>
                    <div class="toggle-container" toggleButton="6{{ $loop->iteration }}">
                                <span class="status">Required</span>
                                <label class="toggle-switch" checked>
                                    <input type="checkbox" class="toggleButton" @if($question->required==1) checked @endif>
                                    <span class="slider"></span>
                                </label>
                    </div>
                </div>
            </div>
            @elseif ($question->type==2)
            <div class="bg-white rounded shadow-sm p-4 question-box drag-box" id="question-box7{{ $loop->iteration }}" question-box="7{{ $loop->iteration }}" >
                <input type="hidden" name="question_id" value="{{ $question->id }}">
                <div class="longText">
                    <div class="form-group header">
                        <div class="question"><input type="text" class="form-control question-name" id="inputHeader" aria-describedby="headerHelp" placeholder="Question" value="{{ $question->name }}"></div>
                        <select class="dropdown" dropdown="{{ $loop->iteration }}" onchange="dropdownChangeButton(event)">
                            <option value="short-text">Short Text</option>
                            <option value="long-text" selected>Long Text</option>
                            <option value="multiple-choice">Multiple Choice</option>
                            <option value="dropdown">Dropdown</option>
                            <option value="checkboxes">Checkboxes</option>
                        </select>
                    </div>
                    <br>
                    <div class="form-group" style="margin-left: 20px">
                        <textarea class="form-control" id="inputHeader" aria-describedby="headerHelp" placeholder="Write answer here" disabled></textarea>
                    </div>
                    <hr>

                    <button type="button" class="btn btn-secondary mt-2 bottom-right" id="deleteButton7{{ $loop->iteration }}" deleteButton="7{{ $loop->iteration }}" onclick="deleteQuestionBoxEdit(event)">
                        <i class="fa-solid fa-trash" deleteButton="7{{ $loop->iteration }}"></i>
                    </button>
                    <div class="toggle-container" toggleButton="7{{ $loop->iteration }}">
                                <span class="status">Required</span>
                                <label class="toggle-switch">
                                    <input type="checkbox" class="toggleButton" @if($question->required==1) checked @endif>
                                    <span class="slider"></span>
                                </label>
                    </div>
                </div>
            </div>
            @elseif ($question->type == 3)
            <div class="bg-white rounded shadow-sm p-4 question-box drag-box" id="question-box8{{ $loop->iteration }}" question-box="8{{ $loop->iteration }}"  >
                <input type="hidden" name="question_id" value="{{ $question->id }}">
                <div class="multipleChoice">
                    <div class="form-group header">
                        <div class="question"><input type="text" class="form-control question-name" id="inputHeader" aria-describedby="headerHelp" placeholder="Question" value="{{ $question->name }}"></div>
                        <select class="dropdown" dropdown="{{ $loop->iteration }}" onchange="dropdownChangeButton(event)">
                            <option value="short-text">Short Text</option>
                            <option value="long-text">Long Text</option>
                            <option value="multiple-choice" selected>Multiple Choice</option>
                            <option value="dropdown">Dropdown</option>
                            <option value="checkboxes">Checkboxes</option>
                        </select>
                    </div>
                    <br>
                    <div id="mcq-options8{{ $loop->iteration }}">
                        @foreach ($question->options as $option)
                        <div class="form-check" id="MultipleChoiceBox8{{ $loop->parent->iteration }}{{ $loop->iteration }}" MultipleChoiceBox="8{{ $loop->parent->iteration }}{{ $loop->iteration }}">
                            <input type="radio" class="form-check-input" name="mcq" id="mcqOption{{ $loop->parent->iteration }}{{ $loop->iteration }}"  value={{ $option }} disabled=true>
                            <label class="form-check-label" for="mcqOption{{ $loop->iteration }}"><input type="text" class='form-control' value="{{ $option }}"></label>
                            <button type="button" mcqOptionDeleteButton="8{{ $loop->parent->iteration }}{{ $loop->iteration }}" id="mcqOptionDeleteButton8{{ $loop->parent->iteration }}{{ $loop->iteration }}" class="btn btn-secondary mt-2 mcqOptionsDeleteButton optionsDeleteButton"><i class="fa-solid fa-xmark"></i></button>
                        </div>
                            @endforeach
                    </div>
                    <button type="button" class="btn btn-secondary mt-2 addButton" id="mcqOptionsButton8{{ $loop->iteration }}" mcqOptionsButton="8{{ $loop->iteration }}" onclick="addMultipleChoiceOptionButton(event)">Add Option</button>
                    <hr>
                    <button type="button" class="btn btn-secondary mt-2 bottom-right" id="deleteButton8{{ $loop->iteration }}" deleteButton="8{{ $loop->iteration }}" onclick="deleteQuestionBoxEdit(event)">
                        <i class="fa-solid fa-trash" deleteButton="8{{ $loop->iteration }}"></i>
                    </button>
                    <div class="toggle-container" toggleButton="8{{ $loop->iteration }}">
                                <span class="status">Required</span>
                                <label class="toggle-switch">
                                    <input type="checkbox" class="toggleButton" @if($question->required==1) checked @endif>
                                    <span class="slider"></span>
                                </label>
                    </div>
                </div>
            </div>
            @elseif ($question->type==4)
            <div class="bg-white rounded shadow-sm p-4 question-box drag-box" id="question-box9{{ $loop->iteration }}" question-box="9{{ $loop->iteration }}" >
                <input type="hidden" name="question_id" value="{{ $question->id }}">
                <div class="dropDown">
                    <div class="form-group header">
                        <div class="question"><input type="text" class="form-control question-name" id="inputHeader" aria-describedby="headerHelp" placeholder="Question" value="{{ $question->name }}"></div>
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
                        <div class="form-check" id="dropdownQuestion9{{ $loop->iteration }}">
                            @foreach ($question->options as $option)
                            <p id="dropdownBox9{{ $loop->parent->iteration }}{{ $loop->iteration }}" dropdownBox="9{{ $loop->parent->iteration }}{{ $loop->iteration }}">
                                <input type="text" width="50" class='form-control dropdownOptions' value="{{ $option }}" width="100px">
                                <button type="button" dropdownOptionDeleteButton="9{{ $loop->parent->iteration }}{{ $loop->iteration }}" id="dropdownOptionDeleteButton9{{ $loop->parent->iteration }}{{ $loop->iteration }}" class="btn btn-secondary mt-2 dropdownOptionDeleteButton optionsDeleteButton"><i class="fa-solid fa-xmark"></i></button>
                            </p>
                            @endforeach
                        </div>
                        <button type="button" class="btn btn-secondary mt-2 addButton" id="dropdownOptionsButton9{{ $loop->iteration }}" dropdownOptionsButton="9{{ $loop->iteration }}" onclick="addDropdownOptionButton(event)">Add Option</button>
                    </div>
                    <hr>
                    <button type="button" class="btn btn-secondary mt-2 bottom-right" id="deleteButton9{{ $loop->iteration }}" deleteButton="9{{ $loop->iteration }}" onclick="deleteQuestionBoxEdit(event)">
                        <i class="fa-solid fa-trash" deleteButton="9{{ $loop->iteration }}"></i>
                    </button>
                    <div class="toggle-container" toggleButton="9{{ $loop->iteration }}">
                                <span class="status">Required</span>
                                <label class="toggle-switch">
                                    <input type="checkbox" class="toggleButton" @if($question->required==1) checked @endif>
                                    <span class="slider"></span>
                                </label>
                    </div>
                </div>
            </div>
            @elseif ($question->type == 5)
            <div class="bg-white rounded shadow-sm p-4 question-box drag-box" id="question-box10{{ $loop->iteration }}" question-box="10{{ $loop->iteration }}" >
                <input type="hidden" name="question_id" value="{{ $question->id }}">
                <div class="CheckBox">
                    <div class="form-group header">
                        <div class="question"><input type="text" class="form-control question-name" id="inputHeader" aria-describedby="headerHelp" placeholder="Question" value="{{ $question->name }}"></div>
                        <select class="dropdown" dropdown="{{ $loop->iteration }}" onchange="dropdownChangeButton(event)">
                            <option value="short-text">Short Text</option>
                            <option value="long-text">Long Text</option>
                            <option value="multiple-choice">Multiple Choice</option>
                            <option value="dropdown">Dropdown</option>
                            <option value="checkboxes" selected>Checkboxes</option>
                        </select>
                    </div>
                    <br>
                    <div id="checkbox-options10{{ $loop->iteration }}">
                        @foreach ($question->options as $option)
                        <div class="form-check" id="checkboxBox10{{ $loop->parent->iteration }}{{ $loop->iteration }}" checkboxBox="10{{ $loop->parent->iteration }}{{ $loop->iteration }}">
                            <input class="form-check-input" type="checkbox" id="checkboxOption{{ $loop->iteration }}" name="checkbox" value="{{ $option }}" disabled=true>
                            <label class="form-check-label" for="checkboxOption{{ $loop->iteration }}"><input type="text" class='form-control' value="{{ $option }}"></label>
                            <button type="button" checkboxOptionDeleteButton="10{{ $loop->parent->iteration }}{{ $loop->iteration }}" id="checkboxOptionDeleteButton10{{ $loop->parent->iteration }}{{ $loop->iteration }}" class="btn btn-secondary mt-2 checkboxOptionDeleteButton optionsDeleteButton"><i class="fa-solid fa-xmark"></i></button>
                        </div>
                        @endforeach
                    </div>
                    <button type="button" class="btn btn-secondary mt-2 addButton" id="checkboxOptionsButton10{{ $loop->iteration }}" checkboxOptionsButton="10{{ $loop->iteration }}" onclick="addCheckBoxOptionButton(event)">Add Option</button>
                    <hr>
                    <button type="button" class="btn btn-secondary mt-2 bottom-right" id="deleteButton10{{ $loop->iteration }}" deleteButton="10{{ $loop->iteration }}" onclick="deleteQuestionBoxEdit(event)">
                        <i class="fa-solid fa-trash" deleteButton="10{{ $loop->iteration }}"></i>
                    </button>
                    <div class="toggle-container" toggleButton="10{{ $loop->iteration }}" >
                                <span class="status">Required</span>
                                <label class="toggle-switch">
                                    <input type="checkbox" class="toggleButton" @if($question->required==1) checked @endif>
                                    <span class="slider"></span>
                                </label>
                    </div>
                </div>
            </div>
            @endif

        @endforeach



    </div>
{{--
    <div class="floating-bar" id="question-type">
        <button value="multiple-choice" class="floating-button"><i class="fa-solid fa-plus"></i></button>
    </div> --}}
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
