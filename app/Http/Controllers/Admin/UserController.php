<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Usuario;
use App\Models\Empleador;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = Usuario::query();

        // Filtros
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('nombre_usuario', 'like', "%{$request->search}%")
                  ->orWhere('correo_electronico', 'like', "%{$request->search}%");
            });
        }

        if ($request->filled('rol')) {
            $query->where('rol', $request->rol);
        }

        if ($request->filled('status')) {
            $query->where('activo', $request->status === 'active');
        }

        // Ordenamiento
        $sort = $request->sort ?? 'created_at';
        $direction = $request->direction ?? 'desc';
        $query->orderBy($sort, $direction);

        $users = $query->paginate(10)->withQueryString();

        return view('admin.users.index', compact('users'));
    }

    public function show(Usuario $user)
    {
        $user->load(['empleador', 'ofertas', 'aplicaciones']);
        return view('admin.users.show', compact('user'));
    }

    public function edit(Usuario $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    public function update(Request $request, Usuario $user)
    {
        $request->validate([
            'nombre_usuario' => 'required|string|max:255',
            'correo_electronico' => ['required', 'email', Rule::unique('usuarios')->ignore($user->id_usuario, 'id_usuario')],
            'rol' => 'required|in:empleado,empleador,admin',
            'activo' => 'boolean',
            'telefono' => 'nullable|string|max:20',
            'ubicacion' => 'nullable|string|max:255',
            'descripcion' => 'nullable|string',
        ]);

        $user->update($request->all());

        if ($request->hasFile('foto_perfil')) {
            if ($user->foto_perfil) {
                Storage::delete('public/profiles/' . basename($user->foto_perfil));
            }
            $path = $request->file('foto_perfil')->store('public/profiles');
            $user->foto_perfil = Storage::url($path);
            $user->save();
        }

        return redirect()
            ->route('admin.users.show', $user)
            ->with('success', 'Usuario actualizado correctamente');
    }

    public function destroy(Usuario $user)
    {
        // Verificar si el usuario es el último administrador
        if ($user->rol === 'admin') {
            $adminCount = Usuario::where('rol', 'admin')->count();
            if ($adminCount <= 1) {
                return back()->withErrors(['error' => 'No se puede eliminar el último administrador del sistema']);
            }
        }

        // Comenzar transacción
        \DB::beginTransaction();

        try {
            // Si es empleador, eliminar sus ofertas y aplicaciones relacionadas
            if ($user->rol === 'empleador') {
                foreach ($user->ofertas as $oferta) {
                    $oferta->aplicaciones()->delete();
                    $oferta->delete();
                }
                if ($user->empleador) {
                    if ($user->empleador->logo_empresa) {
                        Storage::delete('public/logos/' . basename($user->empleador->logo_empresa));
                    }
                    $user->empleador->delete();
                }
            }

            // Si es empleado, eliminar sus aplicaciones
            if ($user->rol === 'empleado') {
                $user->aplicaciones()->delete();
            }

            // Eliminar foto de perfil si existe
            if ($user->foto_perfil) {
                Storage::delete('public/profiles/' . basename($user->foto_perfil));
            }

            // Eliminar usuario
            $user->delete();

            \DB::commit();
            return redirect()
                ->route('admin.users.index')
                ->with('success', 'Usuario eliminado correctamente');
        } catch (\Exception $e) {
            \DB::rollBack();
            return back()->withErrors(['error' => 'Error al eliminar el usuario']);
        }
    }

    public function toggleStatus(Usuario $user)
    {
        // Verificar si el usuario es el último administrador activo
        if ($user->rol === 'admin' && $user->activo) {
            $activeAdminCount = Usuario::where('rol', 'admin')
                                     ->where('activo', true)
                                     ->count();
            if ($activeAdminCount <= 1) {
                return response()->json([
                    'success' => false,
                    'message' => 'No se puede desactivar el último administrador activo'
                ]);
            }
        }

        $user->activo = !$user->activo;
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Estado del usuario actualizado correctamente',
            'status' => $user->activo
        ]);
    }

    public function resetPassword(Usuario $user)
    {
        $newPassword = \Str::random(10);
        $user->contrasena = Hash::make($newPassword);
        $user->save();

        // Aquí podrías enviar un email al usuario con su nueva contraseña

        return response()->json([
            'success' => true,
            'message' => 'Contraseña restablecida correctamente',
            'password' => $newPassword
        ]);
    }
}
