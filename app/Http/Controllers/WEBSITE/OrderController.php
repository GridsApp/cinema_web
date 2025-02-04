<?php

namespace App\Http\Controllers\WEBSITE;

use App\Http\Controllers\Controller;
use App\Interfaces\CartRepositoryInterface;
use App\Interfaces\ItemRepositoryInterface;
use App\Models\Branch;
use App\Models\MovieShow;
use App\Models\PriceGroupZone;
use App\Models\Theater;
use Carbon\Carbon;
use Illuminate\Http\Request;

class OrderController extends Controller
{


    private CartRepositoryInterface $cartRepository;
    private ItemRepositoryInterface $itemRepository;

    public function __construct()
    {

        $this->cartRepository = app(CartRepositoryInterface::class);
        $this->itemRepository = app(ItemRepositoryInterface::class);
    }

    public function getTheaterSeats(Request $request)
    {
        $user = session('user');
    
        $cart = session('cart');
        if (!$cart) {
            $cart = $this->cartRepository->createCart($user->id, 'USER', 3);
            session()->put('cart', $cart);
        }
    
        // Ensure the cart is fresh and not expired
        $cartExpiresAt = Carbon::parse($cart->expires_at);
        if ($cartExpiresAt->isPast()) {
            // Create a new cart if expired
            $cart = $this->cartRepository->createCart($user->id, 'USER', 3);
            session()->put('cart', $cart);
        }
        // dd($request->input('movie_show_id'));
        $movie_show_id = $request->input('movie_show_id');
        $theater_id = $request->input('theater_id');
    
        try {
            $movie_show = MovieShow::where('id', $movie_show_id)->orderBy('id', 'DESC')->firstOrFail();
        } catch (\Throwable $e) {
            // Handle exception
        }
    
        $result = [
            'movie_show' => $movie_show,
            'cart' => $cart
        ];
    
        return view('website.pages.checkout.seat-selection', [
            'result' => $result,
        ]);
    }


    public function getItems(){

        $cinemaPrefix = request()->segment(1);



        $branch_id = Branch::whereNull('deleted_at')->where('web_prefix', $cinemaPrefix)->pluck('id');

        try {

            $items = $this->itemRepository->getItems($branch_id);
        } catch (\Throwable $th) {
            // return $this->response(notification()->error('Error', $th->getMessage()));
        }


        // dd($items);

        return view('website.pages.checkout.item-selection', [
            'items' => $items,
        ]);
    }
    
}