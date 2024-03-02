<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ModelObat extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $table = 'obat'; // Define the table name

    protected $fillable = [
        'pemeriksaan_id',
        'pasien_id',
        'obat',
    ];
}
