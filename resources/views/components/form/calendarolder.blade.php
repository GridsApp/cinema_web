<div x-data="GeneralFunctions.calendar()" x-on:record-created-{{ $info['id'] }}.window='handleCreateCallback'
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
                            <button @click="openQuickEditAll($event)" type="button"
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
        <div class="twa-card-body  card-body-rounded-bottom relative">
            <div class="twa-table-calendar fc w-full p-2">
                <div aria-labelledby="fc-dom-1" class="fc-view-harness fc-view-harness-active"
                    style="height: 754.074px;">
                    <div class="fc-timeGridWeek-view fc-view fc-timegrid h-full">
                        <table role="grid" class="fc-scrollgrid  h-full fc-scrollgrid-liquid">
                            <thead role="rowgroup">
                                <tr role="presentation" class="fc-scrollgrid-section fc-scrollgrid-section-header ">
                                    <th role="presentation">
                                        <div class="fc-scroller-harness">
                                            <div class="fc-scroller" style="overflow: hidden scroll;">
                                                <table role="presentation" class="fc-col-header "
                                                    style="width: 1016px;">
                                                    <colgroup>
                                                        <col style="width: 55px;">
                                                    </colgroup>
                                                    <thead role="presentation">
                                                        <tr role="row">
                                                            <th aria-hidden="true" class="fc-timegrid-axis">
                                                                <div class="fc-timegrid-axis-frame"></div>
                                                            </th>
                                                            <template x-for="(day, dayIndex) in days"
                                                                :key="dayIndex">
                                                                <th role="columnheader" :data-date="day.value"
                                                                    class="fc-col-header-cell fc-day fc-day-sun fc-day-past">
                                                                    <div class="fc-scrollgrid-sync-inner">
                                                                        <a x-text="day.label"
                                                                            title="Go to October 20, 2024"
                                                                            data-navlink="" tabindex="0"
                                                                            class="fc-col-header-cell-cushion"></a>
                                                                    </div>
                                                                </th>
                                                            </template>
                                                        </tr>
                                                    </thead>
                                                </table>
                                            </div>
                                        </div>
                                    </th>
                                </tr>
                            </thead>
                            <tbody role="rowgroup">
                                <tr role="presentation"
                                    class="fc-scrollgrid-section fc-scrollgrid-section-body  fc-scrollgrid-section-liquid">
                                    <td role="presentation h-full">
                                        <div class="fc-scroller-harness fc-scroller-harness-liquid relative h-full">
                                            <div class="fc-scroller fc-scroller-liquid-absolute absolute inset-0"
                                                style="overflow: hidden scroll;">
                                                <div class="fc-timegrid-body relative z-1 min-h-full"
                                                    style="width: 1016px;">
                                                    <div class="fc-timegrid-slots relative z-1">
                                                        <table aria-hidden="true" class="" style="width: 1016px;">
                                                            <colgroup>
                                                                <col style="width: 55px;">
                                                            </colgroup>
                                                            <tbody>
                                                                <template x-for="(time, timeIndex) in times"  :key="timeIndex">
                                                                    <tr>
                                                                       <td :data-time="time"
                                                                            class="fc-timegrid-slot fc-timegrid-slot-label fc-scrollgrid-shrink">
                                                                            <div
                                                                                class="fc-timegrid-slot-label-frame fc-scrollgrid-shrink-frame">
                                                                                <div class="fc-timegrid-slot-label-cushion fc-scrollgrid-shrink-cushion"
                                                                                    x-text="time"></div>
                                                                            </div>
                                                                        </td>
                                                                        <td :data-time="time"
                                                                            class="fc-timegrid-slot fc-timegrid-slot-lane">
                                                                        </td>
                                                                    </tr>
                                                                </template>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                    <div class="fc-timegrid-cols absolute inset-0">
                                                        <table role="presentation" class="h-full"
                                                            style="width: 1016px;">
                                                            <colgroup>
                                                                <col style="width: 55px;">
                                                            </colgroup>
                                                            <tbody role="presentation">
                                                                <tr role="row">
                                                                    <td aria-hidden="true"
                                                                        class="fc-timegrid-col fc-timegrid-axis">
                                                                        <div class="fc-timegrid-col-frame relative">
                                                                            <div
                                                                                class="fc-timegrid-now-indicator-container">
                                                                            </div>
                                                                        </div>
                                                                    </td>
                                                                    <template x-for="(date, dateIndex) in days"
                                                                        :key="dateIndex">
                                                                        <td class="fc-day fc-day-mon fc-day-past fc-timegrid-col"
                                                                            role="gridcell" @dragover.prevent
                                                                            @drop="(event) => dropnew(event, date.value)"
                                                                            :data-date="date.value" >
                                                                            <div
                                                                                class="fc-timegrid-col-frame relative min-h-full">
                                                                                <div
                                                                                    class="fc-timegrid-col-bg absolute inset-0">
                                                                                </div>
                                                                                <div
                                                                                    class="fc-timegrid-col-events absolute inset-0">
                                                                                    <!-- EVENT TO BE DRAGGABLE -->
                                                                                    <template x-for="event in events">
                                                                                        <div @dragstart="dragnew($event, event)"
                                                                                            draggable="true"
                                                                                            class="fc-timegrid-event-harness fc-timegrid-event-harness-inset">
                                                                                            <a
                                                                                                class="fc-event fc-event-draggable fc-event-resizable">
                                                                                                <div
                                                                                                    class="fc-event-main">
                                                                                                    <div
                                                                                                        class="fc-event-main-frame">
                                                                                                        <div class="fc-event-time"
                                                                                                            x-text="'Time : ' + event.details.time">
                                                                                                            {{-- 6:00 - 8:00 --}}
                                                                                                        </div>
                                                                                                        <div
                                                                                                            class="fc-event-title-container">
                                                                                                            <div
                                                                                                                class="fc-event-title fc-sticky">
                                                                                                                Meeting
                                                                                                            </div>
                                                                                                        </div>
                                                                                                    </div>
                                                                                                </div>
                                                                                            </a>
                                                                                        </div>
                                                                                    </template>
                                                                                </div>

                                                                                <div
                                                                                    class="fc-timegrid-col-events absolute inset-0">
                                                                                </div>
                                                                                <div
                                                                                    class="fc-timegrid-now-indicator-container absolute inset-0">
                                                                                </div>
                                                                            </div>
                                                                        </td>
                                                                    </template>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            {{-- <template x-if="loading == false && loadingCalendar == false">

                <template x-for="event in events">
                    <div :id="'event-box-'+event.details.id" class="twa-event twa-event-backdiv">
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
            </template> --}}
        </div>
    </div>

    @component('CMSView::components.drawer', [
        'showHandler' => 'drawerOpenEdit',
        'closeHandler' => 'drawerOpenEdit = false',
        'title' => 'Edit Movie Show',
    ])
        @livewire('MovieShowFormEdit', ['uniqeid' => $info['id'], 'type' => 'single'])
    @endcomponent

    @component('components.drawer', [
        'showHandler' => 'drawerOpenEditAll',
        'closeHandler' => 'drawerOpenEditAll = false',
        'title' => 'Edit Movie Shows',
    ])
        @livewire('MovieShowFormEdit', ['uniqeid' => $info['id'], 'type' => 'multishow'])
    @endcomponent

    @component('components.drawer', [
        'showHandler' => 'drawerOpen',
        'closeHandler' => 'drawerOpen = false',
        'title' => 'Create Movie Show',
    ])
        @livewire('Forms.MovieShowForm', ['uniqeid' => $info['id']])
    @endcomponent






</div>
