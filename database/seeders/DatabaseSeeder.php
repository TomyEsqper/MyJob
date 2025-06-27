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
        \App\Models\Usuario::firstOrCreate(
            ['correo_electronico' => 'test@example.com'],
            [
                'nombre_usuario' => 'Test Company',
                'contrasena' => bcrypt('password'),
                'rol' => 'empleador',
                'telefono' => '123456789',
                'ubicacion' => 'Madrid, España',
                'descripcion' => 'Una empresa de prueba',
                'profesion' => 'Empresa de Tecnología',
                'activo' => true,
            ]
        );

        // Crear usuarios admin predefinidos
        $adminEmails = [
            't.esquivel@myjob.com.co',
            's.murillo@myjob.com.co',
            'c.cuervo@myjob.com.co',
            'n.plazas@myjob.com.co',
            's.lozano@myjob.com.co',
        ];
        foreach ($adminEmails as $email) {
            \App\Models\Usuario::firstOrCreate(
                ['correo_electronico' => $email],
                [
                    'nombre_usuario' => explode('@', $email)[0],
                    'contrasena' => bcrypt('admin1234'),
                    'rol' => 'admin',
                    'telefono' => '000000000',
                    'ubicacion' => 'Colombia',
                    'descripcion' => 'Usuario admin predefinido',
                    'profesion' => 'Administrador',
                    'activo' => true,
                ]
            );
        }
    }
}
