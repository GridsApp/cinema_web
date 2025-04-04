<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BranchItem extends Model
{
    public function item()
    {
        return $this->belongsTo(Item::class, 'item_id')->whereNull('deleted_at');
    }
}
