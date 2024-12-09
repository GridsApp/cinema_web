<?php

namespace App\Repositories;

use App\Interfaces\BranchRepositoryInterface;
use App\Models\Branch;

class BranchRepository implements BranchRepositoryInterface
{

    public function getBranches($display = null){
        return  Branch::whereNull('deleted_at')
            ->when(!is_null($display) , function($q) use($display){
                $q->where('display' , $display);
            })
            ->get()->map(function($branch){
              
                return [
                    'id' => $branch->id,
                    'label' => $branch->label,
                    'image' => get_image($branch->image),
                    'description' => $branch->description,
                    'latitude' => $branch->latitude,
                    'longitude' => $branch->longitude,
                    'address' => $branch->address,
                    'number' => $branch->number
                ];
            });
    }

}