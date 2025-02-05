<?php

namespace App\Rules;

use App\Models\User;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class UniquePhone implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */

     public $user_id;

     public function __construct($user_id = null)
     {
        $this->user_id = $user_id;
     }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {

        $user =  User::where('phone' , $value)
        ->whereNull('deleted_at')
        ->whereNotNull('phone_verified_at')
        ->when(!is_null($this->user_id) , function($q){
            $q->where('id' , '!=' , $this->user_id);
        })
        ->first();
     
        if($user){
            $fail('This phone already exist.');
        }
        
    }
}
