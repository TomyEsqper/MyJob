<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'nombre_empresa' => 'Test Company',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
            'sector' => 'Tecnología',
            'telefono' => '123456789',
            'ubicacion' => 'Madrid, España',
            'sitio_web' => 'https://example.com',
            'numero_empleados' => 50,
            'descripcion' => 'Una empresa de prueba',
            'mision' => 'Nuestra misión es probar el sistema',
            'vision' => 'Ser la mejor empresa de pruebas',
        ]);
    }
}
