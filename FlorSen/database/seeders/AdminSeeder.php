<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $admin = new User();
        $admin->prenom = 'Admin';
        $admin->nom = 'Admin';
        $admin->adresse = 'Adresse Admin';
        $admin->telephone = '77-124-44-10';
        $admin->email = 'admin@example.com';
        $admin->password = bcrypt('password');
        $admin->role = 'admin';
        $admin->save();
    }
}
