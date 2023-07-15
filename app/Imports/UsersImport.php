<?php

namespace App\Imports;

use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;


class UsersImport implements ToModel, WithHeadingRow, WithValidation
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $user = new User([
            'name'                  => $row['name'],
            'email'                 => $row['email'],
            'matriculation_no'      => $row['matriculation_no'],
            'dob'                   => $row['dob'],
            'nd_institute'          => $row['nd_institute'],
            'nd_course'             => $row['nd_course'],
            'phone'                 => $row['phone'],
            'password'              => Hash::make($row['dob'])
        ]);

        $assingrole = Role::findOrCreate('student');
        $user->assignRole($assingrole);

        return $user;


    }

    public function rules(): array
    {
        return [
            'name'                  => ['required', 'string', 'max:255'],
            'email'                 => ['required', 'string', 'email', 'max:255', 'unique:users,email'],            
            'matriculation_no'      => ['required', 'string', 'unique:users,matriculation_no'],
            'dob'                   => ['required', 'date_format:d/m/Y'],
            'nd_institute'          => ['required', 'numeric'],
            'nd_course'             => ['required', 'numeric'],
            'phone'                 => ['required', 'numeric']
        ];
    }
}
