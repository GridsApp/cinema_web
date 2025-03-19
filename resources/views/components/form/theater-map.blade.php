<div x-data="GeneralFunctions.initMap()" {{ '@' . $info['listen']['change'] }}.window="handleValueChanged"
    {{ '@' . $info['listen']['init'] }}.window="handleValueSelected">
    
    <div x-show="!managingSeats" x-cloak>
        <div class="grid grid-cols-12 gap-4">
            <div class="col-span-6">
                <div>
                    <label class="twa-form-label">Max Row</label>
                    <div class="twa-form-input-container">
                        <div
                            class=" twa-form-input-ring">
                            <input x-model.number="maxRow" @input.debounce.500ms="checkAndGenerate" max="100"
                                type="number" min="0"
                                class="twa-form-input ">
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-span-6">
                <label class="twa-form-label">Max Column</label>
                <div class="twa-form-input-container">
                    <div
                        class="twa-form-input-ring">
                        <input x-model.number="maxColumn" @input.debounce.500ms="checkAndGenerate" max="100"
                            type="number" min="0"
                            class="twa-form-input ">
                    </div>
                </div>
            </div>
        </div>
        <div x-show="!loading && gridGenerated" x-cloak class="table-container">
            <div class="flex justify-between items-center mt-5 mb-5">
                <div class="text-[14px] max-w-[65%]">
                    Click on circles to select seats, all unselected represent empty spaces
                </div>
                <div class="flex gap-4 ">
                    <button type="button" @click="toggleAllSeats"
                        class="text-[12px]  bg-secondary-500 hover:bg-secondary-600 text-white px-4 py-2 rounded-md">
                        Select all
                    </button>

                    <button type="button" :disabled="showNextStep" @click="manageSeats"
                        class="text-[12px] disabled:opacity-50 bg-primary-500 hover:bg-primary-600 text-white px-4 py-2 rounded-md">
                        Next Step
                    </button>
                </div>
            </div>

            <div class="border-b border-b-gray-200"></div>

            <table class="map-grid-container mt-6 border-collapse">
                <tbody>
                    <template x-for="(xcells, index) in cells">
                        <tr x-key='index'>
                            <template x-for="(cell,index2) in xcells">
                                <td x-key="index2">
                                    <input type="checkbox" class="checkbox cell-input" :checked="cell.isSeat"
                                        @change="toggleSeat(cell)" />
                                </td>
                            </template>
                        </tr>
                    </template>
                    <tr>
                        <td :colspan="cells[0]?.length" class="text-center font-semibold screen py-1  bg-[#e2e2e2]">
                            SCREEN
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div x-show="managingSeats" x-cloak class="seat-management-section">
        <div class="flex justify-between items-center">
            <div class="flex gap-10 flex-wrap">

                <input type="hidden" x-ref="selectedZone" x-model="selectedZone" />

                <template x-for="zone  in zones" :key="zone.id">

                    <div class="flex items-center">
                        <label class="relative  items-center inline-flex cursor-pointer twa-form-label  ">
                            <span class="mr-2"
                                :style="'display:inline-block;min-width:10px; min-height: 10px; background-color: ' + zone
                                    .color">
                            </span>

                            <span x-text="zone.label"></span>
                            <template x-if="zones.length > 1">
                                <div class="flex items-center ml-2">
                                    <div class="relative flex items-center justify-end">

                                        <input x-model="selectedZone" type="radio" :value="zone.id"
                                            class="peer absolute inset-y-0 left-0.5 translate-x-0 my-0.5 transform cursor-pointer appearance-none rounded-full border-0 bg-white shadow transition duration-200 ease-in-out checked:bg-none checked:text-white focus:outline-none focus:ring-0 focus:ring-offset-0 h-4 w-4 checked:translate-x-4">

                                        <div
                                            class="bg-secondary-200 dark:bg-dark-800 block cursor-pointer rounded-full transition duration-100 ease-in-out group-focus:ring-2 group-focus:ring-offset-2 peer-focus:ring-2 peer-focus:ring-offset-2 h-5 w-9 peer-checked:bg-primary-500 peer-focus:ring-primary-500 group-focus:ring-primary-500 dark:ring-offset-dark-900">
                                        </div>

                                    </div>
                                </div>
                            </template>


                        </label>
                    </div>


                </template>
            </div>
            <div class="">
                <button type="button" @click="resetSeats"
                    class="text-[12px]  bg-secondary-500 hover:bg-secondary-600 text-white px-4 py-2 rounded-md ">
                    Reset
                </button>

            </div>
        </div>
        <div class="table-container">
            <table class="map-grid-container mt-6 border-collapse">

                <tbody>
                    <tr>

                        <td>
                            <div>

                                <select x-model="numberingOrder" x-on:change="generateSeats(); saveSeats();"
                                    name="numbering_order" class="mr-[20px]">
                                    <option value="same">
                                        Same
                                    </option>
                                    <option value="reverse">Reverse
                                    </option>
                                </select>

                            </div>
                        </td>
                    </tr>
                    <template x-for="(xcells, rowIndex) in cells" x-key="rowIndex">

                        <tr>
                            <td>




                                <template x-if="selectedLetters[rowIndex] != null">


                                    <input type="text" x-on:input="changeRowLetter(rowIndex)"
                                        x-on:focus="$event.target.select()" x-model="selectedLetters[rowIndex]">

                                </template>

                            </td>

                            <template x-for="cell in xcells">


                                <td>
                                    <div
                                        class="flex justify-center items-center min-w-[20px] min-h-[20px] my-[4px] mx-[5px]">
                                        <template x-if="cell.isSeat">
                                            <div class="relative group">
                                                {{-- <i x-on:click="() => handleSeatClick(cell)"
                                                    class="fa-solid fa-chair-office text-[20px] cursor-pointer"
                                                    :style="'color:' + cell.color"> </i> --}}

                                                    <i  x-on:click="() => handleSeatClick(cell)" class="fa-solid fa-chair text-[20px] cursor-pointer"  :style="'color:' + cell.color"></i>
                                                <div
                                                    class="absolute bottom-2 flex flex-col items-center hidden mb-5 group-hover:flex">
                                                    <span
                                                        class="relative rounded-md z-10 py-2 px-2 text-xs leading-none text-white whitespace-no-wrap bg-black shadow-lg"
                                                        x-text="cell.code"></span>
                                                    <div class="w-3 h-3 -mt-2 rotate-45 bg-black"></div>
                                                </div>






                                        </template>
                                        <template x-if="!cell.isSeat">
                                            <div class="empty w-[20px] h-[20px] "></div>
                                        </template>

                                    </div>
                                </td>
                            </template>

                        </tr>
                    </template>
                    <tr>
                        <td colspan="1"></td>
                        <td :colspan="cells[0]?.length" class="text-center font-semibold screen py-1  bg-[#e2e2e2]">
                            SCREEN
                        </td>
                    </tr>
                    {{-- <tr>

                    </tr> --}}
                </tbody>
            </table>
        </div>

    </div>
    @error(get_field_modal($info) ?? 'value')
        <span class="form-error-message">
            {{ $message }}
        </span>
    @enderror

</div>
