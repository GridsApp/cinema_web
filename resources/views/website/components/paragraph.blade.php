<div>


    {{-- @dd($paragraph['content']); --}}
    <div class="opacity-60 text-[12px] mt-5">

        {!! $paragraph['content'] !!}
    </div>

    {{-- @dd($company_purposes); --}}

    <div class="grid sm:grid-cols-2 grid-cols-1 mt-10 gap-14 company_purpose">

        @foreach ($company_purposes as $company_purpose)
            @isset($company_purpose['content'])
                <div class=" inline-flex gap-5">
                    <div>
                        <img src="/images/icon.svg" alt="">
                    </div>

                    <div>
                        {!! $company_purpose['content'] !!}

                    </div>
                </div>
            @endisset
        @endforeach


    </div>

</div>
