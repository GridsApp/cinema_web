<div>

  
    <form class="card" wire:submit.prevent="applyFilters" x-data="GeneralFunctions.filterForm()"
        x-on:query-completed.window="disabled = false" x-on:start-report.window="disabled = true">
        <div class="card-body grid grid-cols-12 gap-3 card-body-rounded-bottom">
          
            {!! field('filter_date', 'col-span-12') !!}
            {!! field('filter_distributor', 'col-span-6') !!}
            {!! field('filter_branch', 'col-span-6') !!}
    
            <div class="col-span-12">
                <div id="placeholder_ajax_date" class="mb-2 text-[12px]" x-html="weekRange"></div>
            </div>
      


        </div>
        <div class="flex w-full gap-4 " style=" padding: 1rem 1.875rem;">
            <a class="btn bg-gray-300 text-white w-full">Clear
                filters</a>
            <button :disabled="disabled" class="btn btn-primary w-full">Refine</button>
        </div>
    </form>

</div>
