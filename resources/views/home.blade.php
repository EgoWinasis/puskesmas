@extends('adminlte::page')

@section('title','Dashboard')
@section('content_header')
<h1>Dashboard</h1>
<link rel="shortcut icon" href="{{ asset('favicons/favicon.ico') }}" />
@stop

@section('content')
<div id="layoutSidenav">
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid">
                @if ($message = Session::get('error'))
                <x-adminlte-alert theme="warning" title="Warning">
                    <p>{{ $message }}</p>
                    <p>Perbarui profile terlebih dahulu!</p>

                </x-adminlte-alert>
                @endif
               
                @if (Auth::user()->role == 'admin')
                @include('dashboard_admin')
                @endif
                @if (Auth::user()->role == 'dokter')
                @include('dashboard_dokter')
                @endif
                @if (Auth::user()->role == 'apoteker')
                @include('dashboard_apoteker')
                @endif

            </div>
        </main>
    </div>
</div>
@section('footer')
<div id="mycredit" class="small"><strong> Copyright &copy;
        <?php echo date('Y');?> Sistem Informasi Pelayanan Puskesmas Brebes</div>
@stop
@stop

@section('css')
<link rel="stylesheet" href="/css/admin_custom.css">
@endsection
@section('js')

@stop