<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use Illuminate\Support\Facades\Artisan;

class SystemHealth extends Component
{
    public $isDown = false;

    public function mount()
    {
        $this->isDown = file_exists(storage_path('framework/down'));
    }

    public function toggleMaintenance()
    {
        if ($this->isDown) {
            Artisan::call('up');
            $this->isDown = false;
        } else {
            // Need a secret to bypass maintenance if we are the admin triggering it
            Artisan::call('down', ['--secret' => 'admin-bypass']);
            $this->isDown = true;
        }
    }

    public function render()
    {
        return view('livewire.admin.system-health');
    }
}
