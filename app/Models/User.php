<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Cars;

class User extends Authenticatable
{
    use HasFactory, Notifiable , HasApiTokens;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'password', 
        'profile_picture',
        'player_id'
    ];


    public function format(){
        
        $array = [];
        foreach($this->original as $key => $value){
            $array[$key] = $value;
        }

        if(
            empty($this->email) || 
            is_null($this->email) || 
            empty($this->name) || 
            is_null($this->name)
            ){
                $array['profile_completed']  = false;
            }else{
                $array['profile_completed']  = true;
            }
        
        return $array;
    }


    public function gender(){
        return $this->belongsTo(Gender::class , 'gender_id' , 'id');
    }
    public function cards()
{
    return $this->hasMany(UserCard::class, 'user_id'); 
}

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
  
}
