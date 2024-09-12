@extends('template')

@section('title', 'Tambah Karyawan')

@section('content')

    <form id="employee-form" action="{{ route('employee.store') }}" method="post" enctype="multipart/form-data">
        @csrf
        @if ($errors->any())
            {!! implode('', $errors->all('<div>:message</div>')) !!}
        @endif


        <div class="row py-2">
            <div class="form-group col-md-6 order-last">
                <label for="picture">Picture</label>
                <input id="picture" name="picture" type="file">
            </div>

            <div class="form-group col-md-6">
                <label for="first_name">Nama Depan</label>
                <input type="text" id="first_name" class="form-control" name="first_name" value="{{ old('first_name') }}"
                    required>
            </div>

            <div class="form-group col-md-6">
                <label for="last_name">Nama Belakang</label>
                <input type="text" id="last_name" class="form-control" name="last_name" required
                    value="{{ old('last_name') }}">
            </div>

            <div class="form-group col-md-6">
                <label for="position">Posisi</label>
                <select name="position" class="form-control" required>
                    <option selected disabled>Pilih Posisi</option>
                    @foreach ($positions as $position)
                        <option value="{{ $position->id }}">{{ $position->title }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group col-md-6">
                <label for="email">Email</label>
                <input type="email" id="email" class="form-control" name="email" required>
            </div>

            <div class="form-group col-md-6">
                <label for="phone">No. HP</label>
                <input type="tel" id="phone" class="form-control" name="phone" required>
            </div>

            <div class="form-group col-md-6">
                <label for="date_of_birth">Tangal Lahir</label>
                <input type="date" id="date_of_birth" class="form-control" name="date_of_birth" required>
            </div>

            <div class="form-group col-md-6 order-last">
                <label for="address">Alamat</label>
                <textarea name="address" id="address" rows="5" class="form-control" required></textarea>
            </div>

            <div class="form-group col-md-6">
                <label for="gender">Jenis Kelamin</label>
                <select id="gender" class="form-control" name="gender" required>
                    <option value="0">Male</option>
                    <option value="1">Female</option>
                </select>
            </div>

            <div class="form-group col-md-6">
                <label for="contract">Tanggal Kontrak</label>
                <input type="text" id="contract" class="form-control datepicker" name="contract" required>

                <input type="hidden" name="hire_date">
                <input type="hidden" name="end_date">
            </div>

            <div class="form-group col-md-6">
                <label for="status">Status</label>
                <select name="status" id="status" class="form-control">
                    <option value="0">Inactive</option>
                    <option value="1">Active</option>
                </select>
            </div>

            <div class="form-group col-md-6">
                <label for="salary">Gaji</label>
                <input type="number" id="salary" class="form-control" name="salary" value="{{ old('salary') }}"
                    required>
            </div>
        </div>


        <button class="btn btn-success" type="submit">Submit</button>
    </form>


@endsection

@push('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-fileinput/css/fileinput.min.css" media="all" rel="stylesheet"
        type="text/css" />
    <style>
        .error {
            color: red;
        }
    </style>
@endpush

@push('js')
    <script src="{{ asset('js/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('js/moment.min.js') }}"></script>
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

    {{-- <script src="{{ asset('js/daterangepicker.min.js') }}"></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap-fileinput/js/fileinput.min.js"></script>

    <script>
        // jQuery Validator
        $(document).ready(function() {
            $('#employee-form').validate();

            var start = moment();
            var end = moment().add(30, 'd');

            function cb(start, end) {
                $('input[name=hire_date]').val(start)
                $('input[name=end_date]').val(end)
                $('#contract').val(start.format('DD MMM YYYY') + ' - ' + end.format('DD MMM YYYY'));
            }

            $('#contract').daterangepicker({
                startDate: start,
                endDate: end,
                ranges: {
                    'Today': [moment(), moment()],
                    '1 Month': [moment(), moment().add(1, 'M')],
                    '3 Month': [moment(), moment().add(3, 'M')],
                    '6 Month': [moment(), moment().add(6, 'M')],
                    '1 Year': [moment(), moment().add(1, 'Y')],

                }
            }, cb);

            cb(start, end);

            $('#picture').fileinput({
                theme: 'fa',
                uploadUrl: "{{ route('employee.storeImage') }}",
                uploadExtraData: function() {
                    return {
                        _token: '{{ csrf_token() }}'
                    };
                },
                allowedFileExtensions: ['jpg', 'jpeg', 'png'],
                maxFileSize: 2048,
                showUpload: true,
                dropZoneEnabled: true,
                maxFileCount: 1,
                layoutTemplates: {
                    main2: '{preview} {remove} {browse}'
                },
            });

            $('#picture').on('fileuploaded', function(event, data, previewId, index) {
                var response = data.response;
                console.log('success upload')
                $('<input>').attr({
                    type: 'hidden',
                    name: 'picture_path',
                    value: response.filepath
                }).appendTo('#employee-form');

            });
        });
    </script>
@endpush
