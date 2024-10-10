@extends('layouts.app')

@section('content')
    <div class="page-header">
        <div class="container-fluid">
            <h2 class="h5 no-margin-bottom">{{ __('Animes') }}</h2>
        </div>
    </div>
    <section class="mt-4">
        <div class="container-fluid">

            @if (session()->has('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>{{ __('Success!') }}</strong> {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @elseif(session()->has('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>{{ __('Error!') }}</strong> {{ session('error') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            <div class="block">
                <div class="title d-flex justify-content-between align-items-center">
                    <strong>{{ __('Animes') }}</strong>
                    <div>
                        <a href="{{ route('admin.animes.generate') }}" class="btn btn-sm btn-info">
                            <i class="fa fa-fw fa-magic"></i>
                            {{ __('Generate') }}
                        </a>
                    </div>
                </div>

                <div class="block-body">
                    <div class="table-responsive">
                        <table id="datatableAnimes" style="width: 100%;" class="table">
                            <thead>
                                <tr>
                                    <th>{{ __('Name') }}</th>
                                    <th>{{ __('Name Alternative') }}</th>
                                    <th>{{ __('Aired') }}</th>
                                    <th>{{ __('Status') }}</th>
                                    <th>{{ __('Options') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Modal de confirmación para eliminar -->
    <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModalLabel">{{ __('Confirm Deletion') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    {{ __('Are you sure you want to delete this anime?') }}
                </div>
                <div class="modal-footer">
                    <form id="deleteForm" method="POST" action="">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{ __('Cancel') }}</button>
                        <button type="submit" class="btn btn-danger">{{ __('Delete') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <!-- DataTables CSS-->
    <link rel="stylesheet" href="{{ asset('assets/admin/css/dataTables.bootstrap4.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/css/responsive.bootstrap4.min.css') }}">
@endpush

@push('scripts')
    <!-- Data Tables-->
    <script src="{{ asset('assets/admin/js/jquery.dataTables.js') }}"></script>
    <script src="{{ asset('assets/admin/js/dataTables.bootstrap4.js') }}"></script>
    <script src="{{ asset('assets/admin/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('assets/admin/js/responsive.bootstrap4.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('#datatableAnimes').DataTable({
                "serverSide": true,
                "ajax": {
                    "url": "{{ route('admin.animes.data') }}",
                    "type": "GET"
                },
                "columns": [{
                        "data": "name",
                        "render": function(data, type, row) {
                            return `<div class="truncate" style="max-width: 350px;">${data}</div>`;
                        }
                    },
                    {
                        "data": "name_alternative",
                        "render": function(data, type, row) {
                            return `<div class="truncate" style="max-width: 300px;">${data}</div>`;
                        }
                    },
                    {
                        "data": "aired"
                    },
                    {
                        "data": "status",
                        "render": function(data, type, row) {
                            if (data == 0) {
                                return '<span class="badge badge-danger">{{ __('Finalizado') }}</span>';
                            } else {
                                return '<span class="badge badge-success">{{ __('En Emisión') }}</span>';
                            }
                        }
                    },
                    {
                        "data": null,
                        "orderable": false,
                        "searchable": false,
                        "render": function(data, type, row) {
                            return `
                                <div class="btn-group" role="group" aria-label="Action Buttons">
                                    <a href="/admin/animes/${row.id}/edit" class="btn btn-warning btn-sm">
                                        <i class="fa fa-wrench"></i>
                                    </a>
                                    <button type="button" class="btn btn-danger btn-sm" data-toggle="modal"
                                        data-target="#deleteModal" data-animeid="${row.id}">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </div>
                            `;
                        }
                    }
                ],
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.21/i18n/Spanish.json"
                },
                "ordering": false
            });

            $('#deleteModal').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget);
                var animeId = button.data('animeid');
                var action = '{{ route('admin.animes.destroy', ':id') }}';
                action = action.replace(':id', animeId);
                $('#deleteForm').attr('action', action);
            });
        });
    </script>
@endpush
