<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('User Overview') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">


                    <div wire:poll.30s class="relative overflow-x-auto">
                        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">
                                    ID
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Name
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    E-Mail
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Roles
                                </th>
                                <th scope="col" class="px-6 py-3 flex justify-center">
                                    Actions
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($users as $user)
                                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ $user->id }}
                                    </th>
                                    <td class="px-6 py-4">
                                        {{ $user->name }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $user->email }}
                                    </td>
                                    <td class="px-6 py-4">
                                        @foreach($user->getRoleNames() as $role)
                                            {{ $role }}
                                        @endforeach
                                        @if($user->getRoleNames()->count() == 0)
                                            {{ __('This user has no roles')  }}
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        @if(Auth::id() == $user->id)
                                            You cannot edit yourself.
                                        @else
                                            @if($user->hasRole('Super Admin'))
                                                You cannot edit a Super Admin
                                            @else
                                            <div class="flex justify-center">
                                                <button class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded m-2">
                                                    Edit
                                                </button>
                                                <button class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded m-2">
                                                    Ban
                                                </button>
                                            </div>
                                            @endif
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
</div>
