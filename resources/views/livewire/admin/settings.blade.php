<div>

    <div class="page-header no-margin-bottom">
        <div class="container-fluid">
            <h2 class="h5 no-margin-bottom">{{ __('Settings') }}</h2>
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
            <div class="block">
                <div class="title"><strong class="d-block">{{ __('API keys') }}</strong>
                    <span class="d-block">{{ __('Manage all api keys') }}</span>
                </div>
                <div class="block-body">
                    <form wire:submit.prevent="saveApiKeys">
                        <div class="row">
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label class="form-control-label" for="voe">{{ __('Voe') }}</label>
                                    <input wire:model="apiKeys.voe" id="voe" type="text"
                                        placeholder="{{ __('Api key for voe...') }}" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label" for="filemoon">{{ __('Filemoon') }}</label>
                                    <input wire:model="apiKeys.filemoon" id="filemoon" type="text"
                                        placeholder="{{ __('Api key for filemoon...') }}" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label" for="lulustream">{{ __('Lulustream') }}</label>
                                    <input wire:model="apiKeys.lulustream" id="lulustream" type="text"
                                        placeholder="{{ __('Api key for lulustream...') }}" class="form-control">
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-group">
                                    <label class="form-control-label"
                                        for="tmdb">{{ __('TheMovieDatabase') }}</label>
                                    <input wire:model="apiKeys.tmdb" id="tmdb" type="text"
                                        placeholder="{{ __('Api key for tmdb...') }}" class="form-control">
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label" for="mal">{{ __('MyAnimeList') }}</label>
                                    <input wire:model="apiKeys.mal" id="mal" type="text"
                                        placeholder="{{ __('Api key for mal...') }}" class="form-control">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <button wire:loading.attr="disabled" type="submit" class="btn btn-primary">
                                <span wire:loading wire:target="saveApiKeys" class="spinner-border spinner-border-sm"
                                    role="status" aria-hidden="true"></span>
                                <span wire:loading.remove>{{ __('Save') }}</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>
