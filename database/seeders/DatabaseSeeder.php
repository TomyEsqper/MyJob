<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Usuario;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Crear un usuario empleador de prueba
        Usuario::create([
            'nombre_usuario' => 'Test Company',
            'correo_electronico' => 'test@example.com',
            'contrasena' => bcrypt('password'),
            'rol' => 'empleador',
            'telefono' => '123456789',
            'ubicacion' => 'Madrid, España',
            'descripcion' => 'Una empresa de prueba',
            'profesion' => 'Empresa de Tecnología',
            'activo' => true,
        ]);
    }
}
