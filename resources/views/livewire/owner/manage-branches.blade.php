<div>
    <div class="d-flex justify-between align-center mb-4" style="margin-bottom: 20px;">
        <h3><i class="fa-solid fa-code-branch" style="color: var(--primary-blue);"></i> {{ __('Branches') }}</h3>
        <button class="btn btn-primary" wire:click="toggleForm">
            <i class="fa-solid {{ $showForm ? 'fa-times' : 'fa-plus' }}"></i> {{ $showForm ? __('Cancel') : __('New Branch') }}
        </button>
    </div>

    @if($showForm)
        <div style="background: var(--bg-color); padding: 16px; border-radius: var(--radius-md); margin-bottom: 20px;">
            <div style="margin-bottom: 12px;">
                <label style="display: block; font-weight: 500; margin-bottom: 4px;">{{ __('Branch Name') }}</label>
                <input type="text" class="form-control" style="width: 100%; padding: 10px; border-radius: var(--radius-md); border: 1px solid #d1d5db;" wire:model="name" placeholder="{{ __('e.g. City Center Branch') }}">
                @error('name') <span style="color: var(--danger); font-size: 0.875rem;">{{ $message }}</span> @enderror
            </div>
            <div style="margin-bottom: 16px;">
                <label style="display: block; font-weight: 500; margin-bottom: 4px;">{{ __('Address (Optional)') }}</label>
                <input type="text" class="form-control" style="width: 100%; padding: 10px; border-radius: var(--radius-md); border: 1px solid #d1d5db;" wire:model="address" placeholder="{{ __('e.g. Makumbusho') }}">
                @error('address') <span style="color: var(--danger); font-size: 0.875rem;">{{ $message }}</span> @enderror
            </div>
            <button class="btn btn-success" wire:click="createBranch"><i class="fa-solid fa-save"></i> {{ __('Save Branch') }}</button>
        </div>
    @endif

    <div class="table-responsive" style="background: white; border-radius: var(--radius-lg); box-shadow: var(--shadow-sm);">
        <table style="width: 100%; border-collapse: collapse; min-width: 600px;">
            <thead style="background: var(--primary-blue); color: white;">
                <tr>
                    <th style="padding: 12px; text-align: left;">{{ __('Name') }}</th>
                    <th style="padding: 12px; text-align: left;">{{ __('Address') }}</th>
                    <th style="padding: 12px; text-align: center;">{{ __('Actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($branches as $branch)
                    <tr style="border-bottom: 1px solid #e5e7eb;">
                        <td style="padding: 12px; font-weight: 600;">{{ $branch->name }}</td>
                        <td style="padding: 12px; color: var(--text-muted);">{{ $branch->address ?? 'N/A' }}</td>
                        <td style="padding: 12px; text-align: center;">
                            <button wire:click="editBranch({{ $branch->id }})" class="btn btn-gold" style="padding: 6px 12px;"><i class="fa-solid fa-edit"></i></button>
                            <button wire:click="deleteBranch({{ $branch->id }})" wire:confirm="{{ __('Are you sure?') }}" class="btn" style="padding: 6px 12px; background: var(--danger); color: white;"><i class="fa-solid fa-trash"></i></button>
                        </td>
                    </tr>
                @endforeach
                @if(count($branches) == 0)
                    <tr>
                        <td colspan="3" style="padding: 20px; text-align: center; color: var(--text-muted);">{{ __('No branches found.') }}</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>
