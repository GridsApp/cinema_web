<div class="px-32" x-data="GeneralFunctions.animation()">
    <div class="antialiased main-container flex justify-between">
        <div class="flex flex-col items-center text-center">
            <span class="primary-color tracking-[2px] font-bold text-[35px]" x-data="animation()"
                x-init="animate(400)" x-text="`${counter}+`">
                0
            </span>
            <p class="uppercase tracking-[2.4px] font-bold text-[14px] leading-[20px]">Videos</p>
        </div>
        <div class="flex flex-col items-center text-center">
            <span class="primary-color tracking-[2px] font-bold text-[35px]" x-data="animation()"
                x-init="animate(9400)" x-text="`${counter}+`">
                0
            </span>
            <p class="uppercase tracking-[2.4px] font-bold text-[14px] leading-[20px]">Subscribers</p>
        </div>
        <div class="flex flex-col items-center text-center">
            <span class="primary-color tracking-[2px] font-bold text-[35px]" x-data="animation()"
                x-init="animate(11024)" x-text="`${counter}+`">
                0
            </span>
            <p class="uppercase tracking-[2.4px] font-bold text-[14px] leading-[20px]">Likes</p>
        </div>
    </div>

</div>
