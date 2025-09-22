<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class VehiculoConductore extends Model
{
    protected $table = 'vehiculos_conductores';

    public $timestamps = false;
    
    use HasFactory;
}
