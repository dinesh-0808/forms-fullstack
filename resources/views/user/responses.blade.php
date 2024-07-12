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
        @if($form->published==0)
        <div class="alert alert-danger">
            <h4>form not accepting responses</h4>
        </div>
        @else
        <div class="alert alert-success">
        <h4>form accepting responses</h4>
        </div>
        @endif
        <div class="row">
            <div class="col-md-8">
                <!-- Responses of the Form -->
                <div class="card">
                    <div class="card-header">
                        Responses for Form: {{ $form->name }}
                    </div>
                    <div class="card-body">
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



                        <!-- Responses Display Section -->
                        {{-- <div class="responses-list"> --}}
                            {{-- Iterate through responses --}}
                            {{-- @foreach ($form->responses as $response)
                                <div class="mb-3">
                                    <h5>{{ $response->created_at->format('M d, Y H:i:s') }}</h5>
                                    <p>{{ $response->user_id }}</p>
                                </div>
                            @endforeach --}}
                        {{-- </div> --}}
                        <br>
                        @if (count($responses)>0)
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
                                            <td>Responses</td>
                                        </tr>
                                    @endforeach



                                </tbody>
                            </table>
                        </div>
                        @else
                        <div style="text-align: center">
                            <p>waiting for responses</p>
                        </div>
                        @endif
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
                                <button @if($form->published==0) disabled @endif class="btn btn-outline-secondary" type="button" onclick="copyLink()">Copy</button>
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
    <script>
        // $(document).ready(function() {
        //     $('.toggleButton').on('change', function() {
        //         $('#publishForm').submit();
        //     });
        // });
        $(document).ready(function(){
            $('#publishForm .toggleButton').change(function(){
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
@endsection
