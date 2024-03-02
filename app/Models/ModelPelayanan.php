<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ModelPelayanan extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'pelayanan'; // Define the table name

    protected $fillable = [
        'pasien_id',
        'antrian_id',
        'tujuan',
        'keluhan',
        'catatan'
    ];
}
