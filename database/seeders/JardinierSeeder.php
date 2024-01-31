<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class JardinierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $admin = new User();
        $admin->prenom = 'Aboubacar';
        $admin->nom = 'Leye';
        $admin->image = 'Toona-sinensis-Flamingo.jpg';
        $admin->adresse = 'Medina';
        $admin->telephone = '771124528';
        $admin->email = 'aboubacarleye34@gmail.com';
        $admin->password = bcrypt('12345678');
        $admin->role = 'jardinier';
        $admin->save();
    }
}
