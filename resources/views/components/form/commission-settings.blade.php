<div x-data="{
    open:false, 
    conditions : [] , 
    defaultPercentage : 10, 
    delete(index){
        
    }

}">
    <label class="twa-form-label">
        {{ $info['label'] }}
    </label>
    <div class="twa-form-input-container">
        <div class="twa-form-input-ring  @isset($info['prefix']) has-prefix @endisset">

            @isset($info['prefix'])
                <span
                    class="placeholder-class ml-2 mr-1  flex items-center ">{{ $info['prefix'] }}</span>
            @endisset
            <input x-model="defaultPercentage" type="number" class="twa-form-input ">
        </div>
    </div>

    <div class="">

        <div class="underline text-xs cursor-pointer py-2" x-on:click="open = !open">
            Conditions
        </div>
        <div x-show="open" >
     
            <template x-for="(condition,index) in conditions">
                <div class="flex gap-3 items-center mb-2"  wire:key="index">

                    
            
                        <div class="twa-form-label" style="min-width:50px" >
                            Week <span x-text="index + 1"></span>
                        </div>
                        <div class="twa-form-input-container twa-form-input-ring flex-1">
                            
                            <input class="twa-form-input " type="text" x-model="condition">
                        </div>
    
          
                   
                    <div x-on:click="delete(index)">
                        Delete
                    </div>

                       
                </div>
            </template>   
            
            <button class="btn btn-primary mt-5" type="button" x-on:click="conditions.push('')"> Add Week </button>

        </div>

    </div>

    @error(get_field_modal($info) ?? 'value')
        <span class="form-error-message">
            {{ $message }}
        </span>
    @enderror
</div>
