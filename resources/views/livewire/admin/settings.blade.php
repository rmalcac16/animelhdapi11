<div class="my-4">

    @if (session()->has('message'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle-fill"></i> {{ session('message') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <h2 class="mb-4">{{ __('Manage API Keys') }}</h2>

    <form wire:submit.prevent="saveApiKeys">
        <div class="mb-3">
            <label for="voeKey" class="form-label"><i class="bi bi-key-fill"></i> {{ __('Voe API Key') }}</label>
            <input type="text" id="voeKey" wire:model="apiKeys.voe" class="form-control bg-dark text-light"
                placeholder="Enter Voe API key">
        </div>

        <div class="mb-3">
            <label for="filemoonKey" class="form-label"><i class="bi bi-key-fill"></i>
                {{ __('Filemoon API Key') }}</label>
            <input type="text" id="filemoonKey" wire:model="apiKeys.filemoon"
                class="form-control bg-dark bg-dark text-light"" placeholder="Enter Filemoon API key">
        </div>

        <div class="mb-3">
            <label for="lulustreamKey" class="form-label"><i class="bi bi-key-fill"></i>
                {{ __('Lulustream API Key') }}</label>
            <input type="text" id="lulustreamKey" wire:model="apiKeys.lulustream"
                class="form-control bg-dark bg-dark text-light" placeholder="Enter Lulustream API key">
        </div>

        <button type="submit" class="btn btn-outline-light btn-lg w-100 mt-3">
            <i class="bi bi-save-fill"></i> {{ __('Save API Keys') }}
        </button>
    </form>
</div>
