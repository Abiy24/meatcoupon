<?php

namespace App\Livewire;

use App\Models\Coupon;
use App\Models\Program;
use Livewire\Component;
use Illuminate\Support\Str;
use Livewire\Attributes\Title;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Computed;
use Illuminate\Support\Facades\Auth;

class Dashboard extends Component
{

    #[Computed]
    public function programs()
    {
        return Program::get();
    }

    public function createCoupon(Program $program)
    {
        if (Auth::user()->coupons()->where('program_id', $program->id)->exists()) {
            return;
        }

        Coupon::create([
            'user_id' => Auth::id(),
            'program_id' => $program->id,
            'code' => Str::random(10),
            'qr_code' => null,
            'used_at' => null,
        ]);
    }

    #[Layout('components.layouts.app')]
    #[Title('Dashboard')]
    public function render()
    {
        return view('livewire.dashboard');
    }
}
