<div class="row">
    <div class="col-xl-6 col-md-6">
        <div class="card bg-primary text-white mb-4">
            <div class="card-body d-flex align-items-center">
                <i class="fas fa-users fa-2x mr-3"></i> <!-- Icon -->
                <div>
                    <div class="text-white lead">Users Aktif</div>
                    <div class="text-white lead">{{$totalUsersActive}} Akun</div> <!-- Numeric value -->
                </div>
            </div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <a class="small text-white stretched-link" href="{{route('user.index')}}">View Details</a>
                <div class="small text-white">
                    <i class="fas fa-angle-right"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-6 col-md-6">
        <div class="card bg-danger text-white mb-4">
            <div class="card-body d-flex align-items-center">
                <i class="fas fa-users-slash fa-2x mr-3"></i> <!-- Icon -->
                <div>
                    <div class="text-white lead">User Non Aktif</div>
                    <div class="text-white lead">{{$totalUsersInActive}} Akun</div> <!-- Numeric value -->
                </div>
            </div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <a class="small text-white stretched-link" href="{{route('user.index')}}">View Details</a>
                <div class="small text-white">
                    <i class="fas fa-angle-right"></i>
                </div>
            </div>
        </div>
    </div>

</div>
<div class="row">
    <div class="col-xl-4 col-md-6">
        <div class="card bg-success text-white mb-4">
            <div class="card-body d-flex align-items-center">
                <i class="fas fa-users fa-2x mr-3"></i> <!-- Icon -->
                <div>
                    <div class="text-white lead">Pasien</div>
                    <div class="text-white lead">{{$pasien}} Akun</div> <!-- Numeric value -->
                </div>
            </div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <a class="small text-white stretched-link" href="{{route('pasien.index')}}">View Details</a>
                <div class="small text-white">
                    <i class="fas fa-angle-right"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-md-6">
        <div class="card bg-info text-white mb-4">
            <div class="card-body d-flex align-items-center">
                <i class="fas fa-user-clock fa-2x mr-3"></i> 
                <div>
                    <div class="text-white lead">Antrian</div>
                    <div class="text-white lead">{{$antrian}} Pasien</div> <!-- Numeric value -->
                </div>
            </div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <a class="small text-white stretched-link" href="{{route('antrian.index')}}">View Details</a>
                <div class="small text-white">
                    <i class="fas fa-angle-right"></i>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-md-6">
        <div class="card bg-secondary text-white mb-4">
            <div class="card-body d-flex align-items-center">
                <i class="fas fa-check-circle fa-2x mr-3"></i> 
                <div>
                    <div class="text-white lead">Pelayanan</div>
                    <div class="text-white lead">{{$pelayanan}} Pasien</div> <!-- Numeric value -->
                </div>
            </div>
            <div class="card-footer d-flex align-items-center justify-content-between">
                <a class="small text-white stretched-link" href="{{route('pelayanan.index')}}">View Details</a>
                <div class="small text-white">
                    <i class="fas fa-angle-right"></i>
                </div>
            </div>
        </div>
    </div>
    
</div>