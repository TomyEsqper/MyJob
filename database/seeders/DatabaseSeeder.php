<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Usuario;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Crear usuarios admin predefinidos
        $admins = [
            [
                'email' => 't.esquivel@myjob.com.co',
                'nombre' => 'Tomás Esquivel',
                'telefono' => '3001234567'
            ],
            [
                'email' => 's.murillo@myjob.com.co',
                'nombre' => 'Sharith Murillo',
                'telefono' => '3001234568'
            ],
            [
                'email' => 'c.cuervo@myjob.com.co',
                'nombre' => 'Camilo Cuervo',
                'telefono' => '3001234569'
            ],
            [
                'email' => 'n.plazas@myjob.com.co',
                'nombre' => 'Nicolás Plazas',
                'telefono' => '3001234570'
            ],
            [
                'email' => 's.lozano@myjob.com.co',
                'nombre' => 'Santiago Lozano',
                'telefono' => '3001234571'
            ],
        ];

        foreach ($admins as $admin) {
            Usuario::firstOrCreate(
                ['correo_electronico' => $admin['email']],
                [
                    'nombre_usuario' => $admin['nombre'],
                    'contrasena' => Hash::make('admin1234'),
                    'rol' => 'admin',
                    'telefono' => $admin['telefono'],
                    'ubicacion' => 'Colombia',
                    'descripcion' => 'Administrador del sistema MyJob',
                    'profesion' => 'Administrador de Sistemas',
                    'activo' => true,
                ]
            );
        }
    }
}
