<div>
    <flux:heading size="xl" level="1">Selamat datang, {{ auth()->user()->name }}.</flux:heading>
    @if (auth()->user()->coupons->count() === 0 )
        <flux:text class="mt-2 mb-6 text-base">Segera buat kupon.</flux:text>
    @else
        <flux:text class="mt-2 mb-6 text-base">Kupon bisa digunakan pada tanggal 13 - 06 - 2025</flux:text>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        @foreach ($this->programs as $program)
        <x-card class="space-y-6">
            <flux:heading size="xl">
                {{ $program->name }}
            </flux:heading>
            <flux:subheading>
                {{ $program->description }}
            </flux:subheading>

            <flux:button variant="primary">Create Coupon</flux:button>
        </x-card>
        @endforeach
    </div>


</div>
