@foreach ($board_members as $board_member)
    <div class="bg-white board-member">
        @if(isset( $board_member['image']))
        <div class="w-[200px] mb-4">
            <div class="asp asp-1-1">
                <img src={{ get_image($board_member['image']) }} alt="" class="brightness-50">
            </div>
        </div>
        @endif
        <div>
            @if(isset( $board_member['name']))
            <div class="name">
              {{$board_member['name']}}
            </div>
            @endif
            @if(isset( $board_member['position']))
            <div class="position">
                {{$board_member['position']}}
            </div>
            @endif
            @if(isset( $board_member['description']))
            <div class="desc">
          {{$board_member['description']}}
            </div>
            @endif
        </div>
    </div>
@endforeach
