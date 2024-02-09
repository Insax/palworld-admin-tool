<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Add RCON Connection') }}
        </h2>

    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="relative overflow-x-auto">
                        <form wire:submit.prevent="addRcon">
                            <!-- IP -->
                            <div>
                                <x-input-label for="ip" :value="__('IP/Host')" />
                                <x-text-input wire:model="ip" id="ip" class="block mt-1 w-full" type="text" name="ip" required autofocus autocomplete="ip" />
                                <x-input-error :messages="$errors->get('ip')" class="mt-2" />
                            </div>

                            <!-- Port -->
                            <div>
                                <x-input-label for="port" :value="__('Port')" />
                                <x-text-input wire:model="port" id="port" class="block mt-1 w-full" type="number" name="port" required autofocus autocomplete="port" />
                                <x-input-error :messages="$errors->get('port')" class="mt-2" />
                            </div>

                            <!-- Password -->
                            <div>
                                <x-input-label for="password" :value="__('Password')" />
                                <x-text-input wire:model="password" id="password" class="block mt-1 w-full" type="text" name="password" required autofocus autocomplete="password" />
                                <x-input-error :messages="$errors->get('password')" class="mt-2" />
                            </div>

                            <x-primary-button type="button" class="mt-4 ml-0" wire:click.prevent="testConnection">
                                {{ __('Test Connection') }}
                            </x-primary-button>

                            <!-- Add Server -->
                            <div class="mt-4 flex justify-start">
                                <x-input-label for="quickServer" :value="__('Quick Create Server')" />
                                <x-form-components::choice.checkbox wire:model="quickServer" class="flex ml-4 rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-indigo-600 shadow-sm focus:ring-indigo-500 dark:focus:ring-indigo-600 dark:focus:ring-offset-gray-800"></x-form-components::choice.checkbox>
                            </div>

                            <div class="flex items-center justify-end mt-4">
                                @if($testSuccessful)
                                    <x-primary-button class="ms-4">
                                        {{ __('Add Rcon') }}
                                    </x-primary-button>
                                @else
                                    <x-primary-button class="ms-4" disabled>
                                        {{ __('Please Test the connection first') }}
                                    </x-primary-button>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
