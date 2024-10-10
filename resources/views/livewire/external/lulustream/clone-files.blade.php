<div>

    <div class="page-header no-margin-bottom">
        <div class="container-fluid">
            <h2 class="h5 no-margin-bottom">{{ __('Clone Files') }}</h2>
        </div>
    </div>

    <section class="mt-4">
        <div class="container-fluid">
            @if (session()->has('message'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>{{ __('Success!') }}</strong> {{ session('message') }}
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
                <div class="row">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h4>{{ __('Clone') }}</h4>
                            </div>
                            <div class="card-body">
                                <form wire:submit.prevent="cloneFiles">
                                    <div class="mb-3">
                                        <label for="folder_id" class="form-label">{{ __('Destination Folder') }}</label>
                                        <input type="text" id="folder_id" class="form-control" wire:model="folderId"
                                            placeholder="{{ __('Destination Folder ID') }}">
                                    </div>
                                    <div class="mb-3">
                                        <label for="file_codes" class="form-label">{{ __('File Codes') }}</label>
                                        <textarea class="form-control" id="file_codes" wire:model="fileCodes" rows="10"
                                            placeholder="{{ __('Enter file codes, separated by commas or new lines.') }}"></textarea>
                                    </div>
                                    <button wire:loading.attr="disabled" type="submit" class="btn btn-primary">
                                        <span wire:loading wire:target="cloneFiles"
                                            class="spinner-border spinner-border-sm" role="status"
                                            aria-hidden="true"></span>
                                        <span wire:loading.remove>{{ __('Clone') }}</span>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h4>{{ __('Results') }}</h4>
                            </div>
                            <div class="card-body">
                                @if (!empty($clonedFiles))
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <button onclick="sortList('asc')" class="btn btn-secondary btn-sm">
                                            <span>{{ __('Sort A-Z') }}</span>
                                        </button>
                                        <button class="btn btn-primary btn-sm" onclick="copyAllEmbedUrls()">
                                            {{ __('Copy All') }}
                                        </button>
                                    </div>
                                @endif
                                <ul class="list-group" id="responseList">
                                    @forelse ($clonedFiles as $file)
                                        <li class="list-group-item d-flex justify-content-between align-items-center">
                                            <a href="{{ $file['url_embed'] }}"
                                                target="_blank">{{ $file['file_name'] }}</a>
                                            <button class="btn btn-info btn-sm float-end"
                                                onclick="copyToClipboard('{{ $file['url_embed'] }}')">
                                                {{ __('Copy') }}
                                            </button>
                                        </li>
                                    @empty
                                        <div class="mt-2">
                                            {{ __('No files cloned.') }}
                                        </div>
                                    @endforelse
                                </ul>
                            </div>
                            <div class="card-footer d-flex justify-content-around">
                                <div class="d-flex justify-content-between w-100">
                                    <span class="text-success">{{ __('Successful:') }}
                                        {{ $successfulClones }}</span>
                                    <span class="text-danger">{{ __('Failed:') }} {{ $failedClones }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </section>

</div>

@push('script')
    <script>
        function sortList(order) {
            var list = document.getElementById('responseList');
            var items = list.children;
            var itemsArr = Array.from(items);

            itemsArr.sort(function(a, b) {
                var aValue = a.querySelector('a').innerText.toLowerCase();
                var bValue = b.querySelector('a').innerText.toLowerCase();
                if (order === 'asc') {
                    return aValue.localeCompare(bValue);
                } else {
                    return bValue.localeCompare(aValue);
                }
            });

            itemsArr.forEach(function(item) {
                list.appendChild(item);
            });
        }

        function copyToClipboard(text) {
            var tempInput = document.createElement('input');
            tempInput.value = text;
            document.body.appendChild(tempInput);
            tempInput.select();
            document.execCommand('copy');
            document.body.removeChild(tempInput);
            alert('Enlace copiado al portapapeles');
        }

        function copyAllEmbedUrls() {
            var embedUrls = '';
            var urls = document.querySelectorAll('#responseList a');
            urls.forEach(function(url) {
                embedUrls += url.href + '\n';
            });

            if (embedUrls !== '') {
                var tempInput = document.createElement('textarea');
                tempInput.value = embedUrls.trim();
                document.body.appendChild(tempInput);
                tempInput.select();
                document.execCommand('copy');
                document.body.removeChild(tempInput);
                alert('Todos los enlaces copiados al portapapeles');
            } else {
                alert('No se encontraron enlaces');
            }
        }
    </script>
@endpush
