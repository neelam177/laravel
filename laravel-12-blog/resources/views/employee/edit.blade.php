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

<body>
    <div class="bg-dark py-3">
        <div class="container">
            <div class="h4 text-white">SIMPLE LARAVEL 12 CRUD</div>
        </div>
    </div>

    <div class="container">
        <div class="d-flex justify-content-between py-3">
            <div class="h4">Edit Employees</div>
            <div>
                <a href="{{ route('employees.index') }}" class="btn btn-primary">Back</a>
            </div>
        </div>
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

    </div>
    <form action="{{ route('employees.update', $employee->id) }}" class="container" method="post"
        enctype="multipart/form-data">
        {{-- Cross Site Request Forgery(it is a form token security add) --}}
        @csrf
        @method('PUT')

        <div class="card border-0 shadow-lg">
            <div class="card-body">
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" name="name" id="name" placeholder="Enter Name"
                        class="form-control
                    @error('name') is-invalid @enderror"
                        value="{{ old('name', $employee->name) }}">
                    @error('name')
                        <p class="invalid-feedback">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="text" name="email" id="email" placeholder="Enter Email"
                        class="form-control     
                    {{-- is-invalid = red border --}}
                    @error('email') is-invalid @enderror"
                        value="{{ old('email', $employee->email) }}">
                    @error('email')
                        <p class="invalid-feedback">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="address" class="form-label">Address</label>
                    <textarea name="address" id="address" cols="30" rows="4" placeholder="Enter address" class="form-control">{{ old('address', $employee->address) }}</textarea>
                </div>
                <div class="mb-3">
                    <label for="image" class="form-label">Image</label>
                    <input type="file" name="image" class="form-control @error('image') is-invalid @enderror">
                    @error('image')
                        <p class="invalid-feedback">{{ $message }}</p>
                    @enderror
                    <div class="pt-3">
                        @if ($employee->image != '' && file_exists(public_path() . '/uploads/employees/' . $employee->image))
                            <img src="{{ url('uploads/employees/' . $employee->image) }}" width="100" height="100"
                                alt="">
                        @endif
                    </div>
                </div>

            </div>
        </div>
        <button class="btn btn-primary my-3">Upadate Employees</button>
    </form>
</body>

</html>
