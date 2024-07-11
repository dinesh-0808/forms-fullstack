@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-sm-3">
                <form method="post" action="{{ route('user.create.form') }}">
                    @csrf

                    <div class="form-group">
                        <label for="title">Form Name</label>
                        <input type="text" id="title" name="title"
                            class="form-control @error('title')
                        is-invalid
                    @enderror">

                        <div>
                            @error('title')
                                <span><strong>{{ $message }}</strong></span>
                            @enderror
                        </div>
                        <br>
                    </div>
                    <button type="submit" id="title" class="btn btn-primary">Create</button>
                </form>
            </div>
            <div class="col-sm-9">
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">User Forms</h6>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Title</th>
                                            <th>Created At</th>
                                            <th>Published</th>
                                            <th>Delete</th>
                                            <th>Responses</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th>Id</th>
                                            <th>Title</th>
                                            <th>Created At</th>
                                            <th>Published</th>
                                            <th>Delete</th>
                                            <th>Responses</th>
                                        </tr>
                                    </tfoot>
                                    <tbody>

                                        @foreach ($forms as $form)
                                            <tr>
                                                <td>{{ $form->id }}</td>
                                                <td>{{ $form->name }}</td>
                                                <td>{{ $form->created_at }}</td>
                                                <td>

                                                    {{-- <div class="toggle-container">
                                                        <label class="toggle-switch">
                                                            <input type="checkbox" class="toggleButton"
                                                                @if ($form->published === 1) checked @endif disabled>
                                                            <span class="slider"></span>
                                                        </label>
                                                    </div> --}}
                                                    @if ($form->published === 1)
                                                        published
                                                    @else
                                                        not published
                                                    @endif

                                                </td>
                                                <td>
                                                    <form action="{{ route('form.destroy', $form->id) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')
                                                        <input type="submit" class="btn btn-danger"name="delete">
                                                    </form>
                                                </td>
                                                <td><a href="{{ route('form.response', $form->id) }}">responses</a>
                                                </td>
                                            </tr>
                                        @endforeach


                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    @endsection


    @section('scripts')
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
        {{-- <script>
    $(document).ready(function() {
        $('.toggleButton').on('change', function() {
            $('#publishForm').submit();
        });
    });
</script> --}}
    @endsection
