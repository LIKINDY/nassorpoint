<div>
    <div class="d-flex justify-between align-center mb-4" style="margin-bottom: 20px;">
        <h3><i class="fa-solid fa-users" style="color: var(--primary-blue);"></i> {{ __('Restaurant Owners') }}</h3>
        <button class="btn btn-primary" wire:click="toggleForm">
            <i class="fa-solid {{ $showForm ? 'fa-times' : 'fa-plus' }}"></i> {{ $showForm ? __('Cancel') : __('Add Owner') }}
        </button>
    </div>

    @if (session()->has('message'))
        <div style="padding: 12px; margin-bottom: 20px; border-radius: var(--radius-md); background: #dcfce7; color: #166534; border: 1px solid #bbf7d0;">
            <i class="fa-solid fa-check-circle"></i> {{ session('message') }}
        </div>
    @endif

    @if($showForm)
        <div style="background: var(--bg-color); padding: 16px; border-radius: var(--radius-md); margin-bottom: 20px;">
            <div style="margin-bottom: 12px;">
                <label style="display: block; font-weight: 500; margin-bottom: 4px;">{{ __('Name') }}</label>
                <input type="text" class="form-control" style="width: 100%; padding: 10px; border-radius: var(--radius-md); border: 1px solid #d1d5db;" wire:model="name">
                @error('name') <span style="color: var(--danger); font-size: 0.875rem;">{{ $message }}</span> @enderror
            </div>
            <div style="margin-bottom: 12px;">
                <label style="display: block; font-weight: 500; margin-bottom: 4px;">{{ __('Restaurant Name') }}</label>
                <input type="text" class="form-control" style="width: 100%; padding: 10px; border-radius: var(--radius-md); border: 1px solid #d1d5db;" wire:model="restaurant_name" placeholder="{{ __('e.g. The Nassor Bistro') }}">
                @error('restaurant_name') <span style="color: var(--danger); font-size: 0.875rem;">{{ $message }}</span> @enderror
            </div>
            <div style="margin-bottom: 12px;">
                <label style="display: block; font-weight: 500; margin-bottom: 4px;">{{ __('Email') }}</label>
                <input type="email" class="form-control" style="width: 100%; padding: 10px; border-radius: var(--radius-md); border: 1px solid #d1d5db;" wire:model="email">
                @error('email') <span style="color: var(--danger); font-size: 0.875rem;">{{ $message }}</span> @enderror
            </div>
            <div style="margin-bottom: 16px;">
                <label style="display: block; font-weight: 500; margin-bottom: 4px;">{{ __('Password') }}</label>
                <input type="password" class="form-control" style="width: 100%; padding: 10px; border-radius: var(--radius-md); border: 1px solid #d1d5db;" wire:model="password">
                @error('password') <span style="color: var(--danger); font-size: 0.875rem;">{{ $message }}</span> @enderror
            </div>
            <button class="btn btn-success" wire:click="createOwner"><i class="fa-solid fa-save"></i> {{ __('Save Owner') }}</button>
        </div>
    @endif

    <div class="table-responsive" style="background: white; border-radius: var(--radius-lg); box-shadow: var(--shadow-sm);">
        <table style="width: 100%; border-collapse: collapse; min-width: 600px;">
            <thead style="background: var(--primary-blue); color: white;">
                <tr>
                    <th style="padding: 12px; text-align: left;">{{ __('Name') }}</th>
                    <th style="padding: 12px; text-align: left;">{{ __('Restaurant') }}</th>
                    <th style="padding: 12px; text-align: left;">{{ __('Email') }}</th>
                    <th style="padding: 12px; text-align: center;">{{ __('Actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($owners as $owner)
                    <tr style="border-bottom: 1px solid #e5e7eb;">
                        <td style="padding: 12px;">{{ $owner->name }}</td>
                        <td style="padding: 12px;">{{ $owner->restaurant_name ?? 'N/A' }}</td>
                        <td style="padding: 12px;">{{ $owner->email }}</td>
                        <td style="padding: 12px; text-align: center;">
                            <button wire:click="initResetPassword({{ $owner->id }})" class="btn" style="padding: 6px 12px; background: var(--primary-blue); color: white;"><i class="fa-solid fa-key"></i></button>
                            <button wire:click="editOwner({{ $owner->id }})" class="btn btn-gold" style="padding: 6px 12px;"><i class="fa-solid fa-edit"></i></button>
                            <button wire:click="deleteOwner({{ $owner->id }})" wire:confirm="{{ __('Are you sure?') }}" class="btn" style="padding: 6px 12px; background: var(--danger); color: white;"><i class="fa-solid fa-trash"></i></button>
                        </td>
                    </tr>
                @endforeach
                @if(count($owners) == 0)
                    <tr>
                        <td colspan="4" style="padding: 20px; text-align: center; color: var(--text-muted);">{{ __('No owners found.') }}</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
    <!-- Reset Password Modal/Form -->
    @if($resettingOwnerId)
    <div style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); display: flex; align-items: center; justify-content: center; z-index: 1000;">
        <div style="background: white; padding: 24px; border-radius: var(--radius-lg); width: 100%; max-width: 400px; box-shadow: var(--shadow-md);">
            <h4><i class="fa-solid fa-key" style="color: var(--primary-blue);"></i> {{ __('Reset Password') }}</h4>
            <p style="color: var(--text-muted); margin-bottom: 16px;">{{ __('Set a new password for this user.') }}</p>
            
            <form wire:submit.prevent="resetPassword">
                <div class="mb-4">
                    <label style="display: block; margin-bottom: 8px; font-weight: 500;">{{ __('New Password') }}</label>
                    <input type="text" class="form-control" wire:model="newPassword" placeholder="{{ __('e.g. 12345678') }}" style="width: 100%; padding: 10px 14px; border-radius: var(--radius-md); border: 1px solid #d1d5db;">
                    @error('newPassword') <span style="color: var(--danger); font-size: 0.875rem;">{{ $message }}</span> @enderror
                </div>
                
                <div class="d-flex justify-between" style="margin-top: 20px;">
                    <button type="button" class="btn" wire:click="cancelReset" style="background: #e5e7eb; color: #374151;">{{ __('Cancel') }}</button>
                    <button type="submit" class="btn btn-primary">{{ __('Reset Password') }}</button>
                </div>
            </form>
        </div>
    </div>
    @endif
</div>
