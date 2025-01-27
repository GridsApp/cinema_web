<?php

namespace App\Livewire\Website\user;

use App\Interfaces\CardRepositoryInterface;
use App\Interfaces\UserRepositoryInterface;
use App\Models\User;
use App\Repositories\CardRepository;
use Livewire\Component;
use twa\cmsv2\Traits\ToastTrait;
use Illuminate\Support\Facades\Hash;

class UserProfileUpdate extends Component
{
    use ToastTrait;
    public $cinemaPrefix;
    public $langPrefix;
    public $user;

    public $name;
    public $email;

    public $phone_country_code;
    public $phone_number;
    public $phone;

    public $password;
    public $current_password;
    public $confirm_password;

    public $walletBalance;
    public $loyaltyBalance;


    public function mount($cinemaPrefix, $langPrefix)
    {
        $this->cinemaPrefix = $cinemaPrefix;
        $this->langPrefix = $langPrefix;

        $this->user = User::find(session('user')->id);


        $this->name = $this->user->name ?? '';
        $this->email = $this->user->email ?? '';
        $this->phone = $this->user->phone ?? '';



        $this->dispatch('initPhoneNumber');
    }


    public function hydrate()
    {
        $this->dispatch('initPhoneNumber');
    }


    public function updateProfile()
    {
      
        $this->validate([
            'name' => 'string|max:255',
            'email' => 'email|unique:users,email,' . $this->user->id,
            'phone' => 'nullable|unique:users,phone,' . $this->user->id,
        ]);
    
    
        $this->user->name = $this->name;
        $this->user->email = $this->email;
    
      
        if ($this->phone_number) {
            $this->user->phone = $this->phone_number;
        }
    
    
        $this->user->save();
    
     
        session()->put('user', $this->user);
    
   
        $this->sendSuccess("Updated Successfully", "Your profile has been updated.");
    }
    
    

    public function changePassword()
    {

        $this->validate([
            'current_password' => 'required',
            'password' => 'required|min:8',
            'confirm_password' => 'required|same:password',
        ]);


        if (Hash::check($this->password, $this->user->password)) {
            $this->sendError('Error', 'You have entered the same password as your current one');
            return;
        }


        if (!Hash::check($this->current_password, $this->user->password)) {
            $this->sendError('Error', 'Current password is incorrect');
            return;
        }


        $this->user->password = Hash::make($this->password);
        $this->user->save();


        $this->sendSuccess('Password successfully changed', 'Your password has been updated.');
    }

    public function render()
    {
        return view('livewire.website.user.user-profile-update');
    }
}
