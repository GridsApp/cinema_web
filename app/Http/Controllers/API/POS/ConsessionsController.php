<?php

namespace App\Http\Controllers\API\POS;

use App\Http\Controllers\Controller;
use App\Interfaces\CardRepositoryInterface;
use App\Interfaces\ItemRepositoryInterface;
use App\Interfaces\PosUserRepositoryInterface;
use App\Interfaces\UserRepositoryInterface;
use App\Models\User;
use App\Traits\APITrait;
use Illuminate\Support\Facades\Validator;

class ConsessionsController extends Controller
{
    use APITrait;

    private ItemRepositoryInterface $itemRepository;


    public function __construct(
        ItemRepositoryInterface $itemRepository


    ) {
        $this->itemRepository = $itemRepository;
    }


    public function getItems()
    {
        try {

            $items = $this->itemRepository->getItems();
        } catch (\Throwable $th) {
            return $this->response(notification()->error('Error', $th->getMessage()));
        }


        return $this->responseData($items);
    }
}
