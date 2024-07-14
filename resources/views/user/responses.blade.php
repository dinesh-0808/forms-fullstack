@extends('layouts.app')

@section('style')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <style>
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
    </style>
@endsection
@section('content')
    <div class="container mt-4">
        @if ($form->published == 0)
            <div class="alert alert-danger">
                <h4>form not accepting responses</h4>
            </div>
        @else
            <div class="alert alert-success">
                <h4>form accepting responses</h4>
            </div>
        @endif
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <div class="row">
            <div class="col-md-8">
                <!-- Responses of the Form -->
                <div class="card">
                    <div class="card-header">
                        Responses for Form: {{ $form->name }}
                        <h3>{{ count($responses) }} responses</h3>
                        <!-- Toggle Switch for Accepting Responses -->
                        <form id="publishForm" action="{{ route('form.publish.toggle', $form->id) }}" method="POST">
                            @csrf
                            @method('POST')
                            <div class="toggle-container">
                                <span class="status">Accepting Responses</span>
                                <label class="toggle-switch">
                                    <input type="checkbox" class="toggleButton"
                                        @if ($form->published === 1) checked @endif>
                                    <span class="slider"></span>
                                </label>
                            </div>

                        </form>
                        <br>
                        <ul class="nav nav-tabs card-header-tabs justify-content-center" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="summary-tab" data-toggle="tab" href="#summary" role="tab"
                                    aria-controls="summary" aria-selected="true">Summary</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="question-tab" data-toggle="tab" href="#question" role="tab"
                                    aria-controls="question" aria-selected="false">Question</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" id="individual-tab" data-toggle="tab" href="#individual" role="tab"
                                    aria-controls="individual" aria-selected="false">Individual</a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-body">
                        {{-- @if (count($responses) > 0)
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>User</th>
                                            <th>Created</th>
                                            <th>Responses</th>
                                        </tr>
                                    </thead>

                                    <tbody>

                                        @foreach ($responses as $response)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $response->user->name }}</td>
                                                <td>{{ $response->created_at->diffForHumans() }}</td>
                                                <td>
                                                    <a href="{{ route('response.show', $response->id) }}">response</a>
                                                </td>
                                            </tr>
                                        @endforeach



                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div style="text-align: center">
                                <p>waiting for responses</p>
                            </div>
                        @endif --}}
                        <div class="tab-content" id="myTabContent"
                            style="display: flex;
    justify-content: center; /* Centers content horizontally */
">
                            <div class="tab-pane fade show active" id="summary" role="tabpanel"
                                aria-labelledby="summary-tab">
                                @foreach ($form->questions as $question)
                                    <div class="container border border-dark rounded"
                                        style="padding: 10px; margin: 10px; width: 96%;">
                                        <h3 class="card-title">{{ $question->name }}</h3>
                                        <h6>{{ count($question->answers) }} responses</h6>
                                        @if ($question->type == 1 || $question->type == 2)
                                            @foreach ($question->answers as $answer)
                                                <div class="container rounded" style="border: 1px solid #ccc;">
                                                    <p>{{ $answer->answer }}</p>
                                                </div>
                                            @endforeach
                                        @elseif ($question->type == 3 || $question->type == 4)
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
                                        @elseif ($question->type == 5)
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
                            </div>

                            <div class="tab-pane fade" id="question" role="tabpanel" aria-labelledby="question-tab">
                                @foreach ($form->questions as $question)
                                    <div class="container border border-dark rounded"
                                        style="padding: 10px; margin: 10px; width: 66%;">
                                        <h5 class="card-title">{{ $question->name }}</h5>
                                    </div>
                                @endforeach
                            </div>
                            <div class="tab-pane fade" id="individual" role="tabpanel" aria-labelledby="individual-tab">
                                @foreach ($form->questions as $question)
                                    <div class="container border border-dark rounded"
                                        style="padding: 10px; margin: 10px; width: 66%;">
                                        <h5 class="card-title">{{ $question->name }}</h5>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                    </div>
                </div>

            </div>
            <div class="col-md-4">
                <!-- Share Form Link -->
                <div class="card">
                    <div class="card-header">
                        Share Form
                    </div>
                    <div class="card-body">
                        <p>Share this link with others:</p>
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" value="{{ route('form.getResponse', $form->id) }}"
                                readonly>
                            <div class="input-group-append">
                                <button @if ($form->published == 0) disabled @endif class="btn btn-outline-secondary"
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
                        console.error('Error:', error);
                        // Handle the error
                    }
                });
            });
        });
    </script>

    <script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>
@endsection
