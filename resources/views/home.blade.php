@extends('layouts.app')

@section('content')
    <div class="container">
        @if (Session::has('form-delete-message'))
            <div class="alert alert-danger">
                {{ Session::get('form-delete-message') }}
            </div>
        @elseif(Session('form-create-message'))
            <div class="alert alert-success">
                {{ Session::get('form-create-message') }}
            </div>
        @endif
        <div class="row">

            <div class="col-sm-3">
                <form method="post" id="create-form" action="{{ route('user.create.form') }}">
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
                            @if (count($forms) > 0)
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
                                                <th>preview</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                            @foreach ($forms as $form)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td><a href="{{ route('form.edit',$form->id) }}">{{ $form->name }}</a></td>
                                                    <td>{{ $form->created_at->diffForHumans() }}</td>
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
                                                        <div style="text-align: center;">
                                                            <form action="{{ route('form.destroy', $form->id) }}"
                                                                method="POST" id="delete-form">
                                                                @csrf
                                                                @method('DELETE')
                                                                <input type="submit" class="deleteButton btn btn-danger"
                                                                    value="delete">
                                                            </form>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <a href="{{ route('form.response', $form->id) }}">responses</a>
                                                    </td>
                                                    <td>
                                                        <a href="{{ route('form.getResponse', $form->id) }}">preview</a>
                                                    </td>
                                                </tr>
                                            @endforeach


                                        </tbody>
                                    </table>
                                @else
                                    <div class="container" style="text-align: center">
                                        <h5>No forms yet</h5>
                                        <p>Create a Form to get started</p>
                                    </div>
                            @endif
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
    <script>
        $(document).ready(function() {
            $('.deleteButton').click(function(e) {
                e.preventDefault(); // Prevent default form submission

                // Confirm deletion if needed
                if (!confirm("Are you sure you want to delete this form?")) {
                    return false;
                }

                // Perform AJAX request
                $.ajax({
                    url: $('#delete-form').attr('action'),
                    type: 'POST',
                    data: $('#delete-form').serialize(),
                    success: function(response) {
                        // Handle success response here (if needed)
                        window.location.href = "/home";
                        console.log('Deleted successfully.');
                        // Optionally, update UI or show a message
                    },
                    error: function(error) {
                        // Handle error response here (if needed)
                        console.error('Error deleting:', error);
                    }
                });
            });
        });
    </script>
@endsection
