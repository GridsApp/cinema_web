<div>

    <div class="manage-wallet flex flex-col gap-5">


        {{-- @component('CMSView::components.panels.default', ['classes' => '', 'title' => 'Manage Coupons']) --}}
            <form wire:key="{{ uniqid() }}" method="POST" wire:submit.prevent="editCoupon">
                @csrf

                <div class="mb-5">
                  
            
                    {!! field('label') !!}
                    {!! field('code') !!}
                    {!! field('discount_flat') !!}
                    {!! field('expires_at') !!}
                </div>

                <div class="flex gap-4 items-center justify-start">
                    <button type="submit" class="btn btn-primary"> submit </button>
                </div>

            </form>
        {{-- @endcomponent --}}



       

    </div>

</div>
