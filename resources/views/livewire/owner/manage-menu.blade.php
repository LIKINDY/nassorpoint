<div>
    <div class="d-flex justify-between align-center mb-4" style="margin-bottom: 20px; flex-wrap: wrap; gap: 10px;">
        <h3><i class="fa-solid fa-utensils" style="color: var(--primary-gold);"></i> {{ __('Menu Management') }}</h3>
        <div class="d-flex" style="gap: 10px;">
            <button class="btn btn-gold" wire:click="toggleCategoryForm">
                <i class="fa-solid fa-folder-plus"></i> {{ $showCategoryForm ? __('Cancel') : __('New Category') }}
            </button>
            <button class="btn btn-success" wire:click="toggleMenuForm">
                <i class="fa-solid fa-plus"></i> {{ $showMenuForm ? __('Cancel') : __('New Item') }}
            </button>
        </div>
    </div>

    @if($showCategoryForm)
        <div style="background: var(--bg-color); padding: 16px; border-radius: var(--radius-md); margin-bottom: 20px;">
            <h4>{{ __('Add Category') }}</h4>
            <div style="margin-bottom: 12px; margin-top: 12px;">
                <input type="text" class="form-control" placeholder="{{ __('Category Name (e.g. Foods)') }}" style="width: 100%; padding: 10px; border-radius: var(--radius-md); border: 1px solid #d1d5db;" wire:model="categoryName">
                @error('categoryName') <span style="color: var(--danger); font-size: 0.875rem;">{{ $message }}</span> @enderror
            </div>
            <button class="btn btn-primary" wire:click="createCategory"><i class="fa-solid fa-save"></i> {{ __('Save Category') }}</button>
        </div>
    @endif

    @if($showMenuForm)
        <div style="background: var(--bg-color); padding: 16px; border-radius: var(--radius-md); margin-bottom: 20px;">
            <h4>{{ __('Add Menu Item') }}</h4>
            <div style="margin-bottom: 12px; margin-top: 12px;">
                <label style="display: block; font-weight: 500; margin-bottom: 4px;">{{ __('Item Name') }}</label>
                <input type="text" class="form-control" style="width: 100%; padding: 10px; border-radius: var(--radius-md); border: 1px solid #d1d5db;" wire:model="menuName">
                @error('menuName') <span style="color: var(--danger); font-size: 0.875rem;">{{ $message }}</span> @enderror
            </div>
            <div style="margin-bottom: 12px;">
                <label style="display: block; font-weight: 500; margin-bottom: 4px;">{{ __('Price (TZS)') }}</label>
                <input type="number" class="form-control" style="width: 100%; padding: 10px; border-radius: var(--radius-md); border: 1px solid #d1d5db;" wire:model="menuPrice">
                @error('menuPrice') <span style="color: var(--danger); font-size: 0.875rem;">{{ $message }}</span> @enderror
            </div>
            <div style="margin-bottom: 12px;">
                <label style="display: block; font-weight: 500; margin-bottom: 4px;">{{ __('Category') }}</label>
                <select class="form-control" style="width: 100%; padding: 10px; border-radius: var(--radius-md); border: 1px solid #d1d5db;" wire:model="menuCategoryId">
                    <option value="">{{ __('Select Category') }}</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                    @endforeach
                </select>
                @error('menuCategoryId') <span style="color: var(--danger); font-size: 0.875rem;">{{ $message }}</span> @enderror
            </div>
            <button class="btn btn-primary" wire:click="createMenuItem"><i class="fa-solid fa-save"></i> {{ __('Save Menu Item') }}</button>
        </div>
    @endif

    <div class="table-responsive" style="background: white; border-radius: var(--radius-lg); box-shadow: var(--shadow-sm);">
        <table style="width: 100%; border-collapse: collapse; min-width: 600px;">
            <thead style="background: var(--primary-green); color: white;">
                <tr>
                    <th style="padding: 12px; text-align: left;">{{ __('Item') }}</th>
                    <th style="padding: 12px; text-align: left;">{{ __('Category') }}</th>
                    <th style="padding: 12px; text-align: left;">{{ __('Price') }}</th>
                    <th style="padding: 12px; text-align: center;">{{ __('Actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($menuItems as $item)
                    <tr style="border-bottom: 1px solid #e5e7eb;">
                        <td style="padding: 12px;">{{ $item->name }}</td>
                        <td style="padding: 12px;">{{ optional($item->category)->name }}</td>
                        <td style="padding: 12px;">{{ number_format($item->price, 2) }}</td>
                        <td style="padding: 12px; text-align: center;">
                            <button wire:click="editMenuItem({{ $item->id }})" class="btn btn-gold" style="padding: 6px 12px;"><i class="fa-solid fa-edit"></i></button>
                            <button wire:click="deleteMenuItem({{ $item->id }})" wire:confirm="Are you sure you want to delete this item?" class="btn" style="padding: 6px 12px; background: var(--danger); color: white;"><i class="fa-solid fa-trash"></i></button>
                        </td>
                    </tr>
                @endforeach
                @if(count($menuItems) == 0)
                    <tr>
                        <td colspan="4" style="padding: 20px; text-align: center; color: var(--text-muted);">{{ __('No menu items found.') }}</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>
</div>
