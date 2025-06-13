<?php

namespace App\Livewire;

use App\Models\Coupon;
use App\Models\Program;
use BaconQrCode\Renderer\Image\ImagickImageBackEnd;
use BaconQrCode\Renderer\ImageRenderer;
use BaconQrCode\Renderer\RendererStyle\RendererStyle;
use BaconQrCode\Writer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

class Dashboard extends Component
{
    public string $key = '';

    public string $result = '';

    public $is_valid = false;

    public function decrypt()
    {
        try {
            $decrypted = Crypt::decryptString($this->key);
            $this->result = $decrypted;

            [$userId, $programId, $code] = explode('-', $decrypted, 3);

            $coupon = Coupon::where('user_id', $userId)
                ->where('program_id', $programId)
                ->where('code', $code)
                ->first();

            if ($coupon) {
                $coupon->used_at = now();
                $coupon->save();
                $this->is_valid = true;
            }
        } catch (\Exception $e) {
            $this->result = 'Invalid or tampered code.';
            $this->is_valid = false;
        }
    }

    #[Computed]
    public function programs()
    {
        return Program::all();
    }

    public function createCoupon(Program $program)
    {
        $user = Auth::user();

        $coupon = $user->coupons()->where('program_id', $program->id)->first();

        // Skip if coupon exists and has QR code
        if ($coupon && $coupon->qr_code !== null) {
            return;
        }

        // Create new coupon if doesn't exist
        if (! $coupon) {
            $randomCode = Str::random(10);

            $coupon = Coupon::create([
                'user_id' => $user->id,
                'program_id' => $program->id,
                'code' => $randomCode,
                'encrypted_code' => Crypt::encryptString("{$user->id}-{$program->id}-{$randomCode}"),
                'qr_code' => null,
                'used_at' => null,
            ]);
        }

        // Generate QR code from encrypted_code
        $renderer = new ImageRenderer(
            new RendererStyle(400),
            new ImagickImageBackEnd
        );

        $writer = new Writer($renderer);
        $qrBinary = $writer->writeString($coupon->encrypted_code);
        $qrBase64 = 'data:image/png;base64,'.base64_encode($qrBinary);

        // Save QR code to coupon
        $coupon->qr_code = $qrBase64;
        $coupon->save();
    }

    #[Layout('components.layouts.app')]
    #[Title('Dashboard')]
    public function render()
    {
        return view('livewire.dashboard');
    }
}
