@extends('backend.layout.app')
@section('title', 'Role Management')
@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Create A New User</h3>
                    
                </div>
                @include('backend.partials.message')
                <!-- /.card-header -->
                <!-- form start -->
                <form action="{{route('users.store')}}" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="form-row">
                            <div class="form-group col-md-6 col-sm-12">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" name="name" id="name" placeholder="Enter your  Name">
                            </div>
                            <div class="form-group col-md-6 col-sm-12">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" name="email" id="email" placeholder="Enter your email">
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="form-group col-md-6 col-sm-12">
                                <label for="password">Password</label>
                                <input type="password" class="form-control" name="password" id="password" placeholder="Enter your password">
                            </div>
                            <div class="form-group col-md-6 col-sm-12">
                                <label for="password_confirmation">Confirm Password</label>
                                <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" placeholder="Enter the password again">
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="form-group col-md-6 col-sm-12">
                                <label for="roles">Assign Roles</label>
                                <select name="role" id="roles" class="form-control">
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->name }}"> {{ $role->name }} </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        
                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Create User</button>
                    </div>
                </form>
            </div>
        </div><!-- /.container-fluid -->
    </section>
@endsection

@push('custom_script')
@endpush
