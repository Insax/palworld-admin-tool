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
        <btn wire:loading.attr="disabled" wire:click="install" class="mt-10 flex text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800 text-center justify-center">Install</btn>
    @endif
</div>
