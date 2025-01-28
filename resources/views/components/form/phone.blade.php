{{-- <div x-data="GeneralFunctions.initPhoneField()">
    <input x-ref="phone"
    
    x-model="phone"  

    name="{{ $name ?? 'phone' }}"
        class="{{ $class ?? 'w-full input-group phone-numb' }}"
         type="{{ $type ?? 'tel' }}"
        placeholder="{{ $placeholder ?? 'X XXX XXX' }}">
        <input type="hidden" wire:model="value" />
    
</div> --}}
<div x-data="GeneralFunctions.initPhoneField()" x-init="init()" wire:ignore>
    <input
        type="tel"
        x-ref="phone"
        x-model="phone"
        wire:model="value" 
        class="input-group"

    />

</div>
