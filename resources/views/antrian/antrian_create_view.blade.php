@extends('adminlte::page')

@section('title','Pendaftaran Antrian Pasien')
@section('css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
@stop
@section('content_header')
<h1>Pendaftaran Antrian Pasien</h1>
@stop

@section('content')
<div id="layoutSidenav">
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid">
                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                <form method="POST" action="{{ route('antrian.store') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="row">

                        <x-adminlte-card class="col-md-12" theme-mode="full">
                            @isset($pasien)
                            <div class="row">
                                <div class="col-md-12 border-bottom mb-3">
                                    {{-- With multiple slots, plugin config parameter and custom options --}}
                                    @php
                                    $config = [
                                    "title" => "Import Data Pasien",
                                    "liveSearch" => true,
                                    "liveSearchPlaceholder" => "Search..."
                                    ];
                                    @endphp
                                    <x-adminlte-select-bs id="pasien" name="pasien" label="Data Pasien"
                                        :config="$config">

                                        <x-slot name="appendSlot">
                                            <x-adminlte-button id="importButton" theme="success" label="Import"
                                                icon="fas fa-lg fa-file-import" />
                                        </x-slot>
                                        @foreach ($pasien as $data)
                                        <option value="{{$data->nik .' - '. $data->nama .' - '.
                                            $data->alamat .' - '. $data->kartu}}">{{$data->nik .' - '. $data->nama .' -
                                            '.
                                            $data->alamat .' - '. $data->kartu}}</option>
                                        @endforeach
                                    </x-adminlte-select-bs>
                                </div>
                            </div>
                            @endisset
                            <div class="row">

                                {{-- NIP --}}
                                <div class="col-md-12">
                                    <label for="nik">NIK</label>
                                    <x-adminlte-input name="nik" id="nik" oninput="removeNonNumeric(this)"
                                        value="{{old('nik')}}">
                                    </x-adminlte-input>
                                </div>

                                {{-- Nama --}}
                                <div class="col-md-12">
                                    <label for="nama">Nama</label>
                                    <x-adminlte-input name="nama" id="nama" value="{{old('nama')}}">
                                    </x-adminlte-input>
                                </div>


                                {{-- alamat --}}
                                <div class="col-md-12">
                                    <label for="alamat">Alamat</label>
                                    <x-adminlte-input name="alamat" id="alamat" value="{{old('alamat')}}">
                                    </x-adminlte-input>
                                </div>

                                <div class="col-md-12">
                                    <label for="kartu">Kartu Antrian</label>
                                    <x-adminlte-input name="kartu" id="kartu" value="{{old('kartu')}}">
                                    </x-adminlte-input>
                                </div>

                                <div class="col-md-12 text-center">
                                    <x-adminlte-button class="btn-flat col-sm-2" type="submit" label="Submit"
                                        theme="success" icon="fas fa-lg fa-save" />
                                </div>



                            </div>
                        </x-adminlte-card>
                    </div>
                </form>
            </div>
        </main>
    </div>
</div>
@stop
@section('footer')
<div id="mycredit" class="small"><strong> Copyright &copy;
        <?php echo date('Y');?> Sistem Informasi Pelayanan Puskesmas
</div>
@stop

@section('plugins.Datatables', true)
@section('plugins.DatatablesPlugin', true)
@section('plugins.Sweetalert2', true)
@section('plugins.BootstrapSelect', true)
@section('js')
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script type="text/javascript">
    // Assuming initial setup with default range mode
let rangePicker = flatpickr(".inputTgl", {
    altInput: true,
    altFormat: "j F Y",
    dateFormat: "Y-m-d",
});

function removeNonNumeric(input) {
        // Remove non-numeric characters
        input.value = input.value.replace(/\D/g, '');
    }


     // JavaScript function to be triggered when the "Import" button is clicked
     function importData() {
        // Get the selected option from the select element
        var selectedOption = document.getElementById("pasien").value;

        // Parse the selected option to extract values (assuming the format is "id - nik - nama - alamat - kartu")
        var values = selectedOption.split(' - ');

        // Update the input fields with the extracted values
        document.getElementById("nik").value = values[0]; // NIK
        document.getElementById("nama").value = values[1]; // Nama
        document.getElementById("alamat").value = values[2]; // Alamat
        document.getElementById("kartu").value = values[3]; // Kartu
    }

    // Add an event listener to the "Import" button to trigger the function
    document.getElementById("importButton").addEventListener("click", importData);
</script>
@stop