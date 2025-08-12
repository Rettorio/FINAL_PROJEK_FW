@extends('admin.layouts.app')
@section('title', $title)
@section('content')
    <div class="container-xxl">
        <h4 class="py-1 mb-2"><?= $title ?></h4>
        <div class="row">
            <div class="row">
                @if (session('failures'))
                    <div class="alert alert-dismissible fade show" role="alert">
                        <table class="table table-danger table-bordered" style="line-height: 1px;">
                            <tr>
                                <th>Baris</th>
                                <th>Attribut</th>
                                <th>Error</th>
                            </tr>
                            @foreach (session('failures') as $failure)
                                <tr>
                                    <td>{{ $failure->row() }}</td>
                                    <td>{{ $failure->attribute() }}</td>
                                    <td>
                                        <ul>
                                            @foreach ($failure->errors() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </td>
                                </tr>
                            @endforeach
                        </table>
                        <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
            </div>
            <div class="card">
                <div class="text-end mt-3 me-3">
                    <a href="{{ route('masyarakat.create') }}" class="btn btn-primary btn-sm rounded"><i
                            class="fa-solid fa-plus me-1"></i> Tambah Data</a>
                </div>
                <div class="card-datatable table-responsive">
                    <table class="dt-responsive table table-bordered table-hover" id="tbmasyarakat">
                        <thead>
                            <tr>
                                <th class="text-center"><b>No</b></th>
                                <th class="text-center"><b>Nama Lengkap</b></th>
                                <th class="text-center"><b>Nik</b></th>
                                <th class="text-center"><b>Umur</b></th>
                                <th class="text-center"><b>Jenis Kelamin</b></th>
                                <th class="text-center"><b>Alamat</b></th>
                                <th class="text-center"><b>Aksi</b></th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>


        <script>
        $(function() {

            load_data();

            function load_data() {

                var table = $('#tbmasyarakat').DataTable({
                    processing: true,
                    responsive: true,
                    serverSide: true,
                    stateSave: false,
                    columnDefs: [{
                            "className": "dt-center",
                            "targets": [0, 1, 3, 4, 5, 6]
                        },
                        {
                            "targets": 6,
                            "visible": 'true',
                        }

                    ],
                    ajax: {
                        url: "{{ route('masyarakat.index') }}",
                    },
                    columns: [{
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex',
                            orderable: false,
                            searchable: false
                        },
                        {
                            data: 'nama_lengkap',
                            name: 'nama_lengkap'
                        },
                        {
                            data: 'nik',
                            name: 'nik'
                        },
                        {
                            data: 'umur',
                            name: 'umur'
                        },
                        {
                            data: 'jenis_kelamin',
                            name: 'jenis_kelamin'
                        },
                        {
                            data: 'alamat',
                            name: 'alamat'
                        },
                        {
                            data: 'action',
                            name: 'action',
                            orderable: false,
                            searchable: false
                        },
                    ],

                });


                table.on('draw', function() {
                    reinitializeTooltips();
                });

                table.on('responsive-display', function() {
                    reinitializeTooltips();
                });

                function reinitializeTooltips() {
                    $('[data-bs-toggle="tooltip"]').tooltip({
                        trigger: 'hover'
                    });
                }
            }
        });
    </script>

@endsection
