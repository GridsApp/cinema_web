<?php

namespace App\Http\Controllers\API\POS;

use App\Http\Controllers\Controller;
use App\Interfaces\CardRepositoryInterface;
use App\Interfaces\CartRepositoryInterface;
use App\Interfaces\ItemRepositoryInterface;
use App\Interfaces\PosUserRepositoryInterface;
use App\Interfaces\UserRepositoryInterface;
use App\Models\User;
use twa\cmsv2\Traits\APITrait;
use Illuminate\Support\Facades\Validator;

class ConsessionsController extends Controller
{
    use APITrait;

    private ItemRepositoryInterface $itemRepository;



    public function __construct(
        ItemRepositoryInterface $itemRepository,
      


    ) {
        $this->itemRepository = $itemRepository;
       
    }


    public function getItems($branch_id = null)
    {

        $cart_id = request()->input('cart_id');


        // dd($cart_id);
        try {

            $items = $this->itemRepository->getItems($branch_id , $cart_id);
        } catch (\Throwable $th) {
            return $this->response(notification()->error('Error', $th->getMessage()));
        }

        return $this->responseData($items);
        // return $this->responseData($items);
        
    }
}
