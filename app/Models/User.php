<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use DB;

class User extends Model
{
    use HasFactory;

    function getUserAll(){

        $cad = "select u.id, u.name from users u 
        where u.active ='1'
        order by 1 asc";

		$data = DB::select($cad);
        return $data;
    }

    function getUserByRol($id_rol1, $id_rol2){

        $cad = "select u.id,u.name
        from model_has_roles mhr  
        inner join users u on mhr.model_id=u.id
        where role_id= ".$id_rol1." or role_id= ".$id_rol2."
        and active = 1 ";

		$data = DB::select($cad);
        return $data;
    }

}
