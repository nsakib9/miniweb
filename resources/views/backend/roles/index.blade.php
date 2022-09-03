@extends('backend.layout.app')
@section('title','Role Management')
@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header row">
              <div class="col-md-6"><h3 class="card-title">Role Management</h3></div>
              <div class="col-md-6"><a href="{{route('roles.create')}}" class="btn btn-success float-right">Create Role</a></div>
              
              
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              @include('backend.partials.message')
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>SL</th>
                  <th>Name</th>
                  <th>Permissions</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
                    @foreach ($roles as $role)
                      <tr>
                        <td>{{ $loop->index+1 }}</td>
                        <td>{{ $role->name }}</td>
                        <td>
                          @foreach ($role->permissions as $perm)
                              <span class="badge badge-info py-2 my-2">
                                {{ $perm->name}}
                              </span>
                          @endforeach
                        </td>
                        <td>
                            <a href="{{route('roles.edit', $role->id)}}" class="btn btn-info"><i class="fas fa-edit"></i></a>
                            <a class="btn btn-danger" href="{{ route('roles.destroy', $role->id) }}" class="nav-link"
                                onclick="event.preventDefault(); document.getElementById('delete-form-{{$role->id}}').submit();">
                                <i class="fas fa-trash"></i>
                            </a>
                            <form id="delete-form-{{$role->id}}" action="{{ route('roles.destroy', $role->id) }}" method="POST" style="display: none;">
                              @method('DELETE')
                                @csrf
                            </form>
                        </td>
                      </tr>
                    @endforeach
                </tbody>
              </table>
            </div>
            <!-- /.card-body -->
          </div>
          <!-- /.card -->
    </div><!-- /.container-fluid -->
  </section>
@endsection

@push('custom_script')
<script>
    $(function () {
      $("#example1").DataTable({
        "responsive": true, "lengthChange": false, "autoWidth": false,
        "buttons": ["Create Role"]
      }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
      $('#example2').DataTable({
        "paging": true,
        "lengthChange": false,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": false,
        "responsive": true,
      });
    });
  </script>
@endpush