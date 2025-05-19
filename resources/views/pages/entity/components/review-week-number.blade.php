<div>
    <h1 class="mb-4 text-[16px] font-bold">Review Week Numbers</h1>






    <div class="grid grid-cols-12 gap-4 mb-5">

        <div class="col-span-12">
            <div>
                <div class="twa-table-card ">

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

                                    @if (cms_check_permission('edit-movie-shows'))
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


                                    @if (cms_check_permission('edit-movie-shows'))
                                        <template x-if="selected.length > 1">
                                            <button @click="openDrawer($event , 'editAllDrawer')" type="button"
                                                class="text-[12px] focus:ring-offset-white focus:shadow-outline group inline-flex items-center justify-center gap-x-2 border outline-none transition-all duration-200 ease-in-out hover:shadow-sm focus:border-transparent focus:ring-2 disabled:cursor-not-allowed disabled:opacity-80  px-4 py-2 text-primary-50 ring-primary-500 bg-primary-500 focus:bg-primary-600 hover:bg-primary-600 border-transparent focus:ring-offset-2 dark:focus:ring-offset-dark-900 dark:focus:ring-primary-600 dark:bg-primary-700 dark:hover:bg-primary-600 dark:hover:ring-primary-600 rounded-md">
                                                Edit all selected
                                            </button>
                                        </template>
                                    @endif


                                    @if (cms_check_permission('delete-movie-shows'))
                                        <template x-if="selected.length > 0">

                                            <button x-on:click="deleteMovieShows()" type="button"
                                                class="text-[12px] focus:ring-offset-white focus:shadow-outline group inline-flex items-center justify-center gap-x-2 border outline-none transition-all duration-200 ease-in-out hover:shadow-sm focus:border-transparent focus:ring-2 disabled:cursor-not-allowed disabled:opacity-80  px-4 py-2 text-red-50 ring-red-500 bg-red-500 focus:bg-red-600 hover:bg-red-600 border-transparent focus:ring-offset-2 dark:focus:ring-offset-dark-900 dark:focus:ring-red-600 dark:bg-red-700 dark:hover:bg-red-600 dark:hover:ring-red-600 rounded-md">
                                                Delete
                                            </button>

                                        </template>
                                    @endif
                                </div>
                                @if (cms_check_permission('create-movie-shows'))
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


                    @if (count($shows) == 0)
                        <div class="p-5 font-bold text-[13px]"> No shows available for this date </div>
                    @else
                        @foreach ($shows as $movie => $branches_weeks)
                            <div class="p-5 flex flex-row">
                                <div class="font-bold text-[12px] block w-[300px] py-3">
                                    {{ $movie }}
                                </div>

                                <div class="flex flex-col gap-3 flex-1 ">

                                    <table class="twa-table twa-table-card w-full">

                                        <thead>
                                            <tr>
                                                <th>Theater</th>
                                                <th style="width : 200px">Week #</th>
                                                <th style="width : 300px">Action</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @foreach ($branches_weeks as $index => $branches_week)
                                  
                                                <tr x-data="{edit : false , value : '{{$branches_week->week}}' , handleSave(id){ this.$wire.handleWeekUpdate('{{$branches_week->id}}',this.value); } }">
                                                    <td class="@if($branches_week->week != $branches_week->max_week) !bg-red-50 @endif" > {{ $branches_week->id }} {{ $branches_week->branch }} / {{ $branches_week->theater }} - {{ now()->parse($branches_week->date)->format('d-m-Y') }} | {{ $branches_week->time }} 
                                                    </td>
                                                    <td class="@if($branches_week->week != $branches_week->max_week) !bg-red-50 @endif">
                                                    
                                                        <div x-show="edit">
                                                            <input tabindex="{{$index + 1}}" type="number" x-model="value" class="week-number-input" >
                                                        </div>
                                                       

                                                        <div x-show="!edit">
                                                            {{ $branches_week->week }}
                                                        </div>
                                                       
                                                    
                                                    </td>
                                                    <td class="@if($branches_week->week != $branches_week->max_week) !bg-red-50 @endif"> 
                                                    
                                                        <div x-cloak x-show="!edit">
                                                            <button tabindex="-1" type="button" x-on:click="edit = true" class="underline" > Edit Week</button> 
                                                        </div>
                                                       
                                                    
                                                        <div class="flex gap-3 items-center" x-show="edit">

                                                            <button  tabindex="-1"  type="button" x-on:click=" handleSave('{{$branches_week->id}}') ;edit = false;" class="underline text-red-600" > Save</button> 
                                                            <button  tabindex="-1"  type="button" x-on:click="edit = false" class="underline" > Cancel</button> 

                                                        </div>
                                                    
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>

                                    </table>

                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
                <div>

                </div>
            </div>


        </div>
    </div>


    <style>
        td{
            height: 49.5px;
        }
    </style>

</div>
