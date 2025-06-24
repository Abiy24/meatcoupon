<div>
                <div class="overflow-hidden">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-neutral-700">
                    <thead>
                        <tr>
                            <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-neutral-500">Name</th>
                            <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-neutral-500">Email</th>
                            <th scope="col" class="px-6 py-3 text-start text-xs font-medium text-gray-500 uppercase dark:text-neutral-500">Created At</th>
                            <th scope="col" class="px-6 py-3 text-end text-xs font-medium text-gray-500 uppercase dark:text-neutral-500">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 dark:divide-neutral-700">
                        @foreach ($this->users as $user)
                            <tr class="hover:bg-gray-100 dark:hover:bg-neutral-700">
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-800 dark:text-neutral-200">
                                    {{ $user->name }}
                                    @if ($user->is_valid)
                                        <flux:badge size="sm" color="lime" class="ml-2">Valid</flux:badge>
                                    @else
                                        <flux:badge size="sm" color="red" class="ml-2">Not Valid</flux:badge>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-neutral-200">{{ $user->email }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-800 dark:text-neutral-200">{{ $user->created_at->diffForHumans() }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-end text-sm font-medium">
                                    @if ($user->is_valid)
                                        <flux:button wire:click="toggleValidate({{ $user }})" variant="danger" size="xs">Unvalidate</flux:button>
                                    @else
                                        <flux:button wire:click="toggleValidate({{ $user }})" variant="primary" size="xs">Validate</flux:button>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
</div>
