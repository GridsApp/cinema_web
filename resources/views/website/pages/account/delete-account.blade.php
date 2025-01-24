@extends('website.layouts.main')

@section('content')
    <div class="account main-spacing main-container"  x-data="{ showModal: false }">
        <div class="mt-10">
            @php
                $cinemaPrefix = request()->route('cinema_prefix');
                $langPrefix = request()->route('language_prefix');
            @endphp

            <div class="account-page">
                <div class="sm:col-span-4 col-span-12 left">
                    <livewire:website.profile-info :cinema-prefix="$cinemaPrefix" :lang-prefix="$langPrefix" />
                </div>

                <div class="col-span-6">
                    <div>
                        @include('website.components.title', [
                            'title' => __('messages.delete_account'),
                        ])
                    </div>

                    <div class="mt-10">
            
                        <button class="form-button" @click="showModal = true">Delete account</button>
                    </div>
                </div>
            </div>
        </div>


        {{-- <div x-show="showModal" x-cloak
            class="fixed inset-0 z-50 bg-gray-800 bg-opacity-50 flex items-center justify-center">
            <div class="bg-white p-6 rounded shadow-lg max-w-sm w-full" @click.away="showModal = false">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">{{ __('messages.confirm_delete_account') }}</h2>
                <p class="text-gray-600 mb-6">{{ __('messages.are_you_sure') }}</p>
                <div class="flex justify-end space-x-4">
                 
                    <button class="bg-gray-300 text-gray-800 px-4 py-2 rounded" @click="showModal = false">
                        {{ __('messages.no') }}
                    </button>
                  
                    <form method="POST"
                        action="{{ route('deleteAccount', [
                            'cinema_prefix' => request()->route('cinema_prefix'),
                            'language_prefix' => request()->route('language_prefix'),
                        ]) }}">
                        @csrf
                        <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded">
                            {{ __('messages.yes') }}
                        </button>
                    </form>
                </div>
            </div>
        </div> --}}

        <div x-cloak x-show="showModal" @click.outside="showModal = false; console.log('Modal Closed', showModal)" 
        x-init="showModal = false" 
        x-transition:enter="transition ease-out duration-500 transform opacity-0 "
        x-transition:enter-start="opacity-0 "
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-300 transform opacity-0 "
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 "
        class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-[990]">
       <div class="bg-white rounded-lg p-[44px] max-w-[500px]" @click.stop>
        <h2 class="text-xl font-semibold text-gray-800 mb-4">{{ __('messages.confirm_delete_account') }}</h2>
                <p class="text-gray-600 mb-6 text-[12px]">{{ __('messages.are_you_sure') }}</p>
                <div class="flex justify-end space-x-4">
                 
                    <button class="!bg-gray-300 !text-gray-800 form-button" @click="showModal = false">
                        {{ __('messages.no') }}
                    </button>
                  
                    <form method="POST"
                        action="{{ route('deleteAccount', [
                            'cinema_prefix' => request()->route('cinema_prefix'),
                            'language_prefix' => request()->route('language_prefix'),
                        ]) }}">
                        @csrf
                        <button type="submit" class="form-button">
                            {{ __('messages.yes') }}
                        </button>
                    </form>
                </div>


       </div>
   </div>
    </div>
@endsection
