<?php

namespace App\Imports;

use App\User;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UsersImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        if(!array_filter($row)) return null;

        // comprueba si ya hay un usuario con ese DNI
        $dni = $row['dni'];
        $user = User::where('dni',$dni)->first();
        if($user != null){
            return null;
        }

        // comprueba si ya hay un usuario con ese UVUS
        $uvus = $row['uvus'];
        $user = User::where('username',$uvus)->first();
        if($user != null){
            return null;
        }

        // comprueba si ya hay un usuario con ese email
        $correo = $row['correo'];
        $user = User::where('email',$correo)->first();
        if($user != null){
            return null;
        }

        return new User([
            'dni' => $row['dni'],
            'surname' => explode(',',$row['apellidos_nombre'])[0],
            'name' => explode(',',$row['apellidos_nombre'])[1],
            'username' => $row['uvus'],
            'password' => Hash::make($row['dni']),
            'email' => $row['correo'],
        ]);
    }
}
