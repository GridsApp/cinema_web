<div  x-data="GeneralFunctions.calendar()"
    x-on:record-created-{{ $info['id'] }}.window='handleCreateCallback'
    {{ '@' . $info['listen']['change'] }}.window="handleValueChanged"
    {{ '@' . $info['listen']['init'] }}.window="handleValueSelected">

    <div class="twa-table-card" :class="selectedTheater == null ? 'twa-table-card-disabled' : ''">
        <div class="twa-table-card-disabled-message">
            Please select theater to show calendar
        </div>

        <div class="twa-card-header ">
            <div class="twa-card-title w-full">
                <div class="w-full flex items-center justify-between">
                    <div class="flex items-center">
                        <button type="button" @click="previousWeek" class="text-[12px]  py-2"><i
                                class="fa-regular fa-chevron-left text-[#78829d]"></i></button>

                        <div x-text="formatDate(dateFrom)" class="min-w-[110px] font-semibold text-[12px] text-center">
                        </div>
                        <span> - </span>
                        <div x-text="formatDate(dateTo)" class=" font-semibold min-w-[110px] text-[12px] text-center ">
                        </div>
                        <button type="button" @click="nextWeek" class="text-[12px]  py-2"><i
                                class="fa-regular fa-chevron-right text-[#78829d]"></i></button>
                    </div>

                    <div class="flex gap-3">
                        <template x-if="selected.length == 1">
                            <button @click="drawerOpenEdit = true" type="button"
                                class="text-[12px] focus:ring-offset-white focus:shadow-outline group inline-flex items-center justify-center gap-x-2 border outline-none transition-all duration-200 ease-in-out hover:shadow-sm focus:border-transparent focus:ring-2 disabled:cursor-not-allowed disabled:opacity-80  px-4 py-2 text-secondary-50 ring-secondary-500 bg-secondary-500 focus:bg-secondary-600 hover:bg-secondary-600 border-transparent focus:ring-offset-2 dark:focus:ring-offset-dark-900 dark:focus:ring-secondary-600 dark:bg-secondary-700 dark:hover:bg-secondary-600 dark:hover:ring-secondary-600 rounded-md">
                                Edit
                            </button>
                        </template>

                        <template x-if="selected.length == 1">
                            <button @click="selectGroup()" type="button"
                                class="text-[12px] focus:ring-offset-white focus:shadow-outline group inline-flex items-center justify-center gap-x-2 border outline-none transition-all duration-200 ease-in-out hover:shadow-sm focus:border-transparent focus:ring-2 disabled:cursor-not-allowed disabled:opacity-80  px-4 py-2 text-secondary-50 ring-secondary-500 bg-secondary-500 focus:bg-secondary-600 hover:bg-secondary-600 border-transparent focus:ring-offset-2 dark:focus:ring-offset-dark-900 dark:focus:ring-secondary-600 dark:bg-secondary-700 dark:hover:bg-secondary-600 dark:hover:ring-secondary-600 rounded-md">
                                Select Group
                            </button>
                        </template>

                        <template x-if="selected.length > 1">



                        <button  @click="openQuickEditAll($event)" type="button"
                                class="text-[12px] focus:ring-offset-white focus:shadow-outline group inline-flex items-center justify-center gap-x-2 border outline-none transition-all duration-200 ease-in-out hover:shadow-sm focus:border-transparent focus:ring-2 disabled:cursor-not-allowed disabled:opacity-80  px-4 py-2 text-primary-50 ring-primary-500 bg-primary-500 focus:bg-primary-600 hover:bg-primary-600 border-transparent focus:ring-offset-2 dark:focus:ring-offset-dark-900 dark:focus:ring-primary-600 dark:bg-primary-700 dark:hover:bg-primary-600 dark:hover:ring-primary-600 rounded-md {{ $classes ?? '' }}">
                                Edit all selected
                        </button>



                        </template>

                        <template x-if="selected.length > 0">
                            <button @click="deleteMovieShows()" type="button"
                                class="text-[12px] focus:ring-offset-white focus:shadow-outline group inline-flex items-center justify-center gap-x-2 border outline-none transition-all duration-200 ease-in-out hover:shadow-sm focus:border-transparent focus:ring-2 disabled:cursor-not-allowed disabled:opacity-80  px-4 py-2 text-red-50 ring-red-500 bg-red-500 focus:bg-red-600 hover:bg-red-600 border-transparent focus:ring-offset-2 dark:focus:ring-offset-dark-900 dark:focus:ring-red-600 dark:bg-red-700 dark:hover:bg-red-600 dark:hover:ring-red-600 rounded-md">
                                Delete
                            </button>
                        </template>
                    </div>
                    <template x-if="selected.length == 0">
                        <button :disabled="selectedTheater == null" @click="openQuickAdd($event)" type="button"
                            class="text-[12px] focus:ring-offset-white focus:shadow-outline group inline-flex items-center justify-center gap-x-2 border outline-none transition-all duration-200 ease-in-out hover:shadow-sm focus:border-transparent focus:ring-2 disabled:cursor-not-allowed disabled:opacity-80  px-4 py-2 text-primary-50 ring-primary-500 bg-primary-500 focus:bg-primary-600 hover:bg-primary-600 border-transparent focus:ring-offset-2 dark:focus:ring-offset-dark-900 dark:focus:ring-primary-600 dark:bg-primary-700 dark:hover:bg-primary-600 dark:hover:ring-primary-600 rounded-md {{ $classes ?? '' }}">
                            Add Movie
                        </button>
                    </template>
                </div>

            </div>
        </div>
        <div class="twa-card-body  card-body-rounded-bottom relative"  >
            <div class="twa-table-calendar w-full"
            {{-- x-on:dragover="calendarDragOver($event)" x-on:drop="calendarDrop($event)" --}}

            >
                <div class="twa-table-calendar-tr">
                    <div class="twa-table-calendar-time-th">Time</div>
                    <template x-for="(day, index) in days" :key="index">
                        <div class="twa-table-calendar-th" x-text="day.label" x-ref="thElement"></div>
                    </template>
                </div>
                <template x-for="time in times">
                    <div class="twa-table-calendar-tr" >
                        <div class="twa-table-calendar-time-td" x-text="time">

                        </div>

                        <div class="twa-table-calendar-td time-cell">

                        </div>
                        <div class="twa-table-calendar-td time-cell"
                            x-on:dragover="dragOver"
                            x-on:dragleave="dragLeave"
                            x-on:drop="drop(time , 1)"

                            :data-time="time"
                            data-day="1"



                            >

                        </div>
                        <div class="twa-table-calendar-td time-cell"
                            x-on:dragover="dragOver"
                            x-on:dragleave="dragLeave"
                            x-on:drop="drop(time , 2)"
                            :data-time="time"
                            data-day="2"




                            >

                        </div>
                        <div class="twa-table-calendar-td time-cell"
                            x-on:dragover="dragOver"
                            x-on:dragleave="dragLeave"
                            x-on:drop="drop(time , 3)"

                            :data-time="time"
                            data-day="3"




                            >
                        </div>
                        <div class="twa-table-calendar-td time-cell"
                            x-on:dragover="dragOver"
                            x-on:dragleave="dragLeave"
                            x-on:drop="drop(time , 4)"

                            :data-time="time"
                            data-day="4"


                           >

                        </div>
                        <div class="twa-table-calendar-td time-cell"
                            x-on:dragover="dragOver"
                            x-on:dragleave="dragLeave"
                            x-on:drop="drop(time , 5)"

                            :data-time="time"
                            data-day="5"

                    >

                        </div>
                        <div class="twa-table-calendar-td time-cell"
                            x-on:dragover="dragOver"
                            x-on:dragleave="dragLeave"
                            x-on:drop="drop(time , 6)"

                            :data-time="time"
                            data-day="6"




                            >

                        </div>
                    </div>
                </template>
            </div>
            <template x-if="loading == false && loadingCalendar == false">

                <template x-for="event in events">
                    <div :id="'event-box-'+event.details.id" class="twa-event twa-event-backdiv" draggable="true"
                        x-on:dragstart="dragStart(event.details.id)"
                        {{-- x-on:drag="drag" --}}


                        x-on:mousedown = "mouseDown"
                        x-on:mouseup = "mouseUp"

                        x-on:dragend="dragEnd()"
                        :style="'top: ' + event.top + ' ; left:' + event.left + '; width: ' + event.width + '; height:' +
                            event
                            .height">
                        <div>
                            <input class="checkbox__input " :id="'event-' + event.details.id" type="checkbox"
                                x-model="selected" :value="event.details.id" />

                            <label :for="'event-' + event.details.id" class="twa-event-inner checkbox"
                                :style="'background-color:' + event.details.color + '10; border: 1px solid ' + event.details
                                    .color +
                                    '15; color: ' + event.details.color"
                                @focus="onFocus" @blur="onBlur">
                                <div class="flex mb-2">
                                    <div class="flex-1">
                                        <div class="font-bold mb-1" x-text="event.details.label"></div>
                                    </div>
                                    <div class="">
                                        <span class="checkbox__inner__checked">
                                            <i class="fa-solid fa-circle-check"></i>
                                        </span>
                                        <span class="checkbox__inner__not_checked">
                                            <i class="fa-light fa-circle" x-transition></i>
                                        </span>
                                    </div>
                                </div>

                                <div class="text-[10px]" x-text="'Time : ' + event.details.time">
                                </div>

                                <div class="text-[10px]" x-text="'Duration : ' + event.details.duration + ' min'">
                                </div>
                            </label>


                        </div>
                    </div>

                </template>
            </template>
        </div>
    </div>

    @component('components.drawer', [ 'showHandler' => 'drawerOpenEdit', 'closeHandler' => 'drawerOpenEdit = false', 'title' => 'Edit Movie Show' ])
        @livewire('MovieShowFormEdit', [ 'uniqeid' => $info['id'] , 'type' => 'single' ])
    @endcomponent

    @component('components.drawer', [ 'showHandler' => 'drawerOpenEditAll', 'closeHandler' => 'drawerOpenEditAll = false', 'title' => 'Edit Movie Shows' ])
        @livewire('MovieShowFormEdit', [ 'uniqeid' => $info['id'] , 'type' => 'multishow' ])
    @endcomponent

    @component('components.drawer', [ 'showHandler' => 'drawerOpen', 'closeHandler' => 'drawerOpen = false', 'title' => 'Create Movie Show' ])
        @livewire('Forms.MovieShowForm', ['uniqeid' => $info['id'] ])
    @endcomponent






</div>
