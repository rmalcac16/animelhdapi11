<div class="container my-4">
    <!-- Título Principal -->
    <h2 class="mb-4 text-center text-light">Gestión de Archivos</h2>

    <!-- Mostrar mensajes de éxito o error -->
    @if (session()->has('message'))
        <div class="alert alert-info">
            {{ session('message') }}
        </div>
    @endif

    <!-- Formulario para ingresar el ID de la carpeta -->
    <div class="card bg-secondary mb-4 shadow-sm border-0">
        <div class="card-body">
            <h5 class="card-title text-light">Buscar Archivos en Carpeta</h5>
            <form wire:submit.prevent="getFiles" class="row g-3">
                <div class="col-md-6">
                    <input type="number" wire:model.lazy="folderId" class="form-control bg-dark text-light border-0"
                        placeholder="Ingrese el ID de la carpeta" min="0" aria-label="ID de Carpeta">
                </div>
                <div class="col-md-3">
                    <button class="btn btn-primary w-100" type="submit"
                        style="background-color: var(--color-primary);">
                        <i class="bi bi-folder"></i> Consultar
                    </button>
                </div>
            </form>
        </div>
    </div>

    @if (count($files) > 0)
        <!-- Formulario para seleccionar archivos y moverlos a otra carpeta -->
        <div class="card bg-secondary mb-4 shadow-sm border-0">
            <div class="card-body">
                <h5 class="card-title text-light">Mover Archivos Seleccionados</h5>
                <form wire:submit.prevent="moveSelectedFiles" class="row g-3">
                    <div class="col-md-4">
                        <input type="number" wire:model.lazy="destinationFolderId"
                            class="form-control bg-dark text-light border-0" placeholder="ID de la carpeta de destino"
                            min="0" required aria-label="ID de Carpeta Destino">
                    </div>
                    <div class="col-md-4">
                        <button class="btn btn-success w-100" type="submit"
                            style="background-color: var(--color-primary);"
                            @if (empty($selectedFiles) || !$destinationFolderId) disabled @endif>
                            <i class="bi bi-arrow-right-circle"></i> Mover archivos seleccionados
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Tabla de archivos simplificada -->
        <div class="card bg-secondary mb-4 shadow-sm border-0">
            <div class="card-body">
                <h5 class="card-title text-light">Lista de Archivos</h5>
                <table class="table table-striped table-dark">
                    <thead>
                        <tr>
                            <th><input type="checkbox" wire:model.live="selectAll"></th>
                            <th>
                                <a href="#" wire:click.prevent="sortBy('name')" class="text-light">
                                    Nombre
                                    @if ($sortField === 'name')
                                        @if ($sortDirection === 'asc')
                                            <i class="bi bi-arrow-up"></i>
                                        @else
                                            <i class="bi bi-arrow-down"></i>
                                        @endif
                                    @endif
                                </a>
                            </th>
                            <th>
                                <a href="#" wire:click.prevent="sortBy('uploaded')" class="text-light">
                                    Fecha de Subida
                                    @if ($sortField === 'uploaded')
                                        @if ($sortDirection === 'asc')
                                            <i class="bi bi-arrow-up"></i>
                                        @else
                                            <i class="bi bi-arrow-down"></i>
                                        @endif
                                    @endif
                                </a>
                            </th>
                            <th>
                                <a href="#" wire:click.prevent="sortBy('views')" class="text-light">
                                    Vistas
                                    @if ($sortField === 'views')
                                        @if ($sortDirection === 'asc')
                                            <i class="bi bi-arrow-up"></i>
                                        @else
                                            <i class="bi bi-arrow-down"></i>
                                        @endif
                                    @endif
                                </a>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($files as $file)
                            <tr>
                                <td><input type="checkbox" wire:model.live="selectedFiles"
                                        value="{{ $file['file_code'] }}">
                                </td>
                                <td>{{ $file['name'] }}</td>
                                <td>{{ $file['uploaded'] }}</td>
                                <td>{{ $file['views'] }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @else
        <div class="alert alert-warning text-center bg-secondary text-light border-0">No se encontraron archivos.</div>
    @endif
</div>
