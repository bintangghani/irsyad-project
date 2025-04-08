<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;
use Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'nama' => 'superadmin',
            'email' => 'superadmin@irsyad.com',
            'email_verified_at' => Carbon::now(),
            'password' => Hash::make('SuperadminIrsyad000_'),
            'profile' => 'assets/img/avatars/1.png',
            'moto' => 'Superadmin Irsyad',
            'id_role' => Role::where('nama', 'superadmin')->first()->id_role
        ]);
    }
}
