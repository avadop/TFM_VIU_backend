<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClientesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('clientes')->insert([
            [
                'nif' => '51234268C',
                'nombre' => 'Dario Fernando',
                'apellidos' => 'Gallegos Quishpe',
                'correo_electronico' => 'dario@mail.com',
                'direccion' => 'Calle Dario 1',
                'codigo_postal'=> '28000',
                'poblacion'=> 'Madrid',
                'provincia'=> 'Madrid',
                'pais'=> 'España',
                'id_usuario'=> '01189877H',
            ],
            [
                'nif'=> '01189873Z',
                'nombre'=> 'Jose',
                'apellidos'=> 'del Vado Puell',
                'correo_electronico' => 'jose@mail.com',
                'direccion' => 'Calle Jose 1',
                'codigo_postal'=> '28204',
                'poblacion'=> 'Pozuelo de Alarcon',
                'provincia'=> 'Madrid',
                'pais'=> 'España',
                'id_usuario'=> '01189877H',
            ]
        ]);
    }
}
