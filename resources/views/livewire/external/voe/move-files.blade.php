<div class="container my-4">
    <!-- Main Title -->
    <h2 class="mb-4 text-center text-light">File Management</h2>

    <!-- Show success or error messages -->
    @if (session()->has('message'))
        <div class="alert alert-info">
            {{ session('message') }}
        </div>
    @endif

    <!-- Show warning if the API key is not configured -->
    @if (filled($apiKey))
        <!-- Folder ID input form -->
        <div class="card bg-secondary mb-4 shadow-sm border-0">
            <div class="card-body">
                <h5 class="card-title text-light">Search Files in Folder</h5>
                <form wire:submit.prevent="getFiles" class="row g-3">
                    <div class="col-md-6">
                        <input type="number" wire:model.lazy="folderId" class="form-control bg-dark text-light border-0"
                            placeholder="Enter Folder ID" min="0" aria-label="Folder ID">
                    </div>
                    <div class="col-md-3">
                        <button class="btn btn-primary w-100" type="submit"
                            style="background-color: var(--color-primary);">
                            <i class="bi bi-folder"></i> Search
                        </button>
                    </div>
                </form>
            </div>
        </div>

        @if (count($files) > 0)
            <!-- Form to select files and move them to another folder -->
            <div class="card bg-secondary mb-4 shadow-sm border-0">
                <div class="card-body">
                    <h5 class="card-title text-light">Move Selected Files</h5>
                    <form wire:submit.prevent="moveSelectedFiles" class="row g-3">
                        <div class="col-md-4">
                            <input type="number" wire:model.lazy="destinationFolderId"
                                class="form-control bg-dark text-light border-0" placeholder="Destination Folder ID"
                                min="0" required aria-label="Destination Folder ID">
                        </div>
                        <div class="col-md-4">
                            <button class="btn btn-success w-100" type="submit"
                                style="background-color: var(--color-primary);"
                                @if (empty($selectedFiles) || !$destinationFolderId) disabled @endif>
                                <i class="bi bi-arrow-right-circle"></i> Move Selected Files
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Simplified file table -->
            <div class="card bg-secondary mb-4 shadow-sm border-0">
                <div class="card-body">
                    <h5 class="card-title text-light">File List</h5>
                    <table class="table table-striped table-dark">
                        <thead>
                            <tr>
                                <th><input type="checkbox" wire:model.live="selectAll"></th>
                                <th>
                                    <a href="#" wire:click.prevent="sortBy('name')" class="text-light">
                                        Name
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
                                        Upload Date
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
                                        Views
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
            <div class="alert alert-warning text-center bg-secondary text-light border-0">
                {{ __('No files found.') }}
            </div>
        @endif
    @endif
</div>
