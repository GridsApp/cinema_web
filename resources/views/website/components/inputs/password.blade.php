<div class="relative" x-data="{ showPassword: false }">
    <input 
        :type="showPassword ? 'text' : 'password'" 
        class="input-group {{ $class ?? '' }}" 
        min="{{ $min ?? 6 }}" 
        name="{{ $name ?? 'password' }}" 
        wire:model="{{ $model ?? 'password' }}" 
        placeholder="{{ $placeholder ?? 'Password' }}" 
    />
    
    <div class="eye-icon-position">
        <a href="javascript:;" @click="showPassword = !showPassword">
            <i x-show="!showPassword" class="fa-solid fa-eye"></i>
            <i x-show="showPassword" class="fa-solid fa-eye-slash"></i>
        </a>
    </div>
</div>
