<form wire:submit.prevent="sendOtp" class="auth-form">
    @csrf
    <div>
        @include('website.components.inputs.phone-number', [
            'id' => 'phone',
            'wireModel' => 'phone',
            'name' => 'phone',
            'type' => 'tel',
            'placeholder' => 'Enter your phone number',
        ])
        @error('phone')
            <div class="form-error-message">{{ $message }}</div>
        @enderror
    </div>
    @if ($otpSent)
        <div class="text-green-500 text-sm mt-2">OTP has been sent!</div>
    @endif
    <button type="submit" class="form-button mt-4">Send OTP</button>
</form>
