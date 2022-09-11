@extends('backend.layout.app')
@section('title', 'user Management')
@section('content')
    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header row">
                    <div class="col-md-6">
                        <h3 class="card-title">User Log</h3>
                    </div>
                </div>
                <!-- /.card-header -->
                <div class="card-body">
                    <button type="button" class="btn btn-default" data-toggle="modal" data-target="#modal-default">
                        Launch Default Modal
                    </button>
                    @include('backend.partials.message')
                </div>
                <!-- /.card-body -->
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
                                <button type="submit" class="btn btn-primary">Save changes</button>
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
