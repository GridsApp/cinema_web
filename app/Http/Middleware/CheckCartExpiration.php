<?php

namespace App\Http\Middleware;

use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckCartExpiration
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {


        // Get the cart from the session
        $cart = session('cart');


// dd($cart);


        // Check if cart exists and its expiration time has passed
        if ($cart && Carbon::parse($cart->expires_at)->isPast()) {
            // Clear expired cart session data
            session()->forget('cart');
            
            // Redirect to home if the cart is expired
            return redirect()->route('home', [
                'cinema_prefix' => request()->route('cinema_prefix'),
                'language_prefix' => request()->route('language_prefix'),
            ]);
        }
        

        return $next($request);
    }
}
