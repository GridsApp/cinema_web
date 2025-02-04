<div x-data="{
    quantity: @entangle('quantity')
}"
    class="twa-cart-quantity flex items-center justify-between border border-gray-300 rounded-full">

    <button type="button" class="px-3 py-1 text-[20px] primary-color font-bold rounded-l-md"
        @click="quantity > 0 ? quantity-- : quantity" wire:click="removeItemFromCart({{ $item['id'] }})">
        −
    </button>

    <input type="number" x-model="quantity" class="w-12 text-center font-bold border-x border-transparent outline-none"
        min="0">



    <button type="button" class="px-3 py-1 text-[20px] primary-color font-bold rounded-r-md" @click="quantity++"
        wire:click="addItemToCart({{ $item['id'] }})">
        +
    </button>
</div>
