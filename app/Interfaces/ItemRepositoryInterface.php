<?php

namespace App\Interfaces;

interface ItemRepositoryInterface 
{
    public function getItemById($item_id);
    public function getItemsById($item_ids);
    public function getItems($branch_id , $cart_id = null);
}