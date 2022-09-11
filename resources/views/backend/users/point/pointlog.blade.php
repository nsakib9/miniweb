@extends('backend.layout.app')
@section('title', 'user Management')
@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header row">
                    <div class="col-md-6">
                        <h3 class="card-title">Point Log</h3>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>NO</th>
                                <th>ログ</th>
                                <th>日時</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $i = 1;
                            @endphp
                            @foreach ($auditLog as $audit)
                                @foreach ($audit->new_values as $key => $newVal)
                                    @if ($key == 'total_points')
                                        <tr>
                                            <td>{{ $i++ }}</td>
                                            <td>{{ $key . ' - ' . $newVal }}</td>
                                            <td>{{ $audit->updated_at->diffForHumans() }}</td>
                                        </tr>
                                    @elseif($key == 'tickets')
                                        <tr>
                                            <td>{{ $i++ }}</td>
                                            <td>{{ $key . ' - ' . $newVal }}</td>
                                            <td>{{ $audit->updated_at->diffForHumans() }}</td>
                                        </tr>
                                    @endif
                                @endforeach
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
@endpush
