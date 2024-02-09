<div>
    <h1 class="text-2xl text-center text-white">System Checks</h1>
    <hr class="text-white my-4">
    @if($isPHPVersionOK)
        <p class="text-white text-nowrap whitespace-nowrap flex flex-nowrap justify-between">
            <span class="dark:text-green-400 inline-flex">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                    stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                </svg>
                <span class="ml-3"> OK </span>
            </span>
            <span class="text-white">
                PHP Version 8.1 ({{ $phpVersion }})
            </span>
        </p>
    @else
        <p class="text-white text-nowrap whitespace-nowrap flex flex-nowrap justify-between">
            <span class="dark:text-red-400 inline-flex">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m9.75 9.75 4.5 4.5m0-4.5-4.5 4.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
                <span class="ml-3"> NOK </span>
            </span>
            <span class="text-white">
                PHP Version 8.3 ({{ $phpVersion }})
            </span>
        </p>
    @endif
    @foreach($extensionChecks as $ext => $value)
        @if($value)
            <p class="text-white text-nowrap whitespace-nowrap flex flex-nowrap justify-between">
            <span class="dark:text-green-400 inline-flex">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                     stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                </svg>
                <span class="ml-3"> OK </span>
            </span>
                <span class="text-white">
                    <a class="text underline hover:no-underline dark:text-gray-400" href="https://www.php.net/manual/en/book.{{$ext}}.php">PHP Extension <span class="uppercase">{{$ext}}</span> </a>
            </span>
            </p>
        @else
            <p class="text-white text-nowrap whitespace-nowrap flex flex-nowrap justify-between">
            <span class="dark:text-red-400 inline-flex">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m9.75 9.75 4.5 4.5m0-4.5-4.5 4.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
                <span class="ml-3"> NOK </span>
            </span>
                <span class="text-white">
                <a class="text underline hover:no-underline dark:text-gray-400" href="https://www.php.net/manual/en/book.{{$ext}}.php">PHP Extension <span class="uppercase">{{$ext}}</span> </a> NOT LOADED
            </span>
            </p>
        @endif
    @endforeach
    @if($isDBConfigured)
        <p class="text-white text-nowrap whitespace-nowrap flex flex-nowrap justify-between">
            <span class="dark:text-green-400 inline-flex">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                     stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"/>
                </svg>
                <span class="ml-3"> OK </span>
            </span>
            <span class="text-white">
                    Database Connection Configured
            </span>
        </p>
    @else
        <p class="text-white text-nowrap whitespace-nowrap flex flex-nowrap justify-between">
            <span class="dark:text-red-400 inline-flex">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m9.75 9.75 4.5 4.5m0-4.5-4.5 4.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                </svg>
                <span class="ml-3"> NOK </span>
            </span>
            <span class="text-white">
                {{ $dbError }}
            </span>
        </p>
    @endif
    @if(!$noStartInstallation)
        <x-primary-button type="button" wire:loading.attr="disabled" wire:click.prevent class="mb-4 flex text-center justify-center" wire:click="install">Install</x-primary-button>
    @endif
</div>
