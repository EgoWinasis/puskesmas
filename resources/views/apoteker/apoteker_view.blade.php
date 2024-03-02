@extends('adminlte::page')

@section('title','Pemeriksaan Pasien')
@section('content_header')
<h1>Pemeriksaan Pasien</h1>
@stop

@section('content')
<div id="layoutSidenav">
    <div id="layoutSidenav_content">
        <main>
            <div class="container-fluid">

                <div class="row">

                    <div class="col-md-12">
                        <div class="table-responsive">

                            <table id="table_pelayanan" class="table table-bordered table-striped" style="width: 100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Tanggal</th>
                                        <th>NIK</th>
                                        <th>Nama</th>
                                        <th>Alamat</th>
                                        <th>Tujuan</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                    $i=1;
                                    @endphp
                                    @foreach ($pemeriksaan as $data)
                                    <tr>
                                        <td>{{ $i++ }}</td>
                                        <td>{{ \Carbon\Carbon::parse($data->created_at)->format('d-m-Y H:i:s') }}</td>
                                        <td>{{ $data->nik }}</td>
                                        <td class="nama">{{ $data->nama }}</td>
                                        <td class="alamat">{{ $data->alamat }}</td>
                                        <td>{{ $data->tujuan }}</td>
                                        <td>
                                            {{-- @if ($data->obat == '' && $data->diagnosa == '')
                                            <button class="btn btn-success btn-diagnosa m-2"
                                                data-id_diagnosa="{{ $data->id }}">Obat</button>
                                            @endif --}}
                                            <button class="btn btn-success btn-obat m-2"
                                                data-id_pemeriksaan="{{ $data->id }}" data-pasien_id="{{ $data->pasien_id }}">Obat</button>
                                            <button class="btn btn-warning btn-panggil m-2">Panggil</button>
                                            <button class="btn btn-info btn-show m-2"
                                                data-id_show="{{ $data->pasien_id }}">Show</button>

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
                $(function () {
                    $("#table_pelayanan").DataTable({
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
                                        { "width": "20%", "targets": 3 },   
                                        { "width": "20%", "targets": 4 },   
                                        { "width": "10%", "targets": 5 },   
                                        { "width": "10%", "targets": 6 },   
                                    
                                    ]
                    })
                  });
                
                  $(document).ready(function () {
                    // Add a click event listener to all buttons with class "btn-panggil"
                    $('.btn-panggil').click(function () {
                        // Get the values of "nama" and "alamat" from the closest row
                        var nama = $(this).closest('tr').find('.nama').text();
                        var alamat = $(this).closest('tr').find('.alamat').text();
                        // Create a SpeechSynthesisUtterance with the extracted data
                        var msg = new SpeechSynthesisUtterance();
                        msg.text = 'Panggilan untuk ' + nama + ' dengan alamat ' + alamat + '. Segera Menuju Ke Loket Apotek untuk mengambil obat';
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
            <script>
                // obat
                $(document).on('click', '.btn-obat', function (e) {
                    e.preventDefault();
                    var id = $(this).data('id_pemeriksaan');
                    var pasien_id = $(this).data('pasien_id');
                    var name = $(this).closest('tr').find('.nama').text();

                    // Fetch CSRF token from the meta tag
                    var token = $('meta[name="csrf-token"]').attr('content');
                    let url = "/obat";

                  
                   Swal.fire({
                            title: `Obat Pasien - ${name}`,
                            html:
                                '<input id="obat" class="swal2-input" placeholder="Obat">',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Save'
                        }).then((result) => {
                            if (result.value) {
                                var obat = document.getElementById('obat').value;

                                $.ajax({
                                    type: "POST",
                                    url: url,
                                    data: {
                                        '_token': token,
                                        'pemeriksaan_id': id,
                                        'pasien_id': pasien_id,
                                        'obat': obat
                                    },
                                    success: function (data) {
                                        Swal.fire({
                                            title: 'Berhasil Diupdate!',
                                            type: 'success'
                                        });
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
                // show data
                $(document).on('click', '.btn-show', function (e) {
                    e.preventDefault();
                    var id = $(this).data('id_show');

                    // Fetch CSRF token from the meta tag
                    var token = $('meta[name="csrf-token"]').attr('content');
                    let url = "/pemeriksaan/" + id;

                
                            $.ajax({
                                type: "GET",
                                url: url,
    
                                success: function (data) {
                                    var pemeriksaan = data.pemeriksaan;

                                    Swal.fire({
                                        title: 'Pemeriksaan Details',
                                        width: '65%',
                                        html: `
                                        <table style="width:100%;text-align:left;">
                                            <tr>
                                                <th>NIK</th>
                                                <td>:</td>
                                                <td>${pemeriksaan[0].nik}</td>
                                            </tr>
                                            <tr>
                                                <th>BPJS</th>
                                                <td>:</td>
                                                <td>${pemeriksaan[0].bpjs}</td>
                                            </tr>
                                            <tr>
                                                <th>Nama</th>
                                                <td>:</td>
                                                <td>${pemeriksaan[0].nama}</td>
                                            </tr>
                                            <tr>
                                                <th>Tanggal Lahir</th>
                                                <td>:</td>
                                                <td>${pemeriksaan[0].tgl_lahir}</td>
                                            </tr>
                                            <tr>
                                                <th>Alamat</th>
                                                <td>:</td>
                                                <td>${pemeriksaan[0].alamat}</td>
                                            </tr>
                                            <tr>
                                                <th>Tujuan</th>
                                                <td>:</td>
                                                <td>${pemeriksaan[0].tujuan}</td>
                                            </tr>
                                            <tr>
                                                <th>Keluhan</th>
                                                <td>:</td>
                                                <td>${pemeriksaan[0].keluhan}</td>
                                            </tr>
                                            <tr>
                                                <th>Catatan</th>
                                                <td>:</td>
                                                <td>${pemeriksaan[0].catatan}</td>
                                            </tr>
                                            <tr>
                                                <th>Diagnosa</th>
                                                <td>:</td>
                                                <td>${pemeriksaan[0].diagnosa}</td>
                                            </tr>
                                            <tr>
                                                <th>Obat</th>
                                                <td>:</td>
                                                <td>${pemeriksaan[0].obat}</td>
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