<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class EmpresaVehiculo extends Model
{
    protected $table = 'empresas_vehiculos';

    public $timestamps = false;

    use HasFactory;
}
