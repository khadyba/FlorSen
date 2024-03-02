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
        $admin->prenom = 'Abdoulay';
        $admin->nom = 'Korse Diallo';
        $admin->adresse = 'Mermoz';
        $admin->telephone = '771124528';
        $admin->email = 'abdoulayekorsediallo@gmail.com';
        $admin->password = bcrypt('12345678');
        $admin->role_id = 1;
        $admin->save();
    }
}
