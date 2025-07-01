<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Usuario;
use App\Models\Empleador;
use Illuminate\Support\Facades\Hash;

class EmpleadorTestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear usuario empleador de prueba
        $usuario = Usuario::create([
            'nombre_usuario' => 'Empresa Test',
            'correo_electronico' => 'empresa@test.com',
            'contrasena' => Hash::make('password123'),
            'rol' => 'empleador',
            'activo' => true,
            'verificado' => true
        ]);

        // Crear perfil de empleador
        Empleador::create([
            'usuario_id' => $usuario->id_usuario,
            'nombre_empresa' => 'Empresa de Prueba S.A.S.',
            'nit' => '900123456-7',
            'correo_empresarial' => 'contacto@empresaprueba.com',
            'direccion_empresa' => 'Calle 123 # 45-67, Bogotá',
            'telefono_contacto' => '+57 300 123 4567',
            'sitio_web' => 'https://www.empresaprueba.com',
            'sector' => 'Tecnología',
            'ubicacion' => 'Bogotá, Colombia',
            'numero_empleados' => 50,
            'descripcion' => 'Empresa líder en desarrollo de software y soluciones tecnológicas innovadoras.',
            'mision' => 'Proporcionar soluciones tecnológicas de alta calidad que impulsen el crecimiento de nuestros clientes.',
            'vision' => 'Ser reconocidos como la empresa tecnológica más confiable y eficiente de Colombia.',
            'beneficios' => json_encode([
                'Seguro médico',
                'Bonos de productividad',
                'Capacitación continua',
                'Horario flexible',
                'Trabajo remoto'
            ]),
            'verificado' => true
        ]);

        $this->command->info('Usuario empleador de prueba creado exitosamente.');
        $this->command->info('Email: empresa@test.com');
        $this->command->info('Contraseña: password123');
    }
}
