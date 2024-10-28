<div>
    <div class="page-header">
        <div class="container-fluid">
            <h2 class="h5 no-margin-bottom">{{ __('Users') }} - {{ __('Update by admin') }}</h2>
        </div>
    </div>

    <section class="no-padding-top no-padding-bottom">
        <div class="container-fluid">
            <form>
                <input type="text" placeholder="{{ __('Insert name or email...') }}"
                    wire:model.live.debounce.500ms="query" class="form-control mb-3" />
            </form>

            @if (count($users) > 0)
                <ul class="my-4 p-0">
                    @foreach ($users as $user)
                        <li class="p-2 mb-2 card rounded border-dark" wire:click="selectUser({{ $user->id }})"
                            style="cursor: pointer;">
                            <div class="d-flex align-items-center justify-content-between">
                                <span>{{ $user->name }}</span>
                                <small>{{ $user->email }}</small>
                                <button
                                    class="btn font-weight-bold text-sm btn-sm @if ($user->isPremium) btn-success @else btn-danger @endif">
                                    {{ $user->isPremium ? __('Premiun') : __('Normal') }}</button>
                            </div>
                        </li>
                    @endforeach
                    <div class="text-center">
                        <button class="btn btn-info w-100" wire:click="clearAllData">
                            <i class="fa fa-info"></i>
                            {{ __('Clear users query') }}
                        </button>
                    </div>
                </ul>
            @endif

            @if ($selectedUser)
                <div class="card mt-4">
                    <div class="card-header">
                        <h5 class="card-title">{{ __('Update user') . ': ' . $selectedUser->name }}</h5>
                    </div>

                    <div class="card-body">
                        <div class="form-group d-flex align-items-center justify-content-between">
                            <label>{{ __('Premium Status') }}</label>
                            <button class="btn btn-sm {{ $selectedUser->isPremium ? 'btn-success' : 'btn-danger' }}"
                                wire:click="togglePremium">
                                {{ $selectedUser->isPremium ? __('Premium') : __('Not Premium') }}
                            </button>
                        </div>

                        @if (!$showEmailField)
                            <div class="text-center">
                                <button class="btn btn-primary btn-sm mt-3 w-100" wire:click="enableEmailChange">
                                    {{ __('Change Email') }}
                                </button>
                            </div>
                        @endif

                        @if (!$showPasswordField)
                            <div class="text-center">
                                <button class="btn btn-primary btn-sm mt-3 w-100" wire:click="enablePasswordChange">
                                    {{ __('Change Password') }}
                                </button>
                            </div>
                        @endif

                        @if ($showEmailField)
                            <div class="form-group mt-3">
                                <label for="currentEmail">{{ __('Current Email') }}</label>
                                <input disabled type="email" class="form-control"
                                    value="{{ $selectedUser->email }}" />
                                <label for="newEmail">{{ __('New Email') }}</label>
                                <input type="email" class="form-control" wire:model="newEmail"
                                    placeholder="{{ __('Enter new email') }}" />
                                @error('newEmail')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <button class="btn btn-primary btn-sm mt-2" wire:click="updateEmail">
                                    {{ __('Update Email') }}
                                </button>
                                <button class="btn btn-secondary btn-sm mt-2" wire:click="cancelUpdateEmail">
                                    {{ __('Cancel') }}
                                </button>
                            </div>
                    </div>
            @endif

            @if ($showPasswordField)
                <div class="form-group mt-3">
                    <label for="newPassword">{{ __('New Password') }}</label>
                    <input type="password" class="form-control" wire:model="newPassword"
                        placeholder="{{ __('Enter new password') }}" />
                    <button class="btn btn-primary btn-sm mt-2" wire:click="updatePassword">
                        {{ __('Update Password') }}
                    </button>
                    <button class="btn btn-secondary btn-sm mt-2" wire:click="cancelUpdatePassword">
                        {{ __('Cancel') }}
                    </button>
                </div>
            @endif
        </div>
</div>
@endif

@if (session()->has('success'))
    <div class="alert alert-success mt-3">
        {{ session('success') }}
    </div>
@else
    @if (session()->has('error'))
        <div class="alert alert-danger mt-3">
            {{ session('error') }}
        </div>
    @endif
@endif
</div>
</section>
</div>
