@extends('backend.layout.app')
@section('title', 'Role Management')
@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Create A New Role</h3>
                    
                </div>
                @include('backend.partials.message')
                <!-- /.card-header -->
                <!-- form start -->
                <form action="{{route('roles.store')}}" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" class="form-control" name="name" id="name" placeholder="Enter a Role Name">
                        </div>
                        <div class="form-group">
                            <label for="name">Permissions</label>
                            @foreach ($permissions as $permission)
                            <div class="form-check">
                                <input type="checkbox" name="permissions[]" class="form-check-input" id="checkPermission{{$permission->id}}" value="{{ $permission->name}}">
                                <label class="form-check-label" for="checkPermission{{$permission->id}}">{{ $permission->name }}</label>
                            </div>
                            @endforeach
                        </div>
                        
                    </div>
                    <!-- /.card-body -->

                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Create Role</button>
                    </div>
                </form>
            </div>
        </div><!-- /.container-fluid -->
    </section>
@endsection

@push('custom_script')
@endpush
