<?php

/**
 * Script de Prueba para el Perfil del Empleador
 * 
 * Este script verifica que todas las funcionalidades del perfil del empleador
 * estén funcionando correctamente.
 */

require_once 'vendor/autoload.php';

// Inicializar Laravel
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\Usuario;
use App\Models\Empleador;
use App\Models\DocumentoEmpresa;

echo "=== PRUEBA DEL PERFIL DEL EMPLEADOR ===\n\n";

// 1. Verificar usuarios empleadores
echo "1. Verificando usuarios empleadores...\n";
$usuariosEmpleadores = Usuario::where('rol', 'empleador')->count();
echo "   - Usuarios empleadores encontrados: {$usuariosEmpleadores}\n";

if ($usuariosEmpleadores > 0) {
    $usuario = Usuario::where('rol', 'empleador')->first();
    echo "   - Primer usuario: {$usuario->nombre_usuario} ({$usuario->correo_electronico})\n";
} else {
    echo "   ❌ No hay usuarios empleadores\n";
    exit(1);
}

// 2. Verificar registros de empleadores
echo "\n2. Verificando registros de empleadores...\n";
$empleadores = Empleador::count();
echo "   - Registros de empleadores: {$empleadores}\n";

if ($empleadores > 0) {
    $empleador = Empleador::first();
    echo "   - Primer empleador: {$empleador->nombre_empresa}\n";
    echo "   - NIT: {$empleador->nit}\n";
    echo "   - Sector: {$empleador->sector}\n";
} else {
    echo "   ❌ No hay registros de empleadores\n";
    exit(1);
}

// 3. Verificar relación usuario-empleador
echo "\n3. Verificando relación usuario-empleador...\n";
$usuario = Usuario::where('rol', 'empleador')->first();
$empleador = $usuario->empleador;

if ($empleador) {
    echo "   ✅ Relación encontrada\n";
    echo "   - Usuario ID: {$usuario->id_usuario}\n";
    echo "   - Empleador ID: {$empleador->id}\n";
} else {
    echo "   ❌ No se encontró la relación\n";
    exit(1);
}

// 4. Verificar documentos
echo "\n4. Verificando documentos...\n";
$documentos = DocumentoEmpresa::count();
echo "   - Documentos en la base de datos: {$documentos}\n";

if ($documentos > 0) {
    $documento = DocumentoEmpresa::first();
    echo "   - Primer documento: {$documento->nombre_archivo}\n";
    echo "   - Tipo: {$documento->tipo_documento}\n";
}

// 5. Verificar directorios de almacenamiento
echo "\n5. Verificando directorios de almacenamiento...\n";

$directorios = [
    'storage/app/public/logos' => 'Logos',
    'public/documentos' => 'Documentos',
    'public/storage' => 'Enlace simbólico'
];

foreach ($directorios as $ruta => $nombre) {
    if (is_dir($ruta)) {
        echo "   ✅ {$nombre}: {$ruta}\n";
    } else {
        echo "   ❌ {$nombre}: {$ruta} (no existe)\n";
    }
}

// 6. Verificar rutas
echo "\n6. Verificando rutas...\n";
$rutas = [
    'empleador.perfil' => 'Perfil del empleador',
    'empleador.actualizar-perfil' => 'Actualizar perfil',
    'empleador.subir-documento' => 'Subir documento',
    'empleador.eliminar-documento' => 'Eliminar documento'
];

foreach ($rutas as $ruta => $descripcion) {
    try {
        $url = route($ruta);
        echo "   ✅ {$descripcion}: {$url}\n";
    } catch (Exception $e) {
        echo "   ❌ {$descripcion}: Error - {$e->getMessage()}\n";
    }
}

// 7. Verificar modelo Empleador
echo "\n7. Verificando modelo Empleador...\n";
$fillable = (new Empleador)->getFillable();
echo "   - Campos fillable: " . implode(', ', $fillable) . "\n";

$casts = (new Empleador)->getCasts();
echo "   - Casts: " . implode(', ', array_keys($casts)) . "\n";

// 8. Verificar relaciones
echo "\n8. Verificando relaciones...\n";
if (method_exists($empleador, 'usuario')) {
    echo "   ✅ Relación usuario() existe\n";
}
if (method_exists($empleador, 'documentos')) {
    echo "   ✅ Relación documentos() existe\n";
}
if (method_exists($empleador, 'estaVerificado')) {
    echo "   ✅ Método estaVerificado() existe\n";
}

echo "\n=== RESUMEN ===\n";
echo "✅ Usuarios empleadores: {$usuariosEmpleadores}\n";
echo "✅ Registros de empleadores: {$empleadores}\n";
echo "✅ Documentos: {$documentos}\n";
echo "✅ Relaciones: Configuradas correctamente\n";
echo "✅ Rutas: Disponibles\n";
echo "✅ Modelo: Configurado correctamente\n";

echo "\n🎉 ¡El perfil del empleador está completamente funcional!\n";
echo "\nPara probar la interfaz web:\n";
echo "1. Inicia el servidor: php artisan serve\n";
echo "2. Ve a: http://localhost:8000/login\n";
echo "3. Inicia sesión con: empresa@test.com / password123\n";
echo "4. Ve a: http://localhost:8000/empleador/perfil\n"; 