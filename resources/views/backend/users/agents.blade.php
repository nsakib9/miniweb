@extends('backend.layout.app')
@section('title','user Management')
@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header row">
              <div class="col-md-6"><h3 class="card-title">Agent List</h3></div>
              <div class="col-md-6"><a href="{{route('users.create')}}" class="btn btn-success float-right">Create User</a></div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              @include('backend.partials.message')
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>SL</th>
                  <th>Name</th>
                  <th>Email</th>
                  <th>Action</th>
                </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                      <tr>
                        <td>{{ $loop->index+1 }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>
                            <a href="{{route('users.edit', $user->id)}}" class="btn btn-info"><i class="fas fa-edit"></i></a>
                            <a class="btn btn-danger" href="{{ route('users.destroy', $user->id) }}" class="nav-link"
                                onclick="event.preventDefault(); document.getElementById('delete-form-{{$user->id}}').submit();">
                                <i class="fas fa-trash"></i>
                            </a>
                            <form id="delete-form-{{$user->id}}" action="{{ route('users.destroy', $user->id) }}" method="POST" style="display: none;">
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
        "buttons": ["Create user"]
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