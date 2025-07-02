@extends('layouts.empleador')

@section('page-title', 'Configuración')
@section('page-description', 'Gestiona la configuración de tu cuenta')

@section('content')
<div class="container-fluid">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="row">
        @if(!Auth::user()->google_id)
        <!-- Cambiar Contraseña -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 text-primary">
                        <i class="fas fa-key me-2"></i>Cambiar Contraseña
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('empleador.actualizar-contrasena') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="current_password" class="form-label">Contraseña Actual</label>
                            <input type="password" 
                                   class="form-control @error('current_password') is-invalid @enderror" 
                                   id="current_password" 
                                   name="current_password" 
                                   required>
                            @error('current_password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Nueva Contraseña</label>
                            <input type="password" 
                                   class="form-control @error('password') is-invalid @enderror" 
                                   id="password" 
                                   name="password" 
                                   required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Confirmar Nueva Contraseña</label>
                            <input type="password" 
                                   class="form-control" 
                                   id="password_confirmation" 
                                   name="password_confirmation" 
                                   required>
                        </div>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Actualizar Contraseña
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @endif

        <!-- Eliminar Cuenta -->
        <div class="col-lg-6">
            <div class="card shadow-sm border-danger">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 text-danger">
                        <i class="fas fa-exclamation-triangle me-2"></i>Eliminar Cuenta
                    </h5>
                </div>
                <div class="card-body">
                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        <strong>¡Advertencia!</strong> Esta acción es irreversible. Se eliminarán:
                        <ul class="mb-0 mt-2">
                            <li>Tu perfil de empleador</li>
                            <li>Todas tus ofertas de trabajo</li>
                            <li>Todas las aplicaciones a tus ofertas</li>
                            <li>Tu cuenta de usuario</li>
                        </ul>
                    </div>
                    @if(!Auth::user()->google_id)
                    <form action="{{ route('empleador.eliminar-cuenta') }}" method="POST" id="deleteAccountForm">
                        @csrf
                        @method('DELETE')
                        <div class="mb-3">
                            <label for="delete_password" class="form-label">Ingresa tu contraseña para confirmar</label>
                            <input type="password" 
                                   class="form-control @error('password') is-invalid @enderror" 
                                   id="delete_password" 
                                   name="password" 
                                   required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <button type="button" 
                                class="btn btn-danger" 
                                onclick="confirmarEliminacion()">
                            <i class="fas fa-trash-alt me-2"></i>Eliminar mi cuenta
                        </button>
                    </form>
                    @else
                    <div class="alert alert-info mb-3">
                        <i class="fab fa-google me-2"></i>Has iniciado sesión con Google. No necesitas ingresar una contraseña para eliminar tu cuenta.
                    </div>
                    <form action="{{ route('empleador.eliminar-cuenta') }}" method="POST" id="deleteAccountForm">
                        @csrf
                        @method('DELETE')
                        <button type="button" 
                                class="btn btn-danger" 
                                onclick="confirmarEliminacion()">
                            <i class="fas fa-trash-alt me-2"></i>Eliminar mi cuenta
                        </button>
                    </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
function confirmarEliminacion() {
    if (confirm('¿Estás seguro de que deseas eliminar tu cuenta? Esta acción no se puede deshacer.')) {
        document.getElementById('deleteAccountForm').submit();
    }
}
</script>
@endpush

@endsection 