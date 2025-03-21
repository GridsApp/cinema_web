<div x-data="GeneralFunctions.initPriceSettings()">
    <label class="twa-form-label">
        {{ $info['label'] }}
    </label>
    <div class="twa-form-input-container">
        <div class="twa-form-input-ring  @isset($info['prefix']) has-prefix @endisset">

            @isset($info['prefix'])
                <span class="placeholder-class ml-2 mr-1  flex items-center ">{{ $info['prefix'] }}</span>
            @endisset
            <input x-model="defaultPrice" type="number" class="twa-form-input ">
        </div>
    </div>

    <div class="">

        <div class="underline text-xs cursor-pointer py-3" x-on:click="addCondition">
            <i class="fa-regular fa-plus"></i> Add Condition


        </div>
        <div>

            <template x-for="(condition,index) in conditions">
                <div class="flex gap-3 items-center mb-2" wire:key="index">
                    {{--                    <input x-model="conditions[index].day" /> --}}
                    <div class="twa-form-label min-w-[50px]">

                        <select class="twa-form-input-container twa-form-input-ring border-0 text-[12px]"
                            x-model="conditions[index].day" :key="'select' + index">

                            <option value=""> Choose day</option>
                            <option value="monday">Monday</option>
                            <option value="tuesday">Tuesday</option>
                            <option value="wednesday">Wednesday</option>
                            <option value="thursday">Thursday</option>
                            <option value="friday">Friday</option>
                            <option value="saturday">Saturday</option>
                            <option value="sunday">Sunday</option>


                        </select>
                    </div>
                    <div class="twa-form-input-container twa-form-input-ring flex-1">

                        <input class="twa-form-input " type="text" x-model="conditions[index].price">
                    </div>

                    <button type="button" class="border-0 rounded w-[36px] h-[36px] hover:bg-primary-50"
                        x-on:click="deleteCondition(index)">
                        <i class="fa-regular fa-trash"></i>
                    </button>

                </div>
            </template>

        </div>

    </div>

    @error(get_field_modal($info) ?? 'value')
        <span class="form-error-message">
            {{ $message }}
        </span>
    @enderror
</div>
