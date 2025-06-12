<div class="space-y-6">
    <flux:heading size="xl" level="1">Selamat datang, {{ auth()->user()->name }}.</flux:heading>
    {{-- @if (auth()->user()->coupons->count() === 0 )
        <flux:text class="mt-2 mb-6 text-base">Segera buat kupon.</flux:text>
    @else
        <flux:text class="mt-2 mb-6 text-base">Kupon bisa digunakan pada tanggal 13 - 06 - 2025</flux:text>
    @endif --}}

    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
        @foreach ($this->programs as $program)
        <x-card class="space-y-6">
            <flux:heading size="xl">
                {{ $program->name }}
            </flux:heading>

            <flux:subheading>
                {{ $program->description }}
            </flux:subheading>

            @php
                $coupon = auth()->user()->coupons
                    ->firstWhere('program_id', $program->id);
            @endphp

            @if (!$coupon)
                <flux:button variant="primary" wire:click="createCoupon({{ $program->id }})">Create coupon</flux:button>
            @elseif (is_null($coupon->used_at))
                <flux:button variant="primary">Print</flux:button>
            @endif
        </x-card>
        @endforeach
    </div>


</div>
