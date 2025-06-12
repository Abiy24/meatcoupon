<?php

namespace App\Livewire\Admin;

use Livewire\Component;
use App\Models\Program as ModelProgram;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Validate;

class Program extends Component
{
    #[Validate('required|string|max:255')]
    public string $name;
    #[Validate('required|string|max:255')]
    public string $description;

    #[Computed]
    public function programs()
    {
        return ModelProgram::all();
    }

    public function createProgram()
    {
        $this->validate();
        ModelProgram::create([
            'name' => $this->name,
            'description' => $this->description,
        ]);
        $this->resetErrorBag();
        $this->reset([
            'name',
            'description',
        ]);
        $this->modal('create-program')->close();
    }

    public function render()
    {
        return view('livewire.admin.program');
    }
}
