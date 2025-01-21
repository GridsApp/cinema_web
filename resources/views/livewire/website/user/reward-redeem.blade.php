

<div>
    @if (session()->has('message'))
        <div class="alert alert-info">
            {{ session('message') }}
        </div>
    @endif

    <button wire:click="redeem" 
            class="text-[12px] tracking-[1.5px] font-bold px-10 py-2 rounded-full uppercase text-white 
            {{ $reward['remaining_points'] == 0 ? 'bg-primary-color' : 'bg-[#707070]' }}"
            @if ($reward['remaining_points'] != 0) disabled @endif>
        Redeem
    </button>
</div>
