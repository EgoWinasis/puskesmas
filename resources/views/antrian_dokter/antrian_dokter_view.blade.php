@extends('adminlte::page')

@section('title','Antrian Pasien')
@section('content_header')
<h1>Antrian Pasien</h1>
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


                <div class="row">

                    <div class="col-md-12">
                        <div class="table-responsive">

                            <table id="table_antrian" class="table table-bordered table-striped"
                                style="width: 130%; overflow-x: auto">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Waktu</th>
                                        <th>NIK</th>
                                        <th>Nama</th>
                                        <th>Alamat</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                    $i=1;
                                    @endphp
                                    @foreach ($antrian as $data)
                                    <tr>
                                        <td>{{ $i++ }}</td>
                                        <td>{{ \Carbon\Carbon::parse($data->created_at)->format('d-m-Y H:i:s') }}</td>
                                        <td>{{ $data->nik }}</td>
                                        <td class="nama">{{ $data->nama }}</td>
                                        <td class="alamat">{{ $data->alamat }}</td>
                                        <td>
                                            <button class="btn btn-success btn-panggil m-2"
                                                data-id_show="{{ $data->id }}">Panggil</button>
                                            <button class="btn btn-info btn-show m-2"
                                                data-id_show="{{ $data->pasien_id }}">Show</button>
                                            <button class="btn btn-warning btn-pemeriksaan m-2"
                                                data-id_pemeriksaan="{{ $data->id }}">Pemeriksaan</button>

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
                    <?php echo date('Y');?> Sistem Informasi pemeriksaan Puskesmas </div>
            @stop

            @section('plugins.Datatables', true)
            @section('plugins.DatatablesPlugin', true)
            @section('plugins.Sweetalert2', true)

            @section('js')
            <script type="text/javascript">
                $(function () {
                    $("#table_antrian").DataTable({
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
                                        { "width": "15%", "targets": 4 },   
                                        { "width": "20%", "targets": 5 },   
                                    
                                    ]
                    })
                   
                  });
                
                 
                
            </script>
            <script>
                $(document).on('click', '.btn-show', function (e) {
                    e.preventDefault();
                    var id = $(this).data('id_show');

                    // Fetch CSRF token from the meta tag
                    var token = $('meta[name="csrf-token"]').attr('content');
                    let url = "/antrianDokter/" + id;

                
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
                                                <th>Alamat</th>
                                                <td>:</td>
                                                <td>${pasien[0].alamat}</td>
                                            </tr>
                                            <tr>
                                                <th>Tujuan</th>
                                                <td>:</td>
                                                <td>${pasien[0].tujuan}</td>
                                            </tr>
                                            <tr>
                                                <th>Keluhan</th>
                                                <td>:</td>
                                                <td>${pasien[0].keluhan}</td>
                                            </tr>
                                            <tr>
                                                <th>Catatan</th>
                                                <td>:</td>
                                                <td>${pasien[0].catatan}</td>
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
                $(document).on('click', '.btn-pemeriksaan', function (e) {
                    e.preventDefault();
                    var id = $(this).data('id_pemeriksaan');
                    var token = $('meta[name="csrf-token"]').attr('content');
                    
                    Swal.fire({
                        title: 'Periksa?',
                        text: 'Melakukan Pemeriksaan Pasien',
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes'
                    }).then((result) => {
                        if (result.value) {
                            $.ajax({
                                type: 'POST',
                                url: '/antrianDokter',
                                data: {
                                    id: id
                                },
                                headers: {
                                    'X-CSRF-TOKEN': token // Set the CSRF token in the request headers
                                },
                                success: function (response) {
                                    Swal.fire({
                                        type: 'success',
                                        title: 'Success',
                                        text: response.message
                                    })
                                    location.reload();
                                },
                                error: function (xhr, status, error) {
                                    Swal.fire({
                                        type: 'error',
                                        title: 'Error',
                                        text: xhr.responseJSON.message
                                    });
                                }
                            });
                        }
                    });
                });


                $(document).ready(function () {
                    // Add a click event listener to all buttons with class "btn-panggil"
                    $('.btn-panggil').click(function () {
                        // Get the values of "nama" and "alamat" from the closest row
                        var nama = $(this).closest('tr').find('.nama').text();
                        var alamat = $(this).closest('tr').find('.alamat').text();
                        // Create a SpeechSynthesisUtterance with the extracted data
                        var msg = new SpeechSynthesisUtterance();
                        msg.text = 'Panggilan untuk ' + nama + ' dengan alamat ' + alamat + '. Segera Menuju Ke Ruang Dokter';
                       // Set language to Indonesian
                         msg.lang = 'id-ID';

                        // Set a specific Indonesian voice (optional)
                        var voices = window.speechSynthesis.getVoices();
                        var indonesianVoice = voices.find(voice => voice.lang === 'id-ID');
                        if (indonesianVoice) {
                            msg.voice = indonesianVoice;
                        }

                        // Speak the message
                        window.speechSynthesis.speak(msg);
                    });
                });
            </script>

            @stop