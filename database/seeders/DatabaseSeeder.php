<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        $addadmin = \App\Models\User::factory()->create([
            'name' => 'Edward Mwangi',
            'email' => 'muyaedward@gmail.com',
        ]);

        $muya = \App\Models\User::factory()->create([
            'name' => 'Micheal Muya',
            'email' => 'muyaedward@yopmail.com',
            'matriculation_no' => 'aaaaasssss',
            'dob' => '1990-4-5',
            'phone' => '0702681502'
        ]);

        $moi = \App\Models\User::factory()->create([
            'name' => 'Daniel Moi',
            'email' => 'moidaniel@yopmail.com',
        ]);

        $chege = \App\Models\User::factory()->create([
            'name' => 'Kip Chege',
            'email' => 'chegekip@yopmail.com',
        ]);

        $adminrole = Role::findOrCreate('admin');
        $studentrole = Role::findOrCreate('student');
        $managerrole = Role::findOrCreate('manager');

        $addadmin->assignRole($adminrole);
        $muya->assignRole($studentrole);
        $moi->assignRole($studentrole);
        $chege->assignRole($managerrole);

    }
}
