<div class="space-y-6">
    @if (!auth()->user()->is_valid)
        <flux:callout>
            <flux:callout.heading icon="user">Akun Anda Belum Tervalidasi</flux:callout.heading>

            <flux:callout.text>Segera hubungi Admin untuk memvalidasi Akun anda.
            </flux:callout.text>
        </flux:callout>
    @else
        <flux:heading size="lg" level="1">Your coupon!</flux:heading>

        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
            @foreach ($this->programs as $program)
                <x-card class="space-y-6">
                    @php
                        $coupon = auth()->user()->coupons->firstWhere('program_id', $program->id);
                    @endphp

                    <flux:heading size="xl">
                        {{ $program->name }}
                    </flux:heading>

                    <flux:subheading>
                        {{ $program->description }}
                    </flux:subheading>

                    @if ($coupon && $coupon->qr_code)
                        <img src="{{ $coupon->qr_code }}" alt="{{ $coupon->code }}"
                            class="size-72 rounded-lg opacity-65 aspect-square">
                    @endif

                    @if (!$coupon || empty($coupon->code))
                        <flux:button variant="primary" wire:click="createCoupon({{ $program->id }})">Create coupon
                        </flux:button>
                    @elseif (is_null($coupon->used_at))
                        <flux:button variant="primary">Print</flux:button>
                    @else
                        <flux:badge color="lime">Taken</flux:badge>
                    @endif
                </x-card>
            @endforeach
        </div>
        @if (auth()->user()->is_admin)
            <div>
            <div wire:ignore x-data="{
                scanner: null,
                init() {
                    this.scanner = new Html5Qrcode('qr-reader');
                    this.start();
                },
                start() {
                    Html5Qrcode.getCameras().then(devices => {
                        if (devices.length) {
                            this.scanner.start({ facingMode: 'environment' }, {
                                    fps: 10,
                                    qrbox: { width: 250, height: 250 }
                                },
                                qrCodeMessage => {
                                    $wire.set('key', qrCodeMessage);
                                    $wire.decrypt();
                                    // this.stop();
                                },
                                errorMessage => {
                                    // Optional: handle scan error
                                }
                            );
                        }
                    });
                },
                stop() {
                    this.scanner.stop();
                }
            }" x-init="init" class="aspect-auto">
                <div id="qr-reader"></div>
            </div>

            <div class="space-y-6">
                <flux:heading size="xl">Decrypt</flux:heading>
                <form wire:submit="decrypt" class="space-y-6">
                    <flux:input wire:model="key" />
                    <flux:button type="submit">Submit</flux:button>
                </form>
                <flux:input wire:model="result" readonly />
                @if ($this->is_valid)
                    <flux:badge icon="check" color="green">Valid</flux:badge>
                @else
                    <flux:badge icon="x-mark" color="red">Not Valid</flux:badge>
                @endif
            </div>
        </div>
        @endif
    @endif
</div>
