@extends('layouts.app')

@section('style')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <style>
        .question-box {
            margin-bottom: 20px;
            margin-top: 0px;
            border-radius: 8px; /* Rounded corners */
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); /* Subtle shadow for depth */
            border: 2px solid rgba(108, 117, 125, 0.2);
            position: relative;
        }
        .toggle-container {
            position: absolute;
            right: 15px;
            top: 43px;
            display: flex;
            align-items: center;
            margin-top: 20px;
        }

        .toggle-switch {
            position: relative;
            display: inline-block;
            width: 36px;
            height: 20.4px;
            margin-left: 10px;
        }

        .toggle-switch input {
            display: none;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            transition: .4s;
            border-radius: 34px;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 15.6px;
            width: 15.6px;
            left: 2.4px;
            bottom: 2.4px;
            background-color: white;
            transition: .4s;
            border-radius: 50%;
        }

        input:checked+.slider {
            background-color: #2196F3;
        }

        input:checked+.slider:before {
            transform: translateX(15.6px);
        }

        .export-container {
            position: absolute;
            right: 15px;
            top: 43px;
            display: flex;
            align-items: center;
            margin-top: -30px;
        }

    </style>
@endsection
@section('content')
    <div class="container mt-4">
        @if ($form->accept_response == 0 && $form->published==1)
            <div class="alert alert-danger">
                <h4>form not accepting responses</h4>
            </div>
        @elseif ($form->accept_response == 1 && $form->published==1)
            <div class="alert alert-success">
                <h4>form accepting responses</h4>
            </div>
        @endif
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <div class="row">
            <div class="col-md-8">
                <!-- Responses of the Form -->
                <div class="card">
                    {{-- style="background-color: #fff0ff" --}}
                    <div class="card-header">
                        Responses for Form: {{ $form->name }}
                        <h3>{{ count($form->responses) }} responses</h3>
                        <!-- Toggle Switch for Accepting Responses -->
                        @if($form->published==1)
                        <div class="export-container">
                            <a class="btn btn-outline-success" href="{{ route('form.response.export',$form->id) }}"><i class="fa-regular fa-file-excel"></i> Response Sheet</a>
                        </div>
                        <form id="publishForm" action="{{ route('form.acceptResponse.toggle', $form->id) }}" method="POST">
                            @csrf
                            @method('POST')
                            <div class="toggle-container">
                                <span class="status">Accepting Responses</span>
                                <label class="toggle-switch">
                                    <input type="checkbox" class="toggleButton"
                                        @if ($form->accept_response === 1) checked @endif @if($form->published==0) disabled @endif>
                                    <span class="slider"></span>
                                </label>
                            </div>

                        </form>
                        @else
                        <div class="export-container">
                            <a class="btn btn-primary" href="{{ route('form.publish.toggle',$form->id) }}">Publish</a>
                        </div>
                        @endif


                        <br>
                        @if(count($form->responses)>0)
                        <ul class="nav nav-tabs card-header-tabs justify-content-center" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="individual-tab" data-toggle="tab" href="#individual" role="tab"
                                    aria-controls="individual" aria-selected="false">Individual</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="summary-tab" data-toggle="tab" href="#summary" role="tab"
                                    aria-controls="summary" aria-selected="true">Summary</a>
                            </li>
                            {{-- <li class="nav-item">
                                <a class="nav-link" id="question-tab" data-toggle="tab" href="#question" role="tab"
                                    aria-controls="question" aria-selected="false">Question</a>
                            </li> --}}

                        </ul>
                        @endif
                    </div>
                    <div class="card-body" style="background-color: #fff0ff">
                        <div class="tab-content" id="myTabContent"
                        style="display: flex; justify-content: center; /* Centers content horizontally */
                            "
                            >
                            @if(count($form->responses)==0)
                                <div class="bg-white rounded shadow-sm p-4 question-box title-box"
                            style="padding: 10px; margin: 10px; width: 600px;">
                                    <h6 style="text-align: center">@if($form->published==0) Publish Form for Accepting Responses @else Waiting for responses @endif</h6>
                                </div>
                            @endif
                            <div class="tab-pane fade active" id="individual" role="tabpanel" aria-labelledby="individual-tab">
                                <div>
                                    {{ $responses->links() }}
                                </div>
                                @foreach ($responses as $response)
                                    <div class="bg-white rounded shadow-sm p-4 question-box title-box"
                                    style="padding: 10px; margin: 10px; width: 600px;">
                                        <div class="form-group">
                                            <h2><strong>{{ $form->name }}</strong></h2>
                                        </div>
                                        <br>
                                        <div class="form-group">
                                            <p>{{ $form->description }}</p>
                                        </div>
                                        <div class="form-group">
                                             {{ $response->user->email; }}
                                        </div>
                                    </div>

                                    @foreach ($form->questions as $question)

                                        @php

                                            $answer = [""];
                                            if($question->answers->where('response_id',$response->id)->isNotEmpty() ){
                                            $answer = $question->answers->where('response_id',$response->id)->first()->answer;
                                            }
                                        @endphp
                                        <div class="bg-white rounded shadow-sm p-4 question-box"
                                        style="padding: 10px; margin: 10px; width: 600px;">
                                        @if($question->type==1 || $question->type==2)

                                            <div class="form-group">
                                                <h4><strong>{{ $question->name }}@if ($question->required === 1)
                                                    <span style="color: red;">*</span>
                                                @endif</strong></h4>
                                            </div>
                                            <br>
                                            <div class="form-group">
                                               <p>@if($answer!==[""]) {{ $answer }} @endif</p>
                                            </div>

                                        @elseif($question->type==3)

                                            <div class="form-group">
                                                <h4><strong>{{ $question->name }}@if ($question->required === 1)
                                                    <span style="color: red;">*</span>
                                                @endif</strong></h4>
                                            </div>
                                            <br>
                                            <div class="mcq-options">
                                                @foreach ($question->options as $option)
                                                    <div class="form-check">
                                                        <input type="radio" class="form-check-input" value="{{ $option }}" @if($option==$answer) checked @endif disabled>
                                                        <label class="form-check-label" style="color: inherit;">{{ $option }}</label>
                                                    </div>
                                                @endforeach
                                            </div>

                                        @elseif($question->type==4)

                                            <div class="form-group">
                                                <h4><strong>{{ $question->name }}@if ($question->required === 1)
                                                    <span style="color: red;">*</span>
                                                @endif</strong></h4>
                                            </div>
                                            <br>
                                            <select class="form-control" disabled>
                                                @if($answer == [""])
                                                <option value="" disabled selected>Select an option</option>
                                                @else
                                                @foreach ($question->options as $option)
                                                    <option value="{{ $option }}" @if($option==$answer) selected @endif>{{ $option }}</option>
                                                @endforeach
                                                @endif
                                            </select>

                                        @elseif($question->type==5)

                                            <div class="form-group">
                                                <h4><strong>{{ $question->name }}@if ($question->required === 1)
                                                    <span style="color: red;">*</span>
                                                @endif</strong></h4>
                                            </div>
                                            <br>
                                            <div>
                                                @foreach ($question->options as $option)
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox"
                                                        @if($answer!==[""])
                                                        {{ in_array($option, (array)$answer) ? 'checked' : '' }}
                                                        @endif
                                                         value="{{ $option }}" disabled>
                                                        <label class="form-check-label">{{ $option }}</label>
                                                    </div>
                                                @endforeach
                                            </div>

                                        @endif
                                        </div>
                                    @endforeach
                                @endforeach



                            </div>
                            <div class="tab-pane fade show" id="summary" role="tabpanel"
                                aria-labelledby="summary-tab">
                                @if(count($form->responses)>0)
                                @foreach ($form->questions as $question)
                                    <div class="bg-white rounded shadow-sm p-4 question-box title-box"
                                        style="padding: 10px; margin: 10px; width: 500px;">
                                        <h3 class="card-title">{{ $question->name }}</h3>
                                        <h6>{{ count($question->answers) }} responses</h6>
                                        @if (($question->type == 1 || $question->type == 2) && count($question->answers))
                                            @foreach ($question->answers as $answer)
                                                <div class="container rounded" style="border: 1px solid #ffffff; margin-bottom: 5px; background-color: rgb(224, 222, 222)">
                                                    <p style="margin: 5px 0;">{{ $answer->answer }}</p>
                                                </div>
                                            @endforeach
                                        @elseif (($question->type == 3 || $question->type == 4) && count($question->answers))
                                            {{-- {{ dd(collect($question->answers)->groupBy('answer')) }} --}}
                                            {{-- collect($question->options) --}}
                                            <canvas id="chart-{{ $question->id }}"></canvas>
                                            <script>
                                                var ctx = document.getElementById('chart-{{ $question->id }}').getContext('2d');
                                                var chartData = {
                                                    labels: @json(collect($question->options)),
                                                    datasets: [{
                                                        label: '{{ $question->name }}',
                                                        data: @json(collect($question->answers)->groupBy('answer')->map->count()->values()),
                                                        backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF', '#FF9F40']
                                                    }]
                                                };
                                                new Chart(ctx, {
                                                    type: 'pie',
                                                    data: chartData
                                                });
                                            </script>
                                        @elseif (($question->type == 5) && count($question->answers))
                                            <canvas id="chart-{{ $question->id }}"></canvas>
                                            <script>
                                                var ctx = document.getElementById('chart-{{ $question->id }}').getContext('2d');
                                                var chartData = {
                                                    labels: @json(collect($question->options)),
                                                    datasets: [{
                                                        label: '{{ $question->name }}',
                                                        data: @json(collect($question->options)->map(function ($option) use ($question) {
                                                                return collect($question->answers)->filter(function ($response) use ($option) {
                                                                        return in_array($option, $response->answer);
                                                                    })->count();
                                                            })),
                                                        backgroundColor: '#36A2EB'
                                                    }]
                                                };
                                                new Chart(ctx, {
                                                    type: 'bar',
                                                    data: chartData,

                                                });
                                            </script>
                                        @endif
                                    </div>
                                @endforeach
                                @endif
                            </div>

                            {{-- <div class="tab-pane fade" id="question" role="tabpanel" aria-labelledby="question-tab">
                                @foreach ($form->questions as $question)
                                    <div class="container border border-dark rounded"
                                        style="padding: 10px; margin: 10px; width: 66%;">
                                        <h5 class="card-title">{{ $question->name }}</h5>
                                    </div>
                                @endforeach
                            </div> --}}

                        </div>

                    </div>
                </div>

            </div>
            <div class="col-md-4">
                <!-- Share Form Link -->
                <div class="card" >
                    <div class="card-header">
                        Share Form
                    </div>
                    <div class="card-body" style="background-color: #fff0ff">
                        <p>Share this link with others:</p>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" value="{{ route('form.getResponse', $form->id) }}" style="background-color: #fff5ff"
                                readonly>
                            <div class="input-group-append">
                                <button @if ($form->accept_response == 0) disabled @endif class="btn btn-outline-secondary"
                                    type="button" onclick="copyLink()">Copy</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript for copying link to clipboard -->
    <script>
        function copyLink() {
            var copyText = document.querySelector('.form-control');
            copyText.select();
            document.execCommand('copy');
            alert('Copied the link: ' + copyText.value);
        }
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <script>
        // $(document).ready(function() {
        //     $('.toggleButton').on('change', function() {
        //         $('#publishForm').submit();
        //     });
        // });
        $(document).ready(function() {
            $('#publishForm .toggleButton').change(function() {
                var form = $('#publishForm');
                var url = form.attr('action');
                var data = form.serialize();

                $.ajax({
                    type: form.attr('method'),
                    url: url,
                    data: data,
                    success: function(response) {
                        console.log('Success:', response);
                        // Optionally, you can update the UI based on the response
                        window.location.href = "/form/{{ $form->id }}/responses";
                    },
                    error: function(xhr, status, error) {
                        window.location.href = "/form/{{ $form->id }}/responses";
                        console.error('Error:', error);
                        // Handle the error
                    }
                });
            });
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Check for a saved tab in localStorage
            var activeTab = localStorage.getItem('activeTab');
            if (activeTab) {
                var tabElement = document.querySelector('#' + activeTab + '-tab');
                var paneElement = document.querySelector('#' + activeTab);
                if (tabElement && paneElement) {
                    // Activate the saved tab
                    tabElement.classList.add('active');
                    tabElement.setAttribute('aria-selected', 'true');
                    paneElement.classList.add('show', 'active');
                }
            }
            var summaryTab = document.querySelector('#summary-tab')
            summaryTab.classList.remove('active');
            document.querySelector('#summary').classList.remove('active');
            // Store the active tab in localStorage on tab change
            var tabLinks = document.querySelectorAll('.nav-link');
            tabLinks.forEach(function (tab) {
                tab.addEventListener('click', function (e) {
                    localStorage.setItem('activeTab', e.target.id.replace('-tab', ''));
                });
            });
        });
    </script>
    <script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>
@endsection
