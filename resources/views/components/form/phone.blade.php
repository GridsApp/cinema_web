<div x-data="GeneralFunctions.initPhoneField()">
    <input x-ref="phone"
    
    {{-- x-model="phone"   --}}

    name="{{ $name ?? 'phone' }}"
        class="{{ $class ?? 'w-full input-group phone-numb' }}" type="{{ $type ?? 'tel' }}"
        placeholder="{{ $placeholder ?? 'X XXX XXX' }}">

    {{-- <input wire:model="{{ $wireModelCountryCode ?? 'phone_country_code' }}" type="hidden"
        name="{{ $nameCountryCode ?? 'phone_country_code' }}" id="{{ $idCountryCode ?? 'phone_country_code' }}">
         --}}

    {{-- <input wire:model="{{ $wireModelNumber ?? 'phone_number' }}" type="hidden"
        name="{{ $nameNumber ?? 'phone_number' }}" id="{{ $idNumber ?? 'full' }}"> --}}
</div>
