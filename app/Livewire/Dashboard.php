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
    //$key: holds the encrypted string to decrypt.
    public string $key = '';
    //$result: stores the decrypted outcome or an error message.
    public string $result = '';
    //$is_valid: indicates if the coupon is validated. initial value = false
    public $is_valid = false;
    public function decrypt()
    {
        //Attempts to decrypt $this->key using Laravel’s Crypt::decryptString()
        try {
            $decrypted = Crypt::decryptString($this->key);
            $this->result = $decrypted;
            //Parsing decrypted data, Splits the decrypted string into three parts.
            [$userId, $programId, $code] = explode('-', $decrypted, 3);
            //Searches for a matching Coupon record in the database.
            $coupon = Coupon::where('user_id', $userId)
                ->where('program_id', $programId)
                ->where('code', $code)
                ->first();
            //If the coupon exists but was already redeemed (used_at is set),
            //it marks it invalid and returns an explanatory message.
            if ($coupon->used_at!==null) {
                $this->is_valid = false;
                $this->result = 'Used code.';
                return;
            }
            //If coupon exists and hasn’t been used, it's now marked as used (with timestamp),
            //and $is_valid is set to true.
            if ($coupon) {
                $coupon->used_at = now();
                $coupon->save();
                $this->is_valid = true;
                return;
            }
        //Catches any decryption failure or missing data, marks coupon invalid, and updates $result.
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
