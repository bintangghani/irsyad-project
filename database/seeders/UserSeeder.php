<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Ramsey\Uuid\Uuid;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'id_user' => Uuid::uuid4(),
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
