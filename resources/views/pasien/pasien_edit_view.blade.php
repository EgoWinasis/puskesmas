@extends('adminlte::page')

@section('title','Edit Data Pasien')
@section('css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
@stop
@section('content_header')
<h1>Edit Data Pasien</h1>
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
                <form method="POST" action="{{ route('pasien.update',$pasien[0]->id) }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="row">

                        <x-adminlte-card class="col-md-12" theme-mode="full">
                            <div class="row">

                                {{-- NIP --}}
                                <div class="col-md-6">
                                    <label for="nik">NIK</label>
                                    <x-adminlte-input name="nik" id="nik" oninput="removeNonNumeric(this)" value="{{ old('nik') ?? $pasien[0]->nik }}">
                                    </x-adminlte-input>
                                </div>
                                <div class="col-md-6">
                                    <label for="bpjs">BPJS</label>
                                    <x-adminlte-input name="bpjs" id="bpjs" oninput="removeNonNumeric(this)" value="{{ old('bpjs') ?? $pasien[0]->bpjs }}">
                                    </x-adminlte-input>
                                </div>
                                {{-- Nama --}}
                                <div class="col-md-6">
                                    <label for="nama">Nama</label>
                                    <x-adminlte-input name="nama" id="nama" value="{{ old('nama') ?? $pasien[0]->nama }}">
                                    </x-adminlte-input>
                                </div>
                                <div class="col-md-6">
                                    <label for="tgl_lahir">Tanggal Lahir</label>
                                    <x-adminlte-input name="tgl_lahir" id="tgl_lahir" class="inputTgl" value="{{ old('tgl_lahir') ?? $pasien[0]->tgl_lahir }}">
                                    </x-adminlte-input>
                                </div>
                              
                                <div class="col-md-6">
                                    <label for="hp">HP</label>
                                    <x-adminlte-input name="hp" id="hp" oninput="removeNonNumeric(this)" value="{{ old('hp') ?? $pasien[0]->hp }}">
                                    </x-adminlte-input>
                                </div>
                                <div class="col-md-6">
                                    <label for="kartu">Kartu Antrian</label>
                                    <x-adminlte-input name="kartu" id="kartu" value="{{ old('kartu') ?? $pasien[0]->kartu }}">
                                    </x-adminlte-input>
                                </div>
                                {{-- alamat --}}
                                <div class="col-md-12">
                                    <label for="alamat">Alamat</label>
                                    <x-adminlte-input name="alamat" id="alamat" value="{{ old('alamat') ?? $pasien[0]->alamat }}">
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
</script>
@stop