<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $admin = new User();
        $admin->prenom = 'khady';
        $admin->nom = 'Ba';
        $admin->adresse = 'Ben Tally';
        $admin->telephone = '773611172';
        $admin->email = 'bak92147@gmail.com';
        $admin->password = bcrypt('12345678');
        $admin->role_id = 3;
        $admin->save();
    }
}
