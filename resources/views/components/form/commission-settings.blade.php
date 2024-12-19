<div x-data="GeneralFunctions.initConditions()"

     @if($info['listen']['change'] ?? null) {{ '@' . $info['listen']['change'] }}.window="handleValueChanged" @endif
    @if($info['listen']['init'] ?? null) {{ '@' . $info['listen']['init'] }}.window="handleValueSelected" @endif

>
    <label class="twa-form-label">
        {{ $info['label'] }}
    </label>
    <div class="twa-form-input-container">
        <div class="twa-form-input-ring  @isset($info['prefix']) has-prefix @endisset">

            @isset($info['prefix'])
                <span class="placeholder-class ml-2 mr-1  flex items-center ">{{ $info['prefix'] }}</span>
            @endisset
            <input x-model="defaultPercentage" type="number" class="twa-form-input ">
        </div>
    </div>

    <div class="">

        <div class="underline text-xs cursor-pointer py-3" x-on:click="addCondition" >
            <i class="fa-regular fa-plus"></i> Add Condition


        </div>
        <div>

            <template x-for="(condition,index) in conditions">
                <div class="flex gap-3 items-center mb-2" wire:key="index">



                    <div class="twa-form-label" style="min-width:50px">
                        Week <span x-text="index + 1"></span>
                    </div>
                    <div class="twa-form-input-container twa-form-input-ring flex-1">

                        <input class="twa-form-input " type="text" x-model="conditions[index]">
                    </div>



                    <button type="button" class="border-0 rounded w-[36px] h-[36px] hover:bg-primary-50" x-on:click="deleteCondition(index)">
                        <i class="fa-regular fa-trash"></i>
                    </button>


                </div>
            </template>

{{--            <button class="btn btn-primary mt-5" type="button" x-on:click="addCondition"> <i class="fa-regular fa-plus"></i> Add Week </button>--}}

        </div>

    </div>

    @error(get_field_modal($info) ?? 'value')
        <span class="form-error-message">
            {{ $message }}
        </span>
    @enderror
</div>
