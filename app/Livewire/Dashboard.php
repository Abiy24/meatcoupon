<?php

namespace App\Livewire;

use App\Models\Program;
use Livewire\Component;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Computed;

class Dashboard extends Component
{

    #[Computed]
    public function programs()
    {
        return Program::get();
    }

    #[Layout('components.layouts.app')]
    #[Title('Dashboard')]
    public function render()
    {
        return view('livewire.dashboard');
    }
}
