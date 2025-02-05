<?php

namespace App\Rules;

use App\Models\User;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class UniqueEmail implements ValidationRule
{

    // protected $alias='unique-email';

    // public function __toString()
    // {
    //     return $this->alias;
    // }
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



        $user =  User::where('email' , $value)
        ->whereNull('deleted_at')
        ->whereNotNull('email_verified_at')
        ->when(!is_null($this->user_id) , function($q){
            $q->where('id' , '!=' , $this->user_id);
        })
        ->first();
     
        if($user){
            $fail('This email already exist.');
        }

    }
}
