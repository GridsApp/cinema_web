<div x-data="Functions.initMap()">
    <div x-show="!managingSeats">

        <form @submit.prevent>
            <div class="grid grid-cols-12 container-fixed gap-4">
                {{-- {!! field('price_groups', 'col-span-4' , 'price_group_id') !!} --}}
                
                <div class="col-span-4">
                    <div>
                        <label class="twa-form-label">
                            Max Row
                        </label>
                        <div class="relative mt-1 rounded-md shadow-sm">
                            <div
                                class=" twa-form-input-ring">
                                <input x-model.number="maxRow" min="0" @input="debounceCheckAndGenerate"
                                    type="number"
                                    class="twa-form-input ">
                            </div>
                        </div>


                        @error('value')
                            <span class="mt-1 block text-sm font-medium text-red-500">
                                The field is required.
                            </span>
                        @enderror
                    </div>
                </div>
                <div class="col-span-4">
                    <label class="twa-form-label">
                        Max Column
                    </label>
                    <div class="relative mt-1 rounded-md shadow-sm">
                        <div
                            class=" twa-form-input-ring">
                            <input x-model.number="maxColumn" min="0" @input="debounceCheckAndGenerate"
                                type="number"
                                class="twa-form-input ">
                        </div>
                    </div>


                    @error('value')
                        <span class="mt-1 block text-sm font-medium text-red-500">
                            The field is required.
                        </span>
                    @enderror
                </div>
            </div>
        </form>

        <div class="table-container relative container-fixed overflow-hidden">
            <div class="twa-table-card pb-[100px]">
                <div class="twa-card-body">
                    <div x-show="loading" class="loading-indicator">
                        <div class="twa-select-options-load">
                            <i class="fa-regular fa-loader"></i>
                            <span class="text-[14px]">Loading...</span>
                        </div>
                    </div>

                    <div x-show="!loading && gridGenerated">
                        <table class="map-grid-container mt-6 border-collapse">
                            <tbody>
                                <template x-for="rowIndex in maxRow" :key="rowIndex">
                                    <tr>
                                        <template x-for="colIndex in maxColumn > 0 ? maxColumn : 1"
                                            :key="colIndex">
                                            <td>
                                                <input type="checkbox" class="checkbox cell-input"
                                                    x-model="getCell(rowIndex, colIndex).checked" />
                                            </td>
                                        </template>
                                    </tr>
                                </template>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        <div class="fixed bottom-0" style="width: -webkit-fill-available;">
            <div class="container-fixed">
                @component('components.panels.default', ['classes' => 'bg-[#fcfcfc] ring-1 ring-gray-300'])
                    <div class="flex justify-center gap-4">
                        {!! link_button('Cancel', '#', 'secondary') !!}
                        <button type="button" @click="manageSeats"
                            class="text-[12px] focus:ring-offset-white focus:shadow-outline group inline-flex items-center justify-center gap-x-2 border outline-none transition-all duration-200 ease-in-out hover:shadow-sm focus:border-transparent focus:ring-2 disabled:cursor-not-allowed disabled:opacity-80 px-4 py-2 text-primary-50 ring-primary-500 bg-primary-500 focus:bg-primary-600 hover:bg-primary-600 border-transparent focus:ring-offset-2 dark:focus:ring-offset-dark-900 dark:focus:ring-primary-600 dark:bg-primary-700 dark:hover:bg-primary-600 dark:hover:ring-primary-600 rounded-md">
                            Next Step
                        </button>
                    </div>
                @endcomponent
            </div>
        </div>
    </div>
    <div x-show="managingSeats" class="seat-management-section container-fixed">

        <div class="flex flex-wrap gap-3">
            <div>
                <span
                    style="display:inline-block;min-width:10px; min-height: 10px; background-color: #9c9b9b; margin-right:10px">
                </span>
                Regular Seat
            </div>

            <div class="flex items-center">
                <label class="relative items-center inline-flex gap-2 cursor-pointer  mr-4">
                    <span style="display:inline-block;min-width:10px; min-height: 10px; background-color: #d51515; ">
                    </span> Club Seat
                    <div class="flex items-center">
                        <div class="relative flex items-center justify-end">
                            <input checked type="radio" name="seating" value="club"
                                class="peer absolute inset-y-0 left-0.5 translate-x-0 my-0.5 transform cursor-pointer appearance-none rounded-full border-0 bg-white shadow transition duration-200 ease-in-out checked:bg-none checked:text-white focus:outline-none focus:ring-0 focus:ring-offset-0 h-4 w-4 checked:translate-x-4">
                            <div
                                class="bg-secondary-200 dark:bg-dark-800 block cursor-pointer rounded-full transition duration-100 ease-in-out group-focus:ring-2 group-focus:ring-offset-2 peer-focus:ring-2 peer-focus:ring-offset-2 h-5 w-9 peer-checked:bg-primary-500 peer-focus:ring-primary-500 group-focus:ring-primary-500 dark:ring-offset-dark-900">
                            </div>
                        </div>
                    </div>
                </label>

                <label class="relative items-center inline-flex gap-2 cursor-pointer ">
                    <span style="display:inline-block;min-width:10px; min-height: 10px; background-color: #046287;">
                    </span>
                    Double Club Seat

                    <div class="flex items-center">
                        <div class="relative flex items-center justify-end">
                            <input type="radio" name="seating" value="double"
                                class="peer absolute inset-y-0 left-0.5 translate-x-0 my-0.5 transform cursor-pointer appearance-none rounded-full border-0 bg-white shadow transition duration-200 ease-in-out checked:bg-none checked:text-white focus:outline-none focus:ring-0 focus:ring-offset-0 h-4 w-4 checked:translate-x-4">
                            <div
                                class="bg-secondary-200 dark:bg-dark-800 block cursor-pointer rounded-full transition duration-100 ease-in-out group-focus:ring-2 group-focus:ring-offset-2 peer-focus:ring-2 peer-focus:ring-offset-2 h-5 w-9 peer-checked:bg-primary-500 peer-focus:ring-primary-500 group-focus:ring-primary-500 dark:ring-offset-dark-900">
                            </div>
                        </div>
                    </div>
                </label>
            </div>

        </div>


        <div class="table-container relative container-fixed overflow-hidden">
            <div class="twa-table-card pb-[100px]">
                <div class="twa-card-body">
                    <table class="map-grid-container mt-6 border-collapse">
                        <tbody>
                            <template x-for="rowIndex in maxRow" :key="rowIndex">
                                <tr>
                                    <template x-for="colIndex in maxColumn" :key="colIndex">
                                        <td class="px-3 py-2">
                                            <i class="fa-solid text-[23px] fa-chair-office"
                                                x-bind:class="{
                                                    'text-gray-500': getCell(rowIndex, colIndex).checked,
                                                    'opacity-0': !getCell(rowIndex, colIndex).checked,
                                                    'pointer-events-none': !getCell(rowIndex, colIndex).checked
                                                }"
                                                style="cursor: pointer;"></i>
                                        </td>
                                    </template>
                                </tr>
                            </template>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="fixed bottom-0" style="width: -webkit-fill-available;">
            <div class="container-fixed">
                @component('components.panels.default', ['classes' => 'bg-[#fcfcfc] ring-1 ring-gray-300'])
                    <div class="flex justify-center gap-4">
                        {!! link_button('Cancel', '#', 'secondary') !!}
                        <button type="button" @click="manageSeats"
                            class="text-[12px] focus:ring-offset-white focus:shadow-outline group inline-flex items-center justify-center gap-x-2 border outline-none transition-all duration-200 ease-in-out hover:shadow-sm focus:border-transparent focus:ring-2 disabled:cursor-not-allowed disabled:opacity-80 px-4 py-2 text-primary-50 ring-primary-500 bg-primary-500 focus:bg-primary-600 hover:bg-primary-600 border-transparent focus:ring-offset-2 dark:focus:ring-offset-dark-900 dark:focus:ring-primary-600 dark:bg-primary-700 dark:hover:bg-primary-600 dark:hover:ring-primary-600 rounded-md">
                            Save
                        </button>
                    </div>
                @endcomponent
            </div>
        </div>
    </div>
</div>
Lorem ipsum dolor sit amet consectetur adipisicing elit. Non corrupti, pariatur veniam, vero magni, voluptatum deserunt saepe maxime libero provident fugit! Modi explicabo aut quisquam nostrum qui nulla pariatur dolorem. Officia ipsa odio iusto molestias. Dicta ut inventore magnam perferendis possimus modi, officiis corporis molestiae! Ipsa quod impedit aspernatur odio, doloribus et nemo debitis. In officiis, molestiae repellendus, iure rerum reprehenderit dolorem, voluptatem magni dignissimos ipsam ad. Odit aliquid unde aperiam sed fugit esse minus molestiae dolorem omnis pariatur ipsum laboriosam animi, amet, perferendis laudantium cumque quos? Quidem error alias sequi placeat tempore? Odit obcaecati maiores, ipsa doloribus hic eius!