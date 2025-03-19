<?php

namespace App\Livewire\Website;

use App\Http\Controllers\WEBSITE\CartController;
use Livewire\Component;
use App\Models\MovieShow;
use App\Models\PriceGroupZone;
use App\Models\Theater;
use App\Interfaces\CartRepositoryInterface;
use App\Interfaces\MovieShowRepositoryInterface;
use App\Interfaces\TheaterRepositoryInterface;
use App\Models\CartSeat;
use App\Models\ReservedSeat;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Carbon\Carbon;
use twa\uikit\Traits\ToastTrait;

class SeatSelector extends Component
{
    use ToastTrait;
    public $movie_show_id;
    public $theater_id;
    public $result;


    private CartRepositoryInterface $cartRepository;
    private TheaterRepositoryInterface $theaterRepository;
    private MovieShowRepositoryInterface $movieShowRepository;

    public function __construct()
    {
        $this->cartRepository = app(CartRepositoryInterface::class);
        $this->theaterRepository = app(TheaterRepositoryInterface::class);
        $this->movieShowRepository = app(MovieShowRepositoryInterface::class);
    }

    public function mount($movie_show_id, $theater_id)
    {


        $this->movie_show_id = $movie_show_id;
        $this->theater_id = $theater_id;


        $cart = session()->get('cart');

        $this->loadSeats();
    }

    public function loadSeats()
    {
        $theater = Theater::find($this->theater_id);
        $theater_map = $theater->theater_map;

        try {
            $movie_show = MovieShow::where('id', $this->movie_show_id)->orderBy('id', 'DESC')->firstOrFail();
        } catch (\Throwable $e) {
            // Handle movie show not found exception
        }

        $theater = Theater::whereNull('deleted_at')->where('id', $movie_show->theater_id)->first();
        $theater_map = $theater->theater_map;

        $columns = collect($theater_map[0])->map(function ($item) {
            return (string) ($item['column'] ?? "");
        })->toArray();

        $reserved_seats = ReservedSeat::whereNull('deleted_at')
            ->where('movie_show_id', $movie_show->id)
            ->pluck('seat');

        $booked = collect([]);
        $reserved_seats = $booked->merge($reserved_seats)->unique()->values()->toArray();

        $rows = collect($theater_map)->map(function ($item) {
            $item = collect($item)->where('isSeat', true)->first();
            return (string) ($item['row'] ?? "");
        })->toArray();

        $zone_ids = collect($theater_map)->flatten(1)->pluck('zone')->unique()->values();
        $zones = PriceGroupZone::select('id', 'label', 'color')
            ->whereIn('id', $zone_ids)
            ->whereNull('deleted_at')
            ->get();


        $cart = session()->get('cart');
        $selected_seats = CartSeat::where('cart_id', $cart->id)
            ->where('movie_show_id', $movie_show->id)
            ->whereNull('deleted_at')
            ->pluck('seat')
            ->toArray();


        // dump($selected_seats);
        $map = collect($theater_map)->flatten(1)->map(function ($item) use ($reserved_seats, $selected_seats) {
            if (!$item['isSeat']) {
                return null;
            }

            $isReserved = in_array($item['code'], $reserved_seats);
            $isSelected = in_array($item['code'], $selected_seats);
            return [
                "color" => $item['color'],
                "available" => !$isReserved,
                "reserved" => $isReserved,
                "selected" => $isSelected,
                "code" => $item['code']
            ];
        })->filter()->values()->keyBy('code');

        $this->result = [
            'movie_show' => $movie_show,
            "zones" => $zones,
            "columns" => $columns,
            "rows" => $rows,
            'map' => $map
        ];
    }

    public function addSeatToCart($seatCode)
    {
        $cart = session()->get('cart');
        $cart_id = $cart->id;

        try {
            $movie_show = $this->movieShowRepository->getMovieShowById($this->movie_show_id);
        } catch (\Exception $th) {
        }

        try {
            $theater_map = $this->theaterRepository->getTheaterMap($movie_show->theater_id);
        } catch (\Exception $th) {
        }

        if (!is_array($seatCode) || empty($seatCode)) {
            // Handle invalid seat data
        }

        try {
            $seat = $this->theaterRepository->getSeatFromTheaterMap($theater_map, $seatCode);
        } catch (\Exception $th) {
            // Handle exception
        }

        $selected_seats = CartSeat::where('cart_id', $cart->id)
            ->where('movie_show_id', $movie_show->id)
            ->whereNull('deleted_at')
            ->pluck('seat')
            ->toArray();


        $isSelected = in_array($seat['code'], $selected_seats);


        if ($isSelected) {


            $this->cartRepository->removeSeatFromCart($cart_id, $seat['code'], $movie_show->id);
            $this->sendSuccess("Removed Successfully", "Seat removed from cart Successfully");

            $this->loadSeats();
        } else {
            $this->cartRepository->addSeatToCart($cart_id, $seat['code'], $movie_show, $seat['zone']);
            $this->sendSuccess("Added Successfully", "Seat added to cart Successfully");
            $this->loadSeats();
        }
    }

    public function render()
    {
        return view('livewire.website.seat-selector');
    }
}
