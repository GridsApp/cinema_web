
{{-- @dd("here"); --}}
<form wire:submit.prevent="resetPassword" class="auth-form">
    @csrf
    <div class="flex flex-col gap-4">
    <div>

        @include('website.components.inputs.password', [
            'min' => 8,
            'name' => 'password',
            'model' => 'password',
            'placeholder' => 'Enter your  password',
        ])
        {{-- <input id="password" wire:model="password" required name="password" class="w-full input-group" type="password" placeholder="New Password"> --}}
        @error('password')
            <div class="form-error-message">{{ $message }}</div>
        @enderror
    </div>
    <div class="mt-4">
        @include('website.components.inputs.password', [
            'min' => 8,
            'name' => 'confirm_password',
            'model' => 'confirm_password',
            'placeholder' => 'Enter your  confirm password',
        ])
        
        {{-- <input id="confirm_password" wire:model="confirm_password" required name="confirm_password" class="w-full input-group" type="password" placeholder="Confirm New Password"> --}}
        @error('confirm_password')
            <div class="form-error-message">{{ $message }}</div>
        @enderror
    </div>
 </div>
    <button type="submit" class="form-button mt-5">Reset Password</button>
</form>
