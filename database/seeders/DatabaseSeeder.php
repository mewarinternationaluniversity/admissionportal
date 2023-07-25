<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        $sessions = database_path('seeders/sql/sessions.sql');
        DB::unprepared(file_get_contents($sessions));


        $institutes = database_path('seeders/sql/institutes.sql');
        DB::unprepared(file_get_contents($institutes));

        $addadmin = \App\Models\User::factory()->create([
            'name' => 'Edward Mwangi',
            'email' => 'muyaedward@gmail.com',
            'phone' => '0702681502',
            'password' => Hash::make('muyaedward@gmail.com'),
        ]);

        $Ayuba = \App\Models\User::factory()->create([
            'name' => 'Ayuba Abdulrazak',
            'email' => 'ayubaabdulrazak@yopmail.com',
            'matriculation_no' => 'KADPOLY2023MINING001',
            'dob' => '20/07/2023',
            'phone' => '0702681502',
            'gender' => 'Male',
            'address' => 'Nairobi Kenya',
            'yearofgraduation' => '2015',
            'nd_institute' => 6,
            'nd_course' => 7,
            'password' => Hash::make('20/07/2023'),
        ]);



        $Augustine = \App\Models\User::factory()->create([
            'name' => 'Augustine Mary',
            'email' => 'augustinemary@yopmail.com',
            'matriculation_no' => 'KADPOLY2023MINING002',
            'dob' => '20/07/2023',
            'phone' => '0702681502',
            'gender' => 'Female',
            'address' => 'Lagos Nigeria',
            'yearofgraduation' => '2017',
            'nd_institute' => 6,
            'nd_course' => 7,
            'password' => Hash::make('20/07/2023'),
        ]);

        $James = \App\Models\User::factory()->create([
            'name' => 'James Emmanuel Ndubuisi',
            'email' => 'jamesemmanuelndubuisi@yopmail.com',
            'matriculation_no' => 'KADPOLY2023MINING003',
            'dob' => '20/07/2023',
            'phone' => '0702681502',
            'nd_institute' => 6,
            'nd_course' => 7,
            'password' => Hash::make('20/07/2023'),
        ]);

        $moi = \App\Models\User::factory()->create([
            'name' => 'Daniel Moi',
            'email' => 'moidaniel@yopmail.com',
            'phone' => '0702681502',
            'institute_id' => 1,
            'password' => Hash::make('moidaniel@yopmail.com'),
        ]);

        $chege = \App\Models\User::factory()->create([
            'name' => 'Kip Chege',
            'email' => 'chegekip@yopmail.com',
            'phone' => '0702681502',
            'institute_id' => 5,
            'password' => Hash::make('chegekip@yopmail.com'),
        ]);

        $adminrole = Role::findOrCreate('admin');
        $studentrole = Role::findOrCreate('student');
        $managerrole = Role::findOrCreate('manager');

        $addadmin->assignRole($adminrole);
        $Ayuba->assignRole($studentrole);
        $Augustine->assignRole($studentrole);
        $James->assignRole($studentrole);
        $moi->assignRole($managerrole);
        $chege->assignRole($managerrole);

        $courses = database_path('seeders/sql/courses.sql');

        DB::unprepared(file_get_contents($courses));
    }
}
