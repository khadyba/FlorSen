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
        $admin->email = 'andredembandione1@gmail.com';
        $admin->password = bcrypt('12345678');
        $admin->role_id = 1;
        $admin->save();
    }
}
