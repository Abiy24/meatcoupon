<?php

namespace App\Livewire\Admin;

use App\Models\User as ModelUser;
use Livewire\Component;
use Livewire\Attributes\Computed;

class User extends Component
{
    #[Computed]
    public function users()
    {
        return ModelUser::all();
    }

    public function toggleValidate(ModelUser $user)
    {
        ModelUser::where('id', $user->id)->update([
            'is_valid' => ! $user->is_valid,
        ]);
    }

    public function render()
    {
        return view('livewire.admin.user');
    }
}
