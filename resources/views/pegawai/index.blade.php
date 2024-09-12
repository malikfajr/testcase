@extends('template')

@section('title')
    Daftar Pegawai
@endsection

@section('content')
    <div>
        <h1 class="pb-2">Daftar Pegawai</h1>


        <table id="tbl_pegawai" class="table table-striped" style="width:100%">
            <thead>
                <th>Picture</th>
                <th>Nama</th>
                <th>Posisi</th>
                <th>Email</th>
                <th>No. HP</th>
                <th>Alamat</th>
                <th>Jenis Kelamin</th>
                <th>Tanggal Bergabung</th>
                <th>Akhir Kontrak</th>
                <th>Status</th>
                <th>Gaji</th>

            </thead>
            <tfoot>
                <th>Picture</th>
                <th>Nama</th>
                <th>Posisi</th>
                <th>Email</th>
                <th>No. HP</th>
                <th>Alamat</th>
                <th>Jenis Kelamin</th>
                <th>Tanggal Bergabung</th>
                <th>Akhir Kontrak</th>
                <th>Status</th>
                <th>Gaji</th>

            </tfoot>
            <tbody></tbody>
        </table>
    </div>
@endsection

@push('css')
    <link rel="stylesheet" href="{{ asset('css/datatables.css') }}">
@endpush

@push('js')
    <script src="{{ asset('js/datatables.js') }}"></script>
    <script src="{{ asset('js/moment.min.js') }}"></script>

    <script>
        let table = $('#tbl_pegawai').DataTable({
            processing: true,
            serverSide: true,
            layout: {
                topStart: {
                    buttons: ['copy', 'pageLength', 'colvis', {
                        extend: 'spacer',
                        style: 'bar',
                    }, {
                        text: 'Tambah Data',
                        action: function(e, dt, node, config) {
                            window.location.href = base_url + '/add';
                        },
                        init: function(e, dt, node, config) {
                            $(dt).removeClass('btn-secondary')
                        },
                        className: 'btn-primary'
                    }]
                }
            },
            ajax: {
                url: base_url + '/api/employees',
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'Application/json'
                },
                data: function(d) {
                    return JSON.stringify(d);
                }
            },
            columns: [{
                    data: 'picture',
                    orderable: false,
                    targets: 'no-sort',
                    width: '60px',
                    render: function(data, type, row) {
                        let source = "{{ asset('storage') }}/" +
                            data;

                        if (data.startsWith('http://') || data.startsWith('https://')) {
                            source = data
                        }

                        return '<img src="' + source + '" class="img-fluid img-thumbnail" alt="' + row
                            .last_name +
                            '"/>'
                    }
                }, {
                    data: 'name'
                },
                {
                    data: 'position_name'
                },
                {
                    data: 'email'
                }, {
                    data: 'phone'
                }, {
                    data: 'address',
                    visible: false
                }, {
                    data: 'jk',
                    visible: false
                }, {
                    data: 'hire_date',
                    render: function(data, type, row) {
                        return moment(data).format("DD MMMM YYYY")
                    },
                    visible: false
                }, {
                    data: 'end_date',
                    render: function(data, type, row) {
                        return moment(data).format("DD MMMM YYYY")
                    }
                }, {
                    data: 'status',
                    render: function(data, type, row) {
                        if (data) {
                            return 'active'
                        }

                        return 'inative'
                    }
                }, {
                    data: 'salary',
                    render: $.fn.dataTable.render.number(',', '.', 2, 'Rp '),
                }
            ],
            order: [
                [8, 'desc']
            ],
            searching: true,
            ordering: true
        })
    </script>
@endpush
