@extends('backend.layout.app')
@section('title','user Management')
@section('content')
<section class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header row">
              <div class="col-md-6"><h3 class="card-title">User Log</h3></div>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <div class="container mb-5">
                    <div class="row">
                        <div class="col-md-8 row">
                            <div class="col-2 font-weight-bold">UserName</div>
                            <div class="col-10"> : {{$user->name}}</div>
                        </div>
                        <div class="col-md-4 row text-right">
                            <div class="col-10 font-weight-bold">Total Points</div>
                            <div class="col-2"> : {{$user->total_points % 50}}</div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-8 row">
                            <div class="col-2 font-weight-bold">Email</div>
                            <div class="col-10"> : {{$user->email}}</div>
                        </div>
                        <div class="col-md-4 row text-right">
                            <div class="col-10 font-weight-bold">Total Number of Tickets</div>
                            <div class="col-2"> : {{floor($user->total_points/50)}}</div>
                        </div>
                    </div>
                </div>
              @include('backend.partials.message')
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>NO</th>
                  <th>メールアドレス</th>
                  <th>獲得ポイント</th>
                  <th>日時</th>
                  <th>ステータス</th>
                  <th>編集削除</th>
                </tr>
                </thead>
                <tbody>
                    @foreach ($points as $point)
                      <tr>
                        <td>{{ $loop->index+1 }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $point->score }}</td>
                        <td>{{ $point->created_at }}</td>
                        <td>{{ ($point->score == null)? '失敗' : "成功" }}</td>
                        <td>
                            {{-- <a href="{{route('score.edit', $point->id)}}" class="btn btn-info"><i class="fas fa-edit"></i></a> --}}
                            {{-- <a class="btn btn-danger" href="{{ route('users.destroy', $point->id) }}" class="nav-link"
                                onclick="event.preventDefault(); document.getElementById('delete-form-{{$point->id}}').submit();">
                                <i class="fas fa-trash"></i>
                            </a>
                            <form id="delete-form-{{$point->id}}" action="{{ route('users.destroy', $point->id) }}" method="POST" style="display: none;">
                              @method('DELETE')
                                @csrf
                            </form> --}}
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