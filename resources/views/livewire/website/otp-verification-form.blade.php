{{-- <form wire:submit.prevent="verifyOtp" class="auth-form">
    @csrf
    <div>
        <input
            type="text"
            wire:model="otp"
            placeholder="Enter OTP"
            class="input-group"
        />
        @error('otp') <div class="text-red-500 text-sm mt-1">{{ $message }}</div> @enderror
    </div>

    <button type="submit" class="form-button mt-5">Verify OTP</button>
</form> --}}
{{--  
<div class="bg-gradient-to-r from-purple-400 via-pink-500 to-red-500 flex items-center justify-center min-h-screen">
    <div class="bg-white shadow-lg rounded-lg p-8 max-w-xs md:max-w-md w-full">
        <h2 class="text-xl md:text-2xl font-bold text-center text-gray-800 mb-6">Verify Your OTP</h2>
        <p class="text-center text-gray-600 mb-4">Enter the 4-digit OTP sent to your email.</p>
        <form  wire:submit.prevent="verifyOtp" class="auth-form">
            <div class="flex space-x-2 justify-center mb-6">
                <input type="text" maxlength="1" class="w-10 h-10 md:w-12 md:h-12 border border-gray-300 rounded-lg text-center text-lg font-semibold focus:outline-none focus:ring-2 focus:ring-purple-500" />
                <input type="text" maxlength="1" class="w-10 h-10 md:w-12 md:h-12 border border-gray-300 rounded-lg text-center text-lg font-semibold focus:outline-none focus:ring-2 focus:ring-purple-500" />
                <input type="text" maxlength="1" class="w-10 h-10 md:w-12 md:h-12 border border-gray-300 rounded-lg text-center text-lg font-semibold focus:outline-none focus:ring-2 focus:ring-purple-500" />
                <input type="text" maxlength="1" class="w-10 h-10 md:w-12 md:h-12 border border-gray-300 rounded-lg text-center text-lg font-semibold focus:outline-none focus:ring-2 focus:ring-purple-500" />
                   </div>
                   <button type="submit" class="form-button mt-5">Verify OTP</button>
        </form>
        <p class="text-center text-gray-600 mt-6">
            Didn’t receive the code? <a href="#" class="text-purple-500 hover:underline">Resend OTP</a>
        </p>
    </div>
</div>
  --}}
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
        {{-- <button type="submit" class="w-full bg-primary-color  text-white py-2 rounded-lg font-semibold transition">
            Verify OTP
        </button> --}}
    </form>

    <p class="link-button"> Didn’t receive the code? <span>
        <a class="primary-color underline"
         wire:click.prevent="resendOtp">Resend OTP</a>
    </span>
</p>

</div>
