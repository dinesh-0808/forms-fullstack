@extends('layouts.app')

@section('style')
<style>
    .toggle-container {
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

input:checked + .slider {
    background-color: #2196F3;
}

input:checked + .slider:before {
    transform: translateX(15.6px);
}
</style>

@endsection
@section('content')
<div class="container mt-4">
    <div class="row">
        <div class="col-md-8">
            <!-- Responses of the Form -->
            <div class="card">
                <div class="card-header">
                    Responses for Form: {{ $form->name }}
                </div>
                <div class="card-body">
                    <!-- Toggle Switch for Accepting Responses -->
                    <form id="publishForm" action="{{ route('form.publish.toggle', $form->id) }}" method="POST">
                        @csrf
                        @method('POST')
                        <div class="toggle-container">
                            <span class="status">Accepting Responses</span>
                            <label class="toggle-switch">
                                <input type="checkbox" class="toggleButton"
                                @if($form->published === 1)
                                    checked
                                @endif
                                >
                                <span class="slider"></span>
                            </label>
                        </div>
                    </form>



                    <!-- Responses Display Section -->
                    <div class="responses-list">
                        {{-- Iterate through responses --}}
                        {{-- @foreach($form->responses as $response) --}}
                        {{-- <div class="mb-3">
                            <h5>{{ $response->created_at->format('M d, Y H:i:s') }}</h5>
                            <p>{{ $response->content }}</p>
                        </div> --}}
                        {{-- @endforeach --}}
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
                        <input type="text" class="form-control" value="{{ route('form.getResponse',$form->id) }}" readonly>
                        <div class="input-group-append">
                            <button class="btn btn-outline-secondary" type="button" onclick="copyLink()">Copy</button>
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
    $(document).ready(function() {
        $('.toggleButton').on('change', function() {
            $('#publishForm').submit();
        });
    });
</script>
@endsection
