<form wire:submit.prevent="submit" class="auth-form ">
    @csrf

   <div class="flex flex-col gap-4">
    <div>


        <livewire:components.phone wire:model="phone" />


        {{-- @include('website.components.inputs.phone-number', [
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
        @enderror --}}
    </div>

    <div>
        @include('website.components.inputs.password', [
            'min' => 8,
            'name' => 'password',
            'model' => 'password',
            'placeholder' => 'Enter your password',
        ])
    </div>
   </div>

    <div>
        <div class="link-button ">
            {{ __('messages.forgot_password') }}
            <a
                href="{{ route('forgot-password', [
                    'cinema_prefix' => $cinemaPrefix,
                    'language_prefix' => $langPrefix,
                ]) }}">
                <span class="primary-color underline">{{ __('messages.reset') }}</span>
            </a>
        </div>
        <div class="pt-4">
            <button type="submit" class="form-button w-full ">{{ __('messages.sign_in') }}</button>
        </div>



    </div>
</form>
