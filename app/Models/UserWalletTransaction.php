<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class UserWalletTransaction extends Model
{
    use HasFactory;
    

    public function transactionable(): MorphTo
    {

        return $this->morphTo();
    }


    public function system()
    {
        return $this->belongsTo(System::class, 'system_id' , 'id');
    }

}
