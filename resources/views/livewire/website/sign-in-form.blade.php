<form wire:submit.prevent="submit" class="auth-form ">
    @csrf

    <div>
        {{-- <input id="phone" wire:model="phone" required name="phone" class="w-full input-group phone-numb" id="phone_number"
            type="tel" placeholder="X XXX XXX">

        <input wire:model="phone_country_code"  type="hidden" name="phone_country_code" id="phone_country_code">
        <input wire:model="phone_number"  type="hidden" name="phone_number" id="full" > --}}

        @include('website.components.inputs.phone-number', [
            'id' => 'phone',
            'wireModel' => 'phone',
            'name' => 'phone',
            'type' => 'tel',
            'placeholder' => 'Enter your phone number',
            'wireModelCountryCode' => 'phone_country_code',
            'nameCountryCode' => 'phone_country_code',
            'idCountryCode' => 'country_code_id',
            'wireModelNumber' => 'phone_number',
            'nameNumber' => 'phone_number',
            'idNumber' => 'custom_full_id',
        ])

        @error('phone')
            <div class="form-error-message">{{ $message }}</div>
        @enderror
    </div>

    <div>
        @include('website.components.inputs.password', [
            'min' => 8,
            'name' => 'password',
            'model' => 'password',
            'placeholder' => 'Enter your password',
        ])
    </div>

    <div class="link-button">
        {{ __('messages.forgot_password') }} 
        <a href="{{ route('forgot-password', [
            'cinema_prefix' => $cinemaPrefix,
            'language_prefix' => $langPrefix,
        ]) }}">
            <span class="primary-color underline">{{ __('messages.reset') }}</span>
        </a>
    </div>
    
    <button type="submit" class="form-button mt-10">{{ __('messages.sign_in') }}</button>


</form>
