<div class="main-container ">
    <div class="antialiased main-container flex flex-wrap justify-between sm:gap-8 gap-4">
        @foreach ($statistics as $statistic)
        <div class="flex flex-col items-center text-center  sm:w-52 w-32">
            <span 
                class="primary-color font-extrabold text-[19px] sm:text-5xl" 
                x-data="GeneralFunctions.animation()" 
                x-init="animate({{ $statistic['number'] ?? ''}})" 
                x-text="'+' + counter">
                +
            </span>
            <p class="uppercase  font-bold tracking-[1.5px] sm:text-[12px] sm:rtl:text-[14px] text-[10px]  mt-3">
                {{ $statistic['label'] ?? '' }}
            </p>
        </div>
        @endforeach
    </div>
</div>
