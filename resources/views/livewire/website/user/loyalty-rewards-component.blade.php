<div x-data="{
    activeTab: new URLSearchParams(window.location.search).get('tab') || 'loyalty',
    copied: false,
    setTab(tab) {
        this.activeTab = tab;
        history.pushState(null, '', `?tab=${tab}`);
    },
    copyToClipboard(text) {
        navigator.clipboard.writeText(text).then(() => {
            this.copied = true;
            setTimeout(() => this.copied = false, 700);
        });
    }
}" class="flex pb-6 tabs flex-col gap-10">
    <div class="flex pb-6 tabs flex-col gap-10">
        <div class="flex flex-row gap-5">
            <div class="tabs-text cursor-pointer"
                :class="{ 'text-bold': activeTab === 'loyalty', 'active': activeTab === 'loyalty' }"
                @click="setTab('loyalty')">
                {{ __('tables.loyalty_card') }}
            </div>
            <div class="tabs-text cursor-pointer"
                :class="{ 'text-bold': activeTab === 'rewards', 'active': activeTab === 'rewards' }"
                @click="setTab('rewards')">
                {{ __('tables.rewards') }}
            </div>
        </div>

    </div>


    <div class="flex gap-20 sm:flex-row flex-col loyalty-card" x-show="activeTab === 'loyalty'">
        <div class="relative w-fit">
            <div class="w-[300px]">
                <img src="/images/card.jpg" alt="">
            </div>
            <div class="card-position text-white">
                <div class="flex justify-between h-[80%] flex-col items-center">
                    <div>
                        <img src="/images/iraqi-logo-card.png" alt="" class="block w-[100px]">
                    </div>
                    <div>
                        @if (isset($card['user']['name']))
                            <div class="name">{{ $card['user']['name'] }}</div>
                        @endif
                        @if (isset($card['user']['email']))
                            <div class="email">{{ $card['user']['email'] }}</div>
                        @endif
                    </div>

                    <div>
                        @if (isset($card['loyalty_points_balance']['display']))
                            <div class="text-center uppercase tracking-[1px] text-[10px] font-bold ">
                                {{ __('tables.points_balance') }}
                            </div>
                            <div class="font-normal text-[10px] text-center">
                                {{ $card['loyalty_points_balance']['display'] }}
                            </div>
                        @endif
                    </div>

                    <div>
                        <img src="/images/barcode.png" alt="">
                    </div>
                </div>
            </div>
        </div>
        <div class="flex items-center w-full">
            <div class="w-full max-w-[330px]">
                <div
                    class="bg-[#F0F0F0] justify-between rounded-xl inline-flex w-full px-5 border border-black-200 py-3 gap-5">
                    <div class="uppercase text-[12px] flex items-center font-bold opacity-80 tracking-[1.5px]">
                        {{ __('tables.loyalty_points') }}
                    </div>

                    <div class="text-[12px] font-bold">
                        {{ $card['loyalty_points_balance']['display'] ?? '0' }}
                    </div>
                </div>
                @php
                    $points = $card['loyalty_points_balance']['value'] ?? '0';
                    $iqdPerPoint = 10;
                    $iqd = $points * $iqdPerPoint;
                @endphp

                <div class="text-[12px] text-center pt-3 capitalize">
                    {{ __('tables.your_points_equals', ['points' => $points, 'amount' => $iqd]) }}
                </div>
            </div>
        </div>
    </div>


    <div class="rewards grid sm:grid-cols-2  grid-cols-1 gap-5" x-show="activeTab === 'rewards'">
        @foreach ($rewardList as $list)
            <div class="flex sm:flex-row flex-col reward-card">
                <div class="sm:w-[150px] w-full">
                    <div class="asp asp-3-4">
                        <img src="{{ $list['image'] }}" alt="" class="rounded-xl">
                    </div>
                </div>
                <div class="border-card w-full flex flex-col justify-between">
                    <div>
                        <div class="card-text">
                            {{ $list['title'] }}
                        </div>
                        <p class="card-description"> {{ $list['description'] }}</p>
                    </div>
                    <div>
                        @if ($list['remaining_points'] == 0)
                            <p class="font-normal text-[11px] opacity-70 pb-2 ">
                                {{ __('tables.redeem_reward') }}
                            </p>
                        @else
                            <p class="font-normal text-[11px] opacity-70 pb-2 ">
                                {{ __('tables.remaining_points', ['points' => $list['remaining_points']]) }}
                            </p>
                        @endif

                        <!-- Percentage bar -->
                        <div class="bg-gray-200 h-1 w-full rounded-full" x-data="{ percentage: {{ $list['percentage'] }} }">
                            <div class="bg-gradient-to-br from-[#c51a24] to-[#c51a24] h-1 rounded-full transition-all duration-700"
                                :style="`width: ${percentage}%;`">
                            </div>
                        </div>
                    </div>
                    <div class="pt-5 sm:pt-0">

                        @if (isset($redeemedRewards[$list['id']]))
                            <button
                                class="text-[12px] bg-primary-color tracking-[1.5px] font-bold px-10 py-2 rounded-full uppercase text-white"
                                @click="copyToClipboard('{{ $redeemedRewards[$list['id']] }}')">
                                <span x-show="!copied">{{ $redeemedRewards[$list['id']] }}</span>
                                <span x-show="copied" class="text-[12px] text-white">Copied!</span>
                            </button>
                        @else
                            <button wire:click="redeemReward({{ $list['id'] }})"
                                @if (!$list['remaining_points'] == 0) disabled @endif
                                class="text-[12px] tracking-[1.5px] font-bold px-10 py-2 rounded-full uppercase text-white 
                         {{ $list['remaining_points'] == 0 ? 'bg-primary-color' : 'bg-[#707070]' }}">
                         {{ __('tables.redeem_button') }}
                            </button>
                        @endif

                    </div>
                </div>
            </div>
        @endforeach
    </div>

</div>
