<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsuarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        DB::table('usuarios')->insert([
                'nif' => '01189877H',
                'nombre' => 'Andrea',
                'apellidos' => 'del Vado Puell',
                'correo_electronico' => 'andrea@mail.com',
                'direccion' => 'Calle Andrea 1',
                'codigo_postal'=> '28920',
                'poblacion'=> 'Alcorcon',
                'provincia'=> 'Madrid',
                'pais'=> 'España',
                'contrasenya'=> 'contrasena123',
        ]);
    }
}
