<div>


    <style>
        .terminal-font {
            font-family: "Lucida Console", "Courier New", monospace;
            font-size: 12px;
        }
    </style>

    @if (!$already_not_done->isNotEmpty())
        <form wire:submit.prevent="generate">


            <div class="grid grid-cols-12 gap-5">


                {!! field('movie', 'col-span-6', null, false, false) !!}
                {!! field('theaters', 'col-span-6', null, false, false) !!}
                {!! field('date_from', 'col-span-3') !!}
                {!! field('date_to', 'col-span-3') !!}
                {!! field('show_times', 'col-span-3') !!}
                {!! field('screen_type', 'col-span-3', null, false, false) !!}
               
              
              


                <div class="col-span-12">
                    <div class="pt-7 w-full flex"><button class="btn btn-primary  min-w-[300px] "
                        type="submit">Generate</button></div>
                </div>

                
            </div>








           
        </form>



        @if (!empty($json) && count($json) > 0)
            <form wire:submit.prevent="submit" class="mt-10">

                @if (count($already_not_done) > 0)
                    <div class="p-4 mb-4 text-[12px] text-red-700 bg-red-100 border border-red-400 rounded">
                        ⚠️ You already have a pending movie show log. Please wait until it is processed before
                        submitting
                        again.
                    </div>
                @endif

                <div>


                    <table
                        class="twa-table mt-5 twa-table-card @if (count($already_not_done) > 0) twa-table-card-disabled @endif ">
                        <thead>
                            <tr>
                                <th>Movie</th>
                                <th>Date</th>
                                <th>Theater</th>
                                <th>Time</th>
                                <th>Screen Type</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($json as $index => $item)
                                <tr>
                                    <td>{{ $item['movie']['label'] }}</td>
                                    <td>{{ $item['date']['label'] }}</td>
                                    <td>{{ $item['theater']['label'] }}</td>
                                    <td>{{ $item['time']['label'] }}</td>
                                    <td>

                                        {{-- <select
                                            style="min-width:80px; border:1px solid gray; padding:3px 9px !important;font-size:12px"
                                            name="" id=""
                                            wire:model="json.{{ $index }}.screen_type_id">
                                            <option value="1"> 2D </option>
                                            <option value="2"> 3D </option>
                                        </select> --}}

                                        <select  
                                        style="min-width:80px; border:1px solid rgba(0, 0, 0, 0.1); border-radius:7px;padding:3px 9px !important;font-size:12px"
                                        wire:model="json.{{ $index }}.screen_type_id">
                                        <option value="">Select</option>
                                        @foreach ($screenTypes as $type)
                         
                                            <option value="{{ $type->id }}">{{ $type->label }}</option>
                                        @endforeach
                                    </select>


                                        
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>


                </div>
                <div class="flex justify-end w-full pt-5">
                    <button class="btn btn-primary" @disabled(count($already_not_done) > 0)>Submit</button>
                </div>

            </form>
        @endif

    @endif

    @if ($already_not_done->isNotEmpty())

        <div class="flex items-center justify-between">
            <h1 class="mb-3 font-bold">Movie show creation log</h1>
            @if (count($this->logs) != count($this->already_not_done))
                <i class="fa-solid fa-spinner animate-spin"></i>
            @endif
        </div>


        <div @if (count($this->logs) != count($this->already_not_done)) wire:poll @endif class="bg-black p-4 text-white rounded-md">

            <div class="terminal-font text-green-400">


                Movie creation has been started



            </div>
            <br>
            @foreach ($logs as $log)
                <div class="terminal-font">

                    @if ($log->status == 'success')
                        <span class="text-green-400"> CREATED </span>
                    @elseif($log->status == 'error')
                        <span class="text-red-500"> ERROR </span>
                    @endif

                    {{ $log->movie->condensed_name ?? '-' }}
                    {{ $log->theater->branch->label_en ?? '-' }} / {{ $log->theater->label ?? '-' }}
                    {{ $log->time->label ?? '-' }}
                    {{ $log->date }}



                </div>
                @if ($log->status == 'error')
                    <div class="terminal-font "> <span class="text-red-500"> MESSAGE </span> {{ $log->message }}</div>
                @endif
            @endforeach

        </div>

        @if (count($this->logs) == count($this->already_not_done))
            <div class="my-5 flex items-center justify-end">
                <button wire:click="done"  class="btn btn-primary"> DONE </button>
            </div>
        @endif

    @endif
</div>
