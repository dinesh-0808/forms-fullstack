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
                <div class="card shadow mb-4" >
                    <div class="card-header py-3" style="background-color: #ffcaff">
                        <h5 class="m-0 font-weight-bold" style="color: black">User Forms</h5>
                        <div class="card-body">
                            @if (count($forms) > 0)
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>Id</th>
                                                <th>Title</th>
                                                <th>Created</th>
                                                <th>Published</th>
                                                <th>Actions</th>

                                            </tr>
                                        </thead>
                                        <tbody>

                                            @foreach ($forms as $form)
                                                <tr>
                                                    <td>
                                                        {{ (($forms->perPage())*($forms->currentPage()-1)) + $loop->iteration }}
                                                    </td>
                                                    <td>
                                                        {{ $form->name }}
                                                    </td>
                                                    <td>
                                                        {{ $form->created_at->diffForHumans() }}
                                                    </td>
                                                    <td>
                                                        @if ($form->published === 1)
                                                            <h6 style="color: green">published</h6>
                                                        @else
                                                        <h6 style="color: red">not published</h6>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if($form->published==0)
                                                            <a href="{{ route('form.edit',$form->id) }}" class="btn btn-secondary" title="Edit"><i class="fa-solid fa-pen-to-square"></i></a>
                                                        @endif
                                                        @if($form->published==1)
                                                        <a class="btn btn-secondary" href="{{ route('form.getResponse', $form->id) }}"  title="Preview"><i class="fa-solid fa-eye"></i></a>
                                                        @endif
                                                        <form action="{{ route('form.destroy', $form->id) }}" method="POST" class="delete-form" style="display: inline;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="deleteButton btn btn-danger"  title="Delete Form"><i class="fa-solid fa-trash"></i></button>
                                                        </form>

                                                        <a class="btn btn-primary" href="{{ route('form.response', $form->id) }}" title="Responses"><i class="fa-solid fa-users"></i></i></a>



                                                    </td>
                                                </tr>
                                            @endforeach


                                        </tbody>
                                    </table>
                                    {{ $forms->links() }}
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
    // Intercept the form submission
    $('.delete-form').on('submit', function(e) {
        e.preventDefault(); // Prevent the default form submission

        if(!confirm("are you sure you want to delete this form?")){
            return false;
        }

        var form = $(this);

        $.ajax({
            url: form.attr('action'),
            type: 'POST',
            data: form.serialize(),
            success: function(response) {
                // Handle success response here
                window.location.href = "/home";
                console.log('Deleted successfully.');
                // Optionally, remove the deleted item from the DOM or show a message
            },
            error: function(error) {
                window.location.href = "/home";
                // Handle error response here
                console.error('Error deleting:', error);
            }
        });
    });
});

$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();
});
    </script>
@endsection
