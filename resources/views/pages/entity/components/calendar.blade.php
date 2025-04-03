<div class="grid grid-cols-12 gap-4 mb-5" x-data="GeneralFunctions.calendar()" x-on:empty-selected.window='emptySelection'>
    <div class="col-span-12">

        @component('CMSView::components.panels.default')
            {!! field('theater') !!}
        @endcomponent
    </div>

    <div class="col-span-12">
        <div wire:key="{{ uniqid() }}" x-on:record-created-{{ $info['id'] }}.window='handleCreateCallback'
            x-on:record-not-created-{{ $info['id'] }}.window='handleErrorCallback'>
            <div class="twa-table-card  @if (!$this->theater_id) twa-table-card-disabled @endif">
                <div class="twa-table-card-disabled-message">
                    Please select theater to show calendar
                </div>
                <div class="twa-card-header ">
                    <div class="twa-card-title w-full">
                        <div class="w-full flex items-center justify-between">
                            <div class="flex items-center">
                                <button type="button" wire:click="handlePrevWeek" class="text-[12px]  py-2"><i
                                        class="fa-solid fa-chevron-left text-[#78829d]"></i></button>

                                <div class="min-w-[110px] font-semibold text-[12px] text-center">
                                    {{ now()->parse($date_from)->format('D d M') }}
                                </div>
                                <span> - </span>
                                <div class=" font-semibold min-w-[110px] text-[12px] text-center ">
                                    {{ now()->parse($date_to)->format('D d M') }}
                                </div>
                                <button type="button" wire:click="handleNextWeek" class="text-[12px]  py-2"><i
                                        class="fa-solid fa-chevron-right text-[#78829d]"></i></button>
                            </div>



                            <div class="flex gap-3">

                                @if(cms_check_permission('edit-movie-shows'))
                                <template x-if="selected.length == 1">
                                    <button @click="openDrawer($event , 'editDrawer')" type="button"
                                        class="text-[12px] focus:ring-offset-white focus:shadow-outline group inline-flex items-center justify-center gap-x-2 border outline-none transition-all duration-200 ease-in-out hover:shadow-sm focus:border-transparent focus:ring-2 disabled:cursor-not-allowed disabled:opacity-80  px-4 py-2 text-secondary-50 ring-secondary-500 bg-secondary-500 focus:bg-secondary-600 hover:bg-secondary-600 border-transparent focus:ring-offset-2 dark:focus:ring-offset-dark-900 dark:focus:ring-secondary-600 dark:bg-secondary-700 dark:hover:bg-secondary-600 dark:hover:ring-secondary-600 rounded-md">
                                        Edit
                                    </button>
                                </template>
                                @endif

                                <template x-if="selected.length == 1">
                                    <button @click="selectGroup" type="button"
                                        class="text-[12px] focus:ring-offset-white focus:shadow-outline group inline-flex items-center justify-center gap-x-2 border outline-none transition-all duration-200 ease-in-out hover:shadow-sm focus:border-transparent focus:ring-2 disabled:cursor-not-allowed disabled:opacity-80  px-4 py-2 text-secondary-50 ring-secondary-500 bg-secondary-500 focus:bg-secondary-600 hover:bg-secondary-600 border-transparent focus:ring-offset-2 dark:focus:ring-offset-dark-900 dark:focus:ring-secondary-600 dark:bg-secondary-700 dark:hover:bg-secondary-600 dark:hover:ring-secondary-600 rounded-md">
                                        Select Group
                                    </button>
                                </template>


                                @if(cms_check_permission('edit-movie-shows'))
                                <template x-if="selected.length > 1">
                                    <button @click="openDrawer($event , 'editAllDrawer')" type="button"
                                        class="text-[12px] focus:ring-offset-white focus:shadow-outline group inline-flex items-center justify-center gap-x-2 border outline-none transition-all duration-200 ease-in-out hover:shadow-sm focus:border-transparent focus:ring-2 disabled:cursor-not-allowed disabled:opacity-80  px-4 py-2 text-primary-50 ring-primary-500 bg-primary-500 focus:bg-primary-600 hover:bg-primary-600 border-transparent focus:ring-offset-2 dark:focus:ring-offset-dark-900 dark:focus:ring-primary-600 dark:bg-primary-700 dark:hover:bg-primary-600 dark:hover:ring-primary-600 rounded-md">
                                        Edit all selected
                                    </button>
                                </template>
                                @endif
                                

                                @if(cms_check_permission('delete-movie-shows'))
                                <template x-if="selected.length > 0">

                                    <button x-on:click="deleteMovieShows()" type="button"
                                        class="text-[12px] focus:ring-offset-white focus:shadow-outline group inline-flex items-center justify-center gap-x-2 border outline-none transition-all duration-200 ease-in-out hover:shadow-sm focus:border-transparent focus:ring-2 disabled:cursor-not-allowed disabled:opacity-80  px-4 py-2 text-red-50 ring-red-500 bg-red-500 focus:bg-red-600 hover:bg-red-600 border-transparent focus:ring-offset-2 dark:focus:ring-offset-dark-900 dark:focus:ring-red-600 dark:bg-red-700 dark:hover:bg-red-600 dark:hover:ring-red-600 rounded-md">
                                        Delete
                                    </button>

                                </template>
                               @endif
                            </div>
                         @if(cms_check_permission('create-movie-shows'))
                            <template x-if="selected.length === 0">
                                <button @if (!$this->theater_id) disabled @endif
                                    @click="openDrawer($event, 'createDrawer')" type="button"
                                    class="text-[12px] focus:ring-offset-white focus:shadow-outline group inline-flex items-center justify-center gap-x-2 border outline-none transition-all duration-200 ease-in-out hover:shadow-sm focus:border-transparent focus:ring-2 disabled:cursor-not-allowed disabled:opacity-80  px-4 py-2 text-primary-50 ring-primary-500 bg-primary-500 focus:bg-primary-600 hover:bg-primary-600 border-transparent focus:ring-offset-2 dark:focus:ring-offset-dark-900 dark:focus:ring-primary-600 dark:bg-primary-700 dark:hover:bg-primary-600 dark:hover:ring-primary-600 rounded-md {{ $classes ?? '' }}">

                                    Add Movie
                                </button>
                            </template>

                            @endif
                        </div>
                    </div>
                </div>
                <div class="twa-calendar-v2">
                    <div class="flex twa-calendar-v2-header">
                        <div class="twa-calendar-v2-cells-left time">

                        </div>
                        <div class=" twa-calendar-v2-cells-right ">

                            <div class="grid grid-cols-7">

                                @foreach ($days as $day)
                                    <div class="day"> {{ $day['label'] }}</div>
                                @endforeach


                            </div>

                        </div>
                    </div>
                    <div class="flex ">
                        <div class="twa-calendar-v2-cells-left">

                            @foreach ($times as $time)
                                <div class="cell-height  time">
                                    {{ $time }}
                                </div>
                            @endforeach

                        </div>
                        <div class="twa-calendar-v2-cells-right drag-area">
                            <div class="grid grid-cols-7 h-full relative">

                                @foreach ($this->days as $i => $day)
                                    <div class="twa-calendar-column">
                                        <div class="twa-calendar-column-front" data-id="{{ $i }}"
                                            x-on:dragover="dragOver" x-on:drop="drop">
                                        </div>

                                        <div class="twa-calendar-column-back"
                                            id="twa-calendar-column-back-{{ $i }}">
                                            @foreach ($times as $time)
                                                <div class="slot"></div>
                                            @endforeach
                                        </div>

                                     

                                        @foreach ($events->where('dayIndex', $i) as $event)
                                       
                                            {{-- @dd($canDrag); --}}
                                            <div class="event-box twa-event-backdiv @if ($event['active']) event-box-active @endif"
                                                style="
                                            height: {{ $event['height'] }}px;
                                            top: {{ $event['top'] }}px
                                        "
                                                draggable="{{ ($event['reserved'] == 0 && $canDrag) ? 'true' : 'false'; }}"
                                                {{-- draggable="@if ($event['reserved'] > 0){{'false'}}@else{{'true'}}@endif" --}}
                                                x-on:dragstart="dragStart('{{ json_encode($event) }}')"
                                                x-on:dragend="dragEnd" data-id="{{ $event['id'] }}"
                                                data-group="{{ $event['group'] }}">

                                                <div class="event-box-inner"
                                                    style="
                                            background-color: {{ $event['details']['color'] }}10;
                                            border: 1px solid {{ $event['details']['color'] }}15;
                                            color: {{ $event['details']['color'] }}
                                            "
                                                    x-on:mouseover="$el.style.backgroundColor = '{{ $event['details']['color'] }}17'"
                                                    x-on:mouseout="$el.style.backgroundColor = '{{ $event['details']['color'] }}10'">



                                                    <input id="event-{{ $event['details']['id'] }}"
                                                        value="{{ $event['details']['id'] }}" type="checkbox"
                                                        @if ($event['reserved'] <= 0) x-model="selected" @endif />
                                                    <label for="event-{{ $event['details']['id'] }}">

                                                        <div class="flex items-center mb-2">
                                                            <div class="flex-1 font-bold text-[12px]">

                                                                {{ $event['details']['label'] }}

                                                            </div>
                                                            <div
                                                                class=" @if ($event['reserved'] > 0) hidden @endif">
                                                                <span class="checkbox__inner__checked">
                                                                    <i class="fa-solid fa-circle-check"></i>
                                                                </span>
                                                                <span class="checkbox__inner__not_checked">
                                                                    {{-- <i class="fa-solid fa-circle-notch"></i> --}}
                                                                    <i class="fa-regular fa-circle"></i>
                                                                    {{-- <i class="fa-light fa-circle" x-transition></i> --}}
                                                                </span>
                                                            </div>
                                                        </div>
                                                        <div class="text-[10px] mb-1">
                                                            {{ $event['details']['time'] }} -
                                                            {{ $event['details']['duration'] }} min
                                                        </div>
                                                        <div class="text-[10px]">
                                                            Week: {{ $event['details']['week'] ?? '-' }}
                                                        </div>

                                                        <div class="text-[10px]">
                                                            Reserved: {{ $event['reserved'] ?? '-' }}
                                                        </div>



                                                    </label>
                                                </div>
                                            </div>
                                        @endforeach


                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @component('UIKitView::components.drawer', [
                'showHandler' => 'drawers.editDrawer',
                'closeHandler' => "closeDrawer(event , 'editDrawer')",
                'title' => 'Edit Movie Show',
            ])
                <livewire:entity-forms.movie-show-edit-form :uniqeid="$info['id']" :id="$selected" type="single"
                    :key="uniqid()" />
            @endcomponent

            @component('UIKitView::components.drawer', [
                'showHandler' => 'drawers.editAllDrawer',
                'closeHandler' => "closeDrawer(event , 'editAllDrawer')",
                'title' => 'Edit Movie Shows',
            ])
                <livewire:entity-forms.movie-show-edit-form :uniqeid="$info['id']" :id="$selected" type="multishow"
                    :key="uniqid()" />
            @endcomponent

            @component('UIKitView::components.drawer', [
                'showHandler' => 'drawers.createDrawer',
                'closeHandler' => "closeDrawer(event , 'createDrawer')",
                'title' => 'Create Movie Show',
            ])
                <livewire:entity-forms.movie-show-form :uniqeid="$info['id']" :theater_id="$theater_id" :date_from="$date_from"
                    :date_to="$date_to" :key="uniqid()" />
            @endcomponent






        </div>
    </div>
</div>
