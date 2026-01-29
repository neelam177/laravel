<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>
        SIMPLE LARAVEL 12 CRUD
    </title>    
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
</head>
<body class="">
    <div class="bg-dark py-3">
        <div class="container">
            <div class="h4 text-white">SIMPLE LARAVEL 12 CRUD</div>
        </div>
    </div>

    <div class="container">
        @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        @endif
        
        <div class="d-flex justify-content-between py-3">
            <div class="h4">Employees</div>
            <div>
                <a href="{{ route('employees.create') }}" class="btn btn-primary">Create</a>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-lg container">
        <div class="card-body">
            <table class="table table-striped">
                   <tr>
                    <th>Id</th>
                    <th>Image</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Address</th>
                    <th>Action</th>
                </tr>
                @if($employee->count() > 0)
                @foreach($employee as $emp)
                    <tr>
                    <td>{{ $emp->id }}</td>
                    <td>
                        @if($emp->image != '' && file_exists(public_path().'/uploads/employees/'.$emp->image))
                            <img src="{{ url('uploads/employees/'. $emp->image) }}" width="50" height="50" alt="" class="rounded-circle">
                        @else
                            <img src="{{ asset('assets/images/no-image.png') }}" width="50" height="50" alt="" class="rounded-circle">
                        @endif
                    </td>
                    <td>{{ $emp->name }}</td>
                    <td>{{ $emp->email }}</td>
                    <td>{{ $emp->address }}</td>
                    <td>
                        <a href="{{ route('employees.edit',$emp->id) }}" class="btn btn-primary btn-sm">Edit</a>
                        <a href="#" class="btn btn-danger btn-sm">Delete</a>
                    </td>
                </tr>
                @endforeach
                @else
                <tr>
                    <td colspan="6" class="text-center">No employees found</td>
                </tr>
                @endif
            </table>
        </div>
    </div>
    
    <div class="mt-3 container">
        {{ $employee->links() }}
    </div>
</body>
</html>