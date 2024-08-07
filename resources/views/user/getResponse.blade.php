@extends('layouts.master-forms')

@section('css')
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
@endsection

@section('content')
    @if ($form->accept_response == 1)
        <div class="container mt-5 custom-container">
            <form action="{{ route('form.saveResponse', $form->id) }}" method="POST">
                @csrf
                @method('POST')
                <div id="form-container">
                    <div class="bg-white rounded shadow-sm p-4 question-box title-box">
                        <div class="form-group">
                            <h2>{{ $form->name }}</h2>
                        </div>
                        <br>
                        <div class="form-group">
                            <p>{{ $form->description }}</p>
                        </div>
                        <hr>
                        <div class="form-group">
                            {{ $user->email }} <a href="#">Switch Accounts</a><br>
                        </div>
                        <hr>
                        <span style="color: red;">* Indicates required question</span>
                    </div>


                    @foreach ($questions as $question)
                        @if ($question->type == 1)
                            <div class="bg-white rounded shadow-sm p-4 question-box" question-box="{{ $loop->iteration }}">
                                <div class="form-group">
                                    <h4><strong>{{ $question->name }}@if ($question->required === 1)
                                                <span style="color: red;">*</span>
                                            @endif
                                        </strong>
                                    </h4>
                                </div>
                                <div class="form-group">
                                    <label for="1{{ $loop->iteration }}"></label>
                                    <input type="text" name="1{{ $loop->iteration }}"class="form-control"
                                        id="inputHeader" aria-describedby="headerHelp" placeholder="write answer here"
                                        @if ($question->required == 1) required @endif>
                                </div>
                            </div>
                        @elseif ($question->type == 2)
                            <div class="bg-white rounded shadow-sm p-4 question-box" question-box="{{ $loop->iteration }}">
                                <div class="form-group">
                                    <h4><strong>{{ $question->name }}@if ($question->required === 1)
                                                <span style="color: red;">*</span>
                                            @endif
                                        </strong>
                                    </h4>
                                </div>
                                <div class="form-group">
                                    <label for="2{{ $loop->iteration }}"></label>
                                    <textarea class="form-control" id="inputHeader" name="2{{ $loop->iteration }}" aria-describedby="headerHelp"
                                        placeholder="Write answer here" @if ($question->required == 1) required @endif></textarea>
                                </div>
                            </div>
                        @elseif ($question->type == 3)
                            <div class="bg-white rounded shadow-sm p-4 question-box" question-box="{{ $loop->iteration }}">
                                <div class="multipleChoice">
                                    <div class="form-group">
                                        <h4><strong>{{ $question->name }}@if ($question->required === 1)
                                                    <span style="color: red;">*</span>
                                                @endif
                                            </strong>
                                        </h4>
                                    </div>
                                    <br>
                                    <div class="mcq-options" id="multipleChoice{{ $loop->iteration }}">
                                        @foreach ($question->options as $option)
                                            <div class="form-check" id="multipleChoice{{ $loop->parent->iteration }}">
                                                <input type="radio" class="form-check-input"
                                                    name="3{{ $loop->parent->iteration }}"
                                                    id="mcqOption{{ $loop->parent->iteration }}{{ $loop->iteration }}"
                                                    value="{{ $option }}"
                                                    style="position: relative; bottom: 4px"
                                                    @if ($question->required == 1) required @endif>
                                                <label class="form-check-label"
                                                    for="mcqOption{{ $loop->parent->iteration }}">{{ $option }}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @elseif ($question->type == 4)
                            <div class="bg-white rounded shadow-sm p-4 question-box" question-box="{{ $loop->iteration }}">
                                <div class="dropDown">
                                    <div class="form-group">
                                        <h4><strong>{{ $question->name }}@if ($question->required === 1)
                                                    <span style="color: red;">*</span>
                                                @endif
                                            </strong>
                                        </h4>
                                    </div>
                                    <br>
                                    <select class="form-control" name="4{{ $loop->iteration }}"
                                        @if ($question->required == 1) required @endif>
                                        <option value="" disabled selected>Select an option</option>
                                        @foreach ($question->options as $option)
                                            <option value="{{ $option }}">{{ $option }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        @elseif ($question->type == 5)
                            <div class="bg-white rounded shadow-sm p-4 question-box" question-box="{{ $loop->iteration }}">
                                <div class="CheckBox">
                                    <div class="form-group">
                                        <h4><strong>{{ $question->name }}@if ($question->required === 1)
                                                    <span style="color: red;">*</span>
                                                @endif
                                            </strong></h4>
                                    </div>
                                    <br>
                                    <div id="checkbox-options{{ $loop->iteration }}" class="checkbox-group"
                                        data-required=@if ($question->required == 1) {{ true }}@else{{ false }} @endif>
                                        @foreach ($question->options as $option)
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox"
                                                    id="checkboxOption{{ $loop->parent->iteration }}{{ $loop->iteration }}"
                                                    style="position: relative; bottom: 4px"
                                                    name="5{{ $loop->parent->iteration }}[]" value="{{ $option }}">
                                                <label class="form-check-label"
                                                    for="checkboxOption{{ $loop->parent->iteration }}{{ $loop->iteration }}">{{ $option }}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
                <input type="submit" width="50" id="form-submit" class="btn btn-primary"></input>
            </form>
        </div>
    @else
        <div class="container mt-5 custom-container">
            <div id="form-container">
                <div class="bg-white rounded shadow-sm p-4 question-box title-box">
                    <div class="form-group">
                        <h2>{{ $form->name }}</h2>
                    </div>
                    <br>
                    <div class="form-group">
                        <p>The form <strong>{{ $form->name }}</strong> is no longer accepting responses.</p>
                        <p>Try contacting the owner of the form if you think this is a mistake.</p>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection


@section('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelector('form').addEventListener('submit', function(event) {
                let checkboxGroups = document.querySelectorAll('.checkbox-group[data-required="1"]');
                let valid = true;

                checkboxGroups.forEach(function(group) {
                    let checkboxes = group.querySelectorAll('input[type="checkbox"]');
                    let checked = Array.from(checkboxes).some(checkbox => checkbox.checked);

                    if (!checked) {
                        valid = false;
                        group.classList.add('error');

                        // Check if the error message already exists
                        let errorMessage = group.querySelector('.error-message');
                        if (!errorMessage) {
                            errorMessage = document.createElement('div');
                            errorMessage.classList.add('error-message');
                            errorMessage.style.color = 'red'
                            errorMessage.innerText = 'Please select at least one option.';
                            group.appendChild(errorMessage);
                        }
                    } else {
                        group.classList.remove('error');
                        let errorMessage = group.querySelector('.error-message');
                        if (errorMessage) {
                            errorMessage.remove();
                        }
                    }
                });

                if (!valid) {
                    event.preventDefault();
                }
            });
        });
    </script>
@endsection
