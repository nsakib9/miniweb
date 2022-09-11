@extends('backend.layout.app')
@section('title', 'user Management')
@section('content')

    <div style="display: none">
    <section class="content">
        <div class="container-fluid">

            <div class="card">
                <div class="card-header row">
                    <div class="col-md-6">
                        <h3 class="card-title">{{ env('APP_NAME') }}</h3>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <div class="card">
                        <div class="card-body">
                            <h3>
                                {{ Auth::user()->name }}
                            </h3>
                        </div>
                    </div>
                    <h4>
                        @if (Auth::user()->total_points > 0)
                            {{ Auth::user()->total_points }}
                        @else
                            0
                        @endif
                        <sup>/50</sup> Pt
                    </h4>
                    <p>
                        @if (Auth::user()->total_points > 0)
                            {{ 50 - Auth::user()->total_points }}
                        @else
                            0
                        @endif Pt to get a ticket
                    </p>
                </div>
                <div class="card-footer">
                    Holding Ticket @if (Auth::user()->tickets > 0)
                        {{ Auth::user()->tickets }}
                    @else
                        0
                    @endif
                    <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#modal-default">
                        Exchange Ticket
                    </button>
                    @include('backend.partials.message')
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    Recently
                </div>
                <div class="card-body">
                    <table class="table table-bordered">

                        @foreach ($auditLog as $audit)
                            @foreach ($audit->new_values as $key => $newVal)
                                @if ($key == 'score')
                                    <tr>
                                        <td>{{ $newVal }}pt</td>
                                        <td>{{ $audit->updated_at->format('Y/m/d') }}</td>
                                    </tr>
                                @elseif($key == 'ticket')
                                    <tr>
                                        <td>Exchange {{ $newVal }} Tickets </td>
                                        <td>{{ $audit->updated_at->format('Y/m/d') }}</td>
                                    </tr>
                                @endif
                            @endforeach
                        @endforeach
                    </table>

                </div>
            </div>
            <!-- /.card -->

            <div class="modal fade" id="modal-default">
                <div class="modal-dialog">
                    <form action="{{ route('ticket.exchange') }}" method="POST">
                        @csrf
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4 class="modal-title">Default Modal</h4>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <input type="number" name="exchangeTicket">
                            </div>
                            <div class="modal-footer justify-content-between">
                                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary">Exchange</button>
                            </div>
                        </div>
                    </form>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>
            <!-- /.modal -->
        </div><!-- /.container-fluid -->
    </section>
    </div>

    <section>
        <div class="w_35x mx-auto">
            <div class="bg-dark text-white p-3">
                <h4 class="px-3">{{ env('APP_NAME') }}</h4>

                <div class="border px-3 my-3">
                    <p>ユーザー名</p>
                    <h4>{{ Auth::user()->name }}</h4>
                </div>

                <h3 class="px-3">
                    @if (Auth::user()->total_points > 0)
                        {{ Auth::user()->total_points }}
                    @else
                        0
                    @endif 
                    <sup class="fz-1-5x">/50</sup>
                    <span class="ml-3">Pt</span>
                </h3>

                <p class="px-3">
                        @if (Auth::user()->total_points > 0)
                            <span class="fz-3x">
                                {{ 50 - Auth::user()->total_points }}
                            </span>
                        @else
                            <span class="fz-3x">0</span>
                        @endif Ptでチケットをゲット
                </p>

                <div class="border px-3 d-flex align-items-center justify-content-between">
                    <p>
                        開催チケット  
                        <span class="fz-3x">
                            @if (Auth::user()->tickets > 0)
                                {{ Auth::user()->tickets }}
                            @else
                                0
                            @endif
                        </span>
                    </p>
                    <button class="bbtn_2" data-toggle="modal" data-target="#modal-default2">引換券</button>
                </div>
                @include('backend.partials.message')
            </div>

            <div>
                <p class="px-3 my-2">最近</p>
                <table class="table">
                    <tbody>
                        @foreach ($auditLog as $audit)
                            @foreach ($audit->new_values as $key => $newVal)
                                @if ($key == 'score')
                                    <tr>
                                        <td class="px-3">{{ $newVal }}pt</td>
                                        <td class="px-3 text-center">{{ $audit->updated_at->format('Y/m/d') }}</td>
                                    </tr>
                                @elseif($key == 'ticket')
                                    <tr>
                                        <td class="px-3">交換 {{ $newVal }} 切符売場 </td>
                                        <td class="px-3 text-center">{{ $audit->updated_at->format('Y/m/d') }}</td>
                                    </tr>
                                @endif
                            @endforeach
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="modal fade" id="modal-default2">
            <div class="modal-dialog">
                <form action="{{ route('ticket.exchange') }}" method="POST">
                    @csrf
                    <div class="modal-content border-0 w_35x mx-auto">
                        <div class="bg-dark text-white p-3">
                            <div class="px-3 my-3">
                                <p>ユーザー名</p>
                                <h4>{{ Auth::user()->name }}</h4>
                            </div>
            
                            <div class="border px-3 d-flex align-items-center justify-content-between mb-3">
                                <p class="my-2">
                                    開催チケット  
                                    <span class="fz-3x">
                                        @if (Auth::user()->tickets > 0)
                                            {{ Auth::user()->tickets }}
                                        @else
                                            0
                                        @endif
                                    </span>
                                </p>
                            </div>
    
                            <div class="d-flex justify-content-between">
                                <input type="number" name="exchangeTicket" class="form-control w-50">
                                <button type="submit" class="bbtn_2">交換</button>
                            </div>

                           
                        </div>
                    </div>
                </form>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
    </section>
@endsection

@push('custom_script')
    <script>
        $(function() {
            $("#example1").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
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
