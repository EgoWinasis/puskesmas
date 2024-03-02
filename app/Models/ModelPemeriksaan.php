<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ModelPemeriksaan extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'pemeriksaan'; // Define the table name

    protected $fillable = [
        'pasien_id',
        'antrian_id',
        'pelayanan_id',
        'tujuan',
        'keluhan',
        'catatan',
        'diagnosa',
        'obat',
    ];
}
