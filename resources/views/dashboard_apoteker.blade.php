
    
<div class="row">
    <div class="col-xl-6 col-md-6">
        <div class="card bg-info text-white mb-4">
            <div class="card-body d-flex align-items-center">
                <i class="fas fa-user-clock fa-2x mr-3"></i> 
                <div>
                    <div class="text-white lead">Antrian</div>
                    <div class="text-white lead">{{$antrian}} Pasien</div> <!-- Numeric value -->
                </div>
            </div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <a class="small text-white stretched-link" href="{{route('antrianDokter.index')}}">View Details</a>
                <div class="small text-white">
                    <i class="fas fa-angle-right"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-6 col-md-6">
        <div class="card bg-secondary text-white mb-4">
            <div class="card-body d-flex align-items-center">
                <i class="fas fa-check-circle fa-2x mr-3"></i> 
                <div>
                    <div class="text-white lead">Penyerahan Obat</div>
                    <div class="text-white lead">{{$obat}} Pasien</div> <!-- Numeric value -->
                </div>
            </div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <a class="small text-white stretched-link" href="{{route('pemeriksaan.index')}}">View Details</a>
                <div class="small text-white">
                    <i class="fas fa-angle-right"></i>
                </div>
            </div>
        </div>
    </div>
    
</div>