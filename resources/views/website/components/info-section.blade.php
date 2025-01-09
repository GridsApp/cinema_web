<div class="px-4 sm:px-32 py-10 ">
    <div class="antialiased main-container flex flex-wrap justify-center gap-8 max-w-screen-xl mx-auto">
        @foreach ($statistics as $statistic)
        <div class="flex flex-col items-center text-center bg-white shadow-md rounded-lg p-6 w-64">
            <span 
                class="text-blue-600 font-extrabold text-4xl sm:text-5xl" 
                x-data="GeneralFunctions.animation()" 
                x-init="animate({{ $statistic['number'] }})" 
                x-text="counter">
            </span>
            <p class="uppercase text-gray-700 font-semibold tracking-wider text-sm sm:text-base mt-3">
                {{ $statistic['label'] }}
            </p>
        </div>
        @endforeach
    </div>
</div>
