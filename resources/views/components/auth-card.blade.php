<main class="flex flex-col items-center flex-1 px-4 pt-6 sm:justify-center">
    <div>
        <a href="/">
            <img src="{{ asset('img/logo/logo FG-bg rojo.png') }}" style="width: 350px" alt="">
           {{-- <img src="{{ asset('img/logo/xmas-logo.png') }}" style="width: 250px" alt="">--}}
        </a>
    </div>

    <div class="w-full px-6 py-4 my-6 overflow-hidden bg-white rounded-md shadow-lg sm:max-w-md dark:bg-dark-eval-1">
        {{ $slot }}
    </div>
</main>