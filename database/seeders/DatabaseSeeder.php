<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Alumno;
use App\Models\Asisntencia;
use App\Models\Materia;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        Materia::factory()->create([
            'nombre' => 'Physics',
            'duracion'=>'5hrs',
            'dias'=>5
        ]);
        Materia::factory()->create([
            'nombre' => 'Math',
            'duracion'=>'3hrs',
            'dias'=>4
        ]);

        Alumno::factory()->create([
            'nombre' => 'Yul isai',
            'app' => 'Villegas',
            'apm'=>'Gonzalez',
            'matricula' => '2521160032',
            'edad'=>20,
            'sexo'=>'M',
            'id_materia'=>1
        ]);

        Alumno::factory()->create([
            'nombre' => 'Dylan Alejandro',
            'app' => 'Rodriguez',
            'apm'=>'Silverio',
            'matricula' => '0000000000',
            'edad'=>20,
            'sexo'=>'M',
            'id_materia'=>2
        ]);


        Asisntencia::factory()->create([
            'id_alumno' => 1,
            'asistio' => true,
            'fecha'=>now()
        ]);
        Asisntencia::factory()->create([
            'id_alumno' => 2,
            'asistio' => false,
            'fecha'=>now()
        ]);

    }
}
