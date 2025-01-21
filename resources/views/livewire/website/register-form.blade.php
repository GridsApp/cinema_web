<form wire:submit.prevent="submit" class="auth-form" x-data>
    @csrf

    <div>
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

        @error('password')
            <div class="form-error-message">{{ $message }}</div>
        @enderror

    </div>

    <div>
    
        @include('website.components.inputs.password', [
            'min' => 8,
            'name' => 'confirm_password',
            'model' => 'confirm_password',
            'placeholder' => 'Enter your confirm password',
        ])
         @error('confirm_password')
         <div class="form-error-message">{{ $message }}</div>
     @enderror
    </div>

    <div class="unordered-list">
        <div class="text-[12px] text-gray-700">
            {{ __('messages.we_collect') }}
        </div>
        <ul class="list-disc pl-5 text-gray-700">
            <li>{{ __('messages.benefits.wallet') }}</li>
            <li>{{ __('messages.benefits.rewards') }}</li>
            <li>{{ __('messages.benefits.support') }}</li>
        </ul>
    </div>


    <div class="radio">
        <input id="radio-1" required name="agree" value="1" type="radio" wire:model="agree" />
        <label for="radio-1" class="radio-label">{{ __('messages.i_understand') }}</label>

        @error('agree')
            <div class="form-error-message">{{ $message }}</div>
        @enderror
    </div>

    <button type="submit" class="form-button">{{ __('messages.register') }}</button>

</form>
