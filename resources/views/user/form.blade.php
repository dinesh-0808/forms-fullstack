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
                    <input type="text" class="form-control" id="formTitle" aria-describedby="headerHelp" value="{{ $title }}">
                </div>
                <br>
                <div class="form-group">
                    <input type="text" class="form-control" id="formDesc" aria-describedby="headerHelp" placeholder="Form Description">
                </div>
            </div>
        </div>

    </div>
</div>


<div class="container mt-5 custom-container">


    <div id="form-container">
        <div class="bg-white rounded shadow-sm p-4 question-box drag-box" id="question-box31" question-box="31">
            <div class="multipleChoice">
                <div class="form-group header">
                    <div class="question"><input type="text" class="form-control" id="inputHeader" aria-describedby="headerHelp" placeholder="Question" value="Question"></div>
                    <select class="dropdown" dropdown="1" onchange="dropdownChangeButton(event)">
                        <option value="short-text">Short Text</option>
                        <option value="long-text">Long Text</option>
                        <option value="multiple-choice" selected>Multiple Choice</option>
                        <option value="dropdown">Dropdown</option>
                        <option value="checkboxes">Checkboxes</option>
                    </select>
                </div>
                <br>
                <div id="mcq-options1">
                    <div class="form-check" id="MultipleChoiceBox11">
                        <input type="radio" class="form-check-input" name="mcq" id="mcqOption11" value=" option" disabled=true>
                        <label class="form-check-label" for="mcqOption1"><input type="text" class='form-control' value="option"></label>
                    </div>
                </div>
                <button type="button" class="btn btn-secondary mt-2 addButton" id="mcqOptionsButton1" mcqOptionsButton="1" onclick="addMultipleChoiceOptionButton(event)"><i class="fa-solid fa-plus" mcqOptionsButton="1"></i></button>
                <hr>

                <button type="button" class="btn btn-secondary mt-2 bottom-right" deleteButton="31" onclick="deleteQuestionBox(event)">
                    <i class="fa-solid fa-trash" deleteButton="31"></i>
                </button>

                <div class="toggle-container">
                    <span class="status">Required</span>
                    <label class="toggle-switch">
                        <input type="checkbox" class="toggleButton">
                        <span class="slider"></span>
                    </label>
                </div>
            </div>
        </div>

    </div>
    <div class="floating-bar" id="question-type">
        <button value="multiple-choice" class="floating-button"><i class="fa-solid fa-plus"></i></button>
    </div>
    <!-- <div class="sidebar">
        <div id="question-type">


            <button class="btnp floating-button" onclick="addQuestion(); moveDown()" value="multiple-choice" class="floating-button">
                <i class="fa-solid fa-plus"></i>
            </button>

        </div>
    </div> -->

    <!-- <button type="button" class="btn btn-secondary mt-3 btn-preview" onclick="openPreview()">Preview Form</button> -->
    <!-- <button type="button" class="btn btn-primary mt-3" onclick="addQuestion()">Add Question</button> -->
    <button id="form-submit" class="btn btn-primary">Save</button>
</div>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
<script src="{{ asset('js/script.js') }}"></script>
<script src="{{ asset('js/scriptNew.js') }}"></script>
<script src="{{ asset('js/script2.js') }}"></script>
<script src="{{ asset('js/json_script.js') }}"></script>

@endsection
