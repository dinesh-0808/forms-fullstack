@extends('layouts.master-forms')

@section('css')
<link rel="stylesheet" href="{{ asset('css/styles.css') }}">

@endsection


@section('content')
<div class="container mt-5 custom-container">
    <div id="form-container">
        <div class="bg-white rounded shadow-sm p-4 question-box title-box">
            <div class="form-group">
                <h2>{{ $form->name }}</h2>
            </div>
            <br>
            <div class="form-group">
                <p>Your response has been recorded.</p>
                <p><a href="{{ route('form.getResponse',$form->id) }}">Submit Another Response</a></p>
        </div>
    </div>
</div>
@endsection
