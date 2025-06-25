<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Usuario;
use App\Models\Oferta;
use App\Models\Empleador;
use App\Models\Aplicacion;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Estadísticas generales
        $stats = [
            'total_users' => Usuario::count(),
            'total_employers' => Usuario::where('rol', 'empleador')->count(),
            'total_employees' => Usuario::where('rol', 'empleado')->count(),
            'total_jobs' => Oferta::count(),
            'active_jobs' => Oferta::where('estado', 'activa')->count(),
            'total_applications' => Aplicacion::count(),
        ];

        // Usuarios registrados en los últimos 30 días
        $usersLastMonth = Usuario::where('created_at', '>=', Carbon::now()->subDays(30))
            ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Ofertas creadas en los últimos 30 días
        $jobsLastMonth = Oferta::where('created_at', '>=', Carbon::now()->subDays(30))
            ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Últimos usuarios registrados
        $recentUsers = Usuario::latest()
            ->take(5)
            ->get();

        // Últimas ofertas publicadas
        $recentJobs = Oferta::with('empleador.usuario')
            ->latest()
            ->take(5)
            ->get();

        // Empleadores más activos (con más ofertas)
        $topEmployers = Empleador::withCount('ofertas')
            ->orderBy('ofertas_count', 'desc')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'stats',
            'usersLastMonth',
            'jobsLastMonth',
            'recentUsers',
            'recentJobs',
            'topEmployers'
        ));
    }
} 