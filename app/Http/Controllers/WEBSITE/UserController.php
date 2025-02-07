<?php

namespace App\Http\Controllers\WEBSITE;

use App\Http\Controllers\Controller;
use App\Interfaces\CardRepositoryInterface;
use App\Interfaces\ItemRepositoryInterface;
use App\Interfaces\MovieRepositoryInterface;
use App\Interfaces\OrderRepositoryInterface;
use App\Interfaces\RewardRepositoryInterface;
use App\Interfaces\TokenRepositoryInterface;
use App\Interfaces\UserRepositoryInterface;
use App\Interfaces\ZoneRepositoryInterface;
use App\Models\MovieFavorite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use twa\cmsv2\Traits\ToastTrait;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    private MovieRepositoryInterface $movieRepository;
    private CardRepositoryInterface $cardRepository;
    private RewardRepositoryInterface $rewardRepository;
    private OrderRepositoryInterface $orderRepository;
    private ZoneRepositoryInterface $zoneRepository;
    private ItemRepositoryInterface $itemRepository;
    private UserRepositoryInterface $userRepository;



    public function __construct()
    {
        $this->movieRepository = app(MovieRepositoryInterface::class);
        $this->cardRepository = app(CardRepositoryInterface::class);
        $this->rewardRepository = app(RewardRepositoryInterface::class);
        $this->orderRepository = app(OrderRepositoryInterface::class);
        $this->zoneRepository = app(ZoneRepositoryInterface::class);
        $this->itemRepository = app(ItemRepositoryInterface::class);
        $this->userRepository = app(UserRepositoryInterface::class);
    }


    public function update(Request $request)
    {
        $cinemaPrefix = $request->route('cinema_prefix');
        $languagePrefix = $request->route('language_prefix');

        // Pass variables to the view
        return view('website.pages.account.profile', compact(

            'cinemaPrefix',
            'languagePrefix'
        ));
    }

    public function deleteAccount(Request $request)
    {

        $user = session('user');


        $user->deleted_at = now();
        $user->save();


        $request->session()->flush();
        $request->session()->invalidate();
        $request->session()->regenerateToken();


        $cinemaPrefix = $request->route('cinema_prefix');
        $languagePrefix = $request->route('language_prefix');


        return redirect()->route('home', [
            'cinema_prefix' => $cinemaPrefix,
            'language_prefix' => $languagePrefix,
        ]);
    }

    public function renderDelete(Request $request)
    {

        // $user = session('user');

        // $user->deleted_at = now();
        // $user->save();


        $cinemaPrefix = $request->route('cinema_prefix');
        $languagePrefix = $request->route('language_prefix');



        return view('website.pages.account.delete-account', compact(

            'cinemaPrefix',
            'languagePrefix'
        ));
    }



    public function favorites(Request $request)
    {
        $cinemaPrefix = $request->route('cinema_prefix');
        $languagePrefix = $request->route('language_prefix');
        $user = session('user');

        $ids =  MovieFavorite::where('user_id', $user->id)->pluck('movie_id')->unique()->values()->toArray();

        $movies = $this->movieRepository->getMovies($ids);

        return view('website.pages.account.favorites', compact(
            'movies',
            'cinemaPrefix',
            'languagePrefix'
        ));
    }


    public function getWalletTransactions(Request $request)
    {
        $cinemaPrefix = $request->route('cinema_prefix');
        $languagePrefix = $request->route('language_prefix');
        $user = session('user');


        $transactions = $this->cardRepository->getWalletTransactions($user);

        return view('website.pages.account.wallet-transactions', compact(
            'transactions',
            'cinemaPrefix',
            'languagePrefix'
        ));
    }

    public function getLoyaltyCard(Request $request)
    {

        $cinemaPrefix = $request->route('cinema_prefix');
        $languagePrefix = $request->route('language_prefix');

        $user = session('user');
        $card = $this->cardRepository->getActiveCard($user);
        $reward_list = $this->rewardRepository->getRewards($user);


        return view('website.pages.account.loyality-card', compact(
            'card',
            'reward_list',
            'cinemaPrefix',
            'languagePrefix'
        ));
    }

    public function purchaseHistory(Request $request)
    {
        $user = session('user');
        $cinemaPrefix = $request->route('cinema_prefix');
        $languagePrefix = $request->route('language_prefix');

        $allOrders = [];


        $orders = $this->orderRepository->getUserOrders($user->id);

        foreach ($orders as $order) {
            try {
                $order_seats = $this->orderRepository->getOrderSeats($order->id, true);
            } catch (\Throwable $e) {
                // Handle error if needed
            }


            $zone_ids = $order_seats->pluck('zone_id');
            $zones = $this->zoneRepository->getZones($zone_ids)->keyBy('id');
            $total_discounts = 0;
            $subtotal = 0;

            $seat_lines = $order_seats->map(function ($order_seat) use ($zones, &$total_discounts) {
                $zone = $zones[$order_seat['zone_id']];
                if (!$zone) {
                    return null;
                }

                $unit_price = $order_seat['price'];
                $total_discounts += $order_seat['total_discount'];


                return [
                    'id' => $order_seat['order_id'],
                    'movie_name' => $order_seat->movie->name,
                    'theater' => $order_seat->theater->label,
                    'date' => $order_seat->date,
                    'seats' => $order_seat->seats,
                    'type' => "Seat",
                    'label' => $zone->label,
                    'unit_price' => currency_format($order_seat['price']),
                    'quantity' => $order_seat['quantity'],
                    'price' => currency_format($unit_price * $order_seat['quantity']),
                    'discount' => currency_format($order_seat['total_discount']),
                ];
            })->filter();

            try {
                $order_items = $this->orderRepository->getOrderItems($order->id, true);
            } catch (\Throwable $e) {
            }


            $item_ids = $order_items->pluck('item_id');
            $items = $this->itemRepository->getItemsById($item_ids)->keyBy('id');

            $item_lines = $order_items->map(function ($order_item) use ($items) {
                $item = $items[$order_item['item_id']];
                $unit_price = $order_item->price;

                return [
                    'id' => $order_item['order_id'],
                    'type' => "Item",
                    'label' => $order_item->label,
                    'unit_price' => currency_format($unit_price),
                    'quantity' => $order_item['quantity'],
                    'price' => currency_format($unit_price * $order_item['quantity']),
                ];
            })->filter();

            try {
                $order_topups = $this->orderRepository->getOrderTopups($order->id, true);

                // dd($order_topups);
            } catch (\Throwable $e) {
            }


            $topup_lines = $order_topups->map(function ($order_topup) {

                $unit_price = $order_topup->price;

                return [
                    'id' => $order_topup['order_id'],
                    'type' => "Topup",
                    'label' => "Top-up amount",
                    'unit_price' => currency_format($unit_price),
                    'quantity' => $order_topup['quantity'],
                    'price' => currency_format($unit_price * $order_topup['quantity']),
                ];
            });

            $lines = collect($seat_lines)
                ->merge(collect($item_lines))
                ->merge(collect($topup_lines));



            // $lines = $seat_lines->merge($item_lines)->merge($topup_lines);



            $subtotal = $lines->sum(function ($line) {
                return $line['price']['value'];
            });

            $total_discounts = $lines->sum(function ($line) {
                return isset($line['discount']) ? $line['discount']['value'] : 0;
            });


            $allOrders[] = [
                'order_id' => $order->id,
                'date' => $order->created_at,
                'quantity' => $order->seats->count(),
                'subtotal' => currency_format($subtotal),
                'total_discount' => currency_format($total_discounts),
                'total' => currency_format($subtotal - $total_discounts),
                'payment_method' => $order->paymentMethod->label,
                'lines' => $lines,
            ];
        }


        // dd($allOrders);

        return view('website.pages.account.purchase-history', compact(
            'allOrders',
            'cinemaPrefix',
            'languagePrefix'
        ));
    }

    public function logout(Request $request)
    {
        $cinemaPrefix = $request->route('cinema_prefix');
        $languagePrefix = $request->route('language_prefix');

        session()->flush();

        return redirect()->route('home', [
            'cinema_prefix' => $cinemaPrefix,
            'language_prefix' => $languagePrefix,
        ]);
    }


    public function render()
    {


        $user = session('user');


        // dd($user);
        return view('website.pages.account.profile-pictures', compact(
            'user',

        ));
        // return view('website.pages.account.profile-pictures'['usr']);
    }

    public function addImage(Request $request)
    {

        $request->validate([
            'profile_picture' => 'required|image|mimes:jpg,jpeg,png,webp|mimetypes:image/jpeg,image/png,image/webp',

        ]);


        $user = session('user');


        $folder = uniqid();


        $image = $request->file('profile_picture');


        $extension = $image->getClientOriginalExtension();

        // $originalPath = $image->storeAs("public/data/{$folder}", 'original.' . $extension);
        // $thumbPath = "public/data/{$folder}/thumb.webp";
        $image->storeAs("public/data/{$folder}", 'thumb.webp');
        $image->storeAs("public/data/{$folder}", 'image.webp');


        $originalFilename = $folder . '.' . $extension;
     
        $user->profile_picture = $originalFilename;
        $user->save();

        return redirect()->back()->with('success', 'Image uploaded successfully!');
    }
}
