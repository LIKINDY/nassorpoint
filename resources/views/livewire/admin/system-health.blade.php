<div>
    <div class="d-flex justify-between align-center mb-4" style="margin-bottom: 20px;">
        <h3><i class="fa-solid fa-heart-pulse" style="color: var(--primary-green);"></i> System Health</h3>
    </div>

    <div style="background: white; border-radius: var(--radius-lg); box-shadow: var(--shadow-sm); padding: 20px; margin-bottom: 20px;">
        <h4 style="margin-bottom: 16px;">Maintenance Mode</h4>
        <p style="color: var(--text-muted); margin-bottom: 16px;">When maintenance mode is active, regular users cannot access the site. As an admin, you can bypass it.</p>
        
        <button class="btn" style="background: {{ $isDown ? 'var(--primary-green)' : 'var(--danger)' }}; color: white;" wire:click="toggleMaintenance">
            <i class="fa-solid fa-power-off"></i> {{ $isDown ? 'Bring Site Online' : 'Put Site in Maintenance' }}
        </button>

        @if($isDown)
            <div style="margin-top: 16px; background: #FEF3C7; color: #92400E; padding: 12px; border-radius: var(--radius-md);">
                <strong>Maintenance is ACTIVE.</strong> Bypass URL: <code>/admin-bypass</code>
            </div>
        @endif
    </div>

    <div style="background: white; border-radius: var(--radius-lg); box-shadow: var(--shadow-sm); padding: 20px;">
        <h4 style="margin-bottom: 16px;">System Information</h4>
        <ul style="list-style: none; color: var(--text-muted);">
            <li style="margin-bottom: 8px;"><strong>PHP Version:</strong> {{ phpversion() }}</li>
            <li style="margin-bottom: 8px;"><strong>Laravel Version:</strong> {{ app()->version() }}</li>
            <li style="margin-bottom: 8px;"><strong>Environment:</strong> {{ app()->environment() }}</li>
        </ul>
    </div>
</div>
