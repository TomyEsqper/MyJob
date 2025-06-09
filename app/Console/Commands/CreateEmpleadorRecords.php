<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Usuario;
use App\Models\Empleador;

class CreateEmpleadorRecords extends Command
{
    protected $signature = 'empleadores:create-missing';
    protected $description = 'Create empleador records for existing users with rol="empleador"';

    public function handle()
    {
        $this->info('Buscando usuarios empleadores sin registro en la tabla empleadores...');

        $usuarios = Usuario::where('rol', 'empleador')
            ->whereDoesntHave('empleador')
            ->get();

        if ($usuarios->isEmpty()) {
            $this->info('No se encontraron usuarios empleadores sin registro.');
            return;
        }

        $this->info("Se encontraron {$usuarios->count()} usuarios empleadores sin registro.");

        foreach ($usuarios as $usuario) {
            $empleador = Empleador::create([
                'usuario_id' => $usuario->id_usuario,
                'nit' => '000000000', // NIT temporal
                'correo_empresarial' => $usuario->correo_electronico,
                'nombre_empresa' => $usuario->nombre_usuario,
                'direccion_empresa' => 'Por completar',
                'telefono_contacto' => 'Por completar',
            ]);

            $this->line("Creado registro para usuario ID: {$usuario->id_usuario}");
        }

        $this->info('Proceso completado.');
    }
} 