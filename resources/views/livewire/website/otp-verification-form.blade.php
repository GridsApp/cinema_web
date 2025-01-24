<div>
    <p class="pt-5 text-[12px] capitalize text-center text-gray-600 mb-4">Enter the 4-digit OTP sent to your email.</p>

    <form wire:submit.prevent="verifyOtp" class="auth-form">
        <div class="flex space-x-2 justify-center mb-6">
            @foreach (range(0, 3) as $index)
                <input type="text" maxlength="1" wire:model="otp.{{ $index }}"
                    class="w-10 h-10 md:w-12 md:h-12 border border-gray-300 rounded-lg text-center text-lg font-semibold focus:outline-none focus:ring-2 focus:ring-red-600"
                    autofocus="{{ $index === 0 ? 'autofocus' : '' }}" />
            @endforeach
        </div>

        @error('otp')
            <div class="text-red-500 text-sm mb-4">{{ $message }}</div>
        @enderror

        <button type="submit" class="w-full form-button mt-5">Verify OTP</button>
    </form>

    <div class="pt-10">
        <p class="link-button"> Did not receive the code? 
            <span>
                @if ($canResendOtp)
                    <a class="primary-color underline" wire:click.prevent="resendOtp">Resend OTP</a>
                @else
                @php
                $remainingTimeInSeconds =$remainingTime * 60; 
                $minutes = floor($remainingTimeInSeconds / 60); // Extract minutes
                $seconds = round($remainingTimeInSeconds % 60); // Extract seconds
                $formattedTime = str_pad($minutes, 2, '0', STR_PAD_LEFT) . ':' . str_pad($seconds, 2, '0', STR_PAD_LEFT);
            @endphp
            
            <span wire:poll.500ms="updateResendState">{{ $formattedTime }}</span>
            
                @endif
            </span>
        </p>
    </div>
</div>
