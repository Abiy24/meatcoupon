<div class="space-y-6">
    <div>
        <flux:heading size="lg" level="1">Program</flux:heading>
        <flux:subheading level="1">Manage program.</flux:subheading>
    </div>

    <div>
        <flux:modal.trigger name="create-program">
            <flux:button>Create</flux:button>
        </flux:modal.trigger>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
        @foreach ($this->programs as $program)
            <x-card class="space-y-6">
                <flux:heading size="xl">{{ $program->name }}</flux:heading>
                <flux:subheading>{{ $program->description }}</flux:subheading>

                <div>
                    <flux:modal.trigger name="delete-program">
                        <flux:button variant="danger">Delete</flux:button>
                    </flux:modal.trigger>

                    <flux:modal name="delete-program" class="w-md max-w-[calc(100dvw-3rem)]">
                        <div class="space-y-6">
                            <div>
                                <flux:heading size="lg">Are you sure you want to delete this program?</flux:heading>

                                <flux:subheading>{{ $program->name }}</flux:subheading>
                            </div>

                            <div class="flex gap-2">
                                <flux:spacer />

                                <flux:modal.close>
                                    <flux:button variant="ghost">Cancel</flux:button>
                                </flux:modal.close>

                                <flux:button variant="danger" wire:click="deleteProgram({{ $program->id }})">Delete Program</flux:button>
                            </div>
                        </div>
                    </flux:modal>
                </div>


            </x-card>
        @endforeach
    </div>





    <flux:modal name="create-program" class="w-md max-w-[calc(100dvw-3rem)]">
        <form wire:submit="createProgram" class="space-y-6">
            <div>
                <flux:heading size="lg">Create program</flux:heading>
                <flux:text class="mt-2">Create new program.</flux:text>
            </div>

            <flux:input wire:model="name" label="Name" placeholder="Name" />

            <flux:textarea wire:model="description" label="Description" placeholder="Description" />

            <div class="flex">
                <flux:spacer />

                <flux:button type="submit" variant="primary">Save</flux:button>
            </div>
        </form>
    </flux:modal>

</div>
