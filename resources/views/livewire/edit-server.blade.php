<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Edit Server {{ $server->name }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="relative overflow-x-auto">
                        <form wire:submit="updateServer">
                            <!-- Name -->
                            <div>
                                <x-input-label for="name" :value="__('Name')" />
                                <x-text-input :value="$name" wire:model="name" id="name" class="block mt-1 w-full" type="text" name="name" required autofocus autocomplete="name" />
                                <x-input-error :messages="$errors->get('name')" class="mt-2" />
                            </div>

                            <!-- RCON Address -->
                            <div class="mt-4">
                                <x-input-label for="rcon" :value="__('RCON')" />
                                <x-select
                                    name="rcon"
                                    id="rcon"
                                    :value="$rcon"
                                    wire:model="rcon"
                                    :options="$availableRCON"
                                    value-field="value"
                                    label-field="text"
                                    class="block mt-1 w-full border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm"
                                    required
                                    placeholder="Choose..."
                                >
                                    <option value="" default disabled>Please choose..</option>
                                </x-select>
                                <x-input-error :messages="$errors->get('rcon')" class="mt-2" />
                            </div>

                            <!-- Whitelisting -->
                            <div class="mt-4 flex justify-start">
                                <x-input-label for="whitelist" :value="__('Activate Whitelist Feature')" />
                                <x-form-components::choice.checkbox wire:model="uses_whitelist" :value="$uses_whitelist" class="flex ml-4 rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800"></x-form-components::choice.checkbox>
                            </div>

                            <div class="flex items-center justify-end mt-4">
                                <x-primary-button class="ms-4">
                                    {{ __('Edit Server') }}
                                </x-primary-button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
