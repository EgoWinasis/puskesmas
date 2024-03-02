<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ModelPasien extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'pasien'; // Define the table name

    protected $fillable = [
        'nik',
        'bpjs',
        'nama',
        'tgl_lahir',
        'hp',
        'alamat',
        'kartu',
        // Add other fields that you want to be fillable here
    ];
}
