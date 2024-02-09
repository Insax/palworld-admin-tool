<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Whitelist of Server ').$serverName }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div wire:poll.30s class="relative overflow-x-auto">
                        <div class="flex justify-between">
                            <a href="{{ route('server-dashboard', ['id' => $id]) }}" class="mb-4 items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150 flex self-end">Back to Server Dashboard</a>
                        </div>
                        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">
                                    Username
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    ID
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Steam64 ID
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Online
                                </th>
                                <th scope="col" class="px-6 py-3 flex justify-center">
                                    Actions
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($players as $player)
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ $player->name }}
                                    </th>
                                    <td class="px-6 py-4">
                                        {{ $player->player_id }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $player->steam_id }}
                                    </td>
                                    <td class="px-6 py-4">
                                        @if($player->online)
                                            <span class="flex w-3 h-3 ml-3 me-3 bg-green-500 rounded-full"></span>
                                        @else
                                            <span class="flex w-3 h-3 ml-3 me-3 bg-red-500 rounded-full"></span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <div class="flex justify-center">
                                            <x-danger-button wire:click="removePlayer({{ $player->player_id }})">
                                                Remove
                                            </x-danger-button>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        &nbsp;
                                    </th>
                                    <td class="px-6 py-4">
                                        <div>
                                            <x-text-input placeholder="ID" wire:model="newPlayerId" id="name" class="mt-1 w-48" type="text" name="player_id" required autofocus autocomplete="name" />
                                        </div>
                                    </td>
                                    <td class="px-6 py-4">
                                        &nbsp;
                                    </td>
                                    <td class="px-6 py-4">
                                        &nbsp;
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        <div class="flex justify-center">
                                            <x-secondary-button wire:click="addPlayer">
                                                Add
                                            </x-secondary-button>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>

    @if(!$unkWhitelist->empty())
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <div class="relative overflow-x-auto">
                            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight mb-4">
                                {{ __('In Whitelist but not found as player on Server ').$serverName }}
                            </h2>
                            <div class="w-full dark:bg-gray-900 rounded-2xl">
                                <div class="m-2 p-3">
                                    @foreach($unkWhitelist as $unk)
                                        <p class="font-mono text-sm">
                                            <p> {{ $unk }} </p>
                                        </p>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
