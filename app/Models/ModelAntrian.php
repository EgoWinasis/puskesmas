<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ModelAntrian extends Model
{
   
    use HasFactory;
    use SoftDeletes;
    protected $table = 'antrian'; // Define the table name

    protected $fillable = [
        'kartu'
    ];
}
