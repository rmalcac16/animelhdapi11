<div>
    <div class="page-header no-margin-bottom">
        <div class="container-fluid">
            <h2 class="h5 no-margin-bottom">{{ __('Move Files') }}</h2>
        </div>
    </div>

    <section class="mt-4">
        <div class="container-fluid">
            @if (session()->has('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>{{ __('Success!') }}</strong> {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @elseif(session()->has('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>{{ __('Error!') }}</strong> {{ session('error') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            @if (filled($apiKey))
                <h2 class="mb-4 text-center">{{ __('File Management') }}</h2>

                <div class="row">
                    <div class="col-12 col-md-6">
                        <div class="card">
                            <div class="card-header">{{ __('Get Files') }}</div>
                            <div class="card-body">
                                <form wire:submit.prevent="getFiles">
                                    <div class="mb-3">
                                        <label for="folder_id" class="form-label">{{ __('Initial Folder') }}</label>
                                        <input type="number" min="0" id="folder_id" class="form-control"
                                            wire:model="folderId" placeholder="{{ __('Insert initial folder') }}">
                                    </div>
                                    <button wire:loading.attr="disabled" type="submit" class="btn btn-primary">
                                        <span wire:loading wire:target="getFiles"
                                            class="spinner-border spinner-border-sm" role="status"
                                            aria-hidden="true"></span>
                                        <span wire:loading.remove wire:target="getFiles">{{ __('Get Files') }}</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                    @if ($selectedFiles)
                        <div class="col-12 col-md-6">
                            <div class="card">
                                <div class="card-header">{{ __('Move Files') }}</div>
                                <div class="card-body">
                                    <form wire:submit.prevent="moveSelectedFiles">
                                        <div class="mb-3">
                                            <label for="folder_id_destination"
                                                class="form-label">{{ __('Destination Folder') }}</label>
                                            <input type="number" min="0" id="folder_id_destination"
                                                class="form-control" wire:model.live="destinationFolderId"
                                                placeholder="{{ __('Insert destination folder') }}">
                                        </div>
                                        <button @if (empty($selectedFiles) || $destinationFolderId === null || $folderId == $destinationFolderId) disabled @endif
                                            wire:loading.attr="disabled" type="submit" class="btn btn-primary">
                                            <span wire:loading wire:target="moveSelectedFiles"
                                                class="spinner-border spinner-border-sm" role="status"
                                                aria-hidden="true"></span>
                                            <span wire:loading.remove
                                                wire:target="moveSelectedFiles">{{ __('Move Files') }}</span>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                @if (count($files) > 0)
                    <div class="card  mb-4 shadow-sm border-0">
                        <div class="card-body">
                            <h5 class="card-title">{{ __('File List') }}</h5>
                            <table class="table table-striped" id="fileTable">
                                <thead>
                                    <tr>
                                        <th><input type="checkbox" id="selectAll"></th>
                                        <th><a href="#" class="sort-link"
                                                data-sort="name">{{ __('Name') }}</a></th>
                                        <th><a href="#" class="sort-link"
                                                data-sort="uploaded">{{ __('Upload Date') }}</a></th>
                                        <th><a href="#" class="sort-link"
                                                data-sort="views">{{ __('Views') }}</a></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($files as $file)
                                        <tr>
                                            <td><input type="checkbox" id="selectFile" class="file-checkbox"
                                                    value="{{ $file['file_code'] }}"></td>
                                            <td><a href="https://luluvdo.com/e/{{ $file['file_code'] }}"
                                                    target="_blank">
                                                    {{ $file['title'] }}
                                                </a></td>
                                            <td>{{ $file['uploaded'] }}</td>
                                            <td>{{ $file['views'] }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif
            @endif
        </div>
    </section>
</div>

@push('scripts')
    <script>
        Livewire.on('files-updating', () => {
            initializeFileSelection();
            initializeTableSorting();
        });

        function initializeFileSelection() {
            let selectedFiles = [];

            document.addEventListener('change', function(event) {
                if (event.target.id === 'selectAll') {
                    handleSelectAllChange();
                }
                if (event.target.classList.contains('file-checkbox')) {
                    handleFileCheckboxChange(event.target);
                }
            });

        }

        function handleSelectAllChange() {
            const selectAllCheckbox = document.getElementById('selectAll');
            const fileCheckboxes = document.querySelectorAll('.file-checkbox');

            fileCheckboxes.forEach(function(checkbox) {
                checkbox.checked = selectAllCheckbox.checked;
                if (checkbox.checked) {
                    if (!selectedFiles.includes(checkbox.value)) {
                        selectedFiles.push(checkbox.value);
                    }
                } else {
                    const index = selectedFiles.indexOf(checkbox.value);
                    if (index > -1) {
                        selectedFiles.splice(index, 1);
                    }
                }
            });

            @this.set('selectedFiles', selectedFiles);
        }

        function handleFileCheckboxChange(checkbox) {
            const selectedFiles = @this.get('selectedFiles');

            if (checkbox.checked) {
                if (!selectedFiles.includes(checkbox.value)) {
                    selectedFiles.push(checkbox.value);
                }
            } else {
                const index = selectedFiles.indexOf(checkbox.value);
                if (index > -1) {
                    selectedFiles.splice(index, 1);
                }
            }
            @this.set('selectedFiles', selectedFiles);
        }


        function initializeTableSorting() {
            document.addEventListener('click', function(event) {
                if (event.target.classList.contains('sort-link')) {
                    event.preventDefault();
                    const field = event.target.getAttribute('data-sort');
                    sortTable(field);
                }
            });

            let sortOrder = {
                name: 'asc',
                uploaded: 'asc',
                views: 'asc'
            };

            function sortTable(field) {
                const fileTable = document.querySelector('#fileTable tbody');
                if (!fileTable) return;

                const rows = Array.from(fileTable.querySelectorAll('tr'));
                const direction = sortOrder[field] === 'asc' ? 1 : -1;

                rows.sort((rowA, rowB) => {
                    const cellA = rowA.querySelector(`td:nth-child(${getColumnIndex(field)})`).innerText.trim();
                    const cellB = rowB.querySelector(`td:nth-child(${getColumnIndex(field)})`).innerText.trim();

                    if (!isNaN(cellA) && !isNaN(cellB)) {
                        return direction * (parseInt(cellA) - parseInt(cellB));
                    }
                    return direction * cellA.localeCompare(cellB);
                });

                rows.forEach(row => fileTable.appendChild(row));
                sortOrder[field] = sortOrder[field] === 'asc' ? 'desc' : 'asc';
            }

            function getColumnIndex(field) {
                switch (field) {
                    case 'name':
                        return 2;
                    case 'uploaded':
                        return 3;
                    case 'views':
                        return 4;
                }
            }
        }
    </script>
@endpush
