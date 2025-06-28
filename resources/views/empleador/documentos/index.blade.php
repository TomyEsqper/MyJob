@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Documentos de la Empresa</h4>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    <!-- Información de la empresa -->
                    <div class="mb-4">
                        <h5>Información de la Empresa</h5>
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>NIT:</strong> {{ auth()->user()->empleador->nit ?? 'No especificado' }}</p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Correo empresarial:</strong> {{ auth()->user()->empleador->correo_empresarial ?? 'No especificado' }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Formulario de carga de documentos -->
                    <div class="mb-4">
                        <h5>Subir Nuevo Documento</h5>
                        <form action="{{ route('empleador.documentos.store') }}" method="POST" enctype="multipart/form-data" class="row g-3">
                            @csrf
                            <div class="col-md-6">
                                <select name="tipo_documento" class="form-select" required>
                                    <option value="">Seleccione el tipo de documento</option>
                                    @foreach(App\Models\DocumentoEmpresa::getTiposDocumento() as $key => $value)
                                        <option value="{{ $key }}">{{ $value }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6">
                                <input type="file" name="documento" class="form-control" required>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary">Subir Documento</button>
                            </div>
                        </form>
                    </div>

                    <!-- Lista de documentos -->
                    <div>
                        <h5>Documentos Subidos</h5>
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Tipo de Documento</th>
                                        <th>Nombre del Archivo</th>
                                        <th>Estado</th>
                                        <th>Comentarios</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($documentos as $documento)
                                        <tr>
                                            <td>{{ App\Models\DocumentoEmpresa::getTiposDocumento()[$documento->tipo_documento] }}</td>
                                            <td>{{ $documento->nombre_archivo }}</td>
                                            <td>
                                                @switch($documento->estado)
                                                    @case('pendiente')
                                                        <span class="badge bg-warning">Pendiente</span>
                                                        @break
                                                    @case('aprobado')
                                                        <span class="badge bg-success">Aprobado</span>
                                                        @break
                                                    @case('rechazado')
                                                        <span class="badge bg-danger">Rechazado</span>
                                                        @break
                                                @endswitch
                                            </td>
                                            <td>{{ $documento->comentarios_admin }}</td>
                                            <td>
                                                <a href="{{ Storage::url($documento->ruta_archivo) }}" target="_blank" class="btn btn-sm btn-info">Ver</a>
                                                <form action="{{ route('empleador.documentos.destroy', $documento) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('¿Está seguro de eliminar este documento?')">Eliminar</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center">No hay documentos subidos</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection 