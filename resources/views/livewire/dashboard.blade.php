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

            @if ($coupon && $coupon->qr_code)
                <img src="{{ $coupon->qr_code }}" alt="{{ $coupon->code }}" class="size-80 rounded-lg aspect-square">
            @endif

            @if (!$coupon || empty($coupon->code))
                <flux:button variant="primary" wire:click="createCoupon({{ $program->id }})">Create coupon</flux:button>
            @elseif (is_null($coupon->used_at))
                <flux:button variant="primary">Print</flux:button>
            @else
                <flux:badge color="lime">Taken</flux:badge>
            @endif



        </x-card>
        @endforeach
    </div>

    <div class="space-y-6">
        <flux:heading size="xl">Decrypt</flux:heading>
        <form wire:submit="decrypt" class="space-y-6">
            <flux:input wire:model="key"/>
            <flux:button type="submit">Submit</flux:button>
        </form>
        <flux:input wire:model="result" readonly/>
        @if ($this->is_valid)
            <flux:badge icon="check" color="green">Valid</flux:badge>
        @else
            <flux:badge icon="x-mark" color="red">Not Valid</flux:badge>
        @endif
    </div>




</div>
