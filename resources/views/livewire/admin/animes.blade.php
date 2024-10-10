<div>
    <!-- Modal -->
    <div class="modal fade @if ($showModal) show @endif" id="addAnimeModal" tabindex="-1" role="dialog"
        aria-labelledby="addAnimeModalLabel" aria-hidden="true"
        style="@if ($showModal) display: block; @endif">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addAnimeModalLabel">{{ __('Add New Anime') }}</h5>
                    <button type="button" class="close" wire:click="$set('showModal', false)" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <input type="text" wire:model="name" class="form-control" placeholder="Anime Name">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" wire:click="$set('showModal', false)">
                        {{ __('Close') }}
                    </button>
                    <button type="button" class="btn btn-primary" wire:click="saveAnime">
                        {{ __('Save') }}
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
