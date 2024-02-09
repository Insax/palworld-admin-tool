<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Player Overview of Server ').$serverName }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div wire:poll.30s class="relative overflow-hidden">
                        <div class="flex justify-between">
                            @if(\App\Models\Server::find($id)->shutting_down)
                                <x-primary-button type="button"  disabled wire:click.prevent class="mb-4 flex self-end">Shutdown in Progress</x-primary-button>
                            @elseif(!\App\Models\Server::find($id)->online)
                                <x-primary-button type="button"  disabled wire:click.prevent class="mb-4 flex self-end">Server Offline</x-primary-button>
                            @else
                                <x-primary-button type="button" wire:click.prevent class="mb-4 flex self-end" wire:click="shutdownServer">Restart Server</x-primary-button>
                            @endif
                            <a href="{{ route('edit-whitelist', ['id' => $id]) }}" class="mb-4 inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150 flex self-end">
                                @if(\App\Models\Server::find($id)->uses_whitelist)
                                    Edit Whitelist
                                @else
                                    Prepare Whitelist
                                @endif
                            </a>
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
                                        @if($player->online)
                                            <div class="flex justify-center">
                                                <button wire:click="kickPlayer({{ $player }})" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded m-2">
                                                    Kick
                                                </button>
                                                <button wire:click="banPlayer({{ $player }})" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded m-2">
                                                    Ban
                                                </button>
                                            </div>
                                        @else
                                            Player Offline!
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div wire:poll.30s="buildPlayerList" class="relative overflow-x-auto">
                        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight mb-4">
                            {{ __('Join/Leave log of Server ').$serverName }}
                        </h2>
                        <div class="w-full dark:bg-gray-900 rounded-2xl">
                            <div wire:poll.5s="buildJoinLeaveLog" class="m-2 p-3 overflow-auto h-[40vh]">
                                @foreach($joinLeaveLog as $log)
                                    <p class="font-mono text-sm"
                                       x-data="
                                        {
                                            created_at: '',
                                            convertToLocalTime(time) {
                                                var utcTime = moment.utc(time);
                                                var localTime = moment(utcTime).local();
                                                return localTime.format('YYYY-MM-DD HH:mm:ss');
                                            }
                                        }"
                                        x-init="created_at = convertToLocalTime('{{$log->created_at->format('c')}}')">
                                        <span class="dark:text-orange-300 text-orange-300" x-text="created_at"></span> Player
                                        <span class="dark:text-blue-400 text-blue-400">{{ $log->player->name.'('.$log->player->player_id.'/'.$log->player->steam_id.')' }}</span>
                                        @if($log->action == 'JOIN')
                                            <span class="dark:text-green-400 text-green-400">joined</span>
                                        @elseif($log->action == 'LEFT')
                                            <span class="dark:text-red-400 text-red-400">left</span>
                                        @elseif($log->action == 'KICKWL')
                                            <span class="dark:text-red-400 text-red-400">was kicked by the automatic Whitelist <span class="text-white">from</span></span>
                                        @elseif($log->action == 'KICKUSR')
                                            <span class="dark:text-red-400 text-red-400">was kicked by a User <span class="text-white">from</span></span>
                                        @elseif($log->action == 'BANUSR')
                                            <span class="dark:text-red-400 text-red-400">was banned by a User <span class="text-white"> from</span></span>
                                        @endif
                                        the Server.
                                    </p>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
