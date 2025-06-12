<div class="space-y-6">
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


            @if (!$coupon)
                <flux:button variant="primary" wire:click="createCoupon({{ $program->id }})">Create coupon</flux:button>
            @elseif (is_null($coupon->used_at))
                <flux:button variant="primary">Print</flux:button>
            @else
                <flux:badge color="lime">Taken</flux:badge>
            @endif
        </x-card>
        @endforeach
    </div>


</div>
