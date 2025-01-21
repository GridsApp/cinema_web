<div x-data="{
    showModal: false,
    cinemaPrefix: '{{ $branch['web_prefix'] ?? 'dbaye' }}',
    languagePrefix: '{{ request()->route('language_prefix') ?? 'en' }}'
}">
    {{-- @dd($branch['web_prefix']); --}}
    <div class="mini-card">
        @if (isset($branch['image']))
            <div class="asp asp-2-1">
                <img src="{{ $branch['image'] }}" alt="">
            </div>
        @endif
        <div class="mini-card-bottom">
            @if (isset($branch['label']))
                <div class="title">
                    {{ $branch['label'] }}
                </div>
            @endif
            <div class="location">
                <div class="flex flex-col gap-1">
                    @if (isset($branch['description']))
                        <div class="inline-flex items-center gap-2">
                            <div>
                                <i class="fa-solid fa-location-dot"></i>
                            </div>
                            <div class="text-[12px]">
                                {{ $branch['description'] }}
                            </div>
                        </div>
                    @endif

                    @if (isset($branch['latitude']) && isset($branch['longitude']))
                        <button @click="showModal = true; console.log('Modal Opened')"
                            class="primary-color text-[12px] underline {{ app()->getLocale() === 'ar' ? 'rtl:text-right' : 'ltr:text-left' }}">
                            {{ app()->getLocale() === 'ar' ? 'عرض الموقع' : 'View Location' }}
                        </button>
                    @endif

                </div>
            </div>
        </div>
    </div>

    <div x-cloak x-show="showModal" @click.outside="showModal = false; console.log('Modal Closed')" x-transition
        class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50">
        <div class="bg-white rounded-lg p-[44px] max-w-[500px]" @click.stop>
            <button @click="showModal = false; console.log('Modal Closed')"
                    class="pb-5 text-center flex justify-end w-full text-black rounded">
                <i class="fa-solid fa-x"></i>
            </button>
            
            <h2 class="text-[12px] mb-4 {{ app()->getLocale() === 'ar' ? 'text-right' : 'text-left' }}">
                @lang('messages.continue_to_see_movies')
            </h2>
            
            <div class="w-full flex justify-center">
                <div class="flex flex-col gap-4 w-[80%] justify-center">
                    <div>
                        <a :href="`/${cinemaPrefix}/${languagePrefix}/movies/listing`"
                           class="block w-full font-bold bg-primary-color text-white text-[14px] hover:bg-black tracking-[2.4px] text-center rounded-full uppercase px-10 py-2">
                            @lang('messages.check_movies')
                        </a>
                    </div>
                    <div>
                        <a :href="`https://www.google.com/maps?q={{ $branch['latitude'] }},{{ $branch['longitude'] }}`"
                           target="_blank"
                           class="primary-color flex justify-center flex-col items-center text-[14px] underline {{ app()->getLocale() === 'ar' ? 'text-right' : 'text-left' }}">
                            @lang('messages.view_location')
                        </a>
                    </div>
                </div>
            </div>
        </div>
        
    </div>
</div>
