@extends('adminlte::page')

@section('title','Pendaftaran Pasien')
@section('content_header')
<h1>Pendaftaran Pasien</h1>
@stop

@section('content')
<div id="layoutSidenav">
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid">
                @if ($message = Session::get('success'))
                <div class="alert alert-success">
                    <p>{{ $message }}</p>
                </div>
                @endif
                @if ($message = Session::get('error'))
                <div class="alert alert-danger">
                    <p>{{ $message }}</p>
                </div>
                @endif

                <div class="row my-3">
                    <div class="col-md-12">
                        <x-adminlte-button onclick="return add();" label="Tambah" theme="primary" icon="fas fa-plus" />
                    </div>

                </div>
                <div class="row">

                    <div class="col-md-12">
                        <div class="table-responsive">

                            <table id="table_pasien" class="table table-bordered table-striped"
                                style="width: 110%; overflow-x: auto">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>NIK</th>
                                        <th>BPJS</th>
                                        <th>Nama</th>
                                        <th>Tanggal Lahir</th>
                                        <th>Alamat</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                    $i=1;
                                    @endphp
                                    @foreach ($pasien as $data)
                                    <tr>
                                        <td>{{ $i++ }}</td>
                                        <td>{{ $data->nik }}</td>
                                        <td>{{ $data->bpjs }}</td>
                                        <td class="nama">{{ $data->nama }}</td>
                                        @php
                                        $date = new DateTime($data->tgl_lahir );
                                        $formattedDate = $date->format('d-m-Y');
                                        @endphp
                                        <td>{{ $formattedDate}}</td>
                                        <td>{{ $data->alamat }}</td>
                                        <td>
                                            <button class="btn btn-info btn-show m-2"
                                                data-id_show="{{ $data->id }}">Show</button>
                                            <a class="btn btn-warning btn-edit m-2"
                                                href="{{ route('pasien.edit', $data->id) }}">Edit</a>
                                            <a class="btn btn-danger btn-delete m-2" data-id="{{$data->id}}">Hapus</a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>

                            </table>

                        </div>

                    </div>
                </div>

            </div><!-- /.container-fluid -->
            </section>
            <!-- /.content -->
            @stop
            @section('footer')
            <div id="mycredit" class="small"><strong> Copyright &copy;
                    <?php echo date('Y');?> Sistem Informasi Pelayanan Puskesmas </div>
            @stop

            @section('plugins.Datatables', true)
            @section('plugins.DatatablesPlugin', true)
            @section('plugins.Sweetalert2', true)

            @section('js')
            <script type="text/javascript">
                function add() {
                    window.location = "{{ route('pasien.create') }}";
                 }
                $(function () {
                    $("#table_pasien").DataTable({
                      "responsive": true, "lengthChange": false, "autoWidth": false,
                    //   "buttons": ["excel", "pdf", "print"],
                      "paging": true,
                      "lengthChange": false,
                      "searching": true,
                      "ordering": true,
                      "info": true,
                      "autoWidth": false,
                      "responsive": true,
                      "columnDefs": [
                                        { "width": "2%", "targets": 0 }, 
                                        { "width": "10%", "targets": 1 }, 
                                        { "width": "10%", "targets": 2 }, 
                                        { "width": "10%", "targets": 3 },   
                                        { "width": "10%", "targets": 4 },   
                                        { "width": "20%", "targets": 5 },   
                                        { "width": "20%", "targets": 6 },   
                                    
                                    ]
                    })
                   
                  });
                
                  $(document).on('click', '.btn-delete', function (e) {
                    e.preventDefault();
                    var id = $(this).data('id');
                    var name = $(this).closest('tr').find('.nama').text();
                    // Fetch CSRF token from the meta tag
                    var token = $('meta[name="csrf-token"]').attr('content');
                    let url = "/pasien/" + id;

                  
                    Swal.fire({
                        title: `Hapus Data Pasien ${name}?`,
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes'
                    }).then((result) => {
                
                        if (result.value) {
                
                            $.ajax({
                                type: "DELETE",
                                url: url,
                                data: {
                                    '_token': token
                                },
                                success: function (data) {
                                    Swal.fire({
                                        title: 'Berhasil Dihapus!',
                                        type: "success"
                                    }
                                    );
                                    window.location.reload();
                                },
                                error: function (xhr, status, error) {
                                    Swal.fire({
                                        type: 'error',
                                        title: 'Oops...',
                                        text: error
                                    });
                                }
                            });
                        }
                    });
                });
                
            </script>
            <script>
                $(document).on('click', '.btn-show', function (e) {
                    e.preventDefault();
                    var id = $(this).data('id_show');

                    // Fetch CSRF token from the meta tag
                    var token = $('meta[name="csrf-token"]').attr('content');
                    let url = "/pasien/" + id;

                
                            $.ajax({
                                type: "GET",
                                url: url,
    
                                success: function (data) {
                                    var pasien = data.pasien;

                                    Swal.fire({
                                        title: 'Pasien Details',
                                        width: '65%',
                                        html: `
                                        <table style="width:100%;text-align:left;">
                                            <tr>
                                                <th>NIK</th>
                                                <td>:</td>
                                                <td>${pasien[0].nik}</td>
                                            </tr>
                                            <tr>
                                                <th>BPJS</th>
                                                <td>:</td>
                                                <td>${pasien[0].bpjs}</td>
                                            </tr>
                                            <tr>
                                                <th>Nama</th>
                                                <td>:</td>
                                                <td>${pasien[0].nama}</td>
                                            </tr>
                                            <tr>
                                                <th>Tanggal Lahir</th>
                                                <td>:</td>
                                                <td>${pasien[0].tgl_lahir}</td>
                                            </tr>
                                            <tr>
                                                <th>HP</th>
                                                <td>:</td>
                                                <td>${pasien[0].hp}</td>
                                            </tr>
                                            <tr>
                                                <th>Kartu Antrian</th>
                                                <td>:</td>
                                                <td>${pasien[0].kartu}</td>
                                            </tr>
                                            <tr>
                                                <th>Alamat</th>
                                                <td>:</td>
                                                <td>${pasien[0].alamat}</td>
                                            </tr>
                                           
                                            
                                        </table>
                                        `,
                                        showCloseButton: true,
                                        showConfirmButton: false
                                        // You can customize the modal further as needed
                                    });
                                },
                                error: function (xhr, status, error) {
                                    Swal.fire({
                                        type: 'error',
                                        title: 'Oops...',
                                        text: error
                                    });
                                }
                            });
                });
               
            </script>

            @stop