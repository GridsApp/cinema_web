<div class="sm:col-span-8 col-span-12 right">
    <div class="pb-5">
        @include('website.components.title', ['title' => __('messages.personal_information')])

    </div>
    <form wire:submit.prevent="updateProfile" class="grid sm:grid-cols-2 grid-cols-1 gap-6">
        <div>
            <input class="input-group" type="text" id="name" wire:model.defer="name" placeholder="Full Name" />
        </div>
        <div class="sm:block hidden"></div>
        <div>
            <input class="input-group" type="email" id="email" wire:model.defer="email" placeholder="Email" />
            @error('email')
                <div class="form-error-message">{{ $message }}</div>
            @enderror
        </div>


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
        </div>

        <div>
            <button class="form-button" type="submit">{{ __('tables.save_changes') }}</button>


        </div>
    </form>


    <form wire:submit.prevent="changePassword" class="pt-10">
        <div class="pb-5">
            @include('website.components.title', ['title' => __('messages.change_password')])
        </div>
        <div class="grid sm:grid-cols-2 grid-cols-1 gap-7">
            <div>
                {{-- <input type="password" class="input-group" wire:model.defer="current_password"
                    placeholder="Current Password" /> --}}
                @include('website.components.inputs.password', [
                    'min' => 8,
                    'name' => 'current_password',
                    'model' => 'current_password',
                    'placeholder' => 'Enter your current password',
                ])

            </div>
            @error('current_password')
                <span class="error">{{ $message }}</span>
            @enderror
            <div class="sm:block hidden"></div>
            <div>
                @include('website.components.inputs.password', [
                    'min' => 8,
                    'name' => 'password',
                    'model' => 'password',
                    'placeholder' => 'Enter your password',
                ])
                @error('password')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>
            <div>
                {{-- <input type="password" class="input-group" wire:model.defer="confirm_password"
                        placeholder="Confirm Password" /> --}}

                @include('website.components.inputs.password', [
                    'min' => 8,
                    'name' => 'confirm_password',
                    'model' => 'confirm_password',
                    'placeholder' => 'Enter your confirm password',
                ])
                @error('confirm_password')
                    <span class="error">{{ $message }}</span>
                @enderror
            </div>

            <div>
                <button type="submit" class="form-button">{{ __('tables.change_password') }}</button>
            </div>
        </div>

    </form>
</div>
